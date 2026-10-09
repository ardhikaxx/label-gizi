@extends('layouts.public')

@section('title', 'Sajian Menu Hari Ini')
@section('meta_description', 'Informasi resmi Sajian Menu Makanan Bergizi Hari Ini, rincian hidangan, analisis nilai zat gizi makro, dan petunjuk batas akhir konsumsi.')

@section('content')
<div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-4 px-3 bg-light">
    <div class="container my-auto" style="max-width: 840px;">
        <div class="row justify-content-center">
            <div class="col-12">

                @if($todayLabel)
                    <!-- Card Utama Sajian Menu Hari Ini (Simple & Bersih) -->
                    <div class="card border shadow-sm rounded-4 overflow-hidden bg-white">
                        <!-- Header Menu -->
                        <div class="p-3 p-md-4 text-center border-bottom bg-white">
                            <div class="d-inline-flex align-items-center gap-1 px-3 py-1 bg-success bg-opacity-10 text-success rounded-pill fw-semibold small mb-2">
                                <i class="fa-solid fa-leaf"></i>
                                <span>Sajian Menu Hari Ini</span>
                            </div>

                            <h1 class="h3 fw-bold text-dark mb-2">
                                {{ $todayLabel->title }}
                            </h1>

                            <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap text-muted small">
                                <span class="badge bg-light text-secondary border px-3 py-1.5 rounded-pill fw-medium">
                                    <i class="fa-regular fa-calendar-check text-success me-1"></i> {{ $todayLabel->menu_date->isoFormat('dddd, D MMMM Y') }}
                                </span>
                            </div>
                        </div>

                        <!-- Body Konten -->
                        <div class="card-body p-3 p-md-4">
                            <div class="row g-4 align-items-start">

                                <!-- Bagian Analisis Zat Gizi Per Porsi (DI ATAS PADA MOBILE: order-1) -->
                                <div class="col-md-6 order-1 order-md-2">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <span class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle" style="width: 26px; height: 26px;">
                                            <i class="fa-solid fa-chart-pie small"></i>
                                        </span>
                                        <h6 class="fw-bold text-dark mb-0 text-uppercase tracking-wider" style="font-size: 0.82rem;">
                                            Analisis Zat Gizi Per Porsi
                                        </h6>
                                    </div>

                                    <!-- Energi Total -->
                                    <div class="p-3 bg-success bg-opacity-10 rounded-3 text-center mb-3 border border-success border-opacity-25">
                                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Energi Total</span>
                                        <div class="display-6 fw-bold text-success my-1">
                                            {{ number_format($todayLabel->energy, 0, ',', '.') }}
                                        </div>
                                        <span class="badge bg-success text-white rounded-pill px-2.5 py-1 small">kkal / porsi</span>
                                    </div>

                                    <!-- 4 Nutrisi Makro Grid -->
                                    <div class="row g-2 text-center">
                                        <div class="col-6">
                                            <div class="p-2.5 bg-light rounded-3 border">
                                                <span class="text-muted small d-block mb-1">Protein</span>
                                                <span class="fs-5 fw-bold text-dark">{{ number_format($todayLabel->protein, 1, ',', '.') }}</span>
                                                <span class="text-muted small">g</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-2.5 bg-light rounded-3 border">
                                                <span class="text-muted small d-block mb-1">Lemak</span>
                                                <span class="fs-5 fw-bold text-dark">{{ number_format($todayLabel->fat, 1, ',', '.') }}</span>
                                                <span class="text-muted small">g</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-2.5 bg-light rounded-3 border">
                                                <span class="text-muted small d-block mb-1">Karbohidrat</span>
                                                <span class="fs-5 fw-bold text-dark">{{ number_format($todayLabel->carbohydrate, 1, ',', '.') }}</span>
                                                <span class="text-muted small">g</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-2.5 bg-light rounded-3 border">
                                                <span class="text-muted small d-block mb-1">Serat Pangan</span>
                                                <span class="fs-5 fw-bold text-dark">{{ number_format($todayLabel->fiber, 1, ',', '.') }}</span>
                                                <span class="text-muted small">g</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3 text-center text-muted" style="font-size: 0.72rem;">
                                        <i class="fa-solid fa-shield-halved text-success me-1"></i> Standar Gizi Terpenuhi & Transparan
                                    </div>
                                </div>

                                <!-- Bagian Rincian Menu Makanan & Batas Akhir Konsumsi (DI BAWAH PADA MOBILE: order-2) -->
                                <div class="col-md-6 order-2 order-md-1">
                                    @if($todayLabel->image)
                                        <div class="mb-3 rounded-3 overflow-hidden border shadow-sm">
                                            <img src="{{ $todayLabel->image_url }}" alt="{{ $todayLabel->title }}" class="img-fluid w-100 object-fit-cover" style="max-height: 220px;" loading="lazy" decoding="async">
                                        </div>
                                    @endif

                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <span class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle" style="width: 26px; height: 26px;">
                                            <i class="fa-solid fa-utensils small"></i>
                                        </span>
                                        <h6 class="fw-bold text-dark mb-0 text-uppercase tracking-wider" style="font-size: 0.82rem;">
                                            Rincian Menu Makanan
                                        </h6>
                                    </div>

                                    <!-- Daftar Item Menu -->
                                    <div class="list-group list-group-flush border rounded-3 mb-3">
                                        @foreach($todayLabel->menus as $item)
                                            <div class="list-group-item d-flex align-items-center gap-2.5 py-2 px-3 border-bottom">
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center fw-bold" style="width: 22px; height: 22px; font-size: 0.72rem; flex-shrink: 0;">
                                                    {{ $item->sort_order }}
                                                </span>
                                                <span class="fw-medium text-dark small">{{ $item->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Batas Akhir Konsumsi -->
                                    <div class="consumption-limit-alert rounded-3 p-3">
                                        <div class="d-flex align-items-start gap-2.5">
                                            <i class="fa-solid fa-clock-rotate-left fs-5 mt-0.5"></i>
                                            <div>
                                                <div class="small fw-bold text-uppercase" style="font-size: 0.75rem;">Batas Akhir Konsumsi:</div>
                                                <div class="limit-badge fs-6 my-0.5">
                                                    {{ $todayLabel->formatted_consumption_limit }}
                                                </div>
                                                <small class="d-block opacity-75" style="font-size: 0.72rem;">
                                                    * Dihitung relatif sejak makanan diantarkan.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty State jika belum ada label menu hari ini -->
                    <div class="card border shadow-sm rounded-4 p-4 p-md-5 text-center bg-white">
                        <i class="fa-solid fa-utensils fs-2 text-muted mb-3 opacity-50"></i>
                        <h5 class="fw-bold text-dark mb-1">Belum Ada Sajian Menu Hari Ini</h5>
                        <p class="text-muted small mb-0">Informasi menu makanan bergizi hari ini belum dipublikasikan oleh pengelola.</p>
                    </div>
                @endif

                <!-- Tautan Akses Administrator Diskrit -->
                <div class="text-center mt-3">
                    <a href="{{ route('admin.login') }}" class="text-decoration-none text-muted small opacity-50 hover-opacity-100" style="font-size: 0.75rem;" title="Akses Administrator">
                        <i class="fa-solid fa-lock me-1"></i> Akses Pengelola
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
