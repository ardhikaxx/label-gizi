@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Ringkasan Sistem & Statistik')

@section('content')
<div class="container-fluid p-0">

    <!-- Welcome & Quick Action Banner -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-brand-soft overflow-hidden">
        <div class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <h4 class="fw-bold text-success mb-1">Halo, {{ Auth::user()->name }}! 👋</h4>
                <p class="text-muted mb-0 small">
                    Selamat datang di panel kelola sistem informasi label makanan bergizi. Pantau status menu, zat gizi, dan transparansi informasi publik.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.labels.create') }}" class="btn btn-success rounded-pill px-4 shadow-sm fw-medium">
                    <i class="fa-solid fa-plus-circle me-1"></i> Tambah Label Baru
                </a>
                <a href="{{ route('admin.labels.index') }}" class="btn btn-outline-success rounded-pill px-3 fw-medium">
                    <i class="fa-solid fa-tags me-1"></i> Kelola Label
                </a>
            </div>
        </div>
    </div>

    <!-- Stat Cards Row (Clickable & Filter-Linked) -->
    <div class="row g-3 mb-4">
        <!-- Total Labels -->
        <div class="col-sm-6 col-xl-2">
            <a href="{{ route('admin.labels.index') }}" class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">Total Label</span>
                    <div class="stat-icon-wrapper bg-primary bg-opacity-10 text-primary">
                        <i class="fa-solid fa-utensils"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1">{{ number_format($stats['total_labels']) }}</h3>
                <small class="text-muted d-flex align-items-center gap-1">
                    <i class="fa-solid fa-arrow-right small text-primary"></i> Semua label
                </small>
            </a>
        </div>

        <!-- Published Labels -->
        <div class="col-sm-6 col-xl-2">
            <a href="{{ route('admin.labels.index', ['status' => 'published']) }}" class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">Dipublikasikan</span>
                    <div class="stat-icon-wrapper bg-success bg-opacity-10 text-success">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-success mb-1">{{ number_format($stats['published_labels']) }}</h3>
                <small class="text-muted d-flex align-items-center gap-1">
                    <i class="fa-solid fa-eye small text-success"></i> Tampil ke publik
                </small>
            </a>
        </div>

        <!-- Draft Labels -->
        <div class="col-sm-6 col-xl-2">
            <a href="{{ route('admin.labels.index', ['status' => 'draft']) }}" class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">Draft Menu</span>
                    <div class="stat-icon-wrapper bg-warning bg-opacity-10 text-warning">
                        <i class="fa-solid fa-file-pen"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1">{{ number_format($stats['draft_labels']) }}</h3>
                <small class="text-muted d-flex align-items-center gap-1">
                    <i class="fa-solid fa-clock-rotate-left small text-warning"></i> Perlu verifikasi
                </small>
            </a>
        </div>

        <!-- Scheduled Labels -->
        <div class="col-sm-6 col-xl-2">
            <a href="{{ route('admin.labels.index', ['status' => 'scheduled']) }}" class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">Terjadwal</span>
                    <div class="stat-icon-wrapper bg-info bg-opacity-10 text-info">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1">{{ number_format($stats['scheduled_labels']) }}</h3>
                <small class="text-muted d-flex align-items-center gap-1">
                    <i class="fa-solid fa-hourglass-start small text-info"></i> Rencana publikasi
                </small>
            </a>
        </div>

        <!-- Archived Labels -->
        <div class="col-sm-6 col-xl-2">
            <a href="{{ route('admin.labels.index', ['status' => 'archived']) }}" class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">Diarsipkan</span>
                    <div class="stat-icon-wrapper bg-secondary bg-opacity-10 text-secondary">
                        <i class="fa-solid fa-box-archive"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-secondary mb-1">{{ number_format($stats['archived_labels']) }}</h3>
                <small class="text-muted d-flex align-items-center gap-1">
                    <i class="fa-solid fa-archive small text-secondary"></i> Arsip historis
                </small>
            </a>
        </div>

        <!-- Admin Users -->
        <div class="col-sm-6 col-xl-2">
            <a href="{{ route('admin.users.index') }}" class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">Total Admin</span>
                    <div class="stat-icon-wrapper bg-dark bg-opacity-10 text-dark">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1">{{ number_format($stats['total_users']) }}</h3>
                <small class="text-muted d-flex align-items-center gap-1">
                    <i class="fa-solid fa-user-shield small text-dark"></i> Pengelola aktif
                </small>
            </a>
        </div>
    </div>

    <!-- Charts & Today's Menu Row -->
    <div class="row g-4 mb-4">
        <!-- Monthly Publications Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Tren Publikasi Label Makanan (6 Bulan Terakhir)</h6>
                        <small class="text-muted">Jumlah label yang berhasil dipublikasikan setiap bulan</small>
                    </div>
                    <span class="badge bg-light text-success border">Data Riil Terverifikasi</span>
                </div>
                <div class="card-body p-4">
                    <div style="height: 280px; position: relative;">
                        <canvas id="publicationsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Distribution Chart -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0 text-dark">Proporsi Status Label</h6>
                    <small class="text-muted">Komposisi status data label saat ini</small>
                </div>
                <div class="card-body p-4 d-flex align-items-center justify-content-center">
                    <div style="height: 250px; width: 100%; position: relative;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Labels & Activities Row -->
    <div class="row g-4">
        <!-- Recent Labels Table -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Label Makanan Terbaru</h6>
                        <small class="text-muted">Daftar label yang baru dibuat atau dimutakhirkan</small>
                    </div>
                    <a href="{{ route('admin.labels.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($recentLabels->isEmpty())
                        <div class="p-5 text-center text-muted">
                            <i class="fa-solid fa-folder-open fs-1 mb-2 opacity-50"></i>
                            <p class="mb-2">Belum ada label makanan yang terdaftar.</p>
                            <a href="{{ route('admin.labels.create') }}" class="btn btn-sm btn-success rounded-pill">
                                Tambah Label Pertama
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle table-hover mb-0">
                                <thead class="table-light small text-muted">
                                    <tr>
                                        <th class="ps-3">Judul & Tanggal</th>
                                        <th>Energi</th>
                                        <th>Status</th>
                                        <th class="text-end pe-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentLabels as $lbl)
                                        <tr>
                                            <td class="ps-3">
                                                <a href="{{ route('admin.labels.show', $lbl) }}" class="fw-semibold text-dark text-decoration-none d-block text-truncate" style="max-width: 240px;">
                                                    {{ $lbl->title }}
                                                </a>
                                                <small class="text-muted">
                                                    <i class="fa-regular fa-calendar me-1"></i> {{ $lbl->menu_date->isoFormat('D MMMM Y') }}
                                                    @if($lbl->recipient_group)
                                                        &bull; <span class="badge bg-light text-secondary border">{{ $lbl->recipient_group }}</span>
                                                    @endif
                                                </small>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">{{ number_format($lbl->energy, 0, ',', '.') }}</span> <small class="text-muted">kkal</small>
                                            </td>
                                            <td>
                                                <span class="badge {{ $lbl->status_badge_class }} rounded-pill px-2 py-1">
                                                    {{ $lbl->status_label }}
                                                </span>
                                            </td>
                                            <td class="text-end pe-3">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.labels.show', $lbl) }}" class="btn btn-outline-secondary" title="Detail">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.labels.edit', $lbl) }}" class="btn btn-outline-primary" title="Edit">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Log Aktivitas Terbaru</h6>
                        <small class="text-muted">Catatan tindakan operasional admin</small>
                    </div>
                    <a href="{{ route('admin.activities.index') }}" class="btn btn-sm btn-link text-decoration-none text-success p-0">
                        Lihat Log Lengkap
                    </a>
                </div>
                <div class="card-body p-3">
                    @if($recentActivities->isEmpty())
                        <div class="p-4 text-center text-muted small">
                            <i class="fa-solid fa-clipboard-list fs-2 mb-2 opacity-50"></i>
                            <p class="mb-0">Belum ada riwayat aktivitas tercatat.</p>
                        </div>
                    @else
                        <div class="d-flex flex-column gap-3">
                            @foreach($recentActivities as $act)
                                <div class="d-flex align-items-start gap-3 p-2 rounded-3 hover-bg-light">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-success flex-shrink-0" style="width: 36px; height: 36px;">
                                        <i class="fa-solid fa-circle-dot small"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="mb-1 small text-dark fw-medium">{{ $act->description }}</p>
                                        <div class="d-flex align-items-center gap-2 small text-muted">
                                            <span><i class="fa-regular fa-user me-1"></i> {{ $act->user?->name ?? 'Sistem' }}</span>
                                            &bull;
                                            <span><i class="fa-regular fa-clock me-1"></i> {{ $act->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Publications Bar Chart
    const ctxBar = document.getElementById('publicationsChart');
    if (ctxBar) {
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: @json($chartMonths),
                datasets: [{
                    label: 'Label Dipublikasikan',
                    data: @json($chartMonthlyCounts),
                    backgroundColor: 'rgba(25, 135, 84, 0.75)',
                    borderColor: '#198754',
                    borderWidth: 1.5,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    // Status Doughnut Chart
    const ctxDoughnut = document.getElementById('statusChart');
    if (ctxDoughnut) {
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: @json($statusDistribution['labels']),
                datasets: [{
                    data: @json($statusDistribution['data']),
                    backgroundColor: [
                        '#198754', // Published (Green)
                        '#ffc107', // Draft (Warning/Yellow)
                        '#0dcaf0', // Scheduled (Cyan)
                        '#6c757d'  // Archived (Gray)
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, font: { size: 11 } }
                    }
                }
            }
        });
    }
});
</script>
@endpush
