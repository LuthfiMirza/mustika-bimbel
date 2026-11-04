@extends('layouts.public')

@section('title', 'E-Raport Siswa: ' . $student->full_name . ' (' . $student->student_code . ') — MustikaBimbel')

@section('content')
<div class="bg-slate-100 min-h-screen py-6 sm:py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 space-y-6">

        <!-- Top Breadcrumb & Share Button -->
        <div class="flex items-center justify-between gap-3 text-xs sm:text-sm">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 font-bold text-[#0F2C59] hover:underline">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali ke Beranda</span>
            </a>
            <div class="flex items-center gap-2">
                <button type="button"
                        onclick="navigator.clipboard.writeText(window.location.href); alert('Link E-Raport ananda berhasil disalin ke clipboard!');"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition-colors shadow-sm">
                    <i data-lucide="share-2" class="w-3.5 h-3.5 text-[#0F2C59]"></i>
                    <span>Bagikan Link Raport</span>
                </button>
            </div>
        </div>

        <!-- 1. Header Identitas Siswa (Mobile-First Card) -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-md border-2 border-slate-200/80 relative overflow-hidden">
            <!-- Decorative accent line -->
            <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-[#0F2C59] via-[#FACC15] to-[#0D9488]"></div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 pt-2">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-[#0F2C59] text-[#FACC15] flex items-center justify-center font-extrabold text-2xl sm:text-3xl shadow-lg shrink-0">
                        {{ strtoupper(substr($student->nickname ?? $student->full_name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-[#0F2C59]/10 text-[#0F2C59]">
                                {{ $student->student_code }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold {{ $student->status === 'Aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                ● Status: {{ $student->status }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-[#FACC15]/30 text-[#0F2C59]">
                                {{ $student->grade_level }} ({{ $student->class_number ?? 'Siswa Aktif' }})
                            </span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold text-[#0F2C59] mt-1.5">
                            {{ $student->full_name }}
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 flex items-center gap-1.5 mt-0.5">
                            <i data-lucide="school" class="w-4 h-4 text-slate-400"></i>
                            <span>{{ $student->school_name ?? 'MustikaBimbel Cibinong' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Quick Action Buttons -->
                <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-2 shrink-0">
                    <a href="https://wa.me/6287705555190?text={{ rawurlencode('Halo Admin MustikaBimbel, saya orang tua dari ' . $student->full_name . ' (' . $student->student_code . '). Saya ingin berkonsultasi mengenai perkembangan ananda.') }}"
                       target="_blank"
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-sm transition-all">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        <span>Konsultasi WA Pengajar</span>
                    </a>
                </div>
            </div>

            <!-- Program & Schedule Details Bar -->
            <div class="mt-6 pt-5 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-400 block font-semibold">Program Bimbel</span>
                    <strong class="text-[#0F2C59] text-sm block mt-0.5 truncate">{{ $student->program->name ?? '-' }}</strong>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-400 block font-semibold">Jadwal Sesi</span>
                    <strong class="text-[#0F2C59] text-sm block mt-0.5">{{ $student->schedule->days_text ?? '-' }} ({{ $student->schedule->start_time ?? '' }} WIB)</strong>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-400 block font-semibold">Orang Tua / Wali</span>
                    <strong class="text-[#0F2C59] text-sm block mt-0.5">{{ $student->parent_name }}</strong>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-400 block font-semibold">Bergabung Sejak</span>
                    <strong class="text-[#0F2C59] text-sm block mt-0.5">{{ $student->join_date->translatedFormat('d M Y') }}</strong>
                </div>
            </div>

            <!-- Summary KPI Cards -->
            <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-3 text-center">
                <div class="p-3.5 rounded-2xl bg-[#0F2C59] text-white">
                    <span class="text-[11px] text-slate-300 block">Total Kehadiran</span>
                    <span class="text-xl sm:text-2xl font-extrabold text-[#FACC15]">{{ $attendedCount }}</span>
                    <span class="text-[10px] text-slate-300 block mt-0.5">{{ $attendanceRate }}% Pertemuan</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-[#0F2C59] text-white">
                    <span class="text-[11px] text-slate-300 block">Level Jarimatika</span>
                    <span class="text-xl sm:text-2xl font-extrabold text-[#FACC15]">Lv. {{ $student->jarimatika_level }}</span>
                    <span class="text-[10px] text-slate-300 block mt-0.5">dari 6 Level</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-[#0D9488] text-white">
                    <span class="text-[11px] text-slate-100 block">Penguasaan MIPA</span>
                    <span class="text-xl sm:text-2xl font-extrabold">{{ $student->mipa_mastery_percent }}%</span>
                    <span class="text-[10px] text-slate-100 block mt-0.5">Kurikulum</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-amber-500 text-white">
                    <span class="text-[11px] text-amber-100 block">Rata-rata Skor</span>
                    <span class="text-xl sm:text-2xl font-extrabold">{{ $averageScore }}</span>
                    <span class="text-[10px] text-amber-100 block mt-0.5">Skala 100</span>
                </div>
            </div>
        </div>

        {{-- Section 2: Jarimatika Level Tree & Daily Study Journal Timeline (Included in Commit #2) --}}
        @includeIf('portal.partials.progress-journal')

        {{-- Section 3: Chart.js Trends (Included in Commit #3) --}}
        @includeIf('portal.partials.charts')

        {{-- Section 4: Digital Badges & Certificate (Included in Commit #4) --}}
        @includeIf('portal.partials.badges')

        {{-- Section 5: Tuition Invoices & PDF Downloads (Included in Commit #5) --}}
        @includeIf('portal.partials.invoices')

    </div>
</div>
@endsection

