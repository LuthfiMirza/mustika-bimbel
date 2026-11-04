<!-- Fitur Interaktif 2: Visualizer Metode Jarimatika & Katalog Materi Unggulan -->
<section id="metode-kurikulum" class="py-16 sm:py-24 bg-white border-b border-slate-200/80"
    x-data="{
        activeVisualizer: 'jarimatika_kali',
        activeGradeTab: 'SMP'
    }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">

        <!-- Bagian A: Visualizer Metode Jarimatika & Strategi Soal -->
        <div>
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="inline-block px-3.5 py-1 rounded-full bg-[#0D9488]/10 text-[#0D9488] text-xs font-extrabold uppercase tracking-wider mb-3">
                    Simulasi Perbandingan Metode
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-[#0F2C59] tracking-tight">
                    Cara Biasa yang Lama vs <span class="text-[#0D9488]">Trik Cepat MustikaBimbel</span>
                </h2>
                <p class="mt-3 text-slate-600 text-sm sm:text-base">
                    Klik tab contoh soal di bawah ini untuk melihat bagaimana siswa MustikaBimbel menyelesaikan soal sulit hanya dalam <strong>3 detik</strong>!
                </p>
            </div>

            <!-- Visualizer Selector Buttons -->
            <div class="flex flex-wrap justify-center gap-3 mb-8">
                <button type="button" @click="activeVisualizer = 'jarimatika_kali'"
                        :class="activeVisualizer === 'jarimatika_kali' ? 'bg-[#0F2C59] text-[#FACC15] border-[#0F2C59] shadow-md' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200'"
                        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold border transition-all">
                    🖐️ Contoh 1: Jarimatika 8 × 7 (TK/SD)
                </button>
                <button type="button" @click="activeVisualizer = 'aljabar_cepat'"
                        :class="activeVisualizer === 'aljabar_cepat' ? 'bg-[#0F2C59] text-[#FACC15] border-[#0F2C59] shadow-md' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200'"
                        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold border transition-all">
                    📐 Contoh 2: Kuadrat &amp; Aljabar 98² - 97² (SMP)
                </button>
                <button type="button" @click="activeVisualizer = 'fisika_perbandingan'"
                        :class="activeVisualizer === 'fisika_perbandingan' ? 'bg-[#0F2C59] text-[#FACC15] border-[#0F2C59] shadow-md' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200'"
                        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold border transition-all">
                    ⚡ Contoh 3: Analisis Soal Fisika Gaya &amp; Percepatan (SMP)
                </button>
            </div>

            <!-- Comparison Cards Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
                <!-- Left: Cara Biasa yang Lama -->
                <div class="rounded-3xl p-6 sm:p-8 bg-rose-50/70 border-2 border-rose-200 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 pb-4 border-b border-rose-200">
                            <span class="inline-flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-wider text-rose-700">
                                <i data-lucide="hourglass" class="w-4 h-4"></i>
                                Cara Biasa yang Lama
                            </span>
                            <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-800 text-xs font-bold">
                                ⏱️ Waktu: 35 – 60 Detik
                            </span>
                        </div>

                        <div x-show="activeVisualizer === 'jarimatika_kali'" class="mt-5 space-y-3 text-sm text-slate-700">
                            <p class="font-bold text-slate-900">Soal: Hitung hasil dari 8 × 7</p>
                            <ol class="list-decimal list-inside space-y-2 text-xs sm:text-sm">
                                <li>Anak mencoba menghafal urutan perkalian 8 dari awal (8×1, 8×2, 8×3...).</li>
                                <li>Atau menjumlahkan berulang: 8 + 8 + 8 + 8 + 8 + 8 + 8 secara manual.</li>
                                <li>Rawan lupa atau selisih hitung 1 angka ketika grogi saat ujian.</li>
                            </ol>
                        </div>

                        <div x-show="activeVisualizer === 'aljabar_cepat'" x-cloak class="mt-5 space-y-3 text-sm text-slate-700">
                            <p class="font-bold text-slate-900">Soal: Hitung nilai dari 98² - 97²</p>
                            <ol class="list-decimal list-inside space-y-2 text-xs sm:text-sm">
                                <li>Menghitung perkalian bersusun 98 × 98 = 9.604.</li>
                                <li>Menghitung perkalian bersusun 97 × 97 = 9.409.</li>
                                <li>Mengurangkan 9.604 - 9.409 = 195 (Memakan banyak waktu &amp; kertas coretan).</li>
                            </ol>
                        </div>

                        <div x-show="activeVisualizer === 'fisika_perbandingan'" x-cloak class="mt-5 space-y-3 text-sm text-slate-700">
                            <p class="font-bold text-slate-900">Soal: Gaya F diperbesar 3 kali dan massa benda m dijadikan setengahnya. Berapa percepatan akhirnya?</p>
                            <ol class="list-decimal list-inside space-y-2 text-xs sm:text-sm">
                                <li>Menulis ulang rumus panjang F₁/m₁ dan F₂/m₂ dengan banyak variabel.</li>
                                <li>Sering terbalik saat membagi pecahan 3 dibagi 1/2 menjadi 3/2.</li>
                            </ol>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-rose-200/80 text-xs text-rose-700 font-semibold">
                        ⚠️ Risiko: Anak cepat lelah, kehabisan waktu ujian, dan kurang percaya diri.
                    </div>
                </div>

                <!-- Right: Metode Jarimatika / Trik Cepat MustikaBimbel -->
                <div class="rounded-3xl p-6 sm:p-8 bg-[#0F2C59] text-white border-4 border-[#FACC15] shadow-xl flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 pb-4 border-b border-white/15">
                            <span class="inline-flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-wider text-[#FACC15]">
                                <i data-lucide="sparkles" class="w-4 h-4"></i>
                                Metode MustikaBimbel
                            </span>
                            <span class="px-3 py-1 rounded-full bg-[#FACC15] text-[#0F2C59] text-xs font-extrabold">
                                ⚡ Selesai dalam 3 Detik!
                            </span>
                        </div>

                        <div x-show="activeVisualizer === 'jarimatika_kali'" class="mt-5 space-y-3 text-sm">
                            <p class="font-bold text-[#FACC15]">Soal: 8 × 7 dengan Jarimatika</p>
                            <ul class="space-y-2 text-xs sm:text-sm text-slate-200">
                                <li>🖐️ <strong>Tangan Kiri (8):</strong> Buka 3 jari berdiri (6, 7, 8), 2 jari tertutup.</li>
                                <li>🖐️ <strong>Tangan Kanan (7):</strong> Buka 2 jari berdiri (6, 7), 3 jari tertutup.</li>
                                <li>✨ <strong>Jari Berdiri = Puluhan:</strong> (3 + 2) = <strong>50</strong>.</li>
                                <li>✨ <strong>Jari Tertutup = Dikali:</strong> (2 × 3) = <strong>6</strong>. Hasil = <strong>56</strong>!</li>
                            </ul>
                        </div>

                        <div x-show="activeVisualizer === 'aljabar_cepat'" x-cloak class="mt-5 space-y-3 text-sm">
                            <p class="font-bold text-[#FACC15]">Soal: 98² - 97² dengan Konsep Selisih Kuadrat</p>
                            <ul class="space-y-2 text-xs sm:text-sm text-slate-200">
                                <li>🧠 <strong>Pahami Pola Konsep:</strong> a² - b² = (a + b)(a - b).</li>
                                <li>⚡ Karena selisih (98 - 97) = 1, cukup jumlahkan kedua angkanya saja!</li>
                                <li>✨ <strong>98 + 97 = 195</strong>. Tanpa perkalian bersusun sama sekali!</li>
                            </ul>
                        </div>

                        <div x-show="activeVisualizer === 'fisika_perbandingan'" x-cloak class="mt-5 space-y-3 text-sm">
                            <p class="font-bold text-[#FACC15]">Soal: Percepatan a = F / m dengan Penalaran Konsep</p>
                            <ul class="space-y-2 text-xs sm:text-sm text-slate-200">
                                <li>🧠 <strong>Analisis Pola:</strong> Percepatan (a) lurus dengan Gaya (F) dan terbalik dengan Massa (m).</li>
                                <li>⚡ Langsung masukkan faktor pengubahnya: a' = 3 ÷ (1/2) = 3 × 2 = <strong>6 kali semula</strong>!</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-white/15 flex items-center justify-between text-xs text-[#FACC15] font-bold">
                        <span>✅ Paham Konsepnya &bull; Cepat Hitungnya &bull; Tepat Jawabannya!</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian B: Katalog Materi Unggulan (Interactive Filter Tabs: TK, SD, SMP) -->
        <div>
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="inline-block px-3.5 py-1 rounded-full bg-[#0F2C59]/10 text-[#0F2C59] text-xs font-extrabold uppercase tracking-wider mb-3">
                    Kurikulum Terstruktur Sesuai Jenjang
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-[#0F2C59] tracking-tight">
                    Katalog Program &amp; Materi Unggulan
                </h2>
                <p class="mt-3 text-slate-600 text-sm sm:text-base">
                    Pilih jenjang pendidikan putra/putri Anda untuk melihat rincian materi yang dipelajari di MustikaBimbel.
                </p>
            </div>

            <!-- Interactive Grade Filter Tabs -->
            <div class="flex flex-wrap justify-center gap-3 mb-10">
                <button type="button" @click="activeGradeTab = 'TK'"
                        :class="activeGradeTab === 'TK' ? 'bg-[#0F2C59] text-[#FACC15] ring-4 ring-[#FACC15]/40' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-6 py-3.5 rounded-2xl text-sm sm:text-base font-extrabold transition-all flex items-center gap-2">
                    <span>🖐️ Jenjang TK &amp; SD Awal (Jarimatika)</span>
                </button>
                <button type="button" @click="activeGradeTab = 'SD'"
                        :class="activeGradeTab === 'SD' ? 'bg-[#0F2C59] text-[#FACC15] ring-4 ring-[#FACC15]/40' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-6 py-3.5 rounded-2xl text-sm sm:text-base font-extrabold transition-all flex items-center gap-2">
                    <span>📘 Jenjang SD (Kelas 1 – 6)</span>
                </button>
                <button type="button" @click="activeGradeTab = 'SMP'"
                        :class="activeGradeTab === 'SMP' ? 'bg-[#0F2C59] text-[#FACC15] ring-4 ring-[#FACC15]/40' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-6 py-3.5 rounded-2xl text-sm sm:text-base font-extrabold transition-all flex items-center gap-2">
                    <span>🔬 Jenjang SMP (Kelas 7 – 9 MIPA &amp; Ujian)</span>
                </button>
            </div>

            <!-- Tab Content 1: Jenjang TK & SD Awal -->
            <div x-show="activeGradeTab === 'TK'" x-cloak class="bg-[#F8FAFC] rounded-3xl p-6 sm:p-10 border-2 border-slate-200">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                    <div class="lg:col-span-1 bg-[#0F2C59] text-white rounded-2xl p-6 space-y-4">
                        <span class="px-3 py-1 rounded-full bg-[#FACC15] text-[#0F2C59] text-xs font-extrabold uppercase">
                            Usia 4 – 8 Tahun
                        </span>
                        <h3 class="text-2xl font-extrabold">Program Jarimatika &amp; Fondasi Berhitung</h3>
                        <p class="text-xs sm:text-sm text-slate-200 leading-relaxed">
                            Membangun kecintaan anak terhadap angka sejak dini dengan metode visual dan gerakan jari yang menyenangkan.
                        </p>
                        <div class="pt-2">
                            <a href="#form-trial" @click="selectedGrade = 'TK'"
                               class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-[#FACC15] text-[#0F2C59] font-extrabold text-xs sm:text-sm">
                                Daftar Coba Gratis TK/SD
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                            <h4 class="font-extrabold text-[#0F2C59] text-base mb-2">1. Konsep Bilangan Visual</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Pengenalan nilai tempat satuan dan puluhan secara konkret sehingga anak paham arti angka, bukan sekadar menghafal urutan.</p>
                        </div>
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                            <h4 class="font-extrabold text-[#0F2C59] text-base mb-2">2. Jarimatika Tambah &amp; Kurang</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Berhitung cepat penjumlahan dan pengurangan puluhan menggunakan formasi jari tangan kanan &amp; kiri tanpa sempoa.</p>
                        </div>
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                            <h4 class="font-extrabold text-[#0F2C59] text-base mb-2">3. Jarimatika Kali &amp; Bagi Dasar</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Transisi menyenangkan menuju perkalian dan pembagian menggunakan jari tangan tanpa ketergantungan kalkulator.</p>
                        </div>
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                            <h4 class="font-extrabold text-[#0F2C59] text-base mb-2">4. Fokus &amp; Kepercayaan Diri</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Melatih koordinasi otak kanan-kiri, motorik halus, dan keberanian anak tampil percaya diri di kelas.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content 2: Jenjang SD (Kelas 1 - 6) -->
            <div x-show="activeGradeTab === 'SD'" x-cloak class="bg-[#F8FAFC] rounded-3xl p-6 sm:p-10 border-2 border-slate-200">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                    <div class="lg:col-span-1 bg-[#0F2C59] text-white rounded-2xl p-6 space-y-4">
                        <span class="px-3 py-1 rounded-full bg-[#FACC15] text-[#0F2C59] text-xs font-extrabold uppercase">
                            SD Kelas 1 – 6
                        </span>
                        <h3 class="text-2xl font-extrabold">Matematika &amp; Sains Dasar (MIPA SD)</h3>
                        <p class="text-xs sm:text-sm text-slate-200 leading-relaxed">
                            Mendampingi ketuntasan materi sekolah sekaligus mengasah kecepatan berhitung dan pemecahan soal cerita.
                        </p>
                        <div class="pt-2">
                            <a href="#form-trial" @click="selectedGrade = 'SD'"
                               class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-[#FACC15] text-[#0F2C59] font-extrabold text-xs sm:text-sm">
                                Daftar Coba Gratis SD
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                            <h4 class="font-extrabold text-[#0F2C59] text-base mb-2">🔢 Matematika Dasar &amp; Pecahan</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Konsep dasar &amp; operasi hitung bilangan bulat, KPK/FPB, pecahan, desimal, dan perbandingan senilai.</p>
                        </div>
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                            <h4 class="font-extrabold text-[#0F2C59] text-base mb-2">📐 Bangun Datar &amp; Geometri</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Pemahaman visual keliling, luas bangun datar gabungan, serta volume bangun ruang dasar.</p>
                        </div>
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                            <h4 class="font-extrabold text-[#0F2C59] text-base mb-2">⚡ Trik Berhitung Cepat</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Kombinasi Jarimatika lanjutan dan metode penyederhanaan angka agar tidak kehabisan waktu saat ulangan.</p>
                        </div>
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                            <h4 class="font-extrabold text-[#0F2C59] text-base mb-2">🌱 IPA Dasar &amp; Soal Cerita</h4>
                            <p class="text-xs sm:text-sm text-slate-600">Pengenalan konsep sains alam dan latihan menerjemahkan soal cerita menjadi langkah penyelesaian yang rapi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content 3: Jenjang SMP (Sesuai Poster Materi Unggulan) -->
            <div x-show="activeGradeTab === 'SMP'" class="bg-[#F8FAFC] rounded-3xl p-6 sm:p-10 border-2 border-[#0F2C59]/20">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1: Matematika -->
                    <div class="bg-white rounded-2xl p-6 border-t-4 border-[#0F2C59] shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl bg-[#0F2C59]/10 text-[#0F2C59] flex items-center justify-center mb-4">
                            <i data-lucide="calculator" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-lg font-extrabold text-[#0F2C59] mb-3">Matematika</h3>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-slate-700">
                            <li class="flex items-start gap-2">
                                <span class="text-[#0D9488] font-bold">&bull;</span>
                                <span>Konsep dasar &amp; operasi hitung</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#0D9488] font-bold">&bull;</span>
                                <span>Aljabar, persamaan, perbandingan</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#0D9488] font-bold">&bull;</span>
                                <span>Geometri</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#0D9488] font-bold">&bull;</span>
                                <span>Trik berhitung cepat</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Card 2: IPA (Ilmu Pengetahuan Alam) -->
                    <div class="bg-white rounded-2xl p-6 border-t-4 border-[#0D9488] shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl bg-[#0D9488]/10 text-[#0D9488] flex items-center justify-center mb-4">
                            <i data-lucide="flask-conical" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-lg font-extrabold text-[#0F2C59] mb-3">IPA (Sains Terpadu)</h3>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-slate-700">
                            <li class="flex items-start gap-2">
                                <span class="text-[#0D9488] font-bold">&bull;</span>
                                <span><strong>Fisika</strong> (rumus &amp; analisis soal)</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#0D9488] font-bold">&bull;</span>
                                <span><strong>Kimia</strong> (perhitungan &amp; konsep)</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#0D9488] font-bold">&bull;</span>
                                <span><strong>Biologi</strong> (konsep &amp; penerapan)</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Card 3: Strategi Mengerjakan Soal -->
                    <div class="bg-white rounded-2xl p-6 border-t-4 border-[#FACC15] shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl bg-[#FACC15]/20 text-[#0F2C59] flex items-center justify-center mb-4">
                            <i data-lucide="target" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-lg font-extrabold text-[#0F2C59] mb-3">Strategi Mengerjakan Soal</h3>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-slate-700">
                            <li class="flex items-start gap-2">
                                <span class="text-[#0F2C59] font-bold">&bull;</span>
                                <span>Mengenali pola soal</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#0F2C59] font-bold">&bull;</span>
                                <span>Memilih rumus yang tepat</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#0F2C59] font-bold">&bull;</span>
                                <span>Menghindari kesalahan hitung</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#0F2C59] font-bold">&bull;</span>
                                <span>Metode penyelesaian yang efisien</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Card 4: Persiapan Ujian -->
                    <div class="bg-white rounded-2xl p-6 border-t-4 border-[#0F2C59] shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl bg-[#0F2C59]/10 text-[#0F2C59] flex items-center justify-center mb-4">
                            <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-lg font-extrabold text-[#0F2C59] mb-3">Persiapan Ujian</h3>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-slate-700">
                            <li class="flex items-start gap-2">
                                <span class="text-[#0D9488] font-bold">&bull;</span>
                                <span>Latihan soal bertahap (dasar – menantang)</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#0D9488] font-bold">&bull;</span>
                                <span>Persiapan ujian sekolah &amp; seleksi masuk SMA</span>
                            </li>
                        </ul>
                        <div class="mt-5 pt-4 border-t border-slate-100">
                            <a href="#form-trial" @click="selectedGrade = 'SMP'"
                               class="inline-flex items-center gap-1.5 text-xs font-extrabold text-[#0F2C59] hover:text-[#0D9488]">
                                <span>Yuk, Bangun Fondasi MIPA-mu!</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
