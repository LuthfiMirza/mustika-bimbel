# PROJECT_SPEC.md - Product Requirements Document (MustikaBimbel)

## 1. Identitas Bisnis & Informasi Kontak Resmi
- **Nama Bimbel:** MustikaBimbel[cite: 1]
- **Sub-judul Brand:** Bimbel MIPA untuk Masa Depanmu[cite: 1]
- **Tagline Utama:** "Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!"[cite: 1]
- **Filosofi Pembelajaran:** "Belajar bukan sekadar menghafal rumus. Pahami cara kerjanya, kuasai langkahnya, dan temukan cara menyelesaikan soal dengan lebih efektif."[cite: 1]
- **Call to Action (CTA):** "Yuk, Bangun Fondasi MIPA-mu! Daftar sekarang dan mulai belajar dengan lebih terarah." & "MIPA lebih mudah!"[cite: 1]
- **Nomor WhatsApp Resmi:** 087705555190 (Format Internasional: `6287705555190`)[cite: 1]
- **Alamat Lokasi Bimbel:** Perumahan Amarylis Garden, Jalan H Abdul Gani II Blok I No. 11, Harapan Jaya, Cibinong[cite: 1]
- **Jadwal Belajar Resmi:**[cite: 1]
  - **Senin – Kamis:** 18.30 – 20.00 WIB[cite: 1]
  - **Sabtu:** 16.00 – 17.30 WIB[cite: 1]
  - **Minggu:** 18.30 – 20.00 WIB[cite: 1]

---

## 2. Kurikulum, Jenjang & Materi Unggulan

### A. Tiga Pilar Utama ("Apa yang kamu dapatkan?")[cite: 1]
1. **Konsep Dasar yang Kuat:** Pahami materi dari dasar sampai mengerti alasan di balik setiap rumus[cite: 1].
2. **Teknik Berhitung Cepat:** Pelajari strategi hitung yang praktis, tepat, dan efisien (termasuk metode Jarimatika untuk TK & SD)[cite: 1].
3. **Latihan Soal MIPA:** Matematika, Fisika, Kimia, dan Biologi dengan latihan bertahap[cite: 1].

### B. Pembagian Jenjang & Materi Unggulan
1. **Jenjang TK & SD Awal (Program Jarimatika & Fondasi Berhitung):**
   - Pengenalan angka dan konsep bilangan secara visual.
   - Metode **Jarimatika** (berhitung cepat penjumlahan, pengurangan, perkalian, dan pembagian menggunakan jari tangan tanpa ketergantungan sempoa/kalkulator).
   - Melatih fokus, motorik halus, dan kepercayaan diri anak terhadap matematika sejak dini.
2. **Jenjang SD (Kelas 1 – 6 | Matematika & Sains Dasar):**
   - **Matematika:** Konsep dasar & operasi hitung, pecahan, desimal, bangun datar & geometri dasar, serta trik berhitung cepat[cite: 1].
   - **IPA Dasar:** Pengenalan konsep sains alam dan latihan soal cerita bertahap[cite: 1].
3. **Jenjang SMP (Kelas 7 – 9 | Bimbel MIPA & Persiapan Ujian):**[cite: 1]
   - **Matematika:**[cite: 1]
     - Konsep dasar & operasi hitung[cite: 1]
     - Aljabar, persamaan, perbandingan[cite: 1]
     - Geometri[cite: 1]
     - Trik berhitung cepat[cite: 1]
   - **IPA (Ilmu Pengetahuan Alam):**[cite: 1]
     - Fisika (rumus & analisis soal)[cite: 1]
     - Kimia (perhitungan & konsep)[cite: 1]
     - Biologi (konsep & penerapan)[cite: 1]
   - **Strategi Mengerjakan Soal:**[cite: 1]
     - Mengenali pola soal[cite: 1]
     - Memilih rumus yang tepat[cite: 1]
     - Menghindari kesalahan hitung[cite: 1]
     - Metode penyelesaian yang efisien[cite: 1]
   - **Persiapan Ujian:**[cite: 1]
     - Latihan soal bertahap (dasar - menantang)[cite: 1]
     - Persiapan ujian sekolah & seleksi masuk SMA[cite: 1]

