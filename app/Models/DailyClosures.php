<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyClosures extends Model
{
    protected $table = 'daily_closures';
    protected $fillable = [
        'date', 
        'cash_sales_total', 
        'cash_sales_quantity', 
        'card_sales_total', 
        'card_sales_quantity', 
        'total_sales', 
        'total_products_sold',
        'comments'
    ];

}
    