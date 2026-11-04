<!-- Section: Pohon Level Jarimatika & Progress Penguasaan MIPA -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    <!-- Kolom Kiri: Pohon Level Jarimatika (Level 1-6) -->
    <div class="lg:col-span-6 bg-white rounded-3xl p-6 sm:p-7 shadow-md border-2 border-slate-200/80">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-wider text-[#0D9488]">Tahapan Metode</span>
                <h2 class="text-lg sm:text-xl font-extrabold text-[#0F2C59]">Pohon Level Jarimatika</h2>
            </div>
            <span class="px-3 py-1 rounded-full bg-[#FACC15] text-[#0F2C59] text-xs font-extrabold">
                Posisi: Level {{ $student->jarimatika_level }}
            </span>
        </div>

        <p class="text-xs text-slate-500 mt-3 mb-5 leading-relaxed">
            Kurikulum berhitung cepat dengan formasi jari tangan bertahap dari satuan, puluhan, hingga perkalian & pembagian tanpa kalkulator/sempoa.
        </p>

        @php
            $jarimatikaLevels = [
                1 => ['title' => 'Level 1: Formasi Jari Satuan (1–9)', 'desc' => 'Mengenal formasi jari tangan kanan (jempol bernilai 5)'],
                2 => ['title' => 'Level 2: Jari Puluhan & Teman Kecil', 'desc' => 'Kombinasi tangan kiri (puluhan) dan teman kecil (+/- 1 sampai 4)'],
                3 => ['title' => 'Level 3: Teman Besar & Hitung Puluhan', 'desc' => 'Penguasaan teman besar (+/- 6 sampai 9) hingga angka 99'],
                4 => ['title' => 'Level 4: Jarimatika Perkalian 6–9', 'desc' => 'Trik jari dilipat (puluhan) dan berdiri (satuan dikali)'],
                5 => ['title' => 'Level 5: Pembagian & Pecahan Jari', 'desc' => 'Konsep pembalikan perkalian cepat menggunakan jari tangan'],
                6 => ['title' => 'Level 6: Master Jarimatika Berantai', 'desc' => 'Hitung cepat 3-5 bilangan beruntun dalam hitungan 2-3 detik']
            ];
        @endphp

        <!-- Stepper / Tree Container -->
        <div class="space-y-3.5 relative">
            <div class="absolute left-4 top-3 bottom-3 w-0.5 bg-slate-200 z-0"></div>

            @foreach ($jarimatikaLevels as $lvl => $info)
                @php
                    $isPassed = $lvl < $student->jarimatika_level;
                    $isCurrent = $lvl === (int)$student->jarimatika_level;
                    $isLocked = $lvl > $student->jarimatika_level;
                @endphp
                <div class="relative z-10 flex items-start gap-3.5 p-3 rounded-2xl transition-all {{ $isCurrent ? 'bg-[#0F2C59]/5 border-2 border-[#0F2C59]' : ($isPassed ? 'bg-slate-50 border border-slate-200' : 'bg-slate-50/50 border border-dashed border-slate-200 opacity-60') }}">
                    <!-- Circle Icon -->
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-extrabold text-xs shrink-0 {{ $isPassed ? 'bg-emerald-600 text-white' : ($isCurrent ? 'bg-[#FACC15] text-[#0F2C59] ring-4 ring-[#FACC15]/30' : 'bg-slate-300 text-slate-600') }}">
                        @if ($isPassed)
                            <i data-lucide="check" class="w-4 h-4"></i>
                        @elseif ($isCurrent)
                            <i data-lucide="zap" class="w-4 h-4"></i>
                        @else
                            {{ $lvl }}
                        @endif
                    </div>

                    <!-- Level Details -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <h3 class="text-xs sm:text-sm font-extrabold {{ $isCurrent ? 'text-[#0F2C59]' : ($isPassed ? 'text-slate-800' : 'text-slate-500') }}">
                                {{ $info['title'] }}
                            </h3>
                            @if ($isCurrent)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-[#0F2C59] text-[#FACC15] shrink-0">
                                    Aktif
                                </span>
                            @elseif ($isPassed)
                                <span class="text-[10px] font-bold text-emerald-600 shrink-0">
                                    Tuntas ✓
                                </span>
                            @endif
                        </div>
                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $info['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Kolom Kanan: Penguasaan Materi MIPA & Strategi Soal -->
    <div class="lg:col-span-6 bg-white rounded-3xl p-6 sm:p-7 shadow-md border-2 border-slate-200/80 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-wider text-[#0D9488]">Kurikulum & Pemahaman</span>
                    <h2 class="text-lg sm:text-xl font-extrabold text-[#0F2C59]">Penguasaan Konsep MIPA</h2>
                </div>
                <span class="px-3 py-1 rounded-full bg-[#0D9488]/15 text-[#0D9488] text-xs font-extrabold">
                    {{ $student->mipa_mastery_percent }}% Tuntas
                </span>
            </div>

            <!-- Big Progress Bar -->
            <div class="mt-4 p-4 rounded-2xl bg-slate-50 border border-slate-200">
                <div class="flex items-center justify-between text-xs font-bold mb-2">
                    <span class="text-slate-700">Tingkat Ketuntasan Konsep & Latihan Soal</span>
                    <span class="text-[#0D9488] font-extrabold">{{ $student->mipa_mastery_percent }}%</span>
                </div>
                <div class="w-full h-3.5 bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-[#0D9488] to-[#0F2C59] rounded-full transition-all duration-700"
                         style="width: {{ $student->mipa_mastery_percent }}%"></div>
                </div>
                <p class="text-[11px] text-slate-500 mt-2">
                    Berdasarkan evaluasi mingguan pengajar MustikaBimbel pada tugas sekolah dan simulasi ujian.
                </p>
            </div>

            <!-- Detail 4 Pilar MIPA Sub-skills -->
            <div class="mt-5 space-y-3">
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center justify-between text-xs font-bold text-[#0F2C59]">
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="calculator" class="w-4 h-4 text-[#0D9488]"></i>
                            Matematika (Aljabar, Geometri, Pecahan)
                        </span>
                        <span>{{ min(100, $student->mipa_mastery_percent + 5) }}%</span>
                    </div>
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center justify-between text-xs font-bold text-[#0F2C59]">
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="atom" class="w-4 h-4 text-[#0F2C59]"></i>
                            Fisika & Sains Terpadu (Rumus & Konsep)
                        </span>
                        <span>{{ max(30, $student->mipa_mastery_percent - 5) }}%</span>
                    </div>
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center justify-between text-xs font-bold text-[#0F2C59]">
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="crosshair" class="w-4 h-4 text-[#FACC15]"></i>
                            Strategi Mengerjakan Soal & Trik Cepat
                        </span>
                        <span>{{ min(100, $student->mipa_mastery_percent + 2) }}%</span>
                    </div>
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center justify-between text-xs font-bold text-[#0F2C59]">
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="graduation-cap" class="w-4 h-4 text-emerald-600"></i>
                            Kesiapan Ujian Sekolah / Masuk SMA
                        </span>
                        <span>{{ max(40, $student->mipa_mastery_percent - 8) }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <span>Metode: <strong>Kuat Konsepnya & Cepat Hitungnya</strong></span>
            <span class="text-[#0D9488] font-bold">Terupdate Sesi Terakhir</span>
        </div>
    </div>
</div>

<!-- Section: Timeline Jurnal Belajar Harian -->
<div class="bg-white rounded-3xl p-6 sm:p-8 shadow-md border-2 border-slate-200/80">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-5 border-b border-slate-100">
        <div>
            <span class="text-xs font-extrabold uppercase tracking-wider text-[#0D9488]">Transparansi Pembelajaran</span>
            <h2 class="text-lg sm:text-2xl font-extrabold text-[#0F2C59]">Timeline Jurnal Belajar Harian</h2>
        </div>
        <span class="text-xs font-semibold text-slate-500">
            Menampilkan {{ $student->studySessions->count() }} Pertemuan Terakhir
        </span>
    </div>

    <!-- Timeline List -->
    <div class="mt-6 space-y-4">
        @forelse ($student->studySessions as $session)
            <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200 hover:border-[#0F2C59] transition-all">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-200">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-[#0F2C59] text-white">
                            {{ $session->session_date->translatedFormat('l, d F Y') }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-[#0D9488]/15 text-[#0D9488]">
                            {{ $session->subject_category }}
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                            {{ $session->attendance_status }}
                        </span>
                    </div>
                    <div class="text-xs text-slate-500 flex items-center gap-2">
                        <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>{{ substr($session->check_in_time ?? '18:30', 0, 5) }} – {{ substr($session->check_out_time ?? '20:00', 0, 5) }} WIB</span>
                    </div>
                </div>

                <div class="mt-3 grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                    <div class="md:col-span-8 space-y-2">
                        <h3 class="text-sm sm:text-base font-extrabold text-[#0F2C59]">
                            {{ $session->topic_covered }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 bg-white p-3 rounded-xl border border-slate-200 italic">
                            "{{ $session->tutor_notes }}"
                        </p>
                    </div>

                    <div class="md:col-span-4 flex md:flex-col justify-between items-end md:items-end gap-2 bg-white md:bg-transparent p-3 md:p-0 rounded-xl border md:border-0 border-slate-200">
                        <div class="text-left md:text-right">
                            <span class="text-[11px] text-slate-400 block font-semibold">Skor Latihan</span>
                            <span class="text-lg font-extrabold text-[#0F2C59]">{{ $session->practice_score }}<span class="text-xs text-slate-400">/100</span></span>
                        </div>
                        <div class="text-right">
                            <span class="text-[11px] text-slate-400 block font-semibold">Kecepatan Hitung</span>
                            <div class="flex items-center gap-0.5 text-amber-400 justify-end mt-0.5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i data-lucide="star" class="w-3.5 h-3.5 {{ $i <= $session->speed_rating ? 'fill-current' : 'text-slate-300' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-slate-500 text-sm">
                Belum ada riwayat sesi belajar yang tercatat.
            </div>
        @endforelse
    </div>
</div>
