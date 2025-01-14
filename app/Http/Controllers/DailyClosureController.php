<?php

namespace App\Http\Controllers;

use App\Models\DailyClosures;
use Illuminate\Http\Request;

class DailyClosureController extends Controller
{
    public function index()
    {
        $dailyClosures = DailyClosures::orderBy('date', 'desc')->paginate(10);
        $totals = [
            'surplus'        => DailyClosures::sum('surplus'),
            'purchase_price' => DailyClosures::sum('purchase_price'),
            'sales_total'    => DailyClosures::sum('sales_total'),
            'difference'     => DailyClosures::sum('difference'),
        ];
        return view('sales.closure.index', compact('dailyClosures', 'totals'));
    }

    public function create()
    {
        return view('daily-closures.create');
    }


    public function show(Request $dailyClosure)
    {
        $dailyClosure = DailyClosures::findOrFail($dailyClosure->dailyClosure);
        // Encuentra el registro anterior basado en created_at
        $previousClosure = DailyClosures::where('created_at', '<', $dailyClosure->created_at)
            ->orderBy('created_at', 'desc')
            ->first();

        // Pasamos las fechas a la vista para usarlas en otros cálculos
        $currentDate = $dailyClosure->created_at;
        $previousDate = $previousClosure ? $previousClosure->created_at : null;
        
        //dd();
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
            ->whereBetween('sale_details.created_at', [$previousDate,$currentDate]) // Filtrar por la fecha actual
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
        return view('sales.closure.show', compact(
                                                    'dailyClosure',
                                                    'stocks',
                                                    'purchase_price',
                                                    'sales_total',
                                                    'difference',
                                                    ));
    }
}

