<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\ContactMessage;
use App\Mail\ReservationConfirmation;
use App\Mail\ReservationCancelled;
use Illuminate\Support\Facades\Mail;


Route::get('/', function () {

    if (request('lang')) {
        App::setLocale(request('lang'));
    }

    $query = Car::where('available', true);

    $startDate = request('start_date');
    $endDate = request('end_date');

    if ($startDate && $endDate) {

        $query->whereDoesntHave('reservations', function ($reservationQuery) use ($startDate, $endDate) {
            $reservationQuery
                ->where('status', 'confirmed')
                ->where('start_date', '<=', $endDate)
                ->where('end_date', '>=', $startDate);
        });
    }

    $cars = $query->get();

    return view('home', compact('cars', 'startDate', 'endDate'));
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

    if (request('lang')) {
        App::setLocale(request('lang'));
    }

   
    $data = request()->validate([
        'customer_name' => ['required', 'string', 'max:255'],
        'customer_email' => ['required', 'email', 'max:255'],
        'customer_phone' => ['required', 'string', 'max:30'],
        'start_date' => ['required', 'date', 'after_or_equal:today'],
        'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        'message' => ['nullable', 'string'],
    ], [
        'customer_name.required' => app()->getLocale() === 'fr'
        ? 'Le nom est obligatoire.'
        : 'The name field is required.',

        'customer_email.required' => app()->getLocale() === 'fr'
            ? 'Le courriel est obligatoire.'
            : 'The email field is required.',

        'customer_phone.required' => app()->getLocale() === 'fr'
            ? 'Le téléphone est obligatoire.'
            : 'The phone field is required.',

        'start_date.required' => app()->getLocale() === 'fr'
            ? 'La date de début est obligatoire.'
            : 'The start date field is required.',

        'end_date.required' => app()->getLocale() === 'fr'
            ? 'La date de fin est obligatoire.'
            : 'The end date field is required.',
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
                'end_date' => __('messages.reservation_overlap'),
            ]);
    }

    $reservation = Reservation::create($data);

    Mail::to($reservation->customer_email)

    ->send(new ReservationConfirmation($reservation, app()->getLocale()));

    return redirect()
        ->route('reservations.confirmation', [
            'reservation' => $reservation,
            'lang' => request('lang'),
        ]);

})->name('cars.reserve.store');


Route::get('/reservations/{reservation}/confirmation', function (Reservation $reservation) {

    if (request('lang')) {
        App::setLocale(request('lang'));
    }

    return view('reservation-confirmation', compact('reservation'));
})->name('reservations.confirmation');

Route::get('/reservation/find', function () {

    if (request('lang')) {
        App::setLocale(request('lang'));
    }

    return view('reservation-find');

})->name('reservations.find');

Route::post('/reservation/find', function () {

    if (request('lang')) {
        App::setLocale(request('lang'));
    }

    $data = request()->validate([
        'search' => ['required', 'string'],
    ]);

    $search = trim($data['search']);

    if (ctype_digit($search)) {
        // Search by reservation number
        $reservation = Reservation::find((int) $search);
    } else {
        // Search by email
        $reservations = Reservation::where('customer_email', $search)
            ->orderByDesc('start_date')
            ->get();

        if ($reservations->count() > 1) {
            // We'll display the list in the next step.
            return view('reservation-search-results', compact('reservations'));
        }

        $reservation = $reservations->first();
    }

    if (! $reservation) {
        return back()
            ->withInput()           
            ->withErrors([
                'search' => __('messages.reservation_not_found'),
            ]);
    }

    return redirect()->route('reservations.confirmation', [
        'reservation' => $reservation,
        'lang' => app()->getLocale(),
        'source' => 'search',
    ]);

})->name('reservations.find.search');


Route::post('/reservations/{reservation}/cancel', function (Reservation $reservation) {

    if (request('lang')) {
        App::setLocale(request('lang'));
    }

    $reservation->update([
        'status' => 'cancelled',
    ]);

    Mail::to($reservation->customer_email)
    ->send(new ReservationCancelled($reservation, app()->getLocale()));

    return redirect()->route('reservations.confirmation', [
        'reservation' => $reservation,
        'lang' => app()->getLocale(),
        'source' => 'search',
    ]);

})->name('reservations.cancel');

Route::get('/contact', function () {

    if (request('lang')) {
        App::setLocale(request('lang'));
    }

    return view('contact');

})->name('contact');

Route::post('/contact', function () {

    if (request('lang')) {
        App::setLocale(request('lang'));
    }

    $data = request()->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'phone' => ['nullable', 'string', 'max:30'],
        'message' => ['required', 'string'],
    ]);

    ContactMessage::create($data);

    return back()->with('success', __('messages.contact_success'));

})->name('contact.store');