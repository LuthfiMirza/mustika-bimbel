<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\InvoicePayment;
use App\Models\Setting;
use App\Models\TuitionInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FinancialReportController extends Controller
{
    /**
     * Build 12-month financial report rows and period totals.
     *
     * @return array{startMonthStr: string, rows: array<int, array<string, mixed>>, totals: array<string, int|float>}
     */
    public static function buildMonthlyReport(?string $startMonthInput = null): array
    {
        $startMonthStr = $startMonthInput ?: Setting::get('period_start_month', '2026-07');
        if (! preg_match('/^\d{4}-\d{2}$/', $startMonthStr)) {
            $startMonthStr = '2026-07';
        }

        $startCarbon = Carbon::createFromFormat('Y-m', $startMonthStr)->startOfMonth();
        $endCarbon = $startCarbon->copy()->addMonths(11)->endOfMonth();

        $allInvoices = TuitionInvoice::all();
        $allPayments = InvoicePayment::whereBetween('payment_date', [$startCarbon->toDateString(), $endCarbon->toDateString()])->get();
        $allExpenses = Expense::whereBetween('expense_date', [$startCarbon->toDateString(), $endCarbon->toDateString()])->get();

        // Map legacy paid invoices without invoice_payments rows so kas masuk stays accurate
        $invoiceIdsWithPayments = InvoicePayment::pluck('tuition_invoice_id')->unique()->flip();

        $rows = [];
        $totals = [
            'billed_students' => 0,
            'spp_billed' => 0,
            'spp_paid' => 0,
            'cash_in' => 0,
            'expenses' => 0,
            'net_profit' => 0,
        ];

        for ($i = 0; $i < 12; $i++) {
            $m = $startCarbon->copy()->addMonths($i);
            $ym = $m->format('Y-m');

            $monthInvoices = $allInvoices->filter(function (TuitionInvoice $inv) use ($ym) {
                $key = $inv->billing_month ?: $inv->due_date?->format('Y-m');
                return $key === $ym;
            });

            $billedStudents = $monthInvoices->pluck('student_id')->unique()->count();
            $sppBilled = (int) $monthInvoices->sum('amount');
            $sppPaid = (int) $monthInvoices->sum(fn($inv) => $inv->status === 'Lunas' && (int) $inv->paid_amount === 0 ? (int) $inv->amount : (int) $inv->paid_amount);
            $collectionRate = $sppBilled > 0 ? round(($sppPaid / $sppBilled) * 100, 1) : 0;

            $paymentsCashIn = (int) $allPayments
                ->filter(fn($p) => $p->payment_date->format('Y-m') === $ym)
                ->sum('amount');

            $legacyCashIn = (int) $allInvoices
                ->filter(fn($inv) => ! isset($invoiceIdsWithPayments[$inv->id]) && $inv->status === 'Lunas' && $inv->paid_at && $inv->paid_at->format('Y-m') === $ym)
                ->sum('amount');

            $cashIn = $paymentsCashIn + $legacyCashIn;
            $expensesSum = (int) $allExpenses
                ->filter(fn($e) => $e->expense_date->format('Y-m') === $ym)
                ->sum('amount');

            $netProfit = $cashIn - $expensesSum;

            $rows[] = [
                'key' => $ym,
                'short_label' => $m->translatedFormat('M Y'),
                'full_label' => $m->translatedFormat('F Y'),
                'billed_students' => $billedStudents,
                'spp_billed' => $sppBilled,
                'spp_paid' => $sppPaid,
                'collection_rate' => $collectionRate,
                'cash_in' => $cashIn,
                'expenses' => $expensesSum,
                'net_profit' => $netProfit,
            ];

            $totals['billed_students'] += $billedStudents;
            $totals['spp_billed'] += $sppBilled;
            $totals['spp_paid'] += $sppPaid;
            $totals['cash_in'] += $cashIn;
            $totals['expenses'] += $expensesSum;
            $totals['net_profit'] += $netProfit;
        }

        $totals['collection_rate'] = $totals['spp_billed'] > 0
            ? round(($totals['spp_paid'] / $totals['spp_billed']) * 100, 1)
            : 0;

        return compact('startMonthStr', 'rows', 'totals');
    }

    /**
     * Display 12-month financial & net profit report.
     */
    public function index(Request $request): View
    {
        $data = self::buildMonthlyReport($request->query('start_month'));

        return view('admin.reports.index', $data);
    }

    /**
     * Export 12-month financial report as CSV.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $data = self::buildMonthlyReport($request->query('start_month'));
        $filename = 'laporan-keuangan-mustikabimbel-' . $data['startMonthStr'] . '.csv';

        return response()->streamDownload(function () use ($data) {
            $out = fopen('php://output', 'w');
            // UTF-8 BOM for Excel compatibility
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Bulan', 'Siswa Tertagih', 'SPP Tertagih (Rp)', 'SPP Terbayar (Rp)', '% Terkumpul', 'Kas Masuk Aktual (Rp)', 'Pengeluaran (Rp)', 'Laba Bersih (Rp)']);

            foreach ($data['rows'] as $row) {
                fputcsv($out, [
                    $row['full_label'],
                    $row['billed_students'],
                    $row['spp_billed'],
                    $row['spp_paid'],
                    $row['collection_rate'] . '%',
                    $row['cash_in'],
                    $row['expenses'],
                    $row['net_profit'],
                ]);
            }

            fputcsv($out, [
                'TOTAL PERIODE',
                $data['totals']['billed_students'],
                $data['totals']['spp_billed'],
                $data['totals']['spp_paid'],
                $data['totals']['collection_rate'] . '%',
                $data['totals']['cash_in'],
                $data['totals']['expenses'],
                $data['totals']['net_profit'],
            ]);
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
