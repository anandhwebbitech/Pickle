@extends('admin.layouts.app')

@section('content')

<style>
.dashboard-wrapper {
    background: linear-gradient(135deg, #e6f1f8, #f5f9fc);
    padding: 40px 30px;
    border-radius: 24px;
}

.stat-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 28px;
    display: flex;
    align-items: center;
    gap: 22px;
    box-shadow: 0 18px 40px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    color: #fff;
    flex-shrink: 0;
}

.bg-category {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}

.bg-product {
    background: linear-gradient(135deg, #16a34a, #15803d);
}

.stat-content h6 {
    font-size: 12px;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: #6b7280;
    margin-bottom: 6px;
}

.stat-content h2 {
    font-size: 36px;
    font-weight: 700;
    margin: 0;
    color: #111827;
}

.stat-content p {
    font-size: 13px;
    color: #6b7280;
    margin-top: 4px;
}
</style>

<div class="container-fluid py-4">

    <div class="dashboard-wrapper">

        <div class="row g-4 ">

            <!-- Categories -->
            <div class="col-md-6 col-lg-4">
                <div class="stat-card">
                    <div class="stat-icon bg-category">📂</div>
                    <div class="stat-content">
                        <h6>Categories</h6>
                        <h2>458</h2>
                        <p>Total categories available</p>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="col-md-6 col-lg-4">
                <div class="stat-card">
                    <div class="stat-icon bg-product">📦</div>
                    <div class="stat-content">
                        <h6>Products</h6>
                        <h2>789</h2>
                        <p>Total products listed</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection
