@php
    $appName = \App\Models\ApplicationSetting::get('app_name', 'Label Gizi');
    $institution = \App\Models\ApplicationSetting::get('institution_name', 'Pusat Distribusi Makanan Bergizi Sehat');
    $contactEmail = \App\Models\ApplicationSetting::get('contact_email', 'layanan@labelgizi.go.id');
    $contactPhone = \App\Models\ApplicationSetting::get('contact_phone', '+62 812-3456-7890');
    $footerText = \App\Models\ApplicationSetting::get('footer_text', 'Sistem Informasi Label Makanan Bergizi — Transparansi Pangan Sehat untuk Generasi Indonesia Kuat.');
@endphp
<footer class="bg-white border-top mt-auto py-5 no-print">
    <div class="container">
        <div class="row g-4 justify-content-between">
            <div class="col-lg-5 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle" style="width: 32px; height: 32px;">
                        <i class="fa-solid fa-apple-whole"></i>
                    </span>
                    <span class="fs-5 fw-bold text-success">{{ $appName }}</span>
                </div>
                <p class="text-muted small mb-2">{{ $footerText }}</p>
                <p class="text-secondary small fw-medium mb-0">Dikelola oleh: <strong>{{ $institution }}</strong></p>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-dark mb-3">Tautan Cepat</h6>
                <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                    <li><a href="{{ route('public.home') }}" class="text-decoration-none text-muted hover-success"><i class="fa-solid fa-chevron-right me-1 text-success small"></i> Beranda</a></li>
                    <li><a href="{{ route('public.labels') }}" class="text-decoration-none text-muted hover-success"><i class="fa-solid fa-chevron-right me-1 text-success small"></i> Daftar Label Makanan</a></li>
                    <li><a href="{{ route('public.about') }}" class="text-decoration-none text-muted hover-success"><i class="fa-solid fa-chevron-right me-1 text-success small"></i> Tentang Informasi Gizi</a></li>
                    <li><a href="{{ route('admin.login') }}" class="text-decoration-none text-muted hover-success"><i class="fa-solid fa-lock me-1 text-secondary small"></i> Akses Administrator</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12">
                <h6 class="fw-bold text-dark mb-3">Layanan & Kontak</h6>
                <ul class="list-unstyled small text-muted mb-0 d-flex flex-column gap-2">
                    <li><i class="fa-solid fa-envelope text-success me-2"></i> {{ $contactEmail }}</li>
                    <li><i class="fa-solid fa-phone text-success me-2"></i> {{ $contactPhone }}</li>
                    <li><i class="fa-solid fa-shield-halved text-success me-2"></i> Petunjuk batas konsumsi relatif dihitung sejak makanan diantarkan.</li>
                </ul>
            </div>
        </div>

        <hr class="my-4 text-secondary opacity-25">

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 small text-muted">
            <div>&copy; {{ date('Y') }} {{ $appName }}. Hak Cipta Dilindungi Undang-Undang.</div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-light text-secondary border">Standar Informasi Pangan Sehat</span>
            </div>
        </div>
    </div>
</footer>
