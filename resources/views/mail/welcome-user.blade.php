<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
</head>

<body>
    <h1>Welcome to Our Platform, {{ $name }}!</h1>
    <p>Your account has been created successfully. Here are your credentials:</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>Please change your password after logging in for the first time.</p>
</body>

</html>
