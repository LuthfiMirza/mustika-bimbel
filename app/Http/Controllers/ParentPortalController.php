<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TuitionInvoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ParentPortalController extends Controller
{
    /**
     * Display the student e-report and parent portal.
     */
    public function show(string $portal_token): View
    {
        $student = Student::with([
            'program',
            'schedule',
            'badges' => fn($q) => $q->orderBy('awarded_date', 'desc'),
            'studySessions' => fn($q) => $q->orderBy('session_date', 'desc'),
            'tuitionInvoices' => fn($q) => $q->orderBy('due_date', 'desc'),
        ])->where('portal_token', $portal_token)
          ->orWhere('student_code', $portal_token)
          ->firstOrFail();

        // Calculate attendance metrics
        $totalSessions = $student->studySessions->count();
        $attendedCount = $student->studySessions->where('attendance_status', 'Hadir')->count();
        $attendanceRate = $totalSessions > 0 ? round(($attendedCount / $totalSessions) * 100) : 100;

        // Calculate latest performance
        $latestSession = $student->studySessions->first();
        $averageScore = $totalSessions > 0 ? round($student->studySessions->avg('practice_score')) : 0;
        $averageSpeed = $totalSessions > 0 ? round($student->studySessions->avg('speed_rating'), 1) : 0;

        // Prepare chart chronological data (ascending order)
        $chartSessions = $student->studySessions->sortBy('session_date')->values();
        $chartLabels = $chartSessions->map(fn($s) => $s->session_date->format('d/m'))->toArray();
        $chartScores = $chartSessions->pluck('practice_score')->toArray();
        $chartSpeeds = $chartSessions->pluck('speed_rating')->toArray();

        return view('portal.show', compact(
            'student',
            'totalSessions',
            'attendedCount',
            'attendanceRate',
            'latestSession',
            'averageScore',
            'averageSpeed',
            'chartLabels',
            'chartScores',
            'chartSpeeds'
        ));
    }

    /**
     * Download the official monthly E-Raport as a PDF.
     */
    public function downloadReportPdf(string $portal_token): Response
    {
        $student = Student::with([
            'program',
            'schedule',
            'studySessions' => fn($q) => $q->orderBy('session_date', 'desc'),
        ])->where('portal_token', $portal_token)
          ->orWhere('student_code', $portal_token)
          ->firstOrFail();

        $totalSessions = $student->studySessions->count();
        $attendedCount = $student->studySessions->where('attendance_status', 'Hadir')->count();
        $attendanceRate = $totalSessions > 0 ? round(($attendedCount / $totalSessions) * 100) : 100;
        $averageScore = $totalSessions > 0 ? round($student->studySessions->avg('practice_score')) : 0;
        $averageSpeed = $totalSessions > 0 ? round($student->studySessions->avg('speed_rating'), 1) : 0;

        $pdf = Pdf::loadView('pdf.raport', compact(
            'student',
            'totalSessions',
            'attendedCount',
            'attendanceRate',
            'averageScore',
            'averageSpeed'
        ))->setPaper('a4', 'portrait');

        $filename = 'E-Raport-' . $student->student_code . '-' . str_replace(' ', '-', $student->full_name) . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Download the official tuition receipt as a PDF.
     */
    public function downloadInvoicePdf(string $portal_token, int $invoice_id): Response
    {
        $student = Student::with('program')
            ->where('portal_token', $portal_token)
            ->orWhere('student_code', $portal_token)
            ->firstOrFail();

        $invoice = TuitionInvoice::with('student.program')
            ->where('student_id', $student->id)
            ->where('id', $invoice_id)
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.kwitansi', compact('student', 'invoice'))
            ->setPaper('a5', 'landscape');

        $filename = 'Kwitansi-' . $invoice->invoice_number . '.pdf';

        return $pdf->download($filename);
    }
}
