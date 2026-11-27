<!-- 5.9 KENALAN SAMA PENGAJAR (teacher.blade.php) -->
@php
    $img = fn($f) => file_exists(public_path("images/landing/$f")) ? asset("images/landing/$f") : null;
    // TODO: isi data asli pengajar (ubah 'is_placeholder' => false) dan foto di public/images/landing/pengajar.jpg
    $teacher = [
        'is_placeholder' => true,
        'name' => 'Tim Pengajar MustikaBimbel',
        'title' => 'Pengajar Jarimatika & MIPA Cibinong',
        'bio' => 'Mendampingi siswa TK, SD, dan SMP memahami konsep dasar secara sabar, melatih kecepatan hitung Jarimatika, serta membangun rasa percaya diri saat menghadapi soal ujian.',
        'photo' => $img('pengajar.jpg'),
    ];
    $scheduleTotal = isset($schedules) && $schedules->count() > 0 ? $schedules->count() : 3;
@endphp

<section class="py-16 sm:py-24 bg-paper bg-dots scallop-top relative overflow-hidden" style="--scallop: #FFFDF7;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center max-w-4xl mx-auto mb-12 reveal" x-intersect.once="$el.classList.add('is-in')">
            <span class="sticker sticker--lime mb-4" style="--tilt: -2deg;">
                KENALAN DULU
            </span>
            @if ($teacher['is_placeholder'])
                <h2 class="font-display-hero text-[36px] sm:text-[54px] lg:text-[72px] text-ink">
                    <span class="block">KENALAN SAMA</span>
                    <span class="block mt-2">
                        PENGAJAR
                        <span class="sticker-headline sticker-headline--gold text-[0.82em] mx-1" style="--tilt: -2.5deg;">KAMI</span>
                    </span>
                </h2>
            @else
                <h2 class="font-display-hero text-[36px] sm:text-[54px] lg:text-[72px] text-ink">
                    <span class="block">{{ strtoupper($teacher['name']) }}</span>
                </h2>
            @endif
            <p class="font-script text-2xl sm:text-3xl text-navy mt-1">
                pengajar di balik MustikaBimbel
            </p>
        </div>

        <!-- Photo Frame + Bio + Factual Stat Counters -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center max-w-6xl mx-auto">
            <!-- Left: Tilted Frame -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="relative max-w-xs w-full">
                    <div class="absolute -top-4 -right-4 z-20">
                        @include('landing.partials._badge-flower', ['tone' => 'gold', 'icon' => 'heart-handshake', 'size' => 64])
                    </div>
                    <div class="bg-gold rounded-[28px] border-[3px] border-ink hard-shadow-lg p-4 rotate-[-3deg] hover:rotate-0 transition-transform duration-200">
                        <div class="aspect-square rounded-[20px] border-2 border-ink bg-cream overflow-hidden flex flex-col items-center justify-center text-center {{ $teacher['photo'] ? 'p-0' : 'p-6' }}">
                            @if ($teacher['photo'])
                                <img src="{{ $teacher['photo'] }}"
                                     alt="Foto {{ $teacher['name'] }} di MustikaBimbel Cibinong"
                                     loading="lazy"
                                     class="w-full h-full object-cover">
                            @else
                                @include('landing.partials._mascot', ['pose' => 'wave', 'size' => 150])
                                <span class="mt-3 font-label text-[11px] font-bold uppercase tracking-wider text-navy bg-paper px-3 py-1 rounded-full border-2 border-ink">
                                    {{-- TODO: isi foto asli pengajar di public/images/landing/pengajar.jpg --}}
                                    MustikaBimbel Cibinong
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Bio + 4 Factual Counters -->
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-cream rounded-[24px] border-[2.5px] border-ink hard-shadow p-6 sm:p-8 space-y-3">
                    <span class="sticker sticker--ink text-gold" style="--tilt: -1.5deg;">
                        {{ $teacher['title'] }}
                    </span>
                    <p class="text-sm sm:text-base text-slate-700 leading-relaxed pt-1">
                        {{ $teacher['bio'] }}
                    </p>
                </div>

                <!-- 4 Factual Count-Up Stat Counters -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4"
                     x-data="{
                        shown: false,
                        s1: 0, s2: 0, s3: 0, s4: 0,
                        runCount() {
                            if (this.shown) return;
                            this.shown = true;
                            const anim = (target, key) => {
                                let cur = 0;
                                const step = () => {
                                    cur++;
                                    this[key] = cur;
                                    if (cur < target) setTimeout(step, 55);
                                };
                                step();
                            };
                            anim(10, 's1');
                            anim(3, 's2');
                            anim(4, 's3');
                            anim({{ (int) $scheduleTotal }}, 's4');
                        }
                     }"
                     x-intersect.once="runCount()">
                    <div class="bg-paper rounded-2xl border-2 border-ink shadow-[3px_3px_0_#111] p-4 text-center">
                        <div class="font-display text-3xl sm:text-4xl text-navy" x-text="s1">10</div>
                        <div class="font-label text-[11px] font-bold uppercase text-slate-600 mt-1">Maks Siswa/Sesi</div>
                    </div>
                    <div class="bg-paper rounded-2xl border-2 border-ink shadow-[3px_3px_0_#111] p-4 text-center">
                        <div class="font-display text-3xl sm:text-4xl text-navy" x-text="s2">3</div>
                        <div class="font-label text-[11px] font-bold uppercase text-slate-600 mt-1">Jenjang (TK-SD-SMP)</div>
                    </div>
                    <div class="bg-paper rounded-2xl border-2 border-ink shadow-[3px_3px_0_#111] p-4 text-center">
                        <div class="font-display text-3xl sm:text-4xl text-navy" x-text="s3">4</div>
                        <div class="font-label text-[11px] font-bold uppercase text-slate-600 mt-1">Mapel MIPA</div>
                    </div>
                    <div class="bg-paper rounded-2xl border-2 border-ink shadow-[3px_3px_0_#111] p-4 text-center">
                        <div class="font-display text-3xl sm:text-4xl text-navy"><span x-text="s4">{{ (int) $scheduleTotal }}</span>×</div>
                        <div class="font-label text-[11px] font-bold uppercase text-slate-600 mt-1">Sesi Jadwal Resmi</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4 Factual Feature Strips (replacing fake awards) -->
        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 max-w-6xl mx-auto">
            <div class="rounded-2xl border-2 border-ink bg-gold/30 p-4 flex items-center gap-3 shadow-[3px_3px_0_#111]">
                <div class="w-10 h-10 rounded-xl bg-gold border-2 border-ink flex items-center justify-center shrink-0">
                    <i data-lucide="hand" class="w-5 h-5 text-ink"></i>
                </div>
                <div>
                    <div class="font-display text-sm text-ink">Metode Jarimatika</div>
                    <div class="text-xs text-slate-700">Hitung cepat pakai jari</div>
                </div>
            </div>

            <div class="rounded-2xl border-2 border-ink bg-lime/35 p-4 flex items-center gap-3 shadow-[3px_3px_0_#111]">
                <div class="w-10 h-10 rounded-xl bg-lime border-2 border-ink flex items-center justify-center shrink-0">
                    <i data-lucide="file-bar-chart-2" class="w-5 h-5 text-ink"></i>
                </div>
                <div>
                    <div class="font-display text-sm text-ink">E-Raport Digital</div>
                    <div class="text-xs text-slate-700">Grafik progres tiap sesi</div>
                </div>
            </div>

            <div class="rounded-2xl border-2 border-ink bg-cream p-4 flex items-center gap-3 shadow-[3px_3px_0_#111]">
                <div class="w-10 h-10 rounded-xl bg-navy border-2 border-ink flex items-center justify-center shrink-0">
                    <i data-lucide="message-circle-check" class="w-5 h-5 text-gold"></i>
                </div>
                <div>
                    <div class="font-display text-sm text-ink">Notifikasi WA</div>
                    <div class="text-xs text-slate-700">Info anak tiba &amp; pulang</div>
                </div>
            </div>

            <div class="rounded-2xl border-2 border-ink bg-cream p-4 flex items-center gap-3 shadow-[3px_3px_0_#111]">
                <div class="w-10 h-10 rounded-xl bg-tomato border-2 border-ink flex items-center justify-center shrink-0">
                    <i data-lucide="users" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <div class="font-display text-sm text-ink">Kelas Kecil</div>
                    <div class="text-xs text-slate-700">Maksimal 10 siswa/sesi</div>
                </div>
            </div>
        </div>
    </div>
</section>
