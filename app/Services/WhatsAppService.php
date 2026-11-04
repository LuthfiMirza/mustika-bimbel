<?php

namespace App\Services;

use App\Models\Student;
use App\Models\StudySession;
use App\Models\TrialLead;
use App\Models\TuitionInvoice;
use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    public const OFFICIAL_WA_NUMBER = '6287705555190';
    public const OFFICIAL_WA_DISPLAY = '087705555190';

    /**
     * Normalize Indonesian phone number to international format (628...).
     */
    public static function formatPhoneNumber(string $phone): string
    {
        $digits = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }

        if (str_starts_with($digits, '8')) {
            return '62' . $digits;
        }

        return $digits;
    }

    /**
     * Generate Click-to-Chat URL (https://wa.me/...).
     */
    public static function buildUrl(string $phone, string $message): string
    {
        $formattedPhone = self::formatPhoneNumber($phone);
        return 'https://wa.me/' . $formattedPhone . '?text=' . rawurlencode($message);
    }

    /**
     * 1. Link WA untuk Pendaftaran Free Trial dari Web Customer -> Admin MustikaBimbel.
     */
    public static function generateTrialRegistrationUrl(TrialLead $lead): string
    {
        $programName = $lead->program?->name ?? 'Program Pilihan';
        $scheduleText = $lead->schedule
            ? "{$lead->schedule->session_name} ({$lead->schedule->days_text}, {$lead->schedule->start_time}-{$lead->schedule->end_time} WIB)"
            : 'Fleksibel / Konsultasi Admin';

        $quizInfo = $lead->quiz_score !== null
            ? "\n- *Skor Tantangan 30 Detik:* {$lead->quiz_score}/100 (Rata-rata {$lead->quiz_avg_time} dtk/soal)"
            : '';

        $obstacleInfo = $lead->learning_obstacle
            ? "\n- *Kendala Belajar:* {$lead->learning_obstacle}"
            : '';

        $message = "Halo Admin *MustikaBimbel*! 👋\n"
            . "Saya ingin klaim *Kelas Coba Gratis (Free Trial)* untuk anak saya:\n\n"
            . "- *Nama Orang Tua:* {$lead->parent_name}\n"
            . "- *Nama Anak:* {$lead->student_name}\n"
            . "- *Jenjang / Sekolah:* {$lead->grade_level}" . ($lead->school_name ? " ({$lead->school_name})" : '') . "\n"
            . "- *Program Pilihan:* {$programName}\n"
            . "- *Jadwal Pilihan:* {$scheduleText}"
            . $obstacleInfo
            . $quizInfo . "\n\n"
            . "Mohon informasi jadwal sesi Trial terdekat di MustikaBimbel Amarylis Garden Cibinong. Terima kasih! 🙏";

        return self::buildUrl(self::OFFICIAL_WA_NUMBER, $message);
    }

    /**
     * 2. Link WA untuk Follow-Up Calon Siswa Trial (Admin -> Orang Tua).
     */
    public static function generateLeadFollowUpUrl(TrialLead $lead): string
    {
        $programName = $lead->program?->name ?? 'Jarimatika & MIPA';

        $message = "Halo Bapak/Ibu *{$lead->parent_name}*, salam hangat dari *MustikaBimbel Cibinong*! 🌟\n\n"
            . "Terima kasih telah mendaftarkan ananda *{$lead->student_name}* ({$lead->grade_level}) untuk mengikuti *Kelas Coba Gratis (Free Trial)* program *{$programName}*.\n\n"
            . "Lokasi belajar kami berada di:\n"
            . "📍 *Perumahan Amarylis Garden, Jl. H Abdul Gani II Blok I No. 11, Harapan Jaya, Cibinong*\n\n"
            . "Apakah ananda siap hadir pada jadwal terdekat minggu ini? Kami tunggu kehadirannya ya Bapak/Ibu! 🙏";

        return self::buildUrl($lead->whatsapp, $message);
    }

    /**
     * 3. Link WA Presensi Kedatangan Siswa (Admin/Pengajar -> Orang Tua).
     */
    public static function generateArrivalNotificationUrl(Student $student, StudySession $session): string
    {
        $time = $session->check_in_time ? substr($session->check_in_time, 0, 5) : now()->format('H:i');
        $dateFormatted = $session->session_date->translatedFormat('d F Y');

        $message = "Halo Bapak/Ibu *{$student->parent_name}* 👋\n\n"
            . "Menginformasikan bahwa ananda *{$student->full_name}* telah tiba dengan aman di *MustikaBimbel Amarylis Garden Cibinong* pada:\n"
            . "📅 Tanggal: *{$dateFormatted}*\n"
            . "⏰ Pukul: *{$time} WIB*\n\n"
            . "Selamat belajar ananda {$student->nickname}! *Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!* 🚀";

        return self::buildUrl($student->parent_whatsapp, $message);
    }

    /**
     * 4. Link WA Laporan Jurnal Pulang & Link E-Raport (Admin/Pengajar -> Orang Tua).
     */
    public static function generateStudyReportUrl(Student $student, StudySession $session): string
    {
        $portalUrl = url('/raport/' . $student->portal_token);
        $stars = str_repeat('⭐', max(1, (int) $session->speed_rating));
        $dateFormatted = $session->session_date->translatedFormat('d F Y');

        $message = "Halo Bapak/Ibu *{$student->parent_name}* 🌟\n"
            . "Berikut rangkuman hasil belajar ananda *{$student->full_name}* hari ini ({$dateFormatted}) di *MustikaBimbel*:\n\n"
            . "📚 *Kategori:* {$session->subject_category}\n"
            . "🎯 *Topik Materi:* {$session->topic_covered}\n"
            . "⚡ *Kecepatan Hitung:* {$stars} ({$session->speed_rating}/5)\n"
            . "💯 *Skor Latihan Soal:* {$session->practice_score}/100\n"
            . "📝 *Catatan Pengajar:* _{$session->tutor_notes}_\n\n"
            . "Lihat Grafik Perkembangan & E-Raport lengkap ananda melalui Portal Orang Tua:\n"
            . "🔗 {$portalUrl}\n\n"
            . "Terima kasih atas kerja samanya! 🙏";

        return self::buildUrl($student->parent_whatsapp, $message);
    }

    /**
     * 5. Link WA Pengingat Tagihan SPP Sopan (Admin -> Orang Tua).
     */
    public static function generateTuitionReminderUrl(TuitionInvoice $invoice): string
    {
        $student = $invoice->student;
        $amountFormatted = 'Rp ' . number_format($invoice->amount, 0, ',', '.');
        $dueDateFormatted = $invoice->due_date->translatedFormat('d F Y');
        $portalUrl = url('/raport/' . $student->portal_token);

        $message = "Halo Bapak/Ibu *{$student->parent_name}*, salam hangat dari *MustikaBimbel* 🙏\n\n"
            . "Izin menyampaikan informasi SPP bulanan untuk ananda *{$student->full_name}* ({$student->student_code}):\n\n"
            . "🧾 *No. Tagihan:* {$invoice->invoice_number}\n"
            . "🗓️ *Periode:* {$invoice->billing_period}\n"
            . "💳 *Nominal SPP:* *{$amountFormatted}*\n"
            . "⏳ *Jatuh Tempo:* {$dueDateFormatted}\n"
            . "📌 *Status:* {$invoice->status}\n\n"
            . "Detail tagihan & kwitansi resmi juga dapat diakses melalui Portal Orang Tua:\n"
            . "🔗 {$portalUrl}\n\n"
            . "Terima kasih banyak atas perhatian dan dukungannya terhadap semangat belajar ananda! 🌟";

        return self::buildUrl($student->parent_whatsapp, $message);
    }

    /**
     * Abstraksi pengiriman pesan otomatis via API Gateway (Fonnte / Wablas)
     * jika di masa mendatang diaktifkan pada file .env.
     */
    public static function sendViaGateway(string $phone, string $message): bool
    {
        $apiKey = env('FONNTE_API_KEY');
        if (empty($apiKey)) {
            return false;
        }

        $response = Http::withHeaders([
            'Authorization' => $apiKey,
        ])->post('https://api.fonnte.com/send', [
            'target' => self::formatPhoneNumber($phone),
            'message' => $message,
        ]);

        return $response->successful();
    }
}
