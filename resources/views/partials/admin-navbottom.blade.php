<nav class="bgn-mobile-navbottom d-lg-none no-print" aria-label="Navigasi Bawah Pintar Mobile">
    <div class="bgn-mobile-navbottom-pill shadow-sm">
        {{-- 1. Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="bgn-navbottom-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           aria-label="Dashboard"
           title="Dashboard">
            <i class="fa-solid fa-gauge navbottom-icon"></i>
            <span class="navbottom-label">Dashboard</span>
        </a>

        {{-- 2. Kelola Label Makanan --}}
        <a href="{{ route('admin.labels.index') }}"
           class="bgn-navbottom-item {{ (request()->routeIs('admin.labels.index') || request()->routeIs('admin.labels.show') || request()->routeIs('admin.labels.edit')) ? 'active' : '' }}"
           aria-label="Kelola Label"
           title="Kelola Label">
            <i class="fa-solid fa-tags navbottom-icon"></i>
            <span class="navbottom-label">Label</span>
        </a>

        {{-- 3. Tambah Label Baru --}}
        <a href="{{ route('admin.labels.create') }}"
           class="bgn-navbottom-item {{ request()->routeIs('admin.labels.create') ? 'active' : '' }}"
           aria-label="Tambah Label"
           title="Tambah Label">
            <i class="fa-solid fa-circle-plus navbottom-icon"></i>
            <span class="navbottom-label">Tambah</span>
        </a>

        {{-- 4. Profil Saya --}}
        <a href="{{ route('admin.profile.show') }}"
           class="bgn-navbottom-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}"
           aria-label="Profil Saya"
           title="Profil Saya">
            <i class="fa-solid fa-circle-user navbottom-icon"></i>
            <span class="navbottom-label">Profil</span>
        </a>

        {{-- 5. Buka Menu Sidebar (Pengaturan, Users, Log, dll) --}}
        <button type="button"
                class="bgn-navbottom-item {{ (request()->routeIs('admin.users.*') || request()->routeIs('admin.settings.*') || request()->routeIs('admin.activities.*')) ? 'active' : '' }}"
                id="bottomSidebarToggleBtn"
                aria-label="Menu Lengkap"
                title="Menu Lengkap">
            <i class="fa-solid fa-bars-staggered navbottom-icon"></i>
            <span class="navbottom-label">Menu</span>
        </button>
    </div>
</nav>
