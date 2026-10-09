@extends('layouts.admin')

@section('title', 'Manajemen Pengguna Admin')
@section('page_title', 'Manajemen Akun Administrator')

@section('content')
<div class="container-fluid p-0">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Daftar Akun Administrator</h4>
            <p class="text-muted small mb-0">Kelola akun pengelola sistem, kredensial login, dan status keaktifan akun.</p>
        </div>
        <button type="button" class="btn btn-success rounded-pill px-3 shadow-sm btn-sm fw-medium" data-bs-toggle="modal" data-bs-target="#modalAddUser">
            <i class="fa-solid fa-user-plus me-1"></i> Tambah Administrator Baru
        </button>
    </div>

    <!-- Search & Filter Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama, email, atau username..." value="{{ $search }}">
                    </div>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-success rounded-pill flex-grow-1">Cari</button>
                    @if(!empty($search))
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-light border rounded-pill" title="Reset Pencarian">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small text-muted text-uppercase">
                        <tr>
                            <th class="ps-4">Nama Administrator</th>
                            <th>Username</th>
                            <th>Status Akun</th>
                            <th>Login Terakhir</th>
                            <th>Waktu Dibuat</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark d-block">
                                                {{ $user->name }}
                                                @if($user->id === Auth::id())
                                                    <span class="badge bg-primary bg-opacity-10 text-primary ms-1" style="font-size: 0.7rem;">Anda</span>
                                                @endif
                                            </span>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <code class="text-secondary">@ {{ $user->username }}</code>
                                </td>
                                <td>
                                    @if($user->isActive())
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1">
                                            <i class="fa-solid fa-circle-check me-1 small"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1">
                                            <i class="fa-solid fa-circle-xmark me-1 small"></i> Non-Aktif
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->last_login_at)
                                        <span class="small text-muted" title="{{ $user->last_login_at }}">
                                            {{ $user->last_login_at->diffForHumans() }}
                                        </span>
                                    @else
                                        <span class="small text-muted fst-italic">Belum pernah</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="small text-muted">{{ $user->created_at->isoFormat('D MMM Y') }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <!-- Edit Info Button -->
                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-circle p-0 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Edit Profil"
                                                data-bs-toggle="modal" data-bs-target="#modalEditUser{{ $user->id }}">
                                            <i class="fa-solid fa-pen small"></i>
                                        </button>

                                        <!-- Change Password Button -->
                                        <button type="button" class="btn btn-outline-warning btn-sm rounded-circle p-0 d-inline-flex align-items-center justify-content-center text-dark" style="width: 32px; height: 32px;" title="Ubah Kata Sandi"
                                                data-bs-toggle="modal" data-bs-target="#modalPasswordUser{{ $user->id }}">
                                            <i class="fa-solid fa-key small"></i>
                                        </button>

                                        <!-- Toggle Status -->
                                        @if($user->id !== Auth::id())
                                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST"
                                                  data-confirm="{{ $user->isActive() ? 'Nonaktifkan akun admin ini? Pengguna tidak akan dapat login kembali.' : 'Aktifkan kembali akun admin ini?' }}"
                                                  data-confirm-icon="warning"
                                                  data-confirm-btn="{{ $user->isActive() ? 'Ya, Nonaktifkan' : 'Ya, Aktifkan' }}"
                                                  data-confirm-color="{{ $user->isActive() ? '#ffc107' : '#198754' }}"
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-secondary btn-sm rounded-circle p-0 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="{{ $user->isActive() ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}">
                                                    <i class="fa-solid {{ $user->isActive() ? 'fa-user-slash text-warning' : 'fa-user-check text-success' }} small"></i>
                                                </button>
                                            </form>

                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                  data-confirm="Apakah Anda yakin ingin menghapus akun admin '{{ $user->name }}'? Tindakan ini tidak dapat dibatalkan."
                                                  data-confirm-icon="warning"
                                                  data-confirm-btn="Ya, Hapus Akun"
                                                  data-confirm-color="#dc3545"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle p-0 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Hapus Akun">
                                                    <i class="fa-solid fa-trash small"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Edit Profil User -->
                            <div class="modal fade" id="modalEditUser{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold">Edit Administrator</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold">Nama Lengkap</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold">Alamat Email</label>
                                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold">Username</label>
                                                    <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success rounded-pill px-4">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Ganti Kata Sandi User -->
                            <div class="modal fade" id="modalPasswordUser{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <form action="{{ route('admin.users.password', $user) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold">Ubah Kata Sandi: {{ $user->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold">Kata Sandi Baru (Min. 8 Karakter)</label>
                                                    <input type="password" name="password" class="form-control" placeholder="••••••••" required minlength="8">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold">Konfirmasi Kata Sandi Baru</label>
                                                    <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required minlength="8">
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-warning text-dark rounded-pill px-4">Perbarui Kata Sandi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="p-5 text-center text-muted">
                                    Tidak ada data admin ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3 border-top d-flex justify-content-between align-items-center">
                <small class="text-muted">Total: <strong>{{ $users->total() }}</strong> akun administrator</small>
                <div>
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal Tambah Admin Baru -->
<div class="modal fade" id="modalAddUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="{{ route('admin.users.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Tambah Administrator Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="small text-muted mb-3">Setiap akun baru secara otomatis memiliki hak akses Administrator penuh.</p>

                    <div class="mb-3">
                        <label for="new_name" class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="new_name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: Rina Anggraeni, S.Gz" required>
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_email" class="form-label small fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="new_email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="nama@email.com" required>
                        @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_username" class="form-label small fw-semibold">Username Login <span class="text-danger">*</span></label>
                        <input type="text" name="username" id="new_username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="Contoh: admin_rina" required>
                        @error('username') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label small fw-semibold">Kata Sandi <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="new_password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required minlength="8">
                        @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label small fw-semibold">Konfirmasi Kata Sandi <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" id="new_password_confirmation" class="form-control" placeholder="Ulangi kata sandi" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Simpan Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
