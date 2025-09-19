<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Pesanan</title>
</head>
<body>
    <h2>Halo, {{ $order->user->name }}</h2>
    <p>Terima kasih sudah berbelanja di <strong>HealthHub</strong>.</p>
    <p>Berikut kami lampirkan invoice pembelian Anda.</p>
    <p><strong>No. Order:</strong> {{ $order->id }}</p>
    <p><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
    <br>
    <p>Salam,</p>
    <p><strong>HealthHub</strong></p>
</body>
</html>
