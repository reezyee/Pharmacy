<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .header {
            background: linear-gradient(135deg, #2563eb, #22d3ee);
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 12px 12px 0 0;
            margin: -30px -30px 30px;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #2563eb, #22d3ee);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: bold;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: scale(1.05);
        }
        .footer {
            text-align: center;
            color: #666;
            margin-top: 20px;
            font-size: 0.9em;
        }
        .warning {
            background-color: #f0f9ff;
            border-left: 4px solid #3b82f6;
            padding: 10px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reset Password</h1>
        </div>

        <p>Halo,</p>

        <p>You are receiving this email because we received a password reset request for your account.</p>

        <p>Please click the button below to reset your password:</p>

        <div style="text-align: center;">
            <a href="{{ url(route('password.reset', ['token' => $token, 'email' => $email])) }}" class="btn">
                Reset Password
            </a>
        </div>

        <div class="warning">
            <p><strong>Note:</strong> This link is only valid for a while.</p>
        </div>

        <p>If you did not request a password reset, please ignore this email or contact our support team if you think there is suspicious activity.</p>

        <div class="footer">
            <p>Thank You,<br>
            {{ config('app.name') }} Team</p>
        </div>
    </div>
</body>
</html>