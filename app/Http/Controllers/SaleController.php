<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\DailyClosures;
use PDF;
use Carbon\Carbon;
use DB;

class SaleController extends Controller
{


    public function index()
    {
        $latestDailyClosure = DailyClosures::latest()->first();

        $date = Carbon::now();
        $latestCreationDate = $latestDailyClosure->created_at;
        $sales = Sale::with('details.product')
                                            ->whereBetween('created_at', [$latestCreationDate, $date])
                                            ->paginate(3);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validar el método de pago
            if ($request->payment_method === 'card' && !is_string($request->card_reference)) {
                return response()->json([
                    'success' => false,
                    'message' => 'La referencia de la tarjeta debe ser una cadena de texto.'
                ]);
            }

            // Validar los datos de la solicitud
            $data = $request->validate([
                'total_amount' => 'required|numeric|min:1',
                'payment_method' => 'required|in:cash,card',
                'cash_amount' => 'required_if:payment_method,cash|numeric|min:0',
                'change_amount' => 'required_if:payment_method,cash|numeric|min:0',
                'card_reference' => 'nullable|required_if:payment_method,card|string|max:255',
                'products' => 'required|array|min:1',
                'products.*.id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
            ]);

            // Validar el total calculado
            $calculatedTotal = 0;
            
            // Crear la venta
            $sale = Sale::create([
                'date' => now(),
                'total_amount' => $data['total_amount'],
                'payment_method' => $data['payment_method'],
                'cash_amount' => $data['cash_amount'],
                'change_amount' => $data['change_amount'],
                'card_reference' => $data['card_reference'],
            ]);

            foreach ($data['products'] as $item) {
                $product = Product::findOrFail($item['id']);
                $quantity = $item['quantity'];

                // Obtener los lotes disponibles (FIFO: ordenados por fecha de ingreso)
                $availableLots = $product->stockHistory()
                    ->where('remaining_quantity', '>', 0)
                    ->orderBy('date_added')
                    ->get();

                $remainingToSell = $quantity;

                foreach ($availableLots as $lot) {
                    if ($remainingToSell <= 0) {
                        break;
                    }

                    // Calcular cantidad a tomar de este lote
                    $soldFromLot = min($remainingToSell, $lot->remaining_quantity);

                    // Actualizar cantidad restante en el lote
                    $lot->remaining_quantity -= $soldFromLot;
                    $lot->save();

                    // Calcular el subtotal para este lote
                    $lotTotalPrice = $lot->sale_price * $soldFromLot;
                    $calculatedTotal += $lotTotalPrice;

                    // Registrar el detalle de la venta
                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $soldFromLot,
                        'price' => $lot->sale_price,
                        'total_price' => $lotTotalPrice,
                    ]);

                    // Reducir cantidad pendiente de vender
                    $remainingToSell -= $soldFromLot;
                }

                if ($remainingToSell > 0) {
                    throw new \Exception("Stock insuficiente para el producto {$product->name}.");
                }

