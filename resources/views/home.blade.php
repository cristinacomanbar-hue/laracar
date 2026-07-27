@extends('layouts.main')

@section('title', 'CDrive | Home')

@section('content')


<div class="container mt-1">

    <div class="text-center pt-4 pb-2">

        <img
            src="{{ asset('images/logo.png') }}"
            alt="CDrive"
            class="img-fluid mb-1"
            style="max-width: 360px;">
    
        <p class="fs-5 text-dark-emphasis mt-2 mb-3">
            {{ __('messages.tagline') }}
        </p>
       
        <a href="#" class="btn btn-warning btn-lg px-5 mb-3">
           {{ __('messages.browse_cars') }}
        </a>

    </div>

    <div class="row mt-3">

        @foreach ($cars as $car)

            <div class="col-md-4 mb-4">

                <div class="card h-100 car-card">

                    @if ($car->photo)
                        <img
                            src="{{ Storage::url($car->photo) }}"
                            class="card-img-top"
                            alt="{{ $car->brand }} {{ $car->model }}">
                    @endif

                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title">
                            {{ $car->brand }} {{ $car->model }}
                        </h5>

                        <p class="card-text">                           
                            <strong>{{ __('messages.year') }}:</strong> {{ $car->year }}
                        </p>

                        <p class="card-text">
                            <strong>{{ __('messages.price') }}:</strong>                        
                            CA${{ number_format($car->price_per_day, 2) }} {{ __('messages.per_day') }}
                        </p>

                        <a href="{{ url('/cars/' . $car->id) }}?lang={{ app()->getLocale() }}" class="btn btn-warning mt-auto">
                             {{ __('messages.view_details') }}
                        </a>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection