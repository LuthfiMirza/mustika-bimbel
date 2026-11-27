@extends('layouts.admin')

@section('title', 'Pengaturan Bimbel & Template WA — MustikaBimbel')
@section('header_title', 'Pengaturan Bimbel & Template WA')
@section('breadcrumb', 'Pengaturan')

@section('content')
<div class="space-y-6"
     x-data="{
        tab: 'identity',
        bimbelName: @js(old('bimbel_name', $settings['bimbel_name'])),
        adminWa: @js(old('admin_whatsapp', $settings['admin_whatsapp'])),
        paymentInfo: @js(old('payment_info', $settings['payment_info'])),
        dueDay: @js(old('tuition_due_day', $settings['tuition_due_day'])),
        tplReminder: @js(old('wa_template_reminder', $settings['wa_template_reminder'])),
        tplReceipt: @js(old('wa_template_receipt', $settings['wa_template_receipt'])),
        renderPreview(template) {
            const replacements = {
                '{wali}': 'Ibu Rina Kartika',
                '{siswa}': 'Aisyah Putri Rahmawati',
                '{panggilan}': 'Aisyah',
                '{kode_siswa}': 'MB-2026-001',
                '{no_tagihan}': 'INV-MB-202611-001',
                '{bulan}': 'November 2026',
                '{tagihan}': 'Rp 200.000',
                '{sisa}': 'Rp 100.000',
                '{total_tunggakan}': 'Rp 100.000',
                '{jatuh_tempo}': this.dueDay + ' November 2026',
                '{status}': 'Kurang',
                '{pembayaran}': this.paymentInfo,
                '{bimbel}': this.bimbelName,
                '{admin}': this.adminWa,
                '{jumlah}': 'Rp 100.000',
                '{tanggal}': '10 November 2026',
                '{kuitansi}': 'KWT-MB-202611-001',
                '{metode}': 'QRIS / E-Wallet',
                '{link_raport}': '{{ url('/raport/raport-aisyah-01') }}'
            };
            let out = template || '';
            for (const [k, v] of Object.entries(replacements)) {
                out = out.split(k).join(v);
            }
            return out;
        }
     }">

    <!-- Header Info -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Setup Dinamis</span>
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#0F2C59]">Identitas, Rekening SPP &amp; Template WhatsApp</h2>
            <p class="text-xs text-slate-500 mt-1">Semua perubahan di sini langsung dipakai di pesan WhatsApp otomatis, kwitansi PDF, dan Kartu SPP 12 Bulan.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-xs font-semibold text-rose-800 space-y-1">
            <div class="font-extrabold">Mohon periksa kembali isian berikut:</div>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Navigation Tabs -->
    <div class="flex flex-wrap gap-2">
        <button type="button" @click="tab = 'identity'"
                :class="tab === 'identity' ? 'bg-[#0F2C59] text-[#FACC15] shadow' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'"
                class="px-4 py-2.5 rounded-2xl text-xs font-extrabold flex items-center gap-2 transition-all">
            <i data-lucide="building-2" class="w-4 h-4"></i>
            <span>Identitas &amp; Info Pembayaran</span>
        </button>
        <button type="button" @click="tab = 'tuition'"
                :class="tab === 'tuition' ? 'bg-[#0F2C59] text-[#FACC15] shadow' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'"
                class="px-4 py-2.5 rounded-2xl text-xs font-extrabold flex items-center gap-2 transition-all">
            <i data-lucide="calendar-clock" class="w-4 h-4"></i>
            <span>Pengaturan Periode SPP</span>
        </button>
        <button type="button" @click="tab = 'whatsapp'"
                :class="tab === 'whatsapp' ? 'bg-[#0F2C59] text-[#FACC15] shadow' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'"
                class="px-4 py-2.5 rounded-2xl text-xs font-extrabold flex items-center gap-2 transition-all">
            <i data-lucide="message-circle" class="w-4 h-4"></i>
            <span>Template Pesan WhatsApp</span>
        </button>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Tab 1: Identitas & Rekening -->
        <div x-show="tab === 'identity'" x-cloak class="bg-white rounded-2xl p-6 border border-slate-200 space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-extrabold text-[#0F2C59]">Identitas Bimbel &amp; Rekening Pembayaran</h3>
                <p class="text-xs text-slate-500">Muncul di kop kwitansi PDF, header admin, dan pesan tagihan WhatsApp.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1.5">Nama Bimbel</label>
                    <input type="text" name="bimbel_name" x-model="bimbelName" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1.5">Nama Pemilik / Penanggung Jawab</label>
                    <input type="text" name="owner_name" value="{{ old('owner_name', $settings['owner_name']) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1.5">No. WhatsApp Admin</label>
                    <input type="text" name="admin_whatsapp" x-model="adminWa" required placeholder="087705555190"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1.5">Alamat Lengkap Bimbel</label>
                    <input type="text" name="bimbel_address" value="{{ old('bimbel_address', $settings['bimbel_address']) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 mb-1.5">Info Pembayaran (Rekening Bank / QRIS / Tunai)</label>
                <textarea name="payment_info" rows="3" x-model="paymentInfo" required
                          placeholder="Contoh: Transfer BCA 1234567890 a.n. Mustika, QRIS, atau tunai di lokasi bimbel."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none"></textarea>
                <p class="text-[11px] text-slate-500 mt-1">Teks ini otomatis disisipkan pada placeholder <code class="px-1.5 py-0.5 rounded bg-slate-100 text-[#0F2C59] font-bold">{pembayaran}</code> di pesan reminder SPP.</p>
            </div>
        </div>

        <!-- Tab 2: Pengaturan Periode SPP -->
        <div x-show="tab === 'tuition'" x-cloak class="bg-white rounded-2xl p-6 border border-slate-200 space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-extrabold text-[#0F2C59]">Pengaturan Jatuh Tempo &amp; Periode 12 Bulan</h3>
                <p class="text-xs text-slate-500">Menentukan tanggal jatuh tempo default saat generate tagihan serta bulan awal tampilan Kartu SPP &amp; Laporan Laba Bersih.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1.5">Tanggal Jatuh Tempo SPP Setiap Bulan (1 – 28)</label>
                    <input type="number" name="tuition_due_day" min="1" max="28" x-model="dueDay" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-[#0F2C59] outline-none">
                    <p class="text-[11px] text-slate-500 mt-1">Contoh: isi <strong>10</strong> maka setiap tagihan bulanan otomatis jatuh tempo tanggal 10.</p>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1.5">Bulan Mulai Periode 12 Bulan (Kartu SPP &amp; Laporan)</label>
                    <input type="month" name="period_start_month" value="{{ old('period_start_month', $settings['period_start_month']) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-[#0F2C59] outline-none">
                    <p class="text-[11px] text-slate-500 mt-1">Default <strong>Juli (Tahun Ajaran Baru)</strong>, bisa diganti ke Januari (Tahun Kalender) kapan saja.</p>
                </div>
            </div>
        </div>

        <!-- Tab 3: Template Pesan WhatsApp -->
        <div x-show="tab === 'whatsapp'" x-cloak class="space-y-6">
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-xs text-amber-900">
                <div class="font-extrabold mb-1.5 flex items-center gap-1.5">
                    <i data-lucide="sparkles" class="w-4 h-4 text-amber-600"></i>
                    <span>Kata Kunci Otomatis (Placeholders)</span>
                </div>
                <p class="leading-relaxed">
                    Umum &amp; SPP:
                    <code>{wali}</code> <code>{siswa}</code> <code>{kode_siswa}</code> <code>{no_tagihan}</code> <code>{bulan}</code> <code>{tagihan}</code> <code>{sisa}</code> <code>{total_tunggakan}</code> <code>{jatuh_tempo}</code> <code>{status}</code> <code>{pembayaran}</code> <code>{link_raport}</code> <code>{bimbel}</code> <code>{admin}</code>
                    <br>
                    Khusus Kuitansi: <code>{jumlah}</code> <code>{tanggal}</code> <code>{kuitansi}</code> <code>{metode}</code>
                    &bull; Khusus Presensi/Jurnal: <code>{panggilan}</code> <code>{jam}</code> <code>{kategori}</code> <code>{topik}</code> <code>{bintang}</code> <code>{kecepatan}</code> <code>{skor}</code> <code>{catatan}</code>
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Template Reminder SPP + Preview -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 space-y-3">
                    <label class="block text-sm font-extrabold text-[#0F2C59]">1. Template Pengingat Tagihan SPP</label>
                    <textarea name="wa_template_reminder" rows="9" x-model="tplReminder" required
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-[#0F2C59] outline-none"></textarea>
                    <div class="p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-200">
                        <div class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-700 mb-1">Pratinjau Pesan WA</div>
                        <pre class="text-xs text-slate-800 whitespace-pre-wrap font-sans leading-relaxed" x-text="renderPreview(tplReminder)"></pre>
                    </div>
                </div>

                <!-- Template Kwitansi / Terima Kasih + Preview -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 space-y-3">
                    <label class="block text-sm font-extrabold text-[#0F2C59]">2. Template Terima Kasih / Kuitansi Pembayaran</label>
                    <textarea name="wa_template_receipt" rows="9" x-model="tplReceipt" required
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-[#0F2C59] outline-none"></textarea>
                    <div class="p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-200">
                        <div class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-700 mb-1">Pratinjau Pesan WA</div>
                        <pre class="text-xs text-slate-800 whitespace-pre-wrap font-sans leading-relaxed" x-text="renderPreview(tplReceipt)"></pre>
                    </div>
                </div>

                <!-- Template Kedatangan -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 space-y-3">
                    <label class="block text-sm font-extrabold text-[#0F2C59]">3. Template Notifikasi Anak Tiba</label>
                    <textarea name="wa_template_arrival" rows="6" required
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-[#0F2C59] outline-none">{{ old('wa_template_arrival', $settings['wa_template_arrival']) }}</textarea>
                </div>

                <!-- Template Laporan Jurnal Pulang -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 space-y-3">
                    <label class="block text-sm font-extrabold text-[#0F2C59]">4. Template Laporan Jurnal Pulang</label>
                    <textarea name="wa_template_report" rows="6" required
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-[#0F2C59] outline-none">{{ old('wa_template_report', $settings['wa_template_report']) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Submit Footer -->
        <div class="flex justify-end">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-md transition-all">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>Simpan Semua Pengaturan</span>
            </button>
        </div>
    </form>
</div>
@endsection

