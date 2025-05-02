<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LostProduct;
use App\Models\Product;
use App\Models\ProductStockHistory;
use DB;

class ReportLostProductController extends Controller
{
    //

    public function showLostProductForm($id){
        $product = Product::find($id);
        $lost_products = LostProduct::where('product_id', $product->id)->with('product')->orderBy('created_at', 'desc')->paginate(3);
        return view('lost-products.indexProducts', compact('lost_products', 'product'));
    }

    public function addLostProductStock(Request $request, $id){
        
        // Definir los mensajes personalizados
        $messages = [
            'quantity.required' => 'El campo cantidad es obligatorio.',
            'quantity.integer'  => 'La cantidad debe ser un número entero.',
            'quantity.min'      => 'La cantidad debe ser al menos 1.',
            'reason.required'   => 'El campo razón o motivo es obligatorio.',
            'reason.string'     => 'La razón o motivo debe ser una cadena de texto.',
            'reason.min'        => 'La razón o motivo debe tener al menos 15 caracteres.',
            'reason.max'        => 'La razón o motivo no puede tener más de 255 caracteres.',
        ];

        // Validar los datos del formulario
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'reason'   => 'required|string|min:15|max:255',
        ], $messages); // Pasando los mensajes personalizados aquí

        DB::beginTransaction();
        // Buscar el producto (suponiendo que tienes un modelo Product)
        $product = Product::findOrFail($id);
        if($product->stock <= 0 ){
            $errors = ['No tiene existencias.'];
            DB::rollback();
            return redirect()
            ->route('products.lostProduct')
            ->with('errors');
        }
        //dd($product);
        $product->stock -= $validated['quantity'];
        $lost_product = LostProduct::create([
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'remaining_quantity' => $product->stock,
            'reason' => $validated['reason'],
        ]);

        $stock_history = ProductStockHistory::where('product_id', $product->id)->orderBy('created_at', 'desc')->first();
        if(!$stock_history){
            DB::rollback();
            $errors = ['No tiene existencias.'];
            return redirect()
            ->route('products.lostProduct')
            ->with('errors');
        }
        $stock_history->remaining_quantity = $product->stock;
        $stock_history->save();
        $product->save();
    
        DB::commit();
        // Redirigir con un mensaje
        return redirect()
            ->route('products.lostProduct', $product->id)
            ->with('success', 'Pérdida registrada correctamente: ' . $validated['reason']);
    }

    public function editLostProductStock($id){
        $lostProduct = LostProduct::findOrFail($id);
        return view('lost-products.edit', compact('lostProduct'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|min:15|max:255',
        ], [
            'quantity.required' => 'El campo cantidad es obligatorio.',
            'quantity.integer' => 'La cantidad debe ser un número entero.',
            'quantity.min' => 'La cantidad debe ser al menos 1.',
            'reason.required' => 'El campo razón o motivo es obligatorio.',
            'reason.string' => 'La razón o motivo debe ser una cadena de texto.',
            'reason.min' => 'La razón o motivo debe tener al menos 15 caracteres.',
            'reason.max' => 'La razón o motivo no puede tener más de 255 caracteres.',
        ]);

        $lostProduct = LostProduct::findOrFail($id);
        $lostProduct->update($request->all());

        return redirect()->route('lost-products.index')->with('success', 'Registro actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $lostProduct = LostProduct::findOrFail($id);
        $lostProduct->delete();

        return redirect()->route('lost-products.index')->with('success', 'Registro eliminado exitosamente.');
    }
}