                // Actualizar el stock total del producto
                $product->decrement('stock', $quantity);
            }

            // Verificar si el total calculado coincide con el total proporcionado
            if (number_format($calculatedTotal, 2) !== number_format($data['total_amount'], 2)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El total calculado no coincide con el total_amount proporcionado.'
                ]);
            }


            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    

    public function show($id)
    {
        $sale = Sale::with('details.product')->findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    public function generateReceipt($id)
    {
        $sale = Sale::with('details.product')->findOrFail($id);
        $pdf = PDF::loadView('sales.receipt', compact('sale'));
        return $pdf->download('recibo_venta_' . $sale->id . '.pdf');
    }

    public function closeSales(Request $request)
    {
        $latestDailyClosure = DailyClosures::latest()->first();

        $date = Carbon::now();
        $latestCreationDate = $latestDailyClosure->created_at;
        //dd($latestCreationDate, $date);

        
        $totalVentasDia = \DB::table('sale_details')
                            ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
                            ->whereBetween('sales.created_at', [$latestCreationDate, $date])
                            ->sum('sale_details.total_price');

        $cantidadProductosVendidos = \DB::table('sale_details')
                            ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
                            ->whereBetween('sales.created_at', [$latestCreationDate, $date])
                            ->sum('sale_details.quantity');
                        
        $stocks = \DB::table('products')
                            ->select(
                                'products.id',
                                'products.name',
                                'products.price as sale_price', // Precio de venta
                                'products.stock',
                                \DB::raw('COALESCE(SUM(sale_details.quantity), 0) AS total_sold'),
                                \DB::raw('COALESCE((
                                    SELECT purchase_price 
                                    FROM product_stock_history 
                                    WHERE product_stock_history.product_id = products.id 
                                    ORDER BY product_stock_history.created_at DESC 
                                    LIMIT 1
                                ), 0) AS purchase_price') // Subconsulta para obtener el precio de compra más reciente
                            )
                            ->join('sale_details', 'sale_details.product_id', '=', 'products.id') // Relación con sale_details
                            //->whereDate('sale_details.created_at', '=', $date) // Filtrar por la fecha actual
                            ->whereBetween('sale_details.created_at', [$latestCreationDate, $date])
                            ->groupBy('products.id', 'products.name', 'products.stock') // Agrupar por los campos correspondientes
                            ->havingRaw('total_sold > 0') // Asegurar que hubo movimiento
                            ->get();
        // Inicializar variables para las sumas
        $purchase_price = 0;
        $sales_total = 0;
        $diferencia = 0;
        
        // Recorrer los productos en $stocks para calcular los totales
        foreach ($stocks as $stock) {
            $total_purchase = $stock->total_sold * $stock->purchase_price;
            $purchase_price += $total_purchase;
    
            $total_sale = $stock->total_sold * $stock->sale_price;
            $sales_total += $total_sale;
    
            $total_win = $total_sale - $total_purchase;
            $diferencia += $total_win;
        }
    // Verificar que los cálculos no sean 0
    //dd($stocks, $purchase_price, $sales_total, $diferencia);
        $costoVentasDia = \DB::table('sale_details')
                            ->join('products', 'products.id', '=', 'sale_details.product_id')
                            ->join(
                                \DB::raw('(SELECT product_id, purchase_price FROM product_stock_history WHERE id IN (SELECT MAX(id) FROM product_stock_history GROUP BY product_id)) AS latest_stock'),
                                'latest_stock.product_id', '=', 'products.id'
                            )
                            //->whereDate('sale_details.created_at', $date)
                            ->whereBetween('sale_details.created_at', [$latestCreationDate, $date])
                            ->sum(\DB::raw('sale_details.quantity * latest_stock.purchase_price'));
                        
        
        // Obtener la cantidad de productos vendidos con efectivo
        $cantidadProductosEfectivo = \DB::table('sale_details')
                            ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
                            //->whereDate('sales.date', $date)
                            ->whereBetween('sales.created_at', [$latestCreationDate, $date])
                            ->where('sales.payment_method', 'cash')  // Filtrar por efectivo
                            ->sum('sale_details.quantity');  // Sumar la cantidad de productos vendidos con efectivo

// Obtener la cantidad de productos vendidos con tarjeta
        $cantidadProductosTarjeta = \DB::table('sale_details')
                        ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
                        ->whereBetween('sales.created_at', [$latestCreationDate, $date])
                        ->where('sales.payment_method', 'card')  // Filtrar por tarjeta
                        ->sum('sale_details.quantity');  // Sumar la cantidad de productos vendidos con tarjeta

                        
                        
        return view('sales.close', compact('totalVentasDia',
                                            'cantidadProductosVendidos',
                                            'stocks',
                                            'costoVentasDia',
                                            'cantidadProductosEfectivo',
                                            'cantidadProductosTarjeta',
                                            'date',            
                                            'purchase_price',  // Pasar el total calculado del precio de compra
                                            'sales_total',     // Pasar el total de ventas calculado
                                            'diferencia'       // Pasar la diferencia calculada
                                        ));

    }

    public function dailyClosure(Request $request)
    { 
          
        try {
            $date = Carbon::today();
    
            // Calcular ventas en efectivo
            $cashSales = \DB::table('sale_details')
                ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
                ->whereDate('sales.created_at', $date)
                ->where('sales.payment_method', 'cash')
                ->select(
                    \DB::raw('SUM(sale_details.total_price) as total'),
                    \DB::raw('SUM(sale_details.quantity) as quantity')
                )
                ->first();
    
            // Calcular ventas con tarjeta
            $cardSales = \DB::table('sale_details')
                ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
                ->whereDate('sales.created_at', $date)
                ->where('sales.payment_method', 'card')
                ->select(
                    \DB::raw('SUM(sale_details.total_price) as total'),
                    \DB::raw('SUM(sale_details.quantity) as quantity')
                )
                ->first();
                $stocks = \DB::table('products')
                ->select(
                    'products.id',
                    'products.name',
                    'products.price as sale_price', // Precio de venta
                    'products.stock',
                    \DB::raw('COALESCE(SUM(sale_details.quantity), 0) AS total_sold'),
                    \DB::raw('COALESCE((
                        SELECT purchase_price 
                        FROM product_stock_history 
                        WHERE product_stock_history.product_id = products.id 
                        ORDER BY product_stock_history.created_at DESC 
                        LIMIT 1
                    ), 0) AS purchase_price') // Subconsulta para obtener el precio de compra más reciente
                )
                ->join('sale_details', 'sale_details.product_id', '=', 'products.id') // Relación con sale_details
                ->whereDate('sale_details.created_at', '=', $date) // Filtrar por la fecha actual
                ->groupBy('products.id', 'products.name', 'products.stock') // Agrupar por los campos correspondientes
                ->havingRaw('total_sold > 0') // Asegurar que hubo movimiento
                ->get();
            // Inicializar variables para las sumas
            $purchase_price = 0;
            $sales_total = 0;
            $difference = 0;
            
            // Loop through the products in $stocks to calculate the totals
            foreach ($stocks as $stock) {
                $total_purchase = $stock->total_sold * $stock->purchase_price;
                $purchase_price += $total_purchase;  // Total purchase price or investment
            
                $total_sale = $stock->total_sold * $stock->sale_price;
                $sales_total += $total_sale;  // Total sales
            
                $total_win = $total_sale - $total_purchase;  // The difference between total sales and total purchase (profit)
                $difference += $total_win;
            }
    
            // Preparar los datos para el cierre diario
            $dailyClosureData = [
                'date' => $date->toDateString(),
                'cash_sales_total' => $cashSales->total ?? 0,
                'cash_sales_quantity' => $cashSales->quantity ?? 0,
                'card_sales_total' => $cardSales->total ?? 0,
                'card_sales_quantity' => $cardSales->quantity ?? 0,
                'total_sales' => ($cashSales->total ?? 0) + ($cardSales->total ?? 0),
                'total_products_sold' => ($cashSales->quantity ?? 0) + ($cardSales->quantity ?? 0),
                'comments' => $request->input('comments'),
                'surplus' => $request->input('surplus'),
                'purchase_price' => $purchase_price,
                'sales_total' => $sales_total,
                'difference' => $difference,
            ];
    
            // Verificar si ya existe un cierre para esta fecha
            /* $existingClosure = DailyClosures::whereDate('date', $date)->first();
            
            if ($existingClosure) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe un cierre para la fecha ' . $date->format('d/m/Y')
                ]);
            }
     */
            // Crear el cierre diario
            DailyClosures::create($dailyClosureData);
    
            return response()->json([
                'success' => true,
                'message' => 'Cierre diario creado exitosamente',
                'data' => $dailyClosureData
            ]);
    
        } catch (\Exception $e) {
            \Log::error('Error en cierre diario: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el cierre diario: ' . $e->getMessage()
            ], 500);
        }
    }
}
