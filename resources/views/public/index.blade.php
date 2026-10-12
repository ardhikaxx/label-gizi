@extends('layouts.public')

@section('title', ($todayLabel ? $todayLabel->title.' — ' : '').'Sajian Menu Hari Ini')
@section('meta_description', 'Informasi resmi Sajian Menu Makanan Bergizi Gratis Hari Ini, rincian menu hidangan, kandungan gizi lengkap, dan petunjuk batas akhir konsumsi.')

@section('content')
<div class="public-label-page" id="publicLabelPage">

    <!-- Accessibility & SEO Heading (Hidden Visually, Readable by Screen Readers & Tests) -->
    <h1 class="visually-hidden">Sajian Menu Hari Ini — {{ $todayLabel ? $todayLabel->title : 'Makanan Bergizi Gratis SPPG Ponorogo' }}</h1>

    <!-- ======================================================= -->
    <!-- FLOATING PREV / NEXT NAVIGATION ARROWS                  -->
    <!-- ======================================================= -->
    @if($slides->count() > 1)
        <button type="button" class="carousel-arrow carousel-arrow-prev" id="prevSlideBtn" aria-label="Kondisi Sebelumnya" title="Kondisi Sebelumnya (Geser ke Kiri)">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button type="button" class="carousel-arrow carousel-arrow-next" id="nextSlideBtn" aria-label="Kondisi Berikutnya" title="Kondisi Berikutnya (Geser ke Kanan)">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    @endif

    <!-- ======================================================= -->
    <!-- CAROUSEL VIEWPORT & SLIDES TRACK                        -->
    <!-- ======================================================= -->
    <div class="carousel-viewport" id="carouselViewport">
        <div class="carousel-track" id="carouselTrack">
            @foreach($slides as $index => $slide)
                <div class="carousel-slide" data-index="{{ $index }}" data-condition="{{ $slide['condition'] }}">

                    <!-- ========================================== -->
                    <!-- DESKTOP FRAME (16:9 - 1920x1080 Template)  -->
                    <!-- ========================================== -->
                    <div class="frame-container frame-desktop">
                        <div class="label-template template-desktop" role="region" aria-label="Label Gizi Sajian Makanan Bergizi Gratis (Desktop) - {{ $slide['condition'] }}">

                            <!-- 1. Overlay: Menu Text Box (Next to Fork & Spoon Icon) -->
                            <div class="desktop-menu-box" title="{{ $slide['menuDateFormatted'] }}: {{ $slide['menuItemsFormatted'] }}">
                                <div class="desktop-menu-title">
                                    {{ $slide['menuDateFormatted'] }}
                                </div>
                                <div class="desktop-menu-items">
                                    {{ $slide['menuItemsFormatted'] }}
                                </div>
                            </div>

                            <!-- 2. Overlay: Kandungan Gizi Box (5 Macro/Micro Nutrients) -->
                            <div class="desktop-gizi-box" aria-label="Tabel Kandungan Gizi Makro">
                                <div class="desktop-gizi-row">
                                    <span class="desktop-gizi-name">Energi</span>
                                    <span class="desktop-gizi-colon">:</span>
                                    <span class="desktop-gizi-val">{{ $slide['nutrition']['energy'] }} kkal</span>
                                </div>
                                <div class="desktop-gizi-row">
                                    <span class="desktop-gizi-name">Protein</span>
                                    <span class="desktop-gizi-colon">:</span>
                                    <span class="desktop-gizi-val">{{ $slide['nutrition']['protein'] }} gr</span>
                                </div>
                                <div class="desktop-gizi-row">
                                    <span class="desktop-gizi-name">Lemak</span>
                                    <span class="desktop-gizi-colon">:</span>
                                    <span class="desktop-gizi-val">{{ $slide['nutrition']['fat'] }} gr</span>
                                </div>
                                <div class="desktop-gizi-row">
                                    <span class="desktop-gizi-name">Karbohidrat</span>
                                    <span class="desktop-gizi-colon">:</span>
                                    <span class="desktop-gizi-val">{{ $slide['nutrition']['carbohydrate'] }} gr</span>
                                </div>
                                <div class="desktop-gizi-row">
                                    <span class="desktop-gizi-name">Serat</span>
                                    <span class="desktop-gizi-colon">:</span>
                                    <span class="desktop-gizi-val">{{ $slide['nutrition']['fiber'] }} gr</span>
                                </div>
                            </div>

                            <!-- 3. Overlay: Batas Akhir Konsumsi Box -->
                            <div class="desktop-batas-box">
                                <div class="desktop-batas-desc">
                                    {{ $slide['consumptionNotice'] }}
                                </div>
                                <div class="desktop-batas-time">
                                    {{ $slide['consumptionTimeRange'] }}
                                </div>
                            </div>

                            <!-- 4. Overlay: Kotak Kondisi Makanan (Sebelah gambar) -->
                            <div class="desktop-condition-box" title="Kondisi Makanan: {{ $slide['condition'] }}">
                                <div class="desktop-condition-name">{{ $slide['condition'] }}</div>
                            </div>

                            <!-- 5. Overlay: Circular Dish Photo (Inside the Circular Illustration) -->
                            <div class="desktop-circle-box"
                                 role="button"
                                 tabindex="0"
                                 data-photo-src="{{ $slide['dishImageUrl'] }}"
                                 data-photo-date="{{ $slide['menuDateFormatted'] }}"
                                 data-photo-title="{{ $slide['title'] }} — {{ $slide['condition'] }}"
                                 title="Klik untuk memperbesar foto hidangan {{ $slide['condition'] }}">
                                <img src="{{ $slide['dishImageUrl'] }}"
                                     alt="Foto Sajian Menu {{ $slide['title'] }} — {{ $slide['condition'] }}"
                                     class="desktop-circle-img"
                                     loading="eager"
                                     decoding="async">
                            </div>

                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- MOBILE FRAME (9:16 - 1080x1920 Template)   -->
                    <!-- ========================================== -->
                    <div class="frame-container frame-mobile">
                        <div class="label-template template-mobile" role="region" aria-label="Label Gizi Sajian Makanan Bergizi Gratis (Mobile) - {{ $slide['condition'] }}">

                            <!-- 1. Overlay: Menu Text Box (Next to Fork & Spoon Icon) -->
                            <div class="mobile-menu-box" title="{{ $slide['menuDateFormatted'] }}: {{ $slide['menuItemsFormatted'] }}">
                                <div class="mobile-menu-title">
                                    {{ $slide['menuDateFormatted'] }}
                                </div>
                                <div class="mobile-menu-items">
                                    {{ $slide['menuItemsFormatted'] }}
                                </div>
                            </div>

                            <!-- 2. Overlay: Kandungan Gizi Box (5 Macro/Micro Nutrients) -->
                            <div class="mobile-gizi-box" aria-label="Tabel Kandungan Gizi Makro">
                                <div class="mobile-gizi-row">
                                    <span class="mobile-gizi-name">Energi</span>
                                    <span class="mobile-gizi-colon">:</span>
                                    <span class="mobile-gizi-val">{{ $slide['nutrition']['energy'] }} kkal</span>
                                </div>
                                <div class="mobile-gizi-row">
                                    <span class="mobile-gizi-name">Protein</span>
                                    <span class="mobile-gizi-colon">:</span>
                                    <span class="mobile-gizi-val">{{ $slide['nutrition']['protein'] }} gr</span>
                                </div>
                                <div class="mobile-gizi-row">
                                    <span class="mobile-gizi-name">Lemak</span>
                                    <span class="mobile-gizi-colon">:</span>
                                    <span class="mobile-gizi-val">{{ $slide['nutrition']['fat'] }} gr</span>
                                </div>
                                <div class="mobile-gizi-row">
                                    <span class="mobile-gizi-name">Karbohidrat</span>
                                    <span class="mobile-gizi-colon">:</span>
                                    <span class="mobile-gizi-val">{{ $slide['nutrition']['carbohydrate'] }} gr</span>
                                </div>
                                <div class="mobile-gizi-row">
                                    <span class="mobile-gizi-name">Serat</span>
                                    <span class="mobile-gizi-colon">:</span>
                                    <span class="mobile-gizi-val">{{ $slide['nutrition']['fiber'] }} gr</span>
                                </div>
                            </div>

                            <!-- 3. Overlay: Batas Akhir Konsumsi Box -->
                            <div class="mobile-batas-box">
                                <div class="mobile-batas-desc">
                                    @if(str_contains($slide['consumptionNotice'], 'maksimal'))
                                        {!! str_replace('maksimal', '<br>maksimal', e($slide['consumptionNotice'])) !!}
                                    @else
                                        {{ $slide['consumptionNotice'] }}
                                    @endif
                                </div>
                                <div class="mobile-batas-time">
                                    {{ $slide['consumptionTimeRange'] }}
                                </div>
                            </div>

                            <!-- 4. Overlay: Kotak Kondisi Makanan (Sebelah gambar) -->
                            <div class="mobile-condition-box" title="Kondisi Makanan: {{ $slide['condition'] }}">
                                <div class="mobile-condition-name">{{ $slide['condition'] }}</div>
                            </div>

                            <!-- 5. Overlay: Circular Dish Photo (Inside the Circular Illustration) -->
                            <div class="mobile-circle-box"
                                 role="button"
                                 tabindex="0"
                                 data-photo-src="{{ $slide['dishImageUrl'] }}"
                                 data-photo-date="{{ $slide['menuDateFormatted'] }}"
                                 data-photo-title="{{ $slide['title'] }} — {{ $slide['condition'] }}"
                                 title="Klik untuk memperbesar foto hidangan {{ $slide['condition'] }}">
                                <img src="{{ $slide['dishImageUrl'] }}"
                                     alt="Foto Sajian Menu {{ $slide['title'] }} — {{ $slide['condition'] }}"
                                     class="mobile-circle-img"
                                     loading="eager"
                                     decoding="async">
                            </div>

                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>

    <!-- ======================================================= -->
    <!-- FLOATING BOTTOM BAR (DOT INDICATORS & SWIPE HINT)       -->
    <!-- ======================================================= -->
    @if($slides->count() > 1)
        <div class="carousel-bottom-bar">
            <div class="carousel-dots-list">
                @foreach($slides as $index => $slide)
                    <button type="button"
                            class="carousel-dot-btn {{ $index === 0 ? 'active' : '' }}"
                            data-slide-index="{{ $index }}"
                            aria-label="Kondisi {{ $slide['condition'] }}">
                    </button>
                @endforeach
            </div>
            <div class="carousel-swipe-hint" id="carouselSwipeHint">
                <i class="fa-solid fa-arrows-left-right me-1"></i> Swipe / Geser untuk kondisi makanan lainnya
            </div>
        </div>
    @endif

