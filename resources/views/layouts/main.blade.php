<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'CDrive')</title>

    <link rel="icon" href="{{ asset('favicon.svg') }}">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>


<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
    <div class="container">

        <a class="navbar-brand fw-bold fs-3" href="/?lang={{ app()->getLocale() }}">
            <span class="text-warning">CD</span>rive
        </a>

     <div class="navbar-nav ms-auto fs-5">
     
            <a class="nav-link active text-warning fw-bold" href="/?lang={{ app()->getLocale() }}">
                {{ __('messages.home') }}
            </a>

            <a class="nav-link" href="#">
                {{ __('messages.cars') }}
            </a>

            <a class="nav-link" href="#">
                {{ __('messages.contact') }}
            </a>

            <a class="nav-link" href="/?lang=en">EN</a>
            <a class="nav-link" href="/?lang=fr">FR</a>

        </div>

    </div>
</nav>


@yield('content')

</body>
</html>