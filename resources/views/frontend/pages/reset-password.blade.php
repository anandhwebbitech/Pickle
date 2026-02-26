@extends('frontend.layouts.app')
@section('content')

<div class="container">
    <div class="auth-card">
        <h4 class="mb-3 text-center">Reset Password</h4>

        <form id="resetForm">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn-primary-custom w-100">
                Reset Password
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('resetForm').addEventListener('submit', function(e){
    e.preventDefault();

    fetch("{{ route('password.update') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        },
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {

        if(data.status){
            Swal.fire({
                icon:'success',
                title:'Success',
                text:data.message
            }).then(()=>{
                window.location.href = data.redirect;
            });
        } else {
            Swal.fire('Error', data.message, 'error');
        }

    });
});
</script>
@endpush

@endsection