</div>

<!-- ======================================================= -->
<!-- MODAL LIGHTBOX FOTO SAJIAN MENU (ZOOM PREVIEW)          -->
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
                <img src="{{ $dishImageUrl }}" id="modalPhotoImg" alt="Foto Sajian Menu Makanan" class="img-fluid w-100 object-fit-contain" style="max-height: 80vh;">
            </div>
            <div class="modal-footer bg-white border-0 py-2.5 px-3 d-flex justify-content-between">
                <small class="text-dark fw-bold mb-0" id="modalPhotoDate">{{ $menuDateFormatted }}</small>
                <small class="text-muted" id="modalPhotoTitle">{{ $todayLabel ? $todayLabel->title : 'Sajian Menu Bergizi' }}</small>
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
    touch-action: pan-y pinch-zoom;
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
    position: relative;
    background: radial-gradient(circle at 50% 50%, #b2e2f8 0%, #90ceee 100%);
}

/* -------------------------------------------------------------
   Carousel Viewport & Track
------------------------------------------------------------- */
.carousel-viewport {
    width: 100vw;
    height: 100vh;
    height: 100dvh;
    overflow: hidden;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: flex-start;
}

.carousel-track {
    display: flex;
    flex-direction: row;
    width: 100%;
    height: 100%;
    will-change: transform;
    transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
    touch-action: pan-y;
}

