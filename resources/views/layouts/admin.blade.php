@php
    $appName = \App\Models\ApplicationSetting::get('app_name', 'Label Gizi SPPG Ponorogo');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') — {{ $appName }}</title>
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

    <!-- Flatpickr CDN CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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

    <!-- Sinkronisasi Nilai Input Outlined Floating Label (.bgn-field) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function syncFieldValues() {
                document.querySelectorAll('.bgn-field').forEach(function (field) {
                    const inputs = field.querySelectorAll('.bgn-field-input, input:not([type="hidden"]), select, textarea');
                    let hasVal = false;
                    inputs.forEach(function (inp) {
                        const val = (inp.value || '').toString().trim();
                        if (val !== '') {
                            hasVal = true;
                            inp.classList.add('has-value');
                        } else {
                            inp.classList.remove('has-value');
                        }
                    });
                    if (!hasVal) {
                        const anyInput = field.querySelector('input, select, textarea');
                        if (anyInput && (anyInput.value || '').toString().trim() !== '') {
                            hasVal = true;
                        }
                    }
                    if (hasVal) {
                        field.classList.add('has-value');
                    } else {
                        field.classList.remove('has-value');
                    }
                });
            }
            window.bgnSyncFieldValues = syncFieldValues;
            syncFieldValues();

            document.addEventListener('input', function (e) {
                if (e.target && e.target.classList.contains('bgn-field-input')) {
                    if (e.target.value && e.target.value.toString().trim() !== '') {
                        e.target.classList.add('has-value');
                        e.target.closest('.bgn-field')?.classList.add('has-value');
                    } else {
                        e.target.classList.remove('has-value');
                        e.target.closest('.bgn-field')?.classList.remove('has-value');
                    }
                }
            });
            document.addEventListener('change', function (e) {
                if (e.target && e.target.classList.contains('bgn-field-input')) {
                    if (e.target.value && e.target.value.toString().trim() !== '') {
                        e.target.classList.add('has-value');
                        e.target.closest('.bgn-field')?.classList.add('has-value');
                    } else {
                        e.target.classList.remove('has-value');
                        e.target.closest('.bgn-field')?.classList.remove('has-value');
                    }
                }
            });
            document.addEventListener('shown.bs.modal', function () {
                syncFieldValues();
            });
        });
    </script>

    <!-- Flatpickr CDN JS & Locale ID -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof flatpickr !== 'undefined') {
                if (flatpickr.l10ns && flatpickr.l10ns.id) {
                    flatpickr.localize(flatpickr.l10ns.id);
                }

                function initFlatpickrInstances() {
                    // Date pickers (Format Indonesia: Hari Bulan Tahun, e.g. 13 Oktober 2026)
                    document.querySelectorAll('[data-flatpickr-date]').forEach(function (el) {
                        if (!el._flatpickr) {
                            const isBgn = el.closest('.bgn-field') !== null;
                            const isInvalid = el.classList.contains('is-invalid');
                            const altClass = isBgn
                                ? ('bgn-field-input has-suffix' + (isInvalid ? ' is-invalid' : ''))
                                : (el.className.replace('flatpickr-input', '').trim() || 'form-control');

                            flatpickr(el, {
                                locale: 'id',
                                dateFormat: 'Y-m-d',
                                altInput: true,
                                altFormat: 'j F Y',
                                altInputClass: altClass,
                                allowInput: true,
                                disableMobile: true,
                                onReady: function (selectedDates, dateStr, instance) {
                                    if (instance.altInput) {
                                        instance.altInput.placeholder = ' ';
                                        if (isInvalid) {
                                            instance.altInput.classList.add('is-invalid');
                                        }
                                        if (dateStr || instance.altInput.value) {
                                            instance.altInput.classList.add('has-value');
                                            el.closest('.bgn-field')?.classList.add('has-value');
                                        }
                                    }
                                    if (window.bgnSyncFieldValues) {
                                        window.bgnSyncFieldValues();
                                    }
                                },
                                onChange: function (selectedDates, dateStr, instance) {
                                    el.dispatchEvent(new Event('input', { bubbles: true }));
                                    el.dispatchEvent(new Event('change', { bubbles: true }));
                                    if (instance.altInput) {
                                        instance.altInput.dispatchEvent(new Event('input', { bubbles: true }));
                                        instance.altInput.dispatchEvent(new Event('change', { bubbles: true }));
                                        if (dateStr || instance.altInput.value) {
                                            instance.altInput.classList.add('has-value');
                                            el.closest('.bgn-field')?.classList.add('has-value');
                                        } else {
                                            instance.altInput.classList.remove('has-value');
                                            el.closest('.bgn-field')?.classList.remove('has-value');
                                        }
                                    }
                                    if (window.bgnSyncFieldValues) {
                                        window.bgnSyncFieldValues();
                                    }
                                }
                            });
                        }
                    });

                    // Clock / Time pickers (Format 24 Jam Indonesia: H:i WIB)
                    document.querySelectorAll('[data-flatpickr-time]').forEach(function (el) {
                        if (!el._flatpickr) {
                            flatpickr(el, {
                                locale: 'id',
                                enableTime: true,
                                noCalendar: true,
                                dateFormat: 'H:i',
                                time_24hr: true,
                                minuteIncrement: 5,
                                allowInput: true,
                                disableMobile: true,
                                onChange: function (selectedDates, dateStr) {
                                    el.dispatchEvent(new Event('input', { bubbles: true }));
                                    el.dispatchEvent(new Event('change', { bubbles: true }));
                                    if (dateStr && dateStr.trim() !== '') {
                                        el.classList.add('has-value');
                                        el.closest('.bgn-field')?.classList.add('has-value');
                                    } else {
                                        el.classList.remove('has-value');
                                        el.closest('.bgn-field')?.classList.remove('has-value');
                                    }
                                    if (window.bgnSyncFieldValues) {
                                        window.bgnSyncFieldValues();
                                    }
                                }
                            });
                        }
                    });
                }

                initFlatpickrInstances();
                document.addEventListener('shown.bs.modal', initFlatpickrInstances);
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
