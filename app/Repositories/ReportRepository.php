<?php

namespace App\Repositories;

use App\Repositories\Contracts\ReportRepositoryInterface;
use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;

class ReportRepository implements ReportRepositoryInterface
{
    public function getDailySales()
    {
        return Sale::whereDate('date', Carbon::today())->paginate(5);;
    }
    
    public function getWeeklySales()
    {
        return Sale::whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->paginate(5);
    }

    public function getMonthlySales()
    {
        return Sale::whereMonth('date', Carbon::now()->month)->paginate(5);
    }

    public function getSalesByDateRange($startDate, $endDate)
    {
        return Sale::whereBetween('date', [$startDate, $endDate])->paginate(5);
    }

    public function getTotalDailySales()
    {
        return Sale::whereDate('date', Carbon::today())->get();
    }
    public function getTotalWeeklySales()
    {
        return Sale::whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
    }
    public function getTotalMonthlySales()
    {
        return Sale::whereMonth('date', Carbon::now()->month)->get();
    }
    public function getTotalSalesByDateRangeSales()
    {
        return Sale::whereBetween('date', [$startDate, $endDate])->get();
    }
    public function getTotalProductsSoldDaily()
    {
        return SaleDetail::whereDate('created_at', Carbon::today()) // Asegurarse de que coincide con el día actual
                    ->sum('quantity'); // Sumar la cantidad de productos vendidos
    }
}
