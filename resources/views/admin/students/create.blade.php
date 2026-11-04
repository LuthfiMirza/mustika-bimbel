@extends('layouts.admin')

@section('title', 'Tambah Siswa Baru — MustikaBimbel')
@section('header_title', 'Pendaftaran Siswa Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.students.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-[#0F2C59]">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Daftar Siswa
        </a>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200">
        <div class="border-b border-slate-100 pb-4 mb-6">
            <h2 class="text-lg font-extrabold text-[#0F2C59]">Formulir Pendaftaran Siswa Baru</h2>
            <p class="text-xs text-slate-500">Kode Induk MB-... dan token unik E-Raport akan di-generate otomatis.</p>
        </div>

        @if($errors->any())
            <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700 space-y-1">
                @foreach($errors->all() as $err)
                    <p>&bull; {{ $err }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.students.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Identitas Siswa -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Nama Lengkap Siswa *</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required
                           placeholder="Contoh: Aisyah Putri Rahmawati"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Nama Panggilan</label>
                    <input type="text" name="nickname" value="{{ old('nickname') }}"
                           placeholder="Contoh: Aisyah"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Jenjang Pendidikan *</label>
                    <select name="grade_level" required
                            class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold bg-white focus:ring-2 focus:ring-[#0F2C59] outline-none">
                        <option value="TK">Jenjang TK (Jarimatika)</option>
                        <option value="SD" selected>Jenjang SD (Kelas 1-6)</option>
                        <option value="SMP">Jenjang SMP (Kelas 7-9)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Kelas / Tingkat</label>
                    <input type="text" name="class_number" value="{{ old('class_number') }}"
                           placeholder="Contoh: Kelas 4 SD atau TK B"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Sekolah Asal</label>
                    <input type="text" name="school_name" value="{{ old('school_name') }}"
                           placeholder="Contoh: SDN Harapan Jaya 01"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
                </div>
            </div>

            <!-- Program & Jadwal Sesi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Program Bimbel *</label>
                    <select name="program_id" required
                            class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold bg-white focus:ring-2 focus:ring-[#0F2C59] outline-none">
                        @foreach($programs as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Pilihan Jadwal Belajar *</label>
                    <select name="schedule_id" required
                            class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold bg-white focus:ring-2 focus:ring-[#0F2C59] outline-none">
                        @foreach($schedules as $s)
                            <option value="{{ $s->id }}">{{ $s->days_text }} ({{ $s->start_time }} - {{ $s->end_time }} WIB)</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Orang Tua & Kontak -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Nama Orang Tua / Wali *</label>
                    <input type="text" name="parent_name" value="{{ old('parent_name') }}" required
                           placeholder="Nama Ayah / Ibu"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">WhatsApp Orang Tua (Untuk Notifikasi) *</label>
                    <input type="tel" name="parent_whatsapp" value="{{ old('parent_whatsapp') }}" required
                           placeholder="Contoh: 081234567890"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
                </div>
            </div>

            <!-- Level Awal & Kurikulum -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Level Jarimatika Awal</label>
                    <select name="jarimatika_level" required
                            class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold bg-white outline-none">
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}">Level {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Penguasaan MIPA (%)</label>
                    <input type="number" name="mipa_mastery_percent" value="20" min="0" max="100" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm outline-none">
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Tanggal Bergabung</label>
                    <input type="date" name="join_date" value="{{ date('Y-m-d') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm outline-none">
                </div>
            </div>

            <div>
                <input type="hidden" name="status" value="Aktif">
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.students.index') }}" class="px-5 py-3 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-3 rounded-xl text-xs sm:text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-md transition-all">
                    Simpan &amp; Terbitkan Kode Siswa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
