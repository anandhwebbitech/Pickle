<style>
/* ===== NAVBAR ===== */
.navbar-custom {
    background: #f6efe6;
    border-radius: 18px;
    padding: 10px 14px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
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
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    white-space: nowrap;
}

/* Links */
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

/* Sidebar toggle */
.sidebar-toggle-btn {
    background: #ffffff;
    border: none;
    border-radius: 10px;
    padding: 6px 10px;
    font-size: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

/* ===== MOBILE ===== */
@media (max-width: 576px) {
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

/* ===== TABLET ===== */
@media (max-width: 992px) {
    .navbar-expand-lg .navbar-collapse {
        display: block;
    }
}
</style>
<nav class="navbar navbar-expand-lg navbar-custom mb-3">
    <div class="container-fluid">

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
                    ✉️ <a href="mailto:pvmautomation@gmail.com" class="nav-link">
                        pvmautomation@gmail.com
                    </a>
                </div>
            </li>

            <li class="nav-item w-100 w-lg-auto">
                <a href="#"
                   class="logout-btn d-block"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="#" method="POST" class="d-none">
                    @csrf
                </form>
            </li>

        </ul>
    </div>
</nav>
