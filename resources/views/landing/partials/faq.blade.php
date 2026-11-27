<!-- 5.12 FAQ (faq.blade.php) — Accordion Alpine -->
@php
    $scheduleSummary = isset($schedules) && $schedules->count() > 0
        ? $schedules->map(fn($s) => "{$s->days_text} ({$s->start_time}–{$s->end_time} WIB)")->implode(', ')
        : 'Senin–Kamis (18.30–20.00 WIB), Sabtu (16.00–17.30 WIB), dan Minggu (18.30–20.00 WIB)';

    $faqs = [
        [
            'q' => 'Program apa saja yang tersedia di MustikaBimbel?',
            'a' => 'Tersedia tiga jalur utama: Jarimatika & Hitung Cepat (TK–SD), Bimbel MIPA SD (Matematika & IPA Kelas 1–6), serta Bimbel MIPA SMP & Persiapan Ujian (Matematika, Fisika, Kimia, Biologi Kelas 7–9).',
        ],
        [
            'q' => 'Berapa jumlah siswa dalam satu sesi kelas?',
            'a' => 'Setiap sesi dibatasi maksimal 10 siswa agar pengajar dapat mendampingi pemahaman konsep dan kecepatan berhitung tiap anak secara fokus.',
        ],
        [
            'q' => 'Kapan jadwal belajarnya?',
            'a' => 'Jadwal resmi yang tersedia saat ini: ' . $scheduleSummary . '.',
        ],
        [
            'q' => 'Apakah ada kelas coba gratis (Free Trial)?',
            'a' => 'Ya! Pertemuan pertama gratis untuk semua program. Cukup isi formulir Free Trial di halaman ini, lalu admin MustikaBimbel akan langsung mengonfirmasi jadwal kedatangan lewat WhatsApp.',
        ],
        [
            'q' => 'Bagaimana orang tua memantau perkembangan belajar anak?',
            'a' => 'Orang tua menerima notifikasi WhatsApp saat anak tiba serta laporan jurnal pulang setiap pertemuan, dan bisa melihat grafik skor & sertifikat di Portal E-Raport memakai Kode Induk Siswa.',
        ],
        [
            'q' => 'Di mana lokasi ruang belajar MustikaBimbel?',
            'a' => 'Perumahan Amarylis Garden, Jalan H Abdul Gani II Blok I No. 11, Harapan Jaya, Cibinong, Kabupaten Bogor.',
        ],
    ];
@endphp

<section id="faq" class="py-16 sm:py-24 bg-paper bg-dots scallop-top relative overflow-hidden" style="--scallop: #FFFDF7;">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center mb-12 reveal" x-intersect.once="$el.classList.add('is-in')">
            <span class="sticker sticker--gold mb-4" style="--tilt: -2deg;">
                FAQ
            </span>
            <h2 class="font-display-hero text-[36px] sm:text-[54px] lg:text-[72px] text-ink">
                <span class="block">
                    SEBELUM
                    <span class="sticker-headline text-[0.8em]" style="--tilt: -2deg;">MULAI</span>
                </span>
                <span class="block mt-2">BELAJAR</span>
            </h2>
        </div>

        <!-- Alpine Accordion -->
        <div class="space-y-4" x-data="{ open: 0 }">
            @foreach ($faqs as $idx => $faq)
                <div class="bg-paper rounded-[20px] border-[2.5px] border-ink hard-shadow overflow-hidden reveal"
                     x-intersect.once="$el.classList.add('is-in')"
                     style="transition-delay: {{ $idx * 50 }}ms;">
                    <button type="button"
                            @click="open = open === {{ $idx }} ? -1 : {{ $idx }}"
                            class="w-full px-5 sm:px-6 py-4 sm:py-5 flex items-center justify-between gap-4 text-left cursor-pointer hover:bg-cream/60 transition-colors">
                        <span class="font-display text-base sm:text-lg text-ink leading-snug">
                            {{ $faq['q'] }}
                        </span>
                        <span class="w-9 h-9 rounded-full bg-lime border-2 border-ink flex items-center justify-center shrink-0 transition-transform duration-200"
                              :class="open === {{ $idx }} ? 'rotate-180 bg-gold' : ''">
                            <i data-lucide="chevron-down" class="w-5 h-5 text-ink"></i>
                        </span>
                    </button>

                    <div x-show="open === {{ $idx }}" x-collapse x-cloak>
                        <div class="px-5 sm:px-6 pb-5 pt-3 border-t-2 border-dashed border-ink/20 text-sm text-slate-700 leading-relaxed">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
