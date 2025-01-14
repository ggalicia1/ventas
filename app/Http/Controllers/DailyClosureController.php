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
        return view('sales.closure.show', compact('dailyClosure'));
    }
}

