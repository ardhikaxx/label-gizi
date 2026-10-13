@extends('layouts.admin')

@section('title', 'Profil Saya')
@section('page_title', 'Profil Administrator')

@section('content')
<div class="container-fluid p-0">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Profil Saya</h4>
            <p class="text-muted small mb-0">Kelola informasi akun dan keamanan kata sandi Anda.</p>
        </div>
    </div>

    <div class="row g-4">

        {{-- Kolom Kiri: Avatar & Info Singkat --}}
        <div class="col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4 mb-4">
                {{-- Avatar Inisial --}}
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mx-auto mb-3 fw-bold shadow"
                     style="width: 90px; height: 90px; background-color: #0b2853; color: #d4a34b; font-size: 2rem; flex-shrink: 0;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
                <div class="text-muted small mb-1">@{{ $user->username }}</div>
                <div class="text-muted small mb-3">{{ $user->email }}</div>

                <div class="d-flex flex-column gap-2 text-start">
                    <div class="d-flex align-items-center gap-2 rounded-3 px-3 py-2" style="background: rgba(11,40,83,0.05);">
                        <i class="fa-solid fa-circle-check" style="color: {{ $user->is_active ? '#198754' : '#dc3545' }}; font-size: 0.85rem;"></i>
                        <span class="small fw-semibold" style="color: {{ $user->is_active ? '#198754' : '#dc3545' }};">
                            {{ $user->is_active ? 'Akun Aktif' : 'Akun Nonaktif' }}
                        </span>
                    </div>
                    @if ($user->last_login_at)
                    <div class="d-flex align-items-center gap-2 rounded-3 px-3 py-2" style="background: rgba(11,40,83,0.04);">
                        <i class="fa-regular fa-clock text-muted" style="font-size: 0.82rem;"></i>
                        <span class="small text-muted">Login terakhir:<br>
                            <strong>{{ $user->last_login_at->isoFormat('D MMM Y, HH:mm') }}</strong>
                        </span>
                    </div>
                    @endif
                    <div class="d-flex align-items-center gap-2 rounded-3 px-3 py-2" style="background: rgba(11,40,83,0.04);">
                        <i class="fa-regular fa-calendar-plus text-muted" style="font-size: 0.82rem;"></i>
                        <span class="small text-muted">Bergabung sejak:<br>
                            <strong>{{ $user->created_at->isoFormat('D MMMM Y') }}</strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Form Edit --}}
        <div class="col-lg-8 col-xl-9">

            {{-- Form: Informasi Profil --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                              style="width: 32px; height: 32px; background: rgba(11, 40, 83, 0.1); color: #0b2853;">
                            <i class="fa-solid fa-user-pen"></i>
                        </span>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Informasi Profil</h5>
                            <small class="text-muted">Perbarui nama, username, dan email akun Anda</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.profile.update') }}" method="POST"
                          data-confirm="Simpan perubahan informasi profil Anda?"
                          data-confirm-icon="question"
                          data-confirm-btn="Ya, Simpan"
                          data-confirm-color="#0b2853">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            {{-- Nama Lengkap --}}
                            <div class="col-12">
                                <div class="bgn-field mb-1">
                                    <input type="text"
                                           name="name"
                                           id="profile_name"
                                           class="bgn-field-input @error('name') is-invalid @enderror"
                                           value="{{ old('name', $user->name) }}"
                                           placeholder=" "
                                           required>
                                    <label for="profile_name" class="bgn-field-label">Nama Lengkap *</label>
                                </div>
                                @error('name') <div class="bgn-field-error">{{ $message }}</div> @enderror
                            </div>

                            {{-- Username --}}
                            <div class="col-sm-6">
                                <div class="bgn-field mb-1">
                                    <input type="text"
                                           name="username"
                                           id="profile_username"
                                           class="bgn-field-input @error('username') is-invalid @enderror"
                                           value="{{ old('username', $user->username) }}"
                                           placeholder=" "
                                           required>
                                    <label for="profile_username" class="bgn-field-label">Username *</label>
                                </div>
                                <div class="form-text small text-muted ps-1">Hanya huruf, angka, - dan _</div>
                                @error('username') <div class="bgn-field-error">{{ $message }}</div> @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-sm-6">
                                <div class="bgn-field mb-1">
                                    <input type="email"
                                           name="email"
                                           id="profile_email"
                                           class="bgn-field-input @error('email') is-invalid @enderror"
                                           value="{{ old('email', $user->email) }}"
                                           placeholder=" "
                                           required>
                                    <label for="profile_email" class="bgn-field-label">Email *</label>
                                </div>
                                @error('email') <div class="bgn-field-error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-end pt-4 border-top mt-3">
                            <button type="submit" class="btn btn-bgn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm w-100 w-sm-auto">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Informasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Form: Ganti Kata Sandi --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                              style="width: 32px; height: 32px; background: rgba(220, 53, 69, 0.1); color: #dc3545;">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Keamanan & Kata Sandi</h5>
                            <small class="text-muted">Ubah kata sandi akun Anda secara berkala untuk keamanan</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.profile.password') }}" method="POST"
                          data-confirm="Anda yakin ingin mengubah kata sandi?"
                          data-confirm-icon="warning"
                          data-confirm-btn="Ya, Ubah Kata Sandi"
                          data-confirm-color="#dc3545">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            {{-- Kata Sandi Saat Ini --}}
                            <div class="col-12">
                                <div class="bgn-field mb-1">
                                    <input type="password"
                                           name="current_password"
                                           id="current_password"
                                           class="bgn-field-input @error('current_password') is-invalid @enderror"
                                           placeholder=" "
                                           autocomplete="current-password"
                                           required>
                                    <label for="current_password" class="bgn-field-label">Kata Sandi Saat Ini *</label>
                                </div>
                                @error('current_password') <div class="bgn-field-error">{{ $message }}</div> @enderror
                            </div>

                            {{-- Kata Sandi Baru --}}
                            <div class="col-sm-6">
                                <div class="bgn-field mb-1">
                                    <input type="password"
                                           name="password"
                                           id="new_password"
                                           class="bgn-field-input @error('password') is-invalid @enderror"
                                           placeholder=" "
                                           autocomplete="new-password"
                                           required>
                                    <label for="new_password" class="bgn-field-label">Kata Sandi Baru *</label>
                                </div>
                                <div class="form-text small text-muted ps-1">Min. 8 karakter, huruf besar, huruf kecil & angka</div>
                                @error('password') <div class="bgn-field-error">{{ $message }}</div> @enderror
                            </div>

                            {{-- Konfirmasi Kata Sandi Baru --}}
                            <div class="col-sm-6">
                                <div class="bgn-field mb-1">
                                    <input type="password"
                                           name="password_confirmation"
                                           id="password_confirmation"
                                           class="bgn-field-input"
                                           placeholder=" "
                                           autocomplete="new-password"
                                           required>
                                    <label for="password_confirmation" class="bgn-field-label">Konfirmasi Kata Sandi *</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-between gap-3 pt-4 border-top mt-3">
                            <span class="text-muted small">
                                <i class="fa-solid fa-circle-info text-primary me-1"></i>
                                Setelah kata sandi diubah, Anda tetap dalam kondisi login.
                            </span>
                            <button type="submit" class="btn btn-danger rounded-pill px-4 py-2 fw-semibold shadow-sm w-100 w-sm-auto text-nowrap">
                                <i class="fa-solid fa-key me-1"></i> Ubah Kata Sandi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
