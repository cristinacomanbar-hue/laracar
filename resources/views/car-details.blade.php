@extends('layouts.main')

@section('title', 'CDrive | Home')

@section('content')

<div class="container py-5">

    <h1>{{ $car->brand }} {{ $car->model }}</h1>

    <img
        src="{{ asset('storage/' . $car->photo) }}"
        alt="{{ $car->brand }} {{ $car->model }}"
        class="img-fluid rounded my-4"
        style="max-width: 600px;">

    <ul class="list-group mb-4">
        <li class="list-group-item">
            <strong>{{ __('messages.year') }}:</strong>
            {{ $car->year }}
        </li>

        <li class="list-group-item">
            <strong>{{ __('messages.price') }}:</strong>
            ${{ number_format($car->price_per_day, 2) }}
            {{ __('messages.per_day') }}
        </li>
    </ul>

    <a href="/?lang={{ app()->getLocale() }}" class="btn btn-secondary">
        ← {{ __('messages.home') }}
    </a>

</div>

@endsection
