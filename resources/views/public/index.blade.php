@extends('layouts.public')

@section('title', 'Beranda')
@section('meta_description', 'Sistem Informasi Transparansi Label Makanan Bergizi Gratis. Ketahui rincian menu hari ini, analisis nilai gizi makro, dan batas aman waktu konsumsi makanan.')

@section('content')
<!-- Hero Section -->
<section class="hero-section py-5">
    <div class="container py-lg-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="hero-badge mb-3">
                    <i class="fa-solid fa-shield-heart"></i>
                    <span>Transparansi Informasi Pangan Bergizi</span>
                </div>
                <h1 class="display-5 fw-bold text-dark lh-sm mb-3">
                    {{ $settings['hero_title']['value'] ?? 'Informasi Label Makanan Bergizi Gratis' }}
                </h1>
                <p class="lead text-muted mb-4 fs-6">
                    {{ $settings['hero_subtitle']['value'] ?? 'Masyarakat berhak mendapatkan informasi yang jelas dan akurat mengenai komposisi menu makanan, analisis kandungan zat gizi makro, serta petunjuk batas waktu aman konsumsi.' }}
                </p>

                <!-- Search / Filter Box -->
                <div class="card border-0 shadow-sm rounded-4 p-2 mb-4 bg-white">
                    <form action="{{ route('public.labels') }}" method="GET" class="row g-2 align-items-center p-2">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0 text-success"><i class="fa-solid fa-magnifying-glass"></i></span>
                                <input type="text" name="search" class="form-control border-0 ps-1" placeholder="Cari nama menu, misal: Ayam Bakar...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0 text-muted"><i class="fa-regular fa-calendar"></i></span>
                                <input type="date" name="date" class="form-control border-0 ps-1" title="Pilih Tanggal">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-medium shadow-sm">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <a href="{{ route('public.labels') }}" class="btn btn-success rounded-pill px-4 py-2 fw-semibold shadow-sm">
                        <i class="fa-solid fa-utensils me-2"></i> Lihat Semua Label Makanan
                    </a>
                    <a href="{{ route('public.about') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-medium">
                        <i class="fa-solid fa-circle-info me-2"></i> Panduan Gizi
                    </a>
                </div>
            </div>

            <div class="col-lg-5 text-center">
                <div class="position-relative d-inline-block">
                    <div class="card border-0 shadow rounded-5 overflow-hidden text-start p-4 bg-white" style="max-width: 420px; margin: 0 auto;">
                        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle" style="width: 32px; height: 32px;">
                                    <i class="fa-solid fa-apple-whole"></i>
                                </span>
                                <div>
                                    <div class="fw-bold text-dark small lh-1">Standar Label Pangan</div>
                                    <small class="text-muted" style="font-size: 0.75rem;">Pedoman Keamanan & Gizi</small>
                                </div>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 small fw-semibold">Terverifikasi</span>
                        </div>

                        <div class="mb-3">
                            <div class="small text-muted mb-1">5 Unsur Gizi Utama:</div>
                            <div class="d-flex justify-content-between gap-1 text-center">
                                <div class="bg-light p-2 rounded-3 flex-fill">
                                    <div class="fw-bold text-success small">Kalori</div>
                                    <small class="text-muted" style="font-size: 0.7rem;">Energi</small>
                                </div>
                                <div class="bg-light p-2 rounded-3 flex-fill">
                                    <div class="fw-bold text-dark small">Protein</div>
                                    <small class="text-muted" style="font-size: 0.7rem;">Jaringan</small>
                                </div>
                                <div class="bg-light p-2 rounded-3 flex-fill">
                                    <div class="fw-bold text-dark small">Lemak</div>
                                    <small class="text-muted" style="font-size: 0.7rem;">Cadangan</small>
                                </div>
                                <div class="bg-light p-2 rounded-3 flex-fill">
                                    <div class="fw-bold text-dark small">Karbo</div>
                                    <small class="text-muted" style="font-size: 0.7rem;">Aktivitas</small>
                                </div>
                                <div class="bg-light p-2 rounded-3 flex-fill">
                                    <div class="fw-bold text-dark small">Serat</div>
                                    <small class="text-muted" style="font-size: 0.7rem;">Pencernaan</small>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 bg-warning bg-opacity-10 rounded-3 border border-warning border-opacity-50">
                            <div class="d-flex align-items-center gap-2 text-warning mb-1">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <span class="fw-bold small text-dark">Batas Waktu Konsumsi</span>
                            </div>
                            <p class="mb-0 small text-secondary" style="font-size: 0.8rem;">
                                Informasi batas akhir dihitung secara relatif sejak waktu makanan diantarkan demi menjaga kesegaran dan higienitas pangan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Today's Featured Label Section (If Available) -->
