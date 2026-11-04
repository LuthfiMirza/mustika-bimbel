@extends('layouts.admin')

@section('title', 'CRM Pendaftar Trial (Leads) — MustikaBimbel')
@section('header_title', 'CRM Calon Siswa Free Trial')

@section('content')
<div class="space-y-6"
     x-data="{
        statusModalOpen: false,
        activeLead: null,
        openStatusModal(lead) {
            this.activeLead = lead;
            this.statusModalOpen = true;
        }
     }">

    <!-- Top Status Filter Badges -->
    <div class="flex flex-wrap items-center gap-2">
        @foreach($statusCounts as $stName => $cnt)
            @php
                $isActive = ($statusFilter === null && $stName === 'Semua') || ($statusFilter === $stName);
            @endphp
            <a href="{{ route('admin.leads.index', array_merge(request()->query(), ['status' => $stName === 'Semua' ? null : $stName])) }}"
               class="px-4 py-2 rounded-2xl text-xs font-extrabold transition-all flex items-center gap-2 {{ $isActive ? 'bg-[#0F2C59] text-[#FACC15] shadow-md ring-2 ring-[#FACC15]' : 'bg-white text-slate-700 hover:bg-slate-200 border border-slate-200' }}">
                <span>{{ $stName }}</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $isActive ? 'bg-[#FACC15] text-[#0F2C59]' : 'bg-slate-100 text-slate-600' }}">
                    {{ $cnt }}
                </span>
            </a>
        @endforeach
    </div>

    <!-- Search & Control Card -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
        <form method="GET" action="{{ route('admin.leads.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-4">
            @if($statusFilter)
                <input type="hidden" name="status" value="{{ $statusFilter }}">
            @endif

            <div class="relative w-full sm:w-96">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Cari nama anak, orang tua, no. WA..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit"
                        class="w-full sm:w-auto px-5 py-2.5 rounded-xl text-xs font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] transition-colors flex items-center justify-center gap-1.5">
                    <i data-lucide="search" class="w-3.5 h-3.5"></i>
                    <span>Cari Data</span>
                </button>
                @if($search || $statusFilter)
                    <a href="{{ route('admin.leads.index') }}"
                       class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table of Leads -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base sm:text-lg font-extrabold text-[#0F2C59]">Daftar Calon Siswa (Trial Leads)</h2>
                <p class="text-xs text-slate-500">Data pendaftar online yang masuk dari Landing Page</p>
            </div>
            <span class="text-xs font-semibold text-slate-500">
                Total: {{ $leads->total() }} Pendaftar
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-extrabold border-b border-slate-200 text-[10px]">
                    <tr>
                        <th class="px-5 py-3.5">Calon Siswa</th>
                        <th class="px-5 py-3.5">Kontak Orang Tua</th>
                        <th class="px-5 py-3.5">Minat Program &amp; Jadwal</th>
                        <th class="px-5 py-3.5">Skor Kuis &amp; Kendala</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($leads as $lead)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Calon Siswa -->
                            <td class="px-5 py-4">
                                <div class="font-extrabold text-sm text-[#0F2C59]">{{ $lead->student_name }}</div>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-[#0F2C59]/10 text-[#0F2C59]">
                                        {{ $lead->grade_level }}
                                    </span>
                                    <span class="text-slate-500 text-[11px]">{{ $lead->school_name ?? 'Sekolah -' }}</span>
                                </div>
                                <span class="text-[10px] text-slate-400 block mt-1">Daftar: {{ $lead->created_at->translatedFormat('d M Y H:i') }}</span>
                            </td>

                            <!-- Kontak Orang Tua -->
                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-800">{{ $lead->parent_name }}</div>
                                <div class="mt-0.5">
                                    <a href="https://wa.me/{{ $lead->whatsapp }}" target="_blank"
                                       class="font-mono text-emerald-700 hover:underline font-bold flex items-center gap-1">
                                        <i data-lucide="phone" class="w-3 h-3"></i>
                                        <span>{{ $lead->whatsapp }}</span>
                                    </a>
                                </div>
                            </td>

                            <!-- Minat Program & Jadwal -->
                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-800">{{ $lead->program?->name ?? 'Program Bebas' }}</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">
                                    {{ $lead->schedule ? $lead->schedule->days_text . ' (' . $lead->schedule->start_time . ' WIB)' : 'Konsultasi Admin' }}
                                </div>
                            </td>

                            <!-- Skor Kuis & Kendala -->
                            <td class="px-5 py-4 max-w-xs">
                                @if($lead->quiz_score !== null)
                                    <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-100 text-amber-900 font-extrabold text-[11px]">
                                        ⚡ Kuis 30 Detik: {{ $lead->quiz_score }}/100
                                        <span class="font-normal text-amber-700">({{ $lead->quiz_avg_time }} dtk)</span>
                                    </div>
                                @endif
                                @if($lead->learning_obstacle)
                                    <p class="text-[11px] text-slate-600 mt-1 italic">
                                        "{{ $lead->learning_obstacle }}"
                                    </p>
                                @endif
                                @if($lead->admin_notes)
                                    <p class="text-[10px] text-indigo-700 mt-1 bg-indigo-50 p-1.5 rounded-lg border border-indigo-100">
                                        📝 {{ $lead->admin_notes }}
                                    </p>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="px-5 py-4">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold {{ $lead->status === 'Baru' ? 'bg-amber-100 text-amber-900 border border-amber-300' : ($lead->status === 'Daftar Resmi' ? 'bg-emerald-100 text-emerald-900 border border-emerald-300' : 'bg-slate-100 text-slate-800') }}">
                                    {{ $lead->status }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- WA Follow Up Button -->
                                    <a href="{{ App\Services\WhatsAppService::generateLeadFollowUpUrl($lead) }}" target="_blank"
                                       class="px-2.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1 shadow-sm"
                                       title="Chat Follow-Up WA">
                                        <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                        <span>WA</span>
                                    </a>

                                    <!-- 1-Click Convert Button -->
                                    @if($lead->status !== 'Daftar Resmi')
                                        <form action="{{ route('admin.leads.convert', $lead) }}" method="POST"
                                              onsubmit="return confirm('Konversi calon siswa {{ $lead->student_name }} menjadi Siswa Resmi MustikaBimbel?');"
                                              class="inline">
                                            @csrf
                                            <button type="submit"
                                                    class="px-3 py-1.5 rounded-xl bg-[#0F2C59] hover:bg-[#163A70] text-[#FACC15] font-extrabold text-xs flex items-center gap-1 shadow-sm"
                                                    title="Jadikan Siswa Resmi">
                                                <i data-lucide="user-check" class="w-3.5 h-3.5"></i>
                                                <span>Konversi</span>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Update Status Trigger -->
                                    <button type="button"
                                            @click="openStatusModal({
                                                id: '{{ $lead->id }}',
                                                name: '{{ addslashes($lead->student_name) }}',
                                                status: '{{ $lead->status }}',
                                                notes: '{{ addslashes($lead->admin_notes ?? '') }}'
                                            })"
                                            class="p-1.5 rounded-xl text-slate-500 hover:text-[#0F2C59] hover:bg-slate-100 transition-colors"
                                            title="Ubah Status / Catatan">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST"
                                          onsubmit="return confirm('Hapus data calon siswa ini?');"
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
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                                Tidak ada data calon siswa yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($leads->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $leads->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Ubah Status & Catatan -->
    <div x-show="statusModalOpen" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         @keydown.escape.window="statusModalOpen = false">
        <div @click.outside="statusModalOpen = false"
             class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border-4 border-[#FACC15] relative">
            <button type="button" @click="statusModalOpen = false"
                    class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <h3 class="text-base font-extrabold text-[#0F2C59] mb-1">Perbarui Status Calon Siswa</h3>
            <p class="text-xs text-slate-500 mb-4">Siswa: <strong class="text-[#0D9488]" x-text="activeLead?.name"></strong></p>

            <form :action="'/admin/leads/' + activeLead?.id + '/status'" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Status Follow-Up</label>
                    <select name="status" x-model="activeLead.status" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold bg-white outline-none">
                        <option value="Baru">Baru</option>
                        <option value="Dihubungi">Dihubungi</option>
                        <option value="Sudah Trial">Sudah Trial</option>
                        <option value="Daftar Resmi">Daftar Resmi</option>
                        <option value="Batal">Batal</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Catatan Admin</label>
                    <textarea name="admin_notes" x-model="activeLead.notes" rows="3"
                              placeholder="Misal: Sudah dihubungi, siap hadir trial Sabtu..."
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm outline-none"></textarea>
                </div>

                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl text-xs sm:text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] transition-colors">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
