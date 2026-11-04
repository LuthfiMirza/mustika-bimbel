@extends('layouts.admin')

@section('title', 'Edit Siswa & Level Kurikulum — MustikaBimbel')
@section('header_title', 'Perbarui Data Siswa & Level Kurikulum')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.students.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-[#0F2C59]">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Daftar Siswa
        </a>
        <a href="{{ url('/raport/' . $student->portal_token) }}" target="_blank"
           class="inline-flex items-center gap-1 text-xs font-bold text-[#0D9488] hover:underline">
            <span>Buka E-Raport Siswa</span>
            <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
        </a>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200">
        <div class="border-b border-slate-100 pb-4 mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-extrabold text-[#0F2C59]">Edit Data: {{ $student->full_name }}</h2>
                <p class="text-xs text-slate-500">Nomor Induk Siswa: <strong>{{ $student->student_code }}</strong></p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-[#0F2C59] text-[#FACC15]">
                {{ $student->grade_level }}
            </span>
        </div>

        @if($errors->any())
            <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700 space-y-1">
                @foreach($errors->all() as $err)
                    <p>&bull; {{ $err }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.students.update', $student) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Identitas Siswa -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Nama Lengkap Siswa *</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $student->full_name) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Nama Panggilan</label>
                    <input type="text" name="nickname" value="{{ old('nickname', $student->nickname) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Jenjang Pendidikan *</label>
                    <select name="grade_level" required
                            class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold bg-white outline-none">
                        <option value="TK" {{ $student->grade_level === 'TK' ? 'selected' : '' }}>TK</option>
                        <option value="SD" {{ $student->grade_level === 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ $student->grade_level === 'SMP' ? 'selected' : '' }}>SMP</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Kelas / Tingkat</label>
                    <input type="text" name="class_number" value="{{ old('class_number', $student->class_number) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm outline-none">
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Sekolah Asal</label>
                    <input type="text" name="school_name" value="{{ old('school_name', $student->school_name) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm outline-none">
                </div>
            </div>

            <!-- Program & Jadwal Sesi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Program Bimbel *</label>
                    <select name="program_id" required
                            class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold bg-white outline-none">
                        @foreach($programs as $p)
                            <option value="{{ $p->id }}" {{ $student->program_id == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Pilihan Jadwal Belajar *</label>
                    <select name="schedule_id" required
                            class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold bg-white outline-none">
                        @foreach($schedules as $s)
                            <option value="{{ $s->id }}" {{ $student->schedule_id == $s->id ? 'selected' : '' }}>
                                {{ $s->days_text }} ({{ $s->start_time }} - {{ $s->end_time }} WIB)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Orang Tua & Kontak -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Nama Orang Tua / Wali *</label>
                    <input type="text" name="parent_name" value="{{ old('parent_name', $student->parent_name) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm outline-none">
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">WhatsApp Orang Tua *</label>
                    <input type="tel" name="parent_whatsapp" value="{{ old('parent_whatsapp', $student->parent_whatsapp) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm outline-none">
                </div>
            </div>

            <!-- Naikan Level Jarimatika & MIPA -->
            <div class="p-4 rounded-2xl bg-[#0F2C59]/5 border-2 border-[#0F2C59]/20 space-y-4">
                <span class="text-xs font-extrabold uppercase tracking-wider text-[#0F2C59] block">
                    ⚡ Update Kurikulum &amp; Tingkat Kemajuan Siswa
                </span>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-700 mb-1.5">Level Jarimatika (1-6)</label>
                        <select name="jarimatika_level" required
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-extrabold text-[#0F2C59] bg-white outline-none">
                            @for($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ $student->jarimatika_level == $i ? 'selected' : '' }}>
                                    Level {{ $i }} {{ $i == 6 ? '(Master)' : '' }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-700 mb-1.5">Penguasaan MIPA (0-100%)</label>
                        <input type="number" name="mipa_mastery_percent" value="{{ old('mipa_mastery_percent', $student->mipa_mastery_percent) }}" min="0" max="100" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-extrabold text-[#0D9488] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-700 mb-1.5">Status Siswa</label>
                        <select name="status" required
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold bg-white outline-none">
                            <option value="Aktif" {{ $student->status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Cuti" {{ $student->status === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                            <option value="Lulus" {{ $student->status === 'Lulus' ? 'selected' : '' }}>Lulus</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.students.index') }}" class="px-5 py-3 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-3 rounded-xl text-xs sm:text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-md transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
