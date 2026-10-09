@extends('layouts.admin')

@section('title', 'Kelola Label Makanan')
@section('page_title', 'Manajemen Label Makanan')

@section('content')
<div class="container-fluid p-0">

    <!-- Header Actions -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Daftar Label Makanan</h4>
            <p class="text-muted small mb-0">Kelola informasi menu, status publikasi, dan analisis gizi pangan masyarakat.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.labels.export', request()->query()) }}" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm btn-sm">
                <i class="fa-solid fa-file-csv me-1 text-success"></i> Ekspor CSV
            </a>
            <a href="{{ route('admin.labels.create') }}" class="btn btn-success rounded-pill px-3 shadow-sm btn-sm fw-medium">
                <i class="fa-solid fa-plus-circle me-1"></i> Tambah Label Baru
            </a>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3 p-md-4">
            <!-- Status Tabs -->
            <ul class="nav nav-pills mb-3 gap-2 flex-wrap">
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 py-1 small {{ $currentStatus === 'all' ? 'active bg-success' : 'text-muted' }}" href="{{ route('admin.labels.index', array_merge(request()->except('status', 'page'), ['status' => 'all'])) }}">
                        Semua ({{ $counts['all'] }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 py-1 small {{ $currentStatus === 'published' ? 'active bg-success' : 'text-muted' }}" href="{{ route('admin.labels.index', array_merge(request()->except('status', 'page'), ['status' => 'published'])) }}">
                        Dipublikasikan ({{ $counts['published'] }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 py-1 small {{ $currentStatus === 'draft' ? 'active bg-warning text-dark' : 'text-muted' }}" href="{{ route('admin.labels.index', array_merge(request()->except('status', 'page'), ['status' => 'draft'])) }}">
                        Draft ({{ $counts['draft'] }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 py-1 small {{ $currentStatus === 'scheduled' ? 'active bg-info text-dark' : 'text-muted' }}" href="{{ route('admin.labels.index', array_merge(request()->except('status', 'page'), ['status' => 'scheduled'])) }}">
                        Terjadwal ({{ $counts['scheduled'] }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 py-1 small {{ $currentStatus === 'archived' ? 'active bg-secondary' : 'text-muted' }}" href="{{ route('admin.labels.index', array_merge(request()->except('status', 'page'), ['status' => 'archived'])) }}">
                        Diarsipkan ({{ $counts['archived'] }})
                    </a>
                </li>
            </ul>

            <!-- Search and Filter Form -->
            <form action="{{ route('admin.labels.index') }}" method="GET" class="row g-2 align-items-center">
                <input type="hidden" name="status" value="{{ $currentStatus }}">

                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama menu, judul, atau paket..." value="{{ $search }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-regular fa-calendar"></i></span>
                        <input type="date" name="date" class="form-control border-start-0" value="{{ $date }}" title="Filter Tanggal Spesifik">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="sort_by" class="form-select form-select-sm">
                        <option value="menu_date" {{ $sortBy === 'menu_date' ? 'selected' : '' }}>Urut: Tanggal Menu</option>
                        <option value="created_at" {{ $sortBy === 'created_at' ? 'selected' : '' }}>Urut: Waktu Pembuatan</option>
                        <option value="title" {{ $sortBy === 'title' ? 'selected' : '' }}>Urut: Judul Label</option>
                        <option value="energy" {{ $sortBy === 'energy' ? 'selected' : '' }}>Urut: Kandungan Energi</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-success rounded-pill flex-grow-1">
                        Terapkan
                    </button>
                    @if(!empty($search) || !empty($date) || $currentStatus !== 'all')
                        <a href="{{ route('admin.labels.index') }}" class="btn btn-sm btn-light border rounded-pill" title="Reset Filter">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            @if($labels->isEmpty())
                <div class="p-5 text-center text-muted">
                    <i class="fa-solid fa-utensils fs-1 mb-3 opacity-25"></i>
                    <h5 class="fw-bold text-dark mb-1">Tidak ada label makanan ditemukan</h5>
                    <p class="small mb-3">Tidak ada data label yang sesuai dengan kriteria pencarian atau status yang dipilih.</p>
                    <a href="{{ route('admin.labels.create') }}" class="btn btn-success btn-sm rounded-pill px-4">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Label Baru
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small text-muted text-uppercase">
                            <tr>
                                <th class="ps-4">Informasi Label & Tanggal</th>
                                <th>Kandungan Gizi Inti</th>
                                <th>Daftar Menu</th>
                                <th>Batas Konsumsi</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($labels as $label)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($label->image)
                                                <img src="{{ $label->image_url }}" alt="{{ $label->title }}" class="rounded-3 border object-fit-cover flex-shrink-0" style="width: 46px; height: 46px;">
                                            @else
                                                <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center text-muted flex-shrink-0" style="width: 46px; height: 46px;">
                                                    <i class="fa-solid fa-utensils opacity-50"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('admin.labels.show', $label) }}" class="fw-bold text-dark text-decoration-none d-block mb-1">
                                                    {{ $label->title }}
                                                </a>
                                                <div class="small text-muted d-flex align-items-center gap-2 flex-wrap">
                                                    <span><i class="fa-regular fa-calendar-check text-success me-1"></i> {{ $label->menu_date->isoFormat('D MMMM Y') }}</span>
                                                    @if($label->image)
                                                        <span class="badge bg-success bg-opacity-10 text-success border-0" style="font-size: 0.7rem;">
                                                            <i class="fa-solid fa-camera me-1"></i>Foto WebP
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small lh-sm">
                                            <div class="fw-bold text-success">{{ number_format($label->energy, 0, ',', '.') }} kkal</div>
                                            <span class="text-muted" style="font-size: 0.8rem;">
                                                P: {{ number_format($label->protein, 1, ',', '.') }}g &bull;
                                                L: {{ number_format($label->fat, 1, ',', '.') }}g &bull;
                                                K: {{ number_format($label->carbohydrate, 1, ',', '.') }}g
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <i class="fa-solid fa-list-check me-1 text-muted"></i> {{ $label->menus->count() }} Menu
                                        </span>
                                    </td>
                                    <td>
                                        <span class="small text-muted">
                                            <i class="fa-regular fa-clock me-1 text-warning"></i> Maks. {{ $label->consumption_limit_hours }} Jam
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $label->status_badge_class }} rounded-pill px-2 py-1">
                                            {{ $label->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border rounded-pill px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical px-1"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                <li>
                                                    <a class="dropdown-item small" href="{{ route('admin.labels.show', $label) }}">
                                                        <i class="fa-solid fa-eye me-2 text-muted"></i> Detail Lengkap
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item small" href="{{ route('admin.labels.edit', $label) }}">
                                                        <i class="fa-solid fa-pen-to-square me-2 text-primary"></i> Edit Label
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item small" href="{{ route('admin.labels.preview', $label) }}" target="_blank">
                                                        <i class="fa-solid fa-magnifying-glass me-2 text-info"></i> Pratinjau Publik
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>

                                                <!-- Duplicate Action -->
                                                <li>
                                                    <form action="{{ route('admin.labels.duplicate', $label) }}" method="POST"
                                                          data-confirm="Duplikasi label ini sebagai draft baru?"
                                                          data-confirm-icon="question"
                                                          data-confirm-btn="Ya, Duplikasi"
                                                          data-confirm-color="#198754">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item small">
                                                            <i class="fa-solid fa-copy me-2 text-success"></i> Duplikasi Label
                                                        </button>
                                                    </form>
                                                </li>

                                                <!-- Status Toggles -->
                                                @if($label->status !== 'published')
                                                    <li>
                                                        <form action="{{ route('admin.labels.publish', $label) }}" method="POST"
                                                              data-confirm="Publikasikan label makanan ini agar dapat dilihat oleh masyarakat umum?"
                                                              data-confirm-icon="question"
                                                              data-confirm-btn="Ya, Publikasikan"
                                                              data-confirm-color="#198754">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item small text-success">
                                                                <i class="fa-solid fa-circle-check me-2"></i> Publikasikan
                                                            </button>
                                                        </form>
                                                    </li>
                                                @else
                                                    <li>
                                                        <form action="{{ route('admin.labels.unpublish', $label) }}" method="POST"
                                                              data-confirm="Tarik kembali publikasi label ini? Label akan kembali berstatus draft."
                                                              data-confirm-icon="warning"
                                                              data-confirm-btn="Ya, Tarik Publikasi"
                                                              data-confirm-color="#ffc107">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item small text-warning">
                                                                <i class="fa-solid fa-arrow-rotate-left me-2"></i> Tarik Publikasi (Draft)
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif

                                                @if($label->status !== 'archived')
                                                    <li>
                                                        <form action="{{ route('admin.labels.archive', $label) }}" method="POST"
                                                              data-confirm="Arsipkan label ini? Data tidak akan tampil pada daftar publik aktif."
                                                              data-confirm-icon="info"
                                                              data-confirm-btn="Ya, Arsipkan"
                                                              data-confirm-color="#6c757d">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item small text-secondary">
                                                                <i class="fa-solid fa-box-archive me-2"></i> Arsipkan
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif

                                                <li><hr class="dropdown-divider"></li>

                                                <!-- Delete Action -->
                                                <li>
                                                    <form action="{{ route('admin.labels.destroy', $label) }}" method="POST"
                                                          data-confirm="Apakah Anda yakin ingin menghapus label ini? Data akan dipindahkan ke tempat sampah (soft delete)."
                                                          data-confirm-icon="warning"
                                                          data-confirm-btn="Ya, Hapus"
                                                          data-confirm-color="#dc3545">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item small text-danger">
                                                            <i class="fa-solid fa-trash me-2"></i> Hapus Label
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                <div class="p-3 border-top d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <small class="text-muted">
                        Menampilkan <strong>{{ $labels->firstItem() ?? 0 }}</strong> - <strong>{{ $labels->lastItem() ?? 0 }}</strong> dari <strong>{{ $labels->total() }}</strong> label
                    </small>
                    <div>
                        {{ $labels->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
