@extends('layouts.admin')

@section('title', 'Laporan Keuangan & Laba Bersih — MustikaBimbel')
@section('header_title', 'Laporan Keuangan & Laba Bersih Bulanan')

@section('content')
<div class="space-y-6">

    <!-- Top Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Rekap Laba Rugi 12 Bulan</span>
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#0F2C59]">Kas Masuk, Pengeluaran &amp; Laba Bersih</h2>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <form method="GET" action="{{ route('admin.reports.index') }}" class="flex items-center gap-2">
                <label class="text-xs font-bold text-slate-600">Periode Mulai:</label>
                <input type="month" name="start_month" value="{{ $startMonthStr }}" onchange="this.form.submit()"
                       class="px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold bg-white outline-none">
            </form>
            <a href="{{ route('admin.reports.export', ['start_month' => $startMonthStr]) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0F2C59] hover:bg-[#163A70] text-[#FACC15] text-xs font-extrabold shadow-sm">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>Export CSV</span>
            </a>
        </div>
    </div>

    <!-- Period KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-200">
            <span class="text-[11px] font-extrabold uppercase text-slate-500">Total Kas Masuk (12 Bln)</span>
            <div class="text-2xl font-extrabold text-emerald-700 mt-1.5">Rp {{ number_format($totals['cash_in'], 0, ',', '.') }}</div>
            <p class="text-[11px] text-slate-500 mt-1">Tingkat Tertagih: <strong>{{ $totals['collection_rate'] }}%</strong></p>
        </div>
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-200">
            <span class="text-[11px] font-extrabold uppercase text-slate-500">Total Pengeluaran (12 Bln)</span>
            <div class="text-2xl font-extrabold text-rose-600 mt-1.5">Rp {{ number_format($totals['expenses'], 0, ',', '.') }}</div>
            <p class="text-[11px] text-slate-500 mt-1">Operasional, modul, listrik, dll.</p>
        </div>
        <div class="bg-[#0F2C59] text-white rounded-3xl p-5 shadow-md">
            <span class="text-[11px] font-extrabold uppercase text-[#FACC15]">Laba Bersih Periode</span>
            <div class="text-2xl font-extrabold mt-1.5">Rp {{ number_format($totals['net_profit'], 0, ',', '.') }}</div>
            <p class="text-[11px] text-slate-300 mt-1">Kas Masuk &minus; Pengeluaran</p>
        </div>
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-200">
            <span class="text-[11px] font-extrabold uppercase text-slate-500">Total SPP Tertagih</span>
            <div class="text-2xl font-extrabold text-[#0F2C59] mt-1.5">Rp {{ number_format($totals['spp_billed'], 0, ',', '.') }}</div>
            <p class="text-[11px] text-slate-500 mt-1">Terbayar: Rp {{ number_format($totals['spp_paid'], 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Chart.js Financial Trend -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-extrabold text-[#0F2C59]">Grafik Arus Kas &amp; Laba Bersih (12 Bulan)</h3>
        </div>
        <div class="h-64">
            <canvas id="financialTrendChart"></canvas>
        </div>
    </div>

    <!-- 12-Month Financial Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-extrabold border-b border-slate-200 text-[10px]">
                    <tr>
                        <th class="px-5 py-3.5">Bulan</th>
                        <th class="px-4 py-3.5 text-center">Siswa Tertagih</th>
                        <th class="px-4 py-3.5 text-right">SPP Tertagih</th>
                        <th class="px-4 py-3.5 text-right">SPP Terbayar</th>
                        <th class="px-4 py-3.5 text-center">% Terkumpul</th>
                        <th class="px-4 py-3.5 text-right">Kas Masuk Aktual</th>
                        <th class="px-4 py-3.5 text-right">Pengeluaran</th>
                        <th class="px-5 py-3.5 text-right">Laba Bersih</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($rows as $row)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-5 py-3.5 font-extrabold text-[#0F2C59] whitespace-nowrap">{{ $row['full_label'] }}</td>
                            <td class="px-4 py-3.5 text-center font-bold">{{ $row['billed_students'] }}</td>
                            <td class="px-4 py-3.5 text-right whitespace-nowrap">Rp {{ number_format($row['spp_billed'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3.5 text-right whitespace-nowrap text-emerald-700 font-semibold">Rp {{ number_format($row['spp_paid'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3.5 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $row['collection_rate'] >= 80 ? 'bg-emerald-100 text-emerald-800' : ($row['collection_rate'] > 0 ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-500') }}">
                                    {{ $row['collection_rate'] }}%
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right whitespace-nowrap font-bold text-emerald-700">Rp {{ number_format($row['cash_in'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3.5 text-right whitespace-nowrap font-bold text-rose-600">Rp {{ number_format($row['expenses'], 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap font-extrabold {{ $row['net_profit'] >= 0 ? 'text-[#0F2C59]' : 'text-rose-700' }}">
                                Rp {{ number_format($row['net_profit'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-[#0F2C59] text-white font-extrabold text-xs">
                    <tr>
                        <td class="px-5 py-4">TOTAL PERIODE</td>
                        <td class="px-4 py-4 text-center">{{ $totals['billed_students'] }}</td>
                        <td class="px-4 py-4 text-right whitespace-nowrap">Rp {{ number_format($totals['spp_billed'], 0, ',', '.') }}</td>
                        <td class="px-4 py-4 text-right whitespace-nowrap">Rp {{ number_format($totals['spp_paid'], 0, ',', '.') }}</td>
                        <td class="px-4 py-4 text-center">{{ $totals['collection_rate'] }}%</td>
                        <td class="px-4 py-4 text-right whitespace-nowrap text-emerald-300">Rp {{ number_format($totals['cash_in'], 0, ',', '.') }}</td>
                        <td class="px-4 py-4 text-right whitespace-nowrap text-rose-300">Rp {{ number_format($totals['expenses'], 0, ',', '.') }}</td>
                        <td class="px-5 py-4 text-right whitespace-nowrap text-[#FACC15]">Rp {{ number_format($totals['net_profit'], 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('financialTrendChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json(array_column($rows, 'short_label')),
            datasets: [
                {
                    label: 'Kas Masuk',
                    data: @json(array_column($rows, 'cash_in')),
                    backgroundColor: '#0D9488',
                    borderRadius: 6
                },
                {
                    label: 'Pengeluaran',
                    data: @json(array_column($rows, 'expenses')),
                    backgroundColor: '#F43F5E',
                    borderRadius: 6
                },
                {
                    label: 'Laba Bersih',
                    data: @json(array_column($rows, 'net_profit')),
                    type: 'line',
                    borderColor: '#0F2C59',
                    backgroundColor: '#FACC15',
                    borderWidth: 3,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
</script>
@endpush