.carousel-track.is-dragging {
    transition: none !important;
}

.carousel-slide {
    width: 100vw;
    height: 100vh;
    height: 100dvh;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    user-select: none;
    -webkit-user-select: none;
}

/* -------------------------------------------------------------
   Floating Prev / Next Navigation Arrows
------------------------------------------------------------- */
.carousel-arrow {
    position: fixed;
    top: 50%;
    transform: translateY(-50%);
    z-index: 110;
    width: 46px;
    height: 46px;
    border-radius: 50%;
    border: 1.5px solid rgba(255, 255, 255, 0.7);
    background: rgba(11, 39, 84, 0.55);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 16px;
    box-shadow: 0 6px 20px rgba(11, 39, 84, 0.25);
    transition: all 0.25s cubic-bezier(0.2, 0, 0.2, 1);
}

.carousel-arrow:hover {
    background: rgba(11, 39, 84, 0.85);
    transform: translateY(-50%) scale(1.1);
    color: #ffffff;
}

.carousel-arrow:active {
    transform: translateY(-50%) scale(0.96);
}

.carousel-arrow-prev {
    left: 18px;
}

.carousel-arrow-next {
    right: 18px;
}

/* -------------------------------------------------------------
   Floating Bottom Bar (Dots & Swipe Hint)
------------------------------------------------------------- */
.carousel-bottom-bar {
    position: fixed;
    bottom: 12px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 110;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    pointer-events: none;
}

