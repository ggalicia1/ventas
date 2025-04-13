<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShoppingController extends Controller
{
    public function index()
    {
        dd('aqui');
        $products = Purchase::all();
        return view('shopping.index', compact('products'));
    }

    public function show($id)
    {
        $product = Purchase::findOrFail($id);
        return view('shopping.show', compact('product'));
    }
}
