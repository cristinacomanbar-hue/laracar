@extends('layouts.main')

@section('title', 'CDrive | Find Reservation')

@section('content')

<div class="container py-5">

    <h1>{{ __('messages.find_reservation') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('reservations.find.search', ['lang' => app()->getLocale()]) }}">

    @csrf

    <div class="mb-3">
        <label class="form-label">
            {{ __('messages.reservation_search') }}
        </label>

        <input
            type="text"
            name="search"
            value="{{ old('search') }}"
            class="form-control"
            required
        >
    </div>

    <button type="submit" class="btn btn-warning">
        {{ __('messages.find_reservation') }}
    </button>

</form>

</div>

@endsection