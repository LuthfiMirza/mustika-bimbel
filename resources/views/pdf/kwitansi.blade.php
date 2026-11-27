<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi Pembayaran SPP - {{ $invoice->invoice_number }}</title>
    <style>
        @page {
            margin: 28px 35px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.45;
        }
        .receipt-box {
            border: 2px solid #0F2C59;
            border-radius: 8px;
            padding: 22px;
            position: relative;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #0F2C59;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .brand-title {
            font-size: 19px;
            font-weight: bold;
            color: #0F2C59;
            margin: 0;
            line-height: 1.1;
        }
        .brand-sub {
            font-size: 10px;
            color: #0D9488;
            font-weight: bold;
        }
        .brand-address {
            font-size: 9px;
            color: #64748b;
            margin-top: 3px;
        }
        .receipt-badge {
            background-color: #0F2C59;
            color: #FACC15;
            padding: 5px 12px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 4px;
            display: inline-block;
        }
        .receipt-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            color: #0F2C59;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .data-table td {
            padding: 4px;
            vertical-align: top;
            font-size: 10.5px;
        }
        .lbl {
            width: 26%;
            font-weight: bold;
            color: #475569;
        }
        .col {
            width: 3%;
            text-align: center;
        }
        .val {
            width: 71%;
            font-weight: bold;
            color: #0F2C59;
        }
        .amount-box {
            background-color: #f8fafc;
            border: 2px dashed #0D9488;
            padding: 10px 14px;
            border-radius: 6px;
            margin: 8px 0;
            font-size: 14px;
            font-weight: bold;
            color: #0F2C59;
        }
        .stamp-lunas {
            border: 2px solid #059669;
            color: #059669;
            font-size: 13px;
            font-weight: bold;
            padding: 4px 12px;
            display: inline-block;
            border-radius: 6px;
            letter-spacing: 1.5px;
            transform: rotate(-5deg);
        }
        .stamp-kurang {
            border: 2px solid #d97706;
            color: #d97706;
            font-size: 11px;
            font-weight: bold;
            padding: 4px 10px;
            display: inline-block;
            border-radius: 6px;
            letter-spacing: 1px;
            transform: rotate(-4deg);
        }
        .stamp-belum {
            border: 2px solid #e11d48;
            color: #e11d48;
            font-size: 11px;
            font-weight: bold;
            padding: 4px 10px;
            display: inline-block;
            border-radius: 6px;
            letter-spacing: 1px;
        }
        .payments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 9.5px;
        }
        .payments-table th {
            background-color: #f1f5f9;
            color: #334155;
            text-align: left;
            padding: 4px 6px;
            border-bottom: 1px solid #cbd5e1;
        }
        .payments-table td {
            padding: 4px 6px;
            border-bottom: 1px solid #e2e8f0;
        }
        .sign-table {
            width: 100%;
            margin-top: 16px;
            border-collapse: collapse;
        }
        .footer-note {
            font-size: 8.5px;
            color: #64748b;
            text-align: center;
            border-top: 1px dotted #cbd5e1;
            padding-top: 8px;
            margin-top: 14px;
        }
    </style>
</head>
<body>
@php
    $bimbelName = \App\Models\Setting::get('bimbel_name', 'MustikaBimbel');
    $bimbelAddress = \App\Models\Setting::get('bimbel_address', 'Perumahan Amarylis Garden, Jl. H Abdul Gani II Blok I No. 11, Harapan Jaya, Cibinong');
    $adminWa = \App\Models\Setting::get('admin_whatsapp', '087705555190');
    $ownerName = \App\Models\Setting::get('owner_name', 'Bendahara MustikaBimbel');

    $isPaid = $invoice->status === 'Lunas';
    $isPartial = $invoice->status === 'Kurang';
    $paidAmount = $isPaid && (int) $invoice->paid_amount === 0 ? (int) $invoice->amount : (int) $invoice->paid_amount;
    $remainingAmount = max(0, (int) $invoice->amount - $paidAmount);
    $latestPayment = $invoice->payments->first();
@endphp

