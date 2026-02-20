@extends('frontend.layouts.app')
@section('content')

<div class="container">
    <div class="auth-card">
        <a href="#" class="brand-logo">Login</a>
        <!-- <p class="brand-tagline">Pure, Authentic & Handcrafted</p> -->

        <form id="loginForm">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label">Password</label>
                    {{-- <a href="#" class="signup-link small">Forgot?</a> --}}
                </div>
                <div class="password-field-container">
                    <input type="password" name="password" id="passwordInput"
                        class="form-control" placeholder="••••••••" required style="padding-right: 45px;">
                    <i class="bi bi-eye password-toggle-icon" id="togglePassword"></i>
                </div>
            </div>

            <button type="submit" class="btn-primary-custom">SIGN IN</button>
        </form>

        <div class="divider">OR</div>

        {{-- <a href="#" class="btn btn-outline-secondary w-100 rounded-pill py-2 small d-flex align-items-center justify-content-center gap-2 border-light-subtle">
            <img src="https://cdn-icons-png.flaticon.com/512/300/300221.png" width="16">
            <span class="text-dark">Continue with Google</span>
        </a> --}}

        <p class="text-center mt-4 mb-0 small text-muted">
            Don't have an account? <a href="{{ route('signup') }}" class="signup-link">Sign Up</a>
        </p>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let button = this.querySelector("button[type='submit']");

        // Show loading
        button.disabled = true;
        button.innerHTML = "Please wait...";

        fetch("{{ route('login.ajax') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {

                button.disabled = false;
                button.innerHTML = "SIGN IN";

                if (data.status === true) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = data.redirect;
                    });

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: data.message
                    });

                }
            })
            .catch(error => {

                button.disabled = false;
                button.innerHTML = "SIGN IN";

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                });

                console.error(error);
            });
    });

    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#passwordInput');

    togglePassword.addEventListener('click', function() {
        // Toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Toggle the icon
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });

    document.getElementById('loginForm').addEventListener('submit', (e) => e.preventDefault());
</script>
@endpush
@endsection