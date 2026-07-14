<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <title>CDrive | HomePage</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">     
        <a class="navbar-brand fw-bold fs-4" href="/">
            <span class="text-warning">CD</span>rive
        </a>

        <div class="navbar-nav ms-auto">
           
            <a class="nav-link active" href="/">{{ __('messages.home') }}</a>
            <a class="nav-link" href="#">{{ __('messages.cars') }}</a>
            <a class="nav-link" href="#">{{ __('messages.contact') }}</a>

            <a class="nav-link" href="/?lang=en">EN</a>
            <a class="nav-link" href="/?lang=fr">FR</a>
        </div>

      

    </div>
</nav>


<div class="container mt-1">

    <div class="text-center pt-2 pb-2">

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

                <div class="card h-100">

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

                        <a href="#" class="btn btn-warning mt-auto">
                             {{ __('messages.view_details') }}
                        </a>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>

</body>

</html>