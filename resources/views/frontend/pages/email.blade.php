<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Enquiry</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8;padding:20px 0;">
    <tr>
        <td align="center">

            <!-- Main Card -->
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 4px 10px rgba(0,0,0,0.08);">
                
                <!-- Header -->
                <tr>
                    <td style="background:#0d6efd;color:#ffffff;padding:18px 24px;">
                        <h2 style="margin:0;font-size:20px;">📩 New Enquiry Received</h2>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:24px;">
                        <p style="font-size:14px;color:#333;margin-bottom:20px;">
                            You have received a new enquiry from the website. Below are the details:
                        </p>

                        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;font-size:14px;">
                            <tr>
                                <td style="width:35%;background:#f8f9fa;font-weight:bold;border:1px solid #dee2e6;">Name</td>
                                <td style="border:1px solid #dee2e6;">{{ $fullname }}</td>
                            </tr>
                            <tr>
                                <td style="background:#f8f9fa;font-weight:bold;border:1px solid #dee2e6;">Email</td>
                                <td style="border:1px solid #dee2e6;">{{ $email }}</td>
                            </tr>
                            <tr>
                                <td style="background:#f8f9fa;font-weight:bold;border:1px solid #dee2e6;">Phone</td>
                                <td style="border:1px solid #dee2e6;">{{ $phone }}</td>
                            </tr>
                          
                            <tr>
                                <td style="background:#f8f9fa;font-weight:bold;border:1px solid #dee2e6;">Message</td>
                                <td style="border:1px solid #dee2e6;">
                                    {{ $messageBody }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f1f3f5;padding:14px 24px;text-align:center;font-size:12px;color:#666;">
                        This enquiry was submitted via your website contact form.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
