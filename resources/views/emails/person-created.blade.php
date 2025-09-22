<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Propay</title>
</head>

<body>
    <h1>Welcome, {{ $person->name }} {{ $person->surname }}!</h1>
    <p>Thank you for joining Propay. Your account has been successfully created.</p>
    <p>Here are your details:</p>
    <ul>
        <li><strong>Name:</strong> {{ $person->name }}</li>
        <li><strong>Surname:</strong> {{ $person->surname }}</li>
        <li><strong>Email:</strong> {{ $person->email }}</li>
        <li><strong>Mobile:</strong> {{ $person->mobile_number }}</li>
        <li><strong>Language:</strong> {{ $person->language }}</li>
        <li><strong>Interests:</strong> {{ $person->interests->pluck('name')->join(', ') }}</li>
    </ul>
    <p>If you have any questions, feel free to contact us.</p>
    <p>Best regards,<br>The Propay Team</p>
</body>

</html>
