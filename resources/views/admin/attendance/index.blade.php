@extends('layouts.admin')

@section('title', 'Presensi 1-Klik & Notifikasi WA Kedatangan — MustikaBimbel')
@section('header_title', 'Presensi Sesi & Notifikasi WhatsApp')

@section('content')
<div class="space-y-6"
     x-data="{
        autoOpenWa: '{{ session('wa_arrival_url') }}',
        activeStudent: null,
        journalModalOpen: false,
        openJournalModal(student, session) {
            this.activeStudent = student;
            this.journalModalOpen = true;
        }
     }"
     x-init="if (autoOpenWa) { window.open(autoOpenWa, '_blank'); }">

    <!-- WhatsApp Alert Pop-up Notification -->
    @if (session('wa_arrival_url'))
        <div class="p-4 rounded-2xl bg-[#0F2C59] text-white border-2 border-[#FACC15] shadow-lg flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#FACC15] text-[#0F2C59] flex items-center justify-center font-extrabold shrink-0">
                    <i data-lucide="message-circle-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-extrabold text-[#FACC15]">Notifikasi WA Siswa Tiba Siap Dikirim!</h3>
                    <p class="text-xs text-slate-200">Presensi <strong>{{ session('wa_student_name') }}</strong> tercatat aman. Tab WhatsApp telah dibuka otomatis.</p>
                </div>
            </div>
            <a href="{{ session('wa_arrival_url') }}" target="_blank"
               class="px-4 py-2 rounded-xl bg-[#FACC15] text-[#0F2C59] font-extrabold text-xs hover:bg-[#FFD100] transition-colors shrink-0 flex items-center gap-1.5">
                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                Buka Ulang WhatsApp Orang Tua
            </a>
        </div>
    @endif

    <!-- Filter Jadwal & Tanggal -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
        <form method="GET" action="{{ route('admin.attendance.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
            <div class="sm:col-span-6 lg:col-span-5">
                <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Pilih Sesi Jadwal Belajar</label>
                <select name="schedule_id" onchange="this.form.submit()"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm font-bold text-[#0F2C59] bg-white focus:ring-2 focus:ring-[#0F2C59] outline-none">
                    @foreach($schedules as $sch)
                        <option value="{{ $sch->id }}" {{ $selectedScheduleId == $sch->id ? 'selected' : '' }}>
                            {{ $sch->days_text }} ({{ $sch->start_time }} – {{ $sch->end_time }} WIB) &bull; {{ $sch->program?->category ?? 'MIPA' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-4 lg:col-span-4">
                <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Tanggal Sesi</label>
                <input type="date" name="date" value="{{ $selectedDate }}" onchange="this.form.submit()"
                       class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm font-bold text-[#0F2C59] bg-white focus:ring-2 focus:ring-[#0F2C59] outline-none">
            </div>

            <div class="sm:col-span-2 lg:col-span-3 flex gap-2">
                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl text-xs font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] transition-colors flex items-center justify-center gap-1.5">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    <span>Terapkan</span>
                </button>
            </div>
        </form>

        @if($currentSchedule)
            <div class="mt-4 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between text-xs text-slate-500 gap-2">
                <span>Program: <strong class="text-[#0F2C59]">{{ $currentSchedule->program->name ?? '-' }}</strong></span>
                <span>Kapasitas: <strong class="text-[#0D9488]">{{ $students->count() }} Siswa Terdaftar</strong> (Maks {{ $currentSchedule->max_quota }})</span>
            </div>
        @endif
    </div>

    <!-- Student Attendance List -->
    <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-slate-200">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
            <div>
                <h2 class="text-base sm:text-lg font-extrabold text-[#0F2C59]">Daftar Siswa Pada Sesi Ini</h2>
                <p class="text-xs text-slate-500">Klik tombol hadir untuk mencatat jam tiba dan membuka WhatsApp orang tua otomatis</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-extrabold">
                Tanggal: {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}
            </span>
        </div>

        <div class="space-y-4">
            @forelse($students as $student)
                @php
                    $session = $sessions->get($student->id);
                    $isPresent = $session && $session->attendance_status === 'Hadir';
                    $hasJournal = $session && !empty($session->topic_covered);
                @endphp
                <div class="p-4 sm:p-5 rounded-2xl border transition-all {{ $isPresent ? 'bg-emerald-50/50 border-emerald-300' : 'bg-slate-50 border-slate-200' }}">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <!-- Siswa Info -->
                        <div class="flex items-center gap-3.5 min-w-0">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-extrabold text-base shadow-sm shrink-0 {{ $isPresent ? 'bg-emerald-600 text-white' : 'bg-[#0F2C59] text-[#FACC15]' }}">
                                {{ strtoupper(substr($student->nickname ?? $student->full_name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-xs font-mono font-extrabold text-[#0F2C59]">{{ $student->student_code }}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-[#FACC15] text-[#0F2C59]">{{ $student->grade_level }}</span>
                                    @if($session)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold {{ $isPresent ? 'bg-emerald-200 text-emerald-900' : 'bg-amber-100 text-amber-800' }}">
                                            ● {{ $session->attendance_status }}
                                            @if($session->check_in_time)
                                                ({{ substr($session->check_in_time, 0, 5) }} WIB)
                                            @endif
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-200 text-slate-700">
                                            Belum Presensi
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-sm sm:text-base font-extrabold text-[#0F2C59] mt-0.5 truncate">
                                    {{ $student->full_name }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    Ortu: {{ $student->parent_name }} &bull; WA: <a href="https://wa.me/{{ $student->parent_whatsapp }}" target="_blank" class="hover:underline font-semibold">{{ $student->parent_whatsapp }}</a>
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap items-center gap-2 shrink-0">
                            <!-- 1-Click Hadir & WA Datang Button -->
                            <form action="{{ route('admin.attendance.checkin') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                <input type="hidden" name="schedule_id" value="{{ $selectedScheduleId }}">
                                <input type="hidden" name="session_date" value="{{ $selectedDate }}">
                                <input type="hidden" name="attendance_status" value="Hadir">

                                <button type="submit"
                                        class="px-4 py-2.5 rounded-xl text-xs font-extrabold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition-all flex items-center gap-1.5">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                    <span>{{ $isPresent ? 'Kirim Ulang WA Tiba' : 'Hadir & Kirim WA Tiba' }}</span>
                                </button>
                            </form>

                            <!-- Status Dropdown (Izin / Sakit / Alpha) -->
                            <form action="{{ route('admin.attendance.checkin') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                <input type="hidden" name="schedule_id" value="{{ $selectedScheduleId }}">
                                <input type="hidden" name="session_date" value="{{ $selectedDate }}">

                                <select name="attendance_status" onchange="this.form.submit()"
                                        class="px-3 py-2 rounded-xl text-xs font-bold text-slate-700 bg-white border border-slate-300 hover:bg-slate-100 outline-none">
                                    <option value="" disabled selected>Ubah Status</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Alpha">Alpha</option>
                                    <option value="Hadir">Hadir</option>
                                </select>
                            </form>

                            <!-- Shortcut to Jurnal Modal (Filled in Commit #4) -->
                            <button type="button"
                                    @click="$dispatch('open-journal', {
                                        studentId: '{{ $student->id }}',
                                        studentName: '{{ addslashes($student->full_name) }}',
                                        topic: '{{ addslashes($session->topic_covered ?? '') }}',
                                        cat: '{{ $session->subject_category ?? 'Matematika' }}',
                                        score: '{{ $session->practice_score ?? 85 }}',
                                        speed: '{{ $session->speed_rating ?? 5 }}',
                                        notes: '{{ addslashes($session->tutor_notes ?? '') }}',
                                        sessionId: '{{ $session->id ?? '' }}'
                                    })"
                                    class="px-3.5 py-2.5 rounded-xl text-xs font-bold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-sm transition-all flex items-center gap-1.5">
                                <i data-lucide="book-open" class="w-4 h-4"></i>
                                <span>{{ $hasJournal ? 'Edit Jurnal & Nilai' : 'Isi Jurnal & Nilai' }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Journal Summary if already filled -->
                    @if($hasJournal)
                        <div class="mt-3 pt-3 border-t border-emerald-200/60 text-xs flex flex-wrap items-center justify-between text-slate-600 gap-2">
                            <div>
                                <span class="font-extrabold text-[#0F2C59]">Materi:</span> {{ $session->topic_covered }} ({{ $session->subject_category }})
                                &bull; <span class="font-extrabold text-[#0F2C59]">Nilai:</span> {{ $session->practice_score }}/100
                                &bull; <span class="font-extrabold text-[#0F2C59]">Kecepatan:</span> {{ $session->speed_rating }}/5 ⭐
                            </div>
                            <span class="text-[11px] text-emerald-800 font-bold">✓ Jurnal Tersimpan</span>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-12 text-slate-400 text-xs">
                    Tidak ada siswa terdaftar pada sesi jadwal ini.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Journal Quick-Input Modal Included in Commit #4 --}}
    @includeIf('admin.attendance.partials.journal-modal')
</div>
@endsection
