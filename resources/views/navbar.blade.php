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
                        <li><a class="dropdown-item" href="/logout">Log Out</a></li>
                    </ul>
                </div>
            @endif
        </div>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('') }}" alt="" width="120">
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/pengadaan') ? 'active' : '' }}" href="/pengadaan"><i class="bi bi-speedometer"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/"><i class="bi bi-folder-fill"></i> Pengadaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/"><i class="bi bi-tools"></i> Maintenance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/"><i class="bi bi-folder"></i> Peminjaman</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/"><i class="fa-solid fa-arrows-to-eye"></i> Tracking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/"><i class="bi bi-people-fill"></i> Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/"><i class="bi bi-exclamation-circle-fill"></i> Status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/"><i class="bi bi-journal-text"></i> Log</a>
                </li>
            </ul>
        </div>
        </div>
    </div>
</nav>