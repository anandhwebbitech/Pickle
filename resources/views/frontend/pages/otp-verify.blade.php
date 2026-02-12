@extends('frontend.layouts.app')
@section('content')

 <div class="container">
        <div class="yp-auth-card">
            <div class="yp-icon-circle">
                <i class="bi bi-chat-left-dots"></i>
            </div>

            <!-- <a href="#" class="yp-brand-logo">YUMMY <span>PICKLE</span></a> -->
            <h5 class="fw-bold mt-3 mb-2">Verify OTP</h5>
            <p class="text-muted small">We've sent a 4-digit code to your email.<br><strong>user@example.com</strong></p>

            <form id="ypOtpForm">
                <div class="yp-otp-container">
                    <input type="text" class="yp-otp-input" maxlength="1" pattern="\d*" inputmode="numeric">
                    <input type="text" class="yp-otp-input" maxlength="1" pattern="\d*" inputmode="numeric">
                    <input type="text" class="yp-otp-input" maxlength="1" pattern="\d*" inputmode="numeric">
                    <input type="text" class="yp-otp-input" maxlength="1" pattern="\d*" inputmode="numeric">
                </div>

                <a href="user-dashboard.php" type="submit" class="yp-btn-submit">VERIFY & PROCEED</a>
            </form>

            <p class="mt-4 mb-0 small text-muted">
                Didn't receive the code? <a href="resend-otp.php" class="yp-link-accent">Resend OTP</a>
            </p>

            <div class="mt-3">
                <a href="login.php" class="yp-link-back">
                    <i class="bi bi-arrow-left me-1"></i> Back to Login
                </a>
            </div>
        </div>
    </div>

    <script>
        // OTP Auto-focus logic
        const inputs = document.querySelectorAll('.yp-otp-input');

        inputs.forEach((input, index) => {
            input.addEventListener('keyup', (e) => {
                if (e.key >= 0 && e.key <= 9) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                } else if (e.key === 'Backspace') {
                    if (index > 0) {
                        inputs[index - 1].focus();
                    }
                }
            });
        });

        document.getElementById('ypOtpForm').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('OTP Verified Successfully!');
        });
    </script>
@endsection
