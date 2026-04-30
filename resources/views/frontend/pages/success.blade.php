
@extends('frontend.layouts.app')
@section('content')

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #fff8f0;
    }

    .thankyou-card {
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .brand-color {
        color: #d35400;
    }

    .icon {
        font-size: 60px;
        color: #28a745;
    }

    .btn-custom {
        background-color: #d35400;
        color: #fff;
        border-radius: 30px;
        padding: 10px 25px;
    }

    .btn-custom:hover {
        background-color: #b84300;
        color: #fff;
    }
</style>
    <main class="legal-document-container">
        <div class="container d-flex justify-content-center align-items-center vh-100">
            <div class="col-md-12">
                <div class="thankyou-card p-5 text-center">

                <div class="icon mb"><img style="width: 100px; margin-right: 20px;" src="asset/img/anni-logo.png" alt=""></div>
                <div class="icon mb-2">✔</div>

                <h2 class="fw-bold brand-color">Thank You for Your Order!</h2>

                <p class="mt-3 text-muted">
                    Your payment has been successfully received.  
                    Our kitchen is now preparing your delicious meal with love ❤️
                </p>

                <p class="mt-2">
                    {{-- <strong>Order ID:</strong> {{ session('merchant_order_id') ?? 'N/A' }} --}}
                </p>

                <hr>

                <p class="text-muted">
                    🍽️ At Anna's Kitchen, every dish is made fresh with authentic flavors and care.
                    We hope you enjoy your meal!
                </p>

                <div class="mt-4">
                    <a href="{{ route('home') }}" class="btn btn-custom me-2">🏠 Back to Home</a>
                    {{-- <a href="/orders" class="btn btn-outline-secondary">📦 Track Order</a> --}}
                </div>

            </div>
        </div>
        

    </main>


@endsection
