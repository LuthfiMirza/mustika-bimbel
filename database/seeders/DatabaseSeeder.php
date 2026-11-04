<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudentBadge;
use App\Models\StudySession;
use App\Models\TrialLead;
use App\Models\TuitionInvoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin & Pengajar Users
        User::create([
            'name' => 'Admin MustikaBimbel',
            'email' => 'admin@mustikabimbel.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Kak Mustika (Pengajar MIPA & Jarimatika)',
            'email' => 'tutor@mustikabimbel.com',
            'role' => 'tutor',
            'password' => Hash::make('password'),
        ]);

        // 2. Tiga Program Utama MustikaBimbel
        $programJarimatika = Program::create([
            'name' => 'Jarimatika & Hitung Cepat (TK - SD)',
            'slug' => 'jarimatika-hitung-cepat-tk-sd',
            'target_grade' => 'TK-SD',
            'category' => 'Jarimatika',
            'highlights' => [
                'Pengenalan angka & konsep bilangan visual tanpa menghafal buta',
                'Metode Jarimatika: Penjumlahan & Pengurangan cepat dengan jari tangan',
                'Jarimatika Perkalian & Pembagian praktis tanpa ketergantungan sempoa/kalkulator',
                'Melatih fokus, motorik halus, dan rasa percaya diri terhadap Matematika sejak dini',
            ],
            'monthly_fee' => 200000,
            'description' => 'Program fondasi berhitung cepat menggunakan metode Jarimatika untuk anak usia TK hingga SD awal agar mencintai angka dan terampil berhitung dalam hitungan detik.',
            'is_active' => true,
        ]);

        $programMipaSd = Program::create([
            'name' => 'Bimbel MIPA SD (Kelas 1 - 6)',
            'slug' => 'bimbel-mipa-sd',
            'target_grade' => 'SD',
            'category' => 'MIPA',
            'highlights' => [
                'Matematika: Konsep dasar & operasi hitung, pecahan, desimal, bangun datar & geometri dasar',
                'Trik Berhitung Cepat untuk efisiensi waktu pengerjaan soal sekolah',
                'IPA Dasar: Pengenalan konsep sains alam yang aplikatif & menyenangkan',
                'Latihan Soal Cerita bertahap (mengubah kalimat cerita menjadi model matematika)',
            ],
            'monthly_fee' => 250000,
            'description' => 'Pendampingan intensif Matematika & Sains Dasar untuk siswa SD Kelas 1–6 dengan pendekatan pemahaman konsep yang kuat dan latihan soal bertahap.',
            'is_active' => true,
        ]);

        $programMipaSmp = Program::create([
            'name' => 'Bimbel MIPA SMP & Persiapan Ujian (Kelas 7 - 9)',
            'slug' => 'bimbel-mipa-smp-persiapan-ujian',
            'target_grade' => 'SMP',
            'category' => 'Intensif Ujian',
            'highlights' => [
                'Matematika: Konsep dasar & operasi hitung, Aljabar, Persamaan, Perbandingan, Geometri & Trik Cepat',
                'IPA Terpadu: Fisika (rumus & analisis soal), Kimia (perhitungan & konsep), Biologi (konsep & penerapan)',
                'Strategi Mengerjakan Soal: Mengenali pola soal, memilih rumus tepat, menghindari salah hitung',
                'Persiapan Ujian: Latihan bertahap (dasar - menantang) untuk Ujian Sekolah & Seleksi Masuk SMA Favorit',
            ],
            'monthly_fee' => 300000,
            'description' => 'Program komprehensif MIPA SMP untuk menguasai konsep Matematika, Fisika, Kimia, dan Biologi sekaligus strategi taktis menyelesaikan soal ujian secara cepat dan tepat.',
            'is_active' => true,
        ]);

        // 3. Tiga Jadwal Resmi MustikaBimbel (Sesuai Poster)
        $scheduleSeninKamis = Schedule::create([
            'program_id' => $programMipaSmp->id,
            'session_name' => 'Reguler Malam (Senin – Kamis)',
            'days_text' => 'Senin – Kamis',
            'start_time' => '18:30',
            'end_time' => '20:00',
            'max_quota' => 10,
            'filled_quota' => 8, // Sisa 2 kursi lagi!
        ]);

        $scheduleSabtu = Schedule::create([
            'program_id' => $programJarimatika->id,
            'session_name' => 'Kelas Sore Akhir Pekan (Sabtu)',
            'days_text' => 'Sabtu',
            'start_time' => '16:00',
            'end_time' => '17:30',
            'max_quota' => 10,
            'filled_quota' => 7, // Sisa 3 kursi lagi!
        ]);

        $scheduleMinggu = Schedule::create([
            'program_id' => $programMipaSd->id,
            'session_name' => 'Kelas Malam Akhir Pekan (Minggu)',
            'days_text' => 'Minggu',
            'start_time' => '18:30',
            'end_time' => '20:00',
            'max_quota' => 10,
            'filled_quota' => 6, // Sisa 4 kursi lagi!
        ]);

        // 4. Empat Siswa Dummy (TK, SD, SMP) beserta Portal Token
        $studentsData = [
            [
                'student_code' => 'MB-2026-001',
                'portal_token' => 'raport-aisyah-01',
                'full_name' => 'Aisyah Putri Rahmawati',
                'nickname' => 'Aisyah',
                'grade_level' => 'TK',
                'class_number' => 'TK B',
                'school_name' => 'TK Islam Al-Azhar Cibinong',
                'parent_name' => 'Ibu Rina Kartika',
                'parent_whatsapp' => '6281234567801',
                'address' => 'Perumahan Amarylis Garden Blok C No. 4, Harapan Jaya, Cibinong',
                'program_id' => $programJarimatika->id,
                'schedule_id' => $scheduleSabtu->id,
                'jarimatika_level' => 3,
                'mipa_mastery_percent' => 65,
                'join_date' => '2026-08-10',
                'status' => 'Aktif',
                'sessions' => [
                    ['days_ago' => 28, 'cat' => 'Jarimatika', 'topic' => 'Pengenalan Formasi Jari Tangan Kanan (Satuan 1-9)', 'speed' => 3, 'score' => 75, 'notes' => 'Ananda Aisyah sangat antusias mengenal angka menggunakan jari tangan kanan.'],
                    ['days_ago' => 21, 'cat' => 'Jarimatika', 'topic' => 'Jarimatika Penjumlahan Tanpa Simpan (1-20)', 'speed' => 3, 'score' => 82, 'notes' => 'Gerakan jari mulai luwes, sudah tidak bingung membedakan formasi angka 5 dan 6.'],
                    ['days_ago' => 14, 'cat' => 'Jarimatika', 'topic' => 'Jarimatika Penjumlahan & Pengurangan Teman Kecil', 'speed' => 4, 'score' => 88, 'notes' => 'Luar biasa! Aisyah berhasil menyelesaikan 10 soal tambah-kurang dalam waktu kurang dari 2 menit.'],
                    ['days_ago' => 7, 'cat' => 'Jarimatika', 'topic' => 'Kombinasi Tambah Kurang Puluhan (Tangan Kiri & Kanan)', 'speed' => 5, 'score' => 94, 'notes' => 'Koordinasi tangan kanan (satuan) dan kiri (puluhan) sangat rapi dan cepat.'],
                    ['days_ago' => 1, 'cat' => 'Jarimatika', 'topic' => 'Evaluasi Level 3: Hitung Cepat Berantai 3 Bilangan', 'speed' => 5, 'score' => 98, 'notes' => 'Sangat membanggakan! Aisyah siap naik ke Level 4 bulan depan.'],
                ],
                'badges' => [
                    ['title' => 'Jagoan Jarimatika Level 1-3', 'cat' => 'Kecepatan Hitung', 'icon' => 'zap', 'desc' => 'Berhasil menguasai formasi jari satuan dan puluhan serta menyelesaikan soal hitung berantai di bawah 3 detik/soal.'],
                    ['title' => 'Bintang Fokus & Percaya Diri', 'cat' => 'Pemahaman Konsep', 'icon' => 'star', 'desc' => 'Selalu aktif menjawab tantangan berhitung cepat di depan kelas dengan penuh percaya diri.'],
                ],
            ],
            [
                'student_code' => 'MB-2026-002',
                'portal_token' => 'raport-raffa-002',
                'full_name' => 'Muhammad Raffa Pratama',
                'nickname' => 'Raffa',
                'grade_level' => 'SD',
                'class_number' => 'Kelas 4 SD',
                'school_name' => 'SDN Harapan Jaya 01 Cibinong',
                'parent_name' => 'Bapak Hendra Pratama',
                'parent_whatsapp' => '6281234567802',
                'address' => 'Perumahan Amarylis Garden Blok F No. 12, Harapan Jaya, Cibinong',
                'program_id' => $programMipaSd->id,
                'schedule_id' => $scheduleMinggu->id,
                'jarimatika_level' => 5,
                'mipa_mastery_percent' => 82,
                'join_date' => '2026-07-15',
                'status' => 'Aktif',
                'sessions' => [
                    ['days_ago' => 28, 'cat' => 'Jarimatika', 'topic' => 'Trik Jarimatika Perkalian 6 sampai 9', 'speed' => 3, 'score' => 72, 'notes' => 'Awalnya masih menghafal perkalian, kini mulai paham konsep jari dilipat dan berdiri.'],
                    ['days_ago' => 21, 'cat' => 'Matematika', 'topic' => 'Operasi Hitung Pecahan & Desimal Cepat', 'speed' => 4, 'score' => 80, 'notes' => 'Sudah mengerti cara menyamakan penyebut pecahan dengan KPK secara praktis.'],
                    ['days_ago' => 14, 'cat' => 'Matematika', 'topic' => 'Keliling & Luas Bangun Datar Gabungan', 'speed' => 4, 'score' => 86, 'notes' => 'Konsep dasar geometri sangat kuat, mampu membagi bangun gabungan menjadi persegi dan segitiga.'],
                    ['days_ago' => 7, 'cat' => 'Strategi Soal', 'topic' => 'Bedah Soal Cerita Matematika & Sains SD', 'speed' => 5, 'score' => 92, 'notes' => 'Raffa semakin teliti membaca kata kunci soal cerita tanpa terjebak pengecoh.'],
                    ['days_ago' => 1, 'cat' => 'Matematika', 'topic' => 'Simulasi Ujian Harian Pecahan, Desimal & Geometri', 'speed' => 5, 'score' => 96, 'notes' => 'Peningkatan luar biasa! Kecepatan hitung perkalian dan pembagian Raffa sangat membantu saat ujian.'],
                ],
                'badges' => [
                    ['title' => 'Master Jarimatika Perkalian 6-9', 'cat' => 'Kecepatan Hitung', 'icon' => 'trophy', 'desc' => 'Menuntaskan tantangan 20 soal perkalian angka besar menggunakan metode Jarimatika dengan akurasi 100%.'],
                    ['title' => 'Penakluk Soal Cerita Pecahan', 'cat' => 'Latihan Soal', 'icon' => 'award', 'desc' => 'Mampu menerjemahkan soal cerita pecahan & desimal menjadi langkah penyelesaian yang rapi dan tepat.'],
                ],
            ],
            [
                'student_code' => 'MB-2026-003',
                'portal_token' => 'raport-kevin-003',
                'full_name' => 'Kevin Alvaro Wijaya',
                'nickname' => 'Kevin',
                'grade_level' => 'SMP',
                'class_number' => 'Kelas 8 SMP',
                'school_name' => 'SMPN 1 Cibinong',
                'parent_name' => 'Ibu Dewi Sartika',
                'parent_whatsapp' => '6281234567803',
                'address' => 'Jl. H Abdul Gani II, Harapan Jaya, Cibinong',
                'program_id' => $programMipaSmp->id,
                'schedule_id' => $scheduleSeninKamis->id,
                'jarimatika_level' => 6,
                'mipa_mastery_percent' => 88,
                'join_date' => '2026-06-20',
                'status' => 'Aktif',
                'sessions' => [
                    ['days_ago' => 16, 'cat' => 'Matematika', 'topic' => 'Persamaan Garis Lurus & Sistem Persamaan Linear Dua Variabel (SPLDV)', 'speed' => 3, 'score' => 76, 'notes' => 'Pemahaman konsep eliminasi dan substitusi sudah baik, perlu latihan ketelitian tanda minus.'],
                    ['days_ago' => 12, 'cat' => 'Fisika', 'topic' => 'Hukum Newton tentang Gerak, Gaya & Tekanan Zat', 'speed' => 4, 'score' => 84, 'notes' => 'Kevin berhasil memahami alasan di balik rumus F = m.a melalui diagram bebas gaya.'],
                    ['days_ago' => 8, 'cat' => 'Kimia', 'topic' => 'Partikel Materi: Atom, Ion, Molekul & Perhitungan Dasar', 'speed' => 4, 'score' => 89, 'notes' => 'Cepat menangkap konsep nomor atom dan nomor massa serta konfigurasi elektron dasar.'],
                    ['days_ago' => 4, 'cat' => 'Biologi', 'topic' => 'Sistem Pencernaan & Sistem Peredaran Darah Manusia', 'speed' => 5, 'score' => 93, 'notes' => 'Menguasai mekanisme enzim pencernaan menggunakan peta konsep visual.'],
                    ['days_ago' => 1, 'cat' => 'Strategi Soal', 'topic' => 'Trik Efisien Menyelesaikan Soal Aljabar & Fisika tanpa Salah Hitung', 'speed' => 5, 'score' => 95, 'notes' => 'Waktu pengerjaan soal latihan MIPA meningkat 40% lebih cepat dengan akurasi tinggi!'],
                ],
                'badges' => [
                    ['title' => 'Master Konsep Aljabar & SPLDV', 'cat' => 'Pemahaman Konsep', 'icon' => 'award', 'desc' => 'Menguasai pemodelan persamaan aljabar dan mampu menyelesaikan soal HOTS dengan langkah yang efisien.'],
                    ['title' => 'Analis Fisika & Sains Terbaik', 'cat' => 'Latihan Soal', 'icon' => 'trophy', 'desc' => 'Tepat memilih rumus Fisika dan teliti dalam satuan serta perhitungan angka desimal.'],
                ],
            ],
            [
                'student_code' => 'MB-2026-004',
                'portal_token' => 'raport-nadia-004',
                'full_name' => 'Nadia Shafira Maharani',
                'nickname' => 'Nadia',
                'grade_level' => 'SMP',
                'class_number' => 'Kelas 9 SMP',
                'school_name' => 'SMPIT Al-Madinah Cibinong',
                'parent_name' => 'Bapak Arif Budiman',
                'parent_whatsapp' => '6281234567804',
                'address' => 'Perumahan Amarylis Garden Blok I No. 5, Harapan Jaya, Cibinong',
                'program_id' => $programMipaSmp->id,
                'schedule_id' => $scheduleSeninKamis->id,
                'jarimatika_level' => 6,
                'mipa_mastery_percent' => 92,
                'join_date' => '2026-05-10',
                'status' => 'Aktif',
                'sessions' => [
                    ['days_ago' => 15, 'cat' => 'Matematika', 'topic' => 'Persamaan Kuadrat, Fungsi Kuadrat & Transformasi Geometri', 'speed' => 4, 'score' => 80, 'notes' => 'Trik pemfaktoran cepat sangat membantu Nadia menentukan akar-akar persamaan kuadrat.'],
                    ['days_ago' => 11, 'cat' => 'Fisika', 'topic' => 'Listrik Statis & Rangkaian Listrik Dinamis (Hukum Ohm & Kirchhoff)', 'speed' => 4, 'score' => 86, 'notes' => 'Analisis hambatan seri-paralel sangat rapi, tidak tertukar lagi saat menghitung arus cabang.'],
                    ['days_ago' => 7, 'cat' => 'Biologi', 'topic' => 'Pewarisan Sifat (Hukum Mendel: Persilangan Monohibrid & Dihibrid)', 'speed' => 5, 'score' => 91, 'notes' => 'Mampu menentukan rasio fenotipe dan genotipe F2 dengan metode garpu secara cepat.'],
                    ['days_ago' => 3, 'cat' => 'Kimia', 'topic' => 'Reaksi Kimia, Asam Basa & Perhitungan Kadar Zat', 'speed' => 5, 'score' => 94, 'notes' => 'Konsep penyetaraan reaksi kimia sudah sangat dikuasai.'],
                    ['days_ago' => 1, 'cat' => 'Persiapan Ujian', 'topic' => 'Tryout Intensif Ujian Sekolah & Seleksi Masuk SMA Negeri Favorit', 'speed' => 5, 'score' => 97, 'notes' => 'Nilai Tryout MIPA Nadia meraih peringkat tertinggi bulan ini. Pertahankan semangatnya!'],
                ],
                'badges' => [
                    ['title' => 'Juara Tryout Persiapan Masuk SMA', 'cat' => 'Latihan Soal', 'icon' => 'trophy', 'desc' => 'Meraih skor 97/100 pada simulasi Ujian Sekolah & Seleksi Masuk SMA bidang Matematika & IPA.'],
                    ['title' => 'Bintang Strategi MIPA Efisien', 'cat' => 'Kecepatan Hitung', 'icon' => 'zap', 'desc' => 'Menguasai teknik mengenali pola soal dan memilih rumus paling efisien tanpa kesalahan hitung.'],
                ],
            ],
        ];

        foreach ($studentsData as $index => $data) {
            $sessions = $data['sessions'];
            $badges = $data['badges'];
            unset($data['sessions'], $data['badges']);

            $student = Student::create($data);

            // Buat 5 Riwayat StudySession untuk masing-masing siswa
            foreach ($sessions as $sessionData) {
                $sessionDate = Carbon::now()->subDays($sessionData['days_ago'])->toDateString();

                StudySession::create([
                    'student_id' => $student->id,
                    'schedule_id' => $student->schedule_id,
                    'session_date' => $sessionDate,
                    'check_in_time' => $student->schedule_id === $scheduleSabtu->id ? '15:55:00' : '18:25:00',
                    'check_out_time' => $student->schedule_id === $scheduleSabtu->id ? '17:30:00' : '20:00:00',
                    'attendance_status' => 'Hadir',
                    'subject_category' => $sessionData['cat'],
                    'topic_covered' => $sessionData['topic'],
                    'speed_rating' => $sessionData['speed'],
                    'practice_score' => $sessionData['score'],
                    'tutor_notes' => $sessionData['notes'],
                    'wa_arrival_sent' => true,
                    'wa_report_sent' => true,
                ]);
            }

            // Buat StudentBadges
            foreach ($badges as $bIndex => $badgeData) {
                StudentBadge::create([
                    'student_id' => $student->id,
                    'badge_title' => $badgeData['title'],
                    'badge_category' => $badgeData['cat'],
                    'badge_icon' => $badgeData['icon'],
                    'description' => $badgeData['desc'],
                    'awarded_date' => Carbon::now()->subDays(10 - ($bIndex * 5))->toDateString(),
                ]);
            }

            // Buat TuitionInvoices (Bulan Lalu Lunas & Bulan Berjalan)
            $fee = $student->program->monthly_fee;
            $numPad = str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT);

            TuitionInvoice::create([
                'invoice_number' => "INV-MB-202610-{$numPad}",
                'student_id' => $student->id,
                'billing_period' => 'Oktober 2026',
                'amount' => $fee,
                'due_date' => '2026-10-10',
                'status' => 'Lunas',
                'paid_at' => Carbon::parse('2026-10-08 14:30:00'),
                'payment_method' => 'Transfer Bank',
                'notes' => 'Pembayaran SPP Oktober tepat waktu. Terima kasih!',
            ]);

            TuitionInvoice::create([
                'invoice_number' => "INV-MB-202611-{$numPad}",
                'student_id' => $student->id,
                'billing_period' => 'November 2026',
                'amount' => $fee,
                'due_date' => '2026-11-10',
                'status' => $index < 3 ? 'Lunas' : 'Belum Lunas',
                'paid_at' => $index < 3 ? Carbon::now()->subDays(2) : null,
                'payment_method' => $index < 3 ? 'QRIS / E-Wallet' : null,
                'notes' => $index < 3 ? 'Lunas via QRIS MustikaBimbel.' : 'Tagihan SPP bulan berjalan November 2026.',
            ]);
        }

        // 5. Data Calon Siswa (Trial Leads) dari Web Customer
        TrialLead::create([
            'parent_name' => 'Ibu Sarah Wijaya',
            'whatsapp' => '6281398765432',
            'student_name' => 'Danish Arsenio',
            'grade_level' => 'TK',
            'school_name' => 'TK Harapan Bangsa Cibinong',
            'program_id' => $programJarimatika->id,
            'schedule_id' => $scheduleSabtu->id,
            'learning_obstacle' => 'Masih menghitung lambat satu per satu dan ingin belajar Jarimatika sejak TK',
            'quiz_score' => 80,
            'quiz_avg_time' => 4.2,
            'status' => 'Baru',
            'admin_notes' => 'Menunggu konfirmasi kehadiran kelas coba Sabtu sore.',
        ]);

        TrialLead::create([
            'parent_name' => 'Bapak Bambang Suryono',
            'whatsapp' => '6281287654321',
            'student_name' => 'Farel Aditya',
            'grade_level' => 'SMP',
            'school_name' => 'SMPN 2 Cibinong',
            'program_id' => $programMipaSmp->id,
            'schedule_id' => $scheduleSeninKamis->id,
            'learning_obstacle' => 'Sulit memahami rumus Fisika dan sering kurang teliti di soal Aljabar',
            'quiz_score' => 60,
            'quiz_avg_time' => 5.8,
            'status' => 'Baru',
            'admin_notes' => 'Skor mini-game 60/100, sangat potensial untuk dibimbing di kelas Reguler Malam.',
        ]);

        TrialLead::create([
            'parent_name' => 'Ibu Maya Lestari',
            'whatsapp' => '6285712340987',
            'student_name' => 'Kirana Larasati',
            'grade_level' => 'SD',
            'school_name' => 'SDIT Al-Nur Cibinong',
            'program_id' => $programMipaSd->id,
            'schedule_id' => $scheduleMinggu->id,
            'learning_obstacle' => 'Belum lancar perkalian 6-9 dan kesulitan menyelesaikan soal cerita pecahan',
            'quiz_score' => 80,
            'quiz_avg_time' => 3.6,
            'status' => 'Dihubungi',
            'admin_notes' => 'Sudah dihubungi via WA, dijadwalkan hadir trial hari Minggu pukul 18.30 WIB.',
        ]);
    }
}
