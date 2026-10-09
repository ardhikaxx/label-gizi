@php
    $appName = \App\Models\ApplicationSetting::get('app_name', 'Label Gizi');
@endphp
<nav class="navbar navbar-expand-lg navbar-public sticky-top py-3">
    <div class="container">
        <a class="navbar-brand text-decoration-none" href="{{ route('public.home') }}">
            <span class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-apple-whole"></i>
            </span>
            <span class="fs-4">{{ $appName }}</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars text-success fs-4"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1 mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.home') ? 'active' : '' }}" href="{{ route('public.home') }}">
                        <i class="fa-solid fa-house me-1 opacity-75"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.labels*') ? 'active' : '' }}" href="{{ route('public.labels') }}">
                        <i class="fa-solid fa-utensils me-1 opacity-75"></i> Daftar Label Makanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.about') ? 'active' : '' }}" href="{{ route('public.about') }}">
                        <i class="fa-solid fa-circle-info me-1 opacity-75"></i> Tentang Informasi Gizi
                    </a>
                </li>
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    @auth
                        <a class="btn btn-outline-success btn-sm px-3 rounded-pill" href="{{ route('admin.dashboard') }}">
                            <i class="fa-solid fa-gauge me-1"></i> Dashboard Admin
                        </a>
                    @else
                        <a class="btn btn-light btn-sm text-muted px-3 rounded-pill" href="{{ route('admin.login') }}" title="Masuk Pengelola">
                            <i class="fa-solid fa-lock me-1"></i> Area Admin
                        </a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>
