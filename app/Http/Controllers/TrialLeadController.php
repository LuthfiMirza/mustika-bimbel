<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\TrialLead;
use App\Models\TuitionInvoice;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TrialLeadController extends Controller
{
    /**
     * Display list of trial leads (CRM).
     */
    public function index(Request $request): View
    {
        $statusFilter = $request->query('status');
        $search = $request->query('search');

        $leads = TrialLead::with(['program', 'schedule'])
            ->when($statusFilter, fn($q) => $q->where('status', $statusFilter))
            ->when($search, fn($q) => $q->where(function ($sub) use ($search) {
                $sub->where('student_name', 'like', "%{$search}%")
                    ->orWhere('parent_name', 'like', "%{$search}%")
                    ->orWhere('whatsapp', 'like', "%{$search}%");
            }))
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $statusCounts = [
            'Semua' => TrialLead::count(),
            'Baru' => TrialLead::where('status', 'Baru')->count(),
            'Dihubungi' => TrialLead::where('status', 'Dihubungi')->count(),
            'Sudah Trial' => TrialLead::where('status', 'Sudah Trial')->count(),
            'Daftar Resmi' => TrialLead::where('status', 'Daftar Resmi')->count(),
            'Batal' => TrialLead::where('status', 'Batal')->count(),
        ];

        $programs = Program::where('is_active', true)->get();
        $schedules = Schedule::all();

        return view('admin.leads.index', compact('leads', 'statusCounts', 'statusFilter', 'search', 'programs', 'schedules'));
    }

    /**
     * Update lead status and admin notes.
     */
    public function updateStatus(Request $request, TrialLead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:Baru,Dihubungi,Sudah Trial,Daftar Resmi,Batal'],
            'admin_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $lead->update($validated);

        return back()->with('success', "Status calon siswa {$lead->student_name} diperbarui menjadi: {$lead->status}.");
    }

    /**
     * 1-Click Convert Lead to Official Student.
     */
    public function convertToStudent(Request $request, TrialLead $lead): RedirectResponse
    {
        // 1. Generate unique student code (MB-YYYY-XXX)
        $year = date('Y');
        $count = Student::count() + 1;
        $code = sprintf('MB-%s-%03d', $year, $count);

        // 2. Generate clean portal token
        $nameSlug = Str::slug(explode(' ', trim($lead->student_name))[0]);
        $portalToken = 'raport-' . $nameSlug . '-' . Str::lower(Str::random(5));

        // 3. Fallback program & schedule if null
        $programId = $lead->program_id ?? Program::first()?->id;
        $scheduleId = $lead->schedule_id ?? Schedule::first()?->id;

        $student = Student::create([
            'student_code' => $code,
            'portal_token' => $portalToken,
            'full_name' => $lead->student_name,
            'nickname' => explode(' ', trim($lead->student_name))[0],
            'grade_level' => $lead->grade_level,
            'class_number' => $lead->grade_level . ' Binaan',
            'school_name' => $lead->school_name,
            'parent_name' => $lead->parent_name,
            'parent_whatsapp' => $lead->whatsapp,
            'address' => 'Harapan Jaya, Cibinong',
            'program_id' => $programId,
            'schedule_id' => $scheduleId,
            'jarimatika_level' => 1,
            'mipa_mastery_percent' => 20,
            'join_date' => Carbon::today(),
            'status' => 'Aktif',
        ]);

        // 4. Increment schedule quota if schedule exists
        if ($schedule = Schedule::find($scheduleId)) {
            $schedule->increment('filled_quota');
        }

        // 5. Create initial tuition invoice for current month
        $program = Program::find($programId);
        $monthName = Carbon::now()->translatedFormat('F Y');
        TuitionInvoice::create([
            'invoice_number' => sprintf('INV-MB-%s%02d-%03d', date('Y'), date('m'), $student->id),
            'student_id' => $student->id,
            'billing_period' => $monthName,
            'amount' => $program?->monthly_fee ?? 250000,
            'due_date' => Carbon::now()->addDays(7)->toDateString(),
            'status' => 'Belum Lunas',
            'notes' => 'Tagihan SPP bulan perdana bergabung MustikaBimbel.',
        ]);

        // 6. Mark lead as 'Daftar Resmi'
        $lead->update([
            'status' => 'Daftar Resmi',
            'admin_notes' => ($lead->admin_notes ? $lead->admin_notes . ' | ' : '') . "Dikonversi menjadi Siswa Resmi ({$code}) pada " . now()->format('d/m/Y H:i'),
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', "Selamat! Calon siswa {$lead->student_name} berhasil dikonversi menjadi Siswa Resmi dengan Kode: {$code}!");
    }

    /**
     * Delete lead record.
     */
    public function destroy(TrialLead $lead): RedirectResponse
    {
        $name = $lead->student_name;
        $lead->delete();

        return back()->with('success', "Data calon siswa {$name} berhasil dihapus.");
    }
}
