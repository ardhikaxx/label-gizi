@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            confirmButtonColor: '#198754',
            timer: 3500,
            timerProgressBar: true
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: "{{ session('error') }}",
            confirmButtonColor: '#dc3545'
        });
    });
</script>
@endif

@if(session('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'warning',
            title: 'Pemberitahuan',
            text: "{{ session('warning') }}",
            confirmButtonColor: '#ffc107',
            confirmButtonText: 'Mengerti'
        });
    });
</script>
@endif

@if(session('info'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: "{{ session('info') }}",
            confirmButtonColor: '#0dcaf0'
        });
    });
</script>
@endif

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'warning',
            title: 'Formulir Belum Lengkap',
            text: 'Silakan periksa kembali bagian input yang diberi tanda merah di formulir.',
            confirmButtonColor: '#198754',
            confirmButtonText: 'Periksa Sekarang'
        });
    });
</script>
@endif