.carousel-dots-list {
    display: flex;
    align-items: center;
    gap: 6px;
    pointer-events: auto;
    background: rgba(255, 255, 255, 0.65);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    padding: 5px 10px;
    border-radius: 999px;
    box-shadow: 0 2px 8px rgba(11, 39, 84, 0.1);
}

.carousel-dot-btn {
    border: none;
    width: 8px;
    height: 8px;
    border-radius: 999px;
    background: rgba(11, 39, 84, 0.3);
    cursor: pointer;
    padding: 0;
    transition: all 0.25s cubic-bezier(0.2, 0, 0.2, 1);
}

.carousel-dot-btn.active {
    width: 24px;
    background: #0b2754;
    border-radius: 999px;
}

.carousel-swipe-hint {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 11px;
    font-weight: 700;
    color: #0b2754;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    padding: 3px 12px;
    border-radius: 999px;
    box-shadow: 0 2px 8px rgba(11, 39, 84, 0.1);
    transition: opacity 0.4s ease;
}

/* -------------------------------------------------------------
   DESKTOP FRAME (Aspect Ratio: 16 / 9 => 1920 x 1080)
------------------------------------------------------------- */
.frame-desktop {
    width: min(100vw, calc(100dvh * (1920 / 1080)));
    height: min(100dvh, calc(100vw * (1080 / 1920)));
    aspect-ratio: 1920 / 1080;
    margin: auto;
}

