@extends('frontend.layouts.app')
@section('content')


    <section class="py-5" style="background-color: #fcf9f4;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-2">
                            <li class="breadcrumb-item"><a href="index.php" class="text-muted text-decoration-none small">Home</a></li>
                            <!-- <li class="breadcrumb-item"><a href="#" class="text-muted text-decoration-none small">Shop</a></li> -->
                            <li class="breadcrumb-item active small text-calor fw-bold" aria-current="page">Products</li>
                        </ol>
                    </nav>

                    <h1 class="display-5 fw-bold text-dark mb-0">Our <span style="color: #5E0E3C;">Products</span></h1>
                    <div class="mx-auto mt-2" style="width: 60px; height: 3px; background-color: #5E0E3C; border-radius: 2px;"></div>

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
                        <li class="mb-3"><a href="#" class="text-dark fw-bold text-decoration-none">All</a></li>
                        <li class="mb-3"><a href="#" class="text-muted text-decoration-none hover-red">Dry Fruits & Nuts</a></li>
                        <li class="mb-3"><a href="#" class="text-muted text-decoration-none hover-red">Oil</a></li>
                        <li class="mb-3"><a href="#" class="text-muted text-decoration-none hover-red">Ghee</a></li>
                        <li class="mb-3"><a href="#" class="text-muted text-decoration-none hover-red">Sugar</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                    <div class="text-muted small">Showing all 12 results</div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="small text-muted fw-bold">Sort By:</span>
                        <select class="form-select form-select-sm rounded-pill shadow-sm" style="width: 150px;">
                            <option selected>Popular</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Newest</option>
                        </select>
                    </div>
                </div>

                <div class="row g-4">

                    <div class="col-sm-6 col-md-4">
                        <div class="product-card p-3 border shadow-sm bg-white">
                            <div class="img-container mb-3">
                                <span class="badge badge-calor position-absolute top-0 start-0 m-2" style="z-index: 5;">15%</span>
                                <button class="save-btn" onclick="toggleSave(this)">
                                    <i class="bi bi-heart"></i>
                                </button>

                                <!-- IMAGE PATH UNCHANGED -->
                                <img src="asset/img/product/pro-1.webp" class="img-main">
                                <img src="asset/img/product/pro-2.webp" class="img-hover">

                                <div class="view-overlay">
                                    <a href="product-details.php" class="btn btn-light rounded-pill btn-sm fw-bold shadow-sm px-3">
                                        View Product
                                    </a>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-1">Garlic Pickle – 250g</h6>
                            <p class="text-muted small mb-3">Spicy • Tangy • Traditional</p>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold fs-5 text-calor">₹170</span>
                                    <small class="text-muted text-decoration-line-through ms-1">₹200</small>
                                </div>

                                <div class="qty-pill">
                                    <span class="qty-btn" onclick="updateQty(this, -1)">-</span>
                                    <span class="local-qty fw-bold">1</span>
                                    <span class="qty-btn" onclick="updateQty(this, 1)">+</span>
                                </div>
                            </div>

                            <button class="btn btn-dark w-100 rounded-pill mt-3 py-2 fw-bold"
                                onclick="handleCartClick(this)">
                                Add to Cart
                            </button>
                        </div>
                    </div>


                    <div class="col-sm-6 col-md-4">
                        <div class="product-card p-3 border shadow-sm bg-white">
                            <div class="img-container mb-3">
                                <span class="badge badge-calor position-absolute top-0 start-0 m-2" style="z-index: 5;">10%</span>
                                <button class="save-btn" onclick="toggleSave(this)">
                                    <i class="bi bi-heart"></i>
                                </button>

                                <!-- IMAGE PATH UNCHANGED -->
                                <img src="asset/img/product/pro-1.webp" class="img-main">
                                <img src="asset/img/product/pro-2.webp" class="img-hover">

                                <div class="view-overlay">
                                    <a href="product-details.php" class="btn btn-light rounded-pill btn-sm fw-bold shadow-sm px-3">
                                        View Product
                                    </a>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-1">Raw Mango Pickle – 250g</h6>
                            <p class="text-muted small mb-3">Sun-Dried • Gingelly Oil</p>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold fs-5 text-calor">₹180</span>
                                    <small class="text-muted text-decoration-line-through ms-1">₹200</small>
                                </div>

                                <div class="qty-pill">
                                    <span class="qty-btn" onclick="updateQty(this, -1)">-</span>
                                    <span class="local-qty fw-bold">1</span>
                                    <span class="qty-btn" onclick="updateQty(this, 1)">+</span>
                                </div>
                            </div>

                            <button class="btn btn-dark w-100 rounded-pill mt-3 py-2 fw-bold"
                                onclick="handleCartClick(this)">
                                Add to Cart
                            </button>
                        </div>
                    </div>


                    <div class="col-sm-6 col-md-4">
                        <div class="product-card p-3 border shadow-sm bg-white">
                            <div class="img-container mb-3">
                                <span class="badge badge-calor position-absolute top-0 start-0 m-2" style="z-index: 5;">20%</span>
                                <button class="save-btn" onclick="toggleSave(this)">
                                    <i class="bi bi-heart"></i>
                                </button>

                                <!-- IMAGE PATH UNCHANGED -->
                                <img src="asset/img/product/pro-1.webp" class="img-main">
                                <img src="asset/img/product/pro-2.webp" class="img-hover">

                                <div class="view-overlay">
                                    <a href="product-details.php" class="btn btn-light rounded-pill btn-sm fw-bold shadow-sm px-3">
                                        View Product
                                    </a>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-1">Lemon Pickle – 250g</h6>
                            <p class="text-muted small mb-3">Naturally Fermented</p>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold fs-5 text-calor">₹160</span>
                                    <small class="text-muted text-decoration-line-through ms-1">₹200</small>
                                </div>

                                <div class="qty-pill">
                                    <span class="qty-btn" onclick="updateQty(this, -1)">-</span>
                                    <span class="local-qty fw-bold">1</span>
                                    <span class="qty-btn" onclick="updateQty(this, 1)">+</span>
                                </div>
                            </div>

                            <button class="btn btn-dark w-100 rounded-pill mt-3 py-2 fw-bold"
                                onclick="handleCartClick(this)">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                </div>
                <nav aria-label="Product pagination" class="my-5">
                    <ul class="pagination gap-2 border-0 mb-0 justify-content-center">
                        <li class="page-item">
                            <a class="page-link shadow-sm border-0 rounded-circle d-flex align-items-center justify-content-center" href="#" style="width: 40px; height: 40px; color: #333;">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>

                        <li class="page-item active">
                            <a class="page-link shadow-sm border-0 rounded-circle d-flex align-items-center justify-content-center fw-bold" href="#" style="width: 40px; height: 40px;">1</a>
                        </li>

                        <li class="page-item">
                            <a class="page-link shadow-sm border-0 rounded-circle d-flex align-items-center justify-content-center fw-bold text-dark" href="#" style="width: 40px; height: 40px;">2</a>
                        </li>

                        <li class="page-item">
                            <a class="page-link shadow-sm border-0 rounded-circle d-flex align-items-center justify-content-center" href="#" style="width: 40px; height: 40px; color: #333;">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
@endsection
