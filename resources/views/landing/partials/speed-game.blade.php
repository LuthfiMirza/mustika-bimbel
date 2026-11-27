<!-- 5.5 TANTANGAN 30 DETIK (#tantangan-30-detik) — Neo-Brutalist Game Console -->
<section id="tantangan-30-detik" class="py-16 sm:py-24 bg-cream bg-dots relative overflow-hidden"
    x-data="{
        mode: 'jarimatika',
        state: 'idle',
        timeLeft: 30,
        timerRef: null,
        currentIndex: 0,
        score: 0,
        startTime: 0,
        elapsedSeconds: 0,
        avgTime: 0,
        questionSets: {
            jarimatika: [
                { q: '7 + 8 = ...', options: [13, 14, 15, 16], answer: 15, tip: 'Jarimatika Teman Kecil: buka 7 jari, tambah 8 = buka puluhan kiri +1, tutup 2 jari kanan = 15!' },
                { q: '14 - 6 = ...', options: [6, 7, 8, 9], answer: 8, tip: 'Jarimatika Kurang: dari 14, tutup 10 di tangan kiri lalu buka teman besar 4 di kanan = 8!' },
                { q: '9 + 6 + 4 = ...', options: [17, 18, 19, 20], answer: 19, tip: 'Pasangkan 6 + 4 = 10 terlebih dahulu, lalu tambahkan 9 = 19 dalam 1 detik!' },
                { q: '18 - 9 + 5 = ...', options: [12, 13, 14, 15], answer: 14, tip: '18 - 9 = 9 di jari tangan kanan, tambah 5 langsung = 14!' },
                { q: '8 × 7 = ...', options: [54, 56, 58, 64], answer: 56, tip: 'Jarimatika Perkalian: tangan kiri buka 3 jari (8), kanan buka 2 jari (7). Puluhan (3+2)=50, satuan (2×3)=6 -> 56!' }
            ],
            mipa: [
                { q: '25 × 16 = ...', options: [350, 380, 400, 420], answer: 400, tip: 'Trik Pecah Angka: 25 × (4 × 4) = 100 × 4 = 400 tanpa coretan panjang!' },
                { q: 'Jika 3x + 7 = 22, maka nilai x = ...', options: [3, 4, 5, 6], answer: 5, tip: 'Pindahkan 7: 3x = 15, maka x = 15 ÷ 3 = 5!' },
                { q: '98 × 9 = ...', options: [872, 882, 892, 902], answer: 882, tip: 'Trik Kurang 100: (100 - 2) × 9 = 900 - 18 = 882 selesai dalam 3 detik!' },
                { q: 'Kecepatan mobil 72 km/jam setara dengan ... m/s', options: [15, 20, 25, 30], answer: 20, tip: 'Rumus Cepat Fisika: bagi dengan 3,6 -> 72 ÷ 36 × 10 = 20 m/s!' },
                { q: '15% dari 240 adalah ...', options: [32, 34, 36, 38], answer: 36, tip: '10% dari 240 = 24, ditambah setengahnya (5% = 12) -> 24 + 12 = 36!' }
            ]
        },
        get currentQuestions() {
            return this.questionSets[this.mode];
        },
        get currentQuestion() {
            return this.currentQuestions[this.currentIndex];
        },
        startGame() {
            this.state = 'playing';
            this.timeLeft = 30;
            this.currentIndex = 0;
            this.score = 0;
            this.startTime = Date.now();
            if (this.timerRef) clearInterval(this.timerRef);
            this.timerRef = setInterval(() => {
                if (this.timeLeft > 1) {
                    this.timeLeft--;
                } else {
                    this.timeLeft = 0;
                    this.finishGame();
                }
            }, 1000);
        },
        answerQuestion(choice) {
            if (choice === this.currentQuestion.answer) {
                this.score += 20;
            }
            if (this.currentIndex < this.currentQuestions.length - 1) {
                this.currentIndex++;
            } else {
                this.finishGame();
            }
        },
        finishGame() {
            if (this.timerRef) clearInterval(this.timerRef);
            const totalTime = Math.max(1, (Date.now() - this.startTime) / 1000);
            this.elapsedSeconds = Math.min(30, totalTime).toFixed(1);
            this.avgTime = (this.elapsedSeconds / 5).toFixed(1);
            this.state = 'finished';
        }
    }">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-10 reveal" x-intersect.once="$el.classList.add('is-in')">
            <span class="sticker sticker--lime mb-4" style="--tilt: -2deg;">
                <i data-lucide="flame" class="w-3.5 h-3.5 text-tomato"></i>
                <span>Tantangan Hitung Cepat 30 Detik</span>
            </span>
            <h2 class="font-display-hero text-[36px] sm:text-[56px] lg:text-[74px] text-ink">
                <span class="block">
                    TANTANGAN
                    <span class="sticker-headline sticker-headline--gold text-[0.8em]" style="--tilt: -2.5deg;">30 DETIK</span>
                </span>
                <span class="block mt-2">HITUNG CEPAT</span>
            </h2>
            <p class="mt-4 text-sm sm:text-base text-slate-700 font-medium">
                Uji kecepatan berhitung ananda sekarang. Skor otomatis tersimpan untuk klaim Kelas Coba Gratis!
            </p>
        </div>

        <!-- Console Box -->
        <div class="bg-ink rounded-[28px] border-[3px] border-ink hard-shadow-lg p-3 sm:p-4">
            <div class="bg-cream rounded-[20px] border-2 border-ink p-5 sm:p-8">

                <!-- Top Bar & Mode Selector -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b-2 border-ink/15">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-navy text-gold border-2 border-ink flex items-center justify-center shrink-0">
                            <i data-lucide="gamepad-2" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <span class="font-label text-[11px] font-bold uppercase tracking-wider text-tomato block">Interactive Mini-Game</span>
                            <h3 class="font-display text-lg sm:text-xl text-ink">Pilih Level Tantangan</h3>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <button type="button"
                                @click="mode = 'jarimatika'; state = 'idle'"
                                :class="mode === 'jarimatika' ? 'bg-gold text-ink shadow-[3px_3px_0_#111]' : 'bg-paper text-ink hover:bg-lime'"
                                class="px-4 py-2 rounded-full border-2 border-ink font-label text-xs font-bold uppercase tracking-wide transition-all">
                            🖐️ Level TK / SD (Jarimatika)
                        </button>
                        <button type="button"
                                @click="mode = 'mipa'; state = 'idle'"
                                :class="mode === 'mipa' ? 'bg-gold text-ink shadow-[3px_3px_0_#111]' : 'bg-paper text-ink hover:bg-lime'"
                                class="px-4 py-2 rounded-full border-2 border-ink font-label text-xs font-bold uppercase tracking-wide transition-all">
                            🚀 Level SD Atas / SMP (MIPA)
                        </button>
                    </div>
                </div>

                <!-- State 1: Idle -->
                <div x-show="state === 'idle'" class="py-10 text-center space-y-6">
                    <div class="max-w-xl mx-auto bg-paper border-2 border-ink rounded-2xl p-6 shadow-[4px_4px_0_#111]">
                        <p class="font-label text-xs font-bold uppercase tracking-wider text-navy"
                           x-text="mode === 'jarimatika' ? 'Mode Terpilih: Jarimatika Tambah, Kurang & Kali Dasar (TK - SD)' : 'Mode Terpilih: Hitung Cepat Kali, Aljabar & Fisika Dasar (SD - SMP)'"></p>
                        <p class="text-slate-700 text-sm mt-2">
                            Terdapat <strong>5 soal berurutan</strong> dengan batas waktu total <strong>30 detik</strong>. Di akhir permainan, ananda juga akan melihat rahasia <em>Trik Cepat MustikaBimbel</em>!
                        </p>
                    </div>

                    <button type="button" @click="startGame()" class="btn-pop">
                        <span class="btn-roll">
                            <span>Mulai Tantangan 30 Detik</span>
                            <span aria-hidden="true">Mulai Tantangan 30 Detik</span>
                        </span>
                        <span class="btn-pop__dot"><i data-lucide="play" class="w-4 h-4 fill-current"></i></span>
                    </button>
                </div>

                <!-- State 2: Playing -->
                <div x-show="state === 'playing'" x-cloak class="py-6 space-y-6">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-xs sm:text-sm font-bold">
                            <span class="px-3.5 py-1.5 rounded-full bg-navy text-gold border-2 border-ink font-label uppercase">
                                Soal <span x-text="currentIndex + 1"></span> / 5
                            </span>
                            <div class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-full border-2 border-ink font-display text-base"
                                 :class="timeLeft <= 10 ? 'bg-tomato text-white animate-pulse' : 'bg-gold text-ink'">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                                <span x-text="timeLeft + ' Detik'"></span>
                            </div>
                        </div>
                        <!-- Thick Gold Progress Bar -->
                        <div class="w-full h-4 rounded-full bg-paper border-2 border-ink overflow-hidden">
                            <div class="h-full transition-all duration-500"
                                 :class="timeLeft <= 10 ? 'bg-tomato' : 'bg-gold'"
                                 :style="'width:' + Math.round((timeLeft / 30) * 100) + '%'"></div>
                        </div>
                    </div>

                    <div class="bg-paper rounded-2xl border-[3px] border-ink hard-shadow p-6 sm:p-8 text-center">
                        <span class="font-label text-xs font-bold uppercase tracking-widest text-edu-teal">Pertanyaan Hitung Cepat</span>
                        <div class="font-display text-3xl sm:text-5xl text-ink my-5" x-text="currentQuestion.q"></div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mt-6 max-w-2xl mx-auto">
                            <template x-for="opt in currentQuestion.options" :key="opt">
                                <button type="button"
                                        @click="answerQuestion(opt)"
                                        class="py-4 px-5 rounded-2xl font-display text-2xl sm:text-3xl bg-cream hover:bg-gold text-ink border-[3px] border-ink shadow-[4px_4px_0_#111] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[1px_1px_0_#111] transition-all cursor-pointer"
                                        x-text="opt"></button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- State 3: Finished -->
                <div x-show="state === 'finished'" x-cloak class="py-6 space-y-6">
                    <div class="bg-paper rounded-2xl border-[3px] border-ink hard-shadow p-6 sm:p-8">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-6 border-b-2 border-ink/15 pb-6">
                            <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                                <div class="shrink-0">
                                    <div x-show="score >= 80">
                                        @include('landing.partials._mascot', ['pose' => 'wow', 'size' => 92])
                                    </div>
                                    <div x-show="score < 80">
                                        @include('landing.partials._mascot', ['pose' => 'thumbs', 'size' => 92])
                                    </div>
                                </div>
                                <div>
                                    <span class="sticker sticker--lime mb-2" style="--tilt: -2deg;">
                                        Hasil Tantangan Selesai!
                                    </span>
                                    <h3 class="font-display text-xl sm:text-2xl text-ink mt-1"
                                        x-text="score >= 80 ? 'LUAR BIASA! BAKAT MIPA SANGAT KUAT' : 'BAGUS! YUK TINGKATKAN LAGI'"></h3>
                                    <p class="text-xs sm:text-sm text-slate-600 mt-1">
                                        Dengan latihan terarah di MustikaBimbel, soal seperti di atas bisa diselesaikan di bawah 3 detik/soal!
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 shrink-0">
                                <div class="bg-navy text-white px-5 py-4 rounded-2xl border-2 border-ink shadow-[3px_3px_0_#111] text-center">
                                    <span class="font-label text-[10px] uppercase text-slate-300 block">Skor Akhir</span>
                                    <span class="font-display text-3xl sm:text-4xl text-gold" x-text="score + '/100'"></span>
                                </div>
                                <div class="bg-cream text-ink px-5 py-4 rounded-2xl border-2 border-ink shadow-[3px_3px_0_#111] text-center">
                                    <span class="font-label text-[10px] uppercase text-slate-500 block">Kecepatan</span>
                                    <span class="font-display text-xl sm:text-2xl" x-text="avgTime + ' dtk'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Trik Cepat -->
                        <div class="mt-5">
                            <h4 class="font-label text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">
                                💡 Rahasia Trik Cepat MustikaBimbel untuk Soal Tadi:
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                                <template x-for="(item, idx) in currentQuestions.slice(0, 2)" :key="idx">
                                    <div class="p-4 rounded-xl bg-cream border-2 border-ink">
                                        <span class="font-bold text-ink" x-text="item.q + ' (Jawab: ' + item.answer + ')'"></span>
                                        <p class="text-slate-600 mt-1" x-text="item.tip"></p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-6 pt-5 border-t-2 border-ink/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <button type="button" @click="startGame()"
                                    class="w-full sm:w-auto px-5 py-3 rounded-full border-2 border-ink bg-paper hover:bg-lime font-label text-xs font-bold uppercase text-ink shadow-[3px_3px_0_#111] transition-all">
                                🔄 Main Lagi
                            </button>
                            <button type="button" @click="applyGameResult(score, avgTime, mode)" class="btn-pop w-full sm:w-auto">
                                <span class="btn-roll">
                                    <span>Simpan Skor &amp; Klaim Gratis</span>
                                    <span aria-hidden="true">Simpan Skor &amp; Klaim Gratis</span>
                                </span>
                                <span class="btn-pop__dot"><i data-lucide="arrow-right" class="w-4 h-4"></i></span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
