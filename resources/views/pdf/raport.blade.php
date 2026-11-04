<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Raport Siswa - {{ $student->full_name }}</title>
    <style>
        @page {
            margin: 28px 32px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #1e293b;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #0F2C59;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .brand-title {
            font-size: 20px;
            font-weight: bold;
            color: #0F2C59;
            margin: 0;
            line-height: 1.1;
        }
        .brand-subtitle {
            font-size: 10px;
            color: #0D9488;
            font-weight: bold;
            margin-top: 2px;
        }
        .brand-address {
            font-size: 9px;
            color: #64748b;
            margin-top: 3px;
        }
        .report-badge {
            background-color: #0F2C59;
            color: #FACC15;
            padding: 4px 10px;
            font-size: 10px;
            font-weight: bold;
            text-align: right;
            border-radius: 4px;
        }
        .title-section {
            text-align: center;
            margin-bottom: 14px;
        }
        .report-heading {
            font-size: 14px;
            font-weight: bold;
            color: #0F2C59;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .student-table, .metrics-table, .sessions-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .student-table td {
            padding: 3px 6px;
            font-size: 10.5px;
        }
        .student-label {
            width: 18%;
            color: #475569;
            font-weight: bold;
        }
        .student-colon {
            width: 2%;
            text-align: center;
        }
        .student-val {
            width: 30%;
            color: #0F2C59;
            font-weight: bold;
        }
        .metrics-card {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 8px;
            text-align: center;
            border-radius: 6px;
        }
        .metrics-label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
        }
        .metrics-val {
            font-size: 15px;
            font-weight: bold;
            color: #0F2C59;
            margin-top: 2px;
        }
        .sessions-table th {
            background-color: #0F2C59;
            color: #ffffff;
            padding: 6px 8px;
            font-size: 10px;
            text-align: left;
        }
        .sessions-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9.5px;
            vertical-align: top;
        }
        .sessions-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .tag-cat {
            background-color: #e6fffa;
            color: #0d9488;
            font-weight: bold;
            padding: 1px 5px;
            border-radius: 3px;
            font-size: 9px;
        }
        .score-pill {
            font-weight: bold;
            color: #0F2C59;
            background-color: #fef08a;
            padding: 2px 6px;
            border-radius: 4px;
        }
        .signature-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .footer-note {
            font-size: 8.5px;
            color: #64748b;
            text-align: center;
            border-top: 1px dashed #cbd5e1;
            padding-top: 8px;
            margin-top: 16px;
        }
    </style>
