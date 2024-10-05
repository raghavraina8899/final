<!DOCTYPE html>
<html>
<head>
    <title>Product Booked Successfully</title>
</head>
<body>
    <h1>Hello, {{ $name }}</h1>
    <p>Thank you for booking {{ $product_name }}.</p>
    <p>Details of your booking:</p>
    <ul>
        <li>Product: {{ $product_name }}</li>
        <li>Quantity: {{ $quantity }}</li>
        <li>Total Price: Rs.{{ number_format($totalPrice, 2) }}</li>
    </ul>
    <p>We hope you enjoy your purchase!</p>
    <p>Kind regards</p>
    <p>Team New Acropolis</p>
</body>
</html>
