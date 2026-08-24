@extends('layouts.main')

@section('title', 'CDrive | Reservation')

@section('content')

<div class="container py-5">

    <h1>
        {{ __('messages.reserve_car', ['car' => $car->brand . ' ' . $car->model]) }}
    </h1>

    <p>     
        <strong>{{ __('messages.price') }}:</strong>
        ${{ number_format($car->price_per_day, 2) }} {{ __('messages.per_day') }}
    </p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

   <form method="POST"
      action="{{ route('cars.reserve.store', ['car' => $car, 'lang' => app()->getLocale()]) }}"
      class="mt-4">

        @csrf

        <div class="mb-3">
            <label class="form-label">{{ __('messages.name') }}</label>
            <input type="text"
                name="customer_name"
                class="form-control"
                value="{{ old('customer_name') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('messages.email') }}</label>
            <input type="email"
                name="customer_email"
                class="form-control"
                value="{{ old('customer_email') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('messages.phone') }}</label>
            <input type="tel"
                id="customer_phone"
                name="customer_phone"
                class="form-control"
                value="{{ old('customer_phone') }}">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('messages.start_date') }}</label>
              <input type="date"
                    id="start_date"
                    name="start_date"
                    class="form-control"
                    value="{{ old('start_date') }}"
                    min="{{ date('Y-m-d') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('messages.end_date') }}</label>
                <input type="date"
                    id="end_date"
                    name="end_date"
                    class="form-control"
                    value="{{ old('end_date') }}">
            </div>
        </div>

        <div class="mb-3">           
            <strong>{{ __('messages.estimated_total') }}:</strong>
            <span id="estimated_total">-</span>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('messages.message') }}</label>
            <textarea name="message"
                class="form-control"
                rows="4">{{ old('message') }}</textarea>
        </div>

        <button type="submit" class="btn btn-warning">
            {{ __('messages.reserve') }}
        </button>

    </form>
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

<script>
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    startDate.addEventListener('change', function () {
        endDate.min = this.value;

        if (endDate.value && endDate.value < this.value) {
            endDate.value = '';
        }
    });

    function updateEstimatedTotal() {
        if (!startDate.value || !endDate.value) {
            document.getElementById('estimated_total').textContent = '-';
            return;
        }

        const start = new Date(startDate.value);
        const end = new Date(endDate.value);

        const days = Math.floor((end - start) / 86400000) + 1;
        const pricePerDay = {{ $car->price_per_day }};

        const total = days * pricePerDay;

        document.getElementById('estimated_total').textContent =
            '$' + total.toFixed(2);
    }

    startDate.addEventListener('change', updateEstimatedTotal);
    endDate.addEventListener('change', updateEstimatedTotal);

</script>


@endsection