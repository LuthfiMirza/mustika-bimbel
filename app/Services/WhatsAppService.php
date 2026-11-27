<?php

namespace App\Services;

use App\Models\InvoicePayment;
use App\Models\Setting;
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
     * Format integer rupiah value.
     */
    public static function formatRupiah(int $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

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
     * Replace placeholders inside a WhatsApp template string.
     *
     * @param  array<string, string>  $replacements
     */
    public static function renderTemplate(string $template, array $replacements): string
    {
        return str_replace(array_keys($replacements), array_values($replacements), $template);
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
        $bimbelName = Setting::get('bimbel_name', 'MustikaBimbel');
        $adminWa = Setting::get('admin_whatsapp', self::OFFICIAL_WA_DISPLAY);
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

        $message = "Halo Admin *{$bimbelName}*! 👋\n"
            . "Saya ingin klaim *Kelas Coba Gratis (Free Trial)* untuk anak saya:\n\n"
            . "- *Nama Orang Tua:* {$lead->parent_name}\n"
            . "- *Nama Anak:* {$lead->student_name}\n"
            . "- *Jenjang / Sekolah:* {$lead->grade_level}" . ($lead->school_name ? " ({$lead->school_name})" : '') . "\n"
            . "- *Program Pilihan:* {$programName}\n"
            . "- *Jadwal Pilihan:* {$scheduleText}"
            . $obstacleInfo
            . $quizInfo . "\n\n"
            . "Mohon informasi jadwal sesi Trial terdekat di {$bimbelName}. Terima kasih! 🙏";

        return self::buildUrl($adminWa, $message);
    }

    /**
     * 2. Link WA untuk Follow-Up Calon Siswa Trial (Admin -> Orang Tua).
     */
    public static function generateLeadFollowUpUrl(TrialLead $lead): string
    {
        $bimbelName = Setting::get('bimbel_name', 'MustikaBimbel');
        $bimbelAddress = Setting::get('bimbel_address', 'Perumahan Amarylis Garden, Jl. H Abdul Gani II Blok I No. 11, Harapan Jaya, Cibinong');
        $programName = $lead->program?->name ?? 'Jarimatika & MIPA';

        $message = "Halo Bapak/Ibu *{$lead->parent_name}*, salam hangat dari *{$bimbelName}*! 🌟\n\n"
            . "Terima kasih telah mendaftarkan ananda *{$lead->student_name}* ({$lead->grade_level}) untuk mengikuti *Kelas Coba Gratis (Free Trial)* program *{$programName}*.\n\n"
            . "Lokasi belajar kami berada di:\n"
            . "📍 *{$bimbelAddress}*\n\n"
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
        $template = Setting::get('wa_template_arrival');

        $message = self::renderTemplate($template, [
            '{wali}' => $student->parent_name,
            '{siswa}' => $student->full_name,
            '{panggilan}' => $student->nickname ?: $student->full_name,
            '{tanggal}' => $dateFormatted,
            '{jam}' => $time,
            '{bimbel}' => Setting::get('bimbel_name', 'MustikaBimbel'),
            '{admin}' => Setting::get('admin_whatsapp', self::OFFICIAL_WA_DISPLAY),
        ]);

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
        $template = Setting::get('wa_template_report');

        $message = self::renderTemplate($template, [
            '{wali}' => $student->parent_name,
            '{siswa}' => $student->full_name,
            '{panggilan}' => $student->nickname ?: $student->full_name,
            '{tanggal}' => $dateFormatted,
            '{kategori}' => (string) $session->subject_category,
            '{topik}' => (string) $session->topic_covered,
            '{bintang}' => $stars,
            '{kecepatan}' => (string) $session->speed_rating,
            '{skor}' => (string) $session->practice_score,
            '{catatan}' => (string) ($session->tutor_notes ?? '-'),
            '{link_raport}' => $portalUrl,
            '{bimbel}' => Setting::get('bimbel_name', 'MustikaBimbel'),
            '{admin}' => Setting::get('admin_whatsapp', self::OFFICIAL_WA_DISPLAY),
        ]);

        return self::buildUrl($student->parent_whatsapp, $message);
    }

    /**
     * 5. Link WA Pengingat Tagihan SPP Sopan (Admin -> Orang Tua) memakai template dinamis.
     */
    public static function generateTuitionReminderUrl(TuitionInvoice $invoice, ?int $totalArrears = null): string
    {
        $student = $invoice->student;
        $remaining = max(0, (int) $invoice->amount - (int) ($invoice->paid_amount ?? 0));
        $arrears = $totalArrears ?? $student->total_arrears ?? $remaining;

        $template = Setting::get('wa_template_reminder');

        $message = self::renderTemplate($template, [
            '{wali}' => $student->parent_name,
            '{siswa}' => $student->full_name,
            '{kode_siswa}' => $student->student_code,
            '{no_tagihan}' => $invoice->invoice_number,
            '{bulan}' => $invoice->billing_period,
            '{tagihan}' => self::formatRupiah((int) $invoice->amount),
            '{sisa}' => self::formatRupiah($remaining),
            '{total_tunggakan}' => self::formatRupiah($arrears),
            '{jatuh_tempo}' => $invoice->due_date->translatedFormat('d F Y'),
            '{status}' => $invoice->status,
            '{pembayaran}' => Setting::get('payment_info', 'Transfer Bank / QRIS / Tunai di lokasi bimbel'),
            '{link_raport}' => url('/raport/' . $student->portal_token),
            '{bimbel}' => Setting::get('bimbel_name', 'MustikaBimbel'),
            '{admin}' => Setting::get('admin_whatsapp', self::OFFICIAL_WA_DISPLAY),
        ]);

        return self::buildUrl($student->parent_whatsapp, $message);
    }

    /**
     * 6. Link WA Terima Kasih / Kuitansi Pembayaran (baik Lunas maupun Cicilan).
     */
    public static function generatePaymentReceiptUrl(TuitionInvoice $invoice, ?InvoicePayment $payment = null): string
    {
        $student = $invoice->student;
        $remaining = max(0, (int) $invoice->amount - (int) ($invoice->paid_amount ?? 0));
        $paidAmount = $payment ? (int) $payment->amount : (int) ($invoice->paid_amount ?: $invoice->amount);
        $paidDate = $payment
            ? $payment->payment_date->translatedFormat('d F Y')
            : ($invoice->paid_at ? $invoice->paid_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y'));
        $receiptNo = $payment?->receipt_number ?? $invoice->invoice_number;
        $method = $payment?->payment_method ?? ($invoice->payment_method ?? 'Tunai');

        $template = Setting::get('wa_template_receipt');

        $message = self::renderTemplate($template, [
            '{wali}' => $student->parent_name,
            '{siswa}' => $student->full_name,
            '{kode_siswa}' => $student->student_code,
            '{bulan}' => $invoice->billing_period,
            '{jumlah}' => self::formatRupiah($paidAmount),
            '{tanggal}' => $paidDate,
            '{kuitansi}' => $receiptNo,
            '{metode}' => $method,
            '{status}' => $invoice->status,
            '{sisa}' => self::formatRupiah($remaining),
            '{link_raport}' => url('/raport/' . $student->portal_token),
            '{bimbel}' => Setting::get('bimbel_name', 'MustikaBimbel'),
            '{admin}' => Setting::get('admin_whatsapp', self::OFFICIAL_WA_DISPLAY),
        ]);

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
