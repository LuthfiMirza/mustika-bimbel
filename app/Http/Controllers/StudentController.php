<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudentBadge;
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
        $search = $request->query('search');

        $students = Student::with(['program', 'schedule', 'badges'])
            ->when($gradeFilter, fn($q) => $q->where('grade_level', $gradeFilter))
            ->when($statusFilter, fn($q) => $q->where('status', $statusFilter))
            ->when($search, fn($q) => $q->where(function ($sub) use ($search) {
                $sub->where('full_name', 'like', "%{$search}%")
                    ->orWhere('student_code', 'like', "%{$search}%")
                    ->orWhere('parent_name', 'like', "%{$search}%");
            }))
            ->orderBy('student_code')
            ->paginate(15)
            ->withQueryString();

        $totalActive = Student::where('status', 'Aktif')->count();
        $programs = Program::where('is_active', true)->get();
        $schedules = Schedule::all();

        return view('admin.students.index', compact(
            'students',
            'totalActive',
            'gradeFilter',
            'statusFilter',
            'search',
            'programs',
            'schedules'
        ));
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
            'jarimatika_level' => ['required', 'integer', 'min:1', 'max:6'],
            'mipa_mastery_percent' => ['required', 'integer', 'min:0', 'max:100'],
            'join_date' => ['required', 'date'],
            'status' => ['required', 'in:Aktif,Cuti,Lulus'],
        ]);

        $year = date('Y');
        $count = Student::count() + 1;
        $studentCode = sprintf('MB-%s-%03d', $year, $count);

        $nameSlug = Str::slug(explode(' ', trim($validated['full_name']))[0]);
        $portalToken = 'raport-' . $nameSlug . '-' . Str::lower(Str::random(5));

        $validated['student_code'] = $studentCode;
        $validated['portal_token'] = $portalToken;

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
            'jarimatika_level' => ['required', 'integer', 'min:1', 'max:6'],
            'mipa_mastery_percent' => ['required', 'integer', 'min:0', 'max:100'],
            'status' => ['required', 'in:Aktif,Cuti,Lulus'],
        ]);

        $student->update($validated);

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
        if ($student->schedule) {
            $student->schedule->decrement('filled_quota');
        }
        $student->delete();

        return back()->with('success', "Data siswa {$name} telah dihapus.");
    }
}
