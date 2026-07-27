<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Models\Car;

Route::get('/', function () {

    if (request('lang')) {
        App::setLocale(request('lang'));
    }

    $cars = Car::where('available', true)->get();

    return view('home', compact('cars'));
});

Route::get('/cars/{car}', function (Car $car) {

    if (request('lang')) {
        App::setLocale(request('lang'));
    }

    return view('car-details', compact('car'));
});
