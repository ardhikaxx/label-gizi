# 🥗 Label Gizi — Sistem Informasi Label Makanan Bergizi

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind](https://img.shields.io/badge/Tailwind-4.0-38BDF8?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Pest](https://img.shields.io/badge/Tested%20with-Pest-EB4432?style=for-the-badge&logo=pest&logoColor=white)](https://pestphp.com)
[![License](https://img.shields.io/badge/License-Proprietary-red?style=for-the-badge)](./LICENSE)
[![Author](https://img.shields.io/badge/Author-Yanuar%20Ardhika%20Rahmadhani%20Ubaidillah-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/ardhikaxx)

Aplikasi **Label Gizi** adalah sistem informasi transparansi pangan untuk mempublikasikan label makanan bergizi harian kepada masyarakat. Halaman publik tanpa login menampilkan menu hari ini (fallback ke publikasi terbaru), rincian lauk, angka kecukupan gizi (energi, protein, lemak, karbohidrat, serat), foto hidangan, serta batas waktu & rentang jam konsumsi yang aman. Panel admin mengelola seluruh siklus hidup label (draft → terjadwal → dipublikasikan → diarsipkan), manajemen administrator, pengaturan aplikasi, dan jejak audit aktivitas.

---

## ✨ Fitur Utama

### 1. 🔑 Autentikasi Admin Custom & Proteksi Akses
- Login menggunakan **username atau email** (tanpa starter kit Breeze/Jetstream), dilindungi middleware `admin.guest` & `admin.auth`.
- Rate limiting **5x percobaan/menit** per kombinasi login + IP; akun nonaktif ditolak login dengan pesan Bahasa Indonesia.
- Session regeneration setelah login, pencatatan `last_login_at`, logout aman via POST + CSRF dengan invalidasi sesi.
- Setiap login/logout tercatat di **Activity Log** beserta identitas administrator.

### 2. 🌐 Halaman Publik Tanpa Login
- Landing page menampilkan **menu hari ini yang berstatus published**; bila tidak ada, otomatis fallback ke publikasi terbaru.
- Rincian menu (`Nasi, Lauk, Sayur, Buah, Susu`) dibersihkan dari keterangan gramasi dalam kurung untuk tampilan ringkas.
- Angka gizi diformat notasi Indonesia (koma desimal): energi, protein, lemak, karbohidrat, serat.
- Informasi keamanan pangan: **"Makanan harap dikonsumsi maksimal N jam setelah diterima"** + rentang jam WIB (mis. `Pukul : 08.00 – 12.00 WIB`).
- Foto hidangan dengan fallback `images/default-menu.jpg`; konten hero, edukasi gizi, dan footer diambil dari **Application Settings** sehingga bisa diubah tanpa deploy ulang.

### 3. 🏷️ Manajemen Label Makanan (CRUD + Lifecycle)
- Data label: judul, slug unik (judul + tanggal menu), tanggal menu, deskripsi, gambar, 5 nilai gizi, batas konsumsi (jam), jam mulai/selesai konsumsi, status, jadwal & waktu publikasi.
- State machine status: **Draft → Terjadwal → Dipublikasikan → Diarsipkan** (plus aksi `publish`, `unpublish`, `archive`).
- Aksi **duplikat** untuk membuat ulang menu serupa pada tanggal berbeda; **export CSV** untuk rekap.
- Slug unik otomatis via `FoodLabel::generateUniqueSlug()` (anti tabrakan termasuk data soft-deleted).
- Pencarian judul/deskripsi/nama menu, filter tanggal & rentang tanggal, paginasi admin.

### 4. 🍱 Item Menu (FoodLabelMenu)
- Satu label berisi banyak item menu (`hasMany`) dengan `sort_order`.
- Form tambah/edit dengan baris menu dinamis + **konfirmasi SweetAlert** saat menghapus baris.
- Validasi via FormRequest berbahasa Indonesia.

### 5. 🖼️ Upload Gambar Tanpa `storage:link`
- Gambar disimpan di `storage/uploads/food-labels/` dan disajikan lewat route `GET /uploads/food-labels/{filename}` dengan header cache `immutable, max-age=1 tahun`, `ETag`, dan `Last-Modified`.
- Hapus gambar per label (`DELETE /admin/labels/{label}/image`) tanpa menghapus labelnya.

### 6. 📊 Dashboard Admin
- Kartu statistik real-time: total label, dipublikasikan, draft, terjadwal, diarsipkan, total pengguna.
- Daftar menu hari ini, label terbaru (6), dan aktivitas terbaru (7).
- Grafik publikasi 6 bulan terakhir + donat distribusi status.

### 7. 👥 Manajemen Administrator
- CRUD akun admin: nama, username/email unik, status aktif/nonaktif, reset password terpisah.
- Toggle status cepat; akun nonaktif langsung kehilangan akses (dicek saat login & middleware).
- Validasi via `StoreUserRequest` / `UpdateUserRequest` berbahasa Indonesia.

### 8. ⚙️ Pengaturan Aplikasi
- Key-value store (`application_settings`) berbasis grup: `general` & `contact`.
- Mengatur nama aplikasi/instansi, email & telepon kontak, teks footer, judul/subjudul hero, judul/teks edukasi gizi — langsung tampil di halaman publik.

### 9. 🕘 Activity Log
- Mencatat login/logout, inisialisasi sistem, CRUD label & menu, perubahan status lifecycle, manajemen user, dan perubahan pengaturan — siapa, apa, kapan.

---

## 👥 Hak Akses Pengguna

| Area | Keterangan |
| :--- | :--- |
| **Publik** | Tanpa login: melihat menu hari ini/terbaru, kandungan gizi, batas konsumsi, foto hidangan. Route detail/cetak lama dialihkan ke beranda. |
| **Administrator** | Wajib login (`admin.auth`): dashboard, label & menu, pengguna, pengaturan, activity log, export CSV. |

> Otorisasi ditegakkan di middleware & controller — bukan sekadar menyembunyikan menu.

---

## 🛠️ Tech Stack & Dependensi

* **Backend**: Laravel 13.x (PHP ^8.3)
* **Database**: MySQL 8.0+ (foreign key + soft delete label)
* **Frontend**: Blade, Tailwind CSS 4.0 + Vite 8, SweetAlert2
* **Testing**: Pest (6 feature test + unit)
* **Code Style**: Laravel Pint (PSR-12)

---

## ⚙️ Panduan Instalasi & Menjalankan Aplikasi

### 1. Kloning Repositori
```bash
git clone https://github.com/ardhikaxx/label-gizi.git
cd label-gizi
```

### 2. Install Dependensi PHP & JS
```bash
composer install
npm install
```

### 3. Konfigurasi Environment (`.env`)
Salin file konfigurasi dan buat application key:
```bash
cp .env.example .env
php artisan key:generate
```
Sesuaikan koneksi database MySQL di file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=label_gizi
DB_USERNAME=root
DB_PASSWORD=
```
Kredensial admin awal dapat dikustom via env (opsional):
```env
ADMIN_EMAIL=admin@labelgizi.test
ADMIN_USERNAME=admin
ADMIN_PASSWORD=password
```

### 4. Eksekusi Migrasi & Seeding Data
Aplikasi dilengkapi seeder data awal (1 administrator, 9 pengaturan aplikasi, 3 label contoh + 20 label historis 5 bulan untuk grafik tren, dan activity log inisialisasi).

Khusus local/development (database boleh dikosongkan):
```bash
php artisan migrate:fresh --seed
```

Deployment/production (JANGAN pakai fresh — data tidak akan dihapus):
```bash
php artisan migrate --force
```

### 5. Build Aset Frontend & Jalankan Web Server Lokal
```bash
npm run build
php artisan serve
```
Buka browser dan akses: `http://127.0.0.1:8000`
- Halaman publik: `/`
- Login admin: `/admin/login` (default `admin` / `admin@labelgizi.test` / `password`)
- Via XAMPP Apache: `http://localhost/label-gizi/public`

Untuk pengembangan gunakan `npm run dev` atau `composer run dev`.

---

## 📚 Dokumentasi Sistem

* [⚖️ **LICENSE**](./LICENSE) — Lisensi resmi **Proprietary Software License (All Rights Reserved)**.
* [🛡️ **SECURITY.md**](./SECURITY.md) — Kebijakan keamanan & pelaporan celah (*Responsible Disclosure*).
* [🤝 **CONTRIBUTING.md**](./CONTRIBUTING.md) — Pedoman kontribusi kode & standar PSR-12.
* [📜 **CODE_OF_CONDUCT.md**](./CODE_OF_CONDUCT.md) — Pedoman perilaku komunitas pengembang.
* [💬 **SUPPORT.md**](./SUPPORT.md) — Kanal bantuan teknis & komunikasi resmi pengembang.
* [📋 **CHANGELOG.md**](./CHANGELOG.md) — Riwayat rilis fitur terstruktur (*Keep a Changelog* & SemVer).
* [📚 **CITATION.md**](./CITATION.md) — Format sitasi karya untuk keperluan akademik.

---

## 💖 Dukungan & Donasi

Jika proyek **Label Gizi** ini bermanfaat bagi Anda dan telah menghemat banyak jam kerja Anda, Anda dapat menunjukkan apresiasi dengan memberikan traktiran kopi (donasi) melalui pemindaian kode QRIS di bawah ini:

<p align="center">
  <img src="./qris.png" alt="QRIS Donasi" width="300"/>
</p>

> Donasi sepenuhnya bersifat sukarela dan tidak mengikat. Aplikasi tetap dapat digunakan secara utuh tanpa donasi.

---

## ⚠️ Ketentuan Penggunaan

Proyek ini dilindungi lisensi **Proprietary Software License (All Rights Reserved)**. Anda **dilarang** menyalin, memodifikasi, mendistribusikan ulang, atau menjual kode ini tanpa izin tertulis dari pemilik hak cipta. Lihat [LICENSE](./LICENSE) untuk detail lengkap.

---

## 👨‍💻 Pengembang & Hak Cipta

Dirancang dan dikembangkan dengan penuh dedikasi oleh:
**[Yanuar Ardhika Rahmadhani Ubaidillah (@ardhikaxx)](https://github.com/ardhikaxx)**
*Lead Software Architect & Maintainer*

> **Copyright (c) 2024 - 2026 Yanuar Ardhika Rahmadhani Ubaidillah (@ardhikaxx). All Rights Reserved.**
