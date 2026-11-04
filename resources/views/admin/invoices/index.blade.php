@extends('layouts.admin')

@section('title', 'Manajemen Tagihan SPP & Kwitansi — MustikaBimbel')
@section('header_title', 'Administrasi SPP & Keuangan')

@section('content')
<div class="space-y-6"
     x-data="{
        payModalOpen: false,
        activeInvoice: null,
        generateModalOpen: false,
        openPayModal(inv) {
            this.activeInvoice = inv;
            this.payModalOpen = true;
        }
     }">

    <!-- Top KPI Financial Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Penerimaan SPP (Lunas)</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-emerald-700 mt-2">
                Rp {{ number_format($paidSum, 0, ',', '.') }}
            </div>
            <p class="text-xs text-slate-500 mt-1">{{ $paidCount }} Tagihan Telah Dibayar</p>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Tagihan Tertunda (Belum Lunas)</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-2">
                Rp {{ number_format($unpaidSum, 0, ',', '.') }}
            </div>
            <p class="text-xs text-slate-500 mt-1">{{ $unpaidCount }} Menunggu Pembayaran</p>
        </div>

        <div class="bg-[#0F2C59] text-white rounded-3xl p-6 shadow-md flex items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#FACC15]">Generator Massal</span>
                <h3 class="text-base font-extrabold mt-1">Buat Tagihan SPP Bulanan</h3>
                <p class="text-xs text-slate-300 mt-0.5">Generate tagihan otomatis untuk seluruh siswa aktif</p>
            </div>
            <button type="button" @click="generateModalOpen = true"
                    class="px-4 py-3 rounded-2xl bg-[#FACC15] hover:bg-[#FFD100] text-[#0F2C59] text-xs font-extrabold shadow-md shrink-0 flex items-center gap-1.5 transition-all">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Generate SPP</span>
            </button>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
        <form method="GET" action="{{ route('admin.invoices.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.invoices.index', ['search' => $search]) }}"
                   class="px-3.5 py-2 rounded-xl text-xs font-bold {{ $statusFilter === null ? 'bg-[#0F2C59] text-[#FACC15]' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Semua ({{ $totalInvoicesCount }})
                </a>
                <a href="{{ route('admin.invoices.index', ['status' => 'Belum Lunas', 'search' => $search]) }}"
                   class="px-3.5 py-2 rounded-xl text-xs font-bold {{ $statusFilter === 'Belum Lunas' ? 'bg-amber-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Belum Lunas ({{ $unpaidCount }})
                </a>
                <a href="{{ route('admin.invoices.index', ['status' => 'Lunas', 'search' => $search]) }}"
                   class="px-3.5 py-2 rounded-xl text-xs font-bold {{ $statusFilter === 'Lunas' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Lunas ({{ $paidCount }})
                </a>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Cari no. tagihan / nama siswa..."
                           class="w-full pl-10 pr-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0F2C59] outline-none">
                </div>
                <button type="submit"
                        class="px-4 py-2 rounded-xl text-xs font-bold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100]">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Table of Invoices -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-extrabold border-b border-slate-200 text-[10px]">
                    <tr>
                        <th class="px-5 py-3.5">Nomor &amp; Periode</th>
                        <th class="px-5 py-3.5">Nama Siswa</th>
                        <th class="px-5 py-3.5">Nominal SPP</th>
                        <th class="px-5 py-3.5">Jatuh Tempo</th>
                        <th class="px-5 py-3.5">Status &amp; Pembayaran</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($invoices as $invoice)
                        @php
                            $isPaid = $invoice->status === 'Lunas';
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-4">
                                <div class="font-mono font-extrabold text-xs text-[#0F2C59]">{{ $invoice->invoice_number }}</div>
                                <div class="text-xs font-bold text-slate-700 mt-0.5">{{ $invoice->billing_period }}</div>
                            </td>

                            <td class="px-5 py-4">
                                <div class="font-extrabold text-sm text-slate-800">{{ $invoice->student->full_name }}</div>
                                <div class="text-[11px] text-slate-500">{{ $invoice->student->student_code }} &bull; {{ $invoice->student->grade_level }}</div>
                            </td>

                            <td class="px-5 py-4">
                                <span class="font-extrabold text-sm text-[#0F2C59]">
                                    Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                <span class="text-xs text-slate-600 font-semibold">{{ $invoice->due_date->translatedFormat('d M Y') }}</span>
                            </td>

                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-extrabold {{ $isPaid ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    ● {{ $invoice->status }}
                                </span>
                                @if($isPaid)
                                    <div class="text-[10px] text-slate-500 mt-1">
                                        {{ $invoice->payment_method ?? 'Transfer' }} ({{ $invoice->paid_at?->format('d/m/Y') }})
                                    </div>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if(! $isPaid)
                                        <!-- Tombol Kirim Pengingat WA Sopan -->
                                        <a href="{{ App\Services\WhatsAppService::generateTuitionReminderUrl($invoice) }}" target="_blank"
                                           class="px-2.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1 shadow-sm"
                                           title="Kirim Pengingat WA Sopan">
                                            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                            <span>Ingatkan WA</span>
                                        </a>

                                        <!-- Tombol Tandai Lunas -->
                                        <button type="button"
                                                @click="openPayModal({
                                                    id: '{{ $invoice->id }}',
                                                    number: '{{ $invoice->invoice_number }}',
                                                    name: '{{ addslashes($invoice->student->full_name) }}',
                                                    amount: 'Rp {{ number_format($invoice->amount, 0, ',', '.') }}'
                                                })"
                                                class="px-2.5 py-1.5 rounded-xl bg-[#0F2C59] hover:bg-[#163A70] text-[#FACC15] font-extrabold text-xs flex items-center gap-1 shadow-sm"
                                                title="Tandai Pembayaran Lunas">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                            <span>Bayar</span>
                                        </button>
                                    @else
                                        <!-- Tombol Unduh Kwitansi PDF -->
                                        <a href="{{ route('portal.download-invoice', [$invoice->student->portal_token, $invoice->id]) }}"
                                           class="px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-[#0F2C59] font-bold text-xs flex items-center gap-1 shadow-sm"
                                           title="Unduh Kwitansi PDF">
                                            <i data-lucide="printer" class="w-3.5 h-3.5 text-[#0D9488]"></i>
                                            <span>Kwitansi PDF</span>
                                        </a>
                                    @endif

                                    <!-- Hapus Tagihan -->
                                    <form action="{{ route('admin.invoices.destroy', $invoice) }}" method="POST"
                                          onsubmit="return confirm('Hapus tagihan {{ $invoice->invoice_number }}?');"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-xl text-rose-400 hover:text-rose-700 hover:bg-rose-50" title="Hapus Tagihan">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                                Belum ada data tagihan SPP yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($invoices->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Konfirmasi Bayar / Tandai Lunas -->
    <div x-show="payModalOpen" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         @keydown.escape.window="payModalOpen = false">
        <div @click.outside="payModalOpen = false"
             class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border-4 border-[#FACC15] relative">
            <button type="button" @click="payModalOpen = false"
                    class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <h3 class="text-base font-extrabold text-[#0F2C59] mb-1">Konfirmasi Pembayaran Lunas</h3>
            <p class="text-xs text-slate-500 mb-4">
                No. Tagihan: <strong class="font-mono" x-text="activeInvoice?.number"></strong> &bull; Siswa: <strong x-text="activeInvoice?.name"></strong>
            </p>

            <form :action="'/admin/invoices/' + activeInvoice?.id + '/pay'" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <span class="text-[11px] text-slate-500 block">Jumlah Yang Dibayar</span>
                    <span class="text-xl font-extrabold text-[#0F2C59]" x-text="activeInvoice?.amount"></span>
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Metode Pembayaran *</label>
                    <select name="payment_method" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold bg-white outline-none">
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="QRIS / E-Wallet">QRIS / E-Wallet</option>
                        <option value="Tunai">Tunai</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Catatan Kasir (Opsional)</label>
                    <input type="text" name="notes" placeholder="Misal: Diterima oleh Kak Mustika"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm outline-none">
                </div>

                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl text-xs sm:text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    <span>Tandai LUNAS &amp; Terbitkan Kwitansi</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Generate Massal Tagihan SPP Bulanan -->
    <div x-show="generateModalOpen" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         @keydown.escape.window="generateModalOpen = false">
        <div @click.outside="generateModalOpen = false"
             class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border-4 border-[#0F2C59] relative">
            <button type="button" @click="generateModalOpen = false"
                    class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <h3 class="text-base font-extrabold text-[#0F2C59] mb-1">Generate Tagihan SPP Massal</h3>
            <p class="text-xs text-slate-500 mb-4">Tagihan otomatis dibuat untuk seluruh siswa berstatus Aktif.</p>

            <form action="{{ route('admin.invoices.generate') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Periode Tagihan SPP *</label>
                    <input type="text" name="billing_period" value="{{ \Carbon\Carbon::now()->addMonth()->translatedFormat('F Y') }}" required
                           placeholder="Contoh: Desember 2026"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold text-[#0F2C59] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Tanggal Jatuh Tempo *</label>
                    <input type="date" name="due_date" value="{{ \Carbon\Carbon::now()->addMonth()->startOfMonth()->addDays(9)->toDateString() }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm outline-none">
                </div>

                <div class="p-3 bg-blue-50 border border-blue-200 rounded-xl text-[11px] text-blue-800">
                    Sistem akan mengecek otomatis; jika siswa sudah memiliki tagihan untuk periode ini, tidak akan dibuat ganda.
                </div>

                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl text-xs sm:text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                    <span>Generate Tagihan Seluruh Siswa</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
