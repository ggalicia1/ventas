<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use PDF;
use Carbon\Carbon;
use DB;

class SaleController extends Controller
{


    public function index()
    {
        $sales = Sale::with('details.product')
                                            ->whereDate('created_at', Carbon::today())
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
        $date = Carbon::today();
        
        $totalVentasDia = \DB::table('sale_details')
                            ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
                            ->whereDate('sales.created_at', $date)
                            ->sum('sale_details.total_price');

        $cantidadProductosVendidos = \DB::table('sale_details')
                            ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
                            ->whereDate('sales.created_at', $date)
                            ->sum('sale_details.quantity');
                        
        $stocks = \DB::table('products')
                            ->select(
                                'products.id',
                                'products.name',
                                'products.price',
                                'products.stock',
                                \DB::raw('COALESCE(SUM(sale_details.quantity), 0) AS total_sold')
                            )
                            ->join('sale_details', 'sale_details.product_id', '=', 'products.id') // Relación con sale_details
                            ->whereDate('sale_details.created_at', '=', $date) // Filtrar por la fecha actual
                            ->groupBy('products.id', 'products.name', 'products.stock')
                            ->havingRaw('total_sold > 0') // Asegurar que hubo movimiento
                            ->get();
        $costoVentasDia = \DB::table('sale_details')
                            ->join('products', 'products.id', '=', 'sale_details.product_id')
                            ->join('product_stock_history', 'product_stock_history.product_id', '=', 'products.id')
                            ->whereDate('sale_details.created_at', $date)
                            ->sum(\DB::raw('sale_details.quantity * product_stock_history.purchase_price'));
        
        // Obtener la cantidad de productos vendidos con efectivo
        $cantidadProductosEfectivo = \DB::table('sale_details')
                            ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
                            ->whereDate('sales.date', $date)
                            ->where('sales.payment_method', 'cash')  // Filtrar por efectivo
                            ->sum('sale_details.quantity');  // Sumar la cantidad de productos vendidos con efectivo

// Obtener la cantidad de productos vendidos con tarjeta
        $cantidadProductosTarjeta = \DB::table('sale_details')
                        ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
                        ->whereDate('sales.date', $date)
                        ->where('sales.payment_method', 'card')  // Filtrar por tarjeta
                        ->sum('sale_details.quantity');  // Sumar la cantidad de productos vendidos con tarjeta

                        
                        
        return view('sales.close', compact('totalVentasDia'
                                            , 'cantidadProductosVendidos',
                                         'stocks',
                                          'costoVentasDia',
                                          'cantidadProductosEfectivo',
                                          'cantidadProductosTarjeta',
                                          'date'
                                        ));

    }

    public function dailyClosure(Request $request)
    {
        $cierreDiario = [
            'date' => $date->toDateString(),
            'cash_sales_total' => $totalVentasEfectivo,
            'cash_sales_quantity' => $cantidadProductosEfectivo,
            'card_sales_total' => $totalVentasTarjeta,
            'card_sales_quantity' => $cantidadProductosTarjeta,
            'total_sales' => $totalVentasEfectivo + $totalVentasTarjeta, // Sumar ambos métodos
            'total_products_sold' => $cantidadProductosEfectivo + $cantidadProductosTarjeta, // Sumar productos
        ];
        DailyClosure::create($cierreDiario);
        return redirect()->route('sales.close');
    }
}
