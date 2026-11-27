<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudentBadge;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of active and inactive students.
     */
    public function index(Request $request): View
    {
        $gradeFilter = $request->query('grade');
        $statusFilter = $request->query('status');
        $attentionFilter = $request->boolean('attention');
        $search = $request->query('search');

        $students = Student::with(['program', 'schedule', 'badges', 'invoices', 'studySessions'])
            ->when($gradeFilter, fn($q) => $q->where('grade_level', $gradeFilter))
            ->when($statusFilter, fn($q) => $q->where('status', $statusFilter))
            ->when($attentionFilter, function ($q) {
                $q->where(function ($sub) {
                    $sub->whereHas('invoices', function ($iq) {
                        $iq->whereIn('status', ['Belum Lunas', 'Kurang'])
                            ->whereDate('due_date', '<', now()->toDateString());
                    })->orWhereHas('studySessions', function ($sq) {
                        $sq->where('attendance_status', 'Alpha');
                    }, '>=', 2);
                });
            })
            ->when($search, fn($q) => $q->where(function ($sub) use ($search) {
                $sub->where('full_name', 'like', "%{$search}%")
                    ->orWhere('student_code', 'like', "%{$search}%")
                    ->orWhere('parent_name', 'like', "%{$search}%");
            }))
            ->orderBy('student_code')
            ->paginate(15)
            ->withQueryString();

        $totalActive = Student::where('status', 'Aktif')->count();
        $attentionCount = Student::where('status', 'Aktif')
            ->where(function ($sub) {
                $sub->whereHas('invoices', function ($iq) {
                    $iq->whereIn('status', ['Belum Lunas', 'Kurang'])
                        ->whereDate('due_date', '<', now()->toDateString());
                })->orWhereHas('studySessions', function ($sq) {
                    $sq->where('attendance_status', 'Alpha');
                }, '>=', 2);
            })->count();
        $programs = Program::where('is_active', true)->get();
        $schedules = Schedule::all();

        return view('admin.students.index', compact(
            'students',
            'totalActive',
            'attentionCount',
            'attentionFilter',
            'gradeFilter',
            'statusFilter',
            'search',
            'programs',
            'schedules'
        ));
    }

    /**
     * Display 360-degree student dossier (academic, attendance, finance, badges, internal notes).
     */
    public function show(Student $student): View
    {
        $student->load([
            'program',
            'schedule',
            'badges' => fn($q) => $q->orderBy('awarded_date', 'desc'),
            'studySessions' => fn($q) => $q->orderBy('session_date', 'desc'),
            'invoices' => fn($q) => $q->with('payments')->orderBy('due_date', 'desc'),
        ]);

        $totalSessions = $student->studySessions->count();
        $attendedSessions = $student->studySessions->where('attendance_status', 'Hadir')->count();
        $alphaSessions = $student->studySessions->where('attendance_status', 'Alpha')->count();
        $attendanceRate = $totalSessions > 0 ? round(($attendedSessions / $totalSessions) * 100) : 100;
        $avgScore = $totalSessions > 0 ? round($student->studySessions->avg('practice_score')) : 0;

        $totalArrears = $student->total_arrears;
        $latestUnpaid = $student->invoices->first(fn($i) => in_array($i->status, ['Belum Lunas', 'Kurang'], true));
        $reminderUrl = $latestUnpaid ? WhatsAppService::generateTuitionReminderUrl($latestUnpaid, $totalArrears) : null;

        return view('admin.students.show', compact(
            'student',
            'totalSessions',
            'attendedSessions',
            'alphaSessions',
            'attendanceRate',
            'avgScore',
            'totalArrears',
            'reminderUrl'
        ));
    }

    /**
     * Quick update private internal notes from Student 360 profile.
     */
    public function updateNotes(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'internal_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $student->update(['internal_notes' => $validated['internal_notes']]);

        return back()->with('success', "Catatan internal untuk ananda {$student->full_name} berhasil disimpan.");
    }

    /**
     * Show form to create a new student.
     */
    public function create(): View
    {
        $programs = Program::where('is_active', true)->get();
        $schedules = Schedule::all();

        return view('admin.students.create', compact('programs', 'schedules'));
    }

    /**
     * Store newly created student in database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:120'],
            'nickname' => ['nullable', 'string', 'max:50'],
            'grade_level' => ['required', 'in:TK,SD,SMP'],
            'class_number' => ['nullable', 'string', 'max:50'],
            'school_name' => ['nullable', 'string', 'max:120'],
            'parent_name' => ['required', 'string', 'max:120'],
            'parent_whatsapp' => ['required', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'program_id' => ['required', 'exists:programs,id'],
            'schedule_id' => ['required', 'exists:schedules,id'],
            'monthly_discount' => ['nullable', 'integer', 'min:0', 'max:5000000'],
            'discount_reason' => ['nullable', 'string', 'max:120'],
            'jarimatika_level' => ['required', 'integer', 'min:1', 'max:6'],
            'mipa_mastery_percent' => ['required', 'integer', 'min:0', 'max:100'],
            'join_date' => ['required', 'date'],
            'left_date' => ['nullable', 'date'],
            'status' => ['required', 'in:Aktif,Cuti,Lulus'],
            'internal_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $validated['monthly_discount'] = (int) ($validated['monthly_discount'] ?? 0);

        $year = date('Y');
        $seq = Student::count() + 1;
        $studentCode = sprintf('MB-%s-%03d', $year, $seq);
        while (Student::where('student_code', $studentCode)->exists()) {
            $seq++;
            $studentCode = sprintf('MB-%s-%03d', $year, $seq);
        }

        $nameSlug = Str::slug(explode(' ', trim($validated['full_name']))[0]);
        $portalToken = 'raport-' . $nameSlug . '-' . Str::lower(Str::random(5));

        $validated['student_code'] = $studentCode;
        $validated['portal_token'] = $portalToken;
        $validated['parent_whatsapp'] = WhatsAppService::formatPhoneNumber($validated['parent_whatsapp']);

        $student = Student::create($validated);

        if ($schedule = Schedule::find($validated['schedule_id'])) {
            $schedule->increment('filled_quota');
        }

        return redirect()->route('admin.students.index')
            ->with('success', "Siswa baru {$student->full_name} ({$studentCode}) berhasil didaftarkan!");
    }

    /**
     * Show form to edit existing student.
     */
    public function edit(Student $student): View
    {
        $programs = Program::where('is_active', true)->get();
        $schedules = Schedule::all();

        return view('admin.students.edit', compact('student', 'programs', 'schedules'));
    }

    /**
     * Update student details, Jarimatika level, and MIPA mastery.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:120'],
            'nickname' => ['nullable', 'string', 'max:50'],
            'grade_level' => ['required', 'in:TK,SD,SMP'],
            'class_number' => ['nullable', 'string', 'max:50'],
            'school_name' => ['nullable', 'string', 'max:120'],
            'parent_name' => ['required', 'string', 'max:120'],
            'parent_whatsapp' => ['required', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'program_id' => ['required', 'exists:programs,id'],
            'schedule_id' => ['required', 'exists:schedules,id'],
            'monthly_discount' => ['nullable', 'integer', 'min:0', 'max:5000000'],
            'discount_reason' => ['nullable', 'string', 'max:120'],
            'jarimatika_level' => ['required', 'integer', 'min:1', 'max:6'],
            'mipa_mastery_percent' => ['required', 'integer', 'min:0', 'max:100'],
            'left_date' => ['nullable', 'date'],
            'status' => ['required', 'in:Aktif,Cuti,Lulus'],
            'internal_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $validated['monthly_discount'] = (int) ($validated['monthly_discount'] ?? 0);
        if ($validated['status'] !== 'Aktif' && empty($validated['left_date']) && empty($student->left_date)) {
            $validated['left_date'] = now()->toDateString();
        }
        if ($validated['status'] === 'Aktif') {
            $validated['left_date'] = null;
        }

        $validated['parent_whatsapp'] = WhatsAppService::formatPhoneNumber($validated['parent_whatsapp']);

        $oldScheduleId = $student->schedule_id;
        $student->update($validated);

        if ($oldScheduleId !== (int) $validated['schedule_id']) {
            if ($oldScheduleId && ($oldSchedule = Schedule::find($oldScheduleId)) && $oldSchedule->filled_quota > 0) {
                $oldSchedule->decrement('filled_quota');
            }
            if ($newSchedule = Schedule::find($validated['schedule_id'])) {
                $newSchedule->increment('filled_quota');
            }
        }

        return redirect()->route('admin.students.index')
            ->with('success', "Data perkembangan ananda {$student->full_name} berhasil diperbarui.");
    }

    /**
     * Award new digital badge to student.
     */
    public function awardBadge(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'badge_title' => ['required', 'string', 'max:150'],
            'badge_category' => ['required', 'string', 'max:80'],
            'badge_icon' => ['required', 'in:trophy,star,zap,award'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $validated['student_id'] = $student->id;
        $validated['awarded_date'] = Carbon::today();

        StudentBadge::create($validated);

        return back()->with('success', "Lencana kehormatan '{$validated['badge_title']}' berhasil diberikan kepada {$student->full_name}!");
    }

    /**
     * Delete student record.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $name = $student->full_name;
        if ($student->schedule && $student->schedule->filled_quota > 0) {
            $student->schedule->decrement('filled_quota');
        }
        $student->delete();

        return back()->with('success', "Data siswa {$name} telah dihapus.");
    }
}
