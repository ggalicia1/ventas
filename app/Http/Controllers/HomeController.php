<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::take(6)->get(); // 6 productos destacados
        return view('home');
    }
}
