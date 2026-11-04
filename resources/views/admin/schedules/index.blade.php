@extends('layouts.admin')

@section('title', 'Manajemen Jadwal Belajar & Kuota Kursi — MustikaBimbel')
@section('header_title', 'Jadwal Sesi & Kapasitas Kelas')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Kapasitas Maksimal Kelas</span>
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#0F2C59]">Jadwal Belajar Resmi MustikaBimbel</h2>
            <p class="text-xs text-slate-500 mt-0.5">Pengaturan kuota di sini otomatis memperbarui indikator sisa kursi di halaman publik.</p>
        </div>
    </div>

    <!-- Cards Grid of Schedules -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @foreach($schedules as $schedule)
            @php
                $pct = $schedule->max_quota > 0 ? min(100, round(($schedule->filled_quota / $schedule->max_quota) * 100)) : 0;
            @endphp
            <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border-2 border-slate-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-[#0D9488]">
                            {{ $schedule->program?->category ?? 'Reguler' }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold {{ $schedule->remaining_quota <= 3 ? 'bg-amber-100 text-amber-900' : 'bg-emerald-100 text-emerald-900' }}">
                            Sisa {{ $schedule->remaining_quota }} Kursi
                        </span>
                    </div>

                    <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1">Nama Sesi *</label>
                            <input type="text" name="session_name" value="{{ old('session_name', $schedule->session_name) }}" required
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold text-[#0F2C59] outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1">Hari Belajar *</label>
                            <input type="text" name="days_text" value="{{ old('days_text', $schedule->days_text) }}" required
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs sm:text-sm font-semibold outline-none">
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1">Jam Mulai</label>
                                <input type="text" name="start_time" value="{{ old('start_time', $schedule->start_time) }}" required
                                       class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs sm:text-sm font-mono outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1">Jam Selesai</label>
                                <input type="text" name="end_time" value="{{ old('end_time', $schedule->end_time) }}" required
                                       class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs sm:text-sm font-mono outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 p-3 bg-slate-50 rounded-2xl border border-slate-200">
                            <div>
                                <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1">Kapasitas Maks</label>
                                <input type="number" name="max_quota" value="{{ old('max_quota', $schedule->max_quota) }}" min="1" max="30" required
                                       class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold text-center outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1">Terisi</label>
                                <input type="number" name="filled_quota" value="{{ old('filled_quota', $schedule->filled_quota) }}" min="0" max="30" required
                                       class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold text-center outline-none">
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-between text-[11px] font-semibold text-slate-500">
                                <span>Keterisian: {{ $pct }}%</span>
                                <span>{{ $schedule->filled_quota }}/{{ $schedule->max_quota }} Siswa</span>
                            </div>
                            <div class="w-full h-2.5 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full {{ $schedule->remaining_quota <= 3 ? 'bg-amber-500' : 'bg-[#0D9488]' }} rounded-full"
                                     style="width: {{ $pct }}%"></div>
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full py-2.5 px-4 rounded-xl text-xs font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            <span>Simpan Kuota Jadwal</span>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
