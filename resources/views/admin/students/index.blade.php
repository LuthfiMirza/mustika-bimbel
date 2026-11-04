@extends('layouts.admin')

@section('title', 'Manajemen Data Siswa & Badges — MustikaBimbel')
@section('header_title', 'Data Siswa & Kurikulum Perkembangan')

@section('content')
<div class="space-y-6"
     x-data="{
        badgeModalOpen: false,
        activeStudent: null,
        openBadgeModal(student) {
            this.activeStudent = student;
            this.badgeModalOpen = true;
        }
     }">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Akademik MustikaBimbel</span>
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#0F2C59]">Daftar Siswa Binaan ({{ $totalActive }} Siswa Aktif)</h2>
        </div>
        <a href="{{ route('admin.students.create') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl text-xs sm:text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-md transition-all">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            <span>Tambah Siswa Baru</span>
        </a>
    </div>

    <!-- Filter & Search Card -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
        <form method="GET" action="{{ route('admin.students.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            <div class="sm:col-span-6 lg:col-span-5 relative">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Cari nama, kode MB-..., orang tua..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
            </div>

            <div class="sm:col-span-3 lg:col-span-3">
                <select name="grade" onchange="this.form.submit()"
                        class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold bg-white outline-none">
                    <option value="">Semua Jenjang</option>
                    <option value="TK" {{ $gradeFilter === 'TK' ? 'selected' : '' }}>Jenjang TK (Jarimatika)</option>
                    <option value="SD" {{ $gradeFilter === 'SD' ? 'selected' : '' }}>Jenjang SD (Kelas 1-6)</option>
                    <option value="SMP" {{ $gradeFilter === 'SMP' ? 'selected' : '' }}>Jenjang SMP (Kelas 7-9)</option>
                </select>
            </div>

            <div class="sm:col-span-3 lg:col-span-2">
                <select name="status" onchange="this.form.submit()"
                        class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold bg-white outline-none">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ $statusFilter === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Cuti" {{ $statusFilter === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                    <option value="Lulus" {{ $statusFilter === 'Lulus' ? 'selected' : '' }}>Lulus</option>
                </select>
            </div>

            <div class="sm:col-span-12 lg:col-span-2 flex gap-2">
                <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl text-xs font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] transition-colors">
                    Filter
                </button>
                @if($search || $gradeFilter || $statusFilter)
                    <a href="{{ route('admin.students.index') }}"
                       class="py-2.5 px-3 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-extrabold border-b border-slate-200 text-[10px]">
                    <tr>
                        <th class="px-5 py-3.5">Siswa &amp; Kode</th>
                        <th class="px-5 py-3.5">Jenjang &amp; Sekolah</th>
                        <th class="px-5 py-3.5">Program &amp; Sesi</th>
                        <th class="px-5 py-3.5">Level Jarimatika &amp; MIPA</th>
                        <th class="px-5 py-3.5">Lencana</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $student)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Siswa & Kode -->
                            <td class="px-5 py-4">
                                <div class="font-extrabold text-sm text-[#0F2C59]">{{ $student->full_name }}</div>
                                <div class="font-mono text-xs font-bold text-[#0D9488] mt-0.5">{{ $student->student_code }}</div>
                                <span class="text-[10px] text-slate-400 block mt-0.5">Ortu: {{ $student->parent_name }}</span>
                            </td>

                            <!-- Jenjang & Sekolah -->
                            <td class="px-5 py-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-[#0F2C59] text-[#FACC15]">
                                    {{ $student->grade_level }}
                                </span>
                                <div class="text-xs text-slate-700 mt-1 font-semibold">{{ $student->class_number ?? 'Siswa Binaan' }}</div>
                                <div class="text-[11px] text-slate-500 truncate max-w-[140px]">{{ $student->school_name ?? '-' }}</div>
                            </td>

                            <!-- Program & Sesi -->
                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-800">{{ $student->program->name ?? '-' }}</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">
                                    {{ $student->schedule->days_text ?? '-' }} ({{ $student->schedule->start_time ?? '' }} WIB)
                                </div>
                            </td>

                            <!-- Level Jarimatika & MIPA -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-lg text-xs font-extrabold bg-amber-100 text-amber-900 border border-amber-200">
                                        Lv. {{ $student->jarimatika_level }}
                                    </span>
                                    <span class="px-2.5 py-0.5 rounded-lg text-xs font-extrabold bg-teal-100 text-teal-900 border border-teal-200">
                                        MIPA: {{ $student->mipa_mastery_percent }}%
                                    </span>
                                </div>
                            </td>

                            <!-- Badges -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-1">
                                    <span class="px-2 py-0.5 rounded-full bg-purple-100 text-purple-900 font-extrabold text-[11px] flex items-center gap-1">
                                        <i data-lucide="trophy" class="w-3 h-3 text-purple-700"></i>
                                        {{ $student->badges->count() }} Lencana
                                    </span>
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-extrabold {{ $student->status === 'Aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $student->status }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- Salin Link Raport -->
                                    <button type="button"
                                            onclick="navigator.clipboard.writeText('{{ url('/raport/' . $student->portal_token) }}'); alert('Link E-Raport {{ $student->full_name }} berhasil disalin!');"
                                            class="p-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700"
                                            title="Salin Link E-Raport">
                                        <i data-lucide="copy" class="w-4 h-4"></i>
                                    </button>

                                    <!-- Buka Raport Siswa -->
                                    <a href="{{ url('/raport/' . $student->portal_token) }}" target="_blank"
                                       class="p-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-[#0F2C59]"
                                       title="Buka Raport di Tab Baru">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>

                                    <!-- Berikan Badge Modal Trigger -->
                                    <button type="button"
                                            @click="openBadgeModal({
                                                id: '{{ $student->id }}',
                                                name: '{{ addslashes($student->full_name) }}'
                                            })"
                                            class="p-1.5 rounded-xl bg-purple-100 hover:bg-purple-200 text-purple-800"
                                            title="Beri Lencana Penghargaan">
                                        <i data-lucide="award" class="w-4 h-4"></i>
                                    </button>

                                    <!-- Edit Siswa -->
                                    <a href="{{ route('admin.students.edit', $student) }}"
                                       class="p-1.5 rounded-xl bg-amber-100 hover:bg-amber-200 text-amber-900"
                                       title="Edit Data & Level">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>

                                    <!-- Delete Siswa -->
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST"
                                          onsubmit="return confirm('Hapus siswa {{ $student->full_name }}? Riwayat raport akan terhapus.');"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-xl text-rose-400 hover:text-rose-700 hover:bg-rose-50" title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400">
                                Tidak ada data siswa yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $students->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Beri Lencana Penghargaan (Badges) -->
    <div x-show="badgeModalOpen" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         @keydown.escape.window="badgeModalOpen = false">
        <div @click.outside="badgeModalOpen = false"
             class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border-4 border-[#FACC15] relative">
            <button type="button" @click="badgeModalOpen = false"
                    class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <div class="flex items-center gap-3 mb-4 pb-3 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-800 flex items-center justify-center font-extrabold">
                    <i data-lucide="trophy" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-[#0F2C59]">Beri Lencana Kehormatan</h3>
                    <p class="text-xs text-slate-500">Siswa: <strong class="text-[#0D9488]" x-text="activeStudent?.name"></strong></p>
                </div>
            </div>

            <form :action="'/admin/students/' + activeStudent?.id + '/badge'" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Judul Lencana *</label>
                    <input type="text" name="badge_title" required
                           placeholder="Contoh: Master Jarimatika Level 3 atau Bintang Aljabar"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Kategori *</label>
                        <select name="badge_category" required
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs font-bold bg-white outline-none">
                            <option value="Kecepatan Hitung">Kecepatan Hitung</option>
                            <option value="Pemahaman Konsep">Pemahaman Konsep</option>
                            <option value="Latihan Soal">Latihan Soal</option>
                            <option value="Ketekunan Belajar">Ketekunan Belajar</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Ikon Lencana</label>
                        <select name="badge_icon" required
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs font-bold bg-white outline-none">
                            <option value="trophy">🏆 Piala / Trophy</option>
                            <option value="star">⭐ Bintang / Star</option>
                            <option value="zap">⚡ Kilat / Zap</option>
                            <option value="award">🎖️ Medali / Award</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Deskripsi Prestasi *</label>
                    <textarea name="description" rows="3" required
                              placeholder="Penjelasan prestasi anak yang akan tercetak di sertifikat resmi..."
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm outline-none"></textarea>
                </div>

                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl text-xs sm:text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="award" class="w-4 h-4"></i>
                    <span>Terbitkan Lencana &amp; Sertifikat</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
