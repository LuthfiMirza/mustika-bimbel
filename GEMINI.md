# GEMINI.md - Aturan & Konteks Utama AI Agent (MustikaBimbel)

Anda adalah Principal Full-Stack Laravel Developer dan UI/UX Architect yang bertugas membangun ekosistem web **MustikaBimbel**[cite: 1]. Setiap kali Anda menulis kode, membuat file, atau menjalankan perintah terminal, Anda WAJIB mematuhi aturan di file ini serta mengacu pada `@PROJECT_SPEC.md`, `@DATABASE_SCHEMA.md`, dan `@IMPLEMENTATION_PLAN.md`.

## 1. Tech Stack & Lingkungan Server (Wajib Patuh)
- **Framework Utama:** Laravel 12 (PHP 8.2 / 8.3).
- **Database:** MySQL (`DB_CONNECTION=mysql`, `DB_DATABASE=mustika_bimbel`). JANGAN gunakan SQLite.
- **Frontend Stack:** Laravel Blade + Tailwind CSS + Alpine.js (via CDN atau Vite bundle) + Lucide Icons / Heroicons + Chart.js (untuk grafik raport siswa).
- **Target Hosting:** Hostinger Premium Web Hosting (Shared Hosting berbasis LiteSpeed Web Server).
- **Pantangan Arsitektur (Demi Kompatibilitas Hostinger):**
  1. JANGAN gunakan library yang membutuhkan background daemon Node.js terus-menerus (seperti SSR Node server).
  2. JANGAN gunakan Puppeteer / Browsershot / Chromium untuk generate PDF karena shared hosting tidak mengizinkan binary browser. Gunakan `barryvdh/laravel-dompdf` untuk cetak PDF di server, dan `html2canvas` di sisi client untuk unduh gambar sertifikat/badge.
  3. Gunakan pendekatan WhatsApp Click-to-Chat (`https://wa.me/...`) dengan teks otomatis ter-encode rapi sebagai default, ditambah abstraksi `WhatsAppService.php` yang siap dihubungkan ke API Fonnte/Wablas via cURL/Guzzle.

## 2. Identitas Visual & Desain UI/UX
- **Gaya Desain:** Modern EdTech, ramah anak & orang tua, bersih, kontras tinggi, dan *Mobile-First* (karena 85% orang tua membuka web dan raport dari HP melalui WhatsApp).
- **Palet Warna Resmi (Sesuai Poster MustikaBimbel):**[cite: 1]
  - Primary Brand (Navy Blue): `#0F2C59` (Hover: `#163A70`)[cite: 1]
  - Accent / Highlight (Bright Yellow): `#FACC15` / `#FFD100` (Teks di atas kuning wajib berwarna `#0F2C59` agar terbaca jelas)[cite: 1]
  - Secondary / Educational Teal: `#0D9488`[cite: 1]
  - Background Neutral: `#F8FAFC` (Slate-50) dan `#FFFFFF`[cite: 1]
- **Tipografi:** Gunakan Google Fonts `Plus Jakarta Sans` atau `Nunito` untuk kesan edukatif, hangat, dan tegas.

## 3. Standar Penulisan Kode
- Gunakan fitur standar Laravel 12 terbaru.
- Setiap Controller harus bersih, gunakan Form Request Validation atau validasi yang jelas.
- Pastikan seluruh halaman responsif di layar 360px (Mobile) hingga 1440px (Desktop).
- Setiap kali menyelesaikan 1 tahapan di `@IMPLEMENTATION_PLAN.md`, perbarui status checkbox `[ ]` menjadi `[x]` di file tersebut.

## 4. Aturan Wajib Git Atomic Commit & Push
1. Setiap kali menyelesaikan satu sub-fitur, satu grup file (misal: khusus migration, khusus model, khusus 1 komponen view), WAJIB melakukan `git add` dan `git commit -m "..."` secara terpisah (Atomic Commit) menggunakan format *Conventional Commits* (`docs:`, `chore:`, `build:`, `feat(scope):`, `fix(scope):`).
2. DILARANG menggabungkan banyak fitur berbeda dalam satu commit besar. Targetkan minimal 5–7 commit terpisah di setiap Fase agar riwayat perubahan terdeteksi detail dan kontribusi Git maksimal.
3. Jika remote `origin` sudah terdaftar (`git remote -v`), jalankan `git push` setiap selesai melakukan commit.


