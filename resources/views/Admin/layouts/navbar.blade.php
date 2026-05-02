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
                AnNi'S <span>Kitchen</span>
            </div>
        </div>

        <!-- RIGHT -->
        <ul class="navbar-nav ms-auto align-items-center gap-2">

            <li class="nav-item w-100 w-lg-auto">
                <div class="nav-pill">
                    📞 <a href="tel:+919677739608" class="nav-link">+91 9677739608</a>
                </div>
            </li>

            <li class="nav-item w-100 w-lg-auto">
                <div class="nav-pill">
                    ✉️ <a href="mailto:info@anniskitchen.com" class="nav-link">
                        info@anniskitchen.com
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
