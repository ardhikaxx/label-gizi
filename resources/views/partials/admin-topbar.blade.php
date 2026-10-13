<header class="admin-topbar no-print">
    <div class="d-flex align-items-center gap-2 gap-sm-3 overflow-hidden">
        <button class="btn btn-sm btn-outline-secondary d-lg-none rounded-3 px-2 py-1 shadow-sm sidebar-toggle-btn" type="button" id="sidebarToggleBtn" aria-label="Buka Menu Navigasi" style="color: #0b2853; border-color: #dbe6f2; min-width: 36px; min-height: 36px; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <i class="fa-solid fa-bars fs-6"></i>
        </button>
        <div class="overflow-hidden">
            <div class="d-flex align-items-center gap-2">
                <h5 class="mb-0 fw-bold text-dark text-truncate" style="font-size: 1rem;">@yield('page_title', 'Dashboard')</h5>
                <span class="badge rounded-pill text-uppercase d-none d-xl-inline-block" style="background: rgba(11, 40, 83, 0.08); color: #0b2853; font-weight: 700; font-size: 0.68rem; letter-spacing: 0.03em;">
                    <i class="fa-solid fa-building-flag me-1" style="color: #d4a34b;"></i> SPPG KAUMAN SOMOROTO
                </span>
            </div>
            <small class="text-muted d-none d-sm-inline">
                <i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </small>
        </div>
    </div>

    <div class="d-flex align-items-center gap-2 flex-shrink-0">
        <a href="{{ route('public.home') }}" target="_blank" class="btn btn-sm btn-topbar-public d-none d-md-inline-flex align-items-center gap-2 rounded-pill px-3">
            <i class="fa-solid fa-arrow-up-right-from-square small topbar-public-icon"></i>
            <span>Halaman Publik</span>
        </a>

        <div class="dropdown flex-shrink-0">
            <button class="btn btn-light btn-sm border dropdown-toggle d-flex align-items-center gap-2 rounded-pill px-2 px-sm-3" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-color: #dbe6f2 !important;">
                <span class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; background: rgba(11, 40, 83, 0.1); color: #0b2853; flex-shrink: 0;">
                    <i class="fa-solid fa-shield-halved small"></i>
                </span>
                <span class="fw-semibold text-dark text-truncate d-none d-sm-inline" style="max-width: 130px;">{{ Auth::user()->name ?? 'Administrator' }}</span>
                <span class="fw-semibold text-dark text-truncate d-inline d-sm-none" style="max-width: 75px;">{{ \Illuminate\Support\Str::limit(Auth::user()->name ?? 'Admin', 8) }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                <li><span class="dropdown-header small text-muted">Akun Administrator</span></li>
                <li><a class="dropdown-item" href="{{ route('admin.profile.show') }}"><i class="fa-solid fa-circle-user me-2 text-muted"></i> Profil Saya</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.users.index') }}"><i class="fa-solid fa-user me-2 text-muted"></i> Manajemen Admin</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-sliders me-2 text-muted"></i> Pengaturan Aplikasi</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <button type="button" class="dropdown-item text-danger btn-logout-trigger">
                        <i class="fa-solid fa-right-from-bracket me-2"></i> Keluar (Logout)
                    </button>
                </li>
            </ul>
        </div>
    </div>
</header>
