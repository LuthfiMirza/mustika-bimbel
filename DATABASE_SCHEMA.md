# DATABASE_SCHEMA.md - Skema Database MySQL MustikaBimbel

Gunakan spesifikasi tabel di bawah ini untuk membuat Laravel Migrations, Eloquent Models, dan DatabaseSeeder.

## 1. Tabel `users` (Admin & Pengajar)
- `id` (bigint, PK)
- `name` (string)
- `email` (string, unique)
- `role` (enum: `'admin'`, `'tutor'`, default: `'admin'`)
- `password` (string)
- `timestamps`

## 2. Tabel `programs` (Program Bimbel)
- `id` (bigint, PK)
- `name` (string) — Contoh: "Jarimatika & Hitung Cepat (TK - SD)", "Bimbel MIPA SD", "Bimbel MIPA SMP & Persiapan Ujian"[cite: 1]
- `slug` (string, unique)
- `target_grade` (enum: `'TK'`, `'SD'`, `'SMP'`, `'TK-SD'`)
- `category` (enum: `'Jarimatika'`, `'MIPA'`, `'Intensif Ujian'`)[cite: 1]
- `highlights` (json) — Array poin-poin materi unggulan
- `monthly_fee` (unsignedInteger) — Biaya SPP bulanan dalam Rupiah (contoh: `250000`)
- `description` (text)
- `is_active` (boolean, default: `true`)
- `timestamps`

## 3. Tabel `schedules` (Slot Jadwal Belajar Resmi)
- `id` (bigint, PK)
- `program_id` (foreignId -> `programs.id`, cascadeOnDelete)
- `session_name` (string) — Contoh: "Reguler Malam (Senin - Kamis)", "Akhir Pekan Sabtu", "Akhir Pekan Minggu"[cite: 1]
- `days_text` (string) — Contoh: `"Senin - Kamis"`, `"Sabtu"`, `"Minggu"`[cite: 1]
- `start_time` (string) — Contoh: `"18:30"`, `"16:00"`, `"18:30"`[cite: 1]
- `end_time` (string) — Contoh: `"20:00"`, `"17:30"`, `"20:00"`[cite: 1]
- `max_quota` (unsignedTinyInteger, default: `10`)
- `filled_quota` (unsignedTinyInteger, default: `0`)
- `timestamps`

## 4. Tabel `trial_leads` (Pendaftar Kelas Coba dari Web Customer)
- `id` (bigint, PK)
- `parent_name` (string)
- `whatsapp` (string)
- `student_name` (string)
- `grade_level` (enum: `'TK'`, `'SD'`, `'SMP'`)
- `school_name` (string, nullable)
- `program_id` (foreignId -> `programs.id`, nullable)
- `schedule_id` (foreignId -> `schedules.id`, nullable)
- `learning_obstacle` (string, nullable) — Contoh: "Lambat berhitung", "Belum hafal perkalian", "Sulit paham soal Fisika/Aljabar"[cite: 1]
- `quiz_score` (unsignedTinyInteger, nullable) — Skor dari Mini-Game 30 Detik (0-100)
- `quiz_avg_time` (decimal(4,1), nullable) — Rata-rata detik menjawab soal
- `status` (enum: `'Baru'`, `'Dihubungi'`, `'Sudah Trial'`, `'Daftar Resmi'`, `'Batal'`, default: `'Baru'`)
- `admin_notes` (text, nullable)
- `timestamps`

## 5. Tabel `students` (Data Siswa Aktif)
- `id` (bigint, PK)
- `student_code` (string, unique) — Format: `MB-2026-001`
- `portal_token` (string, unique, index) — Token unik 16 karakter untuk URL `/raport/{portal_token}`
- `full_name` (string)
- `nickname` (string, nullable)
- `grade_level` (enum: `'TK'`, `'SD'`, `'SMP'`)
- `class_number` (string, nullable) — Contoh: `"TK B"`, `"Kelas 4 SD"`, `"Kelas 8 SMP"`
- `school_name` (string, nullable)
- `parent_name` (string)
- `parent_whatsapp` (string) — Disimpan dalam format `628...`
- `address` (text, nullable)
- `program_id` (foreignId -> `programs.id`)
- `schedule_id` (foreignId -> `schedules.id`)
- `jarimatika_level` (unsignedTinyInteger, default: `1`) — Level 1 s/d 6
- `mipa_mastery_percent` (unsignedTinyInteger, default: `20`) — Persentase penguasaan kurikulum (0-100)
- `join_date` (date)
- `status` (enum: `'Aktif'`, `'Cuti'`, `'Lulus'`, default: `'Aktif'`)
- `timestamps`

## 6. Tabel `attendances` & `study_journals` (Digabung atau Relasi 1-to-1 di `study_sessions`)
Buat tabel `study_sessions` agar presensi dan jurnal belajar harian tersimpan rapi dalam satu baris per pertemuan:
- `id` (bigint, PK)
- `student_id` (foreignId -> `students.id`, cascadeOnDelete)
- `schedule_id` (foreignId -> `schedules.id`, nullable)
- `session_date` (date, index)
- `check_in_time` (time, nullable)
- `check_out_time` (time, nullable)
- `attendance_status` (enum: `'Hadir'`, `'Izin'`, `'Sakit'`, `'Alpha'`, default: `'Hadir'`)
- `subject_category` (enum: `'Jarimatika'`, `'Matematika'`, `'Fisika'`, `'Kimia'`, `'Biologi'`, `'Strategi Soal'`, `'Persiapan Ujian'`, nullable)[cite: 1]
- `topic_covered` (string, nullable) — Contoh: "Jarimatika Perkalian 6-9" atau "Persamaan Aljabar & Perbandingan"[cite: 1]
- `speed_rating` (unsignedTinyInteger, nullable) — Skala 1 sampai 5 bintang
- `practice_score` (unsignedTinyInteger, nullable) — Nilai latihan soal 0 sampai 100
- `tutor_notes` (text, nullable) — Catatan perkembangan anak untuk orang tua
- `wa_arrival_sent` (boolean, default: `false`)
- `wa_report_sent` (boolean, default: `false`)
- `timestamps`

## 7. Tabel `student_badges` (Gamifikasi & Sertifikat Anak)
- `id` (bigint, PK)
- `student_id` (foreignId -> `students.id`, cascadeOnDelete)
- `badge_title` (string) — Contoh: "Master Jarimatika Penjumlahan Cepat", "Bintang Aljabar & Geometri"[cite: 1]
- `badge_category` (string) — Contoh: "Kecepatan Hitung", "Pemahaman Konsep", "Latihan Soal"[cite: 1]
- `badge_icon` (string, default: `'trophy'`)
- `description` (string)
- `awarded_date` (date)
- `timestamps`

## 8. Tabel `tuition_invoices` (Tagihan SPP Bulanan)
- `id` (bigint, PK)
- `invoice_number` (string, unique) — Format: `INV-MB-202611-001`
- `student_id` (foreignId -> `students.id`, cascadeOnDelete)
- `billing_period` (string) — Contoh: `"November 2026"`
- `amount` (unsignedInteger)
- `due_date` (date)
- `status` (enum: `'Belum Lunas'`, `'Lunas'`, default: `'Belum Lunas'`)
- `paid_at` (datetime, nullable)
- `payment_method` (string, nullable) — Contoh: `"Transfer Bank"`, `"QRIS / E-Wallet"`, `"Tunai"`
- `notes` (string, nullable)
- `timestamps`

