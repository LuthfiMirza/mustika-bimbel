<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'label',
    ];

    protected const CACHE_KEY = 'mustika_bimbel_settings_map';

    /**
     * Default configuration values for MustikaBimbel.
     *
     * @return array<string, array{value: string, group: string, label: string}>
     */
    public static function defaults(): array
    {
        return [
            'bimbel_name' => [
                'value' => 'MustikaBimbel',
                'group' => 'identity',
                'label' => 'Nama Bimbel',
            ],
            'bimbel_address' => [
                'value' => 'Perumahan Amarylis Garden, Jl. H Abdul Gani II Blok I No. 11, Harapan Jaya, Cibinong',
                'group' => 'identity',
                'label' => 'Alamat Lengkap Bimbel',
            ],
            'owner_name' => [
                'value' => 'Kak Mustika',
                'group' => 'identity',
                'label' => 'Nama Pemilik / Penanggung Jawab',
            ],
            'admin_whatsapp' => [
                'value' => '087705555190',
                'group' => 'identity',
                'label' => 'No. WhatsApp Admin',
            ],
            'payment_info' => [
                'value' => 'Transfer Bank / QRIS MustikaBimbel atau Tunai langsung di lokasi bimbel',
                'group' => 'payment',
                'label' => 'Informasi Rekening / QRIS Pembayaran',
            ],
            'tuition_due_day' => [
                'value' => '10',
                'group' => 'tuition',
                'label' => 'Tanggal Jatuh Tempo SPP (1-28)',
            ],
            'period_start_month' => [
                'value' => '2026-07',
                'group' => 'tuition',
                'label' => 'Bulan Mulai Periode Kartu SPP & Laporan (YYYY-MM)',
            ],
            'wa_template_reminder' => [
                'value' => "Halo Bapak/Ibu *{wali}*, salam hangat dari *{bimbel}* 🙏\n\nIzin menyampaikan informasi SPP bulanan untuk ananda *{siswa}* ({kode_siswa}):\n\n🧾 *No. Tagihan:* {no_tagihan}\n🗓️ *Periode:* {bulan}\n💳 *Nominal SPP:* *{tagihan}*\n💰 *Sisa Tagihan Bulan Ini:* *{sisa}*\n📊 *Total Tunggakan:* {total_tunggakan}\n⏳ *Jatuh Tempo:* {jatuh_tempo}\n📌 *Status:* {status}\n\nPembayaran dapat melalui:\n{pembayaran}\n\nDetail tagihan & kwitansi resmi juga dapat diakses melalui Portal Orang Tua:\n🔗 {link_raport}\n\nMohon abaikan pesan ini bila sudah membayar. Terima kasih banyak atas perhatian dan dukungannya! 🌟",
                'group' => 'whatsapp',
                'label' => 'Template Pesan Pengingat SPP',
            ],
            'wa_template_receipt' => [
                'value' => "Terima kasih Bapak/Ibu *{wali}* 🙏\n\nPembayaran SPP ananda *{siswa}* untuk periode *{bulan}* sebesar *{jumlah}* sudah kami terima pada {tanggal} (No. Kuitansi: *{kuitansi}* via {metode}).\n📌 *Status Tagihan:* {status}\n💰 *Sisa Tagihan:* {sisa}\n\nKwitansi PDF & E-Raport dapat dilihat kapan saja di Portal Orang Tua:\n🔗 {link_raport}\n\nSalam hangat,\n*{bimbel}* | WA {admin}",
                'group' => 'whatsapp',
                'label' => 'Template Pesan Terima Kasih / Kuitansi',
            ],
            'wa_template_arrival' => [
                'value' => "Halo Bapak/Ibu *{wali}* 👋\n\nMenginformasikan bahwa ananda *{siswa}* telah tiba dengan aman di *{bimbel}* pada:\n📅 Tanggal: *{tanggal}*\n⏰ Pukul: *{jam} WIB*\n\nSelamat belajar ananda {panggilan}! *Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!* 🚀",
                'group' => 'whatsapp',
                'label' => 'Template Notifikasi Anak Tiba',
            ],
            'wa_template_report' => [
                'value' => "Halo Bapak/Ibu *{wali}* 🌟\nBerikut rangkuman hasil belajar ananda *{siswa}* hari ini ({tanggal}) di *{bimbel}*:\n\n📚 *Kategori:* {kategori}\n🎯 *Topik Materi:* {topik}\n⚡ *Kecepatan Hitung:* {bintang} ({kecepatan}/5)\n💯 *Skor Latihan Soal:* {skor}/100\n📝 *Catatan Pengajar:* _{catatan}_\n\nLihat Grafik Perkembangan & E-Raport lengkap ananda melalui Portal Orang Tua:\n🔗 {link_raport}\n\nTerima kasih atas kerja samanya! 🙏",
                'group' => 'whatsapp',
                'label' => 'Template Laporan Jurnal Pulang',
            ],
        ];
    }

    /**
     * Get all settings as an associative array merged with defaults.
     *
     * @return array<string, string>
     */
    public static function allMap(): array
    {
        $defaults = array_map(fn(array $item) => $item['value'], self::defaults());

        try {
            if (! Schema::hasTable('settings')) {
                return $defaults;
            }

            $stored = Cache::remember(self::CACHE_KEY, 300, function () {
                return self::query()->pluck('value', 'key')->toArray();
            });

            return array_merge($defaults, array_filter($stored, fn($v) => $v !== null && $v !== ''));
        } catch (\Throwable) {
            return $defaults;
        }
    }

    /**
     * Retrieve a single setting value with fallback to defaults.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $map = self::allMap();

        if (array_key_exists($key, $map)) {
            return $map[$key];
        }

        return $default;
    }

    /**
     * Store or update a single setting value and clear cache.
     */
    public static function set(string $key, ?string $value, ?string $group = null, ?string $label = null): void
    {
        $meta = self::defaults()[$key] ?? ['group' => 'general', 'label' => $key];

        self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group ?? $meta['group'],
                'label' => $label ?? $meta['label'],
            ]
        );

        self::clearCache();
    }

    /**
     * Seed default settings if missing.
     */
    public static function seedDefaults(): void
    {
        foreach (self::defaults() as $key => $meta) {
            self::firstOrCreate(
                ['key' => $key],
                [
                    'value' => $meta['value'],
                    'group' => $meta['group'],
                    'label' => $meta['label'],
                ]
            );
        }

        self::clearCache();
    }

    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
