<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login OTP</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:30px 0;">
        <tr>
            <td align="center">

                <table width="500" cellpadding="0" cellspacing="0" 
                       style="background:#ffffff; border-radius:8px; padding:30px; text-align:center;">

                    <tr>
                        <td>
                            <h2 style="margin:0; color:#333;">Your Login OTP</h2>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:20px; color:#555; font-size:15px;">
                            Hello <strong>{{ $user->name }}</strong>,
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:15px; color:#555; font-size:14px;">
                            Your One-Time Password (OTP) for login is:
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px 0;">
                            <div style="
                                display:inline-block;
                                padding:12px 25px;
                                font-size:26px;
                                font-weight:bold;
                                letter-spacing:6px;
                                background:#28a745;
                                color:#ffffff;
                                border-radius:6px;">
                                {{ $otp }}
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="color:#777; font-size:13px;">
                            This OTP will expire in 5 minutes.
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:25px; font-size:13px; color:#999;">
                            If you did not request this login, please ignore this email.
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:20px; font-size:14px; color:#333;">
                            Thank you,<br>
                            <strong>{{ config('app.name') }}</strong>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>