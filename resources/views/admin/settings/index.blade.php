@extends('layouts.admin')

@section('title', 'Pengaturan Aplikasi')
@section('page_title', 'Pengaturan Sistem & Identitas')

@section('content')
<div class="container-fluid p-0">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Pengaturan Sistem</h4>
            <p class="text-muted small mb-0">Kelola identitas utama aplikasi dan informasi instansi pengelola pangan.</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8 col-xl-7">

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 32px; height: 32px; background: rgba(11, 40, 83, 0.1); color: #0b2853;">
                                <i class="fa-solid fa-sliders"></i>
                            </span>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Identitas Aplikasi & Pengelola</h5>
                                <small class="text-muted">Pengaturan utama yang digunakan pada sistem dan cetak label</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <!-- Nama Aplikasi -->
                        <div class="mb-4">
                            <label for="app_name" class="form-label fw-semibold text-dark">
                                Nama Aplikasi <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="app_name"
                                   id="app_name"
                                   class="form-control form-control-lg fs-6 @error('app_name') is-invalid @enderror"
                                   value="{{ old('app_name', $settings['app_name']['value'] ?? 'Label Gizi') }}"
                                   placeholder="Contoh: Label Gizi"
                                   required>
                            <div class="form-text small text-muted">
                                Nama sistem yang digunakan pada judul browser (tab title), metadata, dan identitas aplikasi.
                            </div>
                            @error('app_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Nama Instansi / Pengelola Pangan -->
                        <div class="mb-4">
                            <label for="institution_name" class="form-label fw-semibold text-dark">
                                Nama Instansi / Pengelola Pangan <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="institution_name"
                                   id="institution_name"
                                   class="form-control form-control-lg fs-6 @error('institution_name') is-invalid @enderror"
                                   value="{{ old('institution_name', $settings['institution_name']['value'] ?? 'Badan Gizi Nasional Republik Indonesia') }}"
                                   placeholder="Contoh: Badan Gizi Nasional Republik Indonesia"
                                   required>
                            <div class="form-text small text-muted">
                                Nama instansi resmi penyedia makanan yang dicantumkan pada format cetak stiker label gizi.
                            </div>
                            @error('institution_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Default Jam Batas Konsumsi (Tampilan Awal) -->
                        <div class="mb-4 pt-3 border-top">
                            <label class="form-label fw-semibold text-dark mb-1">
                                Default Jam Konsumsi (Tampilan Awal)
                            </label>
                            <p class="text-muted small mb-3">
                                Atur rentang jam konsumsi standar ("Jam berapa sampai jam berapa") untuk halaman publik depan dan bawaan pembuatan label baru.
                            </p>
                            <div class="row g-2 mb-2">
                                <div class="col-sm-6">
                                    <label for="default_consumption_time_start" class="form-label small fw-semibold text-muted">Jam Mulai</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light text-muted"><i class="fa-regular fa-clock"></i></span>
                                        <input type="time"
                                               name="default_consumption_time_start"
                                               id="default_consumption_time_start"
                                               class="form-control @error('default_consumption_time_start') is-invalid @enderror"
                                               value="{{ old('default_consumption_time_start', $settings['default_consumption_time_start']['value'] ?? '08:00') }}">
                                    </div>
                                    <div class="form-text small text-muted">Contoh: 08:00 WIB</div>
                                    @error('default_consumption_time_start') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label for="default_consumption_time_end" class="form-label small fw-semibold text-muted">Jam Selesai</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light text-muted"><i class="fa-regular fa-clock"></i></span>
                                        <input type="time"
                                               name="default_consumption_time_end"
                                               id="default_consumption_time_end"
                                               class="form-control @error('default_consumption_time_end') is-invalid @enderror"
                                               value="{{ old('default_consumption_time_end', $settings['default_consumption_time_end']['value'] ?? '12:00') }}">
                                    </div>
                                    <div class="form-text small text-muted">Contoh: 12:00 WIB</div>
                                    @error('default_consumption_time_end') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-text small text-muted">
                                Format tampilan di halaman publik: <strong>Pukul : 08.00 – 12.00 WIB</strong>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                            <span class="text-muted small">
                                <i class="fa-solid fa-circle-info text-primary me-1"></i> Perubahan langsung aktif di seluruh sistem.
                            </span>
                            <button type="submit" class="btn btn-bgn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-4 col-xl-5">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center p-3 rounded-circle bg-light mx-auto mb-3" style="width: 120px; height: 120px; box-shadow: 0 4px 12px rgba(11, 40, 83, 0.08);">
                        <img src="{{ asset('images/logo-bgn.png') }}" alt="Logo Badan Gizi Nasional" style="width: 90px; height: 90px; object-fit: contain;">
                    </div>
                    <h5 class="fw-bold text-dark mb-1">Badan Gizi Nasional</h5>
                    <div class="badge badge-bgn-gold mx-auto mb-3 px-3 py-1 text-uppercase" style="letter-spacing: 0.08em; font-size: 0.72rem;">
                        Republik Indonesia
                    </div>
                    <p class="text-muted small mb-0">
                        Identitas visual resmi Badan Gizi Nasional RI diterapkan pada tata letak administrator, halaman otentikasi login, serta palet warna navigasi.
                    </p>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