.template-desktop {
    position: relative;
    width: 100%;
    height: 100%;
    aspect-ratio: 1920 / 1080;
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

/* Desktop 4: Kotak Kondisi Makanan (Sebelah gambar di page-desktop.png) */
.desktop-condition-box {
    position: absolute;
    left: 75.36%;
    top: 14.17%;
    width: 24.00%;
    height: 11.48%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.4cqw 1.2cqw;
    box-sizing: border-box;
    overflow: hidden;
    text-align: center;
}

.desktop-condition-name {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 800;
    font-size: clamp(22px, 2.5cqw, 44px);
    line-height: 1.15;
    letter-spacing: -0.02em;
    color: #0b2754;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Desktop 5: Circular Food Dish Photo (Pas pada lingkaran di page-desktop.png) */
.desktop-circle-box {
    position: absolute;
    left: 67.37%;
    top: 41.57%;
    width: 31.67%;
    height: 56.30%;
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
   MOBILE FRAME (Aspect Ratio: 9 / 16 => 1080 x 1920)
------------------------------------------------------------- */
.frame-mobile {
    width: min(100vw, calc(100dvh * (1080 / 1920)));
    height: min(100dvh, calc(100vw * (1920 / 1080)));
    aspect-ratio: 1080 / 1920;
    margin: auto;
}

.template-mobile {
    position: relative;
    width: 100%;
    height: 100%;
    aspect-ratio: 1080 / 1920;
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
    left: 30.0%;
    top: 41.5%;
    width: 54.0%;
    height: 8.5%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding-left: 0.5cqw;
    padding-right: 0.8cqw;
    box-sizing: border-box;
    overflow: hidden;
}

.mobile-batas-desc {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 700;
    font-size: clamp(10.5px, 2.2cqw, 20px);
    line-height: 1.25;
    color: #0b2754;
    word-break: normal;
}

.mobile-batas-time {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 800;
    font-size: clamp(12.5px, 2.6cqw, 23px);
    line-height: 1.2;
    color: #0b2754;
    margin-top: 0.35cqw;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Mobile 4: Kotak Kondisi Makanan (Sebelah gambar di page-mobile.png) */
.mobile-condition-box {
    position: absolute;
    left: 67.96%;
    top: 64.38%;
    width: 31.50%;
    height: 7.65%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.2cqw 1.0cqw;
    box-sizing: border-box;
    overflow: hidden;
    text-align: center;
}

.mobile-condition-name {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 800;
    font-size: clamp(18px, 4.2cqw, 38px);
    line-height: 1.15;
    letter-spacing: -0.01em;
    color: #0b2754;
    text-align: center;
    word-break: normal;
    overflow-wrap: break-word;
}

/* Mobile 5: Circular Food Dish Photo (Pas pada lingkaran di page-mobile.png) */
.mobile-circle-box {
    position: absolute;
    left: 22.84%;
    top: 68.37%;
    width: 54.26%;
    height: 30.52%;
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
    .carousel-arrow {
        width: 38px;
        height: 38px;
        font-size: 14px;
    }
    .carousel-arrow-prev {
        left: 8px;
    }
    .carousel-arrow-next {
        right: 8px;
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
    .modal,
    .carousel-arrow,
    .carousel-bottom-bar {
        display: none !important;
    }
    .public-label-page,
    .carousel-viewport,
    .carousel-track,
    .carousel-slide {
        width: 100% !important;
        height: auto !important;
        background: none !important;
        transform: none !important;
    }
    .carousel-slide {
        page-break-after: always;
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const track = document.getElementById('carouselTrack');
    const viewport = document.getElementById('carouselViewport');
    const slides = document.querySelectorAll('.carousel-slide');
    const dotButtons = document.querySelectorAll('.carousel-dot-btn');
    const prevBtn = document.getElementById('prevSlideBtn');
    const nextBtn = document.getElementById('nextSlideBtn');
    const swipeHint = document.getElementById('carouselSwipeHint');

    const totalSlides = slides.length;
    if (totalSlides === 0) return;

    let currentIndex = 0;
    let isDragging = false;
    let startX = 0;
    let startY = 0;
    let currentDeltaX = 0;
    let isHorizontalSwipe = false;

    // Go to specific slide index
    function goToSlide(index, animate = true) {
        if (index < 0) index = 0;
        if (index >= totalSlides) index = totalSlides - 1;

        currentIndex = index;

        if (!animate) {
            track.classList.add('is-dragging');
        } else {
            track.classList.remove('is-dragging');
        }

        const offsetPercent = -currentIndex * 100;
        track.style.transform = `translateX(${offsetPercent}vw)`;

        // Update Dots active states
        dotButtons.forEach((btn, i) => {
            btn.classList.toggle('active', i === currentIndex);
        });

        // Update arrows availability if clamping
        if (prevBtn) {
            prevBtn.style.opacity = currentIndex === 0 ? '0.45' : '1';
        }
        if (nextBtn) {
            nextBtn.style.opacity = currentIndex === totalSlides - 1 ? '0.45' : '1';
        }

        // Hide swipe hint once user interacts
        if (swipeHint && currentIndex > 0) {
            swipeHint.style.opacity = '0';
        }
    }

    // Previous and Next handlers (with wrap-around or clamp)
    function prevSlide() {
        if (currentIndex > 0) {
            goToSlide(currentIndex - 1);
        } else {
            goToSlide(totalSlides - 1);
        }
    }

    function nextSlide() {
        if (currentIndex < totalSlides - 1) {
            goToSlide(currentIndex + 1);
        } else {
            goToSlide(0);
        }
    }

    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);

    // Dot buttons click
    dotButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const idx = parseInt(this.getAttribute('data-slide-index'), 10);
            if (!isNaN(idx)) goToSlide(idx);
        });
    });

    // Keyboard navigation (ArrowLeft & ArrowRight)
    window.addEventListener('keydown', function (e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
        if (e.key === 'ArrowLeft') {
            prevSlide();
        } else if (e.key === 'ArrowRight') {
            nextSlide();
        }
    });

    // Touch & Pointer Gesture Handling
    function handleTouchStart(e) {
        if (totalSlides <= 1) return;
        const touch = e.touches ? e.touches[0] : e;
        startX = touch.clientX;
        startY = touch.clientY;
        currentDeltaX = 0;
        isDragging = true;
        isHorizontalSwipe = false;
        track.classList.add('is-dragging');
    }

    function handleTouchMove(e) {
        if (!isDragging) return;
        const touch = e.touches ? e.touches[0] : e;
        const deltaX = touch.clientX - startX;
        const deltaY = touch.clientY - startY;

        if (!isHorizontalSwipe) {
            if (Math.abs(deltaX) > 10 && Math.abs(deltaX) > Math.abs(deltaY)) {
                isHorizontalSwipe = true;
            } else if (Math.abs(deltaY) > 10) {
                isDragging = false;
                track.classList.remove('is-dragging');
                return;
            }
        }

        if (isHorizontalSwipe) {
            if (e.cancelable) e.preventDefault();
            currentDeltaX = deltaX;
            const currentOffsetPx = (-currentIndex * window.innerWidth) + deltaX;
            track.style.transform = `translateX(${currentOffsetPx}px)`;
        }
    }

    function handleTouchEnd() {
        if (!isDragging) return;
        isDragging = false;
        track.classList.remove('is-dragging');

        const threshold = 45; // pixels
        if (currentDeltaX < -threshold) {
            if (currentIndex < totalSlides - 1) {
                goToSlide(currentIndex + 1);
            } else {
                goToSlide(currentIndex); // Bounce back
            }
        } else if (currentDeltaX > threshold) {
            if (currentIndex > 0) {
                goToSlide(currentIndex - 1);
            } else {
                goToSlide(currentIndex); // Bounce back
            }
        } else {
            goToSlide(currentIndex); // Bounce back
        }
    }

    // Touch events
    viewport.addEventListener('touchstart', handleTouchStart, { passive: true });
    viewport.addEventListener('touchmove', handleTouchMove, { passive: false });
    viewport.addEventListener('touchend', handleTouchEnd, { passive: true });
    viewport.addEventListener('touchcancel', handleTouchEnd, { passive: true });

    // Mouse drag events for Desktop testing
    let isMouseDown = false;
    viewport.addEventListener('mousedown', function (e) {
        if (e.button !== 0) return;
        isMouseDown = true;
        handleTouchStart(e);
    });

    window.addEventListener('mousemove', function (e) {
        if (!isMouseDown) return;
        handleTouchMove(e);
    });

    window.addEventListener('mouseup', function (e) {
        if (!isMouseDown) return;
        isMouseDown = false;
        handleTouchEnd();
    });

    // Lightbox modal logic for dish photo
    const photoModalEl = document.getElementById('photoModal');
    const photoModal = photoModalEl ? new bootstrap.Modal(photoModalEl) : null;
    const modalImg = document.getElementById('modalPhotoImg');
    const modalDate = document.getElementById('modalPhotoDate');
    const modalTitle = document.getElementById('modalPhotoTitle');

    document.querySelectorAll('.desktop-circle-box, .mobile-circle-box').forEach(box => {
        box.addEventListener('click', function (e) {
            if (Math.abs(currentDeltaX) > 10) return; // ignore click if dragging
            const src = this.getAttribute('data-photo-src');
            const date = this.getAttribute('data-photo-date');
            const title = this.getAttribute('data-photo-title');

            if (modalImg && src) modalImg.src = src;
            if (modalDate && date) modalDate.textContent = date;
            if (modalTitle && title) modalTitle.textContent = title;

            if (photoModal) photoModal.show();
        });
    });

    // Initial setup
    goToSlide(0, false);
});
</script>
@endpush
