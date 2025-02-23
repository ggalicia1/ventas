<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction  extends Model
{
    protected $fillable = [
        'date',
        'description',
        'debit_balance',
        'change_amount',
        'changed_balance',
        'balance',
        'cleared'
    ];

    protected $casts = [
        'date' => 'date',
        'debit_balance' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'changed_balance' => 'decimal:2',
        'balance' => 'decimal:2',
        'cleared' => 'boolean'
    ];
}
