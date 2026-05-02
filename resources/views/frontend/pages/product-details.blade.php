@extends('frontend.layouts.app')
@section('content')

    <section class="py-5" style="background-color: #fcf9f4;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-2">
                            <li class="breadcrumb-item"><a href="index.html"
                                    class="text-muted text-decoration-none small">Home</a></li>
                            <!-- <li class="breadcrumb-item"><a href="#" class="text-muted text-decoration-none small">Shop</a></li> -->
                            <li class="breadcrumb-item active small text-danger fw-bold" aria-current="page">Products</li>
                        </ol>
                    </nav>

                    <h1 class="display-5 fw-bold text-dark mb-0">Our <span style="color: #dc3545;">Products</span></h1>
                    <div class="mx-auto mt-2"
                        style="width: 60px; height: 3px; background-color: #dc3545; border-radius: 2px;"></div>

                </div>
            </div>
        </div>
    </section>

    <section class="container pb-5">
        <div class="product-main-container p-4 p-md-5">
            <div class="row g-5">

                <div class="col-lg-6">
                    <div class="swiper main-swiper">

                        <div class="swiper-wrapper">

                            @foreach($images as $img)

                                <div class="swiper-slide text-center">
                                    <img src="{{ asset('public/uploads/products/' . $img) }}" class="img-fluid">
                                </div>

                            @endforeach

                        </div>

                        <div class="swiper-button-next text-danger"></div>
                        <div class="swiper-button-prev text-danger"></div>

                    </div>
                    <div thumbsSlider="" class="swiper thumb-swiper">

                        @php
                            // Decode images
                            $images = is_array($product->image)
                                ? $product->image
                                : (is_string($product->image)
                                    ? json_decode($product->image, true)
                                    : [$product->image]);

                            // Ensure array
                            $images = $images ?: [];
                        @endphp

                        <div class="swiper-wrapper">

                            @foreach($images as $img)

                                <div class="swiper-slide">
                                    <img src="{{ asset('public/uploads/products/' . $img) }}" alt="Product Image">
                                </div>

                            @endforeach

                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <p class="text-danger fw-bold small mb-1">Yummy Pickle</p>
                    <h1 class="fw-bold mb-2">{{$product->name}}</h1>
                    @php
                        $weights = json_decode($product->weight, true);
                    @endphp
                    {{-- <h2 class="fw-bold mb-4">Rs. <span id="price-target">100.00</span></h2> --}}
                    <h2 class="fw-bold mb-4">
                        Rs. <span id="price-target">
                            {{ !empty($weights) ? number_format($weights[0]['price'], 2) : '0.00' }}
                        </span>
                    </h2>

                    <div class="mb-4">
                        <label class="small fw-bold mb-2 d-block text-muted">SELECT WEIGHT</label>
                        <div class="d-flex gap-2">
                            {{-- <button class="btn gram-btn rounded-1 active" onclick="changePrice(this, 100)">100g</button>
                            <button class="btn gram-btn rounded-1" onclick="changePrice(this, 450)">500g</button>
                            <button class="btn gram-btn rounded-1" onclick="changePrice(this, 850)">1kg</button> --}}
                            @foreach($weights as $index => $item)
                                <button 
                                    type="button"
                                    class="btn gram-btn rounded-1 {{ $index == 0 ? 'active' : '' }}"
                                    data-price="{{ $item['price'] }}"
                                    data-weight="{{ $item['weight'] }}"
                                    onclick="changePrice(this)">
                                    {{ $item['weight'] }}g
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3 align-items-center mb-5">
                        <div class="qty-horizontal-wrap">
                            <div class="qty-btn" onclick="updateQty(this, -1)">
                                <i class="bi bi-dash"></i>
                            </div>

                            <div class="fw-bold qty-count">1</div>

                            <div class="qty-btn" onclick="updateQty(this, 1)">
                                <i class="bi bi-plus"></i>
                            </div>
                        </div>
                        <button class="btn btn-dark rounded-pill px-5 py-3 fw-bold flex-grow-1 shadow-sm"
                            onclick="handleCartClick(this)"
                            data-id="{{ $product->id }}"data-url="{{ route('cart.add', $product->id) }}">
                            Add to Cart
                        </button>
                        @php
                            $isInWishlist = in_array($product->id, $wishlistIds ?? []);
                        @endphp
                        <button class="wishlist-btn  {{ $isInWishlist ? 'active' : '' }}" onclick="toggleSave(this)"data-id="{{ $product->id }}">
                            <i class="bi {{ $isInWishlist ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                        </button>
                        {{-- <button class="wishlist-btn" onclick="toggleWishlist(this)" title="Add to Wishlist">
                            <i class="bi bi-heart"></i>
                        </button> --}}
                    </div>

                    <div class="pt-4 border-top">
                        <div class="d-flex flex-wrap gap-3 align-items-center">
                            <span class="small fw-bold text-muted">SHARE:</span>
                            <div class="d-flex gap-3 fs-5">
                                <a href="#" onclick="social('fb')" class="text-dark"><i class="bi bi-facebook"></i></a>
                                <a href="#" onclick="social('wa')" class="text-dark"><i class="bi bi-whatsapp"></i></a>
                            </div>
                            <button onclick="copyToClipProduct()" class="btn btn-sm btn-outline-dark rounded-pill px-3 ms-md-auto"
                                id="clip-btn">
                                <i class="bi bi-link-45deg"></i> Copy Link
                            </button>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h5 class="fw-bold mb-3">Product Description</h5>
                        <p class="text-muted lh-lg mb-5">
                            {{ $product->description }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="row mt-5 pt-5 border-top">
                <div class="col-lg-8">

                    <h6 class="fw-bold small mb-3 text-uppercase">Contains:</h6>
                    <div class="row">
                        @php
                            $chunks = array_chunk($contains, ceil(count($contains) / 2));
                        @endphp
                        @foreach($chunks as $chunk)
                            <div class="col-md-6">
                                <ul class="list-unstyled text-muted small lh-lg">
                                    @foreach($chunk as $item)
                                        <li>
                                            <i class="bi bi-check2 text-danger"></i> {{ $item }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="p-4 rounded-4" style="border: 1px dashed #d1d1d1; background: #fafafa;">
                        <h6 class="fw-bold small mb-3 text-uppercase">Secure Checkout</h6>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <img src="{{ asset('asset/img/applepay.png') }}" class="pay-img" alt="Apple Pay">
                            <img src="{{ asset('asset/img/phonepe.png') }}" class="pay-img" alt="PhonePe">
                            <img src="{{ asset('asset/img/gpay.png') }}" class="pay-img" alt="Google Pay">
                            <img src="{{ asset('asset/img/paytm.png') }}" class="pay-img" alt="Paytm">
                        </div>
                        <p class="text-muted mb-0 small" style="font-size: 0.75rem;">SSL Secure Encryption</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="my-5">
        <div class="container">
            <h3 class="my-4">Related Products</h3>

            <div class="row g-4">

                @foreach($related_products as $related)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="product-card p-3 border shadow-sm bg-white">

                            <div class="img-container mb-3 position-relative">

                                @if($related->discount)
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2" style="z-index: 5;">
                                        {{ $related->discount }}%
                                    </span>
                                @endif

                                {{-- <button class="save-btn" onclick="toggleSave(this)">
                                    <i class="bi bi-heart"></i>
                                </button> --}}
                                @php
                                    $isInWishlist = in_array($related->id, $wishlistIds ?? []);
                                @endphp
                                <button class="save-btn {{ $isInWishlist ? 'active' : '' }}" onclick="toggleSave(this)"data-id="{{ $related->id }}">
                                    <i class="bi {{ $isInWishlist ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                                </button>
                                @php
                                    // Default image if array is empty
                                    $defaultImage = $related->image;

                                    // Decode JSON string if needed
                                    $images = is_array($related->image) 
                                                ? $related->image 
                                                : (is_string($related->image) ? json_decode($related->image, true) : [$product->image]);

                                    // Ensure $images is an array
                                    $images = $images ?: [];

                                    // Get main and hover images with fallback
                                    $mainImage = $images[0] ?? $defaultImage;
                                    $hoverImage = $images[1] ?? $defaultImage;
                                @endphp


                                <!-- Product Image -->
                                <img src="{{ asset('public/uploads/products/' . $mainImage) }}" class="img-main">
                                <img src="{{ asset('public/uploads/products/' . $hoverImage) }}" class="img-hover">


                                <div class="view-overlay">
                                    <a href="{{ route('product-details', $related->id) }}"
                                        class="btn btn-light rounded-pill btn-sm fw-bold shadow-sm px-3">
                                        View Product
                                    </a>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-1">{{ $related->name }}</h6>

                            <p class="text-muted small mb-3">
                                {{ $related->short_description ?? 'Delicious & Traditional' }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold fs-5 text-danger">
                                        @php
                                            $prices = json_decode($related->weight, true);
                                        @endphp
                                        @if(!empty($prices))
                                        ₹{{ number_format($prices[0]['price'], 2) }}
                                        @endif
                                    </span>

                                    @if($related->mrp)
                                        <small class="text-muted text-decoration-line-through ms-1">
                                            ₹{{ $related->mrp }}
                                        </small>
                                    @endif
                                </div>
                                <div class="qty-pill">
                                    <span class="qty-btn" onclick="updateRelatedQty(this, -1)">-</span>
                                    <span class="local-qty fw-bold">1</span>
                                    <span class="qty-btn" onclick="updateRelatedQty(this, 1)">+</span>
                                </div>
                                
                            </div>
                            @php
                                $prices = json_decode($product->weight, true);
                                $firstWeight = $prices[0]['weight'] ?? null;
                                $firstPrice  = $prices[0]['price'] ?? 0;
                            @endphp
                            <button class="btn btn-dark w-100 rounded-pill mt-3 py-2 fw-bold"
                                onclick="handleCartClick(this)"
                                data-id="{{ $related->id }}"data-url="{{ route('cart.add', $related->id) }}"
                                data-weight="{{ $firstWeight }}"
                                data-price="{{ $firstPrice }}">
                                Add to Cart
                            </button>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@push('scripts')
<script>
// function handleCartClick(btn) {

//     let productId = btn.dataset.id;
//     let url = btn.dataset.url;

//     // Get active weight button
//     let activeWeightBtn = document.querySelector(".gram-btn.active");

//     if (!activeWeightBtn) {
//         alert("Please select weight");
//         return;
//     }

//     let weight = activeWeightBtn.getAttribute("data-weight");
//     let price = activeWeightBtn.getAttribute("data-price");

//     // Get quantity
//     let qty = document.querySelector(".qty-count").innerText;

//     fetch(url, {
//         method: "POST",
//         headers: {
//             "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
//             "Content-Type": "application/json",
//             "Accept": "application/json"
//         },
//         body: JSON.stringify({
//             product_id: productId,
//             weight: weight,
//             price: price,
//             quantity: qty
//         })
//     })
//     .then(res => res.json())
//     .then(data => {

//         if (data.status) {

//             // Update cart badge
//             let badge = document.querySelector(".cart-link .badge");
//             if (badge) badge.innerText = data.count;

//             btn.innerHTML = `<i class="bi bi-check-circle me-2"></i> Added`;
//             btn.classList.remove("btn-dark");
//             btn.classList.add("btn-success");

//             setTimeout(() => {
//                 btn.innerHTML = "Add to Cart";
//                 btn.classList.remove("btn-success");
//                 btn.classList.add("btn-dark");
//             }, 2000);

//         } else {
//             alert(data.message || "Something went wrong");
//         }

//     })
//     .catch(error => {
//         console.error(error);
//         alert("Server error");
//     });
// }
function handleCartClick(btn) {

    let productId = btn.dataset.id;
    let url = btn.dataset.url;

    let weight, price, qty;

    // ✅ Check if button is inside related product card
    let productCard = btn.closest('.product-card');

    if (productCard) {

        // 🔥 RELATED PRODUCT
        weight = btn.dataset.weight;
        price  = btn.dataset.price;

        let qtyElement = productCard.querySelector('.local-qty');
        qty = qtyElement ? qtyElement.innerText : 1;

    } else {

        // 🔥 MAIN PRODUCT
        let activeWeightBtn = document.querySelector(".gram-btn.active");

        if (!activeWeightBtn) {
            alert("Please select weight");
            return;
        }

        weight = activeWeightBtn.getAttribute("data-weight");
        price  = activeWeightBtn.getAttribute("data-price");

        let qtyElement = document.querySelector(".qty-count");
        qty = qtyElement ? qtyElement.innerText : 1;
    }

    // 🔥 Send data to backend
    fetch(url, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({
            product_id: productId,
            weight: weight,
            price: price,
            quantity: qty
        })
    })
    .then(res => res.json())
    .then(data => {

        if (data.status) {

            let badge = document.querySelector(".cart-link .badge");
            if (badge) badge.innerText = data.count;

            btn.innerHTML = `<i class="bi bi-check-circle me-2"></i> Added`;
            btn.classList.remove("btn-dark");
            btn.classList.add("btn-success");
            loadNavbarCart();

            setTimeout(() => {
                btn.innerHTML = "Add to Cart";
                btn.classList.remove("btn-success");
                btn.classList.add("btn-dark");
            }, 2000);

        } else {
            alert(data.message || "Something went wrong");
        }

    })
    .catch(error => {
        console.error(error);
        alert("Server error");
    });
}


function toggleSave(btn) {

    let productId = btn.getAttribute("data-id");

    fetch("{{ route('toggle.wishlist', ':id') }}".replace(':id', productId), {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {

        const icon = btn.querySelector("i");

        if (data.added) {
            btn.classList.add("active");
            icon.classList.remove("bi-heart");
            icon.classList.add("bi-heart-fill", "text-danger");
        } else {
            btn.classList.remove("active");
            icon.classList.remove("bi-heart-fill", "text-danger");
            icon.classList.add("bi-heart");
        }

        let badge = document.querySelector(".wishlist-link .badge");
        if (badge) {
            badge.innerText = data.count;
        }

    })
    .catch(err => console.log(err));
}
function changePrice(btn) {

    // Remove active class from all
    document.querySelectorAll(".gram-btn").forEach(el => {
        el.classList.remove("active");
    });

    // Add active to clicked
    btn.classList.add("active");

    // Get price from data attribute
    let newPrice = btn.getAttribute("data-price");

    // Update price text
    document.getElementById("price-target").innerText =
        parseFloat(newPrice).toFixed(2);
         // ✅ Reset quantity to 1
    document.querySelectorAll(".qty-count").forEach(el => {
        el.innerText = 1;
    });
}
function updateQty(btn, change) {

    // Find quantity element inside same wrapper
    let wrapper = btn.closest(".qty-horizontal-wrap");
    let qtyElement = wrapper.querySelector(".qty-count");

    let qty = parseInt(qtyElement.innerText);
    qty += change;

    if (qty < 1) qty = 1;

    qtyElement.innerText = qty;
}
function updateRelatedQty(btn, change) {

    let wrapper = btn.closest('.qty-pill');
    if (!wrapper) return;

    let qtyElement = wrapper.querySelector('.local-qty');
    if (!qtyElement) return;

    let qty = parseInt(qtyElement.innerText);
    qty += change;

    if (qty < 1) qty = 1;

    qtyElement.innerText = qty;
}

function copyToClipProduct() {
    const url = window.location.href;

    navigator.clipboard.writeText(url).then(function() {
        const btn = document.getElementById("clip-btn");
        btn.innerHTML = "✅ Copied!";
        
        setTimeout(() => {
            btn.innerHTML = '<i class="bi bi-link-45deg"></i> Copy Link';
        }, 2000);
    }).catch(function(err) {
        alert("Failed to copy!");
    });
}

var thumbsSwiper = new Swiper(".thumb-swiper", {
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
});

var mainSwiper = new Swiper(".main-swiper", {
    spaceBetween: 10,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    thumbs: {
        swiper: thumbsSwiper,
    },
});
</script>
@endpush

@endsection