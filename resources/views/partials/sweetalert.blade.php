@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: {!! json_encode(session('success')) !!},
                confirmButtonColor: '#198754',
                timer: 3500,
                timerProgressBar: true
            });
        }
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: {!! json_encode(session('error')) !!},
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Tutup'
            });
        }
    });
</script>
@endif

@if(session('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Pemberitahuan',
                text: {!! json_encode(session('warning')) !!},
                confirmButtonColor: '#c48b0f',
                confirmButtonText: 'Mengerti'
            });
        }
    });
</script>
@endif

@if(session('info'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: {!! json_encode(session('info')) !!},
                confirmButtonColor: '#0b2853',
                confirmButtonText: 'Tutup'
            });
        }
    });
</script>
@endif

@if(session('status'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                title: 'Status',
                text: {!! json_encode(session('status')) !!},
                confirmButtonColor: '#0b2853',
                confirmButtonText: 'Tutup'
            });
        }
    });
</script>
@endif

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swal !== 'undefined') {
            const errorList = {!! json_encode($errors->all()) !!};
            let htmlMsg = '<div class="text-start small mt-2"><ul class="mb-0 ps-3">';
            errorList.forEach(function(msg) {
                htmlMsg += '<li class="text-danger mb-1">' + msg + '</li>';
            });
            htmlMsg += '</ul></div>';

            Swal.fire({
                icon: 'error',
                title: 'Formulir Belum Lengkap',
                html: htmlMsg,
                confirmButtonColor: '#0b2853',
                confirmButtonText: 'Periksa Formulir'
            });
        }
    });
</script>
@endif

<script>
/**
 * Global SweetAlert2 Confirmation & Alert System (Badan Gizi Nasional)
 * Menggunakan link CDN SweetAlert2 untuk semua dialog konfirmasi dan alert di proyek ini
 */
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Swal === 'undefined') {
        console.warn('SweetAlert2 CDN belum termuat.');
        return;
    }

    // Override native window.alert untuk selalu menggunakan SweetAlert2 CDN
    window.alert = function(msg) {
        Swal.fire({
            title: 'Pemberitahuan',
            text: String(msg),
            icon: 'info',
            confirmButtonColor: '#0b2853',
            confirmButtonText: 'Mengerti'
        });
    };

    // Helper global untuk memanggil alert konfirmasi secara programatik
    window.confirmSweet = function(options) {
        return Swal.fire({
            title: options.title || 'Konfirmasi Tindakan',
            text: options.text || 'Apakah Anda yakin ingin melanjutkan tindakan ini?',
            icon: options.icon || 'warning',
            showCancelButton: true,
            confirmButtonColor: options.confirmColor || '#0b2853',
            cancelButtonColor: '#6c757d',
            confirmButtonText: options.confirmText || 'Ya, Lanjutkan',
            cancelButtonText: options.cancelText || 'Batal',
            reverseButtons: true,
            focusCancel: options.focusCancel || false
        });
    };

    // Helper global untuk alert notifikasi
    window.SwalSuccess = function(text, title = 'Berhasil') {
        return Swal.fire({
            icon: 'success',
            title: title,
            text: text,
            confirmButtonColor: '#198754',
            timer: 3500,
            timerProgressBar: true
        });
    };

    window.SwalError = function(text, title = 'Terjadi Kesalahan') {
        return Swal.fire({
            icon: 'error',
            title: title,
            text: text,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Tutup'
        });
    };

    window.SwalWarning = function(text, title = 'Peringatan') {
        return Swal.fire({
            icon: 'warning',
            title: title,
            text: text,
            confirmButtonColor: '#c48b0f',
            confirmButtonText: 'Mengerti'
        });
    };

    window.SwalInfo = function(text, title = 'Informasi') {
        return Swal.fire({
            icon: 'info',
            title: title,
            text: text,
            confirmButtonColor: '#0b2853',
            confirmButtonText: 'Tutup'
        });
    };

    // Track button submitter terakhir untuk mempertahankan name & value saat submit form
    let lastSubmitter = null;
    document.addEventListener('click', function(e) {
        const submitBtn = e.target.closest('button[type="submit"], input[type="submit"]');
        if (submitBtn) {
            lastSubmitter = submitBtn;
        }
    }, true);

    // Global SweetAlert Logout Confirmation dengan Event Delegation
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-logout-trigger');
        if (btn) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Keluar',
                text: 'Apakah Anda yakin ingin keluar dari sesi administrator?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    const logoutForm = document.getElementById('logout-form');
                    if (logoutForm) {
                        logoutForm.submit();
                    }
                }
            });
        }
    });

    // Global Form Submission Confirmation dengan Event Delegation (form[data-confirm])
    document.addEventListener('submit', function(e) {
        const form = e.target.closest('form[data-confirm]');
        if (!form) return;

        if (form.dataset.confirmed === 'true') {
            return true;
        }
        e.preventDefault();

        const title = form.getAttribute('data-confirm-title') || 'Konfirmasi Tindakan';
        const message = form.getAttribute('data-confirm') || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
        const icon = form.getAttribute('data-confirm-icon') || 'warning';
        const confirmBtnText = form.getAttribute('data-confirm-btn') || 'Ya, Lanjutkan';
        const confirmBtnColor = form.getAttribute('data-confirm-color') || '#0b2853';
        const cancelBtnText = form.getAttribute('data-confirm-cancel') || 'Batal';

        Swal.fire({
            title: title,
            text: message,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: confirmBtnColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmBtnText,
            cancelButtonText: cancelBtnText,
            reverseButtons: true
        }).then(function(result) {
            if (result.isConfirmed) {
                if (lastSubmitter && lastSubmitter.form === form && lastSubmitter.name) {
                    let hiddenInput = form.querySelector(`input[type="hidden"][name="${lastSubmitter.name}"]`);
                    if (!hiddenInput) {
                        hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = lastSubmitter.name;
                        form.appendChild(hiddenInput);
                    }
                    hiddenInput.value = lastSubmitter.value;
                }
                form.dataset.confirmed = 'true';
                form.submit();
            }
        });
    });

    // Global Link & Standalone Button Confirmation dengan Event Delegation (a[data-confirm], button[data-confirm]:not([type="submit"]))
    document.addEventListener('click', function(e) {
        const el = e.target.closest('a[data-confirm], button[data-confirm]:not([type="submit"])');
        if (!el) return;

        e.preventDefault();

        const title = el.getAttribute('data-confirm-title') || 'Konfirmasi Tindakan';
        const message = el.getAttribute('data-confirm') || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
        const icon = el.getAttribute('data-confirm-icon') || 'warning';
        const confirmBtnText = el.getAttribute('data-confirm-btn') || 'Ya, Lanjutkan';
        const confirmBtnColor = el.getAttribute('data-confirm-color') || '#0b2853';
        const cancelBtnText = el.getAttribute('data-confirm-cancel') || 'Batal';

        Swal.fire({
            title: title,
            text: message,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: confirmBtnColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmBtnText,
            cancelButtonText: cancelBtnText,
            reverseButtons: true
        }).then(function(result) {
            if (result.isConfirmed) {
                if (el.tagName === 'A' && el.href) {
                    window.location.href = el.href;
                } else if (el.dataset.targetForm) {
                    document.querySelector(el.dataset.targetForm)?.submit();
                }
            }
        });
    });
});
</script>
