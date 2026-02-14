@extends('frontend.layouts.app')
@section('content')


    <section class="py-5" style="background-color: #fcf9f4;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-2">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"
                                    class="text-muted text-decoration-none small">Home</a></li>
                            <!-- <li class="breadcrumb-item"><a href="#" class="text-muted text-decoration-none small">Shop</a></li> -->
                            <li class="breadcrumb-item active small text-calor fw-bold" aria-current="page">Products</li>
                        </ol>
                    </nav>

                    <h1 class="display-5 fw-bold text-dark mb-0">Our <span style="color: #5E0E3C;">Products</span></h1>
                    <div class="mx-auto mt-2"
                        style="width: 60px; height: 3px; background-color: #5E0E3C; border-radius: 2px;"></div>

                </div>
            </div>
        </div>
    </section>

    <section class="container my-5 pt-4">
        <div class="row">

            <div class="col-lg-3 mb-4">
                <div class="sticky-top" style="top: 20px; z-index: 10;">
                    <h5 class="fw-bold mb-3 d-flex justify-content-between align-items-center">
                        Categories
                    </h5>
                    <hr class="mb-4" style="width: 40px; border-top: 3px solid #5E0E3C; opacity: 1;">

                    <ul class="list-unstyled category-list">
                        <li class="mb-3">
                            <a href="{{ route('product') }}"
                            class="text-decoration-none {{ request('category') ? 'text-muted' : 'fw-bold text-dark' }}">
                                All
                            </a>
                        </li>

                        @foreach ($categories as $category)
                            <li class="mb-3">
                                <a href="{{ route('product', ['category' => $category->id]) }}"
                                class="text-decoration-none 
                                {{ request('category') == $category->id ? 'fw-bold text-dark' : 'text-muted hover-red' }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                    {{-- <div class="text-muted small">Showing all 12 results</div> --}}
                    <div class="text-muted small">
                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }}
                        of {{ $products->total() }} results
                    </div>
                    {{-- <div class="d-flex align-items-center gap-2">
                        <span class="small text-muted fw-bold">Sort By:</span>
                        <select class="form-select form-select-sm rounded-pill shadow-sm" style="width: 150px;">
                            <option selected>Popular</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Newest</option>
                        </select>
                    </div> --}}
                </div>

                <div class="row g-4">

                    @forelse($products as $product)
                        <div class="col-sm-6 col-md-4">
                            <div class="product-card p-3 border shadow-sm bg-white">

                                <div class="img-container mb-3 position-relative">

                                    @if($product->discount)
                                        <span class="badge badge-calor position-absolute top-0 start-0 m-2" style="z-index: 5;">
                                            {{ $product->discount }}%
                                        </span>
                                    @endif

                                     @php
                                        $isInWishlist = in_array($product->id, $wishlistIds ?? []);
                                    @endphp
                                    <button class="save-btn {{ $isInWishlist ? 'active' : '' }}" onclick="toggleSave(this)"data-id="{{ $product->id }}">
                                        <i class="bi {{ $isInWishlist ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                                    </button>

                                    <!-- Product Image -->
                                    <img src="{{ asset('public/uploads/products/' . $product->image) }}" class="img-main">
                                    <img src="{{ asset('public/uploads/products/' . $product->image) }}" class="img-hover">

                                    <div class="view-overlay">
                                        <a href="{{ route('product-details', $product->id) }}"
                                            class="btn btn-light rounded-pill btn-sm fw-bold shadow-sm px-3">
                                            View Product
                                        </a>
                                    </div>
                                </div>

                                <h6 class="fw-bold mb-1">{{ $product->name }}</h6>

                                <p class="text-muted small mb-3">
                                    {{ $product->short_description ?? 'Delicious & Traditional' }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold fs-5 text-calor">
                                            @php
                                            $prices = json_decode($product->weight, true);
                                            @endphp

                                            @if(!empty($prices))
                                            ₹{{ number_format($prices[0]['price'], 2) }}
                                            @endif
                                        </span>

                                        @if($product->mrp)
                                            <small class="text-muted text-decoration-line-through ms-1">
                                                ₹{{ $product->mrp }}
                                            </small>
                                        @endif
                                    </div>

                                    <div class="qty-pill">
                                        <span class="qty-btn" onclick="updateQty(this, -1)">-</span>
                                        <span class="local-qty fw-bold">1</span>
                                        <span class="qty-btn" onclick="updateQty(this, 1)">+</span>
                                    </div>
                                </div>
                                @php
                                    $prices = json_decode($product->weight, true);
                                    $firstWeight = $prices[0]['weight'] ?? null;
                                    $firstPrice  = $prices[0]['price'] ?? 0;
                                @endphp

                                <button class="btn btn-dark w-100 rounded-pill mt-3 py-2 fw-bold"
                                    onclick="handleCartClick(this)"
                                    data-id="{{ $product->id }}"data-url="{{ route('cart.add', $product->id) }}"
                                    data-weight="{{ $firstWeight }}"
                                    data-price="{{ $firstPrice }}">
                                    Add to Cart
                                </button>

                            </div>
                        </div>

                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">No products available.</p>
                        </div>
                    @endforelse

                </div>
                
                <div class="d-flex justify-content-center mt-5">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </section>
@endsection