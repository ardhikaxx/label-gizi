@extends('layouts.public')

@section('title', ($todayLabel ? $todayLabel->title.' — ' : '').'Sajian Menu Hari Ini')
@section('meta_description', 'Informasi resmi Sajian Menu Makanan Bergizi Gratis Hari Ini, rincian menu hidangan, kandungan gizi lengkap, dan petunjuk batas akhir konsumsi.')

@section('content')
<div class="public-label-page" id="publicLabelPage">

    <!-- Accessibility & SEO Heading (Hidden Visually, Readable by Screen Readers & Tests) -->
    <h1 class="visually-hidden">Sajian Menu Hari Ini — {{ $todayLabel ? $todayLabel->title : 'Makanan Bergizi Gratis SPPG Ponorogo' }}</h1>

    <!-- ========================================== -->
    <!-- DESKTOP FRAME (16:9 - 2880x1620 Template)   -->
    <!-- ========================================== -->
    <div class="frame-container frame-desktop">
        <div class="label-template template-desktop" role="region" aria-label="Label Gizi Sajian Makanan Bergizi Gratis (Desktop)">

            <!-- 1. Overlay: Menu Text Box (Next to Fork & Spoon Icon) -->
            <div class="desktop-menu-box" title="{{ $menuDateFormatted }}: {{ $menuItemsFormatted }}">
                <div class="desktop-menu-title">
                    {{ $menuDateFormatted }}
                </div>
                <div class="desktop-menu-items">
                    {{ $menuItemsFormatted }}
                </div>
            </div>

            <!-- 2. Overlay: Kandungan Gizi Box (5 Macro/Micro Nutrients) -->
            <div class="desktop-gizi-box" aria-label="Tabel Kandungan Gizi Makro">
                <div class="desktop-gizi-row">
                    <span class="desktop-gizi-name">Energi</span>
                    <span class="desktop-gizi-colon">:</span>
                    <span class="desktop-gizi-val">{{ $nutrition['energy'] }} kkal</span>
                </div>
                <div class="desktop-gizi-row">
                    <span class="desktop-gizi-name">Protein</span>
                    <span class="desktop-gizi-colon">:</span>
                    <span class="desktop-gizi-val">{{ $nutrition['protein'] }} gr</span>
                </div>
                <div class="desktop-gizi-row">
                    <span class="desktop-gizi-name">Lemak</span>
                    <span class="desktop-gizi-colon">:</span>
                    <span class="desktop-gizi-val">{{ $nutrition['fat'] }} gr</span>
                </div>
                <div class="desktop-gizi-row">
                    <span class="desktop-gizi-name">Karbohidrat</span>
                    <span class="desktop-gizi-colon">:</span>
                    <span class="desktop-gizi-val">{{ $nutrition['carbohydrate'] }} gr</span>
                </div>
                <div class="desktop-gizi-row">
                    <span class="desktop-gizi-name">Serat</span>
                    <span class="desktop-gizi-colon">:</span>
                    <span class="desktop-gizi-val">{{ $nutrition['fiber'] }} gr</span>
                </div>
            </div>

            <!-- 3. Overlay: Batas Akhir Konsumsi Box -->
            <div class="desktop-batas-box">
                <div class="desktop-batas-desc">
                    {{ $consumptionNotice }}
                </div>
                <div class="desktop-batas-time">
                    {{ $consumptionTimeRange }}
                </div>
            </div>

            <!-- 4. Overlay: Circular Dish Photo (Inside the Navy Ring) -->
            <div class="desktop-circle-box" data-bs-toggle="modal" data-bs-target="#photoModal" title="Klik untuk memperbesar foto hidangan">
                <img src="{{ $dishImageUrl }}" alt="Foto Sajian Menu {{ $todayLabel ? $todayLabel->title : 'Makanan Bergizi' }}" class="desktop-circle-img" loading="eager" decoding="async">
            </div>

        </div>
    </div>

    <!-- ========================================== -->
    <!-- MOBILE FRAME (9:16 - 1620x2880 Template)    -->
    <!-- ========================================== -->
    <div class="frame-container frame-mobile">
        <div class="label-template template-mobile" role="region" aria-label="Label Gizi Sajian Makanan Bergizi Gratis (Mobile)">

            <!-- 1. Overlay: Menu Text Box (Next to Fork & Spoon Icon) -->
            <div class="mobile-menu-box" title="{{ $menuDateFormatted }}: {{ $menuItemsFormatted }}">
                <div class="mobile-menu-title">
                    {{ $menuDateFormatted }}
                </div>
                <div class="mobile-menu-items">
                    {{ $menuItemsFormatted }}
                </div>
            </div>

            <!-- 2. Overlay: Kandungan Gizi Box (5 Macro/Micro Nutrients) -->
            <div class="mobile-gizi-box" aria-label="Tabel Kandungan Gizi Makro">
                <div class="mobile-gizi-row">
                    <span class="mobile-gizi-name">Energi</span>
                    <span class="mobile-gizi-colon">:</span>
                    <span class="mobile-gizi-val">{{ $nutrition['energy'] }} kkal</span>
                </div>
                <div class="mobile-gizi-row">
                    <span class="mobile-gizi-name">Protein</span>
                    <span class="mobile-gizi-colon">:</span>
                    <span class="mobile-gizi-val">{{ $nutrition['protein'] }} gr</span>
                </div>
                <div class="mobile-gizi-row">
                    <span class="mobile-gizi-name">Lemak</span>
                    <span class="mobile-gizi-colon">:</span>
                    <span class="mobile-gizi-val">{{ $nutrition['fat'] }} gr</span>
                </div>
                <div class="mobile-gizi-row">
                    <span class="mobile-gizi-name">Karbohidrat</span>
                    <span class="mobile-gizi-colon">:</span>
                    <span class="mobile-gizi-val">{{ $nutrition['carbohydrate'] }} gr</span>
                </div>
                <div class="mobile-gizi-row">
                    <span class="mobile-gizi-name">Serat</span>
                    <span class="mobile-gizi-colon">:</span>
                    <span class="mobile-gizi-val">{{ $nutrition['fiber'] }} gr</span>
                </div>
            </div>

            <!-- 3. Overlay: Batas Akhir Konsumsi Box -->
            <div class="mobile-batas-box">
                <div class="mobile-batas-desc">
                    {{ $consumptionNotice }}
                </div>
                <div class="mobile-batas-time">
                    {{ $consumptionTimeRange }}
                </div>
            </div>

            <!-- 4. Overlay: Circular Dish Photo (Inside the Navy Ring) -->
            <div class="mobile-circle-box" data-bs-toggle="modal" data-bs-target="#photoModal" title="Klik untuk memperbesar foto hidangan">
                <img src="{{ $dishImageUrl }}" alt="Foto Sajian Menu {{ $todayLabel ? $todayLabel->title : 'Makanan Bergizi' }}" class="mobile-circle-img" loading="eager" decoding="async">
            </div>

        </div>
    </div>

