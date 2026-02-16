@extends('frontend.layouts.app')
@section('content')

<div class="container">
    <div class="yp-step-indicator">
        <span class="yp-step active">01 Cart</span>
        <span class="yp-step">02 Checkout</span>
    </div>

    <div class="row yp-cart-wrapper g-4">
        <div class="col-lg-8" id="cart-container">
            <h4 class="fw-bold mb-4">Shopping Bag</h4>

            <!-- <div class="yp-cart-item shadow-sm">
                    <img src="asset/img/product/pro-1.webp" class="yp-item-thumb" alt="Product">
                    <div class="yp-item-details">
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="yp-item-name">Handmade Mango Pickle</span>
                            <i class="bi bi-trash3 yp-btn-remove" title="Remove Item"></i>
                        </div>
                        <span class="yp-item-spec">Volume: 500ml | Spicy Level: High</span>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="yp-qty-pill">
                                    <button class="yp-qty-btn" onclick="this.nextElementSibling.innerText--">-</button>
                                    <span class="yp-qty-num">1</span>
                                    <button class="yp-qty-btn" onclick="this.previousElementSibling.innerText++">+</button>
                                </div>

                                <a href="product-details.php" class="yp-btn-view-only" title="View Product">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>

                            <span class="yp-item-price">₹249.00</span>
                        </div>
                    </div>
                </div>

                <div class="yp-cart-item shadow-sm">
                    <img src="asset/img/product/pro-1.webp" class="yp-item-thumb" alt="Product">
                    <div class="yp-item-details">
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="yp-item-name">Handmade Mango Pickle</span>
                            <i class="bi bi-trash3 yp-btn-remove" title="Remove Item"></i>
                        </div>
                        <span class="yp-item-spec">Volume: 500ml | Spicy Level: High</span>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="yp-qty-pill">
                                    <button class="yp-qty-btn" onclick="this.nextElementSibling.innerText--">-</button>
                                    <span class="yp-qty-num">1</span>
                                    <button class="yp-qty-btn" onclick="this.previousElementSibling.innerText++">+</button>
                                </div>

                                <a href="product-details.php" class="yp-btn-view-only" title="View Product">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>

                            <span class="yp-item-price">₹249.00</span>
                        </div>
                    </div>
                </div> -->



            <div class="mt-4">
                <a href="#" class="text-decoration-none text-dark fw-bold small">
                    <i class="bi bi-arrow-left me-2"></i> Keep Shopping for Pickles
                </a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="yp-summary-card shadow-sm">
                <div class="yp-summary-title">Order Summary</div>

                <div class="yp-summary-line subtotal">
                    <p class="text-muted">Subtotal</p>
                    <span>₹00.00</span>
                </div>
                <div class="yp-summary-line gst">
                    <p class="text-muted">GST (18 %)</p>
                    <span class="text-success fw-bold">18 %</span>
                </div>
                <div class="yp-summary-line delivery">
                    <p class="text-muted">Standard Delivery</p>
                    <span class="text-success fw-bold">FREE</span>
                </div>

                <div class="yp-promo-box d-flex align-items-center justify-content-between mt-4">
                    <input type="text" class="yp-promo-input" placeholder="DISCOUNT CODE">
                    <button class="btn btn-sm btn-dark rounded-pill px-3 py-1 fw-bold"
                        style="font-size: 0.7rem;">APPLY</button>
                </div>

                <div class="yp-summary-line total  yp-summary-total">
                    <p>Total Amount</p>
                    <span>₹609.00</span>
                </div>

                <a href="{{route('checkout')}}"><button class="yp-btn-checkout mt-4">Checkout & Pay</button></a>
                <!-- <a href="{{route('checkout')}}" class="yp-btn-checkout mt-4"> Checkout & Pay</a> -->
                <p class="text-center small text-muted mt-3 mb-0">
                    <i class="bi bi-lock-fill me-1"></i> 100% Encrypted Transactions
                </p>
            </div>
        </div>
    </div>
