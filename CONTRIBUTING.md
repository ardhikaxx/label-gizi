# 🤝 Panduan Kontribusi (Contributing Guidelines)

Terima kasih atas minat Anda pada proyek **Label Gizi — Sistem Informasi Label Makanan Bergizi**!

Aplikasi ini dikelola dan dirancang oleh **Yanuar Ardhika Rahmadhani Ubaidillah (@ardhikaxx)**. Karena proyek berlisensi **Proprietary (All Rights Reserved)**, kontribusi berlangsung dengan ketentuan sebagai berikut.

---

## 📌 Prinsip & Kebijakan Hak Cipta

1. **Kepemilikan Kode**: Proyek ini dilindungi hak cipta atas nama **Yanuar Ardhika Rahmadhani Ubaidillah (@ardhikaxx)**.
2. **Larangan Plagiarisme**: Dilarang keras menghapus watermark, metadata hak cipta, atau mengubah *author attribution* yang tertanam dalam sistem (lihat [LICENSE](./LICENSE)).
3. Setiap kontribusi kode yang diterima menjadi bagian dari basis kode proyek berlisensi resmi, dan hak ciptanya melekat pada pemilik proyek.
4. Kontribusi dilakukan melalui *pull request*; dengan mengirimkan kontribusi, Anda menyatakan bahwa kode tersebut adalah karya Anda sendiri dan Anda memberikannya kepada pemilik proyek.

---

## 🛠️ Standar Pengembangan Kode (Code Standards)

* **Bahasa & Framework**: PHP ^8.3 dan Laravel 13.x.
* **Standar Kode PHP**: Mematuhi **PSR-12** — jalankan `vendor/bin/pint --dirty --format agent` sebelum finalisasi perubahan.
* **Struktur**: Ikuti struktur direktori dan konvensi yang sudah ada (Controller → FormRequest → Model). Logika bisnis label (slug unik, lifecycle publish/unpublish/archive/duplicate, format gizi) wajib berada di Model/Service, bukan menumpuk di controller.
* **Keamanan**:
  * Semua endpoint `/admin/*` wajib dilindungi middleware `admin.auth` (tamu via `admin.guest` hanya untuk login).
  * Validasi form menggunakan FormRequest dengan pesan Bahasa Indonesia, bukan validasi inline di controller.
  * Akun nonaktif tidak boleh lolos login maupun middleware; password selalu via hashing (tidak pernah plaintext).
  * Upload gambar wajib divalidasi tipe/ukuran dan disajikan lewat route `/uploads/food-labels/{filename}` yang sudah ada (jangan membuka akses direktori storage secara langsung).
* **Bahasa Antarmuka**: Seluruh label UI dan pesan validasi menggunakan **Bahasa Indonesia**.
* **Frontend**: Gunakan Blade + Tailwind CSS 4 + Vite yang sudah tersedia di layout utama. Dilarang memakai `alert()`, `confirm()`, atau `prompt()` bawaan browser — gunakan SweetAlert.
* **Testing**: Setiap fitur baru wajib disertai test Pest (`php artisan make:test --pest`). Pastikan seluruh test suite lolos: `php artisan test --compact`.

---

## 🌿 Alur Kerja Git (Git Workflow)

1. **Fork & Clone Repository**:
   ```bash
   git clone https://github.com/ardhikaxx/label-gizi.git
   cd label-gizi
   ```

2. **Buat Branch Fitur / Perbaikan**:
   * `feat/nama-fitur` (untuk fitur baru)
   * `fix/nama-bug` (untuk perbaikan bug)
   * `docs/nama-dokumentasi` (untuk dokumentasi)

   ```bash
   git checkout -b feat/modul-baru
   ```

3. **Format Commit Message**:
   Gunakan konvensi [Conventional Commits](https://www.conventionalcommits.org/) dengan deskripsi berbahasa Indonesia:
   * `feat: penambahan export CSV label`
   * `fix: perbaikan fallback menu hari ini`
   * `docs: perbaikan panduan instalasi`

4. **Kirim Pull Request**:
   * Satu PR berfokus pada satu perubahan logis.
   * Sertakan deskripsi perubahan, alasan, dan bukti verifikasi lolos.
   * PR akan ditinjau oleh maintainer sebelum digabungkan.

---

## 🐞 Melaporkan Bug

* Gunakan [GitHub Issues](https://github.com/ardhikaxx/label-gizi/issues) dengan template yang tersedia.
* Sertakan versi PHP/Laravel, langkah reproduksi, dan perilaku yang diharapkan.
* Untuk celah keamanan, **jangan** gunakan Issues — ikuti [SECURITY.md](./SECURITY.md).

---

Terima kasih telah membantu proyek ini berkembang!

**Yanuar Ardhika Rahmadhani Ubaidillah (@ardhikaxx)**