</div>

<!-- ======================================================= -->
<!-- MODAL LIGHTBOX FOTO SAJIAN MENU (OPTIONAL ZOOM)         -->
<!-- ======================================================= -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content rounded-4 border-0 shadow overflow-hidden">
            <div class="modal-header border-0 pb-0 position-absolute end-0 top-0 z-3 p-3">
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body p-0 text-center bg-dark">
                <img src="{{ $dishImageUrl }}" alt="Foto Sajian Menu Makanan" class="img-fluid w-100 object-fit-contain" style="max-height: 80vh;">
            </div>
            <div class="modal-footer bg-white border-0 py-2.5 px-3 d-flex justify-content-between">
                <small class="text-dark fw-bold mb-0">{{ $menuDateFormatted }}</small>
                <small class="text-muted">{{ $todayLabel ? $todayLabel->title : 'Sajian Menu Bergizi' }}</small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* -------------------------------------------------------------
   Page & Full Frame Viewport Styling
------------------------------------------------------------- */
html, body {
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
    height: 100% !important;
    overflow: hidden !important;
    background-color: #92d1ee !important;
    font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif;
}

body > main {
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
    height: 100% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.public-label-page {
    width: 100vw;
    height: 100vh;
    height: 100dvh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin: 0;
    padding: 0;
    background: radial-gradient(circle at 50% 50%, #b2e2f8 0%, #90ceee 100%);
}

/* -------------------------------------------------------------
   DESKTOP FRAME (Aspect Ratio: 16 / 9 => 2880 x 1620)
------------------------------------------------------------- */
.frame-desktop {
    width: min(100vw, calc(100dvh * (2880 / 1620)));
    height: min(100dvh, calc(100vw * (1620 / 2880)));
    aspect-ratio: 2880 / 1620;
    margin: auto;
}

.template-desktop {
    position: relative;
    width: 100%;
    height: 100%;
    aspect-ratio: 2880 / 1620;
    background-image: url('{{ asset('images/page-desktop.png') }}');
    background-size: 100% 100%;
    background-position: center;
    background-repeat: no-repeat;
    container-type: inline-size;
    container-name: frame-desktop;
    overflow: hidden;
    user-select: text;
}

/* Desktop 1: Menu Box */
.desktop-menu-box {
    position: absolute;
    left: 10.4%;
    top: 20.8%;
    width: 25.1%;
    height: 10.3%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding-left: 0.6cqw;
    padding-right: 0.8cqw;
    overflow: hidden;
}

.desktop-menu-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 800;
    font-size: clamp(13px, 1.38cqw, 24px);
    line-height: 1.25;
    color: #0b2754;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.desktop-menu-items {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 600;
    font-size: clamp(10px, 1.05cqw, 18px);
    line-height: 1.32;
    color: #0b2754;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-top: 0.25cqw;
}

/* Desktop 2: Kandungan Gizi Box */
.desktop-gizi-box {
    position: absolute;
    left: 4.6%;
    top: 37.8%;
    width: 30.2%;
    height: 16.8%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 0.2cqw 0.4cqw;
}

.desktop-gizi-row {
    background-color: #fff9ea;
    border-radius: 0.4cqw;
    display: flex;
    align-items: center;
    padding: 0.2cqw 0.8cqw;
    height: 17.5%;
    box-sizing: border-box;
}

.desktop-gizi-name {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 800;
    font-size: clamp(10px, 1.12cqw, 20px);
    color: #0b2754;
    width: 44%;
}

.desktop-gizi-colon {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 800;
    font-size: clamp(10px, 1.12cqw, 20px);
    color: #0b2754;
    width: 8%;
    text-align: center;
}

.desktop-gizi-val {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 800;
    font-size: clamp(10px, 1.12cqw, 20px);
    color: #0b2754;
    width: 48%;
    text-align: left;
    padding-left: 0.4cqw;
}

/* Desktop 3: Batas Akhir Konsumsi Box */
.desktop-batas-box {
    position: absolute;
    left: 10.4%;
    top: 64.0%;
    width: 25.1%;
    height: 11.8%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding-left: 0.6cqw;
    padding-right: 0.8cqw;
}

.desktop-batas-desc {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 700;
    font-size: clamp(10px, 1.05cqw, 18px);
    line-height: 1.3;
    color: #0b2754;
}

.desktop-batas-time {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 800;
    font-size: clamp(12px, 1.3cqw, 22px);
    line-height: 1.2;
    color: #0b2754;
    margin-top: 0.3cqw;
}

/* Desktop 4: Circular Food Dish Photo */
.desktop-circle-box {
    position: absolute;
    left: 69.43%;
    top: 45.43%;
    width: 28.82%;
    height: 51.23%;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.desktop-circle-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    transition: transform 0.35s cubic-bezier(0.2, 0, 0.2, 1);
}

.desktop-circle-box:hover .desktop-circle-img {
    transform: scale(1.05);
}

/* -------------------------------------------------------------
   MOBILE FRAME (Aspect Ratio: 9 / 16 => 1620 x 2880)
------------------------------------------------------------- */
.frame-mobile {
    width: min(100vw, calc(100dvh * (1620 / 2880)));
    height: min(100dvh, calc(100vw * (2880 / 1620)));
    aspect-ratio: 1620 / 2880;
    margin: auto;
}

.template-mobile {
    position: relative;
    width: 100%;
    height: 100%;
    aspect-ratio: 1620 / 2880;
    background-image: url('{{ asset('images/page-mobile.png') }}');
    background-size: 100% 100%;
    background-position: center;
    background-repeat: no-repeat;
    container-type: inline-size;
    container-name: frame-mobile;
    overflow: hidden;
    user-select: text;
}

/* Mobile 1: Menu Box */
.mobile-menu-box {
    position: absolute;
    left: 28.5%;
    top: 17.8%;
    width: 53.5%;
    height: 6.0%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding-left: 1.2cqw;
    padding-right: 1.2cqw;
    overflow: hidden;
}

.mobile-menu-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 800;
    font-size: clamp(11px, 2.55cqw, 20px);
    line-height: 1.25;
    color: #0b2754;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    letter-spacing: 0;
}

