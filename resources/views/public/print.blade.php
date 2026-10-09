<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label Stiker — {{ $label->title }}</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <style>
        body {
            background-color: #f1f5f9;
        }
        @media print {
            body {
                background-color: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-wrapper {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
            .nutrition-facts-box {
                max-width: 420px !important;
                margin: 0 auto !important;
                border: 2px solid #000 !important;
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body class="py-4">

    <!-- Screen Control Bar (Hidden on print) -->
    <div class="container text-center mb-4 no-print">
        <div class="card border-0 shadow-sm rounded-4 p-3 d-inline-flex flex-row align-items-center gap-3 bg-white">
            <button type="button" class="btn btn-success rounded-pill px-4" onclick="window.print()">
                <i class="fa-solid fa-print me-1"></i> Cetak Stiker Sekarang
            </button>
            <a href="{{ route('public.labels.show', $label->slug) }}" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
            <span class="text-muted small">Ukuran dioptimalkan untuk label kemasan / kertas A4.</span>
        </div>
    </div>

    <!-- Official Nutrition Facts Print Sticker -->
    <div class="container print-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">

                <div class="nutrition-facts-box shadow-sm rounded-3 p-4 bg-white">
                    <!-- Header -->
                    <div class="text-center pb-2 border-bottom border-dark border-3">
                        <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                            <i class="fa-solid fa-apple-whole text-success fs-3"></i>
                            <h4 class="fw-black text-uppercase text-dark mb-0 tracking-tight" style="font-weight: 900; letter-spacing: -0.5px;">
                                INFORMASI NILAI GIZI
                            </h4>
                        </div>
                        <div class="small fw-bold text-secondary text-uppercase" style="letter-spacing: 1px;">
                            LABEL MAKANAN BERGIZI
                        </div>
                    </div>

                    <!-- Title & Date -->
                    <div class="py-2 border-bottom border-dark">
                        <div class="fw-bold text-dark fs-6">{{ $label->title }}</div>
                        <div class="small text-muted d-flex justify-content-between align-items-center mt-1">
                            <span>Tanggal: <strong>{{ $label->menu_date->isoFormat('D MMMM Y') }}</strong></span>
                            @if($label->recipient_group)
                                <span>Sasaran: <strong>{{ $label->recipient_group }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <!-- Kalori / Energi -->
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

                    <!-- Nutrisi Table -->
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

                    <!-- Menus -->
                    <div class="py-2 border-bottom border-dark">
                        <div class="small fw-bold text-dark text-uppercase mb-2">Komposisi Menu Sajian:</div>
                        <ol class="ps-3 mb-0 small text-dark d-flex flex-column gap-1">
                            @foreach($label->menus as $item)
                                <li class="fw-medium">{{ $item->name }}</li>
                            @endforeach
                        </ol>
                    </div>

                    <!-- Consumption Limit Callout -->
                    <div class="mt-3 p-3 bg-light border border-dark rounded-3">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="fa-solid fa-triangle-exclamation text-warning fs-5"></i>
                            <span class="fw-bold text-dark small text-uppercase">Petunjuk Batas Waktu Konsumsi</span>
                        </div>
                        <div class="fw-bold text-danger fs-6">
                            {{ $label->formatted_consumption_limit }}
                        </div>
                        <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                            * Dihitung relatif sejak makanan diantarkan. Segera konsumsi sebelum batas waktu demi menjaga higienitas dan kesehatan.
                        </small>
                    </div>

                    <!-- Footer -->
                    <div class="text-center pt-3 small text-muted" style="font-size: 0.7rem;">
                        {{ \App\Models\ApplicationSetting::get('institution_name', 'Pusat Distribusi Makanan Bergizi Sehat') }}<br>
                        Sistem Informasi Pangan Bergizi &bull; {{ config('app.name') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
