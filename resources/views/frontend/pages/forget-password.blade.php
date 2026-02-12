@extends('frontend.layouts.app')
@section('content')
    <div class="container">
        <div class="yp-auth-card" id="ypResetContainer">
            <div class="yp-icon-circle">
                <i class="bi bi-shield-lock"></i>
            </div>

            <a href="#" class="yp-brand-logo">Forget Password</a>
            <h5 class="fw-bold mt-3 mb-2">Forgot Password?</h5>
            <p class="text-muted small mb-4">Enter your email and we'll send you a link to reset your password.</p>

            <form id="ypForgotForm">
                <div class="mb-4 text-start">
                    <label class="yp-input-label">Registered Email</label>
                    <input type="email" id="ypUserEmail" class="yp-form-input" placeholder="e.g. john@example.com" required>
                </div>

                <a href="otp-verify.php" type="submit" class="yp-btn-submit">SEND RESET LINK</a>
            </form>

            <div class="mt-4">
                <a href="login.php" class="yp-link-back">
                    <i class="bi bi-arrow-left me-1"></i> Back to Login
                </a>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('ypForgotForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('ypUserEmail').value;
            const container = document.getElementById('ypResetContainer');

            // Success State: Replaces form with a confirmation message
            container.innerHTML = `
            <div class="yp-icon-circle" style="background: #f0fdf4; color: #16a34a;">
                <i class="bi bi-check2-circle"></i>
            </div>
            <a href="#" class="yp-brand-logo">YUMMY <span>PICKLE</span></a>
            <h5 class="fw-bold mt-3 mb-2">Check your inbox</h5>
            <p class="text-muted small mb-4">We've sent a password reset link to:<br><strong>${email}</strong></p>
            
            <button class="yp-btn-submit" onclick="location.reload()">RESEND EMAIL</button>
            
            <div class="mt-4">
                <a href="login.php" class="yp-link-back">
                    <i class="bi bi-arrow-left me-1"></i> Back to Login
                </a>
            </div>
        `;
        });
    </script>
@endsection
