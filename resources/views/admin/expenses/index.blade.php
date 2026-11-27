@extends('layouts.admin')

@section('title', 'Pencatatan Pengeluaran Operasional — MustikaBimbel')
@section('header_title', 'Pengeluaran Operasional Bimbel')

@section('content')
<div class="space-y-6" x-data="{ addModalOpen: false }">

    <!-- Top KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Pengeluaran Bulan Ini</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-rose-600 mt-2">
                Rp {{ number_format($allMonthTotal, 0, ',', '.') }}
            </div>
            <p class="text-xs text-slate-500 mt-1">{{ now()->translatedFormat('F Y') }}</p>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Total Sesuai Filter</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-[#0F2C59] mt-2">
                Rp {{ number_format($totalFiltered, 0, ',', '.') }}
            </div>
            <p class="text-xs text-slate-500 mt-1">Akumulasi keseluruhan: Rp {{ number_format($allTimeTotal, 0, ',', '.') }}</p>
        </div>

        <div class="bg-[#0F2C59] text-white rounded-3xl p-6 shadow-md flex items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#FACC15]">Kas Keluar</span>
                <h3 class="text-base font-extrabold mt-1">Catat Pengeluaran Baru</h3>
                <p class="text-xs text-slate-300 mt-0.5">Otomatis masuk hitungan Laba Bersih Bulanan</p>
            </div>
            <button type="button" @click="addModalOpen = true"
                    class="px-4 py-3 rounded-2xl bg-[#FACC15] hover:bg-[#FFD100] text-[#0F2C59] text-xs font-extrabold shadow-md shrink-0 flex items-center gap-1.5">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Tambah</span>
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-200">
        <form method="GET" action="{{ route('admin.expenses.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <div>
                    <label class="text-[10px] font-extrabold uppercase text-slate-500 block mb-1">Bulan</label>
                    <input type="month" name="month" value="{{ $monthFilter }}" onchange="this.form.submit()"
                           class="px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold bg-white outline-none">
                </div>
                <div>
                    <label class="text-[10px] font-extrabold uppercase text-slate-500 block mb-1">Kategori</label>
                    <select name="category" onchange="this.form.submit()"
                            class="px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold bg-white outline-none">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ $categoryFilter === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.reports.index') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-teal-50 text-teal-800 border border-teal-200 hover:bg-teal-100 text-xs font-extrabold">
                    <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                    <span>Lihat Laporan Laba Bersih</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-extrabold border-b border-slate-200 text-[10px]">
                    <tr>
                        <th class="px-5 py-3.5">Tanggal</th>
                        <th class="px-5 py-3.5">Kategori</th>
                        <th class="px-5 py-3.5">Keterangan</th>
                        <th class="px-5 py-3.5">Metode &amp; Pencatat</th>
                        <th class="px-5 py-3.5 text-right">Jumlah</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($expenses as $exp)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-5 py-4 font-bold text-slate-700 whitespace-nowrap">
                                {{ $exp->expense_date->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-[#0F2C59]/10 text-[#0F2C59]">
                                    {{ $exp->category }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-800">{{ $exp->description }}</div>
                                @if($exp->notes)
                                    <div class="text-[11px] text-slate-500 mt-0.5">{{ $exp->notes }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-semibold">{{ $exp->payment_method }}</div>
                                <div class="text-[10px] text-slate-400">Oleh: {{ $exp->recorded_by ?? 'Admin' }}</div>
                            </td>
                            <td class="px-5 py-4 text-right font-extrabold text-rose-600 whitespace-nowrap">
                                Rp {{ number_format($exp->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-4 text-right">
                                <form action="{{ route('admin.expenses.destroy', $exp) }}" method="POST"
                                      onsubmit="return confirm('Hapus catatan pengeluaran ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-xl text-rose-400 hover:text-rose-700 hover:bg-rose-50" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                                Belum ada catatan pengeluaran untuk periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($expenses->hasPages())
            <div class="p-4 border-t border-slate-100">{{ $expenses->links() }}</div>
        @endif
    </div>

    <!-- Modal Tambah Pengeluaran -->
    <div x-show="addModalOpen" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         @keydown.escape.window="addModalOpen = false">
        <div @click.outside="addModalOpen = false"
             class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border-4 border-[#0F2C59] relative">
            <button type="button" @click="addModalOpen = false" class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
            <h3 class="text-base font-extrabold text-[#0F2C59] mb-1">Catat Pengeluaran Operasional</h3>
            <p class="text-xs text-slate-500 mb-4">Catat biaya cetak modul, ATK, listrik, konsumsi, atau operasional lainnya.</p>

            <form action="{{ route('admin.expenses.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Tanggal *</label>
                        <input type="date" name="expense_date" value="{{ now()->toDateString() }}" required
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs font-bold outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Kategori *</label>
                        <select name="category" required class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs font-bold bg-white outline-none">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Keterangan Pengeluaran *</label>
                    <input type="text" name="description" required placeholder="Contoh: Fotokopi modul latihan MIPA & spidol"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Nominal (Rp) *</label>
                        <input type="number" name="amount" min="1" step="500" required placeholder="50000"
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-sm font-extrabold text-rose-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Metode *</label>
                        <select name="payment_method" required class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs font-bold bg-white outline-none">
                            <option value="Tunai">Tunai</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="QRIS / E-Wallet">QRIS / E-Wallet</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Catatan (Opsional)</label>
                    <input type="text" name="notes" placeholder="Nomor nota / toko"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs outline-none">
                </div>
                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl text-xs sm:text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] flex items-center justify-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Simpan Pengeluaran</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
