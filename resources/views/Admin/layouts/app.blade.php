<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Pickle </title>

  <!-- Bootstrap CSS (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <!-- Template CSS -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
  /* ======================================
   GLOBAL
====================================== */
body {
    background: #f5f7fb;
    min-height: 100vh;
}

/* ======================================
   SIDEBAR
====================================== */
#sidebar {
    width: 260px;
    height: 100vh;
    background: #5e0e3cb8;
    position: fixed;
    top: 0;
    left: 0;
    padding: 14px 0;
    overflow-y: auto;
    z-index: 1000;
    transition: all 0.3s ease;
}

/* Collapsed */
#sidebar.collapsed {
    width: 80px;
}

/* Hide text when collapsed */
#sidebar.collapsed .menu-text,
#sidebar.collapsed .section-title,
#sidebar.collapsed .logo-text,
#sidebar.collapsed small.text-muted {
    display: none;
}

/* Sidebar Header */
.sidebar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 14px 14px;
}

#sidebar.collapsed .sidebar-header {
    justify-content: center;
}

/* Logo */
.sidebar-logo {
    width: 100px;
    height: 65px;
    transition: 0.3s;
}

#sidebar.collapsed .sidebar-logo {
    width: 40px;
    height: auto;
}

/* Toggle Button */
.sidebar-toggle-btn {
    background: #ffffff;
    border: none;
    border-radius: 10px;
    padding: 6px 10px;
    font-size: 16px;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
}

/* ======================================
   SIDEBAR MENU
====================================== */
.section-title {
    padding: 16px 18px 6px;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #dca521;
    font-weight: 600;
}

.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-menu li a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    margin: 6px 12px;
    border-radius: 25px;
    font-size: 12.5px;
    font-weight: 500;
    background: #e0d3db;
    color: #111827;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    transition: 0.25s ease;
}

.sidebar-menu li a:hover {
    transform: translateX(3px);
    background: #fff7ed;
}

.sidebar-menu li a.active {
    background: #e53935;
    color: #ffffff;
}

.sidebar-menu i {
    font-size: 16px;
}

/* Center icons when collapsed */
#sidebar.collapsed .sidebar-menu li a {
    justify-content: center;
}

/* ======================================
   CONTENT AREA
====================================== */
.content {
    margin-left: 260px;
    padding: 20px;
    transition: all 0.3s ease;
}

#sidebar.collapsed ~ .content {
    margin-left: 80px;
}

/* ======================================
   NAVBAR
====================================== */
.navbar-custom {
    background: #5e0e3cb8;
    border-radius: 18px;
    padding: 10px 14px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
}

/* Brand */
.navbar-custom .brand {
    font-weight: 700;
    font-size: 18px;
    color: #e53935;
}

.navbar-custom .brand span {
    color: #111827;
}

/* Pills */
.nav-pill {
    background: #ffffff;
    padding: 5px 12px;
    border-radius: 30px;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    white-space: nowrap;
}

.nav-pill .nav-link {
    padding: 0;
    font-size: 12.5px;
    color: #374151;
    max-width: 140px;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Logout */
.logout-btn {
    background: #e53935;
    color: #ffffff !important;
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 12.5px;
    font-weight: 500;
}

.logout-btn:hover {
    background: #d32f2f;
}

/* ======================================
   CARDS & BUTTONS
====================================== */
.card-box {
    border-radius: 10px;
    padding: 18px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    background: #fff;
}

.addbtn {
    border-radius: 15px;
}

.pgmas {
    background-color: #e0edf5;
}

/* ======================================
   RESPONSIVE
====================================== */

/* Tablet & Mobile Sidebar */
@media (max-width: 992px) {

    #sidebar {
        transform: translateX(-100%);
        width: 260px;
    }

    #sidebar.show {
        transform: translateX(0);
    }

    .content {
        margin-left: 0 !important;
    }
}
/* Small Mobile */
@media (max-width: 576px) {

    #bannerTable img {
        width: 80px !important;
        height: auto;
    }

    .navbar-custom {
        padding: 8px 10px;
        border-radius: 14px;
    }

    .navbar-custom .brand {
        font-size: 16px;
    }

    .navbar-nav {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 8px;
        margin-top: 10px;
    }

    .nav-pill {
        width: 100%;
        font-size: 12px;
    }

    .logout-btn {
        width: 100%;
        text-align: center;
        font-size: 12px;
    }
}
#sidebar.collapsed {
    width: 80px;
}

#sidebar.collapsed ~ .content {
    margin-left: 80px;
}
@media (min-width: 992px) {
    #sidebarToggle {
        display: none !important;
    }
}
</style>
</head>

<body>

  {{-- Sidebar --}}
  @include('admin.layouts.sidebar')

  <div class="content">
    {{-- Navbar --}}
    @include('admin.layouts.navbar')

    {{-- Page content --}}
    <main class="mt-4 pgmas">
      @yield('content')
    </main>
  </div>

  <!-- Bootstrap JS (bundle: Popper included) -->
  <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/app.js') }}"></script>
  <script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
  <script src="{{ asset('admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/main.js') }}"></script>
  <!-- ✅ Add the TOGGLE SCRIPT here -->
  <script>

    document.addEventListener("DOMContentLoaded", function () {

      const sidebar = document.getElementById("sidebar");
      const toggleButtons = document.querySelectorAll("#toggleSidebar");

      toggleButtons.forEach(button => {
        button.addEventListener("click", function () {

          // MOBILE (screen < 992px)
          if (window.innerWidth < 992) {
            sidebar.classList.toggle("mobile-open");
            return;
          }

          // DESKTOP
          sidebar.classList.toggle("collapsed");
        });
      });

    });

    document.addEventListener("DOMContentLoaded", function () {

      const sidebar = document.getElementById("sidebar");
      const toggleBtn = document.getElementById("sidebarToggle");
      const closeBtn = document.getElementById("closeSidebar");

      // OPEN sidebar on mobile
      toggleBtn.addEventListener("click", function () {
        if (window.innerWidth < 992) {
          sidebar.classList.add("mobile-open");
        } else {
          sidebar.classList.toggle("collapsed"); // desktop toggle
        }
      });

      // CLOSE sidebar on mobile
      closeBtn.addEventListener("click", function () {
        sidebar.classList.remove("mobile-open");
      });

    });
  </script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @stack('scripts')

</body>

</html>