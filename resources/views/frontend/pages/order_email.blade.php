<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f9; font-family: Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f9; padding:30px 0;">
    <tr>
        <td align="center">

            <!-- Main Container -->
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.05);">

                <!-- Header -->
                <tr>
                    <td style="background:#5e0e3c; padding:20px; text-align:center;">
                        <h2 style="color:#ffffff; margin:0;">🎉 Order Confirmed</h2>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px;">

                        <p style="font-size:16px; margin-bottom:10px;">
                            Hello <strong>{{ $fullname }}</strong>,
                        </p>

                        <p style="font-size:15px; color:#555;">
                            Thank you for your purchase! Your order has been successfully placed and is now being processed.
                        </p>

                        <p style="font-size:14px; margin-top:15px;">
                            <strong>Order Date:</strong> {{ $order_date }}
                        </p>

                        <!-- Order Table -->
                        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse; margin-top:20px;">
                            <thead>
                                <tr style="background:#f2f2f2;">
                                    <th align="left" style="border:1px solid #ddd;">Product</th>
                                    <th align="center" style="border:1px solid #ddd;">Weight</th>
                                    <th align="center" style="border:1px solid #ddd;">Quantity</th>
                                    <th align="center" style="border:1px solid #ddd;">Price</th>
                                    <th align="center" style="border:1px solid #ddd;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotal = 0; @endphp
                                @foreach($orders as $order)
                                @php $grandTotal += $order->total; @endphp
                                <tr>
                                    <td style="border:1px solid #ddd;">
                                        {{ $order->product->name ?? 'Product' }}
                                    </td>
                                    <td align="center" style="border:1px solid #ddd;">
                                        {{ $order->weight }}
                                    </td>
                                    <td align="center" style="border:1px solid #ddd;">
                                        {{ $order->quantity }}
                                    </td>
                                    <td align="center" style="border:1px solid #ddd;">
                                        ₹{{ number_format($order->price,2) }}
                                    </td>
                                    <td align="center" style="border:1px solid #ddd;">
                                        ₹{{ number_format($order->total,2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @php
                            $gst_rate = 18;
                            $cgst = 0;
                            $sgst = 0;
                            $igst = 0;

                            $subtotal = $grandTotal;
                            $discount = 0; // update if you have discount
                            $country = $country ?? 'India';
                            $state = $state ?? '';

                            if (strtolower($country) === 'india') {
                                $company_state = 'Tamil Nadu';

                                if (strtolower($state) === strtolower($company_state)) {
                                    $gst_total = ($subtotal - $discount) * $gst_rate / 100;
                                    $cgst = $gst_total / 2;
                                    $sgst = $gst_total / 2;
                                } else {
                                    $igst = ($subtotal - $discount) * $gst_rate / 100;
                                }
                            }

                            $gst_total = $cgst + $sgst + $igst;
                            $delivery = 0;
                            $total = ($subtotal - $discount) + $gst_total + $delivery;
                        @endphp
                        <!-- Summary -->
                        <table width="100%" cellpadding="5" cellspacing="0" style="margin-top:20px;">
                            <tr>
                                <td align="right">Subtotal: ₹{{ number_format($subtotal,2) }}</td>
                            </tr>

                            @if($cgst > 0)
                            <tr>    
                                <td align="right">CGST: ₹{{ number_format($cgst,2) }}</td>
                            </tr>
                            <tr>
                                <td align="right">SGST: ₹{{ number_format($sgst,2) }}</td>
                            </tr>
                            @endif

                            @if($igst > 0)
                            <tr>
                                <td align="right">IGST: ₹{{ number_format($igst,2) }}</td>
                            </tr>
                            @endif

                            <tr>
                                <td align="right"><strong>Grand Total: ₹{{ number_format($total,2) }}</strong></td>
                            </tr>

                            <tr>
                                <td align="right" style="font-size:14px; color:#555;">
                                    Payment Method: <strong>Cash on Delivery</strong>
                                </td>
                            </tr>
                        </table>

                        <!-- Delivery Info -->
                        <p style="margin-top:25px; font-size:14px; color:#555;">
                            Expected delivery within 5-7 working days.
                        </p>

                        <p style="font-size:14px; color:#555;">
                            If you have any questions, feel free to contact our support team.
                        </p>

                        <p style="margin-top:20px;">
                            Regards,<br>
                            <strong>Webbitech</strong>
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f2f2f2; text-align:center; padding:15px; font-size:12px; color:#888;">
                        © {{ date('Y') }} Webbitech. All rights reserved.
                    </td>
                </tr>

            </table>
            <!-- End Main Container -->

        </td>
    </tr>
</table>

</body>
</html>