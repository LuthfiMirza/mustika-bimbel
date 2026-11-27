<?php

namespace App\Http\Controllers;

use App\Models\InvoicePayment;
use App\Models\Setting;
use App\Models\Student;
use App\Models\TuitionInvoice;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TuitionInvoiceController extends Controller
{
    /**
     * Display listing of tuition invoices with discount & installment details.
     */
    public function index(Request $request): View
    {
        $statusFilter = $request->query('status');
        $search = $request->query('search');

        $invoices = TuitionInvoice::with(['student.program', 'payments'])
            ->when($statusFilter, fn($q) => $q->where('status', $statusFilter))
            ->when($search, fn($q) => $q->where(function ($sub) use ($search) {
                $sub->where('invoice_number', 'like', "%{$search}%")
                    ->orWhere('billing_period', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($sq) use ($search) {
                        $sq->where('full_name', 'like', "%{$search}%")
                            ->orWhere('student_code', 'like', "%{$search}%");
                    });
            }))
            ->orderBy('due_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        $allInvoices = TuitionInvoice::select('amount', 'paid_amount', 'status')->get();
        $totalInvoicesCount = $allInvoices->count();
        $paidCount = $allInvoices->where('status', 'Lunas')->count();
        $partialCount = $allInvoices->where('status', 'Kurang')->count();
        $unpaidCount = $allInvoices->where('status', 'Belum Lunas')->count();

        $paidSum = (int) $allInvoices->sum(fn($i) => $i->status === 'Lunas' && (int) $i->paid_amount === 0 ? (int) $i->amount : (int) $i->paid_amount);
        $unpaidSum = (int) $allInvoices->whereIn('status', ['Belum Lunas', 'Kurang'])
            ->sum(fn($i) => max(0, (int) $i->amount - (int) $i->paid_amount));

        $dueDay = max(1, min(28, (int) Setting::get('tuition_due_day', 10)));

        return view('admin.invoices.index', compact(
            'invoices',
            'statusFilter',
            'search',
            'totalInvoicesCount',
            'paidSum',
            'unpaidSum',
            'paidCount',
            'partialCount',
            'unpaidCount',
            'dueDay'
        ));
    }

    /**
     * Display 12-Month SPP Matrix Card (Kartu SPP 12 Bulan) & multi-month arrears reminder.
     */
    public function card(Request $request): View
    {
        $startMonthStr = $request->query('start_month', Setting::get('period_start_month', '2026-07'));
        if (! preg_match('/^\d{4}-\d{2}$/', $startMonthStr)) {
            $startMonthStr = '2026-07';
        }

        $startCarbon = Carbon::createFromFormat('Y-m', $startMonthStr)->startOfMonth();
        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $m = $startCarbon->copy()->addMonths($i);
            $months[] = [
                'key' => $m->format('Y-m'),
                'short' => $m->translatedFormat('M y'),
                'full' => $m->translatedFormat('F Y'),
                'start' => $m->copy()->startOfMonth(),
                'end' => $m->copy()->endOfMonth(),
            ];
        }

        $monthKeys = array_column($months, 'key');
        $students = Student::with([
            'program',
            'schedule',
            'invoices' => fn($q) => $q->orderBy('due_date', 'desc'),
        ])
            ->orderByRaw("CASE WHEN status = 'Aktif' THEN 0 ELSE 1 END")
            ->orderBy('full_name')
            ->get();

        $rows = [];
        $monthCollected = array_fill_keys($monthKeys, 0);
        $totalArrearsAll = 0;
        $studentsWithArrearsCount = 0;

        foreach ($students as $student) {
            $invoiceMap = [];
            foreach ($student->invoices as $inv) {
                $key = $inv->billing_month ?: $inv->due_date?->format('Y-m');
                if ($key) {
                    $invoiceMap[$key] = $inv;
                    if (isset($monthCollected[$key])) {
                        $collected = $inv->status === 'Lunas' && (int) $inv->paid_amount === 0
                            ? (int) $inv->amount
                            : (int) $inv->paid_amount;
                        $monthCollected[$key] += $collected;
                    }
                }
            }

            $cells = [];
            foreach ($months as $m) {
                $inv = $invoiceMap[$m['key']] ?? null;
                if ($inv) {
                    $cells[$m['key']] = [
                        'invoice' => $inv,
                        'state' => $inv->status, // Lunas, Kurang, Belum Lunas
                        'remaining' => $inv->remaining_amount,
                    ];
                } else {
                    $joinedAfter = $student->join_date && $student->join_date->gt($m['end']);
                    $leftBefore = $student->left_date && $student->left_date->lt($m['start']);
                    $cells[$m['key']] = [
                        'invoice' => null,
                        'state' => ($joinedAfter || $leftBefore || $student->status !== 'Aktif') ? '-' : 'Belum Ditagih',
                        'remaining' => 0,
                    ];
                }
            }

            $arrears = $student->total_arrears;
            $latestUnpaid = $student->invoices->first(fn($i) => in_array($i->status, ['Belum Lunas', 'Kurang'], true));
            if ($arrears > 0) {
                $totalArrearsAll += $arrears;
                $studentsWithArrearsCount++;
            }

            $rows[] = [
                'student' => $student,
                'cells' => $cells,
                'arrears' => $arrears,
                'reminder_url' => $latestUnpaid
                    ? WhatsAppService::generateTuitionReminderUrl($latestUnpaid, $arrears)
                    : null,
            ];
        }

        return view('admin.invoices.card', compact(
            'months',
            'rows',
            'monthCollected',
            'startMonthStr',
            'totalArrearsAll',
            'studentsWithArrearsCount'
        ));
    }

    /**
     * Bulk generate monthly tuition invoices for all active students (deducting discounts).
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
        $dueCarbon = Carbon::parse($dueDate);
        $monthCode = $dueCarbon->format('Ym');
        $billingMonth = $dueCarbon->format('Y-m');

        foreach ($activeStudents as $student) {
            $exists = TuitionInvoice::where('student_id', $student->id)
                ->where(function ($q) use ($period, $billingMonth) {
                    $q->where('billing_period', $period)
                        ->orWhere('billing_month', $billingMonth);
                })
                ->exists();

            if (! $exists) {
                $baseFee = (int) ($student->program?->monthly_fee ?? 250000);
                $discount = min($baseFee, (int) ($student->monthly_discount ?? 0));
                $netAmount = max(0, $baseFee - $discount);
                $invNumber = sprintf('INV-MB-%s-%03d', $monthCode, $student->id);

                $note = "Tagihan SPP {$period} ananda {$student->full_name}.";
                if ($discount > 0) {
                    $reason = $student->discount_reason ? " ({$student->discount_reason})" : '';
                    $note .= ' Diskon Rp ' . number_format($discount, 0, ',', '.') . $reason . '.';
                }

                TuitionInvoice::create([
                    'invoice_number' => $invNumber,
                    'student_id' => $student->id,
                    'billing_period' => $period,
                    'billing_month' => $billingMonth,
                    'base_amount' => $baseFee,
                    'discount_amount' => $discount,
                    'amount' => $netAmount,
                    'paid_amount' => 0,
                    'due_date' => $dueDate,
                    'status' => $netAmount === 0 ? 'Lunas' : 'Belum Lunas',
                    'paid_at' => $netAmount === 0 ? now() : null,
                    'notes' => $note,
                ]);

                $createdCount++;
            }
        }

        return back()->with('success', "Berhasil men-generate {$createdCount} tagihan SPP baru untuk periode: {$period}!");
    }

    /**
     * Record a full or partial (installment) payment for an invoice.
     */
    public function markAsPaid(Request $request, TuitionInvoice $invoice): RedirectResponse
    {
        $remaining = $invoice->remaining_amount;
        if ($remaining <= 0) {
            return back()->with('error', "Tagihan {$invoice->invoice_number} sudah lunas sepenuhnya.");
        }

        $validated = $request->validate([
            'amount' => ['nullable', 'integer', 'min:1', 'max:' . $remaining],
            'payment_date' => ['nullable', 'date'],
            'payment_method' => ['required', 'string', 'in:Transfer Bank,QRIS / E-Wallet,Tunai'],
            'received_by' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $payAmount = (int) ($validated['amount'] ?? $remaining);
        $paymentDate = $validated['payment_date'] ?? now()->toDateString();
        $receivedBy = $validated['received_by'] ?: (Auth::user()?->name ?? Setting::get('owner_name', 'Admin MustikaBimbel'));

        $monthStamp = Carbon::parse($paymentDate)->format('Ym');
        $seq = InvoicePayment::whereYear('payment_date', Carbon::parse($paymentDate)->year)
            ->whereMonth('payment_date', Carbon::parse($paymentDate)->month)
            ->count() + 1;
        $receiptNumber = sprintf('KWT-MB-%s-%03d', $monthStamp, $seq);
        while (InvoicePayment::where('receipt_number', $receiptNumber)->exists()) {
            $seq++;
            $receiptNumber = sprintf('KWT-MB-%s-%03d', $monthStamp, $seq);
        }

        $payment = InvoicePayment::create([
            'tuition_invoice_id' => $invoice->id,
            'receipt_number' => $receiptNumber,
            'payment_date' => $paymentDate,
            'amount' => $payAmount,
            'payment_method' => $validated['payment_method'],
            'received_by' => $receivedBy,
            'notes' => $validated['notes'] ?? null,
        ]);

        $invoice->syncPaymentStatus(
            $validated['payment_method'],
            $validated['notes'] ?? ($invoice->remaining_amount === 0 ? 'Lunas terverifikasi.' : 'Pembayaran cicilan diterima.')
        );
        $invoice->load('student');

        $waReceiptUrl = WhatsAppService::generatePaymentReceiptUrl($invoice, $payment);
        $statusLabel = $invoice->status === 'Lunas'
            ? "LUNAS (Kuitansi {$receiptNumber})"
            : "KURANG (Sisa Rp " . number_format($invoice->remaining_amount, 0, ',', '.') . ", Kuitansi {$receiptNumber})";

        return back()->with([
            'success' => "Pembayaran Rp " . number_format($payAmount, 0, ',', '.') . " untuk {$invoice->invoice_number} berhasil dicatat! Status: {$statusLabel}.",
            'wa_receipt_url' => $waReceiptUrl,
            'wa_receipt_student' => $invoice->student->full_name,
        ]);
    }

    /**
     * Delete a specific installment payment and recalculate invoice status.
     */
    public function destroyPayment(InvoicePayment $payment): RedirectResponse
    {
        $invoice = $payment->invoice;
        $receipt = $payment->receipt_number;
        $payment->delete();

        if ($invoice) {
            $invoice->syncPaymentStatus();
        }

        return back()->with('success', "Riwayat pembayaran {$receipt} dihapus dan status tagihan telah dihitung ulang.");
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
