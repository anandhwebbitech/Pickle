@extends('layouts.app')

@section('content')
<style>
    .order-box {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    border: 1px dashed #ddd;
}
</style>
<button id="pay-button">Pay Now</button> -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                    <h4 class="text-center fw-bold mb-4">
                        Complete Your Payment
                    </h4>

                    <div class="order-box mb-4">
                        <p class="mb-1"><strong>Order ID:</strong> #23456</p>
                        <p class="mb-1"><strong>Customer:</strong> ANANDH</p>
                        <p class="mb-1"><strong>Email:</strong> anandhwebbitech@gmail.com</p>
                        <p class="mb-1"><strong>Amount:</strong>
                            <span class="text-success fw-bold">
                                1000
                            </span>
                        </p>
                    </div>

                    <button id="pay-button" class="btn btn-danger w-100 py-2 fw-bold">
                        Pay 10000
                    </button>

                    <p class="text-center text-muted mt-3 small">
                        🔒 Secure payment powered by Razorpay
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var options = {
        "key": "{{ env('RAZORPAY_KEY') }}",
        "amount": {{ $rOrder['amount'] }},
        "currency": "{{ $rOrder['currency'] }}",
        "name": "Your Company Name",
        "description": "Order #{{ $order->id }}",
        "order_id": "{{ $rOrder['id'] }}",
        "handler": function (response){
            // Send payment details to server via AJAX
            fetch("{{ route('payment.save') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    order_id: "{{ $order->id }}",
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_signature: response.razorpay_signature,
                    amount: {{ $rOrder['amount'] / 100 }} // in INR
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success'){
                    alert("Payment completed and saved! Payment ID: " + data.payment_id);
                     window.location.href = "{{ route('profilepage') }}";
                } else {
                    alert("Payment save failed! " + (data.message || ""));
                }
            })
            .catch(err => {
                console.error(err);
                alert("Payment save failed due to network or server error!");
            });
        },
        "prefill": {
            "name": "{{ $order->user->name ?? '' }}",
            "email": "{{ $order->user->email ?? '' }}",
            "contact": "{{ $order->user->phone ?? '' }}"
        },
        "theme": {
            "color": "#3399cc"
        }
    };

    var rzp1 = new Razorpay(options);
    document.getElementById('pay-button').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    };
});
</script>
@endsection
