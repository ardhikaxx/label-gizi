@extends('layouts.admin')

@section('title', 'Pengaturan Aplikasi')
@section('page_title', 'Pengaturan Sistem & Identitas')

@section('content')
<div class="container-fluid p-0">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Pengaturan Sistem</h4>
            <p class="text-muted small mb-0">Kelola identitas aplikasi, kontak layanan publik, dan teks edukasi website.</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Left Column: General & Contact -->
            <div class="col-lg-6">

                <!-- Identitas Aplikasi -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-id-card"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Identitas Aplikasi</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="app_name" class="form-label small fw-semibold">Nama Aplikasi</label>
                            <input type="text"
                                   name="app_name"
                                   id="app_name"
                                   class="form-control @error('app_name') is-invalid @enderror"
                                   value="{{ old('app_name', $settings['app_name']['value'] ?? 'Label Gizi') }}"
                                   required>
                            @error('app_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="institution_name" class="form-label small fw-semibold">Nama Instansi / Pengelola Pangan</label>
                            <input type="text"
                                   name="institution_name"
                                   id="institution_name"
                                   class="form-control @error('institution_name') is-invalid @enderror"
                                   value="{{ old('institution_name', $settings['institution_name']['value'] ?? 'Pusat Distribusi Makanan Bergizi Sehat') }}"
                                   required>
                            @error('institution_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-0">
                            <label for="footer_text" class="form-label small fw-semibold">Teks Penjelasan Footer</label>
                            <textarea name="footer_text"
                                      id="footer_text"
                                      rows="2"
                                      class="form-control @error('footer_text') is-invalid @enderror"
                                      required>{{ old('footer_text', $settings['footer_text']['value'] ?? '') }}</textarea>
                            @error('footer_text') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <!-- Kontak Layanan Publik -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-address-book"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Kontak Layanan Publik</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="contact_email" class="form-label small fw-semibold">Email Kontak</label>
                            <input type="email"
                                   name="contact_email"
                                   id="contact_email"
                                   class="form-control @error('contact_email') is-invalid @enderror"
                                   value="{{ old('contact_email', $settings['contact_email']['value'] ?? '') }}"
                                   required>
                            @error('contact_email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-0">
                            <label for="contact_phone" class="form-label small fw-semibold">Nomor Telepon / WhatsApp</label>
                            <input type="text"
                                   name="contact_phone"
                                   id="contact_phone"
                                   class="form-control @error('contact_phone') is-invalid @enderror"
                                   value="{{ old('contact_phone', $settings['contact_phone']['value'] ?? '') }}"
                                   required>
                            @error('contact_phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Landing Page & Education Copy -->
            <div class="col-lg-6">

                <!-- Konten Landing Page -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info rounded-circle" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-desktop"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Konten Landing Page & Banner</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="hero_title" class="form-label small fw-semibold">Judul Banner Utama (Hero)</label>
                            <input type="text"
                                   name="hero_title"
                                   id="hero_title"
                                   class="form-control @error('hero_title') is-invalid @enderror"
                                   value="{{ old('hero_title', $settings['hero_title']['value'] ?? '') }}"
                                   required>
                            @error('hero_title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-0">
                            <label for="hero_subtitle" class="form-label small fw-semibold">Deskripsi Subjudul Banner</label>
                            <textarea name="hero_subtitle"
                                      id="hero_subtitle"
                                      rows="3"
                                      class="form-control @error('hero_subtitle') is-invalid @enderror"
                                      required>{{ old('hero_subtitle', $settings['hero_subtitle']['value'] ?? '') }}</textarea>
                            @error('hero_subtitle') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <!-- Bagian Edukasi Gizi -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning rounded-circle" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Bagian Edukasi Gizi Publik</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="education_title" class="form-label small fw-semibold">Judul Edukasi</label>
                            <input type="text"
                                   name="education_title"
                                   id="education_title"
                                   class="form-control @error('education_title') is-invalid @enderror"
                                   value="{{ old('education_title', $settings['education_title']['value'] ?? '') }}"
                                   required>
                            @error('education_title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-0">
                            <label for="education_text" class="form-label small fw-semibold">Teks Penjelasan Edukasi Gizi</label>
                            <textarea name="education_text"
                                      id="education_text"
                                      rows="4"
                                      class="form-control @error('education_text') is-invalid @enderror"
                                      required>{{ old('education_text', $settings['education_text']['value'] ?? '') }}</textarea>
                            @error('education_text') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success rounded-pill px-5 py-2 fw-semibold shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Pengaturan
                    </button>
                </div>

            </div>
        </div>
    </form>

</div>
@endsection
