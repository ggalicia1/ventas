<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductStockHistory;
use Carbon\Carbon;
use DB;

class ProductStockHistoryController extends Controller
{
    public function showTotalByMonth(Request $request)
    {
        $month = $request->get('month', date('Y-m'));  // Default al mes actual si no se pasa ninguno
    
        // Obtener los totales por día dentro del mes seleccionado
        $totalsByDay = ProductStockHistory::selectRaw('DATE(created_at) as day, 
                                                      SUM(quantity) as total_quantity, 
                                                      SUM(quantity * purchase_price) as total_purchase,
                                                      COUNT(DISTINCT product_id) as total_products')
            ->whereMonth('created_at', substr($month, 5, 2))  // Filtra por mes
            ->whereYear('created_at', substr($month, 0, 4))  // Filtra por año
            ->groupBy('day')
            ->get();
    
        // Calcular el total de la compra del mes
        $totalPurchaseAmountMonth = $totalsByDay->sum('total_purchase');
    
        // Calcular la cantidad total de productos comprados en el mes
        $totalQuantityMonth = $totalsByDay->sum('total_quantity');
    
        return view('product_stock_history.total_by_month', compact('totalsByDay', 'totalPurchaseAmountMonth', 'totalQuantityMonth', 'month'));
    }



    public function showDetailsByDay(Request $request, $date)
    {
        // Obtener las compras por día junto con el nombre del producto
        $stockDetails = ProductStockHistory::with('product')
            ->whereDate('created_at', $date)
            ->get();

        // Calcular el total por producto y la cantidad total comprada
        $totalPurchaseAmount = 0; // Total de la compra (en dinero)
        $totalQuantity = 0; // Cantidad total comprada
        $productTotals = []; // Total por cada producto

        foreach ($stockDetails as $detail) {
            $productTotal = $detail->quantity * $detail->purchase_price; // Total por producto
            $totalPurchaseAmount += $productTotal; // Sumar al total general
            $totalQuantity += $detail->quantity; // Sumar la cantidad total

            // Guardar total por producto
            if (isset($productTotals[$detail->product_id])) {
                $productTotals[$detail->product_id]['quantity'] += $detail->quantity;
                $productTotals[$detail->product_id]['total'] += $productTotal;
            } else {
                $productTotals[$detail->product_id] = [
                    'name' => $detail->product->name,
                    'quantity' => $detail->quantity,
                    'total' => $productTotal,
                ];
            }
        }

        return view('product_stock_history.details_by_day', compact('stockDetails', 'date', 'totalPurchaseAmount', 'totalQuantity', 'productTotals'));
    }
}
