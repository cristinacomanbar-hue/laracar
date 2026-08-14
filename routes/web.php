<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Models\Car;
use App\Models\Reservation;

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

Route::get('/cars/{car}/reserve', function (Car $car) {

    if (request('lang')) {
        App::setLocale(request('lang'));
    }

    return view('reservation-form', compact('car'));
})->name('cars.reserve');


Route::post('/cars/{car}/reserve', function (Car $car) {

    $data = request()->validate([
        'customer_name' => ['required', 'string', 'max:255'],
        'customer_email' => ['required', 'email', 'max:255'],
        'customer_phone' => ['required', 'string', 'max:30'],
        'start_date' => ['required', 'date', 'after_or_equal:today'],
        'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        'message' => ['nullable', 'string'],
    ]);

    $data['car_id'] = $car->id;

    if (
        Reservation::overlapping(
            $car->id,
            $data['start_date'],
            $data['end_date']
        )->exists()
    ) {
        return back()
            ->withInput()
            ->withErrors([
                'end_date' => 'This car is already reserved for the selected period.',
            ]);
    }

    Reservation::create($data);

    return redirect()
        ->route('cars.reserve', [
            'car' => $car,
            'lang' => request('lang'),
        ])
        ->with('success', 'Your reservation has been submitted successfully.');

})->name('cars.reserve.store');