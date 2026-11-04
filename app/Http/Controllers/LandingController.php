<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\TrialLead;
use App\Services\WhatsAppService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * Display the MustikaBimbel public landing page.
     */
    public function index(): View
    {
        $programs = Program::where('is_active', true)->get();
        $schedules = Schedule::with('program')->orderBy('id')->get();
        $sampleStudents = Student::select('student_code', 'portal_token', 'full_name', 'grade_level')
            ->where('status', 'Aktif')
            ->limit(4)
            ->get();

        return view('landing.index', compact('programs', 'schedules', 'sampleStudents'));
    }

    /**
     * Store Free Trial registration and redirect to official WhatsApp Click-to-Chat.
     */
    public function storeTrial(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'parent_name' => ['required', 'string', 'max:120'],
            'whatsapp' => ['required', 'string', 'max:30'],
            'student_name' => ['required', 'string', 'max:120'],
            'grade_level' => ['required', 'in:TK,SD,SMP'],
            'school_name' => ['nullable', 'string', 'max:150'],
            'program_id' => ['nullable', 'exists:programs,id'],
            'schedule_id' => ['nullable', 'exists:schedules,id'],
            'learning_obstacle' => ['nullable', 'string', 'max:255'],
            'quiz_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'quiz_avg_time' => ['nullable', 'numeric', 'min:0', 'max:60'],
        ]);

        $validated['whatsapp'] = WhatsAppService::formatPhoneNumber($validated['whatsapp']);
        $validated['status'] = 'Baru';

        $lead = TrialLead::create($validated);
        $lead->load(['program', 'schedule']);

        $waUrl = WhatsAppService::generateTrialRegistrationUrl($lead);

        return redirect()->away($waUrl);
    }

    /**
     * Quick lookup for student E-Raport by student_code or portal_token.
     */
    public function checkReport(Request $request): RedirectResponse
    {
        $code = trim((string) $request->query('kode', ''));

        if ($code === '') {
            return redirect('/')->with('report_error', 'Silakan masukkan Kode Induk Siswa (contoh: MB-2026-001).');
        }

        $student = Student::where('student_code', $code)
            ->orWhere('portal_token', $code)
            ->first();

        if (! $student) {
            return redirect('/')->with('report_error', "Siswa dengan kode '{$code}' tidak ditemukan. Coba gunakan contoh: MB-2026-001.");
        }

        return redirect()->to('/raport/' . $student->portal_token);
    }
}
