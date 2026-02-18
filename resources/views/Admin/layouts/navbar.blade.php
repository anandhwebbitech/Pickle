<style>

</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-custom mb-3">
    <div class="container-fluid">
        {{-- <button class="btn btn-light d-lg-none" id="mobileSidebarToggle">
            ☰
        </button> --}}
        <!-- LEFT -->
        <div class="d-flex align-items-center gap-2">
            <button class="sidebar-toggle-btn d-lg-none" id="toggleSidebar">☰</button>

            <div class="brand">
                YUMMY <span>PICKLE</span>
            </div>
        </div>

        <!-- RIGHT -->
        <ul class="navbar-nav ms-auto align-items-center gap-2">

            <li class="nav-item w-100 w-lg-auto">
                <div class="nav-pill">
                    📞 <a href="tel:+919876543210" class="nav-link">+91 98765 43210</a>
                </div>
            </li>

            <li class="nav-item w-100 w-lg-auto">
                <div class="nav-pill">
                    ✉️ <a href="mailto:pickle@gmail.com" class="nav-link">
                        pickle@gmail.com
                    </a>
                </div>
            </li>

            <li class="nav-item w-100 w-lg-auto">
                {{-- <a href="#"
                   class="logout-btn d-block"
                   >
                    Logout
                </a> --}}
                 <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="logout-btn d-block">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>

        </ul>
    </div>
</nav>