<div class="receipt-box">
    <!-- Header Instansi -->
    <table class="header-table">
        <tr>
            <td style="width: 65%;">
                <h1 class="brand-title">{{ $bimbelName }}</h1>
                <div class="brand-sub">Bimbel Jarimatika &amp; MIPA &bull; Cibinong</div>
                <div class="brand-address">
                    {{ $bimbelAddress }}<br>
                    WhatsApp: {{ $adminWa }} &bull; "Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!"
                </div>
            </td>
            <td style="width: 35%; text-align: right;">
                <div class="receipt-badge">{{ $isPaid ? 'KWITANSI RESMI' : ($isPartial ? 'BUKTI CICILAN' : 'TAGIHAN SPP') }}</div>
                <div style="font-size: 9.5px; font-weight: bold; color: #0F2C59; margin-top: 5px;">
                    No: {{ $latestPayment?->receipt_number ?? $invoice->invoice_number }}
                </div>
                <div style="font-size: 9px; color: #64748b;">
                    Tanggal: {{ $invoice->paid_at ? $invoice->paid_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
                </div>
            </td>
        </tr>
    </table>

    <div class="receipt-title">Tanda Bukti Pembayaran SPP</div>

    <!-- Rincian Data Kwitansi -->
    <table class="data-table">
        <tr>
            <td class="lbl">Telah Diterima Dari</td>
            <td class="col">:</td>
            <td class="val">{{ $invoice->student->parent_name }}</td>
        </tr>
        <tr>
            <td class="lbl">Nama Siswa / Nomor Induk</td>
            <td class="col">:</td>
            <td class="val">{{ $invoice->student->full_name }} ({{ $invoice->student->student_code }})</td>
        </tr>
        <tr>
            <td class="lbl">Jenjang &amp; Program</td>
            <td class="col">:</td>
            <td class="val">{{ $invoice->student->grade_level }} &bull; {{ $invoice->student->program->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="lbl">Untuk Pembayaran</td>
            <td class="col">:</td>
            <td class="val">
                Biaya Belajar (SPP) Periode <u>{{ $invoice->billing_period }}</u> (Ref: {{ $invoice->invoice_number }})
                @if((int) $invoice->discount_amount > 0)
                    <br><span style="font-size: 9.5px; color: #0D9488; font-weight: normal;">
                        Tarif Program Rp {{ number_format($invoice->base_amount, 0, ',', '.') }} &minus; Diskon Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }} = Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                    </span>
                @endif
            </td>
        </tr>
        <tr>
            <td class="lbl">Metode Pembayaran</td>
            <td class="col">:</td>
            <td class="val">{{ $latestPayment?->payment_method ?? $invoice->payment_method ?? 'Transfer Bank / QRIS' }}</td>
        </tr>
        <tr>
            <td class="lbl">Keterangan / Catatan</td>
            <td class="col">:</td>
            <td class="val" style="font-weight: normal; font-style: italic; color: #475569;">
                {{ $invoice->notes ?? ($isPaid ? 'Pembayaran SPP terverifikasi lunas.' : 'Pembayaran cicilan SPP diterima.') }}
            </td>
        </tr>
    </table>

    <!-- Kotak Jumlah Nominal & Status -->
    <table style="width: 100%; margin: 8px 0;">
        <tr>
            <td style="width: 65%;">
                <div class="amount-box">
                    Sudah Dibayar: Rp {{ number_format($paidAmount, 0, ',', '.') }},-
                    @if($remainingAmount > 0)
                        <div style="font-size: 11px; color: #e11d48; margin-top: 3px;">
                            Sisa Tagihan: Rp {{ number_format($remainingAmount, 0, ',', '.') }},- (Total Tagihan Rp {{ number_format($invoice->amount, 0, ',', '.') }})
                        </div>
                    @endif
                </div>
            </td>
            <td style="width: 35%; text-align: center; vertical-align: middle;">
                @if($isPaid)
                    <div class="stamp-lunas">✓ LUNAS</div>
                @elseif($isPartial)
                    <div class="stamp-kurang">◐ CICILAN (KURANG)</div>
                @else
                    <div class="stamp-belum">BELUM LUNAS</div>
                @endif
            </td>
        </tr>
    </table>

    @if($invoice->payments->count() > 0)
        <table class="payments-table">
            <thead>
                <tr>
                    <th>No. Kuitansi</th>
                    <th>Tanggal Bayar</th>
                    <th>Metode</th>
                    <th>Diterima Oleh</th>
                    <th style="text-align: right;">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->payments as $pay)
                    <tr>
                        <td>{{ $pay->receipt_number }}</td>
                        <td>{{ $pay->payment_date->translatedFormat('d M Y') }}</td>
                        <td>{{ $pay->payment_method }}</td>
                        <td>{{ $pay->received_by ?? 'Admin' }}</td>
                        <td style="text-align: right; font-weight: bold;">Rp {{ number_format($pay->amount, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Tanda Tangan Kasir / Pengelola -->
    <table class="sign-table">
        <tr>
            <td style="width: 60%; vertical-align: bottom;">
                <div style="font-size: 9px; color: #64748b;">
                    Terima kasih atas kepercayaannya mendampingi pendidikan ananda di {{ $bimbelName }}.
                </div>
            </td>
            <td style="width: 40%; text-align: center;">
                <div style="font-size: 9.5px; color: #475569;">Cibinong, {{ $invoice->paid_at ? $invoice->paid_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}</div>
                <div style="font-size: 9.5px; font-weight: bold; color: #0F2C59; margin-top: 2px;">Admin Keuangan {{ $bimbelName }}</div>
                <div style="height: 36px; line-height: 36px; font-size: 10.5px; font-style: italic; color: #0D9488; font-weight: bold;">
                    [ Terverifikasi Sistem ]
                </div>
                <div style="font-weight: bold; font-size: 9.5px; color: #0F2C59; border-top: 1px solid #cbd5e1; padding-top: 2px; width: 80%; margin: 0 auto;">
                    {{ $ownerName }}
                </div>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        Kwitansi digital ini sah dan diterbitkan otomatis oleh Sistem Akademik {{ $bimbelName }}.
    </div>
</div>

</body>
</html>
