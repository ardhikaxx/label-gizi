@php
    $appName = \App\Models\ApplicationSetting::get('app_name', 'Label Gizi');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Kata Sandi Baru — SPPG PONOROGO KAUMAN SOMOROTO - Badan Gizi Nasional</title>
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
                    <h4 class="fw-bold text-white mb-1" style="letter-spacing: 0.02em;">SPPG KAUMAN SOMOROTO</h4>
                    <div class="d-inline-block px-3 py-1 rounded-pill small fw-bold text-uppercase" style="background: rgba(212, 163, 75, 0.22); color: #d4a34b; border: 1px solid rgba(212, 163, 75, 0.45); letter-spacing: 0.06em; font-size: 0.72rem;">
                        BADAN GIZI NASIONAL &bull; PONOROGO
                    </div>
                </div>

                <!-- Reset Password Card -->
                <div class="card bgn-login-card border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <div class="mb-4">
                            <h5 class="fw-bold text-dark mb-1">Ubah Kata Sandi Baru</h5>
                            <p class="text-muted small mb-0">Silakan masukkan kata sandi baru untuk akun Anda.</p>
                        </div>

                        <!-- Info Email Terverifikasi -->
                        <div class="alert alert-light border d-flex align-items-center gap-2 p-2 mb-4 rounded-3" style="background-color: #f8fafc; font-size: 0.8rem;">
                            <span class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; background: rgba(11, 40, 83, 0.1); color: #0b2853; flex-shrink: 0;">
                                <i class="fa-solid fa-user-check small"></i>
                            </span>
                            <div class="text-truncate">
                                <span class="text-muted">Akun:</span> <strong class="text-dark">{{ $email }}</strong>
                            </div>
                        </div>

                        <form action="{{ route('admin.password.update') }}" method="POST" novalidate>
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">

                            <!-- Kata Sandi Baru -->
                            <div class="bgn-field mb-3">
                                <input type="password"
                                       class="bgn-field-input has-suffix @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       placeholder=" "
                                       required
                                       autofocus>
                                <label for="password" class="bgn-field-label">Kata Sandi Baru</label>
                                <button class="bgn-field-suffix-btn" type="button" id="togglePassword" title="Tampilkan / Sembunyikan Kata Sandi">
                                    <i class="fa-solid fa-eye" id="togglePasswordIcon"></i>
                                </button>
                                @error('password')
                                    <div class="bgn-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Konfirmasi Kata Sandi Baru -->
                            <div class="bgn-field mb-3">
                                <input type="password"
                                       class="bgn-field-input has-suffix"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       placeholder=" "
                                       required>
                                <label for="password_confirmation" class="bgn-field-label">Konfirmasi Kata Sandi Baru</label>
                                <button class="bgn-field-suffix-btn" type="button" id="togglePasswordConfirmation" title="Tampilkan / Sembunyikan Konfirmasi Kata Sandi">
                                    <i class="fa-solid fa-eye" id="togglePasswordConfirmationIcon"></i>
                                </button>
                            </div>

                            <div class="form-text small text-muted mb-4 ps-1">
                                <i class="fa-solid fa-shield-halved me-1 text-primary"></i> Minimal 8 karakter, kombinasi huruf &amp; angka disarankan.
                            </div>

                            <button type="submit" class="btn btn-bgn-primary w-100 py-2 fw-semibold rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                                <i class="fa-solid fa-check"></i>
                                <span>Simpan Kata Sandi Baru</span>
                            </button>
                        </form>
                    </div>

                    <div class="card-footer bg-light border-0 py-3 text-center">
                        <a href="{{ route('admin.login') }}" class="text-decoration-none small text-muted hover-navy">
                            <i class="fa-solid fa-arrow-left me-1"></i> Batal &amp; Kembali ke Halaman Masuk
                        </a>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <small class="text-white-50 d-block">&copy; {{ date('Y') }} SPPG PONOROGO KAUMAN SOMOROTO — Badan Gizi Nasional</small>
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
        // Toggle Password Baru
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

        // Toggle Konfirmasi Password
        document.getElementById('togglePasswordConfirmation').addEventListener('click', function () {
            const confirmInput = document.getElementById('password_confirmation');
            const icon = document.getElementById('togglePasswordConfirmationIcon');
            if (confirmInput.type === 'password') {
                confirmInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                confirmInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Sinkronisasi status nilai input outlined floating label
        function syncFields() {
            document.querySelectorAll('.bgn-field-input').forEach(function (input) {
                if (input.value && input.value.toString().trim() !== '') {
                    input.classList.add('has-value');
                } else {
                    input.classList.remove('has-value');
                }
            });
        }
        syncFields();
        document.querySelectorAll('.bgn-field-input').forEach(function (input) {
            input.addEventListener('input', syncFields);
            input.addEventListener('change', syncFields);
        });
        setTimeout(syncFields, 150);
    </script>
</body>
</html>
