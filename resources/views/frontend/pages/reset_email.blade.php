<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>
<body style="font-family: Arial, sans-serif;">

    <h2>Hello {{ $user->name }},</h2>

    <p>You requested to reset your password.</p>

    <p>
        Click the button below to reset your password:
    </p>

    <a href="{{ $resetLink }}"
       style="display:inline-block;padding:10px 20px;background:#28a745;color:#fff;text-decoration:none;border-radius:5px;">
        Reset Password
    </a>

    <p>This link will expire in 60 minutes.</p>

    <p>If you did not request this, please ignore this email.</p>

</body>
</html>