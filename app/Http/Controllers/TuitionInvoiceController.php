<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TuitionInvoice;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TuitionInvoiceController extends Controller
{
    /**
     * Display listing of tuition invoices.
     */
    public function index(Request $request): View
    {
        $statusFilter = $request->query('status');
        $search = $request->query('search');

        $invoices = TuitionInvoice::with(['student.program'])
            ->when($statusFilter, fn($q) => $q->where('status', $statusFilter))
            ->when($search, fn($q) => $q->where(function ($sub) use ($search) {
                $sub->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($sq) use ($search) {
                        $sq->where('full_name', 'like', "%{$search}%")
                           ->orWhere('student_code', 'like', "%{$search}%");
                    });
            }))
            ->orderBy('due_date', 'desc')
            ->paginate(15)
            ->withQueryString();

        $totalInvoicesCount = TuitionInvoice::count();
        $paidSum = TuitionInvoice::where('status', 'Lunas')->sum('amount');
        $unpaidSum = TuitionInvoice::where('status', 'Belum Lunas')->sum('amount');
        $paidCount = TuitionInvoice::where('status', 'Lunas')->count();
        $unpaidCount = TuitionInvoice::where('status', 'Belum Lunas')->count();

        return view('admin.invoices.index', compact(
            'invoices',
            'statusFilter',
            'search',
            'totalInvoicesCount',
            'paidSum',
            'unpaidSum',
            'paidCount',
            'unpaidCount'
        ));
    }

    /**
     * Bulk generate monthly tuition invoices for all active students.
     */
    public function generateMonthly(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'billing_period' => ['required', 'string', 'max:50'],
            'due_date' => ['required', 'date'],
        ]);

        $activeStudents = Student::with('program')
            ->where('status', 'Aktif')
            ->get();

        $createdCount = 0;
        $period = $validated['billing_period'];
        $dueDate = $validated['due_date'];
        $monthCode = Carbon::parse($dueDate)->format('Ym');

        foreach ($activeStudents as $student) {
            $exists = TuitionInvoice::where('student_id', $student->id)
                ->where('billing_period', $period)
                ->exists();

            if (! $exists) {
                $invNumber = sprintf('INV-MB-%s-%03d', $monthCode, $student->id);

                TuitionInvoice::create([
                    'invoice_number' => $invNumber,
                    'student_id' => $student->id,
                    'billing_period' => $period,
                    'amount' => $student->program?->monthly_fee ?? 250000,
                    'due_date' => $dueDate,
                    'status' => 'Belum Lunas',
                    'notes' => "Tagihan SPP {$period} ananda {$student->full_name}.",
                ]);

                $createdCount++;
            }
        }

        return back()->with('success', "Berhasil men-generate {$createdCount} tagihan SPP baru untuk periode: {$period}!");
    }

    /**
     * Mark an invoice as Paid (Lunas).
     */
    public function markAsPaid(Request $request, TuitionInvoice $invoice): RedirectResponse
    {
        $validated = $request->validate([
            'payment_method' => ['required', 'string', 'in:Transfer Bank,QRIS / E-Wallet,Tunai'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $invoice->update([
            'status' => 'Lunas',
            'paid_at' => now(),
            'payment_method' => $validated['payment_method'],
            'notes' => $validated['notes'] ?? 'Lunas terverifikasi.',
        ]);

        return back()->with('success', "Tagihan {$invoice->invoice_number} berhasil ditandai LUNAS!");
    }

    /**
     * Delete an invoice.
     */
    public function destroy(TuitionInvoice $invoice): RedirectResponse
    {
        $num = $invoice->invoice_number;
        $invoice->delete();

        return back()->with('success', "Tagihan {$num} berhasil dihapus.");
    }
}