.mobile-menu-items {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 600;
    font-size: clamp(9px, 1.95cqw, 16px);
    line-height: 1.35;
    color: #0b2754;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-top: 0.2cqw;
}

/* Mobile 2: Kandungan Gizi Box */
.mobile-gizi-box {
    position: absolute;
    left: 17.5%;
    top: 28.2%;
    width: 63.8%;
    height: 8.2%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-sizing: border-box;
    padding: 0;
}

.mobile-gizi-row {
    background-color: #fff9ea;
    border-radius: 0.6cqw;
    display: flex;
    align-items: center;
    padding: 0.15cqw 1.2cqw;
    height: 18.0%;
    box-sizing: border-box;
}

.mobile-gizi-name {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 800;
    font-size: clamp(8px, 1.9cqw, 16px);
    color: #0b2754;
    width: 44%;
}

.mobile-gizi-colon {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 800;
    font-size: clamp(8px, 1.9cqw, 16px);
    color: #0b2754;
    width: 8%;
    text-align: center;
}

.mobile-gizi-val {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 800;
    font-size: clamp(8px, 1.9cqw, 16px);
    color: #0b2754;
    width: 48%;
    text-align: left;
    padding-left: 0.4cqw;
}

/* Mobile 3: Batas Akhir Konsumsi Box */
.mobile-batas-box {
    position: absolute;
    left: 28.5%;
    top: 41.8%;
    width: 53.5%;
    height: 6.8%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding-left: 1.2cqw;
    padding-right: 1.2cqw;
}

