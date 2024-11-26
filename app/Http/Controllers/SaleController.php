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
                if ($request->payment_method === 'card' && !is_string($request->card_reference)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'La referencia de la tarjeta debe ser una cadena de texto.'
                    ]);
                } 

            
                $data = $request->validate([
                    'total_amount' => 'required|numeric|min:1',
                    'payment_method' => 'required|in:cash,card',
                    'cash_amount' => 'required_if:payment_method,cash|numeric|min:0',
                    'change_amount' => 'required_if:payment_method,cash|numeric|min:0',
                    // Hacer que card_reference sea nullable, y solo válido como string cuando el método de pago es 'card'
                    'card_reference' => 'nullable|required_if:payment_method,card|string|max:255',
                    'products' => 'required|array|min:1',
                    'products.*.id' => 'required|exists:products,id',
                    'products.*.quantity' => 'required|integer|min:1',
                    'products.*.price' => 'required|numeric|min:0',
                ]);
            

                $calculatedTotal = 0;
                foreach ($data['products'] as $item) {
                    $calculatedTotal += $item['price'] * $item['quantity'];
                }

                // Verifica si el total calculado coincide con el total_amount proporcionado
                if (number_format($calculatedTotal, 2) !== number_format($data['total_amount'], 2)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'El total calculado no coincide con el total_amount proporcionado.'
                    ]);
                }
                // Crear la venta
                $sale = Sale::create([
                    'date' => now(),
                    'total_amount' => $request->input('total_amount'),
                    'payment_method' => $request->input('payment_method'),
                    'cash_amount' => $request->input('cash_amount'),
                    'change_amount' => $request->input('change_amount'),
                    'card_reference' => $request->input('card_reference'),
                ]);
            
                foreach ($data['products'] as $item) {
                    $product = Product::findOrFail($item['id']);
    
                    // Validar stock disponible 
                    if ($product->stock < $item['quantity']) {
                        return response()->json([
                                                'success' => false, 
                                                'message' => "Stock insuficiente para el producto {$product->name}."
                                                ]);
                    }
            
                    // Reducir stock
                    $product->decrement('stock', $item['quantity']);
            
                    // Crear el detalle de la venta
                    $totalPrice = $product->price * $item['quantity'];
                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                        'total_price' => $totalPrice,
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
}
