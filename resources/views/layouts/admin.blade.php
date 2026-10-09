@php
    $appName = \App\Models\ApplicationSetting::get('app_name', 'Label Gizi');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') — {{ $appName }}</title>
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

    @stack('styles')
</head>
<body>

    <div class="admin-wrapper">
        <!-- Sidebar -->
        @include('partials.admin-sidebar')

        <!-- Main Workspace -->
        <div class="admin-main">
            <!-- Topbar -->
            @include('partials.admin-topbar')

            <!-- Page Content -->
            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Hidden Logout Form -->
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <!-- Bootstrap 5 Bundle JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart.js CDN with Fallback -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>
    <script>
        if (typeof Chart === 'undefined') {
            document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"><\/script>');
        }
    </script>

    @include('partials.sweetalert')

    <script>
        // Global SweetAlert Logout Confirmation
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-logout-trigger').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi Keluar',
                        text: 'Apakah Anda yakin ingin keluar dari sesi administrator?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Keluar',
                        cancelButtonText: 'Batal'
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            document.getElementById('logout-form').submit();
                        }
                    });
                });
            });

            // Global SweetAlert Form Submitter with Confirmation
            document.querySelectorAll('form[data-confirm]').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    if (form.dataset.confirmed === 'true') {
                        return true;
                    }
                    e.preventDefault();
                    const message = form.getAttribute('data-confirm') || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
                    const icon = form.getAttribute('data-confirm-icon') || 'warning';
                    const confirmBtnText = form.getAttribute('data-confirm-btn') || 'Ya, Lanjutkan';
                    const confirmBtnColor = form.getAttribute('data-confirm-color') || '#198754';

                    Swal.fire({
                        title: 'Konfirmasi Tindakan',
                        text: message,
                        icon: icon,
                        showCancelButton: true,
                        confirmButtonColor: confirmBtnColor,
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: confirmBtnText,
                        cancelButtonText: 'Batal'
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            form.dataset.confirmed = 'true';
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
