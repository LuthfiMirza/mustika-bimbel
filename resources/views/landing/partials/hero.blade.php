<!-- 5.1 HERO SECTION (Krackerz Neo-Brutalism Style + MustikaBimbel Cream/Gold/Navy) -->
<section id="hero" class="relative bg-cream bg-dots pt-8 pb-16 sm:pt-12 sm:pb-24 overflow-hidden">
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
                        <span class="hidden sm:block absolute right-full mr-3 lg:mr-4 top-1/2 -translate-y-1/2 pointer-events-none z-20">
                            @include('landing.partials._mascot', ['pose' => 'wave', 'size' => 104, 'class' => 'sm:w-[74px] sm:h-[74px] lg:w-[104px] lg:h-[104px]'])
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

        <!-- Row of 6 Scalloped Biscuit Cards ("card-bite") -->
        @php
            $heroCards = [
                ['text' => 'Belum hafal perkalian', 'icon' => 'x', 'r' => '-3.5deg', 'bg' => 'bg-lime/40'],
                ['text' => 'Lambat menghitung', 'icon' => 'timer', 'r' => '2.5deg', 'bg' => 'bg-gold/40'],
                ['text' => 'Takut soal cerita', 'icon' => 'book-open', 'r' => '-2deg', 'bg' => 'bg-sky-100'],
                ['text' => 'Bingung rumus Fisika', 'icon' => 'atom', 'r' => '3deg', 'bg' => 'bg-rose-100'],
                ['text' => 'Nilai MIPA turun', 'icon' => 'trending-down', 'r' => '-2.5deg', 'bg' => 'bg-teal-100'],
                ['text' => 'Panik saat ujian', 'icon' => 'alarm-clock', 'r' => '2deg', 'bg' => 'bg-amber-100'],
            ];
        @endphp

        <div class="mt-12 -mx-4 px-4 sm:mx-0 sm:px-0">
            <div class="flex lg:justify-center items-stretch gap-3 lg:gap-0 overflow-x-auto lg:overflow-visible snap-x snap-mandatory py-5 no-scrollbar">
                @foreach ($heroCards as $idx => $hc)
                    <div class="card-bite shrink-0 w-[166px] sm:w-[174px] h-[222px] flex flex-col justify-between snap-center {{ $idx > 0 ? 'lg:-ml-3' : '' }}"
                         style="--r: {{ $hc['r'] }};">
                        <div class="flex-1 flex flex-col items-center justify-center p-4 {{ $hc['bg'] }}">
                            <div class="w-14 h-14 rounded-2xl bg-paper border-2 border-ink shadow-[3px_3px_0_#111] flex items-center justify-center text-ink">
                                <i data-lucide="{{ $hc['icon'] }}" class="w-7 h-7"></i>
                            </div>
                        </div>
                        <div class="card-bite__foot px-3 py-4 text-center">
                            <span class="font-label text-xs font-bold uppercase tracking-wide leading-snug block text-paper">
                                {{ $hc['text'] }}
                            </span>
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
