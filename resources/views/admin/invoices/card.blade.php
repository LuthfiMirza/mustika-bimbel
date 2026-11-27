@extends('layouts.admin')

@section('title', 'Kartu SPP 12 Bulan — MustikaBimbel')
@section('header_title', 'Kartu SPP Siswa 12 Bulan & Reminder Tunggakan')

@section('content')
<div class="space-y-6">
    <!-- Sub-Navigation Tabs + Period Picker -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="inline-flex p-1 rounded-2xl bg-white border border-slate-200 shadow-sm">
            <a href="{{ route('admin.invoices.index') }}"
               class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-[#0F2C59] flex items-center gap-1.5">
                <i data-lucide="list-checks" class="w-3.5 h-3.5"></i>
                <span>Daftar Tagihan &amp; Cicilan</span>
            </a>
            <a href="{{ route('admin.invoices.card') }}"
               class="px-4 py-2 rounded-xl text-xs font-extrabold bg-[#0F2C59] text-[#FACC15] shadow-sm flex items-center gap-1.5">
                <i data-lucide="grid-3x3" class="w-3.5 h-3.5"></i>
                <span>Kartu SPP 12 Bulan</span>
            </a>
        </div>

        <form method="GET" action="{{ route('admin.invoices.card') }}" class="flex items-center gap-2">
            <label class="text-xs font-bold text-slate-600">Mulai Bulan:</label>
            <input type="month" name="start_month" value="{{ $startMonthStr }}" onchange="this.form.submit()"
                   class="px-3 py-1.5 rounded-xl border border-slate-300 text-xs font-bold bg-white outline-none focus:ring-2 focus:ring-[#0F2C59]">
        </form>
    </div>

    <!-- Summary Strip -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <span class="text-[11px] font-extrabold uppercase text-slate-500">Siswa Dengan Tunggakan</span>
            <div class="text-2xl font-extrabold text-rose-600 mt-1">{{ $studentsWithArrearsCount }} Siswa</div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <span class="text-[11px] font-extrabold uppercase text-slate-500">Total Tunggakan (Semua Bulan)</span>
            <div class="text-2xl font-extrabold text-amber-600 mt-1">Rp {{ number_format($totalArrearsAll, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-center">
            <span class="text-[11px] font-extrabold uppercase text-slate-500 mb-1.5">Legenda Status</span>
            <div class="flex flex-wrap gap-1.5 text-[10px] font-extrabold">
                <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">LUNAS</span>
                <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-800">KURANG</span>
                <span class="px-2 py-0.5 rounded bg-rose-100 text-rose-800">BELUM</span>
                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-500">- (Belum/Nonaktif)</span>
            </div>
        </div>
    </div>

    <!-- 12-Month Matrix Card Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 border-collapse">
                <thead class="bg-[#0F2C59] text-white text-[10px] uppercase tracking-wider font-extrabold">
                    <tr>
                        <th class="px-4 py-3.5 sticky left-0 bg-[#0F2C59] z-10 min-w-[180px]">Siswa &amp; SPP/Bln</th>
                        @foreach($months as $m)
                            <th class="px-2.5 py-3.5 text-center whitespace-nowrap">{{ $m['short'] }}</th>
                        @endforeach
                        <th class="px-4 py-3.5 text-right whitespace-nowrap">Total Tunggakan</th>
                        <th class="px-4 py-3.5 text-center whitespace-nowrap">Reminder WA</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rows as $row)
                        @php($s = $row['student'])
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-3 sticky left-0 bg-white z-10 border-r border-slate-100">
                                <div class="font-extrabold text-[#0F2C59] text-xs">{{ $s->full_name }}</div>
                                <div class="text-[10px] text-slate-500">
                                    Rp {{ number_format($s->net_monthly_fee, 0, ',', '.') }}/bln
                                    @if($s->monthly_discount > 0)
                                        <span class="text-teal-700 font-bold">(Diskon {{ number_format($s->monthly_discount / 1000, 0) }}rb)</span>
                                    @endif
                                </div>
                            </td>

                            @foreach($months as $m)
                                @php($cell = $row['cells'][$m['key']])
                                <td class="px-2 py-3 text-center whitespace-nowrap">
                                    @if($cell['state'] === 'Lunas')
                                        <span class="inline-block px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 font-extrabold text-[10px]">LUNAS</span>
                                    @elseif($cell['state'] === 'Kurang')
                                        <span class="inline-block px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 font-extrabold text-[10px]"
                                              title="Sisa Rp {{ number_format($cell['remaining'], 0, ',', '.') }}">
                                            KURANG
                                        </span>
                                    @elseif($cell['state'] === 'Belum Lunas')
                                        <span class="inline-block px-2 py-0.5 rounded-md bg-rose-100 text-rose-800 font-extrabold text-[10px]">BELUM</span>
                                    @elseif($cell['state'] === 'Belum Ditagih')
                                        <span class="text-slate-300 text-[10px]">&bull;</span>
                                    @else
                                        <span class="text-slate-300 text-[10px]">-</span>
                                    @endif
                                </td>
                            @endforeach

                            <td class="px-4 py-3 text-right whitespace-nowrap font-extrabold {{ $row['arrears'] > 0 ? 'text-rose-600' : 'text-emerald-700' }}">
                                {{ $row['arrears'] > 0 ? 'Rp ' . number_format($row['arrears'], 0, ',', '.') : 'Rp 0' }}
                            </td>

                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                @if($row['reminder_url'])
                                    <a href="{{ $row['reminder_url'] }}" target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-extrabold shadow-sm">
                                        <i data-lucide="message-circle" class="w-3 h-3"></i>
                                        <span>Kirim WA</span>
                                    </a>
                                @else
                                    <span class="text-[10px] text-emerald-600 font-bold">Aman ✓</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="px-5 py-10 text-center text-slate-400">Belum ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-slate-50 border-t-2 border-slate-200 font-extrabold text-[10px] text-[#0F2C59]">
                    <tr>
                        <td class="px-4 py-3 sticky left-0 bg-slate-50 z-10 border-r border-slate-200">Terkumpul / Bulan</td>
                        @foreach($months as $m)
                            <td class="px-2 py-3 text-center whitespace-nowrap">
                                {{ $monthCollected[$m['key']] > 0 ? number_format($monthCollected[$m['key']] / 1000, 0) . 'rb' : '-' }}
                            </td>
                        @endforeach
                        <td class="px-4 py-3 text-right text-rose-600 whitespace-nowrap">
                            Rp {{ number_format($totalArrearsAll, 0, ',', '.') }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
