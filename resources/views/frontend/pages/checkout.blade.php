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
                                <input type="radio" name="addr" value="{{ $user_delivery_address->id }}" checked>
                                <small class="text-muted d-block">{{ $user_delivery_address->address }}</small>
                                <small class="text-muted d-block">{{ $user_delivery_address->city }}</small>
                                <small class="text-muted d-block">{{ $user_delivery_address->state }} -
                                    {{ $user_delivery_address->pincode }}</small>
                                <small class="fw-bold d-block mt-2">{{$user_delivery_address->mobile }}</small>
                            </label>
                        </div>
                    </div>
                    {{-- <button class="btn btn-link text-calor fw-bold text-decoration-none p-0 mt-3 small"
                        data-bs-toggle="modal" data-bs-target="#addAddressModal">
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
                        <input type="radio" name="payment_method" value="razorpay" id="razorpay" checked>
                        <label for="razorpay" class="flex-grow-1 d-flex align-items-center mb-0 ms-2">
                            <span class="fw-bold me-2">Razorpay</span>
                            <small class="text-muted">(UPI, Cards, Netbanking)</small>
                        </label>
                    </div>

                    <div class="yp-payment-option">
                        <input type="radio" name="payment_method" value="cod" id="cod">
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
                        <span class="text-muted">GST (18 %) </span>
                        <!-- <span class="fw-bold text-decoration-line-through text-muted small me-2">₹729.00</span> -->
                        <span class="fw-bold">₹{{ number_format($gst_total, 2) }}</span>
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

                    <button type="button" class="yp-btn-pay" onclick="handlePayment()">Pay Now</button>

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
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            const codOrderUrl = "{{ route('cod.order') }}";
            const csrfToken = "{{ csrf_token() }}";
            const razorpayOrderUrl = "{{ route('razorpay.create.order') }}";
            const paymentSaveUrl = "{{ route('payment.save') }}";
            function handlePayment() {

                // Get selected payment method
                const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
                const addressInput = document.querySelector('input[name="addr"]:checked');
                const addressId = addressInput ? addressInput.value : null;

                if (!addressId) {
                    Swal.fire("Error", "Please select delivery address", "error");
                    return;
                }

                // Collect order summary data
                const subtotal = {{ $subtotal }};
                const discount = {{ $discount }};
                const total = {{ $total }};
                const couponCode = "{{ $coupon['code'] ?? '' }}";

                // Prepare payload
                const payload = {
                    address_id: addressId,
                    subtotal: subtotal,
                    discount: discount,
                    total: total,
                    coupon_code: couponCode
                };

                // COD Flow
                if (paymentMethod === 'cod') {
                    Swal.fire({
                        title: "Confirm Order?",
                        text: "Are you sure you want to place this order with Cash on Delivery?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#198754",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, Place Order"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(codOrderUrl, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": csrfToken,
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify(payload)
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.status) {
                                        Swal.fire({
                                            icon: "success",
                                            title: "Order Placed!",
                                            text: "Your order has been placed successfully.",
                                            confirmButtonColor: "#198754"
                                        }).then(() => {
                                            window.location.href = data.redirect;
                                        });
                                    } else {
                                        Swal.fire("Error", data.message, "error");
                                    }
                                })
                                .catch(err => {
                                    Swal.fire("Error", "Server error occurred.", "error");
                                    console.error(err);
                                });
                        }
                    });
                }
                // Razorpay Flow
                else if (paymentMethod === 'razorpay') {

                    fetch(razorpayOrderUrl, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(payload)
                    })
                        .then(res => res.json())
                        .then(data => {

                            if (!data.status) {
                                Swal.fire("Error", data.message, "error");
                                return;
                            }

                            var options = {
                                key: data.key,
                                amount: data.amount,
                                currency: "INR",
                                name: "Your Company Name",
                                description: "Order Payment",
                                order_id: data.razorpay_order_id,

                                handler: function (response) {

                                    fetch(paymentSaveUrl, {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json",
                                            "X-CSRF-TOKEN": csrfToken
                                        },
                                        body: JSON.stringify({
                                            order_ids: data.order_ids, // ✅ FIXED
                                            amount: data.amount,
                                            razorpay_payment_id: response.razorpay_payment_id,
                                            razorpay_order_id: response.razorpay_order_id,
                                            razorpay_signature: response.razorpay_signature
                                        })
                                    })
                                        .then(res => res.json())
                                        .then(result => {

                                            if (result.status === 'success') {

                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Payment Successful!',
                                                    confirmButtonColor: '#28a745'
                                                }).then(() => {
                                                    window.location.href = result.redirect;
                                                });

                                            } else {
                                                Swal.fire("Error", result.message, "error");
                                            }

                                        });

                                },

                                theme: {
                                    color: "#dc3545"
                                }
                            };

                            var rzp1 = new Razorpay(options);
                            rzp1.open();

                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire("Error", "Something went wrong", "error");
                        });

                }
            }
        </script>
    @endpush

@endsection