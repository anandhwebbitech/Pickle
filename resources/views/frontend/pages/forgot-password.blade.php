@extends('frontend.layouts.app')
@section('content')

<div class="container">
    <div class="auth-card">
        <h4 class="mb-3 text-center">Forgot Password</h4>

        <form id="forgotForm">
            @csrf

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <button type="submit" class="btn-primary-custom w-100">
                Send Reset Link
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('forgotForm').addEventListener('submit', function(e){
    e.preventDefault();

    fetch("{{ route('forgot.password.send') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        },
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {

        if(data.status){
            Swal.fire('Success', data.message, 'success');
        } else {
            Swal.fire('Error', data.message, 'error');
        }

    });
});
</script>
@endpush

@endsection