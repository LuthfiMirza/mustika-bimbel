<!-- Modal Input Cepat Jurnal Belajar & Kirim WA Laporan Pulang -->
<div x-data="{
    open: false,
    studentId: '',
    studentName: '',
    topic: '',
    cat: 'Matematika',
    score: 85,
    speed: 5,
    notes: 'Ananda belajar dengan sangat fokus dan antusias.',
    init() {
        window.addEventListener('open-journal', (e) => {
            this.studentId = e.detail.studentId;
            this.studentName = e.detail.studentName;
            this.topic = e.detail.topic || '';
            this.cat = e.detail.cat || 'Matematika';
            this.score = e.detail.score || 85;
            this.speed = e.detail.speed || 5;
            this.notes = e.detail.notes || 'Ananda belajar dengan sangat fokus dan antusias memahami konsep materi hari ini.';
            this.open = true;
        });
    },
    setTemplate(text) {
        this.notes = text;
    }
}"
x-show="open" x-cloak
class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#091C3A]/80 backdrop-blur-sm"
@keydown.escape.window="open = false">

    <div @click.outside="open = false"
         class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border-4 border-[#FACC15] relative max-h-[90vh] overflow-y-auto">
        <button type="button" @click="open = false"
                class="absolute top-4 right-4 p-2 rounded-full text-slate-400 hover:text-slate-700 hover:bg-slate-100">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <div class="flex items-center gap-3 pb-4 border-b border-slate-100 mb-5">
            <div class="w-11 h-11 rounded-2xl bg-[#0F2C59] text-[#FACC15] flex items-center justify-center font-extrabold text-xl shadow-md">
                <i data-lucide="book-open-check" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-extrabold text-[#0F2C59]">Jurnal Belajar &amp; Nilai Hari Ini</h3>
                <p class="text-xs text-slate-500">Siswa: <strong class="text-[#0D9488]" x-text="studentName"></strong></p>
            </div>
        </div>

        <form action="{{ route('admin.attendance.journal') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="student_id" :value="studentId">
            <input type="hidden" name="schedule_id" value="{{ $selectedScheduleId }}">
            <input type="hidden" name="session_date" value="{{ $selectedDate }}">

            <!-- Kategori Materi -->
            <div>
                <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Kategori Pelajaran *</label>
                <select name="subject_category" x-model="cat" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold text-[#0F2C59] bg-white focus:ring-2 focus:ring-[#0F2C59] outline-none">
                    <option value="Jarimatika">🖐️ Jarimatika (TK - SD)</option>
                    <option value="Matematika">🔢 Matematika</option>
                    <option value="Fisika">⚡ Fisika (Rumus &amp; Analisis)</option>
                    <option value="Kimia">🧪 Kimia (Perhitungan &amp; Konsep)</option>
                    <option value="Biologi">🌱 Biologi (Konsep &amp; Penerapan)</option>
                    <option value="Strategi Soal">🎯 Strategi Mengerjakan Soal (Trik Cepat)</option>
                    <option value="Persiapan Ujian">🎓 Persiapan Ujian Sekolah &amp; Masuk SMA</option>
                </select>
            </div>

            <!-- Topik Materi -->
            <div>
                <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Materi / Topik Yang Dipelajari *</label>
                <input type="text" name="topic_covered" x-model="topic" required
                       placeholder="Contoh: Jarimatika Perkalian 6-9 atau Persamaan Aljabar SPLDV"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Rating Kecepatan (1-5 Bintang) -->
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Kecepatan Hitung (1-5 ⭐)</label>
                    <select name="speed_rating" x-model="speed" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-bold bg-white focus:ring-2 focus:ring-[#0F2C59] outline-none">
                        <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Cepat)</option>
                        <option value="4">⭐⭐⭐⭐ (4 - Cepat)</option>
                        <option value="3">⭐⭐⭐ (3 - Cukup)</option>
                        <option value="2">⭐⭐ (2 - Butuh Bimbingan)</option>
                        <option value="1">⭐ (1 - Perlu Latihan Dasar)</option>
                    </select>
                </div>

                <!-- Skor Latihan Soal (0-100) -->
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Nilai Latihan (0-100)</label>
                    <input type="number" name="practice_score" x-model="score" min="0" max="100" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-extrabold text-[#0F2C59] focus:ring-2 focus:ring-[#0F2C59] outline-none">
                </div>
            </div>

            <!-- Catatan Pengajar Personal -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-extrabold uppercase text-slate-600">Catatan Pengajar untuk Orang Tua</label>
                </div>
                <textarea name="tutor_notes" x-model="notes" rows="3" required
                          placeholder="Tulis perkembangan spesifik ananda hari ini..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#0F2C59] outline-none"></textarea>

                <!-- Template Catatan Instan -->
                <div class="mt-2 flex flex-wrap gap-1.5 text-[11px]">
                    <span class="text-slate-400 font-semibold">Template Cepat:</span>
                    <button type="button" @click="setTemplate('Kecepatan jarimatika ananda meningkat pesat, sudah hafal formasi jari tanpa ragu!')"
                            class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700">
                        ⚡ Jarimatika Lancar
                    </button>
                    <button type="button" @click="setTemplate('Pemahaman konsep dasar sangat bagus dan teliti dalam pengerjaan soal latihan.')"
                            class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700">
                        🌟 Paham Konsep
                    </button>
                    <button type="button" @click="setTemplate('Sudah memahami trik eliminasi aljabar dengan baik, perlu sedikit latihan tanda minus di rumah.')"
                            class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700">
                        📘 Aljabar/MIPA
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-3 border-t border-slate-100">
                <button type="submit"
                        class="w-full py-3.5 px-5 rounded-2xl text-xs sm:text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-md transition-all flex items-center justify-center gap-2">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span>Simpan &amp; Kirim Laporan Pulang ke WA Ortu</span>
                </button>
            </div>
        </form>
    </div>
</div>

