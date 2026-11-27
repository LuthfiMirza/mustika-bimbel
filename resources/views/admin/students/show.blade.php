@extends('layouts.admin')

@section('title', 'Profil 360° ' . $student->full_name . ' — MustikaBimbel')
@section('header_title', 'Profil 360° Siswa')
@section('breadcrumb', $student->full_name)

@section('content')
<div class="space-y-6" x-data="{ tab: 'sessions' }">

    <!-- Back & Quick Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('admin.students.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-[#0F2C59]">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar Siswa</span>
        </a>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ url('/raport/' . $student->portal_token) }}" target="_blank"
               class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-[#0F2C59] text-xs font-extrabold flex items-center gap-1.5 shadow-sm">
                <i data-lucide="external-link" class="w-3.5 h-3.5 text-[#0D9488]"></i>
                <span>Portal E-Raport</span>
            </a>
            @if($reminderUrl)
                <a href="{{ $reminderUrl }}" target="_blank"
                   class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold flex items-center gap-1.5 shadow-sm">
                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                    <span>Reminder SPP via WA</span>
                </a>
            @endif
            <a href="{{ route('admin.students.edit', $student) }}"
               class="px-3.5 py-2 rounded-xl bg-[#FACC15] hover:bg-[#FFD100] text-[#0F2C59] text-xs font-extrabold flex items-center gap-1.5 shadow-sm">
                <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                <span>Edit Data &amp; Diskon</span>
            </a>
        </div>
    </div>

    <!-- Header Profile Card -->
    <div class="bg-[#0F2C59] text-white rounded-2xl p-6 flex flex-col md:flex-row md:items-center justify-between gap-5">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-[#FACC15] text-[#0F2C59] flex items-center justify-center font-extrabold text-2xl shadow shrink-0">
                {{ strtoupper(substr($student->full_name, 0, 1)) }}
            </div>
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <h2 class="text-xl font-extrabold">{{ $student->full_name }}</h2>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-[#FACC15] text-[#0F2C59]">{{ $student->grade_level }}</span>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold {{ $student->status === 'Aktif' ? 'bg-emerald-400/20 text-emerald-200 border border-emerald-400/40' : 'bg-white/10 text-slate-200' }}">{{ $student->status }}</span>
                </div>
                <p class="text-xs text-slate-300 mt-1">
                    Kode: <strong class="font-mono text-[#FACC15]">{{ $student->student_code }}</strong>
                    &bull; {{ $student->class_number ?? 'Siswa Binaan' }} ({{ $student->school_name ?? '-' }})
                </p>
                <p class="text-xs text-slate-300 mt-0.5">
                    Wali: <strong>{{ $student->parent_name }}</strong> ({{ $student->parent_whatsapp }})
                    &bull; Program: <strong>{{ $student->program?->name ?? '-' }}</strong>
                </p>
            </div>
        </div>

        <div class="bg-white/10 rounded-2xl p-4 border border-white/15 text-xs min-w-[210px]">
            <div class="text-[10px] uppercase tracking-wider text-slate-300 font-bold">SPP Bersih / Bulan</div>
            <div class="text-xl font-extrabold text-[#FACC15] mt-0.5">Rp {{ number_format($student->net_monthly_fee, 0, ',', '.') }}</div>
            @if($student->monthly_discount > 0)
                <div class="text-[11px] text-emerald-300 mt-0.5">
                    Diskon Rp {{ number_format($student->monthly_discount, 0, ',', '.') }} {{ $student->discount_reason ? "({$student->discount_reason})" : '' }}
                </div>
            @else
                <div class="text-[11px] text-slate-300 mt-0.5">Tarif standar program</div>
            @endif
        </div>
    </div>

    <!-- 4 Quick Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
            <span class="text-[10px] font-extrabold uppercase text-slate-500">Kehadiran</span>
            <div class="text-2xl font-extrabold text-[#0F2C59] mt-1">{{ $attendanceRate }}%</div>
            <div class="text-[11px] text-slate-500">{{ $attendedSessions }}/{{ $totalSessions }} Hadir &bull; {{ $alphaSessions }} Alpha</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
            <span class="text-[10px] font-extrabold uppercase text-slate-500">Total Tunggakan SPP</span>
            <div class="text-2xl font-extrabold {{ $totalArrears > 0 ? 'text-rose-600' : 'text-emerald-700' }} mt-1">
                Rp {{ number_format($totalArrears, 0, ',', '.') }}
            </div>
            <div class="text-[11px] text-slate-500">{{ $totalArrears > 0 ? 'Perlu penagihan/cicilan' : 'Semua tagihan lunas' }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
            <span class="text-[10px] font-extrabold uppercase text-slate-500">Kurikulum &amp; Skor</span>
            <div class="text-2xl font-extrabold text-[#0D9488] mt-1">Lv.{{ $student->jarimatika_level }} &bull; {{ $student->mipa_mastery_percent }}%</div>
            <div class="text-[11px] text-slate-500">Rata-rata latihan: {{ $avgScore }}/100</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
            <span class="text-[10px] font-extrabold uppercase text-slate-500">Koleksi Lencana</span>
            <div class="text-2xl font-extrabold text-purple-700 mt-1">{{ $student->badges->count() }} Badge</div>
            <div class="text-[11px] text-slate-500">Bergabung {{ $student->join_date?->translatedFormat('d M Y') }}</div>
        </div>
    </div>

    <!-- Private Internal Tutor Notes -->
    <div class="bg-amber-50/70 rounded-2xl p-5 border border-amber-200">
        <form action="{{ route('admin.students.notes', $student) }}" method="POST" class="space-y-2.5">
            @csrf
            @method('PATCH')
            <div class="flex items-center justify-between">
                <label class="text-xs font-extrabold uppercase tracking-wider text-amber-900 flex items-center gap-1.5">
                    <i data-lucide="sticky-note" class="w-4 h-4 text-amber-600"></i>
                    <span>Catatan Internal Guru / Admin (Privat — Tidak Tampil di Portal Orang Tua)</span>
                </label>
                <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-[#0F2C59] text-[#FACC15] text-[11px] font-extrabold hover:bg-[#163A70]">
                    Simpan Catatan
                </button>
            </div>
            <textarea name="internal_notes" rows="2"
                      placeholder="Contoh: Anak agak pemalu, lebih nyaman duduk di depan; dijemput kakek setiap Sabtu; perlu penguatan rumus teman kecil Jarimatika..."
                      class="w-full px-4 py-2.5 rounded-xl border border-amber-300 bg-white text-xs sm:text-sm text-slate-800 outline-none focus:ring-2 focus:ring-[#0F2C59]">{{ old('internal_notes', $student->internal_notes) }}</textarea>
        </form>
    </div>

    <!-- Tab Switcher -->
    <div class="flex flex-wrap gap-2">
        <button type="button" @click="tab = 'sessions'"
                :class="tab === 'sessions' ? 'bg-[#0F2C59] text-[#FACC15]' : 'bg-white text-slate-600 border border-slate-200'"
                class="px-4 py-2.5 rounded-2xl text-xs font-extrabold">
            Jurnal Belajar ({{ $student->studySessions->count() }})
        </button>
        <button type="button" @click="tab = 'invoices'"
                :class="tab === 'invoices' ? 'bg-[#0F2C59] text-[#FACC15]' : 'bg-white text-slate-600 border border-slate-200'"
                class="px-4 py-2.5 rounded-2xl text-xs font-extrabold">
            Riwayat SPP &amp; Cicilan ({{ $student->invoices->count() }})
        </button>
        <button type="button" @click="tab = 'badges'"
                :class="tab === 'badges' ? 'bg-[#0F2C59] text-[#FACC15]' : 'bg-white text-slate-600 border border-slate-200'"
                class="px-4 py-2.5 rounded-2xl text-xs font-extrabold">
            Koleksi Lencana ({{ $student->badges->count() }})
        </button>
    </div>

    <!-- Tab 1: Jurnal Belajar -->
    <div x-show="tab === 'sessions'" class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-extrabold border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Kategori &amp; Topik</th>
                        <th class="px-5 py-3">Skor &amp; Kecepatan</th>
                        <th class="px-5 py-3">Catatan Pengajar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($student->studySessions as $sess)
                        <tr>
                            <td class="px-5 py-3 font-bold whitespace-nowrap">{{ $sess->session_date->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $sess->attendance_status === 'Hadir' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $sess->attendance_status }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="font-bold text-[#0F2C59]">{{ $sess->subject_category ?? '-' }}</div>
                                <div class="text-[11px] text-slate-600">{{ $sess->topic_covered ?? '-' }}</div>
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap">
                                <span class="font-extrabold text-teal-700">{{ $sess->practice_score ?? '-' }}/100</span>
                                <span class="text-amber-500 ml-1">({{ $sess->speed_rating ?? '-' }}/5 ⭐)</span>
                            </td>
                            <td class="px-5 py-3 text-[11px] text-slate-600">{{ $sess->tutor_notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center text-slate-400">Belum ada riwayat sesi belajar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 2: Riwayat SPP & Cicilan -->
    <div x-show="tab === 'invoices'" x-cloak class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-extrabold border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3">No. Tagihan &amp; Periode</th>
                        <th class="px-5 py-3">Nominal Bersih</th>
                        <th class="px-5 py-3">Masuk / Sisa</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Riwayat Cicilan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($student->invoices as $inv)
                        <tr>
                            <td class="px-5 py-3">
                                <div class="font-mono font-extrabold text-[#0F2C59]">{{ $inv->invoice_number }}</div>
                                <div class="text-[11px] font-bold">{{ $inv->billing_period }}</div>
                            </td>
                            <td class="px-5 py-3 font-extrabold text-[#0F2C59]">
                                Rp {{ number_format($inv->amount, 0, ',', '.') }}
                                @if($inv->discount_amount > 0)
                                    <div class="text-[10px] text-teal-700">Diskon Rp {{ number_format($inv->discount_amount, 0, ',', '.') }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <div class="text-emerald-700 font-bold">Masuk: Rp {{ number_format($inv->paid_amount, 0, ',', '.') }}</div>
                                <div class="text-rose-600 font-bold text-[11px]">Sisa: Rp {{ number_format($inv->remaining_amount, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-5 py-3">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold {{ $inv->status === 'Lunas' ? 'bg-emerald-100 text-emerald-800' : ($inv->status === 'Kurang' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                                    {{ $inv->status }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-[11px]">
                                @forelse($inv->payments as $pay)
                                    <div class="mb-1">
                                        <strong>{{ $pay->receipt_number }}</strong>: Rp {{ number_format($pay->amount, 0, ',', '.') }} ({{ $pay->payment_method }}, {{ $pay->payment_date->format('d/m/Y') }})
                                    </div>
                                @empty
                                    <span class="text-slate-400">Belum ada pembayaran</span>
                                @endforelse
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center text-slate-400">Belum ada riwayat tagihan SPP.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 3: Lencana -->
    <div x-show="tab === 'badges'" x-cloak class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($student->badges as $badge)
            <div class="bg-white rounded-2xl p-5 border border-slate-200 flex items-start gap-3">
                <div class="w-10 h-10 rounded-2xl bg-purple-100 text-purple-800 flex items-center justify-center shrink-0">
                    <i data-lucide="{{ $badge->badge_icon }}" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="font-extrabold text-sm text-[#0F2C59]">{{ $badge->badge_title }}</div>
                    <div class="text-[11px] font-bold text-purple-700">{{ $badge->badge_category }} &bull; {{ $badge->awarded_date?->translatedFormat('d M Y') }}</div>
                    <p class="text-xs text-slate-600 mt-1">{{ $badge->description }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-2 bg-white rounded-2xl p-8 text-center text-xs text-slate-400 border border-slate-200">
                Belum ada lencana yang diberikan untuk siswa ini.
            </div>
        @endforelse
    </div>
</div>
@endsection

