<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Person extends Model
{
    protected $table = 'people';
    protected $fillable =[
        'name',
        'email',
    ];
     public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}
