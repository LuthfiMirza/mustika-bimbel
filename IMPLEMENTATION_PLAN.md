# IMPLEMENTATION_PLAN.md - Roadmap & Checklist Eksekusi Agent

AI Agent wajib mengerjakan tahapan di bawah ini secara berurutan dan mencentang `[x]` setiap kali satu sub-tugas selesai diverifikasi.

## Fase 1: Inisialisasi Proyek & Database MySQL
- [x] Setup proyek Laravel 12 dan konfigurasi `.env` untuk MySQL (`mustika_bimbel`).
- [x] Install `barryvdh/laravel-dompdf` untuk cetak kwitansi & E-Raport PDF.
- [x] Buat seluruh file Migration sesuai `@DATABASE_SCHEMA.md`.
- [x] Buat seluruh Eloquent Model (`User`, `Program`, `Schedule`, `TrialLead`, `Student`, `StudySession`, `StudentBadge`, `TuitionInvoice`) lengkap dengan relasinya.
- [x] Buat `WhatsAppService.php` di `app/Services/` untuk men-generate link `wa.me` otomatis (Pendaftaran Trial, Notifikasi Anak Tiba, Laporan Jurnal Pulang, dan Pengingat SPP).
- [x] Buat `DatabaseSeeder.php` berisi akun Admin (`admin@mustikabimbel.com` / `password`), 3 Program Utama (TK, SD, SMP), 3 Jadwal Resmi (Senin-Kamis 18.30-20.00, Sabtu 16.00-17.30, Minggu 18.30-20.00)[cite: 1], 4 Siswa Dummy (TK, SD, SMP) beserta riwayat 5 pertemuan jurnal belajar, badge sertifikat, dan SPP agar grafik langsung tampil.
- [x] Jalankan `php artisan migrate:fresh --seed` tanpa error.

## Fase 2: Web Customer (Landing Page Publik & Interactive Lead Magnet)
- [ ] Buat layout publik (`resources/views/layouts/public.blade.php`) dengan warna Navy `#0F2C59` dan Kuning `#FACC15`[cite: 1], Google Fonts, Tailwind CSS, dan Alpine.js.
- [ ] Buat `LandingController.php` untuk menampilkan halaman utama dan memproses form `POST /daftar-trial`.
- [ ] Bangun **Hero Section** & **3 Pilar Keunggulan** (*Konsep Dasar yang Kuat, Teknik Berhitung Cepat, Latihan Soal MIPA*)[cite: 1].
- [ ] Bangun widget interaktif **Mini-Game "Tantangan Hitung Cepat 30 Detik"** (pilihan soal Jarimatika TK/SD dan MIPA SD/SMP) yang terhubung otomatis dengan form pendaftaran.
- [ ] Bangun seksi **Visualizer Metode Jarimatika** & **Tab Katalog Materi Unggulan** (Matematika, IPA Fisika/Kimia/Biologi, Strategi Mengerjakan Soal, Persiapan Ujian)[cite: 1].
- [ ] Bangun seksi **Jadwal Belajar & Sisa Kursi Real-time** serta **Form Klaim Free Trial** yang langsung mengarah ke WhatsApp `087705555190`[cite: 1].
- [ ] Bangun seksi **Peta Lokasi** (Perumahan Amarylis Garden, Jalan H Abdul Gani II Blok I No. 11, Harapan Jaya, Cibinong)[cite: 1] dan Modal "Cek Raport Siswa dengan Kode Siswa".

## Fase 3: Portal Orang Tua & E-Raport Interaktif (`/raport/{portal_token}`)
- [ ] Buat `ParentPortalController.php` dengan pencarian via `portal_token` maupun `student_code`.
- [ ] Bangun UI Mobile-First yang menampilkan profil siswa, **Pohon Level Jarimatika (Level 1-6)**, dan persentase penguasaan MIPA.
- [ ] Integrasikan **Chart.js** untuk menampilkan grafik peningkatan skor latihan soal dan rating kecepatan hitung anak.
- [ ] Tampilkan riwayat jurnal belajar harian dari pengajar.
- [ ] Bangun fitur **Kartu Sertifikat / Digital Badge** yang bisa diunduh orang tua menjadi gambar PNG (`html2canvas`) lengkap dengan branding MustikaBimbel[cite: 1].
- [ ] Tambahkan tombol cetak **E-Raport Bulanan (PDF)** dan **Kwitansi SPP (PDF)**.

## Fase 4: Sistem Internal Admin & Pengajar (`/admin/...`)
- [ ] Buat sistem Login Admin/Pengajar sederhana & aman (`/login`).
- [ ] Buat layout Dashboard Admin (`resources/views/layouts/admin.blade.php`) dengan sidebar responsif.
- [ ] Bangun **Dashboard Utama**: Metrik ringkas, grafik siswa per jenjang (TK/SD/SMP), dan daftar pendaftar trial terbaru.
- [ ] Bangun halaman **Presensi 1-Klik & Input Jurnal Harian Cepat (`/admin/attendance`)**:
  - Tombol 1-Klik *"Hadir & Kirim WA Kedatangan"*.
  - Modal/Form cepat isi topik hari ini, skor latihan, rating kecepatan hitung, dan tombol *"Kirim WA Laporan Pulang"*.
- [ ] Bangun halaman **CRM Trial Leads (`/admin/leads`)** dengan fitur *1-Click Convert to Student*.
- [ ] Bangun halaman **Manajemen Siswa & Pemberian Badge (`/admin/students`)**.
- [ ] Bangun halaman **Manajemen SPP & Kwitansi (`/admin/invoices`)** dengan generator tagihan bulanan massal dan pengingat WA.

## Fase 5: Persiapan Deployment Hostinger Premium
- [ ] Jalankan `npm run build` untuk mengompilasi aset ke `public/build`.
- [ ] Buat file `.htaccess` di root proyek dan panduan singkat deployment ke `public_html` Hostinger.

