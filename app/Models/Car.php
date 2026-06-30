<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'brand',
        'model',
        'year',
        'price_per_day',
        'available',
        'fuel_type',
        'transmission',
        'seats',
        'category',
    ];
}