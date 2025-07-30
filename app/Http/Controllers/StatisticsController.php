<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    /**
     * Display the statistics page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $hoy = Carbon::now()->toDateString();
        $inicioSemana = Carbon::now()->startOfWeek();
        $finSemana = Carbon::now()->endOfWeek();
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();

        $productos = Product::select(
                'products.id',
                'products.name',
                'products.stock',
                DB::raw('COALESCE(SUM(sale_details.quantity), 0) as total_vendido'),
                DB::raw('COALESCE(SUM(CASE WHEN DATE(sales.date) = "' . $hoy . '" THEN sale_details.quantity ELSE 0 END), 0) as vendido_hoy'),
                DB::raw('COALESCE(SUM(CASE WHEN sales.date >= "' . $inicioSemana . '" THEN sale_details.quantity ELSE 0 END), 0) as vendido_semana'),
                DB::raw('COALESCE(SUM(CASE WHEN sales.date >= "' . $inicioMes . '" THEN sale_details.quantity ELSE 0 END), 0) as vendido_mes')
            )
            ->leftJoin('sale_details', 'products.id', '=', 'sale_details.product_id')
            ->leftJoin('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->groupBy('products.id', 'products.name', 'products.stock')
            ->orderByDesc('total_vendido')
            ->take(30)
            ->get();

        return view('statistics.dashboard', compact('productos', 'hoy', 'inicioSemana', 'finSemana', 'inicioMes', 'finMes'));
    }
}
