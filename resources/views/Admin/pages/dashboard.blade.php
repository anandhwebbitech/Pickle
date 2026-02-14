@extends('admin.layouts.app')

@section('content')

<style>
/* Dashboard Grid */
.dashboard-wrapper {
    padding: 40px 20px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 24px;
}

/* Stat Card */
.stat-card {
    position: relative;
    background: #ffffff;
    border-radius: 20px;
    padding: 28px 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12);
}

/* Icon */
.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #fff;
}

/* Background gradients */
.bg-category { background: linear-gradient(135deg, #4f46e5, #6366f1); }
.bg-product  { background: linear-gradient(135deg, #10b981, #059669); }
.bg-user     { background: linear-gradient(135deg, #f59e0b, #d97706); }
.bg-order    { background: linear-gradient(135deg, #ef4444, #b91c1c); }

/* Decorative circle */
.decor-circle {
    position: absolute;
    border-radius: 50%;
    opacity: 0.15;
}

/* Content */
.stat-content h6 {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: #9ca3af;
    margin-bottom: 4px;
}

.stat-content h2 {
    font-size: 32px;
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

        <!-- Categories Card -->
        <div class="stat-card">
            <div class="decor-circle" style="top:-20px; right:-20px; width:80px; height:80px; background:#6366f1;"></div>
            <div class="stat-icon bg-category">
                <!-- SVG Folder Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="32" height="32">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h4l2 3h10a1 1 0 011 1v7a1 1 0 01-1 1H3a1 1 0 01-1-1V8a1 1 0 011-1z"/>
                </svg>
            </div>
            <div class="stat-content">
                <h6>Categories</h6>
                <h2>458</h2>
                <p>Total categories available</p>
            </div>
        </div>

        <!-- Products Card -->
        <div class="stat-card">
            <div class="decor-circle" style="top:-20px; right:-20px; width:80px; height:80px; background:#059669;"></div>
            <div class="stat-icon bg-product">
                <!-- SVG Box Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="32" height="32">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0L12 11 4 7"/>
                </svg>
            </div>
            <div class="stat-content">
                <h6>Products</h6>
                <h2>789</h2>
                <p>Total products listed</p>
            </div>
        </div>

        <!-- Users Card -->
        <div class="stat-card">
            <div class="decor-circle" style="top:-20px; right:-20px; width:80px; height:80px; background:#d97706;"></div>
            <div class="stat-icon bg-user">
                <!-- SVG Users Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="32" height="32">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m8-4a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <h6>Users</h6>
                <h2>1,245</h2>
                <p>Registered users</p>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="stat-card">
            <div class="decor-circle" style="top:-20px; right:-20px; width:80px; height:80px; background:#b91c1c;"></div>
            <div class="stat-icon bg-order">
                <!-- SVG Shopping Cart Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="32" height="32">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.3 5.3a1 1 0 001 1.2h12.6a1 1 0 001-1.2L17 13M7 13H5.4M17 13l1.3 5.3M9 21a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z"/>
                </svg>
            </div>
            <div class="stat-content">
                <h6>Orders</h6>
                <h2>1,032</h2>
                <p>Total orders placed</p>
            </div>
        </div>

    </div>

</div>

@endsection
