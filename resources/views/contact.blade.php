@extends('layouts.main')

@section('title', __('messages.contact'))

@section('content')

<div class="container py-5">

    <div class="card shadow-sm">
        <div class="card-body p-4">

                <div class="row g-5 align-items-stretch">
                    <div class="col-lg-7">  

                            <h1 class="mb-4">
                                {{ __('messages.contact_us') }}
                            </h1>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form method="POST"
                                action="{{ route('contact.store', ['lang' => app()->getLocale()]) }}">

                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.name') }}</label>
                                    
                                    <input type="text"
                                            name="name"
                                            class="form-control"
                                            value="{{ old('name') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.customer_email') }}</label>
                                    
                                    <input type="email"
                                            name="email"
                                            class="form-control"
                                            value="{{ old('email') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.customer_phone') }}</label>
                                   
                                 

                                    <input type="tel"
                                            id="customer_phone"
                                            name="phone"
                                            class="form-control"s
                                            value="{{ old('phone') }}">

                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.message') }}</label>
                                    
                                    <textarea name="message"
                                                class="form-control"
                                                rows="5">{{ old('message') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-warning">
                                    {{ __('messages.send') }}
                                </button>
                            </form>

                    </div>

                    <div class="col-lg-5">
                        <img src="{{ asset('images/contact-car.png') }}"
                            alt="Car on a scenic road"
                            class="w-100 h-100 rounded"
                            style="object-fit: cover;">
                    </div>
                </div>

        </div>
    </div>

</div>

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/intl-tel-input@29.2.3/dist/css/intlTelInput.css">

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@29.2.3/dist/js/intlTelInput.min.js"></script>

<script>
    const phoneInput = document.querySelector('#customer_phone');

    const iti = window.intlTelInput(phoneInput, {
        initialCountry: 'ca',
        separateDialCode: true,
        strictMode: true,
        formatAsYouType: true,
        loadUtils: () => import('https://cdn.jsdelivr.net/npm/intl-tel-input@29.2.3/dist/js/utils.js'),
    });

    phoneInput.form.addEventListener('submit', function () {
        phoneInput.value = iti.getNumber();
    });
</script>

@endsection