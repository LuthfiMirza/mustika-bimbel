<!-- 5.14 BIG CLOSING CTA (big-cta.blade.php) -->
<section class="py-16 sm:py-24 bg-gold bg-dots scallop-top relative overflow-hidden" style="--scallop: #FACC15;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-4">
            @include('landing.partials._mascot', ['pose' => 'wow', 'size' => 112])
        </div>

        <h2 class="font-display-hero text-[40px] sm:text-[64px] lg:text-[92px] text-ink leading-[0.95]">
            <span class="block">SIAP JADI</span>
            <span class="block mt-2">
                JAGOAN
                <span class="sticker-headline text-[0.82em] mx-1" style="--tilt: -3deg;">MIPA?</span>
            </span>
        </h2>

        <p class="mt-5 text-sm sm:text-lg font-bold text-ink/85 max-w-xl mx-auto">
            Ambil sesi Kelas Coba Gratis sekarang dan rasakan sendiri cara belajar yang lebih paham konsep dan cepat menghitung!
        </p>

        <div class="mt-8">
            <a href="#form-trial" class="btn-pop btn-pop--ink">
                <span class="btn-roll">
                    <span>Klaim Kelas Coba Gratis</span>
                    <span aria-hidden="true">Klaim Kelas Coba Gratis</span>
                </span>
                <span class="btn-pop__dot"><i data-lucide="arrow-right" class="w-4 h-4"></i></span>
            </a>
        </div>
    </div>
</section>
