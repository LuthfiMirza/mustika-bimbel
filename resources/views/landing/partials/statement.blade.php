<!-- 5.2 STATEMENT SECTION ("SEKOLAH NGEJAR MATERI / KAMI NGAJARIN CARANYA") -->
<section class="pt-8 pb-16 sm:pt-10 sm:pb-20 bg-cream relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Giant 2-Line Mixed Headline -->
        <div class="text-center max-w-5xl mx-auto mb-8 sm:mb-10 reveal" x-intersect.once="$el.classList.add('is-in')">
            <h2 class="font-display-hero text-[36px] sm:text-[58px] lg:text-[82px] text-ink">
                <span class="block">SEKOLAH NGEJAR MATERI</span>
                <span class="block mt-2">
                    KAMI NGAJARIN
                    <span class="sticker-headline text-[0.82em]" style="--tilt: -3deg;">CARANYA</span>
                </span>
            </h2>
        </div>

        <!-- Poster Panel + Overlapping Pain-Point Duo -->
        <div class="relative max-w-5xl mx-auto pb-8 lg:pb-16">
            @php
                $hasStatementPhoto = file_exists(public_path('images/landing/statement.jpg'));
            @endphp

            <div class="relative rounded-[28px] border-[3px] border-ink hard-shadow-lg overflow-hidden min-h-[340px] sm:min-h-[400px] flex items-center justify-center p-6 sm:p-10 {{ $hasStatementPhoto ? 'bg-ink' : 'bg-navy bg-dots-light' }}">
                @if ($hasStatementPhoto)
                    <img src="{{ asset('images/landing/statement.jpg') }}"
                         alt="Suasana belajar MustikaBimbel"
                         loading="lazy"
                         class="absolute inset-0 w-full h-full object-cover opacity-55">
                @endif

                {{-- TODO: opsional taruh foto kegiatan belajar asli di public/images/landing/statement.jpg --}}
                <!-- Inner Yellow Poster Card -->
                <div class="relative z-10 bg-gold border-[3px] border-ink rounded-[22px] hard-shadow p-6 sm:p-8 max-w-lg w-full text-center">
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <div class="shrink-0">
                            @include('landing.partials._mascot', ['pose' => 'thumbs', 'size' => 96])
                        </div>
                        <div class="text-center sm:text-left">
                            <span class="sticker sticker--paper mb-2" style="--tilt: -2deg;">
                                <i data-lucide="timer" class="w-3.5 h-3.5 text-tomato"></i>
                                <span>DIAGNOSA KILAT</span>
                            </span>
                            <h3 class="font-display text-2xl sm:text-3xl text-ink leading-none">
                                PUNYA 30 DETIK?
                            </h3>
                            <p class="font-script text-2xl text-navy mt-1">
                                coba tes hitung cepat anak sekarang
                            </p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="#tantangan-30-detik" class="btn-pop btn-pop--ink">
                            <span class="btn-roll">
                                <span>Coba Tantangan 30 Detik</span>
                                <span aria-hidden="true">Coba Tantangan 30 Detik</span>
                            </span>
                            <span class="btn-pop__dot"><i data-lucide="zap" class="w-4 h-4"></i></span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pain-Point Duo Overlapping Bottom Corners -->
            <div class="mt-6 lg:mt-0 grid grid-cols-1 sm:grid-cols-2 gap-4 lg:block">
                <div class="lg:absolute lg:-bottom-2 lg:-left-6 lg:w-80 bg-tomato text-white rounded-2xl border-[3px] border-ink hard-shadow p-5 lg:rotate-[-5deg] z-20">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-ink text-gold font-label text-[10px] font-bold uppercase mb-2">
                        FAKTA DI KELAS
                    </div>
                    <h4 class="font-display text-lg leading-tight">SEKOLAH NGGAK MENUNGGU</h4>
                    <p class="text-xs sm:text-sm text-white/95 mt-1.5 leading-relaxed">
                        Materi sekolah jalan terus. Anak yang belum paham konsep dasar makin tertinggal tiap bab.
                    </p>
                </div>

                <div class="lg:absolute lg:-bottom-2 lg:-right-6 lg:w-80 bg-tomato text-white rounded-2xl border-[3px] border-ink hard-shadow p-5 lg:rotate-[5deg] z-20">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-ink text-lime font-label text-[10px] font-bold uppercase mb-2">
                        AKAR MASALAH
                    </div>
                    <h4 class="font-display text-lg leading-tight">HAFALAN CEPAT LUPA</h4>
                    <p class="text-xs sm:text-sm text-white/95 mt-1.5 leading-relaxed">
                        Rumus yang cuma dihafal hilang saat soal divariasikan. Anak butuh paham cara kerjanya.
                    </p>
                </div>
            </div>
        </div>

        <!-- Bottom CTA -->
        <div class="mt-10 text-center">
            <a href="#form-trial" class="btn-pop">
                <span class="btn-roll">
                    <span>Daftar Coba Gratis Sekarang</span>
                    <span aria-hidden="true">Daftar Coba Gratis Sekarang</span>
                </span>
                <span class="btn-pop__dot"><i data-lucide="arrow-right" class="w-4 h-4"></i></span>
            </a>
        </div>
    </div>
</section>
