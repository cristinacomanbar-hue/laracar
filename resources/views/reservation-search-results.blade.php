@extends('layouts.main')

@section('title', 'CDrive | Reservations')

@section('content')

<div class="container py-5">

    <h1>{{ __('messages.my_reservations') }}</h1>

    <div class="list-group mt-4">

        @foreach ($reservations as $reservation)

            <a href="{{ route('reservations.confirmation', [
                    'reservation' => $reservation,
                    'lang' => app()->getLocale(),
                    'source' => 'search',
                    'email' => $reservation->customer_email,
                ]) }}"
               class="list-group-item list-group-item-action">

                <strong>
                    {{ __('messages.reservation_number') }}:
                    {{ $reservation->id }}
                </strong>

                <br>

                {{ $reservation->car->brand }}
                {{ $reservation->car->model }}

                <br>

                {{ $reservation->start_date->translatedFormat('j M Y') }}
                →
                {{ $reservation->end_date->translatedFormat('j M Y') }}

            </a>

        @endforeach

    </div>

    <a href="{{ route('reservations.find', ['lang' => app()->getLocale()]) }}"
    class="btn btn-secondary mt-3">
        {{ __('messages.new_search') }}
    </a>

</div>

@endsection