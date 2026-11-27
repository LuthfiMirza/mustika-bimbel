<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\InvoicePayment;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudySession;
use App\Models\TrialLead;
use App\Models\TuitionInvoice;
use App\Services\WhatsAppService;
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

        // 4. Financial metrics (Overall & Current Month Net Profit)
        $allInvoices = TuitionInvoice::select('id', 'student_id', 'amount', 'paid_amount', 'status', 'paid_at')->get();
        $paidInvoicesSum = (int) $allInvoices->sum(fn($i) => $i->status === 'Lunas' && (int) $i->paid_amount === 0 ? (int) $i->amount : (int) $i->paid_amount);
        $unpaidInvoicesSum = (int) $allInvoices->whereIn('status', ['Belum Lunas', 'Kurang'])
            ->sum(fn($i) => max(0, (int) $i->amount - (int) $i->paid_amount));

        $monthCashIn = (int) InvoicePayment::whereYear('payment_date', $today->year)
            ->whereMonth('payment_date', $today->month)
            ->sum('amount');
        $monthExpenses = (int) Expense::whereYear('expense_date', $today->year)
            ->whereMonth('expense_date', $today->month)
            ->sum('amount');
        $monthNetProfit = $monthCashIn - $monthExpenses;

        // 5. Top Arrears Students (Tunggakan Terbesar)
        $topArrears = Student::with(['invoices' => fn($q) => $q->whereIn('status', ['Belum Lunas', 'Kurang'])->orderBy('due_date')])
            ->get()
            ->map(function (Student $s) {
                $arrears = $s->total_arrears;
                $firstOpen = $s->invoices->first();
                return [
                    'student' => $s,
                    'arrears' => $arrears,
                    'open_count' => $s->invoices->count(),
                    'reminder_url' => $firstOpen ? WhatsAppService::generateTuitionReminderUrl($firstOpen, $arrears) : null,
                ];
            })
            ->filter(fn($item) => $item['arrears'] > 0)
            ->sortByDesc('arrears')
            ->take(5)
            ->values();

        // 6. Recent records
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
            'monthCashIn',
            'monthExpenses',
            'monthNetProfit',
            'topArrears',
            'recentLeads',
            'schedules',
            'recentSessions'
        ));
    }
}
