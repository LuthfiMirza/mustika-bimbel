<!-- 5.1 HERO SECTION (Krackerz Neo-Brutalism Style + MustikaBimbel Cream/Gold/Navy) -->
<section id="hero" class="relative bg-cream pt-8 pb-6 sm:pt-12 sm:pb-8 overflow-hidden">
    <!-- Giant Cloud Circles ("Awan" Hero Background) -->
    <div class="pointer-events-none absolute inset-x-0 top-6 flex justify-center overflow-hidden" aria-hidden="true">
        <div class="relative w-[1080px] h-[460px] shrink-0">
            <div class="absolute left-[4%] top-12 w-56 h-56 rounded-full bg-paper border-[2.5px] border-ink/10"></div>
            <div class="absolute left-[18%] top-2 w-72 h-72 rounded-full bg-paper border-[2.5px] border-ink/10"></div>
            <div class="absolute left-[38%] -top-4 w-80 h-80 rounded-full bg-paper border-[2.5px] border-ink/10"></div>
            <div class="absolute right-[16%] top-4 w-[17rem] h-[17rem] rounded-full bg-paper border-[2.5px] border-ink/10"></div>
            <div class="absolute right-[3%] top-16 w-52 h-52 rounded-full bg-paper border-[2.5px] border-ink/10"></div>
            <div class="absolute inset-x-[12%] top-28 bottom-12 bg-paper rounded-full"></div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <!-- Top Sticker Badge -->
        <div class="flex justify-center mb-5">
            <span class="sticker sticker--gold" style="--tilt: -2deg;">
                <i data-lucide="award" class="w-4 h-4"></i>
                <span>BIMBEL JARIMATIKA &amp; MIPA #CIBINONG</span>
            </span>
        </div>

        <!-- Mobile Mascot Above Headline -->
        <div class="flex justify-center mb-2 sm:hidden">
            @include('landing.partials._mascot', ['pose' => 'wave', 'size' => 86])
        </div>

        <!-- Exact string for screen readers & SystemAuditTest -->
        <span class="sr-only">Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya! — Bimbel MIPA untuk Masa Depanmu</span>

        <!-- Giant Mixed Display + Script Headline -->
        <div class="relative inline-block max-w-5xl mx-auto" aria-hidden="true">
            <h1 class="font-display-hero text-[44px] sm:text-[72px] lg:text-[106px] text-ink">
                <span class="block">
                    <span class="relative inline-block">
                        <!-- Desktop Mascot anchored right beside KUAT on line 1 -->
                        <span class="hidden sm:block absolute right-full mr-2.5 lg:mr-3 xl:mr-4 top-1/2 -translate-y-1/2 pointer-events-none z-20">
                            @include('landing.partials._mascot', ['pose' => 'wave', 'size' => 104, 'class' => 'sm:w-[74px] sm:h-[74px] lg:w-[88px] lg:h-[88px] xl:w-[104px] xl:h-[104px]'])
                        </span>
                        KUAT
                    </span>
                    <span class="font-script lowercase font-normal text-[1.08em] text-navy">konsepnya,</span>
                </span>
                <span class="block mt-1">
                    CEPAT <span class="font-script lowercase font-normal text-[1.08em] text-navy">hitungnya,</span>
                </span>
                <span class="block mt-2">
                    TEPAT
                    <span class="sticker-headline sticker-headline--gold text-[0.76em]" style="--tilt: -2.5deg;">
                        JAWABANNYA!
                    </span>
                </span>
            </h1>
        </div>

        <!-- Sub-copy -->
        <p class="mt-7 text-sm sm:text-lg text-slate-700 font-medium leading-relaxed max-w-xl mx-auto">
            Belajar bukan sekadar menghafal rumus. Pahami cara kerjanya, kuasai langkahnya, dan temukan cara menyelesaikan soal dengan lebih efektif.
        </p>

        <!-- Primary & Secondary CTA -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6">
            <a href="#form-trial" class="btn-pop">
                <span class="btn-roll">
                    <span>Klaim Kelas Coba Gratis</span>
                    <span aria-hidden="true">Klaim Kelas Coba Gratis</span>
                </span>
                <span class="btn-pop__dot"><i data-lucide="arrow-right" class="w-4 h-4"></i></span>
            </a>

            <a href="#tantangan-30-detik"
               class="inline-flex items-center gap-1.5 font-label text-sm font-bold uppercase tracking-wide text-ink underline decoration-[3px] decoration-tomato underline-offset-4 hover:text-tomato transition-colors">
                <span>Tes Hitung 30 Detik</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <!-- Row of 6 Fanned Photo Cards: kipas miring, merenggang & tegak saat di-scroll (ala Krackerz) -->
        {{-- Slot foto: taruh hero-1.jpg … hero-6.jpg (potret ±3:4) di public/images/landing/. Tanpa foto, tampil maskot. --}}
        @php
            $img = fn($f) => file_exists(public_path("images/landing/$f")) ? asset("images/landing/$f") : null;
            $heroCards = [
                ['text' => 'Belum hafal perkalian', 'icon' => 'x', 'a' => '-6deg', 'dy' => '0px', 'bg' => 'bg-lime/50', 'pose' => 'think', 'photo' => 'hero-1.jpg'],
                ['text' => 'Lambat menghitung', 'icon' => 'timer', 'a' => '-4deg', 'dy' => '6px', 'bg' => 'bg-gold/50', 'pose' => 'wow', 'photo' => 'hero-2.jpg'],
                ['text' => 'Takut soal cerita', 'icon' => 'book-open', 'a' => '-2deg', 'dy' => '10px', 'bg' => 'bg-sky-100', 'pose' => 'think', 'photo' => 'hero-3.jpg'],
                ['text' => 'Bingung rumus Fisika', 'icon' => 'atom', 'a' => '2deg', 'dy' => '10px', 'bg' => 'bg-rose-100', 'pose' => 'wow', 'photo' => 'hero-4.jpg'],
                ['text' => 'Nilai MIPA turun', 'icon' => 'trending-down', 'a' => '4deg', 'dy' => '6px', 'bg' => 'bg-teal-100', 'pose' => 'thumbs', 'photo' => 'hero-5.jpg'],
                ['text' => 'Panik saat ujian', 'icon' => 'alarm-clock', 'a' => '6deg', 'dy' => '0px', 'bg' => 'bg-amber-100', 'pose' => 'wave', 'photo' => 'hero-6.jpg'],
            ];
        @endphp

        <div class="mt-12 -mx-4 px-4 sm:mx-0 sm:px-0">
            <div class="hero-fan flex items-stretch gap-3 overflow-x-auto snap-x snap-mandatory pt-6 pb-8 no-scrollbar" data-hero-fan>
                @foreach ($heroCards as $idx => $hc)
                    @php $photo = $img($hc['photo']); @endphp
                    <div class="hero-fan__item reveal shrink-0 snap-center relative hover:z-20"
                         x-intersect.once="$el.classList.add('is-in')"
                         style="transition-delay: {{ $idx * 60 }}ms;">
                        <div class="hero-fan__tilt" style="--k: {{ $idx - 2.5 }}; --a: {{ $hc['a'] }}; --dy: {{ $hc['dy'] }};">
                            <div class="card-bite w-[166px] h-[226px] lg:w-[var(--cw)] lg:h-[calc(var(--cw)*1.38)] flex flex-col justify-between" style="--r: 0deg;">
                                <div class="relative flex-1 flex items-center justify-center overflow-hidden {{ $photo ? 'bg-ink' : $hc['bg'] }}">
                                    @if ($photo)
                                        <img src="{{ $photo }}" alt="{{ $hc['text'] }}" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                                    @else
                                        @include('landing.partials._mascot', ['pose' => $hc['pose'], 'size' => 92, 'animate' => false])
                                        <span class="absolute top-2.5 right-2.5 w-9 h-9 rounded-xl bg-paper border-2 border-ink shadow-[2px_2px_0_#111] flex items-center justify-center text-ink rotate-6">
                                            <i data-lucide="{{ $hc['icon'] }}" class="w-4 h-4"></i>
                                        </span>
                                    @endif
                                </div>
                                <div class="card-bite__foot {{ $idx % 2 === 0 ? 'card-bite__foot--paper' : '' }} px-3 py-4 text-center">
                                    <span class="font-label text-xs font-bold uppercase tracking-wide leading-snug block {{ $idx % 2 === 0 ? 'text-ink' : 'text-paper' }}">
                                        {{ $hc['text'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 3 Tilted Trust Stickers -->
        <div class="mt-6 flex flex-wrap items-center justify-center gap-3 sm:gap-5">
            <span class="sticker sticker--paper" style="--tilt: -2deg;">
                <i data-lucide="graduation-cap" class="w-4 h-4 text-navy"></i>
                <span>TK – SMP</span>
            </span>
            <span class="sticker sticker--lime" style="--tilt: 1.5deg;">
                <i data-lucide="users" class="w-4 h-4 text-ink"></i>
                <span>Maks 10 Siswa/Sesi</span>
            </span>
            <span class="sticker sticker--paper" style="--tilt: -1.5deg;">
                <i data-lucide="message-circle-check" class="w-4 h-4 text-edu-teal"></i>
                <span>E-Raport via WA</span>
            </span>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Kartu hero: kipas miring (--p = 0) → merenggang & tegak (--p = 1) mengikuti scroll, hanya di layar lg+.
    (() => {
        const row = document.querySelector('[data-hero-fan]');
        if (!row) return;
        const desktop = window.matchMedia('(min-width: 1024px)');
        const reduce = window.matchMedia('(prefers-reduced-motion: reduce)');
        let ticking = false;
        const update = () => {
            ticking = false;
            if (!desktop.matches || reduce.matches) { row.style.setProperty('--p', 0); return; }
            const top = row.getBoundingClientRect().top + window.scrollY;
            const from = top * 0.1, to = top * 0.8;
            const p = Math.min(1, Math.max(0, (window.scrollY - from) / Math.max(1, to - from)));
            row.style.setProperty('--p', p.toFixed(3));
        };
        const onScroll = () => { if (!ticking) { ticking = true; requestAnimationFrame(update); } };
        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onScroll);
        update();
    })();
</script>
@endpush
