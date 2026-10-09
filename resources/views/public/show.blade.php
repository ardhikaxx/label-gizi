@extends('layouts.public')

@section('title', $label->title)
@section('meta_description', 'Label makanan bergizi untuk ' . $label->title . ' tanggal ' . $label->menu_date->isoFormat('D MMMM Y') . '. Kandungan energi ' . number_format($label->energy, 0, ',', '.') . ' kkal, protein ' . number_format($label->protein, 1, ',', '.') . 'g. Batas akhir konsumsi: ' . $label->formatted_consumption_limit . '.')

@section('content')
<div class="bg-light py-4 border-bottom">
    <div class="container">
        <!-- Breadcrumb & Nav -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('public.home') }}" class="text-decoration-none text-muted">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('public.labels') }}" class="text-decoration-none text-muted">Daftar Label</a></li>
                    <li class="breadcrumb-item active text-success fw-semibold" aria-current="page">{{ $label->title }}</li>
                </ol>
            </nav>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('public.labels.print', $label->slug) }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-print me-1"></i> Cetak Format Stiker
                </a>
                <a href="{{ route('public.labels') }}" class="btn btn-light border btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">

    @if($isPreview)
        <div class="alert alert-warning border-warning d-flex align-items-center gap-3 mb-4 rounded-4 shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation fs-4 text-warning"></i>
            <div>
                <strong>Perhatian: Halaman Mode Pratinjau Administrator</strong><br>
                <small>Label ini berstatus <strong>{{ $label->status_label }}</strong> dan belum dapat diakses oleh masyarakat umum sebelum diterbitkan secara resmi.</small>
            </div>
        </div>
    @endif

    <div class="row g-5 justify-content-center">
        <!-- Left Column: Menu Breakdown & Details -->
        <div class="col-lg-7">

            <!-- Title & Metadata -->
            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold small">
                        <i class="fa-regular fa-calendar-check me-1"></i> {{ $label->menu_date->isoFormat('dddd, D MMMM Y') }}
                    </span>
                    @if($label->recipient_group)
                        <span class="badge bg-light text-secondary border rounded-pill px-3 py-1 small">
                            <i class="fa-solid fa-users me-1 text-muted"></i> {{ $label->recipient_group }}
                        </span>
                    @endif
                </div>

                <h1 class="fw-bold text-dark mb-2">{{ $label->title }}</h1>

                @if($label->description)
                    <p class="text-muted leading-relaxed">{{ $label->description }}</p>
                @endif
            </div>

            <!-- Rincian Menu Makanan -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-utensils text-success me-2"></i> Komposisi Menu Makanan
                    </h5>
                    <small class="text-muted">Daftar makanan yang disajikan dalam satu paket menu:</small>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex flex-column gap-2">
                        @foreach($label->menus as $item)
                            <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border-start border-success border-4">
                                <span class="badge bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 26px; height: 26px;">
                                    {{ $item->sort_order }}
                                </span>
                                <span class="fs-6 fw-semibold text-dark">{{ $item->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Batas Waktu Konsumsi Aman Callout -->
            <div class="consumption-limit-alert rounded-4 p-4 mb-4 shadow-sm">
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-25 text-warning d-flex align-items-center justify-content-center p-3 flex-shrink-0">
                        <i class="fa-solid fa-clock-rotate-left fs-3 text-warning"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Petunjuk Batas Akhir Konsumsi</h5>
                        <div class="limit-badge fs-5 mb-2">
                            {{ $label->formatted_consumption_limit }}
                        </div>
                        <p class="small text-muted mb-0 leading-relaxed">
                            Batas waktu konsumsi ini dihitung secara relatif sejak waktu makanan tiba atau diantarkan kepada penerima. Pastikan makanan dinikmati dalam kurun waktu tersebut untuk menjaga standar higienitas, cita rasa, dan kualitas nilai gizi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Transparency Disclaimer -->
            <div class="p-3 bg-white border rounded-4 small text-muted">
                <i class="fa-solid fa-circle-check text-success me-1"></i>
                <strong>Transparansi Informasi Publik:</strong> Kandungan zat gizi ini dihitung berdasarkan resep standar dan telah diverifikasi oleh petugas pengelola pangan. Informasi ini disediakan untuk transparansi penerima manfaat.
            </div>

        </div>

        <!-- Right Column: Nutrition Sticker (Nutrition Facts) -->
        <div class="col-lg-5">
            <div class="sticky-top" style="top: 100px;">
                <div class="nutrition-facts-box shadow rounded-4 p-4 bg-white">
                    <div class="text-center pb-2 border-bottom border-dark border-3">
                        <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                            <i class="fa-solid fa-apple-whole text-success fs-3"></i>
                            <h4 class="fw-black text-uppercase text-dark mb-0 tracking-tight" style="font-weight: 900; letter-spacing: -0.5px;">
                                INFORMASI NILAI GIZI
                            </h4>
                        </div>
                        <div class="small fw-bold text-secondary text-uppercase" style="letter-spacing: 1px;">
                            KANDUNGAN GIZI MAKANAN BERGIZI
                        </div>
                    </div>

                    <div class="py-2 border-bottom border-dark small text-muted">
                        <div>Ukuran Sajian: <strong>1 Paket / Porsi Lengkap</strong></div>
                        <div>Tanggal Penyajian: <strong>{{ $label->menu_date->isoFormat('D MMMM Y') }}</strong></div>
                    </div>

                    <!-- Energi Total -->
                    <div class="py-3 border-bottom border-dark border-4 d-flex justify-content-between align-items-baseline">
                        <div>
                            <div class="small fw-bold text-dark text-uppercase">Jumlah Per Porsi</div>
                            <div class="fs-4 fw-black text-dark" style="font-weight: 900;">ENERGI TOTAL</div>
                        </div>
                        <div class="text-end">
                            <span class="fs-1 fw-black text-success lh-1" style="font-weight: 900;">{{ number_format($label->energy, 0, ',', '.') }}</span>
                            <span class="fs-6 fw-bold text-muted ms-1">kkal</span>
                        </div>
                    </div>

                    <!-- Nutrisi Makro Breakdown -->
                    <div class="py-2">
                        <div class="text-end small fw-bold text-muted border-bottom pb-1 mb-1">Kandungan Zat Gizi</div>

                        <div class="nutrition-facts-row">
                            <span><strong>Lemak Total</strong></span>
                            <span class="fw-bold">{{ number_format($label->fat, 1, ',', '.') }} g</span>
                        </div>

                        <div class="nutrition-facts-row">
                            <span><strong>Protein</strong></span>
                            <span class="fw-bold">{{ number_format($label->protein, 1, ',', '.') }} g</span>
                        </div>

                        <div class="nutrition-facts-row">
                            <span><strong>Karbohidrat Total</strong></span>
                            <span class="fw-bold">{{ number_format($label->carbohydrate, 1, ',', '.') }} g</span>
                        </div>

                        <div class="nutrition-facts-row thick-border">
                            <span class="ps-3 text-secondary">Serat Pangan</span>
                            <span class="fw-bold">{{ number_format($label->fiber, 1, ',', '.') }} g</span>
                        </div>
                    </div>

                    <!-- Batas Waktu Konsumsi Ringkas -->
                    <div class="p-2 bg-light rounded-3 text-center my-3 border">
                        <small class="text-muted d-block" style="font-size: 0.75rem;">Petunjuk Konsumsi:</small>
                        <span class="fw-bold text-danger small">
                            <i class="fa-regular fa-clock me-1"></i> {{ $label->formatted_consumption_limit }}
                        </span>
                    </div>

                    <!-- Print Button -->
                    <div class="text-center pt-2">
                        <a href="{{ route('public.labels.print', $label->slug) }}" target="_blank" class="btn btn-outline-dark btn-sm w-100 rounded-pill py-2">
                            <i class="fa-solid fa-print me-1"></i> Cetak Stiker Label Ini
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
