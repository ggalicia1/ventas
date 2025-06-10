<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['amount', 'description'];

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }
}
