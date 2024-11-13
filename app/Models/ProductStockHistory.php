<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStockHistory extends Model
{
    protected $table = 'product_stock_history';
    protected $fillable = ['product_id', 'quantity', 'date_added', 'purchase_price', 'sale_price','expiration_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
