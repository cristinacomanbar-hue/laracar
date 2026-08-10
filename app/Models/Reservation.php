<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'car_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'start_date',
        'end_date',
        'message',
    ];
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function scopeOverlapping($query, $carId, $startDate, $endDate)
    {
        return $query
            ->where('car_id', $carId)
            ->where('start_date', '<=', $endDate)
            ->where('end_date', '>=', $startDate);
    }

}
