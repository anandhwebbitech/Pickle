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
    body { background: #f5f7fb; min-height:100vh; }
    .sidebar { width: 260px; background: #fff; height: 100vh; position: fixed; left: 0; top: 0; padding: 24px 18px; border-right: 1px solid #e9ecef; overflow-y: auto; }
    .content { margin-left: 260px; padding: 20px; }
    .card-box { border-radius: 10px; padding: 18px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); background: #fff; }
    .navbar-custom { background: #fff; border-radius: 8px; }
    @media (max-width: 991px) {
      .sidebar { position: relative; width: 100%; height: auto; border-right: none; }
      .content { margin-left: 0; }
    }
    .sidebar {
  width: 250px;
  background-color: #fff;
  border-right: 1px solid #eaeaea;
  height: 100vh;
  transition: width 0.3s;
  overflow: hidden;
}

.sidebar.collapsed {
  width: 80px;
}

/* Hide text when collapsed */
.sidebar.collapsed .link-text,
.sidebar.collapsed .logo-text,
.sidebar.collapsed .badge-text,
.sidebar.collapsed small.text-muted {
  display: none;
}

/* Center icons */
.sidebar.collapsed .nav-link {
  justify-content: center;
}

.sidebar.collapsed .nav-link span {
  margin: 0 !important;
}

.logo-img {
  transition: 0.3s;
}
/* .nav-link.active {
    background: #ffe1f4;
    color: #d63384 !important;
    font-weight: 600;
    border-radius: 6px;
} */
/* .nav-link.active {
    background: #f0f0f0;
    font-weight: 600;
    border-radius: 6px;
} */
/* ===== SIDEBAR BASE ===== */
.sidebar.collapsed .link-text,
.sidebar.collapsed .logo-text {
display: none;
}
.sidebar.collapsed .nav-link {
justify-content: center;
}
.sidebar.collapsed .nav-link span {
margin: 0 !important;
}


/* ===== MOBILE SLIDE MENU ===== */
@media (max-width: 991px) {
.sidebar {
left: -300px;
width: 260px;
height: 100%;
position: fixed;
z-index: 999;
}


.sidebar.mobile-open {
left: 0;
}


.content {
margin-left: 0 !important;
}
}


/* ===== CONTENT ===== */
.content {
margin-left: 260px;
padding: 20px;
transition: 0.3s;
}
.sidebar.collapsed + .content {
margin-left: 80px;
}


/* Navbar */
.navbar-custom {
background: #fff;
border-radius: 8px;
}


.nav-link.active {
background: #ffe1f4;
color: #0d6efd  !important;
font-weight: 600;
border-radius: 6px;
}
/* MOBILE SIDEBAR */
@media (max-width: 991px) {
    #sidebar {
        position: fixed;
        left: -260px;   /* hidden */
        top: 0;
        width: 260px;
        height: 100vh;
        background: #fff;
        transition: left 0.3s ease;
        z-index: 9999;
    }

    #sidebar.mobile-open {
        left: 0;       /* slide in */
    }
}
@media (max-width: 576px) {
    #bannerTable img {
        width: 80px !important;
        height: auto;
    }
}
  .addbtn{
        border-radius:15px;
    }
    .pgmas{ 
        background-color: #e0edf5;
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
<link rel="stylesheet"
      href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('scripts')

</body>
</html>
