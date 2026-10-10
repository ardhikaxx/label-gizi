@extends('layouts.admin')

@section('title', 'Detail Label: ' . $label->title)
@section('page_title', 'Detail Informasi Label Makanan')

@section('content')
<div class="container-fluid p-0">

    <!-- Breadcrumb & Top Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.labels.index') }}" class="text-decoration-none text-muted">Kelola Label</a></li>
                    <li class="breadcrumb-item active text-success fw-semibold">Detail</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <h4 class="fw-bold text-dark mb-0">{{ $label->title }}</h4>
                <span class="badge {{ $label->status_badge_class }} rounded-pill px-3 py-1">
                    {{ $label->status_label }}
                </span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('admin.labels.edit', $label) }}" class="btn btn-primary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-pen-to-square me-1"></i> Edit Label
            </a>
            <a href="{{ route('admin.labels.index') }}" class="btn btn-light border btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Status Action Bar (Publish, Unpublish, Archive, Duplicate, Delete) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-light">
        <div class="card-body p-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-2 small text-muted">
                <i class="fa-solid fa-circle-info text-success"></i>
                <span>Status Saat Ini: <strong class="text-dark">{{ $label->status_label }}</strong></span>
                @if($label->published_at)
                    &bull; <span>Diterbitkan: {{ $label->published_at->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
                @endif
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                @if($label->status !== 'published')
                    <form action="{{ route('admin.labels.publish', $label) }}" method="POST"
                          data-confirm="Publikasikan label ini agar dapat diakses oleh masyarakat umum?"
                          data-confirm-icon="question"
                          data-confirm-btn="Ya, Publikasikan"
                          data-confirm-color="#198754">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                            <i class="fa-solid fa-circle-check me-1"></i> Publikasikan Sekarang
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.labels.unpublish', $label) }}" method="POST"
                          data-confirm="Tarik publikasi label ini kembali menjadi draft?"
                          data-confirm-icon="warning"
                          data-confirm-btn="Ya, Tarik Menjadi Draft"
                          data-confirm-color="#ffc107">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning text-dark rounded-pill px-3">
                            <i class="fa-solid fa-arrow-rotate-left me-1"></i> Tarik Menjadi Draft
                        </button>
                    </form>
                @endif

                @if($label->status !== 'archived')
                    <form action="{{ route('admin.labels.archive', $label) }}" method="POST"
                          data-confirm="Arsipkan label ini? Data tidak akan tampil di daftar publik aktif."
                          data-confirm-icon="info"
                          data-confirm-btn="Ya, Arsipkan"
                          data-confirm-color="#6c757d">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-solid fa-box-archive me-1"></i> Arsipkan
                        </button>
                    </form>
                @endif

                <form action="{{ route('admin.labels.duplicate', $label) }}" method="POST"
                      data-confirm="Buat salinan draft baru dari label ini?"
                      data-confirm-icon="question"
                      data-confirm-btn="Ya, Buat Salinan"
                      data-confirm-color="#198754">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3">
                        <i class="fa-solid fa-copy me-1"></i> Duplikasi
                    </button>
                </form>

                <form action="{{ route('admin.labels.destroy', $label) }}" method="POST"
                      data-confirm="Hapus label makanan ini secara soft delete?"
                      data-confirm-icon="warning"
                      data-confirm-btn="Ya, Hapus"
                      data-confirm-color="#dc3545">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                        <i class="fa-solid fa-trash me-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Info & Nutrition Facts Column -->
        <div class="col-lg-8">

            <!-- Summary & Description Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <small class="text-muted d-block">Tanggal Penyajian Menu:</small>
                            <span class="fs-6 fw-bold text-dark">
                                <i class="fa-regular fa-calendar-check text-success me-1"></i>
                                {{ $label->menu_date->isoFormat('dddd, D MMMM Y') }}
                            </span>
                        </div>
                    </div>

                    @if($label->description)
                        <div class="p-3 bg-light rounded-3 mt-2">
                            <small class="text-muted fw-bold d-block mb-1">Keterangan / Catatan Menu:</small>
                            <p class="mb-0 text-dark small">{{ $label->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Analisis Zat Gizi Pills Grid -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                    <h5 class="fw-bold text-dark mb-0">Analisis Zat Gizi Makro & Serat</h5>
                    <p class="text-muted small mt-1 mb-0">Rincian nilai gizi per porsi saji terverifikasi.</p>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 text-center">
                        <div class="col-6 col-md">
                            <div class="p-3 bg-light rounded-4 border">
                                <div class="fs-3 fw-bold text-success mb-0">{{ number_format($label->energy, 0, ',', '.') }}</div>
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 small">kkal</span>
                                <div class="text-muted small fw-semibold mt-1">Energi Total</div>
                            </div>
                        </div>

                        <div class="col-6 col-md">
                            <div class="p-3 bg-light rounded-4 border">
                                <div class="fs-3 fw-bold text-dark mb-0">{{ number_format($label->protein, 1, ',', '.') }}</div>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 py-1 small">gram</span>
                                <div class="text-muted small fw-semibold mt-1">Protein</div>
                            </div>
                        </div>

                        <div class="col-6 col-md">
                            <div class="p-3 bg-light rounded-4 border">
                                <div class="fs-3 fw-bold text-dark mb-0">{{ number_format($label->fat, 1, ',', '.') }}</div>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 py-1 small">gram</span>
                                <div class="text-muted small fw-semibold mt-1">Lemak</div>
                            </div>
                        </div>

                        <div class="col-6 col-md">
                            <div class="p-3 bg-light rounded-4 border">
                                <div class="fs-3 fw-bold text-dark mb-0">{{ number_format($label->carbohydrate, 1, ',', '.') }}</div>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 py-1 small">gram</span>
                                <div class="text-muted small fw-semibold mt-1">Karbohidrat</div>
                            </div>
                        </div>

                        <div class="col-6 col-md">
                            <div class="p-3 bg-light rounded-4 border">
                                <div class="fs-3 fw-bold text-dark mb-0">{{ number_format($label->fiber, 1, ',', '.') }}</div>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 py-1 small">gram</span>
                                <div class="text-muted small fw-semibold mt-1">Serat Pangan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rincian Menu Makanan -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                    <h5 class="fw-bold text-dark mb-0">Rincian Menu Makanan ({{ $label->menus->count() }} Item)</h5>
                    <p class="text-muted small mt-1 mb-0">Disajikan sesuai nomor urutan penyajian.</p>
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush border rounded-3 overflow-hidden">
                        @forelse($label->menus as $menu)
                            <div class="list-group-item d-flex align-items-center gap-3 py-3">
                                <span class="badge bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px;">
                                    {{ $menu->sort_order }}
                                </span>
                                <span class="fs-6 fw-semibold text-dark">{{ $menu->name }}</span>
                            </div>
                        @empty
                            <div class="p-4 text-center text-muted small">
                                Belum ada menu makanan yang dimasukkan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        <!-- Sidebar Info: Consumption Limit & Audit Column -->
        <div class="col-lg-4">

            @if($label->image)
                <!-- Foto Makanan Bergizi Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold text-dark mb-0">Foto Makanan Bergizi</h6>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5 py-1 small">WebP</span>
                    </div>
                    <div class="card-body p-4 text-center">
                        <a href="{{ $label->image_url }}" target="_blank" title="Buka foto dalam resolusi penuh">
                            <img src="{{ $label->image_url }}" alt="{{ $label->title }}" class="img-fluid rounded-3 border shadow-sm object-fit-cover w-100" style="max-height: 240px;">
                        </a>
                        <small class="text-muted d-block mt-2">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> Klik untuk melihat ukuran penuh
                        </small>
                    </div>
                </div>
            @endif

            <!-- Batas Akhir Konsumsi Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                    <h6 class="fw-bold text-dark mb-0">Batas Waktu Konsumsi Aman</h6>
                </div>
                <div class="card-body p-4">
                    <div class="consumption-limit-alert p-3 mb-3">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="fa-solid fa-clock-rotate-left fs-4 text-warning"></i>
                            <span class="limit-badge fs-5">{{ $label->formatted_consumption_limit }}</span>
                        </div>
                        <div class="mt-2 pt-2 border-top border-warning border-opacity-25">
                            <div class="small text-muted fw-semibold">Tampilan Jam pada Halaman Depan:</div>
                            <div class="fw-bold text-dark fs-6 mt-1">
                                <i class="fa-regular fa-clock me-1 text-primary"></i> {{ $label->formatted_consumption_time_range }}
                            </div>
                        </div>
                        <p class="small mb-0 text-muted mt-2">
                            * Durasi keamanan pangan dihitung secara relatif sejak waktu makanan tiba/diantarkan ke penerima.
                        </p>
                    </div>

                    <div class="p-3 bg-light rounded-3 small text-muted">
                        <i class="fa-solid fa-shield-check text-success me-1"></i>
                        Petunjuk ini membantu penerima manfaat menikmati makanan sebelum terjadi risiko kontaminasi mikroba atau penurunan kualitas gizi.
                    </div>
                </div>
            </div>

            <!-- Audit Trail & Info Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                    <h6 class="fw-bold text-dark mb-0">Informasi Pembuatan & Audit</h6>
                </div>
                <div class="card-body p-4">
                    <ul class="list-unstyled small d-flex flex-column gap-3 mb-0">
                        <li class="d-flex justify-content-between">
                            <span class="text-muted">Slug URL:</span>
                            <code class="text-dark">{{ $label->slug }}</code>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span class="text-muted">Dibuat Oleh:</span>
                            <span class="fw-semibold text-dark">{{ $label->creator?->name ?? 'Sistem' }}</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span class="text-muted">Waktu Dibuat:</span>
                            <span class="text-dark">{{ $label->created_at->isoFormat('D MMMM Y, HH:mm') }}</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span class="text-muted">Terakhir Diperbarui:</span>
                            <span class="text-dark">{{ $label->updated_at->isoFormat('D MMMM Y, HH:mm') }}</span>
                        </li>
                        @if($label->updater)
                            <li class="d-flex justify-content-between">
                                <span class="text-muted">Pengubah Terakhir:</span>
                                <span class="fw-semibold text-dark">{{ $label->updater->name }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
