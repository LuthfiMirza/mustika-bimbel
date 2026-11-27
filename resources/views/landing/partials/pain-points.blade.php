<!-- 5.8 KAMU NGGAK SENDIRIAN (pain-points.blade.php) — Keluhan Umum Orang Tua -->
<section class="py-16 sm:py-24 bg-cream bg-dots relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center max-w-4xl mx-auto mb-12 reveal" x-intersect.once="$el.classList.add('is-in')">
            <span class="sticker sticker--paper mb-4" style="--tilt: -2deg;">
                Keluhan yang Sering Kami Dengar
            </span>
            <h2 class="font-display-hero text-[36px] sm:text-[56px] lg:text-[78px] text-ink">
                <span>KAMU</span>
                <span class="sticker-headline sticker-headline--tomato text-[0.82em] mx-1" style="--tilt: -3deg;">NGGAK</span>
                <span>SENDIRIAN</span>
            </h2>
            <p class="mt-4 text-sm sm:text-base text-slate-700 max-w-2xl mx-auto">
                Banyak orang tua di Cibinong datang ke MustikaBimbel dengan keresahan yang persis sama sebelum anak dibimbing secara bertahap.
            </p>
        </div>

        {{-- TODO: ganti dengan testimoni asli + izin orang tua --}}
        @php
            $quotes = [
                [
                    'text' => 'Anak saya sudah kelas 4 tapi perkaliannya masih menghitung pakai coretan.',
                    'role' => 'Orang tua siswa SD',
                    'rot' => 'lg:-rotate-2',
                    'tag' => 'HITUNG DASAR',
                ],
                [
                    'text' => 'Di rumah sudah paham, begitu soalnya diubah sedikit langsung bingung.',
                    'role' => 'Orang tua siswa SMP',
                    'rot' => 'lg:rotate-2 lg:translate-y-4',
                    'tag' => 'PEMAHAMAN KONSEP',
                ],
                [
                    'text' => 'Saya ingin tahu perkembangan anak tiap pertemuan, bukan cuma pas rapor.',
                    'role' => 'Orang tua siswa SD',
                    'rot' => 'lg:rotate-1',
                    'tag' => 'PANTAUAN PROGRES',
                ],
                [
                    'text' => 'Nilai Fisika turun sejak masuk kelas 8, padahal anaknya rajin.',
                    'role' => 'Orang tua siswa SMP',
                    'rot' => 'lg:-rotate-2 lg:translate-y-3',
                    'tag' => 'STRATEGI MIPA',
                ],
            ];
        @endphp

        <!-- 4 Tilted Quote Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 max-w-5xl mx-auto">
            @foreach ($quotes as $idx => $q)
                <div class="reveal" x-intersect.once="$el.classList.add('is-in')" style="transition-delay: {{ $idx * 70 }}ms;">
                    <div class="bg-paper rounded-[24px] border-[2.5px] border-ink hard-shadow p-6 sm:p-7 h-full transition-transform duration-200 hover:rotate-0 hover:-translate-y-1 {{ $q['rot'] }}">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="font-display text-5xl leading-none text-gold select-none" style="-webkit-text-stroke: 1.5px #111;">“</span>
                            <span class="px-2.5 py-0.5 rounded-full bg-cream border-2 border-ink font-label text-[10px] font-bold uppercase text-ink">
                                {{ $q['tag'] }}
                            </span>
                        </div>
                        <p class="text-base sm:text-lg font-bold text-ink leading-snug">
                            "{{ $q['text'] }}"
                        </p>
                        <p class="mt-4 pt-3 border-t-2 border-dashed border-ink/15 font-label text-xs font-bold uppercase tracking-wide text-navy">
                            — <em>{{ $q['role'] }}</em>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="#form-trial" class="btn-pop">
                <span class="btn-roll">
                    <span>Konsultasi &amp; Coba Gratis</span>
                    <span aria-hidden="true">Konsultasi &amp; Coba Gratis</span>
                </span>
                <span class="btn-pop__dot"><i data-lucide="arrow-right" class="w-4 h-4"></i></span>
            </a>
        </div>
    </div>
</section>
