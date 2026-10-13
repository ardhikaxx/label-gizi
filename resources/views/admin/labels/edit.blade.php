@extends('layouts.admin')

@section('title', 'Edit Label Makanan')
@section('page_title', 'Edit Label: ' . $label->title)

@section('content')
<div class="container-fluid p-0">

    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.labels.index') }}" class="text-decoration-none text-muted">Kelola Label</a></li>
                    <li class="breadcrumb-item active text-success fw-semibold">Edit Label</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <h4 class="fw-bold text-dark mb-0">Edit Label Makanan</h4>
                <span class="badge {{ $label->status_badge_class }} rounded-pill px-2 py-1">
                    {{ $label->status_label }}
                </span>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('admin.labels.show', $label) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Detail
            </a>
        </div>
    </div>

    <form action="{{ route('admin.labels.update', $label) }}" method="POST" id="foodLabelForm" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Left Column: Menu Information & Menus -->
            <div class="col-lg-7">

                <!-- Section: Informasi Menu Hari Ini -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-calendar-day"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Informasi Menu Hari Ini</h5>
                        </div>
                        <p class="text-muted small mt-1 mb-0">Sesuaikan tanggal penyajian dan judul paket makanan.</p>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="bgn-field mb-1">
                                    <input type="text"
                                           class="bgn-field-input has-suffix @error('menu_date') is-invalid @enderror"
                                           id="menu_date"
                                           name="menu_date"
                                           value="{{ old('menu_date', $label->menu_date->format('Y-m-d')) }}"
                                           data-flatpickr-date
                                           placeholder=" "
                                           required>
                                    <label for="menu_date" class="bgn-field-label">Tanggal Menu *</label>
                                    <span class="bgn-field-suffix-btn text-muted" style="pointer-events: none;">
                                        <i class="fa-regular fa-calendar"></i>
                                    </span>
                                </div>
                                <div class="form-text small text-muted ps-1" id="menuDateScheduleNotice">
                                    <i class="fa-solid fa-circle-info text-info me-1"></i> Tanggal menu hari ini langsung diterbitkan, sedangkan tanggal esok/masa depan otomatis berstatus <strong>Terjadwal</strong>.
                                </div>
                                @error('menu_date')
                                    <div class="bgn-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="bgn-field mb-1">
                                    <select class="bgn-field-input bgn-field-select @error('food_condition') is-invalid @enderror" id="food_condition" name="food_condition" required>
                                        @foreach($conditions as $conditionOption)
                                            <option value="{{ $conditionOption }}" {{ old('food_condition', $label->food_condition) === $conditionOption ? 'selected' : '' }}>
                                                {{ $conditionOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="food_condition" class="bgn-field-label">Kondisi Makanan *</label>
                                </div>
                                <div class="form-text small text-muted ps-1">Kategori kondisi makanan untuk sasaran penerima (Porsi besar, Porsi kecil, Alergi, Balita, Busui dan Bumil).</div>
                                @error('food_condition')
                                    <div class="bgn-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="bgn-field mb-1">
                                    <input type="text"
                                           class="bgn-field-input @error('title') is-invalid @enderror"
                                           id="title"
                                           name="title"
                                           value="{{ old('title', $label->title) }}"
                                           placeholder=" "
                                           required>
                                    <label for="title" class="bgn-field-label">Nama Paket / Judul Label *</label>
                                </div>
                                @error('title')
                                    <div class="bgn-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="bgn-field mb-1">
                                    <textarea class="bgn-field-input bgn-field-textarea @error('description') is-invalid @enderror"
                                              id="description"
                                              name="description"
                                              rows="2"
                                              placeholder=" ">{{ old('description', $label->description) }}</textarea>
                                    <label for="description" class="bgn-field-label">Keterangan Tambahan (Opsional)</label>
                                </div>
                                @error('description')
                                    <div class="bgn-field-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Foto Makanan Bergizi Gratis -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info rounded-circle" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-camera"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Foto Makanan Bergizi Gratis</h5>
                        </div>
                        <p class="text-muted small mt-1 mb-0">Format gambar otomatis dikonversi ke <strong>WebP</strong> dan dikompresi agar cepat dimuat di halaman publik.</p>
                    </div>

                    <div class="card-body p-4">
                        @if($label->image)
                            <div class="mb-4 p-3 bg-light rounded-3 border">
                                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $label->image_url }}" alt="{{ $label->title }}" class="rounded-3 border shadow-sm object-fit-cover" style="width: 100px; height: 75px;">
                                        <div>
                                            <div class="fw-semibold text-dark small mb-1">Foto Saat Ini:</div>
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5 py-1 small">
                                                <i class="fa-solid fa-check me-1"></i> Format WebP
                                            </span>
                                            <div class="text-muted small mt-1" style="font-size: 0.75rem;">{{ $label->image }}</div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column gap-2 text-sm-end">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                                            <label class="form-check-label text-danger small fw-semibold" for="remove_image">
                                                Hapus foto saat simpan
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mb-2">
                            <label for="image" class="form-label small fw-semibold">
                                {{ $label->image ? 'Ganti Foto (Opsional)' : 'Pilih File Foto Makanan (Opsional)' }}
                            </label>
                            <input type="file"
                                   class="form-control @error('image') is-invalid @enderror"
                                   id="image"
                                   name="image"
                                   accept="image/jpeg,image/png,image/webp,image/jpg">
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div class="form-text small text-muted mt-1 d-flex flex-wrap align-items-center gap-2">
                                <span><i class="fa-solid fa-circle-info text-info me-1"></i>Format: JPG, JPEG, PNG, WEBP (Maksimal 10 MB).</span>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                    <i class="fa-solid fa-wand-magic-sparkles me-1"></i>Auto Compress & Convert to WebP
                                </span>
                            </div>
                        </div>

                        <!-- Progress / Loading Indikator Kompresi -->
                        <div id="imageCompressingIndicator" class="d-none mt-3 p-3 bg-light rounded-3 border text-center">
                            <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                            <span class="small fw-semibold text-secondary">Sedang mengompresi dan mengonversi foto ke WebP...</span>
                        </div>

                        <!-- Live Preview Area dengan Rincian Kompresi -->
                        <div id="imagePreviewContainer" class="d-none mt-3 p-3 bg-light rounded-3 border">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2 pb-2 border-bottom">
                                <div class="small fw-bold text-dark d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-bolt text-warning"></i>
                                    <span>Pratinjau Foto Baru (WebP Siap Unggah):</span>
                                </div>
                                <div class="d-flex flex-wrap align-items-center gap-1" id="compressionStatsBadges"></div>
                            </div>
                            <div class="position-relative text-center">
                                <img id="imagePreview" src="#" alt="Pratinjau Foto Baru" class="img-fluid rounded-3 shadow-sm border" style="max-height: 240px; object-fit: cover;">
                                <button type="button" id="btnRemovePreview" class="btn btn-sm btn-danger rounded-circle position-absolute top-0 end-0 m-2 shadow-sm" title="Batalkan Pilihan Foto" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Menu Makanan Dinamis -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle" style="width: 32px; height: 32px;">
                                    <i class="fa-solid fa-utensils"></i>
                                </span>
                                <h5 class="fw-bold text-dark mb-0">Rincian Menu Makanan</h5>
                            </div>
                            <p class="text-muted small mt-1 mb-0">Perbarui, tambah, atau kurangi jenis makanan yang disajikan.</p>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3" id="btnAddMenu">
                            <i class="fa-solid fa-plus me-1"></i> Tambah Menu
                        </button>
                    </div>

                    <div class="card-body p-4">
                        @error('menus')
                            <div class="alert alert-danger small py-2 mb-3">
                                <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                            </div>
                        @enderror

                        <div id="menuContainer" class="d-flex flex-column gap-2">
                            @php
                                $existingMenus = old('menus', $label->menus->pluck('name')->toArray());
                                if (empty($existingMenus)) {
                                    $existingMenus = ['Nasi Putih Pulen'];
                                }
                            @endphp

                            @foreach($existingMenus as $idx => $menuVal)
                                <div class="menu-row d-flex align-items-center gap-2">
                                    <span class="badge bg-light text-secondary border menu-number" style="width: 28px;">{{ $idx + 1 }}</span>
                                    <input type="text"
                                           name="menus[]"
                                           class="form-control menu-input @error('menus.'.$idx) is-invalid @enderror"
                                           value="{{ $menuVal }}"
                                           placeholder="Nama menu makanan"
                                           required>
                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-3 btn-remove-menu" title="Hapus Menu Ini">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                                @error('menus.'.$idx)
                                    <div class="text-danger small ps-4">{{ $message }}</div>
                                @enderror
                            @endforeach
                        </div>

                        <div class="mt-3 text-end">
                            <button type="button" class="btn btn-sm btn-light border text-success rounded-pill px-3" id="btnAddMenuBottom">
                                <i class="fa-solid fa-circle-plus me-1"></i> Tambah Baris Menu Baru
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Nutrition Analysis & Consumption Limit -->
            <div class="col-lg-5">

                <!-- Section: Analisis Zat Gizi -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-chart-pie"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Analisis Zat Gizi</h5>
                        </div>
                        <p class="text-muted small mt-1 mb-0">Perbarui nilai zat gizi makro dan serat pangan.</p>
                    </div>

                    <div class="card-body p-4">
                        <div class="d-flex flex-column gap-3">
                            <!-- Energi -->
                            <div class="bgn-field mb-1">
                                <input type="number"
                                       step="0.1"
                                       min="0"
                                       class="bgn-field-input has-suffix @error('energy') is-invalid @enderror"
                                       id="energy"
                                       name="energy"
                                       value="{{ old('energy', $label->energy) }}"
                                       placeholder=" "
                                       required>
                                <label for="energy" class="bgn-field-label">Energi Total *</label>
                                <span class="bgn-field-suffix-text">kkal</span>
                                @error('energy')
                                    <div class="bgn-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Protein -->
                            <div class="bgn-field mb-1">
                                <input type="number"
                                       step="0.1"
                                       min="0"
                                       class="bgn-field-input has-suffix @error('protein') is-invalid @enderror"
                                       id="protein"
                                       name="protein"
                                       value="{{ old('protein', $label->protein) }}"
                                       placeholder=" "
                                       required>
                                <label for="protein" class="bgn-field-label">Protein *</label>
                                <span class="bgn-field-suffix-text">gram</span>
                                @error('protein')
                                    <div class="bgn-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Lemak -->
                            <div class="bgn-field mb-1">
                                <input type="number"
                                       step="0.1"
                                       min="0"
                                       class="bgn-field-input has-suffix @error('fat') is-invalid @enderror"
                                       id="fat"
                                       name="fat"
                                       value="{{ old('fat', $label->fat) }}"
                                       placeholder=" "
                                       required>
                                <label for="fat" class="bgn-field-label">Lemak *</label>
                                <span class="bgn-field-suffix-text">gram</span>
                                @error('fat')
                                    <div class="bgn-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Karbohidrat -->
                            <div class="bgn-field mb-1">
                                <input type="number"
                                       step="0.1"
                                       min="0"
                                       class="bgn-field-input has-suffix @error('carbohydrate') is-invalid @enderror"
                                       id="carbohydrate"
                                       name="carbohydrate"
                                       value="{{ old('carbohydrate', $label->carbohydrate) }}"
                                       placeholder=" "
                                       required>
                                <label for="carbohydrate" class="bgn-field-label">Karbohidrat *</label>
                                <span class="bgn-field-suffix-text">gram</span>
                                @error('carbohydrate')
                                    <div class="bgn-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Serat -->
                            <div class="bgn-field mb-1">
                                <input type="number"
                                       step="0.1"
                                       min="0"
                                       class="bgn-field-input has-suffix @error('fiber') is-invalid @enderror"
                                       id="fiber"
                                       name="fiber"
                                       value="{{ old('fiber', $label->fiber) }}"
                                       placeholder=" "
                                       required>
                                <label for="fiber" class="bgn-field-label">Serat Pangan *</label>
                                <span class="bgn-field-suffix-text">gram</span>
                                @error('fiber')
                                    <div class="bgn-field-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Batas Akhir Konsumsi -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning rounded-circle" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-clock"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Waktu & Batas Akhir Konsumsi</h5>
                        </div>
                        <p class="text-muted small mt-1 mb-0">Ketentuan batas aman konsumsi serta jam konsumsi yang tampil pada halaman depan publik.</p>
                    </div>

                    <div class="card-body p-4">
                        <!-- Durasi Jam Relatif -->
                        <div class="bgn-field mb-3">
                            <input type="number"
                                   step="0.5"
                                   min="0.5"
                                   max="24"
                                   class="bgn-field-input has-suffix @error('consumption_limit_hours') is-invalid @enderror"
                                   id="consumption_limit_hours"
                                   name="consumption_limit_hours"
                                   value="{{ old('consumption_limit_hours', $label->consumption_limit_hours) }}"
                                   placeholder=" "
                                   required>
                            <label for="consumption_limit_hours" class="bgn-field-label">Maksimal Durasi Aman *</label>
                            <span class="bgn-field-suffix-text">jam</span>
                            @error('consumption_limit_hours')
                                <div class="bgn-field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Rentang Jam (Jam Berapa Sampai Jam Berapa) -->
                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <div class="bgn-field mb-1">
                                    <input type="text"
                                           class="bgn-field-input has-suffix @error('consumption_time_start') is-invalid @enderror"
                                           id="consumption_time_start"
                                           name="consumption_time_start"
                                           value="{{ old('consumption_time_start', $label->consumption_time_start ?? '08:00') }}"
                                           data-flatpickr-time
                                           placeholder=" ">
                                    <label for="consumption_time_start" class="bgn-field-label">Jam Mulai Konsumsi</label>
                                    <span class="bgn-field-suffix-btn text-muted" style="pointer-events: none;">
                                        <i class="fa-regular fa-clock"></i>
                                    </span>
                                </div>
                                <div class="form-text small text-muted ps-1">Contoh: 08:00 WIB</div>
                                @error('consumption_time_start')
                                    <div class="bgn-field-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <div class="bgn-field mb-1">
                                    <input type="text"
                                           class="bgn-field-input has-suffix @error('consumption_time_end') is-invalid @enderror"
                                           id="consumption_time_end"
                                           name="consumption_time_end"
                                           value="{{ old('consumption_time_end', $label->consumption_time_end ?? '12:00') }}"
                                           data-flatpickr-time
                                           placeholder=" ">
                                    <label for="consumption_time_end" class="bgn-field-label">Jam Batas Akhir</label>
                                    <span class="bgn-field-suffix-btn text-muted" style="pointer-events: none;">
                                        <i class="fa-regular fa-clock"></i>
                                    </span>
                                </div>
                                <div class="form-text small text-muted ps-1">Contoh: 12:00 WIB</div>
                                @error('consumption_time_end')
                                    <div class="bgn-field-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kustom Teks Rentang Jam (Opsional) -->
                        <div class="mb-3">
                            <div class="bgn-field mb-1">
                                <input type="text"
                                       class="bgn-field-input @error('consumption_time_range') is-invalid @enderror"
                                       id="consumption_time_range"
                                       name="consumption_time_range"
                                       value="{{ old('consumption_time_range', $label->consumption_time_range) }}"
                                       placeholder=" ">
                                <label for="consumption_time_range" class="bgn-field-label">Kustom Teks Rentang Jam (Opsional)</label>
                            </div>
                            <div class="form-text small text-muted ps-1">Kosongkan untuk otomatis menggunakan format dari jam mulai & selesai di atas.</div>
                            @error('consumption_time_range')
                                <div class="bgn-field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Real-time Live Preview Callout -->
                        <div class="consumption-limit-alert p-3">
                            <div class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-circle-exclamation mt-1 text-warning"></i>
                                <div class="small w-100">
                                    <strong class="d-block mb-1 text-dark">Tampilan pada Halaman Publik (Tampilan Awal):</strong>
                                    <div class="p-2 rounded bg-white border small">
                                        <div class="text-muted fw-semibold">
                                            Makanan harap dikonsumsi maksimal <span id="previewLimitHours">{{ $label->consumption_limit_hours }}</span> jam setelah diterima
                                        </div>
                                        <div class="fw-bold text-dark fs-6 mt-1" id="previewTimeRange">
                                            {{ $label->formatted_consumption_time_range }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex flex-column gap-2">
                            <button type="submit" name="action" value="publish" id="btnSubmitPublish" class="btn btn-bgn-primary py-2 fw-semibold rounded-pill shadow-sm">
                                <i class="fa-solid fa-circle-check me-1" id="publishBtnIcon"></i> <span id="publishBtnText">Simpan & Publikasikan</span>
                            </button>
                            <button type="submit" name="action" value="draft" class="btn btn-outline-secondary py-2 fw-semibold rounded-pill">
                                <i class="fa-solid fa-file-pen me-1"></i> Simpan sebagai Draft
                            </button>
                            <a href="{{ route('admin.labels.show', $label) }}" class="btn btn-light py-2 text-muted rounded-pill">
                                Batal
                            </a>
                        </div>
                        <div class="mt-3 p-2 rounded-3 bg-light text-center small text-muted" id="statusHintBox">
                            <i class="fa-solid fa-circle-info text-success me-1" id="statusHintIcon"></i>
                            <span id="statusHintText">Tanggal hari ini: label akan <strong>langsung dipublikasikan</strong>.</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('menuContainer');
    const btnAdd = document.getElementById('btnAddMenu');
    const btnAddBottom = document.getElementById('btnAddMenuBottom');
    const hoursInput = document.getElementById('consumption_limit_hours');
    const previewHours = document.getElementById('previewLimitHours');

    const timeStartInput = document.getElementById('consumption_time_start');
    const timeEndInput = document.getElementById('consumption_time_end');
    const timeRangeInput = document.getElementById('consumption_time_range');
    const previewTimeRange = document.getElementById('previewTimeRange');

    function updateTimePreview() {
        if (!previewTimeRange) return;
        const custom = timeRangeInput ? timeRangeInput.value.trim() : '';
        if (custom) {
            previewTimeRange.textContent = custom;
            return;
        }

        const start = timeStartInput ? timeStartInput.value : '';
        const end = timeEndInput ? timeEndInput.value : '';
        if (start && end) {
            const startFmt = start.replace(':', '.');
            const endFmt = end.replace(':', '.');
            previewTimeRange.textContent = `Pukul : ${startFmt} – ${endFmt} WIB`;
        } else {
            const h = parseFloat(hoursInput ? hoursInput.value : 4) || 4;
            const endH = Math.min(24, Math.round(8 + h));
            const endStr = endH < 10 ? `0${endH}.00` : `${endH}.00`;
            previewTimeRange.textContent = `Pukul : 08.00 – ${endStr} WIB`;
        }
    }

    if (hoursInput) {
        hoursInput.addEventListener('input', function() {
            if (previewHours) previewHours.textContent = this.value || '0';
            updateTimePreview();
        });
    }
    if (timeStartInput) timeStartInput.addEventListener('input', updateTimePreview);
    if (timeEndInput) timeEndInput.addEventListener('input', updateTimePreview);
    if (timeRangeInput) timeRangeInput.addEventListener('input', updateTimePreview);
    updateTimePreview();

    function renumberMenuRows() {
        const rows = container.querySelectorAll('.menu-row');
        rows.forEach((row, index) => {
            const badge = row.querySelector('.menu-number');
            if (badge) {
                badge.textContent = index + 1;
            }
        });
    }

    function addMenuRow(value = '') {
        const row = document.createElement('div');
        row.className = 'menu-row d-flex align-items-center gap-2';
        row.innerHTML = `
            <span class="badge bg-light text-secondary border menu-number" style="width: 28px;">#</span>
            <input type="text"
                   name="menus[]"
                   class="form-control menu-input"
                   value="${value}"
                   placeholder="Nama menu makanan"
                   required>
            <button type="button" class="btn btn-outline-danger btn-sm rounded-3 btn-remove-menu" title="Hapus Menu Ini">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        `;
        container.appendChild(row);
        renumberMenuRows();

        const input = row.querySelector('.menu-input');
        if (input) input.focus();
    }

    btnAdd.addEventListener('click', () => addMenuRow());
    btnAddBottom.addEventListener('click', () => addMenuRow());

    container.addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.btn-remove-menu');
        if (removeBtn) {
            const rows = container.querySelectorAll('.menu-row');
            if (rows.length <= 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pemberitahuan',
                    text: 'Setidaknya harus ada minimal 1 baris menu makanan.',
                    confirmButtonColor: '#198754'
                });
                return;
            }
            const row = removeBtn.closest('.menu-row');
            if (row) {
                const inputVal = row.querySelector('.menu-input')?.value.trim();
                if (inputVal) {
                    Swal.fire({
                        title: 'Hapus Menu?',
                        text: `Apakah Anda yakin ingin menghapus "${inputVal}" dari daftar menu?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            row.remove();
                            renumberMenuRows();
                        }
                    });
                } else {
                    row.remove();
                    renumberMenuRows();
                }
            }
        }
    });

    // Form dirty state checker
    let isFormDirty = false;
    const form = document.getElementById('foodLabelForm');
    form.addEventListener('change', () => isFormDirty = true);
    form.addEventListener('input', () => isFormDirty = true);

    // Intercept submit button click to preserve chosen action
    let lastSubmitAction = 'publish';
    document.querySelectorAll('#foodLabelForm button[type="submit"]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            lastSubmitAction = this.value || 'publish';
        });
    });

    // Form submit confirmation via SweetAlert2
    form.addEventListener('submit', function(e) {
        if (form.dataset.confirmed === 'true') {
            return;
        }
        e.preventDefault();

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const hiddenDate = document.querySelector('input[name="menu_date"][type="hidden"]') || menuDateEl;
        const dateVal = (hiddenDate ? hiddenDate.value : (menuDateEl ? menuDateEl.value : '')).trim();
        const todayStr = '{{ \Carbon\Carbon::today()->format('Y-m-d') }}';
        const isFuture = dateVal > todayStr;

        let title = 'Konfirmasi Perubahan Label';
        let text = 'Apakah Anda yakin ingin menyimpan perubahan label makanan ini?';
        let icon = 'question';
        let confirmText = 'Ya, Simpan Perubahan';
        let confirmColor = '#0b2853';

        if (lastSubmitAction === 'draft') {
            title = 'Simpan sebagai Draft?';
            text = 'Label makanan ini akan diubah statusnya menjadi draft dan belum dapat diakses oleh masyarakat umum.';
            confirmText = 'Ya, Simpan Draft';
            confirmColor = '#6c757d';
            icon = 'info';
        } else if (isFuture) {
            title = 'Simpan & Jadwalkan Label?';
            text = 'Label makanan ini akan disimpan dengan status Terjadwal dan otomatis diterbitkan pada tanggal menu (' + dateVal + ').';
            confirmText = 'Ya, Jadwalkan';
            confirmColor = '#0b2853';
            icon = 'question';
        } else {
            title = 'Simpan & Publikasikan Label?';
            text = 'Label makanan ini akan dipublikasikan dan langsung dapat diakses oleh masyarakat umum.';
            confirmText = 'Ya, Publikasikan';
            confirmColor = '#198754';
            icon = 'question';
        }

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmText,
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(function(result) {
            if (result.isConfirmed) {
                let hiddenAction = form.querySelector('input[type="hidden"][name="action"]');
                if (!hiddenAction) {
                    hiddenAction = document.createElement('input');
                    hiddenAction.type = 'hidden';
                    hiddenAction.name = 'action';
                    form.appendChild(hiddenAction);
                }
                hiddenAction.value = lastSubmitAction;

                form.dataset.confirmed = 'true';
                isFormDirty = false;
                form.submit();
            }
        });
    });

    // Checkbox Hapus Foto Konfirmasi SweetAlert2
    const removeImageCheckbox = document.getElementById('remove_image');
    if (removeImageCheckbox) {
        removeImageCheckbox.addEventListener('change', function() {
            if (this.checked) {
                Swal.fire({
                    title: 'Tandai Hapus Foto?',
                    text: 'Foto makanan saat ini akan dihapus permanen saat Anda menyimpan perubahan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Tandai Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then(function(result) {
                    if (!result.isConfirmed) {
                        removeImageCheckbox.checked = false;
                    }
                });
            }
        });
    }

    // Live Image Preview & Client-Side WebP Compression Handling
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const compressingIndicator = document.getElementById('imageCompressingIndicator');
    const compressionStatsBadges = document.getElementById('compressionStatsBadges');
    const previewImg = document.getElementById('imagePreview');
    const btnRemovePreview = document.getElementById('btnRemovePreview');

    // Helper: Client-Side Image Compression and WebP Conversion via HTML5 Canvas
    function compressImageFileToWebP(file, maxDimension = 1200, quality = 0.82) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    let width = img.naturalWidth || img.width;
                    let height = img.naturalHeight || img.height;

                    if (width > maxDimension || height > maxDimension) {
                        if (width >= height) {
                            height = Math.round((height * maxDimension) / width);
                            width = maxDimension;
                        } else {
                            width = Math.round((width * maxDimension) / height);
                            height = maxDimension;
                        }
                    }

                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.imageSmoothingEnabled = true;
                    ctx.imageSmoothingQuality = 'high';
                    ctx.drawImage(img, 0, 0, width, height);

                    canvas.toBlob((blob) => {
                        if (!blob) {
                            reject(new Error('Gagal mengompresi gambar di kanvas'));
                            return;
                        }

                        const baseName = file.name.replace(/\.[^/.]+$/, "");
                        const isWebp = blob.type === 'image/webp';
                        const ext = isWebp ? 'webp' : 'jpg';
                        const finalMime = isWebp ? 'image/webp' : 'image/jpeg';
                        const compressedFile = new File([blob], `${baseName}.${ext}`, {
                            type: finalMime,
                            lastModified: Date.now()
                        });

                        resolve({
                            file: compressedFile,
                            previewUrl: URL.createObjectURL(blob),
                            originalSize: file.size,
                            compressedSize: blob.size,
                            width: width,
                            height: height,
                            format: isWebp ? 'WEBP' : 'JPEG'
                        });
                    }, 'image/webp', quality);
                };
                img.onerror = () => reject(new Error('Gagal memuat gambar'));
                img.src = e.target.result;
            };
            reader.onerror = () => reject(new Error('Gagal membaca file gambar'));
            reader.readAsDataURL(file);
        });
    }

    if (imageInput && previewContainer && previewImg) {
        imageInput.addEventListener('change', async function() {
            const file = this.files[0];
            if (!file) {
                previewContainer.classList.add('d-none');
                if (compressingIndicator) compressingIndicator.classList.add('d-none');
                return;
            }

            if (!file.type.startsWith('image/')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format Tidak Sesuai',
                    text: 'Silakan pilih file gambar yang valid (JPG, JPEG, PNG, WEBP).',
                    confirmButtonColor: '#0b2853'
                });
                this.value = '';
                previewContainer.classList.add('d-none');
                if (compressingIndicator) compressingIndicator.classList.add('d-none');
                return;
            }

            if (file.size > 15 * 1024 * 1024) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ukuran Terlalu Besar',
                    text: 'Ukuran file gambar asli maksimal 15 MB.',
                    confirmButtonColor: '#c48b0f'
                });
                this.value = '';
                previewContainer.classList.add('d-none');
                if (compressingIndicator) compressingIndicator.classList.add('d-none');
                return;
            }

            // Uncheck remove_image if user chooses a new image
            if (removeImageCheckbox && removeImageCheckbox.checked) {
                removeImageCheckbox.checked = false;
            }

            if (compressingIndicator) compressingIndicator.classList.remove('d-none');
            previewContainer.classList.add('d-none');

            try {
                const result = await compressImageFileToWebP(file, 1200, 0.82);

                if (window.DataTransfer) {
                    const dt = new DataTransfer();
                    dt.items.add(result.file);
                    imageInput.files = dt.files;
                }

                const origKB = Math.round(result.originalSize / 1024);
                const compKB = Math.round(result.compressedSize / 1024);
                const savings = result.originalSize > result.compressedSize
                    ? Math.round((1 - (result.compressedSize / result.originalSize)) * 100)
                    : 0;

                if (compressionStatsBadges) {
                    compressionStatsBadges.innerHTML = `
                        <span class="badge bg-secondary-subtle text-secondary border small">Asli: ${origKB > 1024 ? (origKB / 1024).toFixed(1) + ' MB' : origKB + ' KB'}</span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle small fw-bold">
                            <i class="fa-solid fa-arrow-trend-down me-1"></i>WebP: ${compKB} KB ${savings > 0 ? '(-' + savings + '%)' : ''}
                        </span>
                        <span class="badge bg-primary-subtle text-primary border small">${result.width}x${result.height} px</span>
                    `;
                }

                previewImg.src = result.previewUrl;
                if (compressingIndicator) compressingIndicator.classList.add('d-none');
                previewContainer.classList.remove('d-none');
            } catch (err) {
                console.warn('Kompresi browser gagal, menggunakan file asli untuk diproses server:', err);
                if (compressingIndicator) compressingIndicator.classList.add('d-none');
                const reader = new FileReader();
                reader.onload = function(evt) {
                    previewImg.src = evt.target.result;
                    if (compressionStatsBadges) {
                        compressionStatsBadges.innerHTML = `
                            <span class="badge bg-info-subtle text-info border small"><i class="fa-solid fa-gear me-1"></i>Akan dikompresi oleh server</span>
                        `;
                    }
                    previewContainer.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        });

        if (btnRemovePreview) {
            btnRemovePreview.addEventListener('click', function() {
                Swal.fire({
                    title: 'Batalkan Foto Baru?',
                    text: 'Apakah Anda yakin ingin membatalkan pemilihan foto baru ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Batalkan',
                    cancelButtonText: 'Kembali',
                    reverseButtons: true
                }).then(function(result) {
                    if (result.isConfirmed) {
                        imageInput.value = '';
                        previewContainer.classList.add('d-none');
                        if (compressingIndicator) compressingIndicator.classList.add('d-none');
                        previewImg.src = '#';
                    }
                });
            });
        }
    }

    // Dynamic Schedule Status Hint
    const menuDateEl = document.getElementById('menu_date');
    const btnTextEl = document.getElementById('publishBtnText');
    const btnIconEl = document.getElementById('publishBtnIcon');
    const hintTextEl = document.getElementById('statusHintText');
    const hintIconEl = document.getElementById('statusHintIcon');

    function updatePublishStatusHint() {
        if (!menuDateEl || !btnTextEl || !hintTextEl) return;
        const hiddenDate = document.querySelector('input[name="menu_date"][type="hidden"]') || menuDateEl;
        const dateVal = (hiddenDate.value || menuDateEl.value || '').trim();
        if (!dateVal) return;

        const todayStr = '{{ \Carbon\Carbon::today()->format('Y-m-d') }}';
        if (dateVal > todayStr) {
            btnTextEl.textContent = 'Simpan & Jadwalkan';
            if (btnIconEl) {
                btnIconEl.className = 'fa-solid fa-calendar-check me-1 text-warning';
            }
            if (hintIconEl) {
                hintIconEl.className = 'fa-solid fa-calendar-check text-info me-1';
            }
            hintTextEl.innerHTML = 'Tanggal masa depan: status otomatis <strong class="text-info">Terjadwal</strong> dan akan terbit otomatis pada hari H.';
        } else {
            btnTextEl.textContent = 'Simpan & Publikasikan';
            if (btnIconEl) {
                btnIconEl.className = 'fa-solid fa-circle-check me-1';
            }
            if (hintIconEl) {
                hintIconEl.className = 'fa-solid fa-circle-info text-success me-1';
            }
            hintTextEl.innerHTML = 'Tanggal hari ini/lampau: label akan <strong class="text-success">Langsung Dipublikasikan</strong>.';
        }
    }

    if (menuDateEl) {
        menuDateEl.addEventListener('change', updatePublishStatusHint);
        menuDateEl.addEventListener('input', updatePublishStatusHint);
        setInterval(updatePublishStatusHint, 800);
        updatePublishStatusHint();
    }

    window.addEventListener('beforeunload', function(e) {
        if (isFormDirty) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
});
</script>
@endpush
