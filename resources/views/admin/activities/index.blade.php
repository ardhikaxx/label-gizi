@extends('layouts.admin')

@section('title', 'Log Aktivitas')
@section('page_title', 'Riwayat & Log Aktivitas Sistem')

@section('content')
<div class="container-fluid p-0">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Audit Trail & Log Aktivitas</h4>
            <p class="text-muted small mb-0">Catatan riwayat tindakan administratif, perubahan data, dan akses sistem.</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.activities.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Cari keterangan, admin, atau IP address..." value="{{ $search }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <select name="action" class="form-select form-select-sm">
                        <option value="">Semua Jenis Tindakan</option>
                        @foreach($availableActions as $act)
                            <option value="{{ $act }}" {{ $currentAction === $act ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $act)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-bgn-primary rounded-pill flex-grow-1">Filter</button>
                    @if(!empty($search) || !empty($currentAction))
                        <a href="{{ route('admin.activities.index') }}" class="btn btn-sm btn-light border rounded-pill" title="Reset Filter">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Logs Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small text-muted text-uppercase">
                        <tr>
                            <th class="ps-4">Waktu</th>
                            <th>Pelaku (Admin)</th>
                            <th>Aktivitas</th>
                            <th>Rincian Keterangan</th>
                            <th class="text-end pe-4">Alamat IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td class="ps-4 text-nowrap">
                                    <div class="small fw-semibold text-dark">{{ $log->created_at->isoFormat('D MMM Y, HH:mm') }}</div>
                                    <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    @if($log->user)
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-dark fw-bold small" style="width: 28px; height: 28px;">
                                                {{ strtoupper(substr($log->user->name, 0, 1)) }}
                                            </div>
                                            <span class="small fw-semibold text-dark">{{ $log->user->name }}</span>
                                        </div>
                                    @else
                                        <span class="badge bg-light text-secondary border small">Sistem / Terhapus</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $badgeColor = match($log->action) {
                                            'login' => 'bg-info text-dark',
                                            'logout' => 'bg-secondary',
                                            'create_label', 'create_user' => 'bg-success',
                                            'update_label', 'update_user', 'update_settings' => 'bg-primary',
                                            'publish_label' => 'bg-success',
                                            'unpublish_label' => 'bg-warning text-dark',
                                            'archive_label' => 'bg-secondary',
                                            'delete_label', 'delete_user' => 'bg-danger',
                                            'duplicate_label' => 'bg-info text-dark',
                                            default => 'bg-light text-dark border',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeColor }} rounded-pill px-2 py-1 small">
                                        {{ ucwords(str_replace('_', ' ', $log->action)) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="small text-dark">{{ $log->description }}</span>
                                </td>
                                <td class="text-end pe-4 text-nowrap">
                                    <code class="small text-secondary">{{ $log->ip_address ?? '-' }}</code>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-5 text-center text-muted">
                                    Tidak ada data aktivitas yang sesuai dengan kriteria filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3 border-top d-flex justify-content-between align-items-center">
                <small class="text-muted">Total: <strong>{{ $logs->total() }}</strong> catatan riwayat</small>
                <div>
                    {{ $logs->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