@if($todayLabel)
<section class="py-5 bg-white border-bottom">
    <div class="container">
        <div class="text-center mb-4">
            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold small text-uppercase">
                <i class="fa-solid fa-star me-1"></i> Sajian Menu Hari Ini
            </span>
            <h2 class="fw-bold text-dark mt-2 mb-1">{{ $todayLabel->title }}</h2>
            <p class="text-muted small">
                Tanggal: <strong>{{ $todayLabel->menu_date->isoFormat('dddd, D MMMM Y') }}</strong>
                @if($todayLabel->recipient_group)
                    &bull; Sasaran: <span class="badge bg-light text-secondary border">{{ $todayLabel->recipient_group }}</span>
                @endif
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border border-success border-opacity-25 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <div class="row g-4 align-items-center">
                            <!-- Left: Menus -->
                            <div class="col-md-6 border-end-md">
                                <h6 class="fw-bold text-dark mb-3 text-uppercase small text-muted">Komposisi Menu Makanan:</h6>
                                <div class="d-flex flex-column gap-2 mb-4">
                                    @foreach($todayLabel->menus as $item)
                                        <div class="d-flex align-items-center gap-3 p-2 rounded-3 bg-light">
                                            <span class="badge bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                                {{ $item->sort_order }}
                                            </span>
                                            <span class="fw-semibold text-dark">{{ $item->name }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="consumption-limit-alert p-3">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <i class="fa-solid fa-hourglass-half"></i>
                                        <strong>Batas Akhir Konsumsi:</strong>
                                    </div>
                                    <div class="limit-badge fs-6">
                                        {{ $todayLabel->formatted_consumption_limit }}
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        * Dihitung sejak waktu makanan diantarkan.
                                    </small>
                                </div>
                            </div>

                            <!-- Right: Nutrition Grid -->
                            <div class="col-md-6">
                                <h6 class="fw-bold text-dark mb-3 text-uppercase small text-muted">Kandungan Zat Gizi Per Porsi:</h6>

                                <div class="p-3 bg-success bg-opacity-10 rounded-4 text-center mb-3">
                                    <span class="text-muted small fw-semibold text-uppercase">Energi Total</span>
                                    <div class="display-6 fw-bold text-success my-1">
                                        {{ number_format($todayLabel->energy, 0, ',', '.') }}
                                    </div>
                                    <span class="badge bg-success text-white rounded-pill px-3 py-1">kkal</span>
                                </div>

                                <div class="row g-2 text-center">
                                    <div class="col-6">
                                        <div class="p-3 bg-light rounded-3 border">
                                            <span class="text-muted small d-block">Protein</span>
                                            <span class="fs-5 fw-bold text-dark">{{ number_format($todayLabel->protein, 1, ',', '.') }}</span> <small class="text-muted">g</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 bg-light rounded-3 border">
                                            <span class="text-muted small d-block">Lemak</span>
                                            <span class="fs-5 fw-bold text-dark">{{ number_format($todayLabel->fat, 1, ',', '.') }}</span> <small class="text-muted">g</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 bg-light rounded-3 border">
                                            <span class="text-muted small d-block">Karbohidrat</span>
                                            <span class="fs-5 fw-bold text-dark">{{ number_format($todayLabel->carbohydrate, 1, ',', '.') }}</span> <small class="text-muted">g</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 bg-light rounded-3 border">
                                            <span class="text-muted small d-block">Serat</span>
                                            <span class="fs-5 fw-bold text-dark">{{ number_format($todayLabel->fiber, 1, ',', '.') }}</span> <small class="text-muted">g</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 text-center">
                                    <a href="{{ route('public.labels.show', $todayLabel->slug) }}" class="btn btn-success w-100 rounded-pill py-2 fw-semibold">
                                        <i class="fa-solid fa-eye me-1"></i> Lihat Rincian Label Lengkap
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Latest Published Labels Grid -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
            <div>
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold small text-uppercase">Arsip & Publikasi</span>
                <h3 class="fw-bold text-dark mt-2 mb-1">Daftar Label Makanan Terbaru</h3>
                <p class="text-muted small mb-0">Informasi label menu yang telah diverifikasi dan dipublikasikan resmi.</p>
            </div>
            <a href="{{ route('public.labels') }}" class="btn btn-outline-success btn-sm rounded-pill px-4">
                Lihat Semua Label <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        @if($recentLabels->isEmpty() && ! $todayLabel)
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                <i class="fa-solid fa-utensils fs-1 text-muted mb-3 opacity-25"></i>
                <h5 class="fw-bold text-dark mb-1">Belum Ada Label Makanan yang Dipublikasikan</h5>
                <p class="text-muted small mb-0">Silakan kembali lagi nanti untuk melihat jadwal dan informasi label gizi terbaru.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($recentLabels as $lbl)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 nutrition-card p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-light text-success border fw-semibold">
                                        <i class="fa-regular fa-calendar me-1"></i> {{ $lbl->menu_date->isoFormat('D MMM Y') }}
                                    </span>
                                    @if($lbl->recipient_group)
                                        <span class="badge bg-light text-secondary border small">{{ $lbl->recipient_group }}</span>
                                    @endif
                                </div>

                                <h5 class="fw-bold text-dark mb-3">
                                    <a href="{{ route('public.labels.show', $lbl->slug) }}" class="text-decoration-none text-dark hover-success">
                                        {{ $lbl->title }}
                                    </a>
                                </h5>

                                <!-- Menu Items snippet -->
                                <div class="mb-3">
                                    <small class="text-muted fw-bold d-block mb-1 text-uppercase" style="font-size: 0.72rem;">Menu Utama:</small>
                                    <ul class="list-unstyled small mb-0 d-flex flex-column gap-1">
                                        @foreach($lbl->menus->take(3) as $m)
                                            <li class="text-truncate text-secondary">
                                                <i class="fa-solid fa-circle-check text-success small me-1"></i> {{ $m->name }}
                                            </li>
                                        @endforeach
                                        @if($lbl->menus->count() > 3)
                                            <li class="text-muted small fst-italic">+{{ $lbl->menus->count() - 3 }} menu lainnya</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <div class="pt-3 border-top mt-3">
                                <!-- Nutrition Summary Pills -->
                                <div class="d-flex justify-content-between text-center gap-1 mb-3">
                                    <div class="nutrition-pill flex-fill">
                                        <div class="nutrition-pill-val text-success">{{ number_format($lbl->energy, 0, ',', '.') }}</div>
                                        <div class="nutrition-pill-label">Kkal</div>
                                    </div>
                                    <div class="nutrition-pill flex-fill">
                                        <div class="nutrition-pill-val">{{ number_format($lbl->protein, 1, ',', '.') }}</div>
                                        <div class="nutrition-pill-label">Prot (g)</div>
                                    </div>
                                    <div class="nutrition-pill flex-fill">
                                        <div class="nutrition-pill-val">{{ number_format($lbl->fat, 1, ',', '.') }}</div>
                                        <div class="nutrition-pill-label">Lemak (g)</div>
                                    </div>
                                    <div class="nutrition-pill flex-fill">
                                        <div class="nutrition-pill-val">{{ number_format($lbl->carbohydrate, 1, ',', '.') }}</div>
                                        <div class="nutrition-pill-label">Karbo (g)</div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between gap-2">
                                    <span class="small text-muted" title="{{ $lbl->formatted_consumption_limit }}">
                                        <i class="fa-regular fa-clock text-warning me-1"></i> Maks. {{ $lbl->consumption_limit_hours }} jam
                                    </span>
                                    <a href="{{ route('public.labels.show', $lbl->slug) }}" class="btn btn-outline-success btn-sm rounded-pill px-3">
                                        Lihat Detail <i class="fa-solid fa-arrow-right small ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Educational Section: Mengapa Informasi Gizi Penting? -->
<section class="py-5 bg-white border-top">
    <div class="container py-lg-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold small text-uppercase">Edukasi & Kesadaran Pangan</span>
                <h3 class="fw-bold text-dark mt-2 mb-3">
                    {{ $settings['education_title']['value'] ?? 'Mengapa Informasi Gizi dan Batas Konsumsi Penting?' }}
                </h3>
                <p class="text-muted leading-relaxed mb-4">
                    {{ $settings['education_text']['value'] ?? 'Label gizi memberikan kejelasan mengenai asupan zat gizi makro yang diterima tubuh. Selain itu, kepatuhan terhadap batas waktu konsumsi menjaga keamanan makanan dari bahaya mikrobiologis.' }}
                </p>
                <a href="{{ route('public.about') }}" class="btn btn-outline-success rounded-pill px-4 py-2">
                    Pelajari Selengkapnya <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-light">
                            <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px;">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Energi & Kalori</h5>
                            <p class="small text-muted mb-0">Sebagai bahan bakar utama metabolisme, aktivitas fisik harian, dan konsentrasi belajar generasi muda.</p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-light">
                            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px;">
                                <i class="fa-solid fa-dumbbell"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Protein Berkualitas</h5>
                            <p class="small text-muted mb-0">Mendukung pertumbuhan jaringan otot, regenerasi sel, dan menjaga kekebalan daya tahan tubuh.</p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-light">
                            <div class="rounded-circle bg-warning text-dark d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px;">
                                <i class="fa-solid fa-wheat-awn"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Karbohidrat & Serat</h5>
                            <p class="small text-muted mb-0">Sumber energi utama yang diserap secara stabil didampingi serat pangan untuk kesehatan saluran cerna.</p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-light">
                            <div class="rounded-circle bg-danger text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px;">
                                <i class="fa-solid fa-shield-virus"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Batas Aman Waktu</h5>
                            <p class="small text-muted mb-0">Makanan matang memiliki jendela waktu aman relatif setelah pengantaran agar bebas dari risiko bakteri.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
