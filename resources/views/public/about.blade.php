@extends('layouts.public')

@section('title', 'Tentang Informasi Gizi')
@section('meta_description', 'Panduan edukasi mengenai zat gizi makro, transparansi pangan, standar kebersihan makanan bergizi, dan alasan pentingnya batas waktu konsumsi.')

@section('content')
<!-- Header -->
<section class="py-5 bg-white border-bottom">
    <div class="container text-center">
        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold small text-uppercase">Pedoman & Edukasi</span>
        <h1 class="fw-bold text-dark mt-2 mb-3">Tentang Informasi Label Gizi</h1>
        <p class="text-muted small mx-auto" style="max-width: 650px;">
            Memahami fungsi nutrisi makro, standar mutu makanan bergizi, dan petunjuk operasional batas waktu konsumsi demi menjaga kesehatan masyarakat dan generasi penerus bangsa.
        </p>
    </div>
</section>

<!-- Content Sections -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-5 justify-content-center">
            <div class="col-lg-9">

                <!-- Mengapa Transparansi Penting -->
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="fa-solid fa-eye fs-5"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-0">Transparansi Informasi Makanan Bergizi</h4>
                    </div>
                    <p class="text-muted leading-relaxed mb-3">
                        Pemberian makanan bergizi memerlukan keterbukaan informasi agar penerima manfaat, orang tua, pendidik, dan masyarakat umum dapat mengetahui secara pasti komposisi makanan yang disajikan. Setiap menu dirancang untuk memenuhi kecukupan gizi seimbang yang mendukung tumbuh kembang optimal dan mencegah masalah gizi ganda (stunting maupun obesitas).
                    </p>
                    <p class="text-muted leading-relaxed mb-0">
                        Melalui sistem label ini, seluruh pihak dapat meninjau rincian sajian mulai dari nasi, lauk hewani, lauk nabati, sayuran, buah, hingga minuman pelengkap seperti susu, beserta kalkulasi energi dan zat gizi makronya.
                    </p>
                </div>

                <!-- 5 Unsur Gizi Utama -->
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
                    <h4 class="fw-bold text-dark mb-4">
                        <i class="fa-solid fa-apple-whole text-success me-2"></i> Mengenal 5 Komponen Analisis Gizi
                    </h4>

                    <div class="d-flex flex-column gap-4">
                        <!-- Energi Total -->
                        <div class="d-flex align-items-start gap-3">
                            <span class="badge bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold p-3" style="width: 40px; height: 40px;">
                                <i class="fa-solid fa-bolt"></i>
                            </span>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">1. Energi Total (Satuan: kkal)</h6>
                                <p class="text-muted small mb-0 leading-relaxed">
                                    Kalori atau energi total merupakan total bahan bakar yang disediakan makanan untuk menjalankan fungsi organ tubuh, aktivitas fisik, belajar, dan bermain. Kebutuhan kalori disesuaikan dengan rentang usia kelompok sasaran.
                                </p>
                            </div>
                        </div>

                        <!-- Protein -->
                        <div class="d-flex align-items-start gap-3">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold p-3" style="width: 40px; height: 40px;">
                                <i class="fa-solid fa-drumstick-bite"></i>
                            </span>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">2. Protein (Satuan: gram)</h6>
                                <p class="text-muted small mb-0 leading-relaxed">
                                    Zat pembangun tubuh yang sangat penting untuk pertumbuhan tulang dan otot, perbaikan jaringan sel yang rusak, pembentukan enzim, serta antibodi sistem kekebalan tubuh. Bersumber dari protein hewani (ayam, daging, ikan, telur, susu) dan nabati (tahu, tempe, kacang-kacangan).
                                </p>
                            </div>
                        </div>

                        <!-- Lemak -->
                        <div class="d-flex align-items-start gap-3">
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center fw-bold p-3" style="width: 40px; height: 40px;">
                                <i class="fa-solid fa-droplet"></i>
                            </span>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">3. Lemak (Satuan: gram)</h6>
                                <p class="text-muted small mb-0 leading-relaxed">
                                    Lemak sehat dibutuhkan sebagai pelarut vitamin penting (A, D, E, K), isolator suhu tubuh, serta perkembangan fungsi otak pada masa pertumbuhan. Pengolahan makanan mengutamakan batas lemak yang terkontrol dan higienis.
                                </p>
                            </div>
                        </div>

                        <!-- Karbohidrat -->
                        <div class="d-flex align-items-start gap-3">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold p-3" style="width: 40px; height: 40px;">
                                <i class="fa-solid fa-wheat-awn"></i>
                            </span>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">4. Karbohidrat (Satuan: gram)</h6>
                                <p class="text-muted small mb-0 leading-relaxed">
                                    Sumber glukosa utama bagi sel saraf dan otak. Karbohidrat kompleks yang berasal dari beras pulen, beras merah, umbi-umbian, atau jagung memberikan pelepasan energi yang lebih stabil sepanjang hari.
                                </p>
                            </div>
                        </div>

                        <!-- Serat -->
                        <div class="d-flex align-items-start gap-3">
                            <span class="badge bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center fw-bold p-3" style="width: 40px; height: 40px;">
                                <i class="fa-solid fa-leaf"></i>
                            </span>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">5. Serat Pangan (Satuan: gram)</h6>
                                <p class="text-muted small mb-0 leading-relaxed">
                                    Membantu memelihara kesehatan saluran pencernaan, mencegah sembelit, dan memperlambat penyerapan gula darah. Diperoleh dari sayuran hijau segar, wortel, brokoli, dan buah-buahan tropis segar.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Petunjuk Batas Waktu Konsumsi -->
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-warning bg-opacity-25 text-warning d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="fa-solid fa-clock-rotate-left fs-5"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-0">Mengapa Batas Konsumsi Dihitung Relatif Sejak Pengantaran?</h4>
                    </div>
                    <div class="consumption-limit-alert mb-3 p-3">
                        <i class="fa-solid fa-circle-exclamation me-1"></i>
                        <strong>Contoh Ketentuan:</strong> "Batas akhir konsumsi: maksimal 4 jam setelah pengantaran".
                    </div>
                    <p class="text-muted leading-relaxed mb-3">
                        Makanan siap santap yang diolah segar memiliki masa aman optimum untuk dinikmati pada suhu ruang. Karena jam distribusi ke masing-masing titik penerima dapat bervariasi, batas waktu tidak ditetapkan dalam jam kalender statis (seperti pukul 12:00), melainkan dalam durasi jam sejak makanan sampai di lokasi penerima.
                    </p>
                    <p class="text-muted leading-relaxed mb-0">
                        Hal ini memastikan bahwa batas waktu konsumsi selalu adil dan relevan dengan waktu kedatangan fisik makanan, sekaligus menjadi panduan bagi guru, pengawas, atau orang tua untuk segera membagikan makanan kepada anak-anak sebelum batas waktu terlampaui.
                    </p>
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('public.labels') }}" class="btn btn-success rounded-pill px-5 py-3 fw-semibold shadow-sm">
                        <i class="fa-solid fa-utensils me-2"></i> Telusuri Katalog Label Makanan
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
