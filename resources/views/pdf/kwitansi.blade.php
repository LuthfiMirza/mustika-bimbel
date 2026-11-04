<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi Pembayaran SPP - {{ $invoice->invoice_number }}</title>
    <style>
        @page {
            margin: 30px 35px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.5;
        }
        .receipt-box {
            border: 2px solid #0F2C59;
            border-radius: 8px;
            padding: 24px;
            position: relative;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #0F2C59;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }
        .brand-title {
            font-size: 20px;
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
            font-size: 11px;
            font-weight: bold;
            border-radius: 4px;
            display: inline-block;
        }
        .receipt-title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            color: #0F2C59;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        .data-table td {
            padding: 6px 4px;
            vertical-align: top;
            font-size: 11px;
        }
        .lbl {
            width: 25%;
            font-weight: bold;
            color: #475569;
        }
        .col {
            width: 3%;
            text-align: center;
        }
        .val {
            width: 72%;
            font-weight: bold;
            color: #0F2C59;
        }
        .amount-box {
            background-color: #f8fafc;
            border: 2px dashed #0D9488;
            padding: 12px 16px;
            border-radius: 6px;
            margin: 14px 0;
            font-size: 16px;
            font-weight: bold;
            color: #0F2C59;
        }
        .stamp-lunas {
            border: 2px solid #059669;
            color: #059669;
            font-size: 14px;
            font-weight: bold;
            padding: 4px 12px;
            display: inline-block;
            border-radius: 6px;
            letter-spacing: 1.5px;
            transform: rotate(-5deg);
        }
        .sign-table {
            width: 100%;
            margin-top: 24px;
            border-collapse: collapse;
        }
        .footer-note {
            font-size: 9px;
            color: #64748b;
            text-align: center;
            border-top: 1px dotted #cbd5e1;
            padding-top: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="receipt-box">
    <!-- Header Instansi -->
    <table class="header-table">
        <tr>
            <td style="width: 65%;">
                <h1 class="brand-title">Mustika<span style="color: #eab308;">Bimbel</span></h1>
                <div class="brand-sub">Bimbel MIPA untuk Masa Depanmu &bull; Cibinong</div>
                <div class="brand-address">
                    Perumahan Amarylis Garden, Jl. H Abdul Gani II Blok I No. 11, Harapan Jaya, Cibinong<br>
                    WhatsApp: 087705555190 &bull; "Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!"
                </div>
            </td>
            <td style="width: 35%; text-align: right;">
                <div class="receipt-badge">KWITANSI RESMI</div>
                <div style="font-size: 9.5px; font-weight: bold; color: #0F2C59; margin-top: 6px;">
                    No: {{ $invoice->invoice_number }}
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
            <td class="val">Biaya Belajar (SPP) Periode <u>{{ $invoice->billing_period }}</u></td>
        </tr>
        <tr>
            <td class="lbl">Metode Pembayaran</td>
            <td class="col">:</td>
            <td class="val">{{ $invoice->payment_method ?? 'Transfer Bank / QRIS' }}</td>
        </tr>
        <tr>
            <td class="lbl">Keterangan / Catatan</td>
            <td class="col">:</td>
            <td class="val" style="font-weight: normal; font-style: italic; color: #475569;">
                {{ $invoice->notes ?? 'Pembayaran SPP terverifikasi lunas.' }}
            </td>
        </tr>
    </table>

    <!-- Kotak Jumlah Nominal & Status Lunas -->
    <table style="width: 100%; margin: 10px 0;">
        <tr>
            <td style="width: 65%;">
                <div class="amount-box">
                    Jumlah: Rp {{ number_format($invoice->amount, 0, ',', '.') }},-
                </div>
            </td>
            <td style="width: 35%; text-align: center; vertical-align: middle;">
                <div class="stamp-lunas">
                    ✓ LUNAS
                </div>
            </td>
        </tr>
    </table>

    <!-- Tanda Tangan Kasir / Pengelola -->
    <table class="sign-table">
        <tr>
            <td style="width: 60%; vertical-align: bottom;">
                <div style="font-size: 9.5px; color: #64748b;">
                    Terima kasih atas kepercayaannya mendampingi pendidikan ananda di MustikaBimbel Cibinong.
                </div>
            </td>
            <td style="width: 40%; text-align: center;">
                <div style="font-size: 10px; color: #475569;">Cibinong, {{ $invoice->paid_at ? $invoice->paid_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}</div>
                <div style="font-size: 10px; font-weight: bold; color: #0F2C59; margin-top: 2px;">Admin Keuangan MustikaBimbel</div>
                <div style="height: 44px; line-height: 44px; font-size: 11px; font-style: italic; color: #0D9488; font-weight: bold;">
                    [ Terverifikasi Sistem ]
                </div>
                <div style="font-weight: bold; font-size: 10px; color: #0F2C59; border-top: 1px solid #cbd5e1; padding-top: 2px; width: 80%; margin: 0 auto;">
                    Bendahara MustikaBimbel
                </div>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        Kwitansi digital ini sah dan diterbitkan otomatis oleh Sistem Akademik MustikaBimbel Cibinong.
    </div>
</div>

</body>
</html>
