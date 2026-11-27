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
                    'tab' => 'Konsep Dasar',
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
                    'tab' => 'Hitung Cepat',
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
                    'tab' => 'Latihan &amp; Laporan',
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

        <!-- 3 Stacked Navy Folders (ala Krackerz): semua sticky di top yang sama, tab bergeser ke kanan
             supaya tab folder sebelumnya tetap kelihatan saat folder berikutnya menumpuk di atasnya. -->
        @php
            $folderTones = ['#1A3F7A', '#0F2C59', '#091C3A'];
        @endphp
        <div class="folder-stack space-y-10 lg:space-y-28">
            @foreach ($pillars as $idx => $pilar)
                @php $pilarPhoto = $img($pilar['photo']); @endphp
                <article class="folder" style="--folder: {{ $folderTones[$idx] }}; --tab-x: {{ $idx }};">
                    <!-- Folder Tab -->
                    <div class="folder__tabrow">
                        <div class="folder__tab {{ $idx === 0 ? 'folder__tab--first' : '' }}">
                            {{-- Tab kiri: sisi kiri lurus menyatu dengan sudut folder --}}
                            <svg class="folder__tabshape {{ $idx > 0 ? 'lg:hidden' : '' }}" viewBox="0 0 260 53" preserveAspectRatio="none" aria-hidden="true">
                                <path d="M0 53V24C0 10.7 10.7 0 24 0H206C214.5 0 219.6 4.6 222.6 11.6L235 40C238.4 47.6 244.5 52 253 52H260V53Z"/>
                            </svg>
                            @if ($idx > 0)
                                {{-- Tab tengah: kedua sisi miring dengan lengkung cekung di kaki --}}
                                <svg class="folder__tabshape hidden lg:block" viewBox="0 0 260 53" preserveAspectRatio="none" aria-hidden="true">
                                    <path d="M0 53V52H7C15.5 52 21.6 47.6 25 40L37.4 11.6C40.4 4.6 45.5 0 54 0H206C214.5 0 219.6 4.6 222.6 11.6L235 40C238.4 47.6 244.5 52 253 52H260V53Z"/>
                                </svg>
                            @endif
                            <span class="folder__tablabel">
                                <i data-lucide="{{ $pilar['icon'] }}" class="w-4 h-4 text-gold"></i>
                                <span>{!! $pilar['tab'] !!}</span>
                            </span>
                        </div>
                    </div>

                    <!-- Folder Body -->
                    <div class="folder__body rounded-tl-none {{ $idx > 0 ? 'lg:rounded-tl-[26px]' : '' }}">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 h-full">
                            <!-- Text & Bullets -->
                            <div class="lg:col-span-6 flex flex-col">
                                <div class="flex flex-wrap items-center gap-2.5 mb-4">
                                    <span class="font-label text-xs font-bold uppercase tracking-[0.18em] text-gold">{{ $pilar['code'] }}</span>
                                    @if ($pilar['badge'])
                                        <span class="sticker sticker--lime" style="--tilt: -2deg;">★ {{ $pilar['badge'] }}</span>
                                    @endif
                                </div>

                                <h3 class="font-display text-[34px] sm:text-5xl xl:text-[54px] text-paper leading-[1.02] uppercase">
                                    {{ $pilar['title'] }}
                                </h3>

                                <ul class="mt-7 space-y-3.5">
                                    @foreach ($pilar['points'] as $pt)
                                        <li class="flex items-start gap-3 text-base sm:text-lg text-paper/90 font-medium leading-snug">
                                            <span class="text-gold font-display text-lg leading-none mt-1 shrink-0" aria-hidden="true">✱</span>
                                            <span>{!! $pt !!}</span>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="mt-8 lg:mt-auto pt-2 flex flex-wrap items-center gap-3">
                                    <a href="#form-trial" class="btn-pop">
                                        <span class="btn-roll">
                                            <span>{{ $pilar['cta'] }}</span>
                                            <span aria-hidden="true">{{ $pilar['cta'] }}</span>
                                        </span>
                                        <span class="btn-pop__dot"><i data-lucide="arrow-right" class="w-4 h-4"></i></span>
                                    </a>

                                    @if ($pilar['showRaportBtn'])
                                        <button type="button" @click="reportModalOpen = true"
                                                class="inline-flex items-center gap-1.5 px-4 py-3 rounded-full border-2 border-ink bg-lime hover:bg-gold font-label text-xs font-bold uppercase text-ink shadow-[3px_3px_0_#111] transition-all">
                                            <i data-lucide="file-bar-chart-2" class="w-4 h-4"></i>
                                            <span>Lihat Contoh E-Raport</span>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Visual: foto berbingkai putih (atau maskot bila foto belum ada) -->
                            <div class="lg:col-span-6 relative">
                                <div class="absolute -left-5 sm:-left-8 top-1/2 -translate-y-1/2 z-20 -rotate-6">
                                    @include('landing.partials._badge-flower', ['tone' => $pilar['flowerTone'], 'icon' => $pilar['flowerIcon'], 'size' => 76])
                                </div>
                                <div class="h-[280px] sm:h-[360px] lg:h-full lg:min-h-[440px] rounded-[18px] bg-paper p-2 sm:p-2.5">
                                    @if ($pilarPhoto)
                                        <img src="{{ $pilarPhoto }}" alt="{{ $pilar['alt'] }}" loading="lazy"
                                             class="w-full h-full object-cover rounded-[12px]">
                                    @else
                                        <div class="w-full h-full rounded-[12px] {{ $pilar['accentBg'] }} border-2 border-ink/10 flex flex-col items-center justify-center p-6">
                                            @include('landing.partials._mascot', ['pose' => $pilar['pose'], 'size' => 150])
                                            <div class="mt-4 flex flex-wrap items-center justify-center gap-2.5">
                                                @foreach ($pilar['stickers'] as $st)
                                                    <span class="sticker {{ $st['tone'] }}" style="--tilt: {{ $st['tilt'] }};">{{ $st['text'] }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Folder menumpuk di semua layar: top sticky = di bawah header bila folder muat di layar,
    // atau (layar - tinggi folder) bila folder lebih tinggi dari layar, supaya bagian bawahnya tetap terbaca.
    (() => {
        const stack = document.querySelector('.folder-stack');
        if (!stack) return;
        const folders = [...stack.querySelectorAll('.folder')];
        const header = document.querySelector('header');
        let raf = 0;
        const layout = () => {
            raf = 0;
            const headerH = header ? header.offsetHeight : 72;
            const vh = window.innerHeight;
            const gap = vh < 700 ? 12 : 24;
            folders.forEach((f) => {
                const h = f.offsetHeight;
                const stick = Math.min(headerH + gap, vh - h - gap);
                f.style.setProperty('--stick', Math.round(stick) + 'px');
            });
            stack.classList.add('is-stacking');
        };
        const queue = () => { if (!raf) raf = requestAnimationFrame(layout); };
        window.addEventListener('resize', queue);
        if ('ResizeObserver' in window) {
            const ro = new ResizeObserver(queue);
            folders.forEach((f) => ro.observe(f));
        }
        layout();
    })();
</script>
@endpush
