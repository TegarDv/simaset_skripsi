<nav class="navbar bg-body-tertiary fixed-top">
    <div class="container">
        <div class="d-flex align-items-center">
            <button class="navbar-toggler me-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img src="{{ asset('') }}" alt="" width="120">
            </a>
        </div>
        <div class="ms-auto">
            @if (Auth::guest())
                <a href="/login" class="btn btn-sm btn-primary">Login</a>
            @elseif(Auth::check())
                <div class="btn-group dropstart">
                    <button class="btn dropdown-toggle border border-white" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-fill"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                        <!-- Add dropdown items as needed -->
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </div>
            @endif
        </div>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets/img/polinema_logo.png') }}" alt="" width="70">
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="/pengadaan">
                        <i class="bi bi-speedometer"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('pengadaan.index') ? 'active' : '' }}" href="/pengadaan">
                        <i class="bi bi-folder-fill"></i> Pengadaan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="bi bi-tools"></i> Maintenance
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="bi bi-folder"></i> Peminjaman
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="fa-solid fa-arrows-to-eye"></i> Tracking
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="bi bi-people-fill"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('status.index') ? 'active' : '' }}" href="/status">
                        <i class="bi bi-exclamation-circle-fill"></i> Data Status
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('location.index') ? 'active' : '' }}" href="/location">
                        <i class="bi bi-geo-alt"></i> Data Lokasi Aset
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="bi bi-journal-text"></i> Log
                    </a>
                </li>
            </ul>
        </div>        
        </div>
    </div>
</nav>