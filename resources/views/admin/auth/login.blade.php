@php
    $appName = \App\Models\ApplicationSetting::get('app_name', 'Label Gizi');
    $institution = \App\Models\ApplicationSetting::get('institution_name', 'Pusat Distribusi Makanan Bergizi Sehat');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Administrator — {{ $appName }}</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- SweetAlert2 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom Brand CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light d-flex align-items-center min-vh-100 py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="text-center mb-4">
                    <a href="{{ route('public.home') }}" class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle shadow-sm mb-3" style="width: 54px; height: 54px; text-decoration: none;">
                        <i class="fa-solid fa-apple-whole fs-3"></i>
                    </a>
                    <h4 class="fw-bold text-dark mb-1">{{ $appName }}</h4>
                    <p class="text-muted small">Panel Masuk Khusus Administrator</p>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold text-dark mb-2">Selamat Datang</h5>
                        <p class="text-muted small mb-4">Masukkan kredensial akun administrator Anda untuk melanjutkan.</p>

                        <form action="{{ route('admin.login.submit') }}" method="POST" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="login" class="form-label small fw-semibold">Email atau Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control border-start-0 ps-0 @error('login') is-invalid @enderror"
                                           id="login"
                                           name="login"
                                           value="{{ old('login') }}"
                                           placeholder="nama@email.com atau username"
                                           required
                                           autofocus>
                                </div>
                                @error('login')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label small fw-semibold">Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="fa-solid fa-key"></i>
                                    </span>
                                    <input type="password"
                                           class="form-control border-start-0 border-end-0 px-0 @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           placeholder="••••••••"
                                           required>
                                    <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword" title="Tampilkan / Sembunyikan Kata Sandi">
                                        <i class="fa-solid fa-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label small text-muted" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                                <span class="badge bg-light text-secondary border">Akses Terlindungi</span>
                            </div>

                            <button type="submit" class="btn btn-success w-100 py-2 fw-semibold rounded-3 shadow-sm">
                                <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk ke Dashboard
                            </button>
                        </form>
                    </div>

                    <div class="card-footer bg-light border-0 py-3 text-center">
                        <a href="{{ route('public.home') }}" class="text-decoration-none small text-muted">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Halaman Utama Publik
                        </a>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <small class="text-muted d-block">&copy; {{ date('Y') }} {{ $appName }} &bull; {{ $institution }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('partials.sweetalert')

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
