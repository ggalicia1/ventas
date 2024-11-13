<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\services\ReportService;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index(Request $request)
    {
        $reportType = $request->input('report_type', 'daily');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate && $endDate) {
            $reportType = 'range';
        }

        // Inicializamos las variables
        $sales = collect();
        $totalSales = 0;
        $totalProductsSold = 0; // Nueva variable para el total de productos vendidos

        // Seleccionamos los datos en base al tipo de reporte
        switch ($reportType) {
            case 'weekly':
                $sales = $this->reportService->getWeeklySales();
                $totalSales = $this->reportService->getTotalWeeklySales();
                break;
            case 'monthly':
                $sales = $this->reportService->getMonthlySales();
                $totalSales = $this->reportService->getTotalMonthlySales();
                break;
            case 'range':
                $sales = $this->reportService->getSalesByDateRange($startDate, $endDate);
                $totalSales = $this->reportService->getTotalSalesByDateRange($startDate, $endDate);
                break;
            default: // Diario
                $sales = $this->reportService->getDailySales();
                $totalSales = $this->reportService->getTotalDailySales();
                $totalProductsSold = $this->reportService->getTotalProductsSoldDaily(); // Obtenemos el total de productos vendidos
                break;
        }

        return view('reports.sales.index', compact('sales', 'reportType', 'startDate', 'endDate', 'totalSales', 'totalProductsSold'));
    }

    


}
