<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudySession;
use App\Models\TrialLead;
use App\Models\TuitionInvoice;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SystemAuditTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        if (User::count() === 0) {
            $this->seed(DatabaseSeeder::class);
        }
    }

    /**
     * Audit Fase 1: Database Seeder, Models & Eloquent Relationships
     */
    public function test_phase_1_database_models_and_eloquent_relationships(): void
    {
        $this->assertGreaterThanOrEqual(2, User::count());
        $this->assertEquals(3, Program::count());
        $this->assertEquals(3, Schedule::count());
        $this->assertGreaterThanOrEqual(4, Student::count());
        $this->assertGreaterThanOrEqual(20, StudySession::count());

        $student = Student::where('student_code', 'MB-2026-001')->firstOrFail();

        $this->assertNotNull($student->program);
        $this->assertNotNull($student->schedule);
        $this->assertGreaterThan(0, $student->studySessions->count());
        $this->assertGreaterThan(0, $student->badges->count());
        $this->assertGreaterThan(0, $student->invoices->count());
        $this->assertGreaterThan(0, $student->tuitionInvoices->count());
    }

    /**
     * Audit Fase 2 (1): GET / Landing Page loads with all 5 key sections
     */
    public function test_phase_2_landing_page_loads_with_all_core_sections(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // Hero & 3 Pillars
        $response->assertSee('Bimbel MIPA untuk Masa Depanmu');
        $response->assertSee('Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!');
        // Mini-Game 30 Detik
        $response->assertSee('Tantangan Hitung Cepat 30 Detik');
        // Katalog Program TK / SD / SMP
        $response->assertSee('Jarimatika & Hitung Cepat (TK - SD)');
        $response->assertSee('Bimbel MIPA SD (Kelas 1 - 6)');
        $response->assertSee('Bimbel MIPA SMP & Persiapan Ujian (Kelas 7 - 9)');
        // Jadwal Real-Time
        $response->assertSee('18:30');
        $response->assertSee('16:00');
        // Lokasi Amarylis Garden
        $response->assertSee('Amarylis Garden');
        $response->assertSee('Cibinong');
    }

    /**
     * Audit Fase 2 (2): POST /daftar-trial stores lead with quiz_score and redirects to WhatsApp
     */
    public function test_phase_2_store_trial_lead_and_redirect_to_whatsapp(): void
    {
        $program = Program::firstOrFail();
        $schedule = Schedule::firstOrFail();

        $response = $this->post('/daftar-trial', [
            'parent_name' => 'Bunda Rina Test',
            'whatsapp' => '081299887766',
            'student_name' => 'Zaidan Alfarizi',
            'grade_level' => 'SD',
            'school_name' => 'SDN Cibinong 02',
            'program_id' => $program->id,
            'schedule_id' => $schedule->id,
            'learning_obstacle' => 'Ingin meningkatkan kecepatan perkalian',
            'quiz_score' => 90,
            'quiz_avg_time' => 2.4,
        ]);

        $this->assertDatabaseHas('trial_leads', [
            'student_name' => 'Zaidan Alfarizi',
            'parent_name' => 'Bunda Rina Test',
            'whatsapp' => '6281299887766',
            'grade_level' => 'SD',
            'quiz_score' => 90,
            'status' => 'Baru',
        ]);

        $response->assertRedirect();
        $targetUrl = $response->headers->get('Location');
        $this->assertStringStartsWith('https://wa.me/6287705555190?text=', $targetUrl);
        $this->assertStringContainsString('Zaidan%20Alfarizi', $targetUrl);
    }

    /**
     * Audit Fase 2 (3): GET /cek-raport?kode=MB-2026-001 redirects to /raport/{portal_token}
     */
    public function test_phase_2_cek_raport_redirects_to_student_portal(): void
    {
        $response = $this->get('/cek-raport?kode=MB-2026-001');

        $response->assertRedirect('/raport/raport-aisyah-01');
    }

    /**
     * Audit Fase 3 (1): GET /raport/{portal_token} renders profile, Jarimatika tree, Chart.js, journals, and badges
     */
    public function test_phase_3_parent_portal_renders_student_progress_and_badges(): void
    {
        $response = $this->get('/raport/raport-aisyah-01');

        $response->assertStatus(200);
        $response->assertSee('Aisyah Putri Rahmawati');
        $response->assertSee('MB-2026-001');
        $response->assertSee('Pohon Level Jarimatika');
        $response->assertSee('practiceScoreChart');
        $response->assertSee('speedRatingChart');
        $response->assertSee('Jagoan Jarimatika Level 1-3');
    }

    /**
     * Audit Fase 3 (2): GET /raport/{portal_token}/cetak-pdf returns valid PDF stream
     */
    public function test_phase_3_parent_portal_downloads_eraport_pdf(): void
    {
        $response = $this->get('/raport/raport-aisyah-01/cetak-pdf');

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $response->headers->get('Content-Type'));
    }

    /**
     * Audit Fase 3 (3): GET /raport/{portal_token}/kwitansi/{invoice_id} returns valid PDF receipt
     */
    public function test_phase_3_parent_portal_downloads_tuition_invoice_pdf(): void
    {
        $student = Student::where('portal_token', 'raport-aisyah-01')->firstOrFail();
        $invoice = $student->invoices()->firstOrFail();

        $response = $this->get("/raport/{$student->portal_token}/kwitansi/{$invoice->id}");

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $response->headers->get('Content-Type'));
    }

    /**
     * Audit Fase 4 (1): Unauthenticated user visiting /admin/dashboard is redirected to /login
     */
    public function test_phase_4_unauthenticated_admin_access_redirects_to_login(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    /**
     * Audit Fase 4 (2): Authenticated Admin can open all 6 core internal modules (HTTP 200)
     */
    public function test_phase_4_authenticated_admin_can_access_all_modules(): void
    {
        $admin = User::where('email', 'admin@mustikabimbel.com')->firstOrFail();

        $routes = [
            '/admin/dashboard',
            '/admin/attendance',
            '/admin/leads',
            '/admin/students',
            '/admin/schedules',
            '/admin/invoices',
        ];

        foreach ($routes as $uri) {
            $response = $this->actingAs($admin)->get($uri);
            $response->assertStatus(200, "Failed asserting that {$uri} returned HTTP 200.");
        }
    }

    /**
     * Audit Fase 4 (3): POST/PUT/PATCH actions for Attendance Check-in, Daily Journal, Lead Conversion, Badge Award, and Invoice Generation
     */
    public function test_phase_4_admin_crud_and_workflow_actions(): void
    {
        $admin = User::where('email', 'admin@mustikabimbel.com')->firstOrFail();
        $student = Student::where('student_code', 'MB-2026-001')->firstOrFail();

        // 1. Check-in Presensi 1-Klik
        $checkInResponse = $this->actingAs($admin)->post('/admin/attendance/check-in', [
            'student_id' => $student->id,
            'schedule_id' => $student->schedule_id,
            'session_date' => '2026-11-04',
            'attendance_status' => 'Hadir',
        ]);
        $checkInResponse->assertRedirect();
        $checkInResponse->assertSessionHas('wa_arrival_url');
        $this->assertDatabaseHas('study_sessions', [
            'student_id' => $student->id,
            'session_date' => '2026-11-04 00:00:00',
            'attendance_status' => 'Hadir',
            'wa_arrival_sent' => true,
        ]);

        // 2. Input Jurnal Belajar Harian & Skor
        $journalResponse = $this->actingAs($admin)->post('/admin/attendance/journal', [
            'student_id' => $student->id,
            'schedule_id' => $student->schedule_id,
            'session_date' => '2026-11-04',
            'subject_category' => 'Matematika',
            'topic_covered' => 'Operasi Pecahan Campuran & Desimal Cepat',
            'speed_rating' => 5,
            'practice_score' => 98,
            'tutor_notes' => 'Ananda sangat cepat menguasai trik desimal.',
        ]);
        $journalResponse->assertRedirect();
        $journalResponse->assertSessionHas('wa_report_url');
        $this->assertDatabaseHas('study_sessions', [
            'student_id' => $student->id,
            'topic_covered' => 'Operasi Pecahan Campuran & Desimal Cepat',
            'speed_rating' => 5,
            'practice_score' => 98,
            'wa_report_sent' => true,
        ]);

        // 3. Konversi Pendaftar Trial ke Siswa Resmi
        $lead = TrialLead::where('status', 'Baru')->firstOrFail();
        $convertResponse = $this->actingAs($admin)->post("/admin/leads/{$lead->id}/convert");
        $convertResponse->assertRedirect(route('admin.students.index'));
        $this->assertDatabaseHas('trial_leads', [
            'id' => $lead->id,
            'status' => 'Daftar Resmi',
        ]);
        $this->assertDatabaseHas('students', [
            'full_name' => $lead->student_name,
            'status' => 'Aktif',
        ]);

        // 4. Pemberian Student Badge Baru
        $badgeResponse = $this->actingAs($admin)->post("/admin/students/{$student->id}/badge", [
            'badge_title' => 'Juara Olimpiade MIPA Simulasi',
            'badge_category' => 'Akademik MIPA',
            'badge_icon' => 'trophy',
            'description' => 'Meraih nilai tertinggi pada simulasi ujian MIPA tingkat SD.',
        ]);
        $badgeResponse->assertRedirect();
        $this->assertDatabaseHas('student_badges', [
            'student_id' => $student->id,
            'badge_title' => 'Juara Olimpiade MIPA Simulasi',
        ]);

        // 5. Generate Tagihan SPP Bulanan & Tandai Lunas
        $generateInvoiceResponse = $this->actingAs($admin)->post('/admin/invoices/generate', [
            'billing_period' => 'Desember 2026',
            'due_date' => '2026-12-10',
        ]);
        $generateInvoiceResponse->assertRedirect();
        $this->assertDatabaseHas('tuition_invoices', [
            'student_id' => $student->id,
            'billing_period' => 'Desember 2026',
            'status' => 'Belum Lunas',
        ]);

        $newInvoice = TuitionInvoice::where('student_id', $student->id)
            ->where('billing_period', 'Desember 2026')
            ->firstOrFail();

        $payInvoiceResponse = $this->actingAs($admin)->patch("/admin/invoices/{$newInvoice->id}/pay", [
            'payment_method' => 'QRIS / E-Wallet',
            'notes' => 'Lunas via QRIS Bunda Siti.',
        ]);
        $payInvoiceResponse->assertRedirect();
        $this->assertDatabaseHas('tuition_invoices', [
            'id' => $newInvoice->id,
            'status' => 'Lunas',
            'payment_method' => 'QRIS / E-Wallet',
        ]);
    }
}
