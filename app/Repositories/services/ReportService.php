<?php

namespace App\Repositories\Services;

use App\Repositories\Contracts\ReportRepositoryInterface;

class ReportService
{
    protected $reportRepositorys;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function getDailySales()
    {
        return $this->reportRepository->getDailySales();
    }

    public function getWeeklySales()
    {
        return $this->reportRepository->getWeeklySales();
    }

    public function getMonthlySales()
    {
        return $this->reportRepository->getMonthlySales();
    }

    public function getSalesByDateRange($startDate, $endDate)
    {
        return $this->reportRepository->getSalesByDateRange($startDate, $endDate);
    }

    public function getTotalDailySales()
    {
        return $this->reportRepository->getTotalDailySales()->sum('total_amount');
    }

    public function getTotalWeeklySales()
    {
        return $this->reportRepository->getTotalWeeklySales()->sum('total_amount');
    }
    public function getTotalMonthlySales()
    {
        return $this->reportRepository->getTotalMonthlySales()->sum('total_amount');
    }
    public function getTotalSalesByDateRangeSales()
    {
        return $this->reportRepository->getTotalSalesByDateRangeSales($startDate, $endDate)->sum('total_amount');
    }
    public function getTotalProductsSoldDaily()
    {
        return $this->reportRepository->getTotalProductsSoldDaily();
    }
}
