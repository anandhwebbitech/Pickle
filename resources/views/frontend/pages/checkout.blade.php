@extends('frontend.layouts.app')
@section('content')
   <div class="container mb-5">
        <div class="yp-step-indicator">
            <span class="yp-step">01 Cart</span>
            <span class="yp-step active">02 Checkout</span>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="yp-checkout-section shadow-sm">
                    <div class="yp-section-title"><i class="bi bi-geo-alt-fill"></i> Delivery Address</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="yp-address-card active">
                                <input type="radio" name="addr" checked>
                                {{-- <span class="fw-bold d-block mb-1">Home</span> --}}
                                <small class="text-muted d-block">{{ $user_delivery_address->address }}</small>
                                <small class="text-muted d-block">{{ $user_delivery_address->city }}</small>
                                <small class="text-muted d-block">{{ $user_delivery_address->state }} - {{ $user_delivery_address->pincode }}</small>
                                <small class="fw-bold d-block mt-2">{{$user_delivery_address->mobile }}</small>
                            </label>
                        </div>
                    </div>
                    {{-- <button class="btn btn-link text-calor fw-bold text-decoration-none p-0 mt-3 small" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                        + Change Address
                    </button> --}}
                    <a href="{{ route('profile') }}"
                        class="btn btn-link text-calor fw-bold text-decoration-none p-0 mt-3 small">
                            + Change Address
                    </a>
                </div>

                <div class="yp-checkout-section shadow-sm">
                    <div class="yp-section-title"><i class="bi bi-truck"></i> Shipping Method</div>
                    <div class="yp-shipping-card shadow-sm">
                        <i class="bi bi-rocket-takeoff-fill fs-3 text-calor"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Shiprocket (Standard Service)</h6>
                            <small class="text-muted">Direct Delivery within 24 Hours</small>
                        </div>
                        <div class="ms-auto text-success fw-bold">FREE</div>
                    </div>
                </div>

                <div class="yp-checkout-section shadow-sm">
                    <div class="yp-section-title"><i class="bi bi-credit-card-fill"></i> Select Payment</div>
                    <div class="yp-payment-option">
                        <input type="radio" name="pay" id="razorpay" checked>
                        <label for="razorpay" class="flex-grow-1 d-flex align-items-center mb-0 ms-2">
                            <span class="fw-bold me-2">Razorpay</span>
                            <small class="text-muted">(UPI, Cards, Netbanking)</small>
                        </label>
                    </div>
                    <div class="yp-payment-option">
                        <input type="radio" name="pay" id="cod">
                        <label for="cod" class="flex-grow-1 fw-bold mb-0 ms-2">Cash on Delivery</label>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="yp-summary-sticky shadow-sm">
                    <h5 class="fw-bold mb-4">Order Summary</h5>

                    <div class="yp-offer-applied">
                        <i class="bi bi-patch-check-fill text-success fs-5"></i>
                        <div class="flex-grow-1">
                            @if(!empty($coupon) && isset($coupon['code']))
                                <div class="yp-offer-text">{{ $coupon['code'] }} Applied</div>
                            @endif
                            <small class="text-muted">You saved ₹{{ number_format($discount, 2) }} on this order!</small>
                        </div>
                        <!-- <button class="btn btn-sm text-calor fw-bold p-0" style="font-size: 0.7rem;">REMOVE</button> -->
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal </span>
                        <!-- <span class="fw-bold text-decoration-line-through text-muted small me-2">₹729.00</span> -->
                        <span class="fw-bold">₹{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">@if(!empty($coupon) && isset($coupon['code']))
                            Discount ({{ $coupon['code'] }})
                        @else
                            Discount
                        @endif</span>
                        <span class="yp-discount-line">- ₹{{ number_format($discount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Rocket Shipping</span>
                        <span class="text-success fw-bold">FREE</span>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 fw-bold mb-0">Total Payable</span>
                        <span class="h4 fw-extrabold mb-0 text-calor">₹{{ number_format($total, 2) }}</span>
                    </div>

                    <button class="yp-btn-pay" onclick="handlePayment()">Pay Now</button>

                    <p class="text-center small text-muted mt-3">
                        <i class="bi bi-shield-lock-fill me-1"></i> Razorpay Secure Payments
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addAddressModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 28px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="fw-bold">Add New Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="newAddressForm">
                        <label class="yp-form-label">Full Name</label>
                        <input type="text" class="yp-form-input" required>
                        <label class="yp-form-label">Mobile Number</label>
                        <input type="tel" class="yp-form-input" placeholder="+91" required>
                        <label class="yp-form-label">Address</label>
                        <textarea class="yp-form-input" rows="2" required></textarea>
                        <button type="submit" class="yp-btn-pay py-3">Save Address</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
