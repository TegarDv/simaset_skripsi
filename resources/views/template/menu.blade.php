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
        <li class="menu-item {{ Route::is('dashboard*') ? 'active' : '' }}">
            <a href="{!! route('dashboard.index') !!}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-apps" style="margin-bottom: 2px;"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Menu</span>
        </li>
        <li class="menu-item {{ Route::is('asset-*') ? 'active' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti bi-box-seam" style="margin-bottom: 2px;"></i>
                <div>Master Aset</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('asset-list*') ? 'active' : '' }}">
                    <a href="{!! route('asset-list.index') !!}" class="menu-link">
                        <div>List Aset</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('asset-permintaan*') ? 'active' : '' }}">
                    <a href="{!! route('asset-permintaan.index') !!}" class="menu-link">
                        <div>Permintaan Aset</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('asset-location*') ? 'active' : '' }}">
                    <a href="{!! route('asset-location.index') !!}" class="menu-link">
                        <div>Lokasi Aset</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('asset-status*') ? 'active' : '' }}">
                    <a href="{!! route('asset-status.index') !!}" class="menu-link">
                        <div>Status & Kondisi Aset</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ Route::is('transaksi-*') ? 'active' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti bi-repeat" style="margin-bottom: 2px;"></i>
                <div>Transaksi</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('transaksi-pinjam*') ? 'active' : '' }}">
                    <a href="{!! route('transaksi-pinjam.index') !!}" class="menu-link">
                        <div>Peminjaman</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('transaksi-kembali*') ? 'active' : '' }}">
                    <a href="{!! route('transaksi-kembali.index') !!}" class="menu-link">
                        <div>Pengembalian</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ Route::is('laporan-*') ? 'active' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti bi-printer" style="margin-bottom: 2px;"></i>
                <div>Laporan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('laporan-assets*') ? 'active' : '' }}">
                    <a href="{!! route('laporan-assets.index') !!}" class="menu-link">
                        <div>Laporan Data Aset</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('laporan-transaksi*') ? 'active' : '' }}">
                    <a href="{!! route('laporan-transaksi.index') !!}" class="menu-link">
                        <div>Laporan Transaksi</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('laporan-activity*') ? 'active' : '' }}">
                    <a href="{!! route('laporan-activity.index') !!}" class="menu-link">
                        <div>Laporan Aktivitas</div>
                    </a>
                </li>
            </ul>
        </li>


        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Other</span>
        </li>
        <li class="menu-item {{ Route::is('log-user*') ? 'active' : '' }}">
            <a href="{!! route('log-user.index') !!}" class="menu-link">
                <i class="menu-icon tf-icons ti bi-activity" style="margin-bottom: 2px;"></i>
                <div>Log Aktivitas</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('users*') ? 'active' : '' }}">
            <a href="{!! route('users.index') !!}" class="menu-link">
                <i class="menu-icon tf-icons ti bi-people" style="margin-bottom: 2px;"></i>
                <div>Kelola Users</div>
            </a>
        </li>
    </ul>
</aside>