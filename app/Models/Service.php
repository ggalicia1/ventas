<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class Service extends Model
{
    protected $fillable = ['name', 'description'];

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}
