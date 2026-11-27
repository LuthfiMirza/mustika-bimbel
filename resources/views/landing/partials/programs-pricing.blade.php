<!-- 5.10 PROGRAM & BIAYA (programs-pricing.blade.php) — No Toggle, Exact DB Prices -->
<section id="program-biaya" class="py-16 sm:py-24 bg-cream bg-dots relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center max-w-4xl mx-auto mb-14 reveal" x-intersect.once="$el.classList.add('is-in')">
            <span class="sticker sticker--tomato mb-4" style="--tilt: -2deg;">
                PROGRAM &amp; BIAYA
            </span>
            <h2 class="font-display-hero text-[36px] sm:text-[56px] lg:text-[78px] text-ink">
                <span class="block">PILIH JALAN</span>
                <span class="block mt-2">
                    <span class="sticker-headline sticker-headline--gold text-[0.8em]" style="--tilt: -2deg;">JAGOAN</span>
                    MIPA-MU
                </span>
            </h2>
            <p class="mt-4 text-sm sm:text-base text-slate-700 max-w-xl mx-auto">
                Biaya bulanan transparan sesuai jenjang belajar tanpa biaya tersembunyi.
            </p>
        </div>

        <!-- Pricing Cards from $programs -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
            @foreach ($programs as $idx => $program)
                @php
                    $isMiddle = $idx === 1;
                    $target = strtoupper((string) ($program->target_grade ?? ''));
                    $specificBenefit = str_contains($target, 'TK')
                        ? 'Fokus Jarimatika tambah, kurang, kali & bagi visual'
                        : (str_contains($target, 'SMP')
                            ? 'Pendalaman MIPA (Mat, Fis, Kim, Bio) & persiapan ujian'
                            : 'Matematika & IPA dasar + penguatan soal cerita SD');
                @endphp
                <div class="rounded-[26px] border-[3px] border-ink p-7 flex flex-col justify-between transition-transform duration-200 {{ $isMiddle ? 'bg-gold hard-shadow-lg md:scale-[1.04] relative z-10' : 'bg-paper hard-shadow hover:-translate-y-1' }}">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <span class="sticker {{ $isMiddle ? 'sticker--ink text-gold' : 'sticker--lime' }}" style="--tilt: -2deg;">
                                {{ $program->target_grade ?? $program->category }}
                            </span>
                            <span class="font-label text-xs font-bold uppercase text-slate-600">
                                {{ $program->category ?? 'Reguler' }}
                            </span>
                        </div>

                        <h3 class="font-display text-2xl text-ink leading-snug">
                            {{ $program->name }}
                        </h3>

                        <!-- Monthly Fee directly from DB -->
                        <div class="mt-5 pb-5 border-b-2 border-ink/15 flex flex-wrap items-baseline gap-x-1 gap-y-0.5">
                            <span class="font-label text-sm font-bold text-ink">Rp</span>
                            <span class="font-display text-4xl sm:text-5xl text-ink tracking-tight">
                                {{ number_format($program->monthly_fee, 0, ',', '.') }}
                            </span>
                            <span class="text-xs font-bold text-slate-700 whitespace-nowrap">/bulan</span>
                        </div>

                        <ul class="mt-5 space-y-3 text-xs sm:text-sm text-ink font-medium">
                            <li class="flex items-start gap-2.5">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-navy shrink-0 mt-0.5"></i>
                                <span>{{ $specificBenefit }}</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-navy shrink-0 mt-0.5"></i>
                                <span>Kelas kecil fokus maksimal 10 siswa per sesi</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-navy shrink-0 mt-0.5"></i>
                                <span>E-Raport perkembangan belajar tiap pertemuan</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-navy shrink-0 mt-0.5"></i>
                                <span>Notifikasi WhatsApp saat anak tiba &amp; pulang</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-7 pt-4">
                        <button type="button"
                                @click="selectedProgramId = '{{ $program->id }}'; selectedGrade = '{{ $program->target_grade === 'TK-SD' ? 'TK' : ($program->target_grade ?: 'SD') }}'; document.getElementById('form-trial')?.scrollIntoView({ behavior: 'smooth' });"
                                class="btn-pop {{ $isMiddle ? 'btn-pop--ink' : '' }} w-full">
                            <span class="btn-roll">
                                <span>Pilih Program Ini</span>
                                <span aria-hidden="true">Pilih Program Ini</span>
                            </span>
                            <span class="btn-pop__dot"><i data-lucide="arrow-right" class="w-4 h-4"></i></span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <p class="mt-8 text-center font-label text-xs sm:text-sm font-bold uppercase tracking-wide text-navy">
            ★ Pertemuan pertama GRATIS untuk semua program. ★
        </p>

        <!-- Partner Strip (gaya "PARTNER WITH US") -->
        <div class="mt-12 rounded-[26px] bg-ink border-[3px] border-ink hard-shadow-lg p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <span class="font-label text-xs font-bold uppercase tracking-wider text-lime block mb-1">
                    KOLABORASI KOMUNITAS CIBINONG
                </span>
                <h3 class="font-display text-xl sm:text-3xl text-gold leading-tight">
                    KERJA SAMA SEKOLAH, TPA &amp; KOMUNITAS RT/RW?
                </h3>
            </div>
            <a href="https://wa.me/6287705555190?text=Halo%20Admin%20MustikaBimbel%2C%20kami%20tertarik%20kerja%20sama%20program%20Jarimatika%20dan%20MIPA."
               target="_blank" rel="noopener"
               class="btn-pop btn-pop--lime shrink-0">
                <span class="btn-roll">
                    <span>Hubungi Kami</span>
                    <span aria-hidden="true">Hubungi Kami</span>
                </span>
                <span class="btn-pop__dot"><i data-lucide="message-circle" class="w-4 h-4"></i></span>
            </a>
        </div>
    </div>
</section>
