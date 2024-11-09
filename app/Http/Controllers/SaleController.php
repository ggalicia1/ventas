<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use PDF;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('details.product')->paginate(10);
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
        //dd($data);
        /* $validated = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]); */
        
        //$sale = Sale::create(); // Asegúrate de agregar los campos necesarios

         // Calcular el total de la venta
       /*  $totalAmount = 0;
        foreach ($data['products'] as $item) {
            $product = Product::find($item['id']);
            $totalAmount += $product->price * $item['quantity'];
        } */
       //dd($request->input('payment_method'));
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
            //dd($item);
            $product = Product::where('id', $item['id'])->first();
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
