<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudySession;
use App\Models\TrialLead;
use App\Models\TuitionInvoice;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display executive dashboard metrics.
     */
    public function index(): View
    {
        // 1. Student counts
        $totalStudents = Student::where('status', 'Aktif')->count();
        $tkCount = Student::where('status', 'Aktif')->where('grade_level', 'TK')->count();
        $sdCount = Student::where('status', 'Aktif')->where('grade_level', 'SD')->count();
        $smpCount = Student::where('status', 'Aktif')->where('grade_level', 'SMP')->count();

        // 2. Leads count
        $newLeadsCount = TrialLead::where('status', 'Baru')->count();
        $totalLeads = TrialLead::count();

        // 3. Today's attendance
        $today = Carbon::today();
        $todaySessionsCount = StudySession::whereDate('session_date', $today)->count();
        $totalSessionsCount = StudySession::count();

        // 4. Financial metrics
        $paidInvoicesSum = TuitionInvoice::where('status', 'Lunas')->sum('amount');
        $unpaidInvoicesSum = TuitionInvoice::where('status', 'Belum Lunas')->sum('amount');

        // 5. Recent records
        $recentLeads = TrialLead::with(['program', 'schedule'])->latest()->take(5)->get();
        $schedules = Schedule::with('program')->get();
        $recentSessions = StudySession::with('student')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'tkCount',
            'sdCount',
            'smpCount',
            'newLeadsCount',
            'totalLeads',
            'todaySessionsCount',
            'totalSessionsCount',
            'paidInvoicesSum',
            'unpaidInvoicesSum',
            'recentLeads',
            'schedules',
            'recentSessions'
        ));
    }
}
