<style>
    /* ===== SIDEBAR ===== */

</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<div id="sidebar" class="sidebar">

    <!-- HEADER -->
    <div class="sidebar-header">
        <img src="{{ asset('asset/img/anni-logo.png') }}" class="sidebar-logo" alt="Logo">

        <button id="sidebarToggle" class="sidebar-toggle">
            <span class="open-icon"><i class="fa-solid fa-x" style="color: rgb(243, 4, 4);"></i></span>
        </button>
    </div>

    <!-- GENERAL -->
    <div class="section-title">General</div>
    <ul class="sidebar-menu">
        <li>
            <a href="{{route('adminhome')}}" class="active">
                🏠 <span class="menu-text">Dashboard</span>
            </a>
        </li>
    </ul>

    <!-- MANAGEMENT -->
    <div class="section-title">Management</div>
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('bannerpage') }}">
                <i class="bi bi-grid"></i>
                <span class="menu-text">Banner</span>
            </a>
        </li>
        <li>
            <a href="{{ route('shorts.page') }}">
                <i class="bi bi-grid"></i>
                <span class="menu-text">Shorts</span>
            </a>
        </li>
        <li>
            <a href="{{ route('categoriespage') }}">
                <i class="bi bi-grid"></i>
                <span class="menu-text">Categories</span>
            </a>
        </li>
        <li>
            <a href="{{ route('subcategoriespage') }}">
                <i class="bi bi-grid"></i>
                <span class="menu-text">Sub Categories</span>
            </a>
        </li>


        <li>
            <a href="{{ route('productpage') }}">
                <i class="bi bi-box-seam"></i>
                <span class="menu-text">Products</span>
            </a>
        </li>
        <li>
            <a href="{{ route('productpage') }}">
                <i class="bi bi-box-seam"></i>
                <span class="menu-text">Combo Products</span>
            </a>
        </li>

        <li>
            <a href="{{route('couponpage')}}">
                <i class="bi bi-ticket-perforated"></i>
                <span class="menu-text">Coupons</span>
            </a>
        </li>

        <li>
            <a href="{{route('orderlist')}}">
                <i class="bi bi-receipt"></i>
                <span class="menu-text">Order List</span>
            </a>
        </li>

        <li>
            <a href="{{route('paymentlist')}}">
                <i class="bi bi-credit-card"></i>
                <span class="menu-text">Online Payment List</span>
            </a>
        </li>
    </ul>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const sidebar = document.getElementById("sidebar");

    // Correct selector (single string!)
    const toggleBtns = document.querySelectorAll(
        "#sidebarToggle, #toggleSidebar, #mobileSidebarToggle"
    );

    toggleBtns.forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.stopPropagation();

            if (window.innerWidth <= 992) {
                // Mobile slide
                sidebar.classList.toggle("show");
            } else {
                // Desktop collapse
                sidebar.classList.toggle("collapsed");
            }
        });
    });

});
</script>
