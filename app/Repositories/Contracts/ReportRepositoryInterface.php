<?php
namespace App\Repositories\Contracts;

interface ReportRepositoryInterface
{
    public function getDailySales();
    public function getWeeklySales();
    public function getMonthlySales();
    public function getSalesByDateRange($startDate, $endDate);
    public function getTotalDailySales();
    public function getTotalWeeklySales();
    public function getTotalMonthlySales();
    public function getTotalSalesByDateRangeSales();
    public function getTotalProductsSoldDaily();
}