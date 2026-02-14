@extends('frontend.layouts.app')

@section('content')
<style>
    .order-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        border: 1px dashed #ddd;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                    <h4 class="text-center fw-bold mb-4">
                        Complete Your Payment
                    </h4>

                    <div class="order-box mb-4">
                        <p class="mb-1"><strong>Order ID:</strong> #{{ $order->id }}</p>
                        <p class="mb-1"><strong>Customer:</strong> {{ $order->user->name ?? '' }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ $order->user->email ?? '' }}</p>
                        <p class="mb-1">
                            <strong>Amount:</strong>
                            <span class="text-success fw-bold">
                                ₹100
                            </span>
                        </p>
                    </div>

                    <button id="pay-button" class="btn btn-danger w-100 py-2 fw-bold">
                        Pay ₹100
                    </button>

                    <p class="text-center text-muted mt-3 small">
                        🔒 Secure payment powered by Razorpay
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>
@push('scripts')
    
{{-- Razorpay --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    var options = {
        key: "{{ config('services.razorpay.key') }}",
        amount: 100,
        currency: "INR",
        name: "Your Company Name",
        description: "Order #1",
        order_id: "1",

        handler: function (response) {

            fetch("{{ route('payment.save') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    order_id: "1",
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_signature: response.razorpay_signature,
                    amount: 100
                })
            })
            .then(res => res.json())
            .then(data => {

                if(data.status === 'success') {

                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Successful!',
                        text: 'Your payment has been completed.',
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        window.location.href = "{{ route('profile') }}";
                    });

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Failed',
                        text: data.message || 'Payment save failed.'
                    });

                }

            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Payment save failed due to server error.'
                });
            });
        },

        prefill: {
            name: "{{ $order->user->name ?? '' }}",
            email: "{{ $order->user->email ?? '' }}",
            contact: "{{ $order->user->phone ?? '' }}"
        },

        theme: {
            color: "#dc3545"
        }
    };

    var rzp1 = new Razorpay(options);

    document.getElementById('pay-button').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    };

});
</script>
@endpush

@endsection
