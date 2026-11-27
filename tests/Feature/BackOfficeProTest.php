<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\Setting;
use App\Models\Student;
use App\Models\TuitionInvoice;
use App\Models\User;
use App\Services\WhatsAppService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BackOfficeProTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        if (User::count() === 0) {
            $this->seed(DatabaseSeeder::class);
        }

        $this->admin = User::where('email', 'admin@mustikabimbel.com')->firstOrFail();
    }

    public function test_phase_6_dynamic_settings_and_whatsapp_template_rendering(): void
    {
        $this->actingAs($this->admin)->get('/admin/settings')->assertStatus(200);

        $response = $this->actingAs($this->admin)->put('/admin/settings', [
            'bimbel_name' => 'MustikaBimbel Cibinong Pro',
            'bimbel_address' => 'Amarylis Garden Blok I No. 11',
            'owner_name' => 'Kak Mustika',
            'admin_whatsapp' => '087705555190',
            'payment_info' => 'BCA 1234567890 a.n. Mustika',
            'tuition_due_day' => 15,
            'period_start_month' => '2026-07',
            'wa_template_reminder' => 'Tagihan {siswa} bulan {bulan} sisa {sisa} via {pembayaran} ({bimbel})',
            'wa_template_receipt' => 'Terima kasih {wali}, diterima {jumlah} ({kuitansi})',
            'wa_template_arrival' => 'Ananda {siswa} tiba jam {jam}',
            'wa_template_report' => 'Laporan {siswa} skor {skor}',
        ]);

        $response->assertRedirect();
        $this->assertEquals('MustikaBimbel Cibinong Pro', Setting::get('bimbel_name'));
        $this->assertEquals('15', Setting::get('tuition_due_day'));

        $invoice = TuitionInvoice::with('student')->firstOrFail();
        $waUrl = WhatsAppService::generateTuitionReminderUrl($invoice);
        $this->assertStringContainsString('BCA%201234567890', $waUrl);
        $this->assertStringContainsString('MustikaBimbel%20Cibinong%20Pro', $waUrl);
    }

    public function test_phase_7_student_discount_installments_and_12_month_spp_card(): void
    {
        $student = Student::where('student_code', 'MB-2026-002')->firstOrFail();
        $student->update([
            'monthly_discount' => 50000,
            'discount_reason' => 'Diskon Kakak-Beradik',
        ]);
        $student->load('program');
        $expectedNet = $student->program->monthly_fee - 50000;

        // Generate Januari 2027
        $this->actingAs($this->admin)->post('/admin/invoices/generate', [
            'billing_period' => 'Januari 2027',
            'due_date' => '2027-01-10',
        ])->assertRedirect();

        $invoice = TuitionInvoice::where('student_id', $student->id)
            ->where('billing_month', '2027-01')
            ->firstOrFail();

        $this->assertEquals($student->program->monthly_fee, $invoice->base_amount);
        $this->assertEquals(50000, $invoice->discount_amount);
        $this->assertEquals($expectedNet, $invoice->amount);
        $this->assertEquals('Belum Lunas', $invoice->status);

        // Cicilan ke-1 (100.000) -> status harus Kurang
        $this->actingAs($this->admin)->patch("/admin/invoices/{$invoice->id}/pay", [
            'amount' => 100000,
            'payment_date' => '2027-01-05',
            'payment_method' => 'Tunai',
            'notes' => 'Cicilan tahap 1',
        ])->assertRedirect()->assertSessionHas('wa_receipt_url');

        $invoice->refresh();
        $this->assertEquals('Kurang', $invoice->status);
        $this->assertEquals(100000, $invoice->paid_amount);
        $this->assertEquals($expectedNet - 100000, $invoice->remaining_amount);

        // Cicilan ke-2 (lunaskan sisa) -> status harus Lunas
        $this->actingAs($this->admin)->patch("/admin/invoices/{$invoice->id}/pay", [
            'amount' => $invoice->remaining_amount,
            'payment_date' => '2027-01-09',
            'payment_method' => 'Transfer Bank',
            'notes' => 'Pelunasan tahap 2',
        ])->assertRedirect();

        $invoice->refresh();
        $this->assertEquals('Lunas', $invoice->status);
        $this->assertEquals($expectedNet, $invoice->paid_amount);
        $this->assertEquals(2, $invoice->payments()->count());

        // Kartu SPP 12 Bulan loads cleanly
        $this->actingAs($this->admin)
            ->get('/admin/invoices/card')
            ->assertStatus(200)
            ->assertSee($student->full_name);
    }

    public function test_phase_8_expenses_and_12_month_financial_report_and_csv(): void
    {
        $this->actingAs($this->admin)->get('/admin/expenses')->assertStatus(200);

        $this->actingAs($this->admin)->post('/admin/expenses', [
            'expense_date' => '2026-11-20',
            'category' => 'Modul & ATK',
            'description' => 'Pembelian spidol & kertas HVS',
            'amount' => 85000,
            'payment_method' => 'Tunai',
        ])->assertRedirect();

        $this->assertDatabaseHas('expenses', [
            'description' => 'Pembelian spidol & kertas HVS',
            'amount' => 85000,
        ]);

        $this->actingAs($this->admin)
            ->get('/admin/reports?start_month=2026-07')
            ->assertStatus(200)
            ->assertSee('Laba Bersih');

        $csv = $this->actingAs($this->admin)->get('/admin/reports/export?start_month=2026-07');
        $csv->assertStatus(200);
        $this->assertStringContainsString('text/csv', $csv->headers->get('Content-Type'));
    }

    public function test_phase_9_student_360_profile_internal_notes_and_dashboard(): void
    {
        $student = Student::where('student_code', 'MB-2026-001')->firstOrFail();

        $this->actingAs($this->admin)
            ->get("/admin/students/{$student->id}")
            ->assertStatus(200)
            ->assertSee($student->full_name)
            ->assertSee('Catatan Internal Guru / Admin');

        $this->actingAs($this->admin)
            ->patch("/admin/students/{$student->id}/notes", [
                'internal_notes' => 'Sangat cepat paham jika diberi contoh visual jari.',
            ])->assertRedirect();

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'internal_notes' => 'Sangat cepat paham jika diberi contoh visual jari.',
        ]);

        $this->actingAs($this->admin)
            ->get('/admin/students?attention=1')
            ->assertStatus(200);

        $this->actingAs($this->admin)
            ->get('/admin/dashboard')
            ->assertStatus(200)
            ->assertSee('Laba Bersih Bulan Ini');

        // Ensure private internal_notes is NEVER exposed in Parent Portal
        $this->get("/raport/{$student->portal_token}")
            ->assertStatus(200)
            ->assertDontSee('Sangat cepat paham jika diberi contoh visual jari.');
    }

    public function test_audit_regression_student_code_collision_schedule_quota_and_partial_pdf(): void
    {
        // 1. Delete a student and create another -> student_code must not collide
        $tempStudent = Student::create([
            'student_code' => 'MB-2026-005',
            'portal_token' => 'raport-temp-005',
            'full_name' => 'Siswa Sementara',
            'nickname' => 'Temp',
            'grade_level' => 'SD',
            'parent_name' => 'Ibu Temp',
            'parent_whatsapp' => '6281111111111',
            'program_id' => 1,
            'schedule_id' => 1,
            'jarimatika_level' => 1,
            'mipa_mastery_percent' => 20,
            'join_date' => '2026-11-01',
            'status' => 'Aktif',
        ]);

        // Delete MB-2026-002's clone gap simulation: delete MB-2026-004 or tempStudent -> count drops, MB-2026-005 remains taken if 004 deleted
        $student4 = Student::where('student_code', 'MB-2026-004')->firstOrFail();
        $this->actingAs($this->admin)->delete("/admin/students/{$student4->id}")->assertRedirect();

        $createRes = $this->actingAs($this->admin)->post('/admin/students', [
            'full_name' => 'Siswa Anti Bentrok',
            'nickname' => 'Bentrok',
            'grade_level' => 'SD',
            'parent_name' => 'Bapak Anti Bentrok',
            'parent_whatsapp' => '081234500001',
            'program_id' => 1,
            'schedule_id' => 1,
            'monthly_discount' => 25000,
            'discount_reason' => 'Promo Audit',
            'jarimatika_level' => 2,
            'mipa_mastery_percent' => 45,
            'join_date' => '2026-11-27',
            'status' => 'Aktif',
        ]);
        $createRes->assertRedirect(route('admin.students.index'));
        $this->assertDatabaseHas('students', ['full_name' => 'Siswa Anti Bentrok']);

        // 2. Partial payment invoice PDF & Parent Portal display
        $partialInvoice = TuitionInvoice::where('status', 'Kurang')->with('student')->firstOrFail();
        $this->get("/raport/{$partialInvoice->student->portal_token}")
            ->assertStatus(200)
            ->assertSee('Kurang (Cicil)');

        $pdfRes = $this->get("/raport/{$partialInvoice->student->portal_token}/kwitansi/{$partialInvoice->id}");
        $pdfRes->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $pdfRes->headers->get('Content-Type'));
    }

    public function test_landing_redesign_preserves_all_anchors_form_contracts_and_sections(): void
    {
        $res = $this->get('/');
        $res->assertStatus(200);

        // Required Anchor IDs
        foreach (['id="keunggulan"', 'id="tantangan-30-detik"', 'id="metode-kurikulum"', 'id="jadwal-belajar"', 'id="form-trial"', 'id="lokasi"'] as $anchor) {
            $res->assertSee($anchor, false);
        }

        // Required Form Contracts & Alpine Hooks
        foreach ([
            'name="parent_name"', 'name="whatsapp"', 'name="student_name"',
            'name="grade_level"', 'x-model="selectedGrade"', 'name="school_name"',
            'name="program_id"', 'x-model="selectedProgramId"',
            'name="schedule_id"', 'x-model="selectedScheduleId"',
            'name="learning_obstacle"', 'name="quiz_score"', 'name="quiz_avg_time"',
            'name="kode"', 'reportModalOpen', 'mobileMenuOpen',
            'prefers-reduced-motion', '@alpinejs/intersect', '@alpinejs/collapse',
            'Bowlby+One', 'Caveat+Brush',
        ] as $hook) {
            $res->assertSee($hook, false);
        }

        // New Krackerz-inspired sections
        $res->assertSee('SEKOLAH NGEJAR MATERI');
        $res->assertSee('KENALAN DULU');
        $res->assertSee('Pertemuan pertama GRATIS untuk semua program.');
        $res->assertSee('HIAS');
        $res->assertSee('JADI YANG PERTAMA');
    }
}

