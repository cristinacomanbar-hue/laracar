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

    <form method="GET" action="{{ url('/') }}" class="card shadow-sm p-3 mb-4">
    <input type="hidden" name="lang" value="{{ app()->getLocale() }}">

    <div class="row align-items-end">

        <div class="col-md-5">
            <label class="form-label">
                {{ __('messages.start_date') }}
            </label>

            <input type="date"
                   name="start_date"
                   class="form-control"
                   min="{{ date('Y-m-d') }}"
                   value="{{ $startDate }}">
        </div>

        <div class="col-md-5">
            <label class="form-label">
                {{ __('messages.end_date') }}
            </label>

            <input type="date"
                   name="end_date"
                   class="form-control"
                   min="{{ date('Y-m-d') }}"
                   value="{{ $endDate }}">
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-warning w-100">
                {{ __('messages.check_availability') }}
            </button>
        </div>

    </div>
</form>

    <div class="row mt-3">

        @foreach ($cars as $car)

            @if ($cars->isEmpty())
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        {{ __('messages.no_cars_available') }}
                    </div>
                </div>
            @endif

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

                        <a href="{{ url('/cars/' . $car->id) }}?lang={{ app()->getLocale() }}&start_date={{ $startDate }}&end_date={{ $endDate }}"
                            class="btn btn-warning mt-auto">
                                {{ __('messages.view_details') }}
                        </a>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>

<script>
    const startDate = document.querySelector('input[name="start_date"]');
    const endDate = document.querySelector('input[name="end_date"]');

    startDate.addEventListener('change', function () {
        endDate.min = this.value;

        if (endDate.value && endDate.value < this.value) {
            endDate.value = '';
        }
    });
</script>

@endsection