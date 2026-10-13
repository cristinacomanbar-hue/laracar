<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New contact message</title>
</head>

<body>

    <h2>New contact message</h2>

    <p>
        <strong>Name:</strong> {{ $contactMessage->name }}<br>
        <strong>Email:</strong> {{ $contactMessage->email }}<br>

        @if ($contactMessage->phone)
            <strong>Phone:</strong> {{ $contactMessage->formattedPhone() }}<br>
        @endif
    </p>

    <p>
        <strong>Message:</strong><br>
        {{ $contactMessage->message }}
    </p>

</body>
</html>