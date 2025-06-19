<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Mukora Supermarket Admin</h2>
        </div>
        <div class="content">
            <h3>Order #{{ $order->id }} Approved</h3>
            <p>A new order by {{ $order->user->name }} ({{ $order->user->email }}) has been approved.</p>
            <ul>
                <li><strong>Total:</strong> UGX {{ number_format($order->total_amount, 2) }}</li>
                <li><strong>Status:</strong> {{ ucfirst($order->status) }}</li>
                <li><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</li>
            </ul>
            <p>Please take necessary actions.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Mukora Supermarket. All rights reserved.</p>
        </div>
    </div>
</body>
</html>