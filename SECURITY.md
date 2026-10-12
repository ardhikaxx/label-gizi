# 🛡️ Kebijakan Keamanan (Security Policy)

Keamanan informasi dan integritas data label makanan, data administrator, serta pengaturan aplikasi adalah prioritas utama dalam pengembangan sistem **Label Gizi — Sistem Informasi Label Makanan Bergizi**.

Aplikasi ini dirancang dengan mematuhi prinsip pengembangan aman (secure development), **Undang-Undang Perlindungan Data Pribadi (UU PDP No. 27 Tahun 2022)**, serta standar enkripsi modern.

---

## 📦 Versi yang Didukung

Pembaruan keamanan dan perbaikan celah (*security patches*) aktif diberikan untuk versi berikut:

| Versi | Status Keamanan |
| :--- | :--- |
| **v1.0.x** | ✅ Didukung Penuh (*Active Security Support*) |
| < 1.0.0 | ❌ Tidak Didukung |

---

## 🔒 Lapisan Keamanan Bawaan (Built-in Security Layers)

1. **Autentikasi & Otorisasi Admin**:
   * Login custom username/email dengan middleware `admin.guest` & `admin.auth`.
   * Verifikasi status aktif pada setiap percobaan login DAN middleware — akun nonaktif langsung ditolak (403/redirect login).
   * Route publik hanya read-only; seluruh `/admin/*` wajib login.
2. **Perlindungan Akun**:
   * Rate limiting 5x percobaan/menit per login + IP (anti brute-force).
   * Session regeneration setelah login; logout aman via POST + CSRF + invalidasi sesi + regenerasi token.
   * Password disimpan dengan hashing bcrypt, tidak pernah ditampilkan di mana pun; pencatatan `last_login_at` untuk deteksi anomali.
3. **Perlindungan Injeksi & Serangan Web**:
   * Proteksi penuh dari serangan **CSRF** pada seluruh formulir.
   * Perlindungan **SQL Injection** menggunakan PDO Prepared Statements melalui Eloquent ORM.
   * Sanitasi dan escaping output Blade dari serangan **XSS**; pesan error validasi berbahasa Indonesia tanpa membocorkan error SQL mentah.
   * Upload gambar tervalidasi dan disajikan lewat route terkontrol (tanpa `storage:link` publik langsung).
4. **Integritas Data Label**:
   * Slug unik anti tabrakan; lifecycle status tervalidasi di backend (tidak mempercayai nilai dari browser).
   * Nilai gizi memakai tipe float/decimal dengan validasi FormRequest; soft delete mencegah kehilangan histori.
5. **Audit Trail & Logging**:
   * Setiap aktivitas penting (login/logout, CRUD label & menu, perubahan status lifecycle, manajemen user, pengaturan) dicatat di tabel `activity_logs` beserta pelakunya.

---

## 🚨 Melaporkan Celah Keamanan (Reporting a Vulnerability)

Jika Anda menemukan kerentanan atau celah keamanan (*security vulnerability*) dalam sistem ini:

> [!CAUTION]
> **JANGAN** membuat laporan publik melalui GitHub Issues terbuka demi melindungi pengguna sistem.

Silakan kirimkan laporan celah keamanan secara privat dan bertanggung jawab (*Responsible Disclosure*) melalui:

* **Email Penanggung Jawab Keamanan**: `ardhikayanuar58@gmail.com`
* **Subjek Email**: `[SECURITY VULNERABILITY] - Label Gizi`

### Informasi yang Wajib Disertakan:
1. Deskripsi mendalam mengenai celah keamanan yang ditemukan.
2. Langkah-langkah detail atau *proof-of-concept (PoC)* untuk mereproduksi masalah.
3. Estimasi potensi dampak terhadap data label, data administrator, atau operasional publikasi menu.

Tim pengembang akan merespons laporan dalam waktu **1x24 jam** dan segera merilis perbaikan (*patch*).

---

Terima kasih atas kerja sama Anda dalam menjaga keamanan ekosistem digitalisasi transparansi pangan Indonesia.
**Yanuar Ardhika Rahmadhani Ubaidillah (@ardhikaxx)**
