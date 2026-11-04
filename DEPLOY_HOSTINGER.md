# Panduan Deployment MustikaBimbel ke Hostinger Premium Web Hosting

Panduan ini disusun khusus untuk mendeploy ekosistem web **MustikaBimbel** (Laravel 12 + MySQL) ke **Hostinger Premium Web Hosting (Shared Hosting berbasis LiteSpeed Web Server)**.

---

## 1. Persiapan Database MySQL di hPanel Hostinger

1. Masuk ke **hPanel Hostinger** (`https://hpanel.hostinger.com`).
2. Masuk ke menu **Databases** &rarr; **Management**.
3. Buat database baru:
   - **Database Name:** misal `u123456789_mustikabimbel`
   - **Username:** misal `u123456789_admin`
   - **Password:** Masukkan kata sandi yang kuat dan catat.
4. Klik **Create**.
5. Buka **phpMyAdmin** untuk database tersebut di hPanel.
6. Dari laptop/server lokal Anda, ekspor database `mustika_bimbel`:
   ```bash
   /Applications/XAMPP/xamppfiles/bin/mysqldump -u root mustika_bimbel > mustika_bimbel_backup.sql
   ```
7. Di phpMyAdmin Hostinger, klik tab **Import**, pilih file `mustika_bimbel_backup.sql`, lalu klik **Go / Impor**.

---

## 2. Pilihan Upload File ke Hostinger

Tersedia dua opsi praktis di Hostinger:

### Opsi A: Menggunakan Fitur Git di hPanel (Paling Direkomendasikan)
1. Buka hPanel &rarr; Menu **Advanced** &rarr; **Git**.
2. Masukkan URL Repository:
   ```text
   https://github.com/LuthfiMirza/mustika-bimbel.git
   ```
3. Pilih Branch: `main`.
4. Install Path: `/` (atau `/public_html`).
5. Klik **Create / Deploy**.

### Opsi B: Upload Manual via File Manager (ZIP)
1. Di lokal, pastikan aset produksi sudah ter-compile:
   ```bash
   npm run build
   ```
2. Kompres seluruh file proyek ke dalam file ZIP (kecuali folder `/node_modules`, `/storage/logs`, dan `.git`). Pastikan folder `/public/build` dan `/vendor` ikut terunggah jika tidak menggunakan akses SSH Terminal.
3. Buka **File Manager** di hPanel Hostinger.
4. Masuk ke root direktori domain Anda (misal `public_html/`).
5. Upload file ZIP dan ekstrak seluruh isinya di sana.

---

## 3. Konfigurasi File `.env` di Server Production

Di File Manager Hostinger, buka file `.env` (atau salin dari `.env.example`) dan sesuaikan parameter berikut:

```ini
APP_NAME="MustikaBimbel"
APP_ENV=production
APP_KEY=base64:u6HQqElPG2tItDeX/94C8GqYP/VBgHiVJBD3PFZecZQ=
APP_DEBUG=false
APP_URL=https://namadomainanda.com

APP_LOCALE=id
APP_FALLBACK_LOCALE=en

LOG_CHANNEL=daily
LOG_LEVEL=error

# Sesuaikan dengan kredensial database di hPanel
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u123456789_mustikabimbel
DB_USERNAME=u123456789_admin
DB_PASSWORD=KataSandiDatabaseAnda

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Opsional: Jika menggunakan gateway Fonnte untuk WA otomatis tanpa klik
FONNTE_API_KEY=
```

---

## 4. Konfigurasi Web Server LiteSpeed & File `.htaccess`

Proyek ini telah dilengkapi dengan dua file `.htaccess` yang teruji aman:
1. **Root `.htaccess`:** Otomatis meneruskan trafik dari `public_html/` ke folder `public_html/public/` tanpa perlu memindahkan struktur folder Laravel, sekaligus memblokir akses ke file sensitif (`.env`, `composer.json`, `.git`).
2. **`public/.htaccess`:** Menghandle routing URL Laravel (`index.php`) dan caching aset statis LiteSpeed.

---

## 5. Menjalankan Perintah Optimasi via SSH Terminal Hostinger

Jika paket Hostinger Anda mendukung akses **SSH**:
1. Hubungkan terminal SSH Anda:
   ```bash
   ssh -p 65002 u123456789@ip_hostinger
   ```
2. Masuk ke direktori web:
   ```bash
   cd public_html
   ```
3. Buat symlink storage publik:
   ```bash
   php artisan storage:link
   ```
4. Jalankan optimasi cache Laravel:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

## 6. Akun Login Bawaan (Default Credentials)

Setelah database terimpor, Anda dapat langsung login ke portal internal pengajar di:
- **URL Login:** `https://namadomainanda.com/login`
- **Akun Pengelola / Admin:**
  - Email: `admin@mustikabimbel.com`
  - Password: `password`
- **Akun Pengajar / Tutor:**
  - Email: `tutor@mustikabimbel.com`
  - Password: `password`

*(Disarankan langsung mengganti kata sandi setelah login pertama kali).*

---

## 7. Verifikasi Fitur Utama Setelah Live

1. **Landing Page (`/`):**
   - Tes mini-game 30 detik (Jarimatika & MIPA).
   - Tes form Free Trial & konfirmasi terhubung ke nomor WA Resmi `087705555190`.
2. **Portal E-Raport (`/raport/{portal_token}`):**
   - Buka contoh token: `/raport/raport-aisyah-01`.
   - Cek grafik Chart.js perkembangan belajar.
   - Klik **Unduh Sertifikat (PNG)** dan pastikan `html2canvas` men-generate gambar jernih.
   - Klik **Cetak E-Raport (PDF)** dan **Unduh Kwitansi (PDF)** via `dompdf`.
3. **Panel Admin (`/admin/dashboard`):**
   - Tes Presensi 1-Klik di `/admin/attendance` (otomatis membuka WhatsApp orang tua).
   - Tes pengisian Jurnal Belajar & Laporan Pulang WA.
   - Tes CRM Calon Siswa di `/admin/leads` & tombol 1-Klik Konversi Siswa Resmi.
   - Tes Manajemen SPP di `/admin/invoices` & pengingat WA sopan.
