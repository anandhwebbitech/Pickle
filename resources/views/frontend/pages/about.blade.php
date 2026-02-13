@extends('frontend.layouts.app')
@section('content')
    <section class="py-5" style="background-color: #fcf9f4;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-2">
                            <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-muted text-decoration-none small">Home</a></li>
                            <!-- <li class="breadcrumb-item"><a href="#" class="text-muted text-decoration-none small">Shop</a></li> -->
                            <li class="breadcrumb-item active small text-calor fw-bold" aria-current="page">About</li>
                        </ol>
                    </nav>

                    <h1 class="display-5 fw-bold text-dark mb-0">Our <span style="color: #5E0E3C;">About</span></h1>
                    <div class="mx-auto mt-2" style="width: 60px; height: 3px; background-color: #5E0E3C; border-radius: 2px;"></div>

                </div>
            </div>
        </div>
    </section>

    <section class="container section-spacer">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <img src="asset/img/product/pro-1.webp" class="image-block-rounded" alt="Our Craft">
            </div>
            <div class="col-lg-6 ps-lg-5">
                <span class="sub-badge">The Art of Pickling</span>
                <h2 class="section-title-large">Mastering the <span style="color: #d63342;">Slow-Cure</span> Process</h2>
                <p class="content-paragraph-lead">
                    Unlike factory-made preserves, our pickles live in harmony with the sun.
                </p>
                <p class="content-paragraph-sub">
                    We follow the "Vasantha" method where spices are hand-pounded only when the humidity is just right. This ensures the essential oils of the mustard and fenugreek stay trapped inside the jar until the moment you open it.
                </p>
                <div class="mt-4">
                    <div class="check-list-item">
                        <i class="bi bi-check-circle-fill check-icon-box"></i> No Synthetic Vinegar
                    </div>
                    <div class="check-list-item">
                        <i class="bi bi-check-circle-fill check-icon-box"></i> Aged in Ceramic Jars (Bharnis)
                    </div>
                    <div class="check-list-item">
                        <i class="bi bi-check-circle-fill check-icon-box"></i> 100% Gingelly Oil Base
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <h2 class="fw-800 mb-4">No Preservatives. <br>Only <span class="text-brand">Passion.</span></h2>
                    <p class="text-muted lead">We believe in the power of simple ingredients. Local mangoes, hand-ground spices, and pure wood-pressed oils are the only things you'll find in our jars.</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="product-list.php" class="btn btn-dark rounded-pill px-4 py-2 fw-bold">Explore Shop</a>
                        <a href="contact.php" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold">Contact Us</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-6">
                            <img src="asset/img/product/pro-1.webp" class="img-fluid rounded-4 shadow-sm" alt="Process">
                        </div>
                        <div class="col-6">
                            <img src="asset/img/product/pro-2.webp" class="img-fluid rounded-4 shadow-sm mt-4" alt="Process">
                        </div>
                    </div>
                </div>
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

@endsection
