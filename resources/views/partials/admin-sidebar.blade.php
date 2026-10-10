@php
    $appName = \App\Models\ApplicationSetting::get('app_name', 'Label Gizi');
@endphp
<aside class="admin-sidebar no-print">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand py-3">
        <img src="{{ asset('images/logo-bgn.png') }}" alt="Logo Badan Gizi Nasional" style="height: 38px; width: auto; object-fit: contain;" class="me-1">
        <div class="d-flex flex-column">
            <span class="fs-6 fw-bold lh-1 text-white" style="letter-spacing: 0.02em;">BADAN GIZI NASIONAL</span>
            <span class="small lh-1 mt-1 text-uppercase" style="font-size: 0.65rem; color: #d4a34b; font-weight: 600; letter-spacing: 0.06em;">Republik Indonesia</span>
        </div>
    </a>

    <ul class="sidebar-menu">
        <li class="sidebar-menu-header">Menu Utama</li>
        <li>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="sidebar-menu-header">Data & Label</li>
        <li>
            <a href="{{ route('admin.labels.index') }}" class="sidebar-link {{ request()->routeIs('admin.labels.index') || request()->routeIs('admin.labels.show') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i>
                <span>Kelola Label Makanan</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.labels.create') }}" class="sidebar-link {{ request()->routeIs('admin.labels.create') ? 'active' : '' }}">
                <i class="fa-solid fa-plus-circle"></i>
                <span>Tambah Label Baru</span>
            </a>
        </li>

        <li class="sidebar-menu-header">Sistem & Keamanan</li>
        <li>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i>
                <span>Manajemen Admin</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fa-solid fa-sliders"></i>
                <span>Pengaturan Sistem</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.activities.index') }}" class="sidebar-link {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Log Aktivitas</span>
            </a>
        </li>

        <li class="sidebar-menu-header">Akses Cepat</li>
        <li>
            <a href="{{ route('public.home') }}" target="_blank" class="sidebar-link" style="color: #87c3e3;">
                <i class="fa-solid fa-arrow-up-right-from-square" style="color: #87c3e3;"></i>
                <span>Lihat Website Publik</span>
            </a>
        </li>
    </ul>

    <div class="p-3 border-top border-secondary border-opacity-25 mt-auto">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2 overflow-hidden me-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 34px; height: 34px; flex-shrink: 0; background-color: #d4a34b; color: #071c3b;">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="text-truncate">
                    <div class="text-white small fw-bold text-truncate">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="text-truncate" style="font-size: 0.72rem; color: #87c3e3 !important;">{{ Auth::user()->email ?? '' }}</div>
                </div>
            </div>
            <button type="button" class="btn btn-outline-danger btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center btn-logout-trigger" style="width: 32px; height: 32px; flex-shrink: 0;" title="Keluar">
                <i class="fa-solid fa-right-from-bracket small"></i>
            </button>
        </div>
    </div>
</aside>
