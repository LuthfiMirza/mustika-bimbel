<!-- 5.7 METODE & KURIKULUM (#metode-kurikulum) — Neo-Brutalist Comparison & Catalog -->
<section id="metode-kurikulum" class="py-16 sm:py-24 bg-paper bg-dots relative overflow-hidden"
    x-data="{
        activeVisualizer: 'jarimatika_kali',
        activeGradeTab: 'SMP'
    }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">

        <!-- Bagian A: Cara Biasa vs Trik MustikaBimbel -->
        <div>
            <div class="text-center max-w-4xl mx-auto mb-10 reveal" x-intersect.once="$el.classList.add('is-in')">
                <span class="sticker sticker--gold mb-4" style="--tilt: -2deg;">
                    Simulasi Perbandingan Metode
                </span>
                <h2 class="font-display-hero text-[34px] sm:text-[54px] lg:text-[72px] text-ink">
                    <span class="block">CARA BIASA VS</span>
                    <span class="block mt-2">
                        TRIK
                        <span class="sticker-headline text-[0.8em]" style="--tilt: -2deg;">3 DETIK</span>
                    </span>
                </h2>
                <p class="mt-4 text-slate-600 text-sm sm:text-base max-w-2xl mx-auto">
                    Klik contoh soal di bawah ini untuk melihat bagaimana siswa MustikaBimbel menyelesaikan soal sulit hanya dalam <strong>3 detik</strong>!
                </p>
            </div>

            <!-- Pill Toggles -->
            <div class="flex flex-wrap justify-center gap-3 mb-8">
                <button type="button" @click="activeVisualizer = 'jarimatika_kali'"
                        :class="activeVisualizer === 'jarimatika_kali' ? 'bg-navy text-gold shadow-[3px_3px_0_#111]' : 'bg-cream text-ink hover:bg-lime'"
                        class="px-5 py-2.5 rounded-full border-2 border-ink font-label text-xs font-bold uppercase tracking-wide transition-all">
                    🖐️ Contoh 1: Jarimatika 8 × 7 (TK/SD)
                </button>
                <button type="button" @click="activeVisualizer = 'aljabar_cepat'"
                        :class="activeVisualizer === 'aljabar_cepat' ? 'bg-navy text-gold shadow-[3px_3px_0_#111]' : 'bg-cream text-ink hover:bg-lime'"
                        class="px-5 py-2.5 rounded-full border-2 border-ink font-label text-xs font-bold uppercase tracking-wide transition-all">
                    📐 Contoh 2: 98² - 97² (SMP)
                </button>
                <button type="button" @click="activeVisualizer = 'fisika_perbandingan'"
                        :class="activeVisualizer === 'fisika_perbandingan' ? 'bg-navy text-gold shadow-[3px_3px_0_#111]' : 'bg-cream text-ink hover:bg-lime'"
                        class="px-5 py-2.5 rounded-full border-2 border-ink font-label text-xs font-bold uppercase tracking-wide transition-all">
                    ⚡ Contoh 3: Fisika Gaya &amp; Percepatan (SMP)
                </button>
            </div>

            <!-- Comparison Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
                <!-- Left: Cara Lama (Dashed) -->
                <div class="rounded-[24px] p-6 sm:p-8 bg-slate-100 border-[3px] border-dashed border-ink/45 flex flex-col justify-between">
                    <div>
                        <div class="flex flex-wrap items-center justify-between gap-2 pb-4 border-b-2 border-dashed border-ink/20">
                            <span class="inline-flex items-center gap-1.5 font-label text-xs font-bold uppercase tracking-wider text-ink">
                                <i data-lucide="hourglass" class="w-4 h-4 text-tomato"></i>
                                Cara Biasa yang Lama
                            </span>
                            <span class="sticker sticker--tomato" style="--tilt: 2deg;">
                                CARA LAMA ⏱ 35–60 DTK
                            </span>
                        </div>

                        <div x-show="activeVisualizer === 'jarimatika_kali'" x-transition:enter="tx-enter" x-transition:enter-start="tx-from" x-transition:enter-end="tx-to" class="mt-5 space-y-3 text-sm text-slate-700">
                            <p class="font-bold text-ink">Soal: Hitung hasil dari 8 × 7</p>
                            <ol class="list-decimal list-inside space-y-2 text-xs sm:text-sm">
                                <li>Anak mencoba menghafal urutan perkalian 8 dari awal (8×1, 8×2, 8×3...).</li>
                                <li>Atau menjumlahkan berulang: 8 + 8 + 8 + 8 + 8 + 8 + 8 secara manual.</li>
                                <li>Rawan lupa atau selisih hitung 1 angka ketika grogi saat ujian.</li>
                            </ol>
                        </div>

                        <div x-show="activeVisualizer === 'aljabar_cepat'" x-transition:enter="tx-enter" x-transition:enter-start="tx-from" x-transition:enter-end="tx-to" x-cloak class="mt-5 space-y-3 text-sm text-slate-700">
                            <p class="font-bold text-ink">Soal: Hitung nilai dari 98² - 97²</p>
                            <ol class="list-decimal list-inside space-y-2 text-xs sm:text-sm">
                                <li>Menghitung perkalian bersusun 98 × 98 = 9.604.</li>
                                <li>Menghitung perkalian bersusun 97 × 97 = 9.409.</li>
                                <li>Mengurangkan 9.604 - 9.409 = 195 (Memakan banyak waktu &amp; kertas coretan).</li>
                            </ol>
                        </div>

                        <div x-show="activeVisualizer === 'fisika_perbandingan'" x-transition:enter="tx-enter" x-transition:enter-start="tx-from" x-transition:enter-end="tx-to" x-cloak class="mt-5 space-y-3 text-sm text-slate-700">
                            <p class="font-bold text-ink">Soal: Gaya F diperbesar 3 kali dan massa benda m dijadikan setengahnya. Berapa percepatan akhirnya?</p>
                            <ol class="list-decimal list-inside space-y-2 text-xs sm:text-sm">
                                <li>Menulis ulang rumus panjang F₁/m₁ dan F₂/m₂ dengan banyak variabel.</li>
                                <li>Sering terbalik saat membagi pecahan 3 dibagi 1/2 menjadi 3/2.</li>
                            </ol>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t-2 border-dashed border-ink/20 text-xs text-tomato font-bold">
                        ⚠️ Risiko: Anak cepat lelah, kehabisan waktu ujian, dan kurang percaya diri.
                    </div>
                </div>

                <!-- Right: Trik MustikaBimbel (Gold + Hard Shadow) -->
                <div class="rounded-[24px] p-6 sm:p-8 bg-gold text-ink border-[3px] border-ink hard-shadow-lg flex flex-col justify-between">
                    <div>
                        <div class="flex flex-wrap items-center justify-between gap-2 pb-4 border-b-2 border-ink/20">
                            <span class="inline-flex items-center gap-1.5 font-label text-xs font-bold uppercase tracking-wider text-ink">
                                <i data-lucide="sparkles" class="w-4 h-4"></i>
                                Metode MustikaBimbel
                            </span>
                            <span class="sticker sticker--ink text-lime" style="--tilt: -2deg;">
                                ⚡ 3 DETIK!
                            </span>
                        </div>

                        <div x-show="activeVisualizer === 'jarimatika_kali'" x-transition:enter="tx-enter" x-transition:enter-start="tx-from" x-transition:enter-end="tx-to" class="mt-5 space-y-3 text-sm">
                            <p class="font-display text-lg text-ink">Soal: 8 × 7 dengan Jarimatika</p>
                            <ul class="space-y-2 text-xs sm:text-sm text-ink font-medium">
                                <li>🖐️ <strong>Tangan Kiri (8):</strong> Buka 3 jari berdiri (6, 7, 8), 2 jari tertutup.</li>
                                <li>🖐️ <strong>Tangan Kanan (7):</strong> Buka 2 jari berdiri (6, 7), 3 jari tertutup.</li>
                                <li>✨ <strong>Jari Berdiri = Puluhan:</strong> (3 + 2) = <strong>50</strong>.</li>
                                <li>✨ <strong>Jari Tertutup = Dikali:</strong> (2 × 3) = <strong>6</strong>. Hasil = <strong>56</strong>!</li>
                            </ul>
                        </div>

                        <div x-show="activeVisualizer === 'aljabar_cepat'" x-transition:enter="tx-enter" x-transition:enter-start="tx-from" x-transition:enter-end="tx-to" x-cloak class="mt-5 space-y-3 text-sm">
                            <p class="font-display text-lg text-ink">Soal: 98² - 97² dengan Konsep Selisih Kuadrat</p>
                            <ul class="space-y-2 text-xs sm:text-sm text-ink font-medium">
                                <li>🧠 <strong>Pahami Pola Konsep:</strong> a² - b² = (a + b)(a - b).</li>
                                <li>⚡ Karena selisih (98 - 97) = 1, cukup jumlahkan kedua angkanya saja!</li>
                                <li>✨ <strong>98 + 97 = 195</strong>. Tanpa perkalian bersusun sama sekali!</li>
                            </ul>
                        </div>

                        <div x-show="activeVisualizer === 'fisika_perbandingan'" x-transition:enter="tx-enter" x-transition:enter-start="tx-from" x-transition:enter-end="tx-to" x-cloak class="mt-5 space-y-3 text-sm">
                            <p class="font-display text-lg text-ink">Soal: Percepatan a = F / m dengan Penalaran Konsep</p>
                            <ul class="space-y-2 text-xs sm:text-sm text-ink font-medium">
                                <li>🧠 <strong>Analisis Pola:</strong> Percepatan (a) lurus dengan Gaya (F) dan terbalik dengan Massa (m).</li>
                                <li>⚡ Langsung masukkan faktor pengubahnya: a' = 3 ÷ (1/2) = 3 × 2 = <strong>6 kali semula</strong>!</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t-2 border-ink/20 text-xs font-extrabold text-navy">
                        ✅ Paham Konsepnya &bull; Cepat Hitungnya &bull; Tepat Jawabannya!
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian B: Katalog Program & Materi Unggulan -->
        <div>
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="sticker sticker--lime mb-4" style="--tilt: 1.5deg;">
                    Kurikulum Terstruktur Sesuai Jenjang
                </span>
                <h2 class="font-display-hero text-[32px] sm:text-[48px] text-ink">
                    KATALOG MATERI UNGGULAN
                </h2>
                <p class="mt-3 text-slate-600 text-sm sm:text-base">
                    Pilih jenjang pendidikan putra/putri Anda untuk melihat rincian materi yang dipelajari di MustikaBimbel.
                </p>
            </div>

            <!-- 3 Big Pill Grade Tabs -->
            <div class="flex flex-wrap justify-center gap-3 mb-10">
                <button type="button" @click="activeGradeTab = 'TK'"
                        :class="activeGradeTab === 'TK' ? 'bg-gold text-ink shadow-[4px_4px_0_#111]' : 'bg-cream text-ink hover:bg-lime'"
                        class="px-6 py-3.5 rounded-full border-[3px] border-ink font-display text-xs sm:text-sm uppercase transition-all">
                    🖐️ TK &amp; SD Awal (Jarimatika)
                </button>
                <button type="button" @click="activeGradeTab = 'SD'"
                        :class="activeGradeTab === 'SD' ? 'bg-gold text-ink shadow-[4px_4px_0_#111]' : 'bg-cream text-ink hover:bg-lime'"
                        class="px-6 py-3.5 rounded-full border-[3px] border-ink font-display text-xs sm:text-sm uppercase transition-all">
                    📘 Jenjang SD (Kelas 1 – 6)
                </button>
                <button type="button" @click="activeGradeTab = 'SMP'"
                        :class="activeGradeTab === 'SMP' ? 'bg-gold text-ink shadow-[4px_4px_0_#111]' : 'bg-cream text-ink hover:bg-lime'"
                        class="px-6 py-3.5 rounded-full border-[3px] border-ink font-display text-xs sm:text-sm uppercase transition-all">
                    🔬 Jenjang SMP (Kelas 7 – 9)
                </button>
            </div>

            <!-- Tab Content 1: TK -->
            <div x-show="activeGradeTab === 'TK'" x-transition:enter="tx-enter" x-transition:enter-start="tx-from" x-transition:enter-end="tx-to" x-cloak class="bg-cream rounded-[28px] p-6 sm:p-10 border-[3px] border-ink hard-shadow">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                    <div class="lg:col-span-1 bg-navy text-white rounded-2xl border-2 border-ink p-6 space-y-4">
                        <span class="sticker sticker--gold" style="--tilt: -2deg;">Usia 4 – 8 Tahun</span>
                        <h3 class="font-display text-2xl text-gold">Jarimatika &amp; Fondasi Berhitung</h3>
                        <p class="text-xs sm:text-sm text-slate-200 leading-relaxed">
                            Membangun kecintaan anak terhadap angka sejak dini dengan metode visual dan gerakan jari yang menyenangkan.
                        </p>
                        <div class="pt-2">
                            <a href="#form-trial" @click="selectedGrade = 'TK'" class="btn-pop btn-pop--sm">
                                <span class="btn-roll">
                                    <span>Daftar Trial TK/SD</span>
                                    <span aria-hidden="true">Daftar Trial TK/SD</span>
                                </span>
                                <span class="btn-pop__dot"><i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-paper p-5 rounded-2xl border-2 border-ink shadow-[3px_3px_0_#111]">
                            <h4 class="font-display text-base text-ink mb-2">★ Konsep Bilangan Visual</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Pengenalan nilai tempat satuan dan puluhan secara konkret sehingga anak paham arti angka.</p>
                        </div>
                        <div class="bg-paper p-5 rounded-2xl border-2 border-ink shadow-[3px_3px_0_#111]">
                            <h4 class="font-display text-base text-ink mb-2">★ Jarimatika Tambah &amp; Kurang</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Berhitung cepat penjumlahan dan pengurangan puluhan memakai formasi jari tanpa sempoa.</p>
                        </div>
                        <div class="bg-paper p-5 rounded-2xl border-2 border-ink shadow-[3px_3px_0_#111]">
                            <h4 class="font-display text-base text-ink mb-2">★ Jarimatika Kali &amp; Bagi Dasar</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Transisi menyenangkan menuju perkalian dan pembagian menggunakan jari tangan.</p>
                        </div>
                        <div class="bg-paper p-5 rounded-2xl border-2 border-ink shadow-[3px_3px_0_#111]">
                            <h4 class="font-display text-base text-ink mb-2">★ Fokus &amp; Kepercayaan Diri</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Melatih koordinasi otak kanan-kiri, motorik halus, dan keberanian anak di kelas.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content 2: SD -->
            <div x-show="activeGradeTab === 'SD'" x-transition:enter="tx-enter" x-transition:enter-start="tx-from" x-transition:enter-end="tx-to" x-cloak class="bg-cream rounded-[28px] p-6 sm:p-10 border-[3px] border-ink hard-shadow">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                    <div class="lg:col-span-1 bg-navy text-white rounded-2xl border-2 border-ink p-6 space-y-4">
                        <span class="sticker sticker--lime" style="--tilt: -2deg;">SD Kelas 1 – 6</span>
                        <h3 class="font-display text-2xl text-gold">Matematika &amp; Sains Dasar (MIPA SD)</h3>
                        <p class="text-xs sm:text-sm text-slate-200 leading-relaxed">
                            Mendampingi ketuntasan materi sekolah sekaligus mengasah kecepatan berhitung dan pemecahan soal cerita.
                        </p>
                        <div class="pt-2">
                            <a href="#form-trial" @click="selectedGrade = 'SD'" class="btn-pop btn-pop--sm">
                                <span class="btn-roll">
                                    <span>Daftar Trial SD</span>
                                    <span aria-hidden="true">Daftar Trial SD</span>
                                </span>
                                <span class="btn-pop__dot"><i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-paper p-5 rounded-2xl border-2 border-ink shadow-[3px_3px_0_#111]">
                            <h4 class="font-display text-base text-ink mb-2">★ Matematika &amp; Pecahan</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Konsep dasar &amp; operasi hitung bilangan bulat, KPK/FPB, pecahan, desimal, dan perbandingan.</p>
                        </div>
                        <div class="bg-paper p-5 rounded-2xl border-2 border-ink shadow-[3px_3px_0_#111]">
                            <h4 class="font-display text-base text-ink mb-2">★ Bangun Datar &amp; Geometri</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Pemahaman visual keliling, luas bangun datar gabungan, serta volume bangun ruang dasar.</p>
                        </div>
                        <div class="bg-paper p-5 rounded-2xl border-2 border-ink shadow-[3px_3px_0_#111]">
                            <h4 class="font-display text-base text-ink mb-2">★ Trik Berhitung Cepat</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Kombinasi Jarimatika lanjutan dan metode penyederhanaan angka agar tidak kehabisan waktu ulangan.</p>
                        </div>
                        <div class="bg-paper p-5 rounded-2xl border-2 border-ink shadow-[3px_3px_0_#111]">
                            <h4 class="font-display text-base text-ink mb-2">★ IPA Dasar &amp; Soal Cerita</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Pengenalan konsep sains alam dan latihan menerjemahkan soal cerita menjadi langkah yang rapi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content 3: SMP -->
            <div x-show="activeGradeTab === 'SMP'" x-transition:enter="tx-enter" x-transition:enter-start="tx-from" x-transition:enter-end="tx-to" class="bg-cream rounded-[28px] p-6 sm:p-10 border-[3px] border-ink hard-shadow">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div class="bg-paper rounded-2xl p-6 border-2 border-ink shadow-[4px_4px_0_#111]">
                        <div class="w-11 h-11 rounded-xl bg-gold border-2 border-ink text-ink flex items-center justify-center mb-4">
                            <i data-lucide="calculator" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-display text-lg text-ink mb-3">Matematika</h3>
                        <ul class="space-y-2 text-xs sm:text-sm text-slate-700">
                            <li>★ Konsep dasar &amp; operasi hitung</li>
                            <li>★ Aljabar, persamaan, perbandingan</li>
                            <li>★ Geometri</li>
                            <li>★ Trik berhitung cepat</li>
                        </ul>
                    </div>

                    <div class="bg-paper rounded-2xl p-6 border-2 border-ink shadow-[4px_4px_0_#111]">
                        <div class="w-11 h-11 rounded-xl bg-lime border-2 border-ink text-ink flex items-center justify-center mb-4">
                            <i data-lucide="flask-conical" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-display text-lg text-ink mb-3">IPA (Sains Terpadu)</h3>
                        <ul class="space-y-2 text-xs sm:text-sm text-slate-700">
                            <li>★ <strong>Fisika</strong> (rumus &amp; analisis soal)</li>
                            <li>★ <strong>Kimia</strong> (perhitungan &amp; konsep)</li>
                            <li>★ <strong>Biologi</strong> (konsep &amp; penerapan)</li>
                        </ul>
                    </div>

                    <div class="bg-paper rounded-2xl p-6 border-2 border-ink shadow-[4px_4px_0_#111]">
                        <div class="w-11 h-11 rounded-xl bg-navy border-2 border-ink text-gold flex items-center justify-center mb-4">
                            <i data-lucide="target" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-display text-lg text-ink mb-3">Strategi Soal</h3>
                        <ul class="space-y-2 text-xs sm:text-sm text-slate-700">
                            <li>★ Mengenali pola soal</li>
                            <li>★ Memilih rumus yang tepat</li>
                            <li>★ Menghindari kesalahan hitung</li>
                            <li>★ Metode penyelesaian efisien</li>
                        </ul>
                    </div>

                    <div class="bg-paper rounded-2xl p-6 border-2 border-ink shadow-[4px_4px_0_#111] flex flex-col justify-between">
                        <div>
                            <div class="w-11 h-11 rounded-xl bg-tomato border-2 border-ink text-white flex items-center justify-center mb-4">
                                <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                            </div>
                            <h3 class="font-display text-lg text-ink mb-3">Persiapan Ujian</h3>
                            <ul class="space-y-2 text-xs sm:text-sm text-slate-700">
                                <li>★ Latihan bertahap (dasar–menantang)</li>
                                <li>★ Persiapan ujian sekolah &amp; seleksi SMA</li>
                            </ul>
                        </div>
                        <div class="mt-5 pt-4 border-t-2 border-ink/10">
                            <a href="#form-trial" @click="selectedGrade = 'SMP'" class="btn-pop btn-pop--sm w-full">
                                <span class="btn-roll">
                                    <span>Daftar SMP</span>
                                    <span aria-hidden="true">Daftar SMP</span>
                                </span>
                                <span class="btn-pop__dot"><i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
