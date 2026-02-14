<style>
    .offcanvas-body{
        background: #5e0e3c;
    }
</style>
<div class="py-2 text-center small fw-bold text-uppercase border-bottom" style="letter-spacing: 2px; font-size: 10px;">
    Pure Quality <span class="text-calor mx-2">•</span> Fast Delivery <span class="text-calor mx-2">•</span> Customer Support
</div>

<div class="sticky-wrapper">
    <div class="main-nav-container mx-3">

        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button class="action-icon d-lg-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNav">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <a href="{{route('home')}}" class="logo-text text-decoration-none text-dark">
                    <img style="width: 100px; margin-right: 20px;" src="asset/img/anni-logo.png" alt="">
                </a>
                <a href="tel:+91 9876543210" class="contact-pill d-none d-xl-flex align-items-center gap-2">
                    <i class="bi bi-telephone-fill "></i>
                    <span>+91 98765 43210</span>
                </a>
            </div>

            <div class="d-none d-lg-flex align-items-center gap-2">
                <div class="dropdown">
                    <button class="nav-link-custom cat-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-grid-fill me-1"></i> Categories
                    </button>
                    <ul class="dropdown-menu border-0 shadow-lg">
                        <li><a class="dropdown-item" href="#">🌿 Organic Pulses</a></li>
                        <li><a class="dropdown-item" href="#">🍯 Pure Honey</a></li>
                        <li><a class="dropdown-item" href="#">🥜 Premium Nuts</a></li>
                    </ul>
                </div>
                <a href="{{route('home')}}" class="nav-link-custom">Home</a>
                <a href="{{route('product')}}" class="nav-link-custom">Shop Now</a>
                <a href="{{route('wishlist')}}" class="nav-link-custom">Wishlist</a>
                <a href="{{route('contact')}}" class="nav-link-custom">Contact</a>
            </div>

            <div class="d-flex align-items-center gap-2">
                <div class="search-pill d-flex align-items-center d-none d-md-flex">
                    <i class="bi bi-search text-muted"></i>
                    <input type="text" placeholder="Find your flavor...">
                </div>

                <div class="dropdown">
                    <button class="action-icon" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg">
                        <li class="px-3 py-2">
                            <a href="{{route('profile')}}">
                                <h6 class="fw-bold mb-0">My Account</h6>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{route('login')}}">Login / Register</a></li>
                        <li><a class="dropdown-item" href="#">Track Order</a></li>
                    </ul>
                </div>

                <button class="action-icon" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartSide">
                    <i class="bi bi-bag"></i>
                     <span class="badge-dot cart-count" id="cart-count">0</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNav" style="width: 280px;">
    <div class="offcanvas-header p-4 border-bottom">
        <h5 class="fw-bold mb-0 text-calor">MENU</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-4">
        <nav class="d-flex flex-column gap-3">
            <a href="{{route('home')}}" class="nav-link-custom fs-5 border-bottom pb-2">Home</a>
            <a href="{{route('product')}}" class="nav-link-custom fs-5 border-bottom pb-2">Shop Now</a>
            <a href="{{route('wishlist')}}" class="nav-link-custom fs-5 border-bottom pb-2">Wishlist</a>
            <a href="{{route('contact')}}" class="nav-link-custom fs-5 border-bottom pb-2">Contact</a>
        </nav>

        <div class="mt-4">
            <h6 class="fw-bold text-muted small text-uppercase">Categories</h6>
            <div class="d-grid gap-2 mt-3">
                <a href="#" class="btn btn-light text-start rounded-4 p-3">🌿 Organic Pulses</a>
                <a href="#" class="btn btn-light text-start rounded-4 p-3">🍯 Pure Honey</a>
                <a href="#" class="btn btn-light text-start rounded-4 p-3">🥜 Premium Nuts</a>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="cartSide">
    <div class="offcanvas-header p-4">
        <h5 class="fw-bold mb-0"><i class="bi bi-bag-check text-calor me-2"></i> Your Selection</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body" id="cartBody">
        
    </div>
    <div class="p-4 border-top">
        <div class="d-flex justify-content-between mb-4">
            <span class="text-muted">Subtotal Amount</span>
            <span class="fw-bold fs-4">₹<span id="cartGrandTotal">000</span></span>
        </div>
        {{-- <a href="{{route('checkout')}}" class="btn butn-calor w-100 py-3 fw-bold rounded-pill">Proceed to Checkout</a>
        <div class="my-3 text-center">
            <a href="{{route('cart')}}">Go to Cart</a>
        </div> --}}
        <a href="{{route('cart')}}" class="btn butn-calor w-100 py-3 fw-bold rounded-pill">Go to Cart</a>
        {{-- <div class="my-3 text-center">
            <a href="{{route('cart')}}">Go to Cart</a>
        </div> --}}
    </div>
</div>
