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
                            <span class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle" style="width: 32px; height: 32px;">
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
                                   value="{{ old('institution_name', $settings['institution_name']['value'] ?? 'Pusat Distribusi Makanan Bergizi Sehat') }}"
                                   placeholder="Contoh: Pusat Distribusi Makanan Bergizi Sehat"
                                   required>
                            <div class="form-text small text-muted">
                                Nama instansi resmi penyedia makanan yang dicantumkan pada format cetak stiker label gizi.
                            </div>
                            @error('institution_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                            <span class="text-muted small">
                                <i class="fa-solid fa-circle-info text-primary me-1"></i> Perubahan langsung aktif di seluruh sistem.
                            </span>
                            <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-semibold shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>
@endsection
