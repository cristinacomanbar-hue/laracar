@extends('layouts.main')


@section('title', __('messages.reservation_confirmation_title'))

@section('content')

<div class="container py-5">

    <div class="card shadow-sm">
        <div class="card-body p-4">

         <h1 class="mb-3">
            {{ request('source') === 'search'
                ? __('messages.my_reservation')
                : __('messages.reservation_confirmed') }}
        </h1>

        @if ($reservation->status === 'cancelled')
            <div class="alert alert-danger">
                {{ __('messages.reservation_cancelled') }}
            </div>
        @endif
          
            @if (request('source') !== 'search')
                <p class="lead">
                    {{ __('messages.thank_you', ['name' => $reservation->customer_name]) }}
                </p>
            @endif

            <hr>         

            <p>
                <strong>{{ __('messages.reservation_number') }}:</strong>
                #{{ $reservation->id }}
            </p>

            <p>
                <strong>{{ __('messages.customer_email') }}:</strong>
                {{ $reservation->customer_email }}
            </p>

            <p>
                <strong>{{ __('messages.customer_phone') }}:</strong>                           
              
               {{ $reservation->formattedPhone() }}
            </p>


            <p>             
                <strong>{{ __('messages.car') }}:</strong>
                {{ $reservation->car->brand }} {{ $reservation->car->model }}
            </p>

            <p>
                <strong>{{ __('messages.start_date') }}:</strong>
                {{ $reservation->start_date->translatedFormat('j M Y') }}          
            </p>

            <p>               
                <strong>{{ __('messages.end_date') }}:</strong>
                {{ $reservation->end_date->translatedFormat('j M Y') }}
            </p>

            @php
                $days = $reservation->start_date->diffInDays($reservation->end_date) + 1;
                $total = $days * $reservation->car->price_per_day;
            @endphp

            <p>
                <strong>{{ __('messages.days') }}:</strong>
                {{ $days }}
            </p>

            <p>
                <strong>{{ __('messages.estimated_total') }}:</strong>
                ${{ number_format($total, 2) }}
            </p>    
            
            @if ($reservation->message)
                <p>
                    <strong>{{ __('messages.message') }}:</strong>
                    {{ $reservation->message }}
                </p>
            @endif

            @if (request('source') === 'search' && request('email'))
                <form method="POST"
                    action="{{ route('reservations.find.search', ['lang' => app()->getLocale()]) }}"
                    class="d-inline">

                    @csrf

                    <input type="hidden"
                        name="search"
                        value="{{ request('email') }}">

                    <button type="submit" class="btn btn-secondary mt-3 me-2">
                        {{ __('messages.back_to_reservations') }}
                    </button>

                </form>
            @endif

            @if ($reservation->status === 'confirmed')
                <form method="POST"
                    action="{{ route('reservations.cancel', [
                        'reservation' => $reservation,
                        'lang' => app()->getLocale(),
                    ]) }}"
                    class="d-inline">

                    @csrf

                    <button type="submit"
                            class="btn btn-danger mt-3 me-2"
                            onclick="return confirm('{{ __('messages.confirm_cancel_reservation') }}')">
                        {{ __('messages.cancel_reservation') }}
                    </button>

                </form>
            @endif

            <a href="/?lang={{ app()->getLocale() }}" class="btn btn-warning mt-3">
                {{ __('messages.back_home') }}
            </a>

        </div>
    </div>

</div>

@endsection