.mobile-batas-desc {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 700;
    font-size: clamp(9px, 1.9cqw, 16px);
    line-height: 1.3;
    color: #0b2754;
}

.mobile-batas-time {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 800;
    font-size: clamp(11px, 2.4cqw, 20px);
    line-height: 1.2;
    color: #0b2754;
    margin-top: 0.3cqw;
}

/* Mobile 4: Circular Food Dish Photo */
.mobile-circle-box {
    position: absolute;
    left: 26.79%;
    top: 71.67%;
    width: 46.30%;
    height: 26.04%;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.mobile-circle-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    transition: transform 0.35s cubic-bezier(0.2, 0, 0.2, 1);
}

.mobile-circle-box:hover .mobile-circle-img {
    transform: scale(1.05);
}

/* -------------------------------------------------------------
   AUTOMATIC RESPONSIVE DISPLAY SWITCHING
------------------------------------------------------------- */
@media (min-width: 768px) {
    .frame-desktop {
        display: block !important;
    }
    .frame-mobile {
        display: none !important;
    }
}

@media (max-width: 767.98px) {
    .frame-desktop {
        display: none !important;
    }
    .frame-mobile {
        display: block !important;
    }
}

/* -------------------------------------------------------------
   PRINT STYLESHEET
------------------------------------------------------------- */
@media print {
    html, body {
        background: white !important;
        overflow: visible !important;
    }
    .modal {
        display: none !important;
    }
    .public-label-page {
        width: 100% !important;
        height: auto !important;
        background: none !important;
    }
    .frame-desktop,
    .frame-mobile {
        width: 100% !important;
        height: auto !important;
        page-break-inside: avoid;
    }
}
</style>
@endpush