</div>
@push('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    window.loadCart = function() {
        $.ajax({
            url: "{{ route('cart.items') }}",
            method: "GET",
            success: function(res) {
                $('#cart-container').html('<h4 class="fw-bold mb-4">Shopping Bag</h4>' + res
                    .html);
                $('.yp-summary-line.subtotal span').text('₹' + res.subtotal.toFixed(2));
                $('.yp-summary-line.delivery span').text(res.delivery === 0 ? 'FREE' : '₹' + res
                    .delivery.toFixed(2));
                $('.yp-summary-line.gst span').text('₹' + res.gst_total.toFixed(2));
                $('.yp-summary-line.total span').text('₹' + res.total.toFixed(2));
            }
        });
    };

    loadCart();
    loadNavbarCart();

});
$(document).ready(function() {
    loadCart();
    // Remove item
    $(document).on('click', '.yp-btn-remove', function() {
        let id = $(this).data('id');
        $.ajax({
            url: '/cart/remove/' + id,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                loadCart();
            }
        });
    });
});

// Update quantity
function updateQty(el, cartId, change) {

    let currentCoupon = $('.yp-promo-input').val('');
    $('.yp-summary-line.discount span:last').text('₹0.00');

    // Find the quantity span
    let qtySpan = $(el).siblings('.yp-qty-num');
    let currentQty = parseInt(qtySpan.text());

    // Calculate new quantity
    let newQty = currentQty + change;
    if (newQty < 1) newQty = 1; // prevent negative or zero

    // Update the quantity text immediately
    qtySpan.text(newQty);

    // Optional: Update the total price for this item instantly
    let itemPrice = parseInt($(el).closest('.yp-cart-item').find('.yp-item-price').text().replace('₹', ''));
    let pricePerUnit = itemPrice / currentQty; // old price per unit
    let newTotal = pricePerUnit * newQty;
    $(el).closest('.yp-cart-item').find('.yp-item-price').text('₹' + newTotal.toFixed(2));

    // Send AJAX to backend
    $.ajax({
        url: "{{ route('cart.update', ':id') }}".replace(':id', cartId),
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            change: change
        },
        success: function(res) {
            // Optionally do something after backend update
            console.log('Cart updated successfully');
            loadCart();
        }
    });
}
$(document).on('click', '.yp-btn-remove', function() {
    let cartId = $(this).data('id'); // get cart ID
    let cartItemDiv = $(this).closest('.yp-cart-item'); // the div to remove

    // SweetAlert confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX to remove item
            $.ajax({
                url: "{{ route('cart.remove', ':id') }}".replace(':id', cartId),
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.success) {
                        cartItemDiv.remove(); // remove from UI
                        recalcCartTotal(); // optional: update total
                        loadCart();
                        // SweetAlert success
                        Swal.fire(
                            'Removed!',
                            'Item has been removed from your cart.',
                            'success'
                        );
                    }
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'Failed to remove item. Please try again.',
                        'error'
                    );
                }
            });
        }
    });
});

function recalcCartTotal() {
    let total = 0;
    $('.yp-cart-item').each(function() {
        let price = parseFloat($(this).find('.yp-item-price').text().replace('₹', ''));
        total += price;
    });
    $('#cart-total').text('₹' + total.toFixed(2));
}

$(document).on('click', '.yp-promo-box button', function() {
    let code = $('.yp-promo-input').val().trim();

    if (code == '') {
        Swal.fire('Error', 'Please enter a discount code', 'error');
        return;
    }

    $.ajax({
        url: "{{ route('cart.applyDiscount') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            code: code
        },
        success: function(res) {
            if (res.success) {
                // Update summary dynamically
                $('.yp-summary-line.subtotal span').text('₹' + res.subtotal.toFixed(2));
                if (res.discount) {
                    if ($('.yp-summary-line.discount').length == 0) {
                        $('<div class="yp-summary-line discount"><span>Coupon</span><span>₹' + res
                                .discount.toFixed(2) + '</span></div>')
                            .insertAfter('.yp-summary-line.subtotal');
                    } else {
                        $('.yp-summary-line.discount span:last').text('₹' + res.discount.toFixed(
                        2));
                    }
                }
                $('.yp-summary-line.total span').text('₹' + res.total.toFixed(2));

                Swal.fire('Success', 'Discount applied!', 'success');
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Failed to apply discount', 'error');
        }
    });
});
</script>
@endpush

@endsection