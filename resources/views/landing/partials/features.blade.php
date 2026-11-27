<!-- 5.4 CORE FEATURES (#keunggulan) — 3 Stacked Navy Folders -->
<section id="keunggulan" class="py-16 sm:py-24 bg-paper bg-dots scallop-top" style="--scallop: #FFFDF7;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-4xl mx-auto mb-14 reveal" x-intersect.once="$el.classList.add('is-in')">
            <span class="sticker sticker--tomato mb-4" style="--tilt: -2deg;">
                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                <span>TIGA PILAR BELAJAR</span>
            </span>
            <h2 class="font-display-hero text-[36px] sm:text-[56px] lg:text-[78px] text-ink">
                <span class="block">CARA KAMI BIKIN</span>
                <span class="block mt-2">
                    <span class="sticker-headline text-[0.82em]" style="--tilt: -2deg;">MIPA</span>
                    JADI GAMPANG
                </span>
            </h2>
            <p class="mt-5 text-sm sm:text-base text-slate-600 max-w-2xl mx-auto">
                Kami membangun fondasi berpikir logis dan ketangkasan berhitung agar anak tidak lagi takut menghadapi pelajaran Matematika &amp; IPA di sekolah.
            </p>
        </div>

        @php
            $img = fn($f) => file_exists(public_path("images/landing/$f")) ? asset("images/landing/$f") : null;
            $pillars = [
                [
                    'code' => 'PILAR 01',
                    'title' => 'KONSEP DASAR KUAT',
                    'badge' => null,
                    'icon' => 'lightbulb',
                    'flowerTone' => 'gold',
                    'flowerIcon' => 'brain',
                    'photo' => 'pilar-1.jpg',
                    'alt' => 'Siswa MustikaBimbel belajar memahami konsep dasar Matematika secara visual',
                    'pose' => 'think',
                    'stickers' => [
                        ['text' => 'Paham Konsep', 'tone' => 'sticker--paper', 'tilt' => '-4deg'],
                        ['text' => 'Anti Lupa Rumus', 'tone' => 'sticker--lime', 'tilt' => '3deg'],
                        ['text' => 'Logika Dasar', 'tone' => 'sticker--gold', 'tilt' => '-2deg'],
                    ],
                    'points' => [
                        'Paham alasan di balik rumus, bukan sekadar menghafal buta',
                        'Tidak mudah lupa saat variasi soal ujian diubah guru',
                        'Belajar dari fondasi paling dasar sampai benar-benar mengerti',
                    ],
                    'cta' => 'Mulai Bangun Konsep',
                    'showRaportBtn' => false,
                    'accentBg' => 'bg-cream',
                ],
                [
                    'code' => 'PILAR 02',
                    'title' => 'HITUNG CEPAT',
                    'badge' => 'FAVORIT SISWA',
                    'icon' => 'zap',
                    'flowerTone' => 'lime',
                    'flowerIcon' => 'hand',
                    'photo' => 'pilar-2.jpg',
                    'alt' => 'Siswa TK dan SD berlatih metode Jarimatika hitung cepat di MustikaBimbel',
                    'pose' => 'thumbs',
                    'stickers' => [
                        ['text' => '8 × 7 = 56', 'tone' => 'sticker--gold', 'tilt' => '-5deg'],
                        ['text' => 'Jarimatika', 'tone' => 'sticker--paper', 'tilt' => '4deg'],
                        ['text' => '3 Detik!', 'tone' => 'sticker--tomato', 'tilt' => '-2deg'],
                    ],
                    'points' => [
                        'Metode Jarimatika praktis untuk siswa TK &amp; SD',
                        'Trik penyederhanaan angka &amp; aljabar cepat untuk SMP',
                        'Terampil berhitung cepat tanpa sempoa atau kalkulator',
                    ],
                    'cta' => 'Coba Trik Hitung Cepat',
                    'showRaportBtn' => false,
                    'accentBg' => 'bg-lime/25',
                ],
                [
                    'code' => 'PILAR 03',
                    'title' => 'LATIHAN BERTAHAP + LAPORAN ORANG TUA',
                    'badge' => null,
                    'icon' => 'book-open-check',
                    'flowerTone' => 'gold',
                    'flowerIcon' => 'file-bar-chart-2',
                    'photo' => 'pilar-3.jpg',
                    'alt' => 'Pendampingan latihan soal MIPA bertahap dan laporan E-Raport untuk orang tua',
                    'pose' => 'wow',
                    'stickers' => [
                        ['text' => 'E = mc²', 'tone' => 'sticker--ink', 'tilt' => '-4deg'],
                        ['text' => '✓ E-Raport', 'tone' => 'sticker--lime', 'tilt' => '3deg'],
                        ['text' => 'Notif WA', 'tone' => 'sticker--paper', 'tilt' => '-2deg'],
                    ],
                    'points' => [
                        'Matematika, Fisika, Kimia, dan Biologi terstruktur',
                        'Latihan bertahap dari soal dasar hingga soal ujian &amp; seleksi SMA',
                        'Notifikasi WA saat anak tiba &amp; E-Raport digital tiap pertemuan',
                    ],
                    'cta' => 'Klaim Kelas Coba Gratis',
                    'showRaportBtn' => true,
                    'accentBg' => 'bg-gold/20',
                ],
            ];
        @endphp

        <!-- 3 Stacked Navy Folders -->
        <div class="space-y-10">
            @foreach ($pillars as $idx => $pilar)
                <div class="lg:sticky reveal"
                     x-intersect.once="$el.classList.add('is-in')"
                     style="top: {{ 88 + ($idx * 20) }}px; transition-delay: {{ $idx * 80 }}ms;">
                    <!-- Folder Tab -->
                    <div class="inline-flex items-center gap-2 px-5 py-2 rounded-t-2xl bg-navy text-gold border-t-[3px] border-x-[3px] border-ink ml-6 relative z-10 -mb-[3px]">
                        <i data-lucide="{{ $pilar['icon'] }}" class="w-4 h-4"></i>
                        <span class="font-label text-xs font-bold uppercase tracking-wider">{{ $pilar['code'] }}</span>
                    </div>

                    <!-- Folder Body -->
                    <div class="bg-navy rounded-[28px] border-[3px] border-ink hard-shadow-lg p-3 sm:p-4">
                        <div class="bg-paper rounded-[20px] border-2 border-ink p-6 sm:p-8 lg:p-10">
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                                <!-- Visual (on top for mobile, right for desktop) -->
                                <div class="lg:col-span-5 lg:order-2">
                                    @php $pilarPhoto = $img($pilar['photo']); @endphp
                                    <div class="relative rounded-2xl border-2 border-ink {{ $pilar['accentBg'] }} {{ $pilarPhoto ? 'p-3' : 'p-6 sm:p-8' }} flex flex-col items-center justify-center min-h-[225px]">
                                        <div class="absolute -top-4 -right-4 z-20">
                                            @include('landing.partials._badge-flower', ['tone' => $pilar['flowerTone'], 'icon' => $pilar['flowerIcon'], 'size' => 62])
                                        </div>

                                        @if ($pilarPhoto)
                                            <img src="{{ $pilarPhoto }}"
                                                 alt="{{ $pilar['alt'] }}"
                                                 loading="lazy"
                                                 class="w-full h-56 sm:h-64 object-cover rounded-[20px] border-[3px] border-ink hard-shadow -rotate-2">
                                        @else
                                            <div class="relative flex flex-col items-center justify-center py-2">
                                                @include('landing.partials._mascot', ['pose' => $pilar['pose'], 'size' => 118])
                                                <div class="mt-3 flex flex-wrap items-center justify-center gap-2">
                                                    @foreach ($pilar['stickers'] as $st)
                                                        <span class="sticker {{ $st['tone'] }}" style="--tilt: {{ $st['tilt'] }};">
                                                            {{ $st['text'] }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Text & Bullets -->
                                <div class="lg:col-span-7 lg:order-1 space-y-5">
                                    <div class="flex flex-wrap items-center gap-2.5">
                                        <span class="font-label text-xs font-bold uppercase tracking-wider text-tomato">{{ $pilar['code'] }}</span>
                                        @if ($pilar['badge'])
                                            <span class="sticker sticker--lime" style="--tilt: -2deg;">
                                                ★ {{ $pilar['badge'] }}
                                            </span>
                                        @endif
                                    </div>

                                    <h3 class="font-display text-2xl sm:text-4xl text-ink leading-tight">
                                        {{ $pilar['title'] }}
                                    </h3>

                                    <ul class="space-y-3">
                                        @foreach ($pilar['points'] as $pt)
                                            <li class="flex items-start gap-3 text-sm sm:text-base text-slate-700 font-medium">
                                                <span class="w-6 h-6 rounded-lg bg-gold border-2 border-ink flex items-center justify-center shrink-0 mt-0.5">
                                                    <i data-lucide="star" class="w-3.5 h-3.5 text-ink fill-current"></i>
                                                </span>
                                                <span>{!! $pt !!}</span>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="pt-2 flex flex-wrap items-center gap-3">
                                        <a href="#form-trial" class="btn-pop btn-pop--sm">
                                            <span class="btn-roll">
                                                <span>{{ $pilar['cta'] }}</span>
                                                <span aria-hidden="true">{{ $pilar['cta'] }}</span>
                                            </span>
                                            <span class="btn-pop__dot"><i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></span>
                                        </a>

                                        @if ($pilar['showRaportBtn'])
                                            <button type="button" @click="reportModalOpen = true"
                                                    class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full border-2 border-ink bg-lime hover:bg-gold font-label text-xs font-bold uppercase text-ink shadow-[3px_3px_0_#111] transition-all">
                                                <i data-lucide="file-bar-chart-2" class="w-4 h-4"></i>
                                                <span>Lihat Contoh E-Raport</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
