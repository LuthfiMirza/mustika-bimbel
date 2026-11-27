@extends('layouts.admin')

@section('title', 'Manajemen Tagihan SPP & Kwitansi — MustikaBimbel')
@section('header_title', 'Administrasi SPP, Diskon & Cicilan')

@section('content')
<div class="space-y-6"
     x-data="{
        payModalOpen: false,
        activeInvoice: null,
        payAmount: 0,
        generateModalOpen: false,
        openPayModal(inv) {
            this.activeInvoice = inv;
            this.payAmount = inv.remaining;
            this.payModalOpen = true;
        },
        formatRp(num) {
            return 'Rp ' + Number(num || 0).toLocaleString('id-ID');
        }
     }">

    <!-- Sub-Navigation Tabs: Daftar Tagihan vs Kartu SPP 12 Bulan -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="inline-flex p-1 rounded-2xl bg-white border border-slate-200 shadow-sm">
            <a href="{{ route('admin.invoices.index') }}"
               class="px-4 py-2 rounded-xl text-xs font-extrabold bg-[#0F2C59] text-[#FACC15] shadow-sm flex items-center gap-1.5">
                <i data-lucide="list-checks" class="w-3.5 h-3.5"></i>
                <span>Daftar Tagihan &amp; Cicilan</span>
            </a>
            <a href="{{ route('admin.invoices.card') }}"
               class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-[#0F2C59] flex items-center gap-1.5">
                <i data-lucide="grid-3x3" class="w-3.5 h-3.5"></i>
                <span>Kartu SPP 12 Bulan</span>
            </a>
        </div>

        <a href="{{ route('admin.settings.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-[#0F2C59]">
            <i data-lucide="sliders-horizontal" class="w-3.5 h-3.5"></i>
            <span>Atur Jatuh Tempo (Tgl {{ $dueDay }}) &amp; Template WA</span>
        </a>
    </div>

    <!-- Quick Action Banner: Kirim WA Kuitansi setelah Bayar -->
    @if (session('wa_receipt_url'))
        <div class="p-4 rounded-2xl bg-emerald-600 text-white shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-2.5 text-xs sm:text-sm font-bold">
                <i data-lucide="send" class="w-5 h-5 text-[#FACC15] shrink-0"></i>
                <span>Kirim pesan terima kasih &amp; nomor kuitansi pembayaran untuk <strong>{{ session('wa_receipt_student') }}</strong> via WhatsApp?</span>
            </div>
            <a href="{{ session('wa_receipt_url') }}" target="_blank"
               class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl bg-[#FACC15] hover:bg-[#FFD100] text-[#0F2C59] text-xs font-extrabold shadow shrink-0">
                <i data-lucide="message-circle" class="w-4 h-4"></i>
                <span>Kirim WA Kuitansi Sekarang</span>
            </a>
        </div>
    @endif

    <!-- Top KPI Financial Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Kas SPP Terkumpul</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-emerald-700 mt-2">
                Rp {{ number_format($paidSum, 0, ',', '.') }}
            </div>
            <p class="text-xs text-slate-500 mt-1">{{ $paidCount }} Lunas &bull; {{ $partialCount }} Cicilan (Kurang)</p>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Total Sisa Tunggakan SPP</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-2">
                Rp {{ number_format($unpaidSum, 0, ',', '.') }}
            </div>
            <p class="text-xs text-slate-500 mt-1">{{ $unpaidCount + $partialCount }} Tagihan Belum Lunas / Kurang</p>
        </div>

        <div class="bg-[#0F2C59] text-white rounded-3xl p-6 shadow-md flex items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#FACC15]">Generator Massal</span>
                <h3 class="text-base font-extrabold mt-1">Buat Tagihan SPP Bulanan</h3>
                <p class="text-xs text-slate-300 mt-0.5">Otomatis potong diskon SPP tiap siswa aktif</p>
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
        <form method="GET" action="{{ route('admin.invoices.index') }}" class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.invoices.index', ['search' => $search]) }}"
                   class="px-3.5 py-2 rounded-xl text-xs font-bold {{ $statusFilter === null ? 'bg-[#0F2C59] text-[#FACC15]' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Semua ({{ $totalInvoicesCount }})
                </a>
                <a href="{{ route('admin.invoices.index', ['status' => 'Belum Lunas', 'search' => $search]) }}"
                   class="px-3.5 py-2 rounded-xl text-xs font-bold {{ $statusFilter === 'Belum Lunas' ? 'bg-rose-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Belum Lunas ({{ $unpaidCount }})
                </a>
                <a href="{{ route('admin.invoices.index', ['status' => 'Kurang', 'search' => $search]) }}"
                   class="px-3.5 py-2 rounded-xl text-xs font-bold {{ $statusFilter === 'Kurang' ? 'bg-amber-500 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Kurang / Cicil ({{ $partialCount }})
                </a>
                <a href="{{ route('admin.invoices.index', ['status' => 'Lunas', 'search' => $search]) }}"
                   class="px-3.5 py-2 rounded-xl text-xs font-bold {{ $statusFilter === 'Lunas' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Lunas ({{ $paidCount }})
                </a>
            </div>

            <div class="flex items-center gap-2 w-full md:w-auto">
                <div class="relative w-full md:w-64">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Cari no. tagihan / periode / siswa..."
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
                        <th class="px-5 py-3.5">Tagihan &amp; Diskon</th>
                        <th class="px-5 py-3.5">Terbayar / Sisa</th>
                        <th class="px-5 py-3.5">Status &amp; Jatuh Tempo</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($invoices as $invoice)
                        @php
                            $isPaid = $invoice->status === 'Lunas';
                            $isPartial = $invoice->status === 'Kurang';
                            $remaining = $invoice->remaining_amount;
                            $paidDisplay = $isPaid && (int) $invoice->paid_amount === 0 ? (int) $invoice->amount : (int) $invoice->paid_amount;
                            $isOverdue = ! $isPaid && $invoice->due_date->isPast();
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
                                <div class="font-extrabold text-sm text-[#0F2C59]">
                                    Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                                </div>
                                @if((int) $invoice->discount_amount > 0)
                                    <div class="text-[10px] text-teal-700 font-bold mt-0.5">
                                        Tarif Rp {{ number_format($invoice->base_amount, 0, ',', '.') }} &minus; Diskon Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <div class="text-xs font-bold text-emerald-700">
                                    Masuk: Rp {{ number_format($paidDisplay, 0, ',', '.') }}
                                </div>
                                @if($remaining > 0)
                                    <div class="text-[11px] font-extrabold text-rose-600 mt-0.5">
                                        Sisa: Rp {{ number_format($remaining, 0, ',', '.') }}
                                    </div>
                                @else
                                    <div class="text-[10px] text-slate-400 mt-0.5">Sisa: Rp 0</div>
                                @endif
                                @if($invoice->payments->count() > 0)
                                    <div class="text-[10px] text-slate-500 mt-0.5">
                                        {{ $invoice->payments->count() }}x transaksi ({{ $invoice->payments->first()->receipt_number }})
                                    </div>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                @if($isPaid)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800">
                                        ● Lunas
                                    </span>
                                @elseif($isPartial)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800">
                                        ◐ Kurang (Cicil)
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-extrabold bg-rose-100 text-rose-800">
                                        ● Belum Lunas
                                    </span>
                                @endif
                                <div class="text-[10px] mt-1 {{ $isOverdue ? 'text-rose-600 font-extrabold' : 'text-slate-500' }}">
                                    JT: {{ $invoice->due_date->translatedFormat('d M Y') }}
                                    @if($isOverdue) (Lewat JT) @endif
                                </div>
                            </td>

                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5 flex-wrap">
                                    @if(! $isPaid)
                                        <a href="{{ App\Services\WhatsAppService::generateTuitionReminderUrl($invoice) }}" target="_blank"
                                           class="px-2.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1 shadow-sm"
                                           title="Kirim Pengingat WA">
                                            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                            <span>Ingatkan WA</span>
                                        </a>

                                        <button type="button"
                                                @click="openPayModal({
                                                    id: '{{ $invoice->id }}',
                                                    number: '{{ $invoice->invoice_number }}',
                                                    name: '{{ addslashes($invoice->student->full_name) }}',
                                                    total: {{ (int) $invoice->amount }},
                                                    paid: {{ $paidDisplay }},
                                                    remaining: {{ $remaining }}
                                                })"
                                                class="px-2.5 py-1.5 rounded-xl bg-[#0F2C59] hover:bg-[#163A70] text-[#FACC15] font-extrabold text-xs flex items-center gap-1 shadow-sm"
                                                title="Catat Pembayaran Penuh atau Cicilan">
                                            <i data-lucide="wallet" class="w-3.5 h-3.5"></i>
                                            <span>{{ $isPartial ? 'Bayar Sisa' : 'Bayar / Cicil' }}</span>
                                        </button>
                                    @endif

                                    @if($isPaid || $isPartial)
                                        <a href="{{ route('portal.download-invoice', [$invoice->student->portal_token, $invoice->id]) }}"
                                           class="px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-[#0F2C59] font-bold text-xs flex items-center gap-1 shadow-sm"
                                           title="Unduh Kwitansi PDF">
                                            <i data-lucide="printer" class="w-3.5 h-3.5 text-[#0D9488]"></i>
                                            <span>PDF</span>
                                        </a>
                                    @endif

                                    <form action="{{ route('admin.invoices.destroy', $invoice) }}" method="POST"
                                          onsubmit="return confirm('Hapus tagihan {{ $invoice->invoice_number }} beserta riwayat pembayarannya?');"
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

    <!-- Modal Catat Pembayaran (Penuh / Cicilan) -->
    <div x-show="payModalOpen" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         @keydown.escape.window="payModalOpen = false">
        <div @click.outside="payModalOpen = false"
             class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border-4 border-[#FACC15] relative">
            <button type="button" @click="payModalOpen = false"
                    class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <h3 class="text-base font-extrabold text-[#0F2C59] mb-1">Catat Pembayaran SPP / Cicilan</h3>
            <p class="text-xs text-slate-500 mb-4">
                No: <strong class="font-mono" x-text="activeInvoice?.number"></strong> &bull; <strong x-text="activeInvoice?.name"></strong>
            </p>

            <form :action="'/admin/invoices/' + activeInvoice?.id + '/pay'" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-2 gap-2 p-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs">
                    <div>
                        <span class="text-[10px] text-slate-500 block">Total Tagihan</span>
                        <strong class="text-[#0F2C59]" x-text="formatRp(activeInvoice?.total)"></strong>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 block">Sisa Belum Dibayar</span>
                        <strong class="text-rose-600" x-text="formatRp(activeInvoice?.remaining)"></strong>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-xs font-extrabold uppercase text-slate-600">Nominal Dibayar (Rp) *</label>
                        <div class="flex gap-1">
                            <button type="button" @click="payAmount = Math.round((activeInvoice?.remaining || 0) / 2)"
                                    class="px-2 py-0.5 rounded-lg bg-amber-100 text-amber-900 text-[10px] font-extrabold hover:bg-amber-200">
                                Cicil 50%
                            </button>
                            <button type="button" @click="payAmount = activeInvoice?.remaining || 0"
                                    class="px-2 py-0.5 rounded-lg bg-emerald-100 text-emerald-900 text-[10px] font-extrabold hover:bg-emerald-200">
                                Lunaskan
                            </button>
                        </div>
                    </div>
                    <input type="number" name="amount" x-model="payAmount" min="1" :max="activeInvoice?.remaining" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-extrabold text-[#0F2C59] focus:ring-2 focus:ring-[#0F2C59] outline-none">
                    <p class="text-[10px] text-slate-500 mt-1" x-show="Number(payAmount) < Number(activeInvoice?.remaining)">
                        Status akan otomatis menjadi <strong class="text-amber-700">Kurang (Cicil)</strong> dengan sisa <strong x-text="formatRp((activeInvoice?.remaining || 0) - Number(payAmount || 0))"></strong>.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Tanggal Bayar *</label>
                        <input type="date" name="payment_date" value="{{ now()->toDateString() }}" required
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs font-bold outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Metode *</label>
                        <select name="payment_method" required
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs font-bold bg-white outline-none">
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="QRIS / E-Wallet">QRIS / E-Wallet</option>
                            <option value="Tunai">Tunai</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Diterima Oleh</label>
                        <input type="text" name="received_by" value="{{ Auth::user()?->name }}"
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Catatan (Opsional)</label>
                        <input type="text" name="notes" placeholder="Cicilan 1 / Lunas"
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs outline-none">
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl text-xs sm:text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    <span>Simpan Pembayaran &amp; Terbitkan Kuitansi</span>
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
            <p class="text-xs text-slate-500 mb-4">Otomatis menghitung Tarif Program &minus; Diskon SPP masing-masing siswa aktif.</p>

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
                    <input type="date" name="due_date" value="{{ \Carbon\Carbon::now()->addMonth()->startOfMonth()->addDays($dueDay - 1)->toDateString() }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm outline-none">
                </div>

                <div class="p-3 bg-blue-50 border border-blue-200 rounded-xl text-[11px] text-blue-800">
                    Sistem anti-duplikat: siswa yang sudah punya tagihan di periode ini akan dilewati otomatis.
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
