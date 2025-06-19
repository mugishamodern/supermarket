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
            <h3>Response to Your Inquiry</h3>
            <p>Dear {{ $name }},</p>
            <p>Thank you for contacting us. Below is your original message and our response:</p>
            <div class="bg-gray-200 p-2 rounded mb-2">
                <p><strong>Original Message:</strong></p>
                <p>{{ $originalMessage }}</p>
            </div>
            <div class="bg-gray-200 p-2 rounded">
                <p><strong>Our Reply:</strong></p>
                <p>{{ $reply }}</p>
            </div>
            <p>If you have further questions, feel free to reply to this email.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Mukora Supermarket. All rights reserved.</p>
        </div>
    </div>
</body>
</html>