<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchases';

    protected $fillable = [
        'provider_id',
        'date',
        'user_id',
        'receipt_type',
        'receipt_number',
        'receipt_series',
        'total',
        'status',
    ];

    // Relación con el proveedor
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function productStockHistories()
    {
        return $this->hasMany(ProductStockHistory::class);
    }

}
