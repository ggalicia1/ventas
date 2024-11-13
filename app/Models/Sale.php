<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'date',
        'total_amount',
        'customer_id', // Opcional, si manejas clientes
        'payment_method',
        'cash_amount',
        'change_amount',
        'card_reference',
    ];

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    /* public function customer()
    {
        return $this->belongsTo(Customer::class); // Si tienes un modelo de cliente
    } */

     // Relación con los detalles de la venta
     public function details()
     {
         return $this->hasMany(SaleDetail::class);  // Asumiendo que tienes un modelo Detail
     }
}
