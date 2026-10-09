@extends('layouts.admin')

@section('title', 'Edit Label Makanan')
@section('page_title', 'Edit Label: ' . $label->title)

@section('content')
<div class="container-fluid p-0">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.labels.index') }}" class="text-decoration-none text-muted">Kelola Label</a></li>
                    <li class="breadcrumb-item active text-success fw-semibold">Edit Label</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center gap-2">
                <h4 class="fw-bold text-dark mb-0">Edit Label Makanan</h4>
                <span class="badge {{ $label->status_badge_class }} rounded-pill px-2 py-1">
                    {{ $label->status_label }}
                </span>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.labels.preview', $label) }}" target="_blank" class="btn btn-outline-info btn-sm rounded-pill px-3">
                <i class="fa-solid fa-magnifying-glass me-1"></i> Pratinjau
            </a>
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
                                <label for="menu_date" class="form-label small fw-semibold">Tanggal Menu <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="fa-regular fa-calendar"></i></span>
                                    <input type="date"
                                           class="form-control @error('menu_date') is-invalid @enderror"
                                           id="menu_date"
                                           name="menu_date"
                                           value="{{ old('menu_date', $label->menu_date->format('Y-m-d')) }}"
                                           required>
                                </div>
                                @error('menu_date')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="title" class="form-label small fw-semibold">Nama Paket / Judul Label <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ old('title', $label->title) }}"
                                       placeholder="Contoh: Paket Menu Sehat Siang"
                                       required>
                                @error('title')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label small fw-semibold">Keterangan Tambahan (Opsional)</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="2"
                                          placeholder="Catatan kebersihan, rekomendasi penyajian, atau keterangan bahan...">{{ old('description', $label->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
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
                            <div class="form-text small text-muted mt-1">
                                Format: JPG, JPEG, PNG, WEBP (Maksimal 5 MB). Mengunggah foto baru akan mengganti foto yang lama.
                            </div>
                        </div>

                        <!-- Live Preview Area -->
                        <div id="imagePreviewContainer" class="d-none mt-3 p-3 bg-light rounded-3 border text-center">
                            <div class="small fw-semibold text-muted mb-2">Pratinjau Foto Baru (Otomatis Dikonversi ke WebP):</div>
                            <div class="position-relative d-inline-block">
                                <img id="imagePreview" src="#" alt="Pratinjau Foto Baru" class="img-fluid rounded-3 shadow-sm border" style="max-height: 220px; object-fit: cover;">
                                <button type="button" id="btnRemovePreview" class="btn btn-sm btn-danger rounded-circle position-absolute top-0 end-0 m-1 shadow-sm" title="Batalkan Pilihan Foto">
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
                            <div>
                                <label for="energy" class="form-label small fw-semibold">Energi Total <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number"
                                           step="0.1"
                                           min="0"
                                           class="form-control @error('energy') is-invalid @enderror"
                                           id="energy"
                                           name="energy"
                                           value="{{ old('energy', $label->energy) }}"
                                           placeholder="0"
                                           required>
                                    <span class="input-group-text bg-light text-muted fw-bold">kkal</span>
                                </div>
                                @error('energy')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Protein -->
                            <div>
                                <label for="protein" class="form-label small fw-semibold">Protein <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number"
                                           step="0.1"
                                           min="0"
                                           class="form-control @error('protein') is-invalid @enderror"
                                           id="protein"
                                           name="protein"
                                           value="{{ old('protein', $label->protein) }}"
                                           placeholder="0"
                                           required>
                                    <span class="input-group-text bg-light text-muted fw-bold">gram</span>
                                </div>
                                @error('protein')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Lemak -->
                            <div>
                                <label for="fat" class="form-label small fw-semibold">Lemak <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number"
                                           step="0.1"
                                           min="0"
                                           class="form-control @error('fat') is-invalid @enderror"
                                           id="fat"
                                           name="fat"
                                           value="{{ old('fat', $label->fat) }}"
                                           placeholder="0"
                                           required>
                                    <span class="input-group-text bg-light text-muted fw-bold">gram</span>
                                </div>
                                @error('fat')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Karbohidrat -->
                            <div>
                                <label for="carbohydrate" class="form-label small fw-semibold">Karbohidrat <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number"
                                           step="0.1"
                                           min="0"
                                           class="form-control @error('carbohydrate') is-invalid @enderror"
                                           id="carbohydrate"
                                           name="carbohydrate"
                                           value="{{ old('carbohydrate', $label->carbohydrate) }}"
                                           placeholder="0"
                                           required>
                                    <span class="input-group-text bg-light text-muted fw-bold">gram</span>
                                </div>
                                @error('carbohydrate')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Serat -->
                            <div>
                                <label for="fiber" class="form-label small fw-semibold">Serat Pangan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number"
                                           step="0.1"
                                           min="0"
                                           class="form-control @error('fiber') is-invalid @enderror"
                                           id="fiber"
                                           name="fiber"
                                           value="{{ old('fiber', $label->fiber) }}"
                                           placeholder="0"
                                           required>
                                    <span class="input-group-text bg-light text-muted fw-bold">gram</span>
                                </div>
                                @error('fiber')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
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
                                <i class="fa-solid fa-hourglass-half"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Batas Akhir Konsumsi</h5>
                        </div>
                        <p class="text-muted small mt-1 mb-0">Ketentuan batas aman konsumsi relatif setelah makanan diantarkan.</p>
                    </div>

                    <div class="card-body p-4">
                        <label for="consumption_limit_hours" class="form-label small fw-semibold">Maksimal Durasi Aman <span class="text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <input type="number"
                                   step="0.5"
                                   min="0.5"
                                   max="24"
                                   class="form-control @error('consumption_limit_hours') is-invalid @enderror"
                                   id="consumption_limit_hours"
                                   name="consumption_limit_hours"
                                   value="{{ old('consumption_limit_hours', $label->consumption_limit_hours) }}"
                                   required>
                            <span class="input-group-text bg-light text-dark fw-bold">jam</span>
                            <span class="input-group-text bg-light text-muted">setelah pengantaran</span>
                        </div>
                        @error('consumption_limit_hours')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        <div class="consumption-limit-alert mt-3 p-3">
                            <div class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-circle-exclamation mt-1"></i>
                                <div class="small">
                                    <strong>Tampilan pada Label Publik:</strong><br>
                                    "Batas akhir konsumsi: maksimal <span id="previewLimitHours">{{ $label->consumption_limit_hours }}</span> jam setelah pengantaran."
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex flex-column gap-2">
                            <button type="submit" name="action" value="publish" class="btn btn-success py-2 fw-semibold rounded-pill shadow-sm">
                                <i class="fa-solid fa-circle-check me-1"></i> Simpan & Publikasikan
                            </button>
                            <button type="submit" name="action" value="draft" class="btn btn-outline-secondary py-2 fw-semibold rounded-pill">
                                <i class="fa-solid fa-file-pen me-1"></i> Simpan sebagai Draft
                            </button>
                            <a href="{{ route('admin.labels.show', $label) }}" class="btn btn-light py-2 text-muted rounded-pill">
                                Batal
                            </a>
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

    if (hoursInput && previewHours) {
        hoursInput.addEventListener('input', function() {
            previewHours.textContent = this.value || '0';
        });
    }

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
                row.remove();
                renumberMenuRows();
            }
        }
    });

    // Form dirty state checker
    let isFormDirty = false;
    const form = document.getElementById('foodLabelForm');
    form.addEventListener('change', () => isFormDirty = true);
    form.addEventListener('input', () => isFormDirty = true);
    form.addEventListener('submit', () => isFormDirty = false);

    // Live Image Preview Handling
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const previewImg = document.getElementById('imagePreview');
    const btnRemovePreview = document.getElementById('btnRemovePreview');

    if (imageInput && previewContainer && previewImg) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                if (!file.type.startsWith('image/')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Tidak Sesuai',
                        text: 'Silakan pilih file gambar yang valid (JPG, JPEG, PNG, WEBP).',
                        confirmButtonColor: '#198754'
                    });
                    this.value = '';
                    previewContainer.classList.add('d-none');
                    return;
                }
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ukuran Terlalu Besar',
                        text: 'Ukuran file gambar maksimal 5 MB.',
                        confirmButtonColor: '#198754'
                    });
                    this.value = '';
                    previewContainer.classList.add('d-none');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(evt) {
                    previewImg.src = evt.target.result;
                    previewContainer.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('d-none');
            }
        });

        if (btnRemovePreview) {
            btnRemovePreview.addEventListener('click', function() {
                imageInput.value = '';
                previewContainer.classList.add('d-none');
                previewImg.src = '#';
            });
        }
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
