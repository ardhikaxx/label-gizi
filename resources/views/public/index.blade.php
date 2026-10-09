@extends('layouts.public')

@section('title', 'Sajian Menu Hari Ini')
@section('meta_description', 'Informasi resmi Sajian Menu Makanan Bergizi Hari Ini, rincian hidangan, analisis nilai zat gizi makro, dan petunjuk batas akhir konsumsi.')

@section('hide_navbar', 'true')
@section('hide_footer', 'true')

@section('content')
<div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-4 py-md-5 bg-brand-soft">
    <div class="container py-2">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">

                @if($todayLabel)
                    <!-- Card Utama Sajian Menu Hari Ini -->
                    <div class="card border-0 shadow rounded-5 overflow-hidden bg-white">
                        <!-- Header Banner -->
                        <div class="p-4 p-md-5 text-center bg-white border-bottom position-relative">
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-success bg-opacity-10 text-success rounded-pill fw-bold small text-uppercase mb-3">
                                <i class="fa-solid fa-apple-whole"></i>
                                <span>Sajian Menu Hari Ini</span>
                            </div>

                            <h1 class="display-6 fw-bold text-dark mb-2">
                                {{ $todayLabel->title }}
                            </h1>

                            <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap text-muted small mt-2">
                                <span class="badge bg-light text-success border px-3 py-2 rounded-pill fs-6 fw-semibold">
                                    <i class="fa-regular fa-calendar-check me-1"></i> {{ $todayLabel->menu_date->isoFormat('dddd, D MMMM Y') }}
                                </span>
                                @if($todayLabel->recipient_group)
                                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill fs-6 fw-medium">
                                        <i class="fa-solid fa-users me-1 text-muted"></i> {{ $todayLabel->recipient_group }}
                                    </span>
                                @endif
                            </div>

                            @if($todayLabel->description)
                                <p class="text-muted small mt-3 mb-0 mx-auto" style="max-width: 650px;">
                                    {{ $todayLabel->description }}
                                </p>
                            @endif
                        </div>

                        <!-- Body Konten -->
                        <div class="card-body p-4 p-md-5">
                            <div class="row g-4 g-lg-5 align-items-stretch">

                                <!-- Kolom Kiri: Rincian Menu & Batas Waktu -->
                                <div class="col-md-6 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <span class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle" style="width: 28px; height: 28px;">
                                                <i class="fa-solid fa-utensils small"></i>
                                            </span>
                                            <h5 class="fw-bold text-dark mb-0">Rincian Menu Makanan</h5>
                                        </div>

                                        <div class="d-flex flex-column gap-2 mb-4">
                                            @foreach($todayLabel->menus as $item)
                                                <div class="d-flex align-items-center gap-3 p-3 rounded-4 bg-light border-start border-success border-4 shadow-sm">
                                                    <span class="badge bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 28px; height: 28px; flex-shrink: 0;">
                                                        {{ $item->sort_order }}
                                                    </span>
                                                    <span class="fs-6 fw-semibold text-dark">{{ $item->name }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Batas Akhir Konsumsi Alert -->
                                    <div class="consumption-limit-alert rounded-4 p-3 p-md-4 shadow-sm mt-3">
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="rounded-circle bg-warning bg-opacity-25 text-warning d-flex align-items-center justify-content-center p-2 flex-shrink-0" style="width: 38px; height: 38px;">
                                                <i class="fa-solid fa-clock-rotate-left fs-5 text-warning"></i>
                                            </div>
                                            <div>
                                                <div class="small fw-bold text-dark text-uppercase">Batas Akhir Konsumsi:</div>
                                                <div class="limit-badge fs-5 my-1">
                                                    {{ $todayLabel->formatted_consumption_limit }}
                                                </div>
                                                <small class="text-muted d-block leading-normal" style="font-size: 0.78rem;">
                                                    * Waktu aman konsumsi dihitung relatif sejak makanan diantarkan.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kolom Kanan: Analisis Zat Gizi -->
                                <div class="col-md-6 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <span class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle" style="width: 28px; height: 28px;">
                                                <i class="fa-solid fa-chart-pie small"></i>
                                            </span>
                                            <h5 class="fw-bold text-dark mb-0">Analisis Zat Gizi Per Porsi</h5>
                                        </div>

                                        <!-- Energi Utama -->
                                        <div class="p-4 bg-success bg-opacity-10 rounded-4 text-center mb-4 border border-success border-opacity-25 shadow-sm">
                                            <span class="text-muted small fw-semibold text-uppercase tracking-wider">Energi Total</span>
                                            <div class="display-5 fw-bold text-success my-1">
                                                {{ number_format($todayLabel->energy, 0, ',', '.') }}
                                            </div>
                                            <span class="badge bg-success text-white rounded-pill px-3 py-1 fw-bold">kkal</span>
                                        </div>

                                        <!-- Nutrisi Makro Grid -->
                                        <div class="row g-3 text-center">
                                            <div class="col-6">
                                                <div class="p-3 bg-light rounded-4 border shadow-sm">
                                                    <span class="text-muted small d-block mb-1">Protein</span>
                                                    <span class="fs-4 fw-bold text-dark">{{ number_format($todayLabel->protein, 1, ',', '.') }}</span>
                                                    <span class="text-muted small">g</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-3 bg-light rounded-4 border shadow-sm">
                                                    <span class="text-muted small d-block mb-1">Lemak</span>
                                                    <span class="fs-4 fw-bold text-dark">{{ number_format($todayLabel->fat, 1, ',', '.') }}</span>
                                                    <span class="text-muted small">g</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-3 bg-light rounded-4 border shadow-sm">
                                                    <span class="text-muted small d-block mb-1">Karbohidrat</span>
                                                    <span class="fs-4 fw-bold text-dark">{{ number_format($todayLabel->carbohydrate, 1, ',', '.') }}</span>
                                                    <span class="text-muted small">g</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-3 bg-light rounded-4 border shadow-sm">
                                                    <span class="text-muted small d-block mb-1">Serat Pangan</span>
                                                    <span class="fs-4 fw-bold text-dark">{{ number_format($todayLabel->fiber, 1, ',', '.') }}</span>
                                                    <span class="text-muted small">g</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-3 border-top text-center text-muted small" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-shield-halved text-success me-1"></i>
                                        Standar Mutu Makanan Bergizi &bull; Transparansi Informasi Pangan Sehat
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty State jika belum ada label sama sekali -->
                    <div class="card border-0 shadow rounded-5 p-5 text-center bg-white">
                        <i class="fa-solid fa-utensils fs-1 text-muted mb-3 opacity-25"></i>
                        <h4 class="fw-bold text-dark mb-2">Belum Ada Sajian Menu Hari Ini</h4>
                        <p class="text-muted small mb-0">Informasi menu makanan bergizi hari ini belum dipublikasikan oleh pengelola.</p>
                    </div>
                @endif

                <!-- Tautan Akses Administrator yang Diskrit di Bagian Bawah Layar -->
                <div class="text-center mt-4">
                    <a href="{{ route('admin.login') }}" class="text-decoration-none text-muted small opacity-50 hover-opacity-100" style="font-size: 0.75rem;" title="Akses Administrator">
                        <i class="fa-solid fa-lock me-1"></i> Akses Pengelola
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
