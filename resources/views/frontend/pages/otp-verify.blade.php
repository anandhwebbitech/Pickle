@extends('frontend.layouts.app')
@section('content')

<div class="container">
    <div class="yp-auth-card text-center">
        <div class="yp-icon-circle">
            <i class="bi bi-chat-left-dots"></i>
        </div>

        <h5 class="fw-bold mt-3 mb-2">Verify OTP</h5>
        <p class="text-muted small">
            We've sent a 4-digit code to your email.<br>
            <strong>{{ session('otp_email') }}</strong>
        </p>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form id="ypOtpForm" method="POST" action="{{ route('verify.otp') }}">
            @csrf

            <input type="hidden" name="email" value="{{ session('otp_email') }}">
            <input type="hidden" name="otp" id="finalOtp">

            <div class="yp-otp-container d-flex justify-content-center gap-2 mt-3">
                <input type="text" class="yp-otp-input form-control text-center"
                       maxlength="1" inputmode="numeric" pattern="[0-9]*" required>
                <input type="text" class="yp-otp-input form-control text-center"
                       maxlength="1" inputmode="numeric" pattern="[0-9]*" required>
                <input type="text" class="yp-otp-input form-control text-center"
                       maxlength="1" inputmode="numeric" pattern="[0-9]*" required>
                <input type="text" class="yp-otp-input form-control text-center"
                       maxlength="1" inputmode="numeric" pattern="[0-9]*" required>
            </div>

            <button type="submit" class="btn btn-primary mt-4 w-100">
                VERIFY & PROCEED
            </button>
        </form>

        <!-- Resend OTP (separate form) -->
        <div class="mt-3 small">
            Didn't receive the code?
            <form id="resendOtpForm" method="POST" action="{{ route('resend.otp') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link p-0">Resend OTP</button>
            </form>
        </div>

        <div class="mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> Back to Login
            </a>
        </div>
    </div>
</div>

<script>
const inputs = document.querySelectorAll('.yp-otp-input');
const finalOtp = document.getElementById('finalOtp');
const form = document.getElementById('ypOtpForm');

// Move focus & allow only numbers
inputs.forEach((input, index) => {

    input.addEventListener('input', function () {

        this.value = this.value.replace(/[^0-9]/g, '');

        if (this.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }

        updateOtp();
    });

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Backspace' && this.value === '' && index > 0) {
            inputs[index - 1].focus();
        }
    });
});

function updateOtp() {
    let otp = '';
    inputs.forEach(i => otp += i.value);
    finalOtp.value = otp;
}

// Submit via AJAX
form.addEventListener('submit', function(e) {
    e.preventDefault();

    updateOtp(); // 🔥 IMPORTANT

    if (finalOtp.value.length !== 4) {
        alert("Please enter 4 digit OTP");
        return;
    }

    let formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            window.location.href = data.redirect;
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error(error);
        alert("Something went wrong");
    });
});


const resendForm = document.getElementById('resendOtpForm');
const resendBtn = resendForm.querySelector('button');

resendForm.addEventListener('submit', function(e) {
    e.preventDefault();

    // 🔥 Disable button + show loading
    resendBtn.disabled = true;
    resendBtn.innerHTML = `
        <span class="spinner-border spinner-border-sm me-1" role="status"></span>
        Sending...
    `;

    let formData = new FormData(resendForm);
    formData.append('email', document.querySelector('input[name="email"]').value);

    fetch(resendForm.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        alert(data.message);

        // ✅ Restore button
        resendBtn.disabled = false;
        resendBtn.innerHTML = "Resend OTP";

    })
    .catch(error => {
        console.error(error);
        alert("Something went wrong");

        resendBtn.disabled = false;
        resendBtn.innerHTML = "Resend OTP";
    });
});
</script>

@endsection