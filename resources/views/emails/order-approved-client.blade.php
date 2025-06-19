<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Mukora Supermarket</h2>
        </div>
        <div class="content">
            <h3>Order #{{ $order->id }} Approved</h3>
            <p>Dear {{ $order->user->name }},</p>
            <p>Your order has been approved and will be processed soon. Below are the details:</p>
            <ul>
                <li><strong>Total:</strong> UGX {{ number_format($order->total_amount, 2) }}</li>
                <li><strong>Status:</strong> {{ ucfirst($order->status) }}</li>
                <li><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</li>
            </ul>
            <p>Thank you for shopping with us!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Mukora Supermarket. All rights reserved.</p>
        </div>
    </div>
</body>
</html>