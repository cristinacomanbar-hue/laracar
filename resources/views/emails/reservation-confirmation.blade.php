@php
    App::setLocale($emailLocale);
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reservation Confirmation</title>
</head>

<body>

    @if ($emailLocale === 'fr')

        <h2>Confirmation de réservation</h2>

        <p>Bonjour {{ $reservation->customer_name }},</p>

        <p>Votre réservation a été confirmée.</p>

        <p>
            <strong>Réservation no :</strong> {{ $reservation->id }}<br>
            <strong>Voiture :</strong> {{ $reservation->car->brand }} {{ $reservation->car->model }}<br>
            <strong>Date de début :</strong> {{ $reservation->start_date->format('Y-m-d') }}<br>
            <strong>Date de fin :</strong> {{ $reservation->end_date->format('Y-m-d') }}
        </p>

        <p>Merci !</p>

    @else

        <h2>Reservation Confirmation</h2>

        <p>Hello {{ $reservation->customer_name }},</p>

        <p>Your reservation has been confirmed.</p>

        <p>
            <strong>Reservation #:</strong> {{ $reservation->id }}<br>
            <strong>Car:</strong> {{ $reservation->car->brand }} {{ $reservation->car->model }}<br>
            <strong>Start date:</strong> {{ $reservation->start_date->format('Y-m-d') }}<br>
            <strong>End date:</strong> {{ $reservation->end_date->format('Y-m-d') }}
        </p>

        <p>Thank you!</p>

    @endif

</body>

</html>
