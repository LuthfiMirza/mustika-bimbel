@extends('layouts.admin')

@section('title', 'Dashboard Eksekutif — MustikaBimbel')
@section('header_title', 'Dashboard Ringkasan Operasional')

@section('content')
<div class="space-y-8">

    <!-- KPI Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Siswa Aktif -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Siswa Aktif</span>
                <div class="w-10 h-10 rounded-2xl bg-[#0F2C59] text-[#FACC15] flex items-center justify-center font-extrabold shadow-sm">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-extrabold text-[#0F2C59]">{{ $totalStudents }}</span>
                <span class="text-xs text-slate-500 ml-1">Anak Binaan</span>
                <div class="flex items-center gap-2 text-[11px] font-bold text-slate-600 mt-2">
                    <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-800">TK: {{ $tkCount }}</span>
                    <span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-800">SD: {{ $sdCount }}</span>
                    <span class="px-2 py-0.5 rounded-md bg-purple-100 text-purple-800">SMP: {{ $smpCount }}</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Pendaftar Trial Baru -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Pendaftar Free Trial</span>
                <div class="w-10 h-10 rounded-2xl bg-[#FACC15] text-[#0F2C59] flex items-center justify-center font-extrabold shadow-sm">
                    <i data-lucide="sparkles" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-amber-600">{{ $newLeadsCount }}</span>
                    <span class="text-xs font-bold text-slate-500">Baru (Belum Dihubungi)</span>
                </div>
                <div class="mt-2">
                    <a href="{{ route('admin.leads.index') }}" class="text-xs font-bold text-[#0F2C59] hover:underline flex items-center gap-1">
                        <span>Total Calon Siswa: {{ $totalLeads }}</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3: Presensi Sesi Kelas -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Aktivitas Presensi</span>
                <div class="w-10 h-10 rounded-2xl bg-[#0D9488] text-white flex items-center justify-center font-extrabold shadow-sm">
                    <i data-lucide="calendar-check-2" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-extrabold text-[#0F2C59]">{{ $totalSessionsCount }}</span>
                <span class="text-xs text-slate-500 ml-1">Total Pertemuan Jurnal</span>
                <div class="mt-2">
                    <a href="{{ route('admin.attendance.index') }}" class="text-xs font-bold text-[#0D9488] hover:underline flex items-center gap-1">
                        <span>Buka Presensi 1-Klik &amp; Jurnal</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 4: Total Pemasukan SPP -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Penerimaan SPP</span>
                <div class="w-10 h-10 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-extrabold shadow-sm">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl sm:text-3xl font-extrabold text-emerald-700">Rp {{ number_format($paidInvoicesSum, 0, ',', '.') }}</span>
                <div class="flex items-center justify-between text-xs text-slate-500 mt-2">
                    <span>Tertunda: Rp {{ number_format($unpaidInvoicesSum, 0, ',', '.') }}</span>
                    <a href="{{ route('admin.invoices.index') }}" class="font-bold text-[#0F2C59] hover:underline">Kelola</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Shortcuts / Action Bar -->
    <div class="p-6 rounded-3xl bg-gradient-to-r from-[#0F2C59] to-[#091C3A] text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-extrabold text-[#FACC15]">Pintasan Kerja Pengajar Hari Ini</h2>
            <p class="text-xs text-slate-300 mt-0.5">Kirim notifikasi anak tiba dan laporan jurnal pulang langsung ke WhatsApp orang tua.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.attendance.index') }}"
               class="px-5 py-2.5 rounded-xl bg-[#FACC15] hover:bg-[#FFD100] text-[#0F2C59] text-xs font-extrabold shadow-md flex items-center gap-2">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                Presensi Kelas Sekarang
            </a>
            <a href="{{ route('admin.leads.index') }}"
               class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold flex items-center gap-2">
                <i data-lucide="phone-forwarded" class="w-4 h-4 text-[#FACC15]"></i>
                Follow-Up Trial
            </a>
        </div>
    </div>

    <!-- 2 Column Section: Pendaftar Trial Terbaru & Kapasitas Jadwal -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Kolom Kiri: Pendaftar Trial Terbaru -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <div>
                    <h3 class="text-base font-extrabold text-[#0F2C59]">Pendaftar Kelas Coba Gratis Terbaru</h3>
                    <p class="text-xs text-slate-500">Calon siswa yang mengisi form dari Landing Page</p>
                </div>
                <a href="{{ route('admin.leads.index') }}" class="text-xs font-bold text-[#0F2C59] hover:underline">
                    Lihat Semua
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentLeads as $lead)
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-extrabold text-[#0F2C59] truncate">{{ $lead->student_name }}</span>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-[#0F2C59]/10 text-[#0F2C59]">{{ $lead->grade_level }}</span>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold {{ $lead->status === 'Baru' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">{{ $lead->status }}</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Ortu: {{ $lead->parent_name }} &bull; Program: {{ $lead->program?->category ?? 'MIPA' }}
                                @if($lead->quiz_score !== null)
                                    &bull; <strong class="text-emerald-700">Skor Kuis: {{ $lead->quiz_score }}/100</strong>
                                @endif
                            </p>
                        </div>
                        <a href="{{ App\Services\WhatsAppService::generateLeadFollowUpUrl($lead) }}" target="_blank"
                           class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold flex items-center gap-1 shrink-0">
                            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                            <span>Chat WA</span>
                        </a>
                    </div>
                @empty
                    <p class="text-center py-6 text-xs text-slate-400">Belum ada pendaftar trial baru.</p>
                @endforelse
            </div>
        </div>

        <!-- Kolom Kanan: Kapasitas Jadwal Belajar Resmi -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <div>
                    <h3 class="text-base font-extrabold text-[#0F2C59]">Status Kuota Kursi Jadwal</h3>
                    <p class="text-xs text-slate-500">Maksimal 10 siswa per sesi</p>
                </div>
                <a href="{{ route('admin.schedules.index') }}" class="text-xs font-bold text-[#0F2C59] hover:underline">
                    Atur
                </a>
            </div>

            <div class="space-y-4">
                @foreach($schedules as $sch)
                    @php
                        $pct = $sch->max_quota > 0 ? min(100, round(($sch->filled_quota / $sch->max_quota) * 100)) : 0;
                    @endphp
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                        <div class="flex items-center justify-between text-xs font-bold mb-1">
                            <span class="text-[#0F2C59]">{{ $sch->days_text }}</span>
                            <span class="{{ $sch->remaining_quota <= 3 ? 'text-rose-600 font-extrabold' : 'text-slate-600' }}">
                                Sisa {{ $sch->remaining_quota }} Kursi
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-500 mb-2">{{ $sch->start_time }} – {{ $sch->end_time }} WIB ({{ $sch->program?->category ?? 'Reguler' }})</p>
                        <div class="w-full h-2.5 bg-slate-200 rounded-full overflow-hidden">
                            <div class="h-full {{ $sch->remaining_quota <= 3 ? 'bg-amber-500' : 'bg-[#0D9488]' }} rounded-full"
                                 style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection

