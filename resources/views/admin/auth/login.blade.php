@php
    $appName = \App\Models\ApplicationSetting::get('app_name', 'Label Gizi');
    $institution = \App\Models\ApplicationSetting::get('institution_name', 'Badan Gizi Nasional Republik Indonesia');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Administrator — Badan Gizi Nasional RI</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- Favicon (Badan Gizi Nasional) -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-bgn.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-bgn.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-bgn.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- SweetAlert2 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom Brand CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bgn-login-body d-flex align-items-center min-vh-100 py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <!-- Brand Header -->
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center p-2 mb-3 rounded-circle bg-white shadow-lg" style="width: 88px; height: 88px;">
                        <img src="{{ asset('images/logo-bgn.png') }}" alt="Logo Badan Gizi Nasional" style="width: 72px; height: 72px; object-fit: contain;">
                    </div>
                    <h4 class="fw-bold text-white mb-1" style="letter-spacing: 0.03em;">BADAN GIZI NASIONAL</h4>
                    <div class="d-inline-block px-3 py-1 rounded-pill small fw-semibold text-uppercase" style="background: rgba(212, 163, 75, 0.18); color: #d4a34b; border: 1px solid rgba(212, 163, 75, 0.4); letter-spacing: 0.08em; font-size: 0.72rem;">
                        REPUBLIK INDONESIA
                    </div>
                    <p class="text-white-50 small mt-2 mb-0">Panel Masuk Administrator</p>
                </div>

                <!-- Login Card -->
                <div class="card bgn-login-card border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">Masuk Administrator</h5>
                                <p class="text-muted small mb-0">Gunakan akun kredensial terdaftar.</p>
                            </div>
                            <span class="badge badge-bgn-gold rounded-pill px-3 py-2 small fw-semibold">
                                <i class="fa-solid fa-shield-halved me-1"></i> Akses Resmi
                            </span>
                        </div>

                        <form action="{{ route('admin.login.submit') }}" method="POST" novalidate class="mt-3">
                            @csrf

                            <div class="mb-3">
                                <label for="login" class="form-label small fw-semibold text-secondary">Email atau Username</label>
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
                                <label for="password" class="form-label small fw-semibold text-secondary">Kata Sandi</label>
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

                            <button type="submit" class="btn btn-bgn-primary w-100 py-2 fw-semibold rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                <span>Masuk ke Dashboard</span>
                            </button>
                        </form>
                    </div>

                    <div class="card-footer bg-light border-0 py-3 text-center">
                        <a href="{{ route('public.home') }}" class="text-decoration-none small text-muted hover-navy">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Halaman Utama Publik
                        </a>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <small class="text-white-50 d-block">&copy; {{ date('Y') }} Badan Gizi Nasional Republik Indonesia</small>
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
