<!-- 5.11 JADWAL & FORM (#jadwal-belajar, #form-trial) — Scalloped Schedule Cards & Neo-Brutalist Trial Form -->
<section id="jadwal-belajar" class="py-16 sm:py-24 bg-cream bg-dots relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">

        <!-- Bagian A: Jadwal Belajar Real-Time -->
        <div>
            <div class="text-center max-w-3xl mx-auto mb-12 reveal" x-intersect.once="$el.classList.add('is-in')">
                <span class="sticker sticker--gold mb-4" style="--tilt: -2deg;">
                    Kapasitas Kelas Kecil &amp; Kondusif
                </span>
                <h2 class="font-display-hero text-[34px] sm:text-[54px] lg:text-[72px] text-ink">
                    <span class="block">JADWAL BELAJAR</span>
                    <span class="block mt-2">
                        &amp;
                        <span class="sticker-headline text-[0.8em]" style="--tilt: -2deg;">SISA KURSI</span>
                    </span>
                </h2>
                <p class="mt-4 text-slate-700 text-sm sm:text-base max-w-2xl mx-auto">
                    Setiap sesi dibatasi maksimal 10 siswa agar pengajar dapat membimbing pemahaman konsep dan kecepatan hitung setiap anak secara personal.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($schedules as $idx => $schedule)
                    @php
                        $remaining = $schedule->remaining_quota;
                        $percentFilled = $schedule->max_quota > 0
                            ? min(100, round(($schedule->filled_quota / $schedule->max_quota) * 100))
                            : 0;
                        $isScarce = $remaining <= 3;
                        $rot = $idx % 2 === 0 ? '-1.2deg' : '1.2deg';
                    @endphp
                    <div class="card-bite flex flex-col justify-between relative" style="--r: {{ $rot }};">
                        <div class="p-6 sm:p-7 flex-1">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <span class="inline-flex items-center gap-1.5 font-label text-xs font-bold uppercase tracking-wider text-navy">
                                    <i data-lucide="calendar-clock" class="w-4 h-4 text-tomato"></i>
                                    {{ $schedule->program?->category ?? 'Reguler' }}
                                </span>
                                @if ($isScarce)
                                    <span class="sticker sticker--tomato" style="--tilt: 3deg;">
                                        🔥 SISA {{ $remaining }} KURSI
                                    </span>
                                @endif
                            </div>

                            <h3 class="font-display text-2xl sm:text-3xl text-ink leading-tight">
                                {{ $schedule->days_text }}
                            </h3>
                            <p class="font-label text-lg font-bold text-navy mt-1.5 flex items-center gap-2">
                                <i data-lucide="clock-3" class="w-5 h-5 text-ink"></i>
                                {{ str_replace(':', '.', $schedule->start_time) }} – {{ str_replace(':', '.', $schedule->end_time) }} WIB
                            </p>
                            <p class="text-xs text-slate-600 mt-2">
                                Program Utama: <strong>{{ $schedule->program?->name ?? 'Semua Program (TK/SD/SMP)' }}</strong>
                            </p>

                            <!-- Thick Neo-Brutalist Progress Bar -->
                            <div class="mt-5 bg-cream p-4 rounded-2xl border-2 border-ink">
                                <div class="flex items-center justify-between font-label text-xs font-bold mb-2">
                                    <span>Terisi: {{ $schedule->filled_quota }}/{{ $schedule->max_quota }} Siswa</span>
                                    <span class="{{ $isScarce ? 'text-tomato' : 'text-edu-teal' }}">
                                        Tersedia {{ $remaining }} Kursi
                                    </span>
                                </div>
                                <div class="w-full h-3.5 bg-paper border-2 border-ink rounded-full overflow-hidden">
                                    <div class="h-full transition-all duration-500 {{ $isScarce ? 'bg-tomato' : 'bg-gold' }}"
                                         style="width: {{ $percentFilled }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-bite__foot p-5">
                            <button type="button"
                                    @click="chooseSchedule('{{ $schedule->id }}', '{{ $schedule->program_id }}', '{{ $schedule->program?->target_grade }}')"
                                    class="btn-pop btn-pop--sm w-full">
                                <span class="btn-roll">
                                    <span>Pilih Jadwal Ini</span>
                                    <span aria-hidden="true">Pilih Jadwal Ini</span>
                                </span>
                                <span class="btn-pop__dot"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Bagian B: Formulir Klaim Kelas Coba Gratis (Free Trial) -->
        <div id="form-trial" class="scroll-mt-24">
            <div class="bg-paper rounded-[28px] border-[3px] border-ink hard-shadow-lg overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-12">

                    <!-- Left Column: Gold Persuasive Column -->
                    <div class="lg:col-span-5 bg-gold p-6 sm:p-10 border-b-[3px] lg:border-b-0 lg:border-r-[3px] border-ink flex flex-col justify-between space-y-6">
                        <div class="space-y-5">
                            <span class="sticker sticker--ink text-lime" style="--tilt: -2deg;">
                                <i data-lucide="gift" class="w-3.5 h-3.5"></i>
                                <span>100% GRATIS PERTEMUAN PERTAMA</span>
                            </span>

                            <h2 class="font-display text-3xl sm:text-4xl text-ink leading-tight">
                                YUK, BANGUN FONDASI MIPA-MU!
                            </h2>
                            <p class="font-script text-2xl text-navy">
                                Daftar sekarang &amp; mulai belajar lebih terarah
                            </p>

                            <p class="text-sm text-ink/90 font-medium leading-relaxed">
                                Isi formulir singkat di samping. Data pendaftaran ananda akan tercatat dan langsung terhubung ke WhatsApp Resmi Admin <strong>MustikaBimbel (0877-0555-5190)</strong>.
                            </p>

                            <!-- Dynamic Quiz Score Badge -->
                            <div x-show="gameScore !== null" x-cloak class="p-4 rounded-2xl bg-paper border-2 border-ink shadow-[4px_4px_0_#111] text-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-navy text-gold border-2 border-ink flex items-center justify-center font-extrabold text-lg shrink-0">
                                        🏆
                                    </div>
                                    <div>
                                        <p class="font-display text-sm text-ink">Skor Tantangan 30 Detik Terlampir!</p>
                                        <p class="text-xs text-slate-700 font-semibold">
                                            Skor: <strong x-text="gameScore + '/100'"></strong> &bull; Rata-rata: <strong x-text="gameAvgTime + ' detik/soal'"></strong>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <ul class="space-y-2.5 text-xs sm:text-sm font-semibold text-ink">
                                <li class="flex items-center gap-2.5">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-navy shrink-0"></i>
                                    <span>Gratis diagnosa kemampuan hitung &amp; konsep dasar MIPA anak</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-navy shrink-0"></i>
                                    <span>Pilih kelas Jarimatika (TK-SD) atau Bimbel MIPA (SD-SMP)</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-navy shrink-0"></i>
                                    <span>Ruang belajar nyaman di Perumahan Amarylis Garden Cibinong</span>
                                </li>
                            </ul>
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            @include('landing.partials._mascot', ['pose' => 'thumbs', 'size' => 88])
                            <div class="bg-paper border-2 border-ink rounded-2xl px-4 py-2.5 text-xs font-bold text-ink shadow-[3px_3px_0_#111]">
                                "Langsung terhubung ke WA Admin begitu diklik!"
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Exact Contract Form -->
                    <div class="lg:col-span-7 p-6 sm:p-10 bg-paper">
                        <form action="{{ route('landing.store-trial') }}" method="POST" class="space-y-5">
                            @csrf
                            <input type="hidden" name="quiz_score" :value="gameScore">
                            <input type="hidden" name="quiz_avg_time" :value="gameAvgTime">

                            <div class="border-b-2 border-ink/10 pb-3">
                                <h3 class="font-display text-xl sm:text-2xl text-ink">
                                    Formulir Klaim Kelas Coba Gratis (Free Trial)
                                </h3>
                                <p class="text-xs text-slate-600">Lengkapi data di bawah ini untuk konfirmasi jadwal via WhatsApp</p>
                            </div>

                            @if ($errors->any())
                                <div class="p-4 rounded-xl bg-rose-50 border-2 border-tomato text-xs text-rose-800 font-semibold space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <p>&bull; {{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-label text-xs font-bold uppercase text-ink mb-1.5">Nama Orang Tua (Bapak/Ibu) *</label>
                                    <input type="text" name="parent_name" value="{{ old('parent_name') }}" required
                                           placeholder="Contoh: Ibu Rina Kartika"
                                           class="w-full px-4 py-3 rounded-[14px] border-2 border-ink bg-white text-sm focus:outline focus:outline-[3px] focus:outline-gold focus:outline-offset-2">
                                </div>
                                <div>
                                    <label class="block font-label text-xs font-bold uppercase text-ink mb-1.5">Nomor WhatsApp Aktif *</label>
                                    <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" required
                                           placeholder="Contoh: 081234567890"
                                           class="w-full px-4 py-3 rounded-[14px] border-2 border-ink bg-white text-sm focus:outline focus:outline-[3px] focus:outline-gold focus:outline-offset-2">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="sm:col-span-1">
                                    <label class="block font-label text-xs font-bold uppercase text-ink mb-1.5">Nama Anak *</label>
                                    <input type="text" name="student_name" value="{{ old('student_name') }}" required
                                           placeholder="Nama panggilan/lengkap"
                                           class="w-full px-4 py-3 rounded-[14px] border-2 border-ink bg-white text-sm focus:outline focus:outline-[3px] focus:outline-gold focus:outline-offset-2">
                                </div>
                                <div>
                                    <label class="block font-label text-xs font-bold uppercase text-ink mb-1.5">Jenjang *</label>
                                    <select name="grade_level" x-model="selectedGrade" required
                                            class="w-full px-4 py-3 rounded-[14px] border-2 border-ink bg-white text-sm font-semibold focus:outline focus:outline-[3px] focus:outline-gold focus:outline-offset-2">
                                        <option value="TK">TK (Jarimatika)</option>
                                        <option value="SD">SD (Kelas 1 - 6)</option>
                                        <option value="SMP">SMP (Kelas 7 - 9)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-label text-xs font-bold uppercase text-ink mb-1.5">Sekolah Asal</label>
                                    <input type="text" name="school_name" value="{{ old('school_name') }}"
                                           placeholder="Contoh: SMPN 1 Cibinong"
                                           class="w-full px-4 py-3 rounded-[14px] border-2 border-ink bg-white text-sm focus:outline focus:outline-[3px] focus:outline-gold focus:outline-offset-2">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-label text-xs font-bold uppercase text-ink mb-1.5">Pilihan Program</label>
                                    <select name="program_id" x-model="selectedProgramId"
                                            class="w-full px-4 py-3 rounded-[14px] border-2 border-ink bg-white text-sm font-semibold focus:outline focus:outline-[3px] focus:outline-gold focus:outline-offset-2">
                                        @foreach ($programs as $program)
                                            <option value="{{ $program->id }}">
                                                {{ $program->name }} (Rp {{ number_format($program->monthly_fee, 0, ',', '.') }}/bln)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-label text-xs font-bold uppercase text-ink mb-1.5">Pilihan Jadwal Belajar</label>
                                    <select name="schedule_id" x-model="selectedScheduleId"
                                            class="w-full px-4 py-3 rounded-[14px] border-2 border-ink bg-white text-sm font-semibold focus:outline focus:outline-[3px] focus:outline-gold focus:outline-offset-2">
                                        @foreach ($schedules as $schedule)
                                            <option value="{{ $schedule->id }}">
                                                {{ $schedule->days_text }} ({{ $schedule->start_time }} - {{ $schedule->end_time }} WIB)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block font-label text-xs font-bold uppercase text-ink mb-1.5">Kendala Belajar Anak Saat Ini (Opsional)</label>
                                <input type="text" name="learning_obstacle" value="{{ old('learning_obstacle') }}"
                                       placeholder="Contoh: Belum hafal perkalian, lambat berhitung, atau sulit paham soal Aljabar & Fisika"
                                       class="w-full px-4 py-3 rounded-[14px] border-2 border-ink bg-white text-sm focus:outline focus:outline-[3px] focus:outline-gold focus:outline-offset-2">
                            </div>

                            <button type="submit" class="btn-pop w-full">
                                <span class="btn-roll">
                                    <span>Daftar Gratis via WhatsApp</span>
                                    <span aria-hidden="true">Daftar Gratis via WhatsApp</span>
                                </span>
                                <span class="btn-pop__dot"><i data-lucide="send" class="w-4 h-4"></i></span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>
