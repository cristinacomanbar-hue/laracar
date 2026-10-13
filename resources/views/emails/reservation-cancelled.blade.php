<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reservation Cancellation</title>
</head>

<body>

@if ($emailLocale === 'fr')

    <h2>Annulation de réservation</h2>

    <p>Bonjour {{ $reservation->customer_name }},</p>

    <p>Votre réservation a été annulée.</p>

    <p>
        <strong>Réservation no :</strong> {{ $reservation->id }}<br>
        <strong>Voiture :</strong> {{ $reservation->car->brand }} {{ $reservation->car->model }}<br>
        <strong>Date de début :</strong> {{ $reservation->start_date->format('Y-m-d') }}<br>
        <strong>Date de fin :</strong> {{ $reservation->end_date->format('Y-m-d') }}
    </p>

@else

    <h2>Reservation Cancellation</h2>

    <p>Hello {{ $reservation->customer_name }},</p>

    <p>Your reservation has been cancelled.</p>

    <p>
        <strong>Reservation #:</strong> {{ $reservation->id }}<br>
        <strong>Car:</strong> {{ $reservation->car->brand }} {{ $reservation->car->model }}<br>
        <strong>Start date:</strong> {{ $reservation->start_date->format('Y-m-d') }}<br>
        <strong>End date:</strong> {{ $reservation->end_date->format('Y-m-d') }}
    </p>

@endif

</body>
</html>
