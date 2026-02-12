@extends('frontend.layouts.app')
@section('content')

<section class="py-5" style="background-color: #fcf9f4;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}" class="text-muted text-decoration-none small">Home</a>
                        </li>
                        <li class="breadcrumb-item active small text-danger fw-bold" aria-current="page">
                            Products
                        </li>
                    </ol>
                </nav>

                <h1 class="display-5 fw-bold text-dark mb-0">
                    Our <span style="color: #dc3545;">Products</span>
                </h1>
                <div class="mx-auto mt-2"
                     style="width: 60px; height: 3px; background-color: #dc3545; border-radius: 2px;">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container pb-5">
<div class="product-main-container p-4 p-md-5">
<div class="row g-5">

<!-- LEFT IMAGE SECTION -->
<div class="col-lg-6">
    <div class="swiper main-swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide text-center">
                <img src="{{ asset('assets/img/product/pro-1.webp') }}" class="img-fluid">
            </div>
            <div class="swiper-slide text-center">
                <img src="{{ asset('assets/img/product/pro-2.webp') }}" class="img-fluid">
            </div>
        </div>
        <div class="swiper-button-next text-danger"></div>
        <div class="swiper-button-prev text-danger"></div>
    </div>

    <div thumbsSlider="" class="swiper thumb-swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="{{ asset('assets/img/product/pro-1.webp') }}">
            </div>
            <div class="swiper-slide">
                <img src="{{ asset('assets/img/product/pro-2.webp') }}">
            </div>
        </div>
    </div>
</div>

<!-- RIGHT CONTENT -->
<div class="col-lg-6">
    <p class="text-danger fw-bold small mb-1">Yummy Pickle</p>
    <h1 class="fw-bold mb-2">Curry Leaf Powder</h1>
    <h2 class="fw-bold mb-4">Rs. <span id="price-target">100.00</span></h2>

    <!-- (rest of your content remains same, unchanged) -->

</div>
</div>

<!-- PAYMENT SECTION -->
<div class="row mt-5 pt-5 border-top">
<div class="col-lg-4 mt-4 mt-lg-0">
    <div class="p-4 rounded-4" style="border: 1px dashed #d1d1d1; background: #fafafa;">
        <h6 class="fw-bold small mb-3 text-uppercase">Secure Checkout</h6>
        <div class="d-flex flex-wrap gap-2 mb-3">
            <img src="{{ asset('assets/img/applepay.png') }}" class="pay-img">
            <img src="{{ asset('assets/img/phonepe.png') }}" class="pay-img">
            <img src="{{ asset('assets/img/gpay.png') }}" class="pay-img">
            <img src="{{ asset('assets/img/paytm.png') }}" class="pay-img">
        </div>
        <p class="text-muted mb-0 small" style="font-size: 0.75rem;">
            SSL Secure Encryption
        </p>
    </div>
</div>
</div>
</div>
</section>

<!-- RELATED PRODUCTS -->
<section class="my-5">
<div class="container">
<div class="row g-4">

@for($i = 0; $i < 4; $i++)
<div class="col-sm-6 col-md-4 col-lg-3">
<div class="product-card p-3 border shadow-sm bg-white">
<div class="img-container mb-3">

<img src="{{ asset('assets/img/product/pro-1.webp') }}" class="img-main">
<img src="{{ asset('assets/img/product/pro-2.webp') }}" class="img-hover">

<div class="view-overlay">
    <a href="#" class="btn btn-light rounded-pill btn-sm fw-bold shadow-sm px-3">
        View Product
    </a>
</div>

</div>
</div>
</div>
@endfor

</div>
</div>
</section>

@endsection
