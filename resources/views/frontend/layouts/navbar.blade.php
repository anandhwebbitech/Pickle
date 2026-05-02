<style>
    .offcanvas-body{
        background: #5e0e3c;
    }

.search-results {
    position: absolute;
    top: 45px;
    left: 0;
    width: 300px;
    max-height: 350px;
    overflow-y: auto;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    z-index: 9999;
}

.search-item {
    padding: 10px 15px;
    border-bottom: 1px solid #f1f1f1;
    cursor: pointer;
}

.search-item:hover {
    background: #f8f8f8;
}
 /* Desktop Category Dropdown */
    .category-dropdown{
        min-width: 280px;
        border-radius: 18px;
        overflow: visible !important;
        padding: 10px;
    }
    .dropdown-menu{
        overflow: visible !important;
    }

    .category-item{
        position: relative;
    }

    .category-link{
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:12px 14px;
        border-radius:12px;
        color:#333;
        text-decoration:none;
        transition:.3s;
        font-weight:500;
    }

    .category-link:hover{
        background:#f8f1f5;
        color:#5E0E3C;
    }

    .subcategory-menu{
        position:absolute;
        left:calc(100% + 10px);
        top:0;
        min-width:240px;
        background:#fff;
        border-radius:16px;
        padding:10px;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
        display:none;
        z-index:9999;
    }
    .subcategory-menu.show{
        display:block !important;
    }
   

    .subcategory-link{
        display:block;
        padding:10px 12px;
        border-radius:10px;
        text-decoration:none;
        color:#555;
        transition:.3s;
        font-size:14px;
    }

    .subcategory-link:hover{
        background:#f8f1f5;
        color:#5E0E3C;
        transform:translateX(3px);
    }

    /* Mobile Accordion */
    .mobile-category-btn{
        background:#fff;
        border:none;
        width:100%;
        text-align:left;
        padding:14px 16px;
        border-radius:14px;
        font-weight:600;
        display:flex;
        justify-content:space-between;
        align-items:center;
    }

    .mobile-subcategory{
        background:#fff;
        border-radius:14px;
        margin-top:8px;
        padding:10px;
    }

    .mobile-subcategory a{
        display:block;
        padding:10px 12px;
        text-decoration:none;
        color:#444;
        border-radius:10px;
        transition:.3s;
    }

    .mobile-subcategory a:hover{
        background:#f8f1f5;
        color:#5E0E3C;
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
                {{-- <a href="tel:+91 9876543210" class="contact-pill d-none d-xl-flex align-items-center gap-2">
                    <i class="bi bi-telephone-fill "></i>
                    <span>+91 98765 43210</span>
                </a> --}}
            </div>

            <div class="d-none d-lg-flex align-items-center gap-2">
                <div class="dropdown" data-bs-auto-close="outside">
                    <button class="nav-link-custom cat-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-grid-fill me-1"></i> Categories
                    </button>
                    <ul class="dropdown-menu border-0 shadow-lg category-dropdown">

                        @foreach($categories as $category)

                            <li class="category-item position-relative">

                                <div class="d-flex justify-content-between align-items-center category-link">

                                    {{-- Category Link --}}
                                    <a href="{{ route('product', ['category' => $category->id]) }}"
                                    class="text-decoration-none text-dark flex-grow-1">

                                        {{ $category->name }}

                                    </a>

                                    {{-- Toggle Button --}}
                                    @if($category->subcategories->count())

                                        <button type="button"
                                                class="border-0 bg-transparent sub-toggle-btn"
                                                onclick="toggleSubmenu(event, this)">

                                            <i class="bi bi-chevron-right"></i>

                                        </button>

                                    @endif

                                </div>

                                {{-- Sub Categories --}}
                                @if($category->subcategories->count())

                                    <div class="subcategory-menu">

                                        <a href="{{ route('product', ['category' => $category->id]) }}"
                                        class="subcategory-link fw-bold text-calor">

                                            View All

                                        </a>

                                        @foreach($category->subcategories as $sub)

                                            <a href="{{ route('product', [
                                                    'category' => $category->id,
                                                    'subcategory' => $sub->id
                                                ]) }}"
                                            class="subcategory-link">

                                                {{ $sub->sub_category_name }}

                                            </a>

                                        @endforeach

                                    </div>

                                @endif

                            </li>

                        @endforeach

                    </ul>
                </div>
                <a href="{{route('home')}}" class="nav-link-custom">Home</a>
                <a href="{{route('product')}}" class="nav-link-custom">Shop Now</a>
                <a href="{{route('wishlist')}}" class="nav-link-custom">Wishlist</a>
                <a href="{{route('contact')}}" class="nav-link-custom">Contact</a>
                
            </div>

            <div class="d-flex align-items-center gap-2">
                {{-- <div class="search-pill d-flex align-items-center d-none d-md-flex">
                    <i class="bi bi-search text-muted"></i>
                    <input type="text" placeholder="Find your flavor...">
                </div> --}}
                <div class="search-pill position-relative d-flex align-items-center d-none d-md-flex">
                    <i class="bi bi-search text-muted"></i>
                    <input type="text" id="productSearch" placeholder="Find your flavor..." autocomplete="off">

                    <!-- Search Result Box -->
                    <div id="searchResults" class="search-results d-none"></div>
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
                        @auth

                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="bi bi-person me-2"></i> Personal Info
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}?tab=orders">
                                    <i class="bi bi-bag me-2"></i> Order History
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}?tab=address">
                                    <i class="bi bi-geo-alt me-2"></i> My Address
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}?tab=password">
                                    <i class="bi bi-key me-2"></i> Change Password
                                </a>
                            </li>
                            {{-- User is logged in --}}
                            <hr>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-left"></i>  Logout
                                    </button>
                                </form>
                            </li>
                        @else
                            {{-- User is NOT logged in --}}
                            <li>
                                <a class="dropdown-item" href="{{ route('login') }}">
                                    Login / Register
                                </a>
                            </li>
                        @endauth
                        {{-- <li><a class="dropdown-item" href="{{route('login')}}">Login / Register</a></li> --}}
                        {{-- <li><a class="dropdown-item" href="#">Track Order</a></li> --}}
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

            <h6 class="fw-bold text-white small text-uppercase mb-3">
                Categories
            </h6>

            <div class="accordion" id="mobileCategoryAccordion">

                @foreach($categories as $category)

                    <div class="mb-2">

                        <button class="mobile-category-btn"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#mobileCat{{ $category->id }}">

                            {{ $category->name }}

                            <i class="bi bi-chevron-down"></i>

                        </button>

                        <div id="mobileCat{{ $category->id }}"
                             class="collapse"
                             data-bs-parent="#mobileCategoryAccordion">

                            <div class="mobile-subcategory">

                                <a href="{{ route('product', ['category' => $category->id]) }}"
                                   class="fw-bold text-calor">
                                    View All
                                </a>

                                @foreach($category->subcategories as $sub)

                                    <a href="{{ route('product', [
                                            'category' => $category->id,
                                            'subcategory' => $sub->id
                                        ]) }}">

                                        {{ $sub->sub_category_name }}

                                    </a>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endforeach

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
              
            <div id="subtotalSection"
                class="subtotal-section d-flex justify-content-between mb-4 d-none">
                <span class="text-muted">Subtotal Amount</span>
                <span class="fw-bold fs-4">
                    ₹<span id="cartGrandTotal">0.00</span>
                </span>
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
<script>
    function toggleSubmenu(event, button) {

        event.preventDefault();
        event.stopPropagation();

        let parent = button.closest('.category-item');
        let submenu = parent.querySelector('.subcategory-menu');

        // close others
        document.querySelectorAll('.subcategory-menu').forEach(menu => {

            if(menu !== submenu){
                menu.classList.remove('show');
            }

        });

        submenu.classList.toggle('show');
    }

    // prevent submenu click close
    document.querySelectorAll('.subcategory-menu').forEach(menu => {

        menu.addEventListener('click', function(e) {
            e.stopPropagation();
        });

    });

</script>