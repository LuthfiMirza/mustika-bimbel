<!-- Seksi 6 & 7: Jadwal Belajar Real-Time & Formulir Klaim Kelas Coba Gratis (WA) -->
<section id="jadwal-belajar" class="py-16 sm:py-24 bg-[#F8FAFC] border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">

        <!-- Bagian 6: Jadwal Belajar & Indikator Sisa Kursi Real-Time -->
        <div>
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="inline-block px-3.5 py-1 rounded-full bg-[#0F2C59]/10 text-[#0F2C59] text-xs font-extrabold uppercase tracking-wider mb-3">
                    Kapasitas Kelas Kecil &amp; Kondusif
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-[#0F2C59] tracking-tight">
                    Jadwal Belajar Resmi &amp; Sisa Kursi
                </h2>
                <p class="mt-3 text-slate-600 text-sm sm:text-base">
                    Setiap sesi dibatasi maksimal 10 siswa agar pengajar dapat membimbing pemahaman konsep dan kecepatan hitung setiap anak secara personal.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($schedules as $schedule)
                    @php
                        $remaining = $schedule->remaining_quota;
                        $percentFilled = $schedule->max_quota > 0
                            ? min(100, round(($schedule->filled_quota / $schedule->max_quota) * 100))
                            : 0;
                        $isScarce = $remaining <= 3;
                    @endphp
                    <div class="bg-white rounded-3xl p-7 border-2 {{ $isScarce ? 'border-[#FACC15] shadow-xl' : 'border-slate-200 shadow-md' }} flex flex-col justify-between relative overflow-hidden">
                        @if ($isScarce)
                            <div class="absolute top-0 right-0 bg-[#FACC15] text-[#0F2C59] text-[11px] font-extrabold px-4 py-1 rounded-bl-2xl uppercase tracking-wider">
                                🔥 Sisa {{ $remaining }} Kursi Lagi!
                            </div>
                        @endif

                        <div>
                            <span class="inline-flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-wider text-[#0D9488]">
                                <i data-lucide="calendar-clock" class="w-4 h-4"></i>
                                {{ $schedule->program?->category ?? 'Reguler' }}
                            </span>
                            <h3 class="text-2xl font-extrabold text-[#0F2C59] mt-2">
                                {{ $schedule->days_text }}
                            </h3>
                            <p class="text-lg font-bold text-slate-700 mt-1 flex items-center gap-2">
                                <i data-lucide="clock-3" class="w-5 h-5 text-[#0F2C59]"></i>
                                {{ str_replace(':', '.', $schedule->start_time) }} – {{ str_replace(':', '.', $schedule->end_time) }} WIB
                            </p>
                            <p class="text-xs text-slate-500 mt-2">
                                Program Utama: <strong>{{ $schedule->program?->name ?? 'Semua Program (TK/SD/SMP)' }}</strong>
                            </p>

                            <!-- Progress Bar Kapasitas Kelas -->
                            <div class="mt-6 bg-slate-50 p-4 rounded-2xl border border-slate-200/80">
                                <div class="flex items-center justify-between text-xs font-bold mb-2">
                                    <span class="text-slate-600">Terisi: {{ $schedule->filled_quota }}/{{ $schedule->max_quota }} Siswa</span>
                                    <span class="{{ $isScarce ? 'text-rose-600 font-extrabold' : 'text-[#0D9488]' }}">
                                        Tersedia {{ $remaining }} Kursi
                                    </span>
                                </div>
                                <div class="w-full h-3 bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500 {{ $isScarce ? 'bg-amber-500' : 'bg-[#0D9488]' }}"
                                         style="width: {{ $percentFilled }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100">
                            <button type="button"
                                    @click="chooseSchedule('{{ $schedule->id }}', '{{ $schedule->program_id }}', '{{ $schedule->program?->target_grade }}')"
                                    class="w-full py-3.5 px-4 rounded-xl text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow transition-all flex items-center justify-center gap-2">
                                <span>Pilih Jadwal Ini untuk Coba Gratis</span>
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Bagian 7: Formulir Klaim Kelas Coba Gratis (Free Trial) + Auto Redirect WA -->
        <div id="form-trial" class="scroll-mt-24">
            <div class="bg-[#0F2C59] rounded-3xl p-6 sm:p-10 lg:p-12 text-white shadow-2xl border-4 border-[#FACC15]">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

                    <!-- Left Column: Persuasive Copy -->
                    <div class="lg:col-span-5 space-y-6">
                        <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#FACC15] text-[#0F2C59] text-xs font-extrabold uppercase">
                            <i data-lucide="gift" class="w-4 h-4"></i>
                            100% Gratis Pertemuan Coba Kelas
                        </span>

                        <h2 class="text-2xl sm:text-4xl font-extrabold leading-tight">
                            Yuk, Bangun Fondasi MIPA-mu!<br>
                            <span class="text-[#FACC15]">Daftar Sekarang &amp; Mulai Belajar Lebih Terarah.</span>
                        </h2>

                        <p class="text-sm sm:text-base text-slate-200 leading-relaxed">
                            Isi formulir singkat di samping. Data pendaftaran ananda akan tercatat dan langsung terhubung ke WhatsApp Resmi Admin <strong>MustikaBimbel (0877-0555-5190)</strong>.
                        </p>

                        <!-- Dynamic Quiz Score Badge if completed -->
                        <div x-show="gameScore !== null" x-cloak class="p-4 rounded-2xl bg-[#FACC15]/15 border-2 border-[#FACC15] text-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-[#FACC15] text-[#0F2C59] flex items-center justify-center font-extrabold text-lg">
                                    🏆
                                </div>
                                <div>
                                    <p class="font-extrabold text-[#FACC15]">Skor Tantangan 30 Detik Terlampir!</p>
                                    <p class="text-xs text-slate-200">
                                        Skor: <strong x-text="gameScore + '/100'"></strong> &bull; Rata-rata: <strong x-text="gameAvgTime + ' detik/soal'"></strong>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <ul class="space-y-3 text-xs sm:text-sm text-slate-200 pt-2">
                            <li class="flex items-center gap-2.5">
                                <i data-lucide="check-circle-2" class="w-5 h-5 text-[#FACC15] shrink-0"></i>
                                <span>Gratis diagnosa kemampuan hitung &amp; konsep dasar MIPA anak</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i data-lucide="check-circle-2" class="w-5 h-5 text-[#FACC15] shrink-0"></i>
                                <span>Bisa pilih kelas Jarimatika (TK-SD) atau Bimbel MIPA (SD-SMP)</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i data-lucide="check-circle-2" class="w-5 h-5 text-[#FACC15] shrink-0"></i>
                                <span>Ruang belajar nyaman di Perumahan Amarylis Garden Cibinong</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Right Column: Form Klaim Free Trial -->
                    <div class="lg:col-span-7">
                        <form action="{{ route('landing.store-trial') }}" method="POST"
                              class="bg-white text-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl space-y-5">
                            @csrf
                            <input type="hidden" name="quiz_score" :value="gameScore">
                            <input type="hidden" name="quiz_avg_time" :value="gameAvgTime">

                            <div class="border-b border-slate-100 pb-3">
                                <h3 class="text-lg sm:text-xl font-extrabold text-[#0F2C59]">
                                    Formulir Klaim Kelas Coba Gratis (Free Trial)
                                </h3>
                                <p class="text-xs text-slate-500">Lengkapi data di bawah ini untuk konfirmasi jadwal via WhatsApp</p>
                            </div>

                            @if ($errors->any())
                                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <p>&bull; {{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Nama Orang Tua (Bapak/Ibu) *</label>
                                    <input type="text" name="parent_name" value="{{ old('parent_name') }}" required
                                           placeholder="Contoh: Ibu Rina Kartika"
                                           class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0F2C59] focus:border-[#0F2C59] outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Nomor WhatsApp Aktif *</label>
                                    <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" required
                                           placeholder="Contoh: 081234567890"
                                           class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0F2C59] focus:border-[#0F2C59] outline-none">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="sm:col-span-1">
                                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Nama Anak *</label>
                                    <input type="text" name="student_name" value="{{ old('student_name') }}" required
                                           placeholder="Nama panggilan/lengkap"
                                           class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0F2C59] focus:border-[#0F2C59] outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Jenjang *</label>
                                    <select name="grade_level" x-model="selectedGrade" required
                                            class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm bg-white focus:ring-2 focus:ring-[#0F2C59] outline-none">
                                        <option value="TK">TK (Jarimatika)</option>
                                        <option value="SD">SD (Kelas 1 - 6)</option>
                                        <option value="SMP">SMP (Kelas 7 - 9)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Sekolah Asal</label>
                                    <input type="text" name="school_name" value="{{ old('school_name') }}"
                                           placeholder="Contoh: SMPN 1 Cibinong"
                                           class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0F2C59] focus:border-[#0F2C59] outline-none">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Pilihan Program</label>
                                    <select name="program_id" x-model="selectedProgramId"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm bg-white focus:ring-2 focus:ring-[#0F2C59] outline-none">
                                        @foreach ($programs as $program)
                                            <option value="{{ $program->id }}">
                                                {{ $program->name }} (Rp {{ number_format($program->monthly_fee, 0, ',', '.') }}/bln)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Pilihan Jadwal Belajar</label>
                                    <select name="schedule_id" x-model="selectedScheduleId"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm bg-white focus:ring-2 focus:ring-[#0F2C59] outline-none">
                                        @foreach ($schedules as $schedule)
                                            <option value="{{ $schedule->id }}">
                                                {{ $schedule->days_text }} ({{ $schedule->start_time }} - {{ $schedule->end_time }} WIB)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Kendala Belajar Anak Saat Ini (Opsional)</label>
                                <input type="text" name="learning_obstacle" value="{{ old('learning_obstacle') }}"
                                       placeholder="Contoh: Belum hafal perkalian, lambat berhitung, atau sulit paham soal Aljabar & Fisika"
                                       class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0F2C59] focus:border-[#0F2C59] outline-none">
                            </div>

                            <button type="submit"
                                    class="w-full py-4 px-6 rounded-2xl text-base font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2.5">
                                <i data-lucide="send" class="w-5 h-5"></i>
                                <span>Klaim Kelas Coba Gratis &amp; Kirim ke WhatsApp</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

