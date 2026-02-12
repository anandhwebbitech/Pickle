@extends('frontend.layouts.app')
@section('content')


<div class="mx-3 my-4">
    <div class="swiper bannerSwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="banner-content" style="background-image: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)), url('./asset/img/garlic.webp');">
                    <div class="container px-5 text-white">
                       
                    </div>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="banner-content" style="background-image: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)), url('./asset/img/mango.webp');">
                    <div class="container px-5 text-white">
                   
                    </div>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="banner-content" style="background-image: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)), url('./asset/img/lemon.webp');">
                    <div class="container px-5 text-white">
                   
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

<section class="container my-5 pt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 px-3">
        <div>
            <h2 class="fw-bold mb-0">Our <span style="color:#5E0E3C;">Collections</span></h2>
            <p class="text-muted small">Pure, Authentic & Handcrafted</p>
        </div>
        <div class="d-flex gap-2">
            <div id="p-prev" class="action-icon shadow-sm" style="cursor:pointer;"><i class="bi bi-chevron-left"></i></div>
            <div id="p-next" class="action-icon shadow-sm" style="cursor:pointer;"><i class="bi bi-chevron-right"></i></div>
        </div>
    </div>

    <div class="swiper productSwiper" id="mainSlider">
        <div class="swiper-wrapper">
            @foreach($products as $product)
            <div class="swiper-slide">
                <div class="product-card p-3 border shadow-sm bg-white">

                    <div class="img-container mb-3">
                        @php
                            $isInWishlist = in_array($product->id, $wishlistIds ?? []);
                        @endphp
                        <button class="save-btn {{ $isInWishlist ? 'active' : '' }}" onclick="toggleSave(this)"data-id="{{ $product->id }}">
                            <i class="bi {{ $isInWishlist ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                        </button>

                        {{-- Main Image --}}
                        <img src="{{ asset('public/uploads/products/'.$product->image) }}" class="img-main">

                        {{-- Optional Hover Image --}}
                        @if($product->image)
                        <img src="{{ asset('public/uploads/products/'.$product->image) }}" class="img-hover">
                        @endif

                        <div class="view-overlay">
                            <a href="{{ route('product-details', $product->id) }}"
                                class="btn btn-light rounded-pill btn-sm fw-bold shadow-sm px-3">
                                View Product
                            </a>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-1">{{ $product->name }}</h6>

                    <p class="text-muted small mb-3">
                        {{ $product->short_description ?? 'Authentic & Handmade' }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold fs-5 text-calor">
                            @php
                            $prices = json_decode($product->weight, true);
                            @endphp

                            @if(!empty($prices))
                            ₹{{ number_format($prices[0]['price'], 2) }}
                            @endif
                            <!-- ₹{{ number_format($product->price, 2) }} -->
                        </span>

                        <div class="qty-pill">
                            <span class="qty-btn" onclick="updateQty(this, -1)">-</span>
                            <span class="local-qty fw-bold">1</span>
                            <span class="qty-btn" onclick="updateQty(this, 1)">+</span>
                        </div>
                    </div>

                    <button class="btn btn-dark w-100 rounded-pill mt-3 py-2 fw-bold"
                        onclick="handleCartClick(this)"
                        data-id="{{ $product->id }}"data-url="{{ route('cart.add', $product->id) }}">
                        Add to Cart
                    </button>

                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>

<section class="container my-5 px-3 px-lg-0">
    <div class="row g-4">

        <div class="col-lg-5 d-flex flex-column gap-4">

            <div class="yummy-bento-card bento-beige text-center">
                <div class="promo-content mx-auto">
                    <span class="badge-label">100% Pure</span>
                    <h4 class="fw-bold mt-2">Wood Pressed <br>Nutrient Rich Oils used Pickle</h4>
                    <p class="small text-muted mb-3">Traditional extraction for authentic health.</p>
                    <a href="product-list.php" class="btn-yummy-outline-sm">Explore More</a>
                </div>
                <img src="asset/img/product/garlic-pro.png" class="bento-asset-bottom" alt="Oils">
            </div>

            <div class="yummy-bento-card bento-grey text-center">
                <div class="promo-content mx-auto">
                    <span class="badge-label">Wild Harvest</span>
                    <h4 class="fw-bold mt-2">Raw Forest <br>Organic Garlic</h4>
                    <p class="small text-muted mb-3">Unprocessed Pickle</p>
                    <a href="product-list.php" class="btn-yummy-outline-sm">Explore More</a>
                </div>
                <img src="asset/img/product/garlic-pro.png" class="bento-asset-bottom" alt="Honey">
            </div>
        </div>

        <div class="col-lg-7">
            <div class="yummy-bento-card bento-main-red text-center">
                <div class="promo-content text-white mx-auto">
                    <span class="badge-label bg-white text-calor">Bestseller</span>
                    <h2 class="display-5 fw-bold mt-3 mb-3">Traditional <br>Homemade Pickles</h2>
                    <p class="mb-4 opacity-90 mx-auto" style="max-width: 80%;">Experience the spicy, tangy, and authentic taste of South Indian heritage in every jar.</p>
                    <a href="product-list.php" class="btn btn-light rounded-pill px-5 py-2 fw-bold text-calor shadow-sm">
                        Shop All Pickles
                    </a>
                </div>
                <img src="asset/img/product/mango-pro.png" class="bento-asset-center" alt="Pickle Jar">
            </div>
        </div>

    </div>
</section>


<section class="container my-5 pt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 px-3">
        <div>
            <h2 class="fw-bold mb-0">Trending <span style="color:#5E0E3C;">Deals</span></h2>
            <p class="text-muted small">Pure, Authentic & Handcrafted</p>
        </div>
        <div class="d-flex gap-2">
            <div id="p-prev-2" class="action-icon shadow-sm" style="cursor:pointer;"><i class="bi bi-chevron-left"></i></div>
            <div id="p-next-2" class="action-icon shadow-sm" style="cursor:pointer;"><i class="bi bi-chevron-right"></i></div>
        </div>
    </div>

    <div class="swiper trendingSwiper" id="trendingSlider">
        <div class="swiper-wrapper">

            @foreach($products as $product)
            <div class="swiper-slide">
                <div class="product-card p-3 border shadow-sm bg-white">

                    <div class="img-container mb-3">
                        @php
                            $isInWishlist = in_array($product->id, $wishlistIds ?? []);
                        @endphp
                        <button class="save-btn {{ $isInWishlist ? 'active' : '' }}" onclick="toggleSave(this)"data-id="{{ $product->id }}">
                            <i class="bi {{ $isInWishlist ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                        </button>

                        {{-- Product Image --}}
                        <img src="{{ asset('public/uploads/products/'.$product->image) }}" class="img-main">

                        {{-- Optional Hover Image --}}
                        @if(!empty($product->image))
                        <img src="{{ asset('public/uploads/products/'.$product->image) }}" class="img-hover">
                        @endif

                        <div class="view-overlay">
                            <a href="#"
                                class="btn btn-light rounded-pill btn-sm fw-bold shadow-sm px-3">
                                View Product
                            </a>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-1">{{ $product->name }}</h6>

                    <p class="text-muted small mb-3">
                        {{ $product->short_description ?? 'Pure & Authentic' }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center">

                        {{-- First Price from JSON --}}
                        @php
                        $prices = json_decode($product->weight, true);
                        @endphp

                        @if(!empty($prices))
                        ₹{{ number_format($prices[0]['price'], 2) }}
                        @endif

                        <div class="qty-pill">
                            <span class="qty-btn" onclick="updateQty(this, -1)">-</span>
                            <span class="local-qty fw-bold">1</span>
                            <span class="qty-btn" onclick="updateQty(this, 1)">+</span>
                        </div>
                    </div>

                    <button class="btn btn-dark w-100 rounded-pill mt-3 py-2 fw-bold"
                        onclick="handleCartClick(this)"
                        data-id="{{ $product->id }}" data-url="{{ route('cart.add', $product->id) }}">
                        Add to Cart
                    </button>

                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>

<section class="container my-5 pt-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold display-6">
            The <span style="color:#5E0E3C; border-bottom: 3px solid #5E0E3C; border-radius: 10px;">Pickle Promise</span>
            We Deliver
        </h2>
    </div>

    <div class="row g-4 justify-content-center">

        <div class="col-6 col-md-4 col-lg">
            <div class="benefit-card text-center">
                <div class="benefit-icon-wrapper">
                    <i class="bi bi-fire"></i>
                </div>
                <h6 class="fw-bold mt-3 mb-2">Authentic Spiciness</h6>
                <p class="text-muted smaller">Bold heat inspired by traditional South Indian recipes.</p>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg">
            <div class="benefit-card text-center">
                <div class="benefit-icon-wrapper">
                    <i class="bi bi-droplet-half"></i>
                </div>
                <h6 class="fw-bold mt-3 mb-2">Cold-Pressed Oils</h6>
                <p class="text-muted smaller">Made using gingelly oil for rich aroma & taste.</p>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg">
            <div class="benefit-card text-center">
                <div class="benefit-icon-wrapper">
                    <i class="bi bi-sun"></i>
                </div>
                <h6 class="fw-bold mt-3 mb-2">Sun-Dried Process</h6>
                <p class="text-muted smaller">Naturally matured for deep, lasting flavor.</p>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg">
            <div class="benefit-card text-center">
                <div class="benefit-icon-wrapper">
                    <i class="bi bi-house"></i>
                </div>
                <h6 class="fw-bold mt-3 mb-2">Homemade Style</h6>
                <p class="text-muted smaller">Prepared in small batches with care.</p>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg">
            <div class="benefit-card text-center">
                <div class="benefit-icon-wrapper">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h6 class="fw-bold mt-3 mb-2">Pure & Preservative-Free</h6>
                <p class="text-muted smaller">No artificial colors or chemicals.</p>
            </div>
        </div>

    </div>
</section>


<section class="container my-5 pt-4">
    <div class="text-center mb-5">
        <span class="badge-label mb-2">#YummyShorts</span>
        <h2 class="fw-bold">Watch Our <span style="color:#5E0E3C;">Shorts</span></h2>
        <p class="text-muted small">Quick bites of tradition and heritage</p>
    </div>

    <div class="row g-3">
        <div class="col-6 col-md-3">
            <div class="yt-shorts-card shadow-sm">
                <div class="shorts-wrapper">
                    <iframe
                        src="https://www.youtube.com/embed/d38xWWg62LY?si=7ERlPLT4Mzb6MZ-1"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="yt-shorts-card shadow-sm">
                <div class="shorts-wrapper">
                    <iframe
                       src="https://www.youtube.com/embed/d38xWWg62LY?si=7ERlPLT4Mzb6MZ-1"
                        frameborder="0"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="yt-shorts-card shadow-sm">
                <div class="shorts-wrapper">
                    <iframe
                        src="https://www.youtube.com/embed/d38xWWg62LY?si=7ERlPLT4Mzb6MZ-1"
                        frameborder="0"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="yt-shorts-card shadow-sm">
                <div class="shorts-wrapper">
                    <iframe
                        src="https://www.youtube.com/embed/d38xWWg62LY?si=7ERlPLT4Mzb6MZ-1"
                        frameborder="0"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container my-5 pt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 px-3">
        <div>
            <h2 class="fw-bold mb-0">South Indian <span style="color:#5E0E3C;">Pickles</span></h2>
            <p class="text-muted small">Traditional Flavors from Grandma's Kitchen</p>
        </div>
        <div class="d-flex gap-2">
            <div id="p-prev-3" class="action-icon shadow-sm" style="cursor:pointer;"><i class="bi bi-chevron-left"></i></div>
            <div id="p-next-3" class="action-icon shadow-sm" style="cursor:pointer;"><i class="bi bi-chevron-right"></i></div>
        </div>
    </div>

    <div class="swiper pickleSwiper" id="pickleSlider">
        <div class="swiper-wrapper">
            @foreach($products as $product)
            @php
            $prices = json_decode($product->weight, true);
            @endphp

            <div class="swiper-slide">
                <div class="product-card p-3 border shadow-sm bg-white">

                    <div class="img-container mb-3">
                        @php
                            $isInWishlist = in_array($product->id, $wishlistIds ?? []);
                        @endphp
                        <button class="save-btn {{ $isInWishlist ? 'active' : '' }}" onclick="toggleSave(this)"data-id="{{ $product->id }}">
                            <i class="bi {{ $isInWishlist ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                        </button>

                        {{-- Main Image --}}
                        <img src="{{ asset('public/uploads/products/'.$product->image) }}"
                            class="img-main">

                        {{-- Hover Image (optional) --}}
                        @if(!empty($product->image))
                        <img src="{{ asset('public/uploads/products/'.$product->image) }}"
                            class="img-hover">
                        @endif

                        <div class="view-overlay">
                            <a href="#"
                                class="btn btn-light rounded-pill btn-sm fw-bold shadow-sm px-3">
                                View Product
                            </a>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-1">{{ $product->name }}</h6>

                    <p class="text-muted small mb-3">
                        {{ $product->short_description ?? 'Andhra Special' }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center">

                        {{-- First price from JSON --}}
                        <span class="fw-bold fs-5 text-calor">
                            ₹{{ number_format($prices[0]['price'] ?? 0, 2) }}
                        </span>

                        <div class="qty-pill">
                            <span class="qty-btn" onclick="updateQty(this, -1)">-</span>
                            <span class="local-qty fw-bold">1</span>
                            <span class="qty-btn" onclick="updateQty(this, 1)">+</span>
                        </div>
                    </div>

                    <button class="btn btn-dark w-100 rounded-pill mt-3 py-2 fw-bold"
                        onclick="handleCartClick(this)"
                        data-id="{{ $product->id }}" data-url="{{ route('cart.add', $product->id) }}">
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
    function loadProductDetails(productId) {

    fetch("{{ url('/product') }}/" + productId)
    .then(response => response.json())
    .then(data => {

        if (data.status) {

            document.getElementById('product-details-container').innerHTML = data.html;

            // Scroll smoothly to product details
            document.getElementById('product-details-container')
                .scrollIntoView({ behavior: "smooth" });

        }

    })
    .catch(error => {
        console.log(error);
        alert("Something went wrong");
    });
}
</script>
@endpush
@endsection