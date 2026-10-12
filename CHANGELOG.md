# 📋 Changelog

Semua perubahan penting dan riwayat pengembangan proyek **Label Gizi — Sistem Informasi Label Makanan Bergizi** didokumentasikan dalam file ini.

Format pencatatan mengacu pada [Keep a Changelog](https://keepachangelog.com/id/1.0.0/) dan mematuhi [Semantic Versioning (SemVer)](https://semver.org/).

---

## [1.0.0] - 2026-10-12
### 🚀 Rilis Perdana (Initial Production Release)
Dikembangkan oleh **Yanuar Ardhika Rahmadhani Ubaidillah (@ardhikaxx)**.

### ✨ Added (Fitur Baru)
- **Autentikasi Admin & Proteksi**:
  - Login custom berbasis session (username atau email) tanpa starter kit, session regeneration, logout POST + CSRF + invalidasi sesi.
  - Middleware `admin.guest` dan `admin.auth` (akun nonaktif ditolak login & diblokir di middleware).
  - Rate limiting 5x percobaan/menit per login + IP; pencatatan `last_login_at`.
- **Halaman Publik Tanpa Login**:
  - Landing page menu hari ini berstatus published dengan fallback ke publikasi terbaru.
  - Rincian lauk ringkas, angka gizi notasi Indonesia (energi, protein, lemak, karbohidrat, serat).
  - Notifikasi batas konsumsi ("maksimal N jam setelah diterima") + rentang jam WIB.
  - Foto hidangan dengan fallback default; konten hero/edukasi/footer dari Application Settings.
- **Manajemen Label Makanan**:
  - CRUD label: judul, slug unik (judul + tanggal), tanggal menu, deskripsi, gambar, 5 nilai gizi, batas & jam konsumsi, status, jadwal publikasi.
  - Lifecycle draft → terjadwal → dipublikasikan → diarsipkan (`publish`, `unpublish`, `archive`), duplikat label, export CSV.
  - Slug unik anti tabrakan (termasuk soft-deleted); soft delete; pencarian & filter tanggal/rentang.
- **Item Menu (FoodLabelMenu)**:
  - Relasi `hasMany` dengan `sort_order`; form baris dinamis + konfirmasi SweetAlert saat hapus baris.
  - Validasi FormRequest berbahasa Indonesia.
- **Gambar Tanpa `storage:link`**:
  - Penyimpanan `storage/uploads/food-labels/` + route serving `/uploads/food-labels/{filename}` (cache immutable 1 tahun, ETag, Last-Modified).
  - Endpoint hapus gambar per label.
- **Dashboard Admin**:
  - Statistik total/published/draft/scheduled/archived/pengguna; menu hari ini; label & aktivitas terbaru.
  - Grafik publikasi 6 bulan + donat distribusi status.
- **Manajemen Administrator**:
  - CRUD admin, toggle status aktif, update password terpisah via `StoreUserRequest`/`UpdateUserRequest`.
- **Pengaturan Aplikasi**:
  - Key-value store grup `general`/`contact`: nama aplikasi & instansi, kontak, hero, edukasi gizi, footer.
- **Activity Log**:
  - Jejak login/logout, inisialisasi sistem, CRUD label/menu, lifecycle, user, dan pengaturan.
- **Data Awal**:
  - Seeder idempoten: 1 administrator (`admin` / `admin@labelgizi.test` / `password`, dapat dioverride via env), 9 pengaturan, 3 label contoh (hari ini published, kemarin published, besok draft), 20 label historis 5 bulan untuk visualisasi tren.
- **Dokumentasi**:
  - README lengkap (fitur, instalasi, akun demo) dengan QRIS donasi, SECURITY.md, CONTRIBUTING.md, CODE_OF_CONDUCT.md, SUPPORT.md, CHANGELOG.md, CITATION.md.

### 🔐 Security
- Proteksi CSRF penuh, Eloquent ORM (anti SQL Injection), escaping Blade (anti XSS).
- Password hashing bcrypt; user nonaktif tidak dapat login; otorisasi middleware per endpoint.
- Rate limiting login; kalkulasi & validasi di backend (tidak mempercayai nilai browser).

---

[1.0.0]: https://github.com/ardhikaxx/label-gizi/releases/tag/v1.0.0
