<style>
/* ===== SIDEBAR ===== */
#sidebar {
    width: 260px;
    min-height: 100vh;
    background: #f6efe6;
    border-radius: 18px;
    margin: 16px;
    padding: 14px 0;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* ===== HEADER ===== */
.sidebar-header {
    padding: 0 16px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.sidebar-logo {
    height: 30px;
    transition: 0.3s;
}

/* ===== TOGGLE BUTTON ===== */
.sidebar-toggle {
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
    color: #374151;
}

/* ===== SECTION TITLE ===== */
.section-title {
    padding: 16px 18px 6px;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #9ca3af;
    font-weight: 600;
}

/* ===== MENU ===== */
.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-menu li a {
    background: #ffffff;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    margin: 6px 12px;
    border-radius: 25px;
    font-size: 12.5px;
    font-weight: 500;
    color: #374151;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    transition: all 0.25s ease;
}

/* Hover */
.sidebar-menu li a:hover {
    transform: translateX(3px);
    background: #fff7ed;
}

/* Active */
.sidebar-menu li a.active {
    background: #e53935;
    color: #ffffff;
    border-radius: 25px; 
}
.section-title {
    border-radius: 25px;
}
/* Icon */
.sidebar-menu i,
.sidebar-menu span:first-child {
    font-size: 16px;
}

/* Toggle icons */
.open-icon { display: inline; }
.close-icon { display: none; }

/* ===== COLLAPSED STATE (optional future use) ===== */
#sidebar.collapsed {
    width: 90px;
}

#sidebar.collapsed .menu-text {
    display: none;
}

#sidebar.collapsed .section-title {
    text-align: center;
}

/* ===== TRANSITION ===== */
#sidebar,
.sidebar-menu li a {
    transition: all 0.3s ease;
}
</style>

<div id="sidebar" class="sidebar">

    <!-- HEADER -->
    <div class="sidebar-header">
        <img src="{{ asset('assets/images/new-images/logo.png') }}"
             class="sidebar-logo"
             alt="Logo">

        <button id="sidebarToggle" class="sidebar-toggle">
            <span class="open-icon">☰</span>
            <span class="close-icon">✖</span>
        </button>
    </div>

    <!-- GENERAL -->
    <div class="section-title">General</div>
    <ul class="sidebar-menu">
        <li>
            <a href="#" class="active">
                🏠 <span class="menu-text">Dashboard</span>
            </a>
        </li>
    </ul>

    <!-- MANAGEMENT -->
    <div class="section-title">Management</div>
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('categoriespage') }}">
                📂 <span class="menu-text">Categories</span>
            </a>
        </li>
        <li>
            <a href="{{ route('productpage') }}">
                📦 <span class="menu-text">Products</span>
            </a>
        </li>
        <li>
            <a href="{{route('couponpage')}}">
                🚀 <span class="menu-text">Coupons</span>
            </a>
        </li>
    </ul>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const openIcon = document.querySelector('.open-icon');
    const closeIcon = document.querySelector('.close-icon');

    toggleBtn.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');

        openIcon.style.display = sidebar.classList.contains('collapsed') ? 'inline' : 'none';
        closeIcon.style.display = sidebar.classList.contains('collapsed') ? 'none' : 'inline';
    });
});
</script>
