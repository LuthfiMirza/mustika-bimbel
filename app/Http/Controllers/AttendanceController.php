<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudySession;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    /**
     * Display student attendance list filtered by schedule and date.
     */
    public function index(Request $request): View
    {
        $schedules = Schedule::with('program')->get();
        $selectedScheduleId = $request->input('schedule_id', $schedules->first()?->id);
        $selectedDate = $request->input('date', Carbon::today()->toDateString());

        $currentSchedule = Schedule::with('program')->find($selectedScheduleId);

        $students = Student::with(['program'])
            ->where('status', 'Aktif')
            ->when($selectedScheduleId, fn($q) => $q->where('schedule_id', $selectedScheduleId))
            ->orderBy('full_name')
            ->get();

        // Attach today's session record for each student
        $studentIds = $students->pluck('id');
        $sessions = StudySession::whereIn('student_id', $studentIds)
            ->whereDate('session_date', $selectedDate)
            ->get()
            ->keyBy('student_id');

        return view('admin.attendance.index', compact(
            'schedules',
            'selectedScheduleId',
            'selectedDate',
            'currentSchedule',
            'students',
            'sessions'
        ));
    }

    /**
     * Record 1-click check-in and generate WhatsApp arrival alert.
     */
    public function checkIn(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'schedule_id' => ['nullable', 'exists:schedules,id'],
            'session_date' => ['required', 'date'],
            'attendance_status' => ['required', 'in:Hadir,Izin,Sakit,Alpha'],
        ]);

        $session = StudySession::firstOrNew([
            'student_id' => $validated['student_id'],
            'session_date' => $validated['session_date'],
        ]);

        $session->schedule_id = $validated['schedule_id'];
        $session->attendance_status = $validated['attendance_status'];

        if ($validated['attendance_status'] === 'Hadir' && empty($session->check_in_time)) {
            $session->check_in_time = now()->format('H:i:s');
        }

        $session->wa_arrival_sent = true;
        $session->save();

        $student = Student::findOrFail($validated['student_id']);
        $waUrl = WhatsAppService::generateArrivalNotificationUrl($student, $session);

        return back()->with([
            'success' => "Presensi ananda {$student->full_name} ({$validated['attendance_status']}) berhasil disimpan!",
            'wa_arrival_url' => $waUrl,
            'wa_student_name' => $student->full_name,
        ]);
    }

    /**
     * Save daily study journal and generate WhatsApp report link.
     */
    public function saveJournal(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'session_date' => ['required', 'date'],
            'schedule_id' => ['nullable', 'exists:schedules,id'],
            'subject_category' => ['required', 'in:Jarimatika,Matematika,Fisika,Kimia,Biologi,Strategi Soal,Persiapan Ujian'],
            'topic_covered' => ['required', 'string', 'max:255'],
            'speed_rating' => ['required', 'integer', 'min:1', 'max:5'],
            'practice_score' => ['required', 'integer', 'min:0', 'max:100'],
            'tutor_notes' => ['nullable', 'string'],
        ]);

        $session = StudySession::firstOrNew([
            'student_id' => $validated['student_id'],
            'session_date' => $validated['session_date'],
        ]);

        $session->schedule_id = $validated['schedule_id'];
        $session->attendance_status = 'Hadir';
        if (empty($session->check_in_time)) {
            $session->check_in_time = '18:30:00';
        }
        $session->check_out_time = now()->format('H:i:s');
        $session->subject_category = $validated['subject_category'];
        $session->topic_covered = $validated['topic_covered'];
        $session->speed_rating = $validated['speed_rating'];
        $session->practice_score = $validated['practice_score'];
        $session->tutor_notes = $validated['tutor_notes'] ?? 'Ananda belajar dengan sangat fokus dan antusias.';
        $session->wa_report_sent = true;
        $session->save();

        $student = Student::findOrFail($validated['student_id']);
        $waUrl = WhatsAppService::generateStudyReportUrl($student, $session);

        return back()->with([
            'success' => "Jurnal belajar & skor ananda {$student->full_name} berhasil disimpan!",
            'wa_report_url' => $waUrl,
            'wa_student_name' => $student->full_name,
        ]);
    }
}
