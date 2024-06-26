<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <span class="app-brand-logo demo" style="height: unset">
                <img style="height: 30px" src="{{ asset('assets/img/polinema_logo.png') }}" alt="img">
            </span>
            <span class="app-brand-text demo menu-text fw-bold">SIMASET</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @can('isOwner')
            <li class="menu-item">
                <a href="" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-apps" style="margin-bottom: 2px;"></i>
                    <div>Dashboard</div>
                </a>
            </li>
        @endcan

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Menu</span>
        </li>
        {{-- <li class="menu-item">
            <a href="" class="menu-link">
                <i class="menu-icon tf-icons ti bi-cart3" style="margin-bottom: 2px;"></i>
                <div>Master Aset</div>
            </a>
        </li> --}}
        <li class="menu-item">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-brand-tabler" style="margin-bottom: 2px;"></i>
                <div>Master Aset</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="" class="menu-link">
                        <div>List Aset</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="" class="menu-link">
                        <div>Permintaan Aset</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="" class="menu-link">
                        <div>Lokasi Aset</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="" class="menu-link">
                        <div>Status & Kondisi Aset</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-brand-tabler" style="margin-bottom: 2px;"></i>
                <div>Transaksi</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="" class="menu-link">
                        <div>Peminjaman</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="" class="menu-link">
                        <div>Pengembalian</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-brand-tabler" style="margin-bottom: 2px;"></i>
                <div>Laporan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="" class="menu-link">
                        <div>Laporan Data Aset</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="" class="menu-link">
                        <div>Laporan Transaksi</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="" class="menu-link">
                        <div>Laporan Aktivitas</div>
                    </a>
                </li>
            </ul>
        </li>


        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Other</span>
        </li>
        {{-- @can('isOwner')
            <li class="menu-item>
                <a href="" class="menu-link">
                    <i class="menu-icon tf-icons ti bi-menu-button-fill" style="margin-bottom: 2px;"></i>
                    <div>Kelola Users</div>
                </a>
            </li>
        @endcan --}}
        <li class="menu-item">
            <a href="" class="menu-link">
                <i class="menu-icon tf-icons ti bi-google-play" style="margin-bottom: 2px;"></i>
                <div>Log Aktivitas</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="" class="menu-link">
                <i class="menu-icon tf-icons ti bi-person-video3" style="margin-bottom: 2px;"></i>
                <div>Kelola Users</div>
            </a>
        </li>
        
        {{-- @endif --}}
        {{-- <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons ti ti-code" style="margin-bottom: 2px;"></i>
                <div>Version 3.0</div>
                <div class="badge bg-label-success rounded-pill ms-auto">Current</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{!! route('logout') !!}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-logout" style="margin-bottom: 2px;"></i>
                <div>Log out</div>
            </a>
        </li> --}}
    </ul>
</aside>