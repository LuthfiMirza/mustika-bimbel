<!-- Section: Administrasi SPP & Unduh Dokumen Resmi (PDF) -->
<div class="bg-white rounded-3xl p-6 sm:p-8 shadow-md border-2 border-slate-200/80">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
        <div>
            <span class="text-xs font-extrabold uppercase tracking-wider text-[#0D9488]">Dokumen Akademik & Administrasi</span>
            <h2 class="text-lg sm:text-2xl font-extrabold text-[#0F2C59]">E-Raport & Tagihan SPP Siswa</h2>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('portal.download-raport', $student->portal_token) }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold text-white bg-[#0F2C59] hover:bg-[#163A70] shadow-sm transition-all">
                <i data-lucide="printer" class="w-4 h-4 text-[#FACC15]"></i>
                <span>Cetak E-Raport (PDF)</span>
            </a>
        </div>
    </div>

    <!-- Riwayat Tagihan SPP Bulanan -->
    <div class="mt-6">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">
            Informasi SPP & Kwitansi Resmi:
        </h3>

        <div class="space-y-3">
            @forelse ($student->tuitionInvoices as $invoice)
                @php
                    $isPaid = $invoice->status === 'Lunas';
                @endphp
                <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-[#0F2C59] transition-all">
                    <div class="flex items-start sm:items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $isPaid ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            @if ($isPaid)
                                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                            @else
                                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                            @endif
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-extrabold text-[#0F2C59]">{{ $invoice->invoice_number }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $isPaid ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    ● {{ $invoice->status }}
                                </span>
                            </div>
                            <h4 class="text-sm font-extrabold text-slate-800 mt-0.5">
                                SPP Periode: {{ $invoice->billing_period }}
                            </h4>
                            <p class="text-xs text-slate-500 mt-0.5">
                                @if ($isPaid)
                                    Dibayar pada {{ $invoice->paid_at?->translatedFormat('d M Y') ?? '-' }} via {{ $invoice->payment_method ?? 'Transfer' }}
                                @else
                                    Jatuh tempo: {{ $invoice->due_date->translatedFormat('d M Y') }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between sm:justify-end gap-4 shrink-0 border-t sm:border-0 border-slate-200 pt-3 sm:pt-0">
                        <div class="text-left sm:text-right">
                            <span class="text-[10px] text-slate-400 block font-semibold">Nominal SPP</span>
                            <span class="text-base font-extrabold text-[#0F2C59]">
                                Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                            </span>
                        </div>

                        <div>
                            @if ($isPaid)
                                <a href="{{ route('portal.download-invoice', [$student->portal_token, $invoice->id]) }}"
                                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-sm transition-all">
                                    <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                    <span>Unduh Kwitansi (PDF)</span>
                                </a>
                            @else
                                <a href="https://wa.me/6287705555190?text={{ rawurlencode('Halo Admin MustikaBimbel, saya ingin konfirmasi pembayaran SPP ananda ' . $student->full_name . ' (' . $student->student_code . ') untuk periode ' . $invoice->billing_period . '.') }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-extrabold text-white bg-[#0D9488] hover:bg-teal-700 shadow-sm transition-all">
                                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                    <span>Konfirmasi Bayar WA</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-6 text-slate-400 text-xs">
                    Belum ada riwayat tagihan SPP.
                </div>
            @endforelse
        </div>
    </div>
</div>

