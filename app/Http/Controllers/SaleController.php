<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use PDF;
use Carbon\Carbon;

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
        $data = $request->all();
    
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
                return redirect()->back()->withErrors(['message' => "Stock insuficiente para el producto {$product->name}."]);
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
    
        return redirect()->route('sales.index')->with('success', 'Venta creada con éxito.');
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
