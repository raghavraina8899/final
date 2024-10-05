<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
</head>

<body>
    <h1>Hello {{ $name }}!</h1>
    <p>You asked to reset your password. To do so, please click this link:</p>
    {{-- <p><strong>Email:</strong> {{ $email }}</p> --}}
    <p> {{ $url }}</p>
    <p>This will let you change your password to something new. If you did not ask for this, do not worry, we will keep your password safe.</p>
    <p>Kind regards</p>
    <p>Team New Acropolis</p>
</body>

</html>
