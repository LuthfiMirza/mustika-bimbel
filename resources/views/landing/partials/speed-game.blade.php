<!-- Fitur Interaktif 1: Mini-Game "Tantangan Hitung Cepat 30 Detik" (Alpine.js) -->
<section id="tantangan-30-detik" class="py-16 sm:py-20 bg-[#F8FAFC] border-b border-slate-200/80"
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
        <div class="bg-[#0F2C59] rounded-3xl p-6 sm:p-10 text-white shadow-2xl border-4 border-[#FACC15] relative overflow-hidden">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-8 border-b border-white/15">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FACC15] text-[#0F2C59] text-xs font-extrabold uppercase tracking-wider">
                        <i data-lucide="Flame" class="w-3.5 h-3.5"></i>
                        Interactive Mini-Game
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold mt-2">
                        Tantangan Hitung Cepat 30 Detik!
                    </h2>
                    <p class="text-sm text-slate-300 mt-1">
                        Uji kecepatan berhitung ananda sekarang. Skor otomatis tersimpan untuk klaim Kelas Coba Gratis!
                    </p>
                </div>

                <!-- Mode Selector -->
                <div class="flex bg-[#091C3A] p-1.5 rounded-2xl border border-white/15 self-start">
                    <button type="button"
                            @click="mode = 'jarimatika'; state = 'idle'"
                            :class="mode === 'jarimatika' ? 'bg-[#FACC15] text-[#0F2C59] font-extrabold shadow' : 'text-slate-300 hover:text-white font-semibold'"
                            class="px-4 py-2.5 rounded-xl text-xs sm:text-sm transition-all">
                        🖐️ Level TK / SD (Jarimatika)
                    </button>
                    <button type="button"
                            @click="mode = 'mipa'; state = 'idle'"
                            :class="mode === 'mipa' ? 'bg-[#FACC15] text-[#0F2C59] font-extrabold shadow' : 'text-slate-300 hover:text-white font-semibold'"
                            class="px-4 py-2.5 rounded-xl text-xs sm:text-sm transition-all">
                        🚀 Level SD Atas / SMP (MIPA)
                    </button>
                </div>
            </div>

            <!-- State 1: Idle / Start Screen -->
            <div x-show="state === 'idle'" class="py-10 text-center space-y-6">
                <div class="max-w-xl mx-auto bg-white/5 border border-white/15 rounded-2xl p-6">
                    <p class="text-sm text-[#FACC15] font-bold uppercase tracking-wider"
                       x-text="mode === 'jarimatika' ? 'Mode Terpilih: Jarimatika Tambah, Kurang & Kali Dasar (TK - SD)' : 'Mode Terpilih: Hitung Cepat Kali, Aljabar & Fisika Dasar (SD - SMP)'"></p>
                    <p class="text-slate-200 text-sm mt-2">
                        Terdapat <strong>5 soal berurutan</strong> dengan batas waktu total <strong>30 detik</strong>. Di akhir permainan, ananda juga akan melihat rahasia <em>Trik Cepat MustikaBimbel</em>!
                    </p>
                </div>
                <button type="button" @click="startGame()"
                        class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl text-base sm:text-lg font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-xl hover:scale-105 transition-all">
                    <i data-lucide="play" class="w-5 h-5 fill-current"></i>
                    Mulai Tantangan 30 Detik Sekarang!
                </button>
            </div>

            <!-- State 2: Playing Screen -->
            <div x-show="state === 'playing'" x-cloak class="py-8 space-y-6">
                <div class="flex items-center justify-between bg-[#091C3A] px-5 py-3 rounded-2xl border border-white/10">
                    <div class="flex items-center gap-2 text-sm font-bold">
                        <span class="px-3 py-1 rounded-lg bg-white/10 text-[#FACC15]">
                            Soal <span x-text="currentIndex + 1"></span> / 5
                        </span>
                        <span class="hidden sm:inline text-slate-300">Pilih jawaban yang paling tepat!</span>
                    </div>
                    <div class="flex items-center gap-2 text-lg font-extrabold"
                         :class="timeLeft <= 10 ? 'text-rose-400 animate-pulse' : 'text-[#FACC15]'">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                        <span x-text="timeLeft + ' Detik'"></span>
                    </div>
                </div>

                <!-- Question Card -->
                <div class="bg-white text-[#0F2C59] rounded-3xl p-6 sm:p-8 text-center shadow-inner">
                    <span class="text-xs font-extrabold uppercase tracking-widest text-[#0D9488]">Pertanyaan Hitung Cepat</span>
                    <div class="text-2xl sm:text-4xl font-extrabold my-4" x-text="currentQuestion.q"></div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mt-6 max-w-2xl mx-auto">
                        <template x-for="opt in currentQuestion.options" :key="opt">
                            <button type="button"
                                    @click="answerQuestion(opt)"
                                    class="py-4 px-5 rounded-2xl text-xl sm:text-2xl font-extrabold bg-slate-100 hover:bg-[#FACC15] text-[#0F2C59] border-2 border-slate-200 hover:border-[#0F2C59] transition-all shadow-sm hover:-translate-y-0.5"
                                    x-text="opt"></button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- State 3: Finished Screen -->
            <div x-show="state === 'finished'" x-cloak class="py-8 space-y-6">
                <div class="bg-white text-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6 border-b border-slate-200 pb-6">
                        <div class="text-center md:text-left">
                            <span class="inline-block px-3 py-1 rounded-full bg-[#0D9488]/15 text-[#0D9488] text-xs font-extrabold uppercase">
                                Hasil Tantangan Selesai!
                            </span>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-[#0F2C59] mt-2"
                                x-text="score >= 80 ? 'Luar Biasa! Bakat MIPA Sangat Kuat 🌟' : 'Bagus! Yuk Tingkatkan Lagi dengan Jarimatika & Trik Cepat 🚀'"></h3>
                            <p class="text-sm text-slate-600 mt-1">
                                Dengan latihan terarah di MustikaBimbel, soal seperti di atas bisa diselesaikan di bawah 3 detik/soal!
                            </p>
                        </div>

                        <div class="flex items-center gap-4 shrink-0">
                            <div class="bg-[#0F2C59] text-white px-5 py-4 rounded-2xl text-center">
                                <span class="text-xs text-slate-300 block">Skor Akhir</span>
                                <span class="text-3xl font-extrabold text-[#FACC15]" x-text="score + '/100'"></span>
                            </div>
                            <div class="bg-slate-100 text-[#0F2C59] px-5 py-4 rounded-2xl text-center border border-slate-200">
                                <span class="text-xs text-slate-500 block">Kecepatan</span>
                                <span class="text-2xl font-extrabold" x-text="avgTime + ' dtk/soal'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Kunci & Trik Cepat MustikaBimbel -->
                    <div class="mt-5">
                        <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-3">
                            💡 Rahasia Trik Cepat MustikaBimbel untuk Soal Tadi:
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                            <template x-for="(item, idx) in currentQuestions.slice(0, 2)" :key="idx">
                                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                                    <span class="font-extrabold text-[#0F2C59]" x-text="item.q + ' (Jawab: ' + item.answer + ')'"></span>
                                    <p class="text-slate-600 mt-1" x-text="item.tip"></p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <button type="button" @click="startGame()"
                                class="w-full sm:w-auto px-5 py-3 rounded-xl text-sm font-bold text-[#0F2C59] bg-slate-100 hover:bg-slate-200 transition-colors">
                            🔄 Main Lagi
                        </button>
                        <button type="button"
                                @click="applyGameResult(score, avgTime, mode)"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl text-sm sm:text-base font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-lg transition-all">
                            <span>Simpan Skor &amp; Klaim Kelas Coba Gratis</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
