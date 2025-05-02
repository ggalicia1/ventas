<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LostProduct extends Model
{
    protected $fillable = ['product_id', 'quantity', 'remaining_quantity', 'reason', 'loss_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
