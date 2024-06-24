<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <span class="app-brand-logo demo" style="height: unset">
                <img style="height: 30px" src="{{ asset('save_image/logo_apk.png') }}" alt="img">
            </span>
            <span class="app-brand-text demo menu-text fw-bold">Tokogar</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @can('isOwner')
            <li class="menu-item  {{ Route::is('myadmin.dashboard*') ? 'active' : '' }}">
                <a href="{!! route('myadmin.dashboard') !!}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-apps" style="margin-bottom: 2px;"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>
        @endcan

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Tokogar.com</span>
        </li>
        <li class="menu-item {{ Route::is('myadmin.transaksi*') ? 'active' : '' }}">
            <a href="{!! route('myadmin.transaksi') !!}" class="menu-link">
                <i class="menu-icon tf-icons ti bi-cart3" style="margin-bottom: 2px;"></i>
                <div data-i18n="Auto Responders">Transaksi</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('myadmin.member*') ? 'active' : '' }}">
            <a href="{!! route('myadmin.member') !!}" class="menu-link">
                <i class="menu-icon tf-icons ti bi-people" style="margin-bottom: 2px;"></i>
                <div data-i18n="Phone Book">Member</div>
            </a>
        </li>


        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Apps Premium</span>
        </li>
        @can('isOwner')
            <li class="menu-item {{ Route::is('myadmin.apps') ? 'active' : '' }}">
                <a href="{!! route('myadmin.apps') !!}" class="menu-link">
                    <i class="menu-icon tf-icons ti bi-menu-button-fill" style="margin-bottom: 2px;"></i>
                    <div data-i18n="Auto Responders">Kelola Apps</div>
                </a>
            </li>
        @endcan
        <li class="menu-item {{ Route::is('myadmin.apps.buyer*') ? 'active' : '' }}">
            <a href="{!! route('myadmin.apps.buyer') !!}" class="menu-link">
                <i class="menu-icon tf-icons ti bi-google-play" style="margin-bottom: 2px;"></i>
                <div data-i18n="Auto Responders">Stock Buyer</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('myadmin.apps.admin*') ? 'active' : '' }}">
            <a href="{!! route('myadmin.apps.admin') !!}" class="menu-link">
                <i class="menu-icon tf-icons ti bi-person-video3" style="margin-bottom: 2px;"></i>
                <div data-i18n="Phone Book">Stock Admin</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Other</span>
        </li>
        @can('isOwner')
            <li class="menu-item {{ Route::is('files') ? 'active' : '' }}">
                <a href="#" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-folder" style="margin-bottom: 2px;"></i>
                    <div data-i18n="File Manager">File Manager</div>
                </a>
            </li>
            {{-- @if ($auth->role == 'admin') --}}
            <li class="menu-item {{ Route::is('admin*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-brand-tabler" style="margin-bottom: 2px;"></i>
                    <div data-i18n="Admin Menu">Admin Menu</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <div data-i18n="Manage Users">Manage Users</div>
                        </a>
                    </li>
                    {{-- <li class="menu-item">
                            <a href="{!! route('admin.settings') !!}" class="menu-link">
                                <div data-i18n="Settings">Settings</div>
                            </a>
                        </li> --}}
                </ul>
            </li>
        @endcan
        {{-- @endif --}}
        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons ti ti-code" style="margin-bottom: 2px;"></i>
                <div data-i18n="Version 3.0.0">Version 3.0</div>
                <div class="badge bg-label-success rounded-pill ms-auto">Current</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{!! route('logout') !!}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-logout" style="margin-bottom: 2px;"></i>
                <div data-i18n="Log out">Log out</div>
            </a>
        </li>
    </ul>
</aside>