---

## 3. Spesifikasi Fitur: Web Customer (Landing Page Publik `/`)
Halaman depan harus dirancang untuk memikat orang tua murid di area Cibinong dan sekitarnya agar mendaftarkan anaknya ikut *Free Trial Class*:

1. **Sticky Navbar Modern:** Logo MustikaBimbel[cite: 1], link navigasi *smooth-scroll* (Keunggulan, Program TK/SD/SMP, Tantangan 30 Detik, Jadwal, Lokasi), tombol "Cek Raport Siswa" (modal input kode siswa), dan tombol kuning mencolok "Daftar Coba Gratis".
2. **Hero Section Konversi Tinggi:**
   - Menampilkan badge *"Bimbel Jarimatika (TK-SD) & MIPA (SD-SMP) — Cibinong"*[cite: 1].
   - Headline utama *"Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!"*[cite: 1] dan deskripsi filosofi belajar[cite: 1].
   - Tombol CTA ke Formulir Trial & Tombol "Tes Kecepatan Hitung Anak (30 Detik)".
3. **Fitur Interaktif 1: Mini-Game "Tantangan Hitung Cepat 30 Detik" (Alpine.js):**
   - Pengunjung dapat memilih tingkat kesulitan:
     - *Level TK / SD Awal (Jarimatika Tambah & Kurang)*
     - *Level SD Atas / SMP (Hitung Cepat Kali, Bagi & Aljabar Dasar)*[cite: 1]
   - Timer berjalan 30 detik, menampilkan 5 soal berurutan dengan pilihan ganda / input cepat.
   - Di akhir permainan, munculkan skor, rata-rata detik per soal, dan tombol *"Simpan Skor & Klaim Kelas Coba Gratis"* yang otomatis mengisi skor tersebut ke form pendaftaran di bawah.
4. **Fitur Interaktif 2: Visualizer Metode Jarimatika & Strategi Soal:**
   - Seksi interaktif dengan tab simulasi yang memperlihatkan perbandingan "Cara Biasa yang Lama" vs "Metode Jarimatika / Trik Cepat MustikaBimbel (Selesai dalam 3 Detik!)"[cite: 1].
5. **Katalog Materi Unggulan (Interactive Filter Tabs: TK, SD, SMP):**
   - Menampilkan rincian materi Matematika, IPA, Strategi Mengerjakan Soal, dan Persiapan Ujian sesuai poster[cite: 1].
6. **Jadwal Belajar & Indikator Sisa Kursi Real-Time:**
   - Mengambil data langsung dari tabel `schedules` (Senin–Kamis 18.30–20.00, Sabtu 16.00–17.30, Minggu 18.30–20.00)[cite: 1].
   - Menampilkan progress bar kapasitas kelas dan label kelangkaan (contoh: *"Sisa 2 kursi lagi!"*).
7. **Formulir "Klaim Kelas Coba Gratis (Free Trial)" + Auto Redirect WA:**
   - Input: Nama Orang Tua, Nomor WhatsApp, Nama Anak, Jenjang (TK / SD / SMP), Sekolah Asal, Pilihan Program (Jarimatika / MIPA SD / MIPA SMP)[cite: 1], Pilihan Jadwal, dan Kendala Belajar Anak.
   - Saat dikirim: Data tersimpan ke tabel `trial_leads` di database, lalu pengguna diarahkan ke `https://wa.me/6287705555190?text=...`[cite: 1] dengan format pesan otomatis yang rapi.
8. **Seksi Lokasi & Peta Interaktif:**
   - Menampilkan alamat Perumahan Amarylis Garden, Jalan H Abdul Gani II Blok I No. 11, Harapan Jaya, Cibinong[cite: 1], jam operasional[cite: 1], dan tombol rute Google Maps.

---

## 4. Spesifikasi Fitur: Portal Orang Tua & E-Raport (`/raport/{portal_token}`)
Halaman khusus berdesain *Mobile-First* yang bisa dibuka langsung oleh orang tua dari link WhatsApp tanpa harus mengingat *username/password*:

1. **Kartu Identitas & Level Siswa:** Menampilkan nama siswa, kode induk, jenjang (TK/SD/SMP), program aktif, serta total kehadiran bulan berjalan.
2. **Pohon Progres Level Jarimatika & Kurikulum MIPA:**
   - Visualisasi tahapan belajar (Level 1 s/d Level 5 untuk Jarimatika, atau Bab penguasaan Konsep MIPA & Strategi Soal)[cite: 1].
3. **Grafik Perkembangan Belajar (Chart.js):**
   - Grafik tren peningkatan **Skor Latihan Soal (0–100)** dan **Rating Kecepatan Hitung (1–5)** dari waktu ke waktu.
4. **Timeline Jurnal Belajar Harian:**
   - Riwayat setiap pertemuan: Tanggal, jam datang-pulang, topik yang dipelajari, nilai latihan, dan catatan personal dari pengajar.
5. **Galeri Digital Badge / Sertifikat & Tombol Share WA Story:**
   - Menampilkan lencana pencapaian siswa (misal: *"Jagoan Jarimatika Level 1"*, *"Master Konsep Aljabar"*)[cite: 1].
   - Tombol **"Unduh Sertifikat Kebanggaan (PNG)"** menggunakan `html2canvas` lengkap dengan logo MustikaBimbel, slogan *"Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!"*, dan info kontak WA `087705555190` di bagian footer sertifikat[cite: 1].
6. **Informasi SPP & Kwitansi Digital:**
   - Menampilkan status SPP bulan berjalan (Lunas / Belum Lunas) dan tombol unduh Kwitansi Resmi (PDF).

---

## 5. Spesifikasi Fitur: Sistem Internal Admin & Pengajar (`/admin/...`)
Dilengkapi sistem autentikasi (`login`) untuk Pengelola/Pengajar MustikaBimbel[cite: 1]:

1. **Dashboard Eksekutif (`/admin/dashboard`):**
   - Ringkasan metrik: Total Siswa Aktif (TK, SD, SMP), Pendaftar Trial Baru yang belum dihubungi, Kehadiran Hari Ini, dan Total Pemasukan SPP Bulan Ini.
2. **CRM Pendaftar Trial (`/admin/leads`):**
   - Daftar calon siswa dari form Landing Page beserta skor mini-game mereka.
   - Tombol 1-Klik *"Follow-Up via WA"* dan tombol *"Konversi Jadi Siswa Resmi"* (otomatis memindahkan data ke tabel `students`).
3. **Manajemen Data Siswa & Kurikulum (`/admin/students`):**
   - CRUD data siswa, pengaturan level Jarimatika/MIPA, pemberian Digital Badge baru, dan tombol salin link Portal Orang Tua.
4. **Presensi 1-Klik & Jurnal Harian Kelas (`/admin/attendance`):**
   - Filter berdasarkan sesi jadwal (Senin–Kamis 18.30–20.00, Sabtu 16.00–17.30, Minggu 18.30–20.00)[cite: 1].
   - **Tombol "Hadir & WA Datang":** Mencatat jam tiba siswa dan langsung membuka tab WA ke nomor orang tua berisi info anak sudah tiba dengan aman di MustikaBimbel Amarylis Garden[cite: 1].
   - **Form Cepat "Jurnal & Nilai Hari Ini":** Mengisi materi hari ini, kategori (Jarimatika, Matematika, Fisika, Kimia, Biologi, Strategi Soal)[cite: 1], rating kecepatan hitung (1-5), skor latihan (0-100), dan catatan pengajar.
   - **Tombol "Kirim Laporan Pulang ke WA Ortu":** Membuka WA berisi rangkuman hasil belajar hari itu + link Portal Orang Tua.
5. **Manajemen Jadwal & Kuota Kelas (`/admin/schedules`):**
   - Mengatur kapasitas maksimal kursi per sesi jadwal agar indikator di halaman publik selalu akurat.
6. **Manajemen Tagihan SPP & Cetak Kwitansi (`/admin/invoices`):**
   - Generate tagihan SPP bulanan otomatis untuk seluruh siswa aktif, tandai lunas, kirim pengingat WA sopan ke orang tua, dan cetak Kwitansi PDF (`dompdf`).

