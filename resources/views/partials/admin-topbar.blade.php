<header class="admin-topbar no-print">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-sm btn-outline-secondary d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminSidebarCollapse" aria-expanded="false">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div>
            <h5 class="mb-0 fw-bold text-dark">@yield('page_title', 'Dashboard')</h5>
            <small class="text-muted d-none d-sm-inline">
                <i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </small>
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('public.home') }}" target="_blank" class="btn btn-outline-secondary btn-sm d-none d-md-inline-flex align-items-center gap-1 rounded-pill px-3" style="border-color: #dbe6f2; color: #0b2853;">
            <i class="fa-solid fa-arrow-up-right-from-square small" style="color: #d4a34b;"></i> Halaman Publik
        </a>

        <div class="dropdown">
            <button class="btn btn-light btn-sm border dropdown-toggle d-flex align-items-center gap-2 rounded-pill px-3" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-color: #dbe6f2 !important;">
                <span class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; background: rgba(11, 40, 83, 0.1); color: #0b2853;">
                    <i class="fa-solid fa-shield-halved small"></i>
                </span>
                <span class="fw-semibold text-dark">{{ Auth::user()->name ?? 'Administrator' }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                <li><span class="dropdown-header small text-muted">Akun Administrator</span></li>
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