</head>
<body>

    <!-- Header Instansi MustikaBimbel -->
    <table class="header-table">
        <tr>
            <td style="width: 70%; vertical-align: top;">
                <h1 class="brand-title">Mustika<span style="color: #eab308;">Bimbel</span></h1>
                <div class="brand-subtitle">Bimbel MIPA untuk Masa Depanmu &bull; Spesialis Jarimatika (TK-SD) &amp; MIPA (SD-SMP)</div>
                <div class="brand-address">
                    Perumahan Amarylis Garden, Jl. H Abdul Gani II Blok I No. 11, Harapan Jaya, Cibinong<br>
                    WhatsApp Resmi: 087705555190 &bull; Website: mustikabimbel.com
                </div>
            </td>
            <td style="width: 30%; text-align: right; vertical-align: top;">
                <div class="report-badge">E-RAPORT SISWA</div>
                <div style="font-size: 9px; color: #64748b; margin-top: 5px;">
                    Dicetak: {{ now()->translatedFormat('d F Y') }}<br>
                    Token: {{ $student->portal_token }}
                </div>
            </td>
        </tr>
    </table>

    <!-- Heading Raport -->
    <div class="title-section">
        <h2 class="report-heading">Laporan Hasil &amp; Perkembangan Belajar Siswa</h2>
        <div style="font-size: 10px; color: #475569; margin-top: 3px; font-weight: bold;">
            "Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!"
        </div>
    </div>

    <!-- Data Identitas Siswa -->
    <table class="student-table">
        <tr>
            <td class="student-label">Nama Siswa</td>
            <td class="student-colon">:</td>
            <td class="student-val">{{ $student->full_name }}</td>
            <td class="student-label">Jenjang / Kelas</td>
            <td class="student-colon">:</td>
            <td class="student-val">{{ $student->grade_level }} ({{ $student->class_number ?? 'Siswa Aktif' }})</td>
        </tr>
        <tr>
            <td class="student-label">Nomor Induk</td>
            <td class="student-colon">:</td>
            <td class="student-val">{{ $student->student_code }}</td>
            <td class="student-label">Sekolah Asal</td>
            <td class="student-colon">:</td>
            <td class="student-val">{{ $student->school_name ?? 'Cibinong' }}</td>
        </tr>
        <tr>
            <td class="student-label">Program Bimbel</td>
            <td class="student-colon">:</td>
            <td class="student-val">{{ $student->program->name ?? '-' }}</td>
            <td class="student-label">Orang Tua / Wali</td>
            <td class="student-colon">:</td>
            <td class="student-val">{{ $student->parent_name }}</td>
        </tr>
        <tr>
            <td class="student-label">Jadwal Sesi</td>
            <td class="student-colon">:</td>
            <td class="student-val">{{ $student->schedule->days_text ?? '-' }} ({{ $student->schedule->start_time ?? '' }}-{{ $student->schedule->end_time ?? '' }} WIB)</td>
            <td class="student-label">Status Siswa</td>
            <td class="student-colon">:</td>
            <td class="student-val">{{ $student->status }} (Bergabung: {{ $student->join_date->translatedFormat('d M Y') }})</td>
        </tr>
    </table>

    <!-- 4 Metrik Ringkasan Performa -->
    <table class="metrics-table">
        <tr>
            <td style="width: 25%; padding: 4px;">
                <div class="metrics-card">
                    <div class="metrics-label">Level Jarimatika</div>
                    <div class="metrics-val">Level {{ $student->jarimatika_level }} <span style="font-size: 10px; color:#64748b;">/ 6</span></div>
                </div>
            </td>
            <td style="width: 25%; padding: 4px;">
                <div class="metrics-card">
                    <div class="metrics-label">Penguasaan MIPA</div>
                    <div class="metrics-val" style="color: #0D9488;">{{ $student->mipa_mastery_percent }}%</div>
                </div>
            </td>
            <td style="width: 25%; padding: 4px;">
                <div class="metrics-card">
                    <div class="metrics-label">Rata-rata Skor</div>
                    <div class="metrics-val">{{ $averageScore }} <span style="font-size: 10px; color:#64748b;">/ 100</span></div>
                </div>
            </td>
            <td style="width: 25%; padding: 4px;">
                <div class="metrics-card">
                    <div class="metrics-label">Tingkat Kehadiran</div>
                    <div class="metrics-val">{{ $attendanceRate }}% <span style="font-size: 10px; color:#64748b;">({{ $attendedCount }}/{{ $totalSessions }})</span></div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Tabel Riwayat Pertemuan / Jurnal Belajar -->
    <div style="font-weight: bold; font-size: 11px; color: #0F2C59; margin-bottom: 6px;">
        Riwayat Jurnal Pertemuan Belajar:
    </div>
    <table class="sessions-table">
        <thead>
            <tr>
                <th style="width: 16%;">Tanggal</th>
                <th style="width: 14%;">Kategori</th>
                <th style="width: 32%;">Materi / Topik Pembelajaran</th>
                <th style="width: 12%; text-align: center;">Skor Latihan</th>
                <th style="width: 12%; text-align: center;">Kecepatan</th>
                <th style="width: 14%;">Catatan Pengajar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($student->studySessions as $session)
                <tr>
                    <td><strong>{{ $session->session_date->format('d/m/Y') }}</strong></td>
                    <td><span class="tag-cat">{{ $session->subject_category }}</span></td>
                    <td>{{ $session->topic_covered }}</td>
                    <td style="text-align: center;"><span class="score-pill">{{ $session->practice_score }}</span></td>
                    <td style="text-align: center; color: #b45309; font-weight: bold;">
                        {{ str_repeat('★', (int)$session->speed_rating) }} ({{ $session->speed_rating }}/5)
                    </td>
                    <td style="font-style: italic; color: #475569;">{{ $session->tutor_notes }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 12px; color: #94a3b8;">Belum ada riwayat pertemuan tercatat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Lembar Tanda Tangan -->
    <table class="signature-table">
        <tr>
            <td style="width: 60%; vertical-align: top; padding-right: 20px;">
                <div style="font-weight: bold; font-size: 10px; color: #0F2C59;">Catatan &amp; Evaluasi Pengajar:</div>
                <div style="font-size: 9.5px; color: #475569; margin-top: 4px; padding: 6px; background-color: #f8fafc; border-left: 3px solid #0F2C59;">
                    Ananda <strong>{{ $student->full_name }}</strong> menunjukkan antusiasme yang tinggi dalam memahami konsep dasar dan mempraktikkan trik berhitung cepat. Terus dampingi latihan soal di rumah agar kecepatan motorik jari dan penalaran konsep semakin matang.
                </div>
            </td>
            <td style="width: 40%; text-align: center; vertical-align: top;">
                <div style="font-size: 10px; color: #475569;">Cibinong, {{ now()->translatedFormat('d F Y') }}</div>
                <div style="font-size: 10px; font-weight: bold; color: #0F2C59; margin-top: 2px;">MustikaBimbel Cibinong</div>
                <div style="height: 48px; line-height: 48px; font-size: 11px; font-style: italic; color: #0D9488; font-weight: bold;">
                    [ Kak Mustika &amp; Tim ]
                </div>
                <div style="font-weight: bold; font-size: 10px; color: #0F2C59; border-top: 1px solid #cbd5e1; padding-top: 2px; width: 80%; margin: 0 auto;">
                    Pengajar Pembimbing
                </div>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        Dokumen ini diterbitkan secara elektronik oleh Sistem Informasi Akademik MustikaBimbel Cibinong melalui Portal Orang Tua.<br>
        Lokasi Belajar: Perumahan Amarylis Garden Blok I No. 11, Harapan Jaya, Cibinong. Kontak WhatsApp: 087705555190.
    </div>

</body>
</html>
