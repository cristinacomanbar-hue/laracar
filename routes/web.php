<?php

use Illuminate\Support\Facades\Route;
use App\Models\Car;

Route::get('/', function () {
    $cars = Car::where('available', true)->get();

    return view('home', compact('cars'));
});
