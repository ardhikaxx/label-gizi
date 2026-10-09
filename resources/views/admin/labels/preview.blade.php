@extends('layouts.admin')

@section('title', 'Pratinjau Label: ' . $label->title)
@section('page_title', 'Pratinjau Label Makanan')

@section('content')
<div class="container-fluid p-0">

    <!-- Top Action Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div>
            <span class="badge bg-info text-dark rounded-pill px-3 py-1 mb-2">Mode Pratinjau Tampilan Publik</span>
            <h4 class="fw-bold text-dark mb-0">Simulasi Label: {{ $label->title }}</h4>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="window.print()">
                <i class="fa-solid fa-print me-1"></i> Cetak Label
            </button>
            <a href="{{ route('admin.labels.edit', $label) }}" class="btn btn-primary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-pen-to-square me-1"></i> Edit Label
            </a>
            <a href="{{ route('admin.labels.show', $label) }}" class="btn btn-light border btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Detail
            </a>
        </div>
    </div>

    <!-- Official Food Nutrition Label Sticker Box -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">

            <div class="nutrition-facts-box shadow-sm rounded-3">
                <!-- Header -->
                <div class="text-center pb-2 border-bottom border-dark border-3">
                    <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                        <i class="fa-solid fa-apple-whole text-success fs-4"></i>
                        <h4 class="fw-black text-uppercase text-dark mb-0 tracking-tight" style="font-weight: 900; letter-spacing: -0.5px;">
                            INFORMASI NILAI GIZI
                        </h4>
                    </div>
                    <div class="small fw-bold text-secondary text-uppercase" style="letter-spacing: 1px;">
                        LABEL MAKANAN BERGIZI
                    </div>
                </div>

                <!-- Package & Date Info -->
                <div class="py-2 border-bottom border-dark">
                    <div class="fw-bold text-dark fs-6">{{ $label->title }}</div>
                    <div class="small text-muted mt-1">
                        <span>Tanggal: <strong>{{ $label->menu_date->isoFormat('D MMMM Y') }}</strong></span>
                    </div>
                </div>

                <!-- Energy / Kalori Callout -->
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

                <!-- Nutrients Table -->
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
                        <span class="ps-3">Serat Pangan</span>
                        <span class="fw-bold">{{ number_format($label->fiber, 1, ',', '.') }} g</span>
                    </div>
                </div>

                <!-- Menus Section -->
                <div class="py-2 border-bottom border-dark">
                    <div class="small fw-bold text-dark text-uppercase mb-2">Komposisi Menu:</div>
                    <ol class="ps-3 mb-0 small text-dark d-flex flex-column gap-1">
                        @foreach($label->menus as $m)
                            <li class="fw-medium">{{ $m->name }}</li>
                        @endforeach
                    </ol>
                </div>

                <!-- Consumption Limit Alert Box -->
                <div class="mt-3 p-3 bg-warning bg-opacity-10 border border-warning rounded-3">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="fa-solid fa-triangle-exclamation text-warning fs-5"></i>
                        <span class="fw-bold text-dark small text-uppercase">Petunjuk Batas Waktu Konsumsi</span>
                    </div>
                    <div class="fw-bold text-danger fs-6">
                        {{ $label->formatted_consumption_limit }}
                    </div>
                    <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                        * Dihitung relatif sejak makanan diantarkan. Segera konsumsi sebelum batas waktu demi higienitas dan kesehatan.
                    </small>
                </div>

                <!-- Footer Note -->
                <div class="text-center pt-3 small text-muted" style="font-size: 0.7rem;">
                    Diterbitkan oleh Sistem Informasi Pangan Bergizi &bull; {{ config('app.name') }}
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
