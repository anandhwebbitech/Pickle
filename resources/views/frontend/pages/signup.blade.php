@extends('frontend.layouts.app')

@section('content')

<div class="container">
    <div class="auth-card">
        <a href="#" class="brand-logo">Signup</a>

        <form id="signupForm">
            @csrf
            <div class="row g-3">

                <div class="col-md-12">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="John Doe">
                </div>

                <div class="col-md-12">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="john@example.com">
                </div>

                <div class="col-md-12">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="Enter your phone number">
                </div>

                <div class="col-md-12">
                    <label class="form-label">Create Password</label>
                    <div class="password-field-container">
                        <input type="password" name="password" id="regPassword" class="form-control" placeholder="Min. 8 characters" style="padding-right: 45px;">
                        <i class="bi bi-eye password-toggle-icon" id="toggleRegPassword"></i>
                    </div>
                </div>

            </div>

            <button type="submit" class="btn-signup mt-3">CREATE ACCOUNT</button>
        </form>
    </div>
</div>

@endsection


@push('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// Password Toggle
const toggleRegPassword = document.querySelector('#toggleRegPassword');
const regPassword = document.querySelector('#regPassword');

toggleRegPassword.addEventListener('click', function () {
    const type = regPassword.getAttribute('type') === 'password' ? 'text' : 'password';
    regPassword.setAttribute('type', type);
    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
});


// AJAX Signup
$('#signupForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('signup.store') }}",
        type: "POST",
        data: $(this).serialize(),

        success: function(response) {

            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: response.message,
                confirmButtonColor: '#28a745'
            }).then(() => {
                $('#signupForm')[0].reset();
                window.location.href = "{{ route('home') }}";

            });

        },

        error: function(xhr) {

            if (xhr.status === 422) {

                let errors = xhr.responseJSON.errors;
                let errorMsg = '';

                $.each(errors, function(key, value) {
                    errorMsg += value[0] + "<br>";
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMsg,
                    confirmButtonColor: '#dc3545'
                });
            }
        }
    });

});

</script>

@endpush
