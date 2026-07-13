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
            <a class="nav-link active" href="/">Home</a>
            <a class="nav-link" href="#">Cars</a>
            <a class="nav-link" href="#">Contact</a>
        </div>

    </div>
</nav>



<div class="container mt-2">

    <div class="text-center pt-3 pb-4">

        <img
            src="{{ asset('images/logo.png') }}"
            alt="CDrive"
            class="img-fluid mb-2"
            style="max-width: 400px;">

        <p class="fs-5 text-dark-emphasis mb-4">
            Affordable • Reliable • Ready for your next adventure
        </p>
       
        <a href="#" class="btn btn-warning btn-lg px-5 mb-3">
            Browse Cars
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
                            <strong>Year:</strong> {{ $car->year }}
                        </p>

                        <p class="card-text">
                            <strong>Price:</strong>
                            CA${{ number_format($car->price_per_day, 2) }} / day
                        </p>

                        <a href="#" class="btn btn-warning mt-auto">
                            View Details
                        </a>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>

</body>

</html>