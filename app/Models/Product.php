<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'stock', 'category', 'supplier',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function addStock(int $quantity)
    {
        $this->increment('stock', $quantity);
    }

    public function stockHistory()
    {
        return $this->hasMany(ProductStockHistory::class);
    }
    
}
