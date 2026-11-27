@extends('layouts.admin')

@section('title', 'Dashboard Eksekutif — MustikaBimbel')
@section('header_title', 'Dashboard Operasional')
@section('breadcrumb', 'Ringkasan')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">

    <!-- ===== LEFT 7 COLS: 2x2 KPI Cards + Monthly Cashflow Bar Chart ===== -->
    <div class="col-span-12 space-y-4 md:space-y-6 xl:col-span-7">

        <!-- TailAdmin 2x2 KPI Grid -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6">
            <!-- Metric 1: Siswa Aktif -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 md:p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#0F2C59]/8 text-[#0F2C59]">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div class="mt-5 flex items-end justify-between gap-2">
                    <div>
                        <span class="text-sm font-medium text-slate-500">Siswa Aktif</span>
                        <h4 class="mt-1.5 text-2xl font-extrabold text-[#0F2C59] tracking-tight">{{ $totalStudents }}</h4>
                    </div>
                    <span class="inline-flex h-6 shrink-0 items-center gap-1 rounded-lg bg-[#0F2C59]/8 px-2.5 py-0.5 text-[11px] font-bold text-[#0F2C59]">
                        TK {{ $tkCount }} &bull; SD {{ $sdCount }} &bull; SMP {{ $smpCount }}
                    </span>
                </div>
            </div>

            <!-- Metric 2: Pendaftar Free Trial -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 md:p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#FACC15]/25 text-[#0F2C59]">
                    <i data-lucide="sparkles" class="w-6 h-6"></i>
                </div>
                <div class="mt-5 flex items-end justify-between gap-2">
                    <div>
                        <span class="text-sm font-medium text-slate-500">Pendaftar Trial Baru</span>
                        <h4 class="mt-1.5 text-2xl font-extrabold text-[#0F2C59] tracking-tight">{{ $newLeadsCount }}</h4>
                    </div>
                    <a href="{{ route('admin.leads.index') }}"
                       class="inline-flex h-6 shrink-0 items-center gap-1 rounded-lg {{ $newLeadsCount > 0 ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-600' }} px-2.5 py-0.5 text-xs font-bold hover:opacity-80">
                        <span>Total {{ $totalLeads }} Leads</span>
                        <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

            <!-- Metric 3: Laba Bersih Bulan Ini -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 md:p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                    <i data-lucide="wallet" class="w-6 h-6"></i>
                </div>
                <div class="mt-5 flex items-end justify-between gap-2">
                    <div class="min-w-0">
                        <span class="text-sm font-medium text-slate-500">Laba Bersih Bulan Ini</span>
                        <h4 class="mt-1.5 text-xl sm:text-2xl font-extrabold {{ $monthNetProfit >= 0 ? 'text-[#0F2C59]' : 'text-rose-600' }} tracking-tight truncate">
                            Rp {{ number_format($monthNetProfit, 0, ',', '.') }}
                        </h4>
                    </div>
                    <span class="inline-flex h-6 shrink-0 items-center gap-1 rounded-lg {{ $monthNetProfit >= 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-600' }} px-2 py-0.5 text-[11px] font-bold">
                        <i data-lucide="{{ $monthNetProfit >= 0 ? 'trending-up' : 'trending-down' }}" class="w-3.5 h-3.5"></i>
                        Masuk {{ number_format($monthCashIn / 1000, 0) }}rb
                    </span>
                </div>
            </div>

            <!-- Metric 4: Aktivitas Presensi & Jurnal -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 md:p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#0D9488]/12 text-[#0D9488]">
                    <i data-lucide="calendar-check-2" class="w-6 h-6"></i>
                </div>
                <div class="mt-5 flex items-end justify-between gap-2">
                    <div>
                        <span class="text-sm font-medium text-slate-500">Total Jurnal Belajar</span>
                        <h4 class="mt-1.5 text-2xl font-extrabold text-[#0F2C59] tracking-tight">{{ $totalSessionsCount }}</h4>
                    </div>
                    <a href="{{ route('admin.attendance.index') }}"
                       class="inline-flex h-6 shrink-0 items-center gap-1 rounded-lg bg-teal-50 px-2.5 py-0.5 text-xs font-bold text-[#0D9488] hover:bg-teal-100">
                        <span>Hari ini: {{ $todaySessionsCount }}</span>
                        <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Monthly Cashflow Bar Chart Card (TailAdmin Monthly Sales equivalent) -->
        <div class="rounded-2xl border border-slate-200 bg-white px-5 pt-5 pb-5 sm:px-6 sm:pt-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-[#0F2C59]">Arus Kas Bulanan (12 Bulan)</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Perbandingan Kas Masuk SPP &amp; Pengeluaran Operasional</p>
                </div>
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button type="button" @click="open = !open"
                            class="inline-flex size-8 items-center justify-center rounded-[10px] text-slate-500 hover:bg-slate-100 hover:text-[#0F2C59]">
                        <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                    </button>
                    <div x-show="open" x-cloak x-transition
                         class="absolute right-0 mt-1 w-44 rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg z-20">
                        <a href="{{ route('admin.reports.index') }}" class="block rounded-lg px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-[#0F2C59]">
                            Laporan Lengkap
                        </a>
                        <a href="{{ route('admin.expenses.index') }}" class="block rounded-lg px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-[#0F2C59]">
                            Catat Pengeluaran
                        </a>
                    </div>
                </div>
            </div>

            <div class="h-56">
                <canvas id="dashboardMonthlyBarChart"></canvas>
            </div>
        </div>
    </div>

    <!-- ===== RIGHT 5 COLS: Target SPP Bulan Ini (TailAdmin Monthly Target Gauge) ===== -->
    <div class="col-span-12 xl:col-span-5">
        <div class="flex h-full flex-col justify-between rounded-2xl border border-slate-200 bg-slate-100/90">
            <div class="flex flex-1 flex-col justify-between rounded-2xl bg-white px-5 pt-5 pb-6 sm:px-6 sm:pt-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-base font-bold text-[#0F2C59]">Target Tagihan SPP Bulan Ini</h3>
                        <p class="mt-0.5 text-xs text-slate-500">Realisasi penagihan periode {{ now()->translatedFormat('F Y') }}</p>
                    </div>
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button type="button" @click="open = !open"
                                class="inline-flex size-8 items-center justify-center rounded-[10px] text-slate-500 hover:bg-slate-100 hover:text-[#0F2C59]">
                            <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                        </button>
                        <div x-show="open" x-cloak x-transition
                             class="absolute right-0 mt-1 w-44 rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg z-20">
                            <a href="{{ route('admin.invoices.index') }}" class="block rounded-lg px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-[#0F2C59]">
                                Kelola Tagihan
                            </a>
                            <a href="{{ route('admin.invoices.card') }}" class="block rounded-lg px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-[#0F2C59]">
                                Kartu SPP 12 Bulan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Semi-Circle Gauge -->
                <div class="my-4 flex flex-col items-center">
                    <div class="relative w-64 h-36">
                        <canvas id="dashboardTargetGauge"></canvas>
                        <div class="absolute inset-x-0 bottom-3 flex flex-col items-center">
                            <span class="text-3xl font-extrabold text-[#0F2C59]">{{ $monthCollectionPct }}%</span>
                            <span class="mt-1 inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700">
                                Terkumpul {{ number_format($monthCollected / 1000, 0) }}rb
                            </span>
                        </div>
                    </div>

                    <p class="mt-4 max-w-xs text-center text-xs sm:text-sm text-slate-500 leading-relaxed">
                        @if($monthRemaining > 0)
                            Masih ada <strong class="text-rose-600">Rp {{ number_format($monthRemaining, 0, ',', '.') }}</strong> tagihan bulan ini yang menunggu pelunasan/cicilan.
                        @else
                            Luar biasa! Seluruh tagihan SPP bulan berjalan telah terkumpul lunas.
                        @endif
                    </p>
                </div>

                <!-- Quick Action Strip -->
                <div class="flex items-center justify-center gap-2 pt-2">
                    <a href="{{ route('admin.attendance.index') }}"
                       class="inline-flex items-center gap-1.5 rounded-[10px] bg-[#0F2C59] hover:bg-[#163A70] px-3.5 py-2 text-xs font-bold text-[#FACC15] transition-colors">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                        <span>Presensi Kelas</span>
                    </a>
                    <a href="{{ route('admin.invoices.card') }}"
                       class="inline-flex items-center gap-1.5 rounded-[10px] border border-slate-200 bg-white hover:bg-slate-50 px-3.5 py-2 text-xs font-bold text-[#0F2C59] transition-colors">
                        <i data-lucide="grid-3x3" class="w-3.5 h-3.5 text-[#0D9488]"></i>
                        <span>Kartu SPP</span>
                    </a>
                </div>
            </div>

            <!-- 3-Column Footer inside Gray Tray (TailAdmin exact signature) -->
            <div class="flex items-center justify-center gap-4 px-4 py-4 sm:gap-7 sm:py-5">
                <div class="text-center">
                    <p class="mb-1 text-[11px] font-medium text-slate-500">Target Bulan Ini</p>
                    <p class="text-sm sm:text-base font-extrabold text-[#0F2C59]">
                        Rp {{ number_format($monthBilledTarget, 0, ',', '.') }}
                    </p>
                </div>
                <div class="h-7 w-px bg-slate-200"></div>
                <div class="text-center">
                    <p class="mb-1 text-[11px] font-medium text-slate-500">Sudah Masuk</p>
                    <p class="text-sm sm:text-base font-extrabold text-emerald-700">
                        Rp {{ number_format($monthCollected, 0, ',', '.') }}
                    </p>
                </div>
                <div class="h-7 w-px bg-slate-200"></div>
                <div class="text-center">
                    <p class="mb-1 text-[11px] font-medium text-slate-500">Total Tunggakan</p>
                    <p class="text-sm sm:text-base font-extrabold text-rose-600">
                        Rp {{ number_format($unpaidInvoicesSum, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== FULL-WIDTH ROW: Statistics Area Chart with Segmented Tabs ===== -->
    <div class="col-span-12"
         x-data="{
            statTab: 'all',
            switchTab(t) {
                this.statTab = t;
                if (window.updateDashboardStatChart) {
                    window.updateDashboardStatChart(t);
                }
            }
         }">
        <div class="rounded-2xl border border-slate-200 bg-white px-5 pt-5 pb-5 sm:px-6 sm:pt-6">
            <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-base font-bold text-[#0F2C59]">Statistik Kinerja Keuangan</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Tren Kas Masuk, Pengeluaran &amp; Laba Bersih periode 12 bulan</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-0.5 rounded-[10px] bg-slate-100 p-0.5">
                        <button type="button" @click="switchTab('all')"
                                :class="statTab === 'all' ? 'bg-white text-[#0F2C59] font-bold shadow-2xs' : 'text-slate-500 hover:text-[#0F2C59]'"
                                class="h-8 rounded-lg px-3 text-xs transition-colors">
                            Semua
                        </button>
                        <button type="button" @click="switchTab('cash')"
                                :class="statTab === 'cash' ? 'bg-white text-[#0F2C59] font-bold shadow-2xs' : 'text-slate-500 hover:text-[#0F2C59]'"
                                class="h-8 rounded-lg px-3 text-xs transition-colors">
                            Kas Masuk
                        </button>
                        <button type="button" @click="switchTab('profit')"
                                :class="statTab === 'profit' ? 'bg-white text-[#0F2C59] font-bold shadow-2xs' : 'text-slate-500 hover:text-[#0F2C59]'"
                                class="h-8 rounded-lg px-3 text-xs transition-colors">
                            Laba Bersih
                        </button>
                    </div>

                    <a href="{{ route('admin.reports.export') }}"
                       class="inline-flex h-9 items-center gap-1.5 rounded-[10px] border border-slate-200 bg-white px-3 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#0F2C59]">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        <span>Export CSV</span>
                    </a>
                </div>
            </div>

            <div class="h-64">
                <canvas id="dashboardStatisticsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- ===== BOTTOM LEFT 5 COLS: Sebaran Jenjang & Kuota Jadwal ===== -->
    <div class="col-span-12 xl:col-span-5">
        <div class="h-full rounded-2xl border border-slate-200 bg-white p-5 sm:p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-base font-bold text-[#0F2C59]">Sebaran Siswa &amp; Kuota Jadwal</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Keterisian kursi kelas resmi MustikaBimbel</p>
                </div>
                <a href="{{ route('admin.schedules.index') }}"
                   class="inline-flex items-center gap-1 rounded-[10px] border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#0F2C59]">
                    Atur
                </a>
            </div>

            <!-- Boxed Grade Breakdown (mirrors TailAdmin map container) -->
            @php
                $safeTotal = max(1, $totalStudents);
                $tkPct = round(($tkCount / $safeTotal) * 100);
                $sdPct = round(($sdCount / $safeTotal) * 100);
                $smpPct = round(($smpCount / $safeTotal) * 100);
            @endphp
            <div class="my-5 rounded-2xl border border-slate-200 bg-slate-50/70 p-4 space-y-3">
                <div class="flex items-center justify-between text-xs">
                    <span class="font-bold text-[#0F2C59]">Jenjang TK (Jarimatika)</span>
                    <span class="font-bold text-slate-700">{{ $tkCount }} Siswa ({{ $tkPct }}%)</span>
                </div>
                <div class="w-full h-2 rounded-full bg-slate-200 overflow-hidden">
                    <div class="h-full bg-[#FACC15] rounded-full" style="width: {{ $tkPct }}%"></div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <span class="font-bold text-[#0F2C59]">Jenjang SD (MIPA &amp; Jarimatika)</span>
                    <span class="font-bold text-slate-700">{{ $sdCount }} Siswa ({{ $sdPct }}%)</span>
                </div>
                <div class="w-full h-2 rounded-full bg-slate-200 overflow-hidden">
                    <div class="h-full bg-[#0D9488] rounded-full" style="width: {{ $sdPct }}%"></div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <span class="font-bold text-[#0F2C59]">Jenjang SMP (MIPA &amp; Ujian)</span>
                    <span class="font-bold text-slate-700">{{ $smpCount }} Siswa ({{ $smpPct }}%)</span>
                </div>
                <div class="w-full h-2 rounded-full bg-slate-200 overflow-hidden">
                    <div class="h-full bg-[#0F2C59] rounded-full" style="width: {{ $smpPct }}%"></div>
                </div>
            </div>

            <!-- Schedule Rows -->
            <div class="space-y-4">
                @foreach($schedules as $sch)
                    @php
                        $pct = $sch->max_quota > 0 ? min(100, round(($sch->filled_quota / $sch->max_quota) * 100)) : 0;
                    @endphp
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="size-9 rounded-lg bg-[#0F2C59]/8 text-[#0F2C59] flex items-center justify-center shrink-0">
                                <i data-lucide="clock-3" class="w-4 h-4"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-[#0F2C59] truncate">{{ $sch->days_text }}</p>
                                <span class="block text-[11px] text-slate-500">{{ $sch->start_time }}–{{ $sch->end_time }} WIB &bull; {{ $sch->filled_quota }}/{{ $sch->max_quota }} Kursi</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <div class="w-20 h-1.5 rounded-full bg-slate-200 overflow-hidden">
                                <div class="h-full rounded-full {{ $sch->remaining_quota <= 2 ? 'bg-amber-500' : 'bg-[#0D9488]' }}" style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="text-xs font-bold text-slate-700 w-9 text-right">{{ $pct }}%</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ===== BOTTOM RIGHT 7 COLS: Recent Trial Leads & Top Arrears Table (TailAdmin Recent Orders) ===== -->
    <div class="col-span-12 xl:col-span-7" x-data="{ listTab: 'leads' }">
        <div class="h-full overflow-hidden rounded-2xl border border-slate-200 bg-white px-4 pt-5 pb-4 sm:px-6">
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-base font-bold text-[#0F2C59]">
                        <span x-show="listTab === 'leads'">Pendaftar Trial Terbaru</span>
                        <span x-show="listTab === 'arrears'" x-cloak>Tunggakan SPP Perlu Diingatkan</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Aksi cepat follow-up WhatsApp orang tua</p>
                </div>

                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-0.5 rounded-[10px] bg-slate-100 p-0.5">
                        <button type="button" @click="listTab = 'leads'"
                                :class="listTab === 'leads' ? 'bg-white text-[#0F2C59] font-bold shadow-2xs' : 'text-slate-500'"
                                class="h-8 rounded-lg px-3 text-xs transition-colors">
                            Trial ({{ $recentLeads->count() }})
                        </button>
                        <button type="button" @click="listTab = 'arrears'"
                                :class="listTab === 'arrears' ? 'bg-white text-rose-700 font-bold shadow-2xs' : 'text-slate-500'"
                                class="h-8 rounded-lg px-3 text-xs transition-colors">
                            Tunggakan ({{ $topArrears->count() }})
                        </button>
                    </div>

                    <a :href="listTab === 'leads' ? '{{ route('admin.leads.index') }}' : '{{ route('admin.invoices.card') }}'"
                       class="inline-flex h-9 items-center justify-center rounded-[10px] border border-slate-200 bg-white px-3.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#0F2C59]">
                        Lihat Semua
                    </a>
                </div>
            </div>

            <!-- Table 1: Recent Trial Leads -->
            <div x-show="listTab === 'leads'" class="max-w-full overflow-x-auto">
                <table class="min-w-full">
                    <thead class="border-y border-slate-100">
                        <tr>
                            <th class="py-3 text-left text-xs font-semibold text-slate-500">Calon Siswa</th>
                            <th class="py-3 text-left text-xs font-semibold text-slate-500">Program</th>
                            <th class="py-3 text-left text-xs font-semibold text-slate-500">Skor Kuis</th>
                            <th class="py-3 text-left text-xs font-semibold text-slate-500">Status</th>
                            <th class="py-3 text-right text-xs font-semibold text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentLeads as $lead)
                            <tr class="hover:bg-slate-50/70">
                                <td class="py-3 pr-3">
                                    <div class="flex items-center gap-3">
                                        <div class="size-10 rounded-[10px] bg-[#0F2C59]/8 text-[#0F2C59] flex items-center justify-center font-extrabold text-xs shrink-0">
                                            {{ strtoupper(substr($lead->student_name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-xs sm:text-sm font-bold text-[#0F2C59]">{{ $lead->student_name }}</p>
                                            <span class="text-[11px] text-slate-500">{{ $lead->parent_name }} &bull; {{ $lead->grade_level }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 pr-3 text-xs text-slate-600 font-medium">
                                    {{ $lead->program?->category ?? 'MIPA' }}
                                </td>
                                <td class="py-3 pr-3 text-xs font-bold text-slate-700">
                                    {{ $lead->quiz_score !== null ? $lead->quiz_score . '/100' : '-' }}
                                </td>
                                <td class="py-3 pr-3">
                                    <span class="inline-flex items-center rounded-lg px-2 py-0.5 text-[11px] font-bold {{ $lead->status === 'Baru' ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700' }}">
                                        {{ $lead->status }}
                                    </span>
                                </td>
                                <td class="py-3 text-right">
                                    <a href="{{ App\Services\WhatsAppService::generateLeadFollowUpUrl($lead) }}" target="_blank"
                                       class="inline-flex items-center gap-1 rounded-[10px] bg-emerald-600 hover:bg-emerald-700 px-2.5 py-1.5 text-[11px] font-bold text-white">
                                        <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                        <span>WA</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-xs text-slate-400">Belum ada pendaftar trial baru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table 2: Top Arrears -->
            <div x-show="listTab === 'arrears'" x-cloak class="max-w-full overflow-x-auto">
                <table class="min-w-full">
                    <thead class="border-y border-slate-100">
                        <tr>
                            <th class="py-3 text-left text-xs font-semibold text-slate-500">Siswa</th>
                            <th class="py-3 text-left text-xs font-semibold text-slate-500">Jml Bulan</th>
                            <th class="py-3 text-left text-xs font-semibold text-slate-500">Total Tunggakan</th>
                            <th class="py-3 text-right text-xs font-semibold text-slate-500">Reminder</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($topArrears as $item)
                            <tr class="hover:bg-slate-50/70">
                                <td class="py-3 pr-3">
                                    <a href="{{ route('admin.students.show', $item['student']) }}" class="text-xs sm:text-sm font-bold text-[#0F2C59] hover:underline block">
                                        {{ $item['student']->full_name }}
                                    </a>
                                    <span class="text-[11px] text-slate-500">{{ $item['student']->student_code }} &bull; {{ $item['student']->parent_name }}</span>
                                </td>
                                <td class="py-3 pr-3 text-xs font-semibold text-slate-600">{{ $item['open_count'] }} bln</td>
                                <td class="py-3 pr-3 text-xs sm:text-sm font-extrabold text-rose-600">
                                    Rp {{ number_format($item['arrears'], 0, ',', '.') }}
                                </td>
                                <td class="py-3 text-right">
                                    @if($item['reminder_url'])
                                        <a href="{{ $item['reminder_url'] }}" target="_blank"
                                           class="inline-flex items-center gap-1 rounded-[10px] bg-emerald-600 hover:bg-emerald-700 px-2.5 py-1.5 text-[11px] font-bold text-white">
                                            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                            <span>Ingatkan WA</span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-xs text-emerald-700 font-semibold">Semua tagihan SPP siswa sudah lunas!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const labels = @json($chartLabels);
    const cashInData = @json($chartCashIn);
    const expenseData = @json($chartExpenses);
    const profitData = @json($chartNetProfit);

    // 1. Monthly Bar Chart
    const barCtx = document.getElementById('dashboardMonthlyBarChart');
    if (barCtx) {
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Kas Masuk',
                        data: cashInData,
                        backgroundColor: '#0F2C59',
                        borderRadius: 6,
                        barPercentage: 0.55
                    },
                    {
                        label: 'Pengeluaran',
                        data: expenseData,
                        backgroundColor: '#FACC15',
                        borderRadius: 6,
                        barPercentage: 0.55
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', align: 'end', labels: { boxWidth: 10, usePointStyle: true } }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, grid: { color: '#F1F5F9' } }
                }
            }
        });
    }

    // 2. Semi-Circle Target Gauge Chart
    const gaugeCtx = document.getElementById('dashboardTargetGauge');
    if (gaugeCtx) {
        const pct = {{ (int) $monthCollectionPct }};
        new Chart(gaugeCtx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [pct, Math.max(0, 100 - pct)],
                    backgroundColor: ['#0F2C59', '#E2E8F0'],
                    borderWidth: 0,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                circumference: 180,
                rotation: 270,
                cutout: '78%',
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                }
            }
        });
    }

    // 3. Statistics Area Chart with Dynamic Tab Switching
    const statCtx = document.getElementById('dashboardStatisticsChart');
    if (statCtx) {
        const allDatasets = [
            {
                label: 'Kas Masuk',
                data: cashInData,
                borderColor: '#0D9488',
                backgroundColor: 'rgba(13, 148, 136, 0.12)',
                fill: true,
                tension: 0.35,
                borderWidth: 2.5
            },
            {
                label: 'Laba Bersih',
                data: profitData,
                borderColor: '#0F2C59',
                backgroundColor: 'rgba(15, 44, 89, 0.08)',
                fill: true,
                tension: 0.35,
                borderWidth: 2.5
            }
        ];

        const statChart = new Chart(statCtx, {
            type: 'line',
            data: { labels, datasets: allDatasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', align: 'end', labels: { boxWidth: 10, usePointStyle: true } }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, grid: { color: '#F1F5F9' } }
                }
            }
        });

        window.updateDashboardStatChart = (tab) => {
            if (tab === 'cash') {
                statChart.data.datasets = [allDatasets[0]];
            } else if (tab === 'profit') {
                statChart.data.datasets = [allDatasets[1]];
            } else {
                statChart.data.datasets = allDatasets;
            }
            statChart.update();
        };
    }
});
</script>
@endpush
