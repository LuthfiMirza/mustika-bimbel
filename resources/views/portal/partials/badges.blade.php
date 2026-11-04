<!-- Section: Lencana Prestasi & Sertifikat Digital Siswa (html2canvas) -->
<div class="bg-white rounded-3xl p-6 sm:p-8 shadow-md border-2 border-slate-200/80"
     x-data="{
        activeBadgeTitle: '{{ $student->badges->first()?->badge_title ?? 'Prestasi Gemilang MustikaBimbel' }}',
        activeBadgeDesc: '{{ $student->badges->first()?->description ?? 'Menunjukkan dedikasi tinggi dan penguasaan konsep yang luar biasa.' }}',
        activeBadgeDate: '{{ $student->badges->first()?->awarded_date?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y') }}',
        isGenerating: false,
        downloadCertificate() {
            this.isGenerating = true;
            const certElement = document.getElementById('mustika-certificate');
            if (!certElement) return;

            html2canvas(certElement, {
                scale: 2,
                useCORS: true,
                backgroundColor: '#0F2C59'
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'Sertifikat-MustikaBimbel-{{ Str::slug($student->full_name) }}.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
                this.isGenerating = false;
            }).catch(err => {
                console.error(err);
                alert('Gagal mengunduh gambar sertifikat. Silakan coba kembali.');
                this.isGenerating = false;
            });
        }
     }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
        <div>
            <span class="text-xs font-extrabold uppercase tracking-wider text-[#0D9488]">Gamifikasi & Apresiasi Belajar</span>
            <h2 class="text-lg sm:text-2xl font-extrabold text-[#0F2C59]">Lencana Prestasi & Sertifikat</h2>
        </div>
        <button type="button" @click="downloadCertificate()" :disabled="isGenerating"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-sm transition-all disabled:opacity-50">
            <i data-lucide="download" class="w-4 h-4"></i>
            <span x-text="isGenerating ? 'Menyiapkan Gambar...' : 'Unduh Sertifikat (PNG)'"></span>
        </button>
    </div>

    <!-- Badges Grid Selection -->
    <div class="mt-6">
        <p class="text-xs text-slate-500 mb-3">
            Klik lencana di bawah untuk menampilkan sertifikat resmi kebanggaan siswa:
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse ($student->badges as $badge)
                <div @click="activeBadgeTitle = '{{ $badge->badge_title }}'; activeBadgeDesc = '{{ $badge->description }}'; activeBadgeDate = '{{ $badge->awarded_date->translatedFormat('d F Y') }}'"
                     class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-[#0F2C59] hover:bg-[#0F2C59]/5 cursor-pointer transition-all flex items-start gap-3.5 group">
                    <div class="w-12 h-12 rounded-2xl bg-[#0F2C59] text-[#FACC15] flex items-center justify-center text-xl shrink-0 shadow-md group-hover:scale-105 transition-transform">
                        @if($badge->badge_icon === 'zap')
                            <i data-lucide="zap" class="w-6 h-6"></i>
                        @elseif($badge->badge_icon === 'star')
                            <i data-lucide="star" class="w-6 h-6"></i>
                        @elseif($badge->badge_icon === 'award')
                            <i data-lucide="award" class="w-6 h-6"></i>
                        @else
                            <i data-lucide="trophy" class="w-6 h-6"></i>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-1">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#0D9488]">
                                {{ $badge->badge_category }}
                            </span>
                            <span class="text-[10px] text-slate-400">
                                {{ $badge->awarded_date->translatedFormat('d M Y') }}
                            </span>
                        </div>
                        <h3 class="text-xs sm:text-sm font-extrabold text-[#0F2C59] mt-0.5 group-hover:text-[#0D9488] transition-colors truncate">
                            {{ $badge->badge_title }}
                        </h3>
                        <p class="text-[11px] text-slate-600 mt-1 line-clamp-2">
                            {{ $badge->description }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-6 text-slate-400 text-xs">
                    Lencana perdana sedang dipersiapkan oleh tim pengajar.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Official Certificate Canvas (Optimized for html2canvas & WhatsApp Story 4:3 / 16:9) -->
    <div class="mt-8 pt-6 border-t border-slate-100">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                Pratinjau Sertifikat Resmi (Siap Diunduh & Dibagikan ke WhatsApp Story)
            </span>
            <span class="text-[11px] text-slate-400">Dimensi HD</span>
        </div>

        <div class="overflow-x-auto pb-2">
            <div id="mustika-certificate"
                 class="w-[720px] max-w-full mx-auto bg-[#0F2C59] text-white p-8 rounded-3xl border-8 border-[#FACC15] shadow-2xl relative overflow-hidden select-none">
                <!-- Background Glow -->
                <div class="absolute -top-16 -right-16 w-56 h-56 rounded-full bg-[#FACC15]/20 blur-2xl pointer-events-none"></div>
                <div class="absolute -bottom-16 -left-16 w-56 h-56 rounded-full bg-[#0D9488]/25 blur-2xl pointer-events-none"></div>

                <!-- Certificate Header -->
                <div class="flex items-center justify-between pb-4 border-b-2 border-white/20 relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-[#FACC15] text-[#0F2C59] flex items-center justify-center font-extrabold text-2xl shadow-md">
                            M
                        </div>
                        <div>
                            <span class="text-2xl font-extrabold tracking-tight text-white block leading-none">
                                Mustika<span class="text-[#FACC15]">Bimbel</span>
                            </span>
                            <span class="text-[11px] text-slate-300 font-medium">Bimbel MIPA untuk Masa Depanmu &bull; Cibinong</span>
                        </div>
                    </div>

                    <div class="text-right">
                        <span class="inline-block px-3 py-1 rounded-full bg-[#FACC15] text-[#0F2C59] text-[10px] font-extrabold uppercase tracking-wider">
                            Sertifikat Resmi
                        </span>
                        <p class="text-[11px] text-slate-300 mt-1 font-mono">No: CERT-{{ $student->student_code }}</p>
                    </div>
                </div>

                <!-- Certificate Body -->
                <div class="py-6 text-center space-y-4 relative z-10">
                    <p class="text-xs font-bold uppercase tracking-widest text-[#FACC15]">
                        Sertifikat Pencapaian Prestasi Siswa
                    </p>

                    <p class="text-xs text-slate-300">Diberikan dengan penuh rasa bangga kepada:</p>

                    <div>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-white tracking-wide">
                            {{ $student->full_name }}
                        </h3>
                        <p class="text-xs text-[#FACC15] font-semibold mt-1">
                            Kode Siswa: {{ $student->student_code }} &bull; Jenjang: {{ $student->grade_level }} ({{ $student->class_number ?? 'Siswa Binaan' }})
                        </p>
                    </div>

                    <p class="text-xs text-slate-300 max-w-lg mx-auto">
                        Atas pencapaian kompetensi dan ketuntasan materi luar biasa pada:
                    </p>

                    <!-- Award Highlight Box -->
                    <div class="bg-white/10 border-2 border-[#FACC15] rounded-2xl p-4 max-w-xl mx-auto shadow-inner">
                        <h4 class="text-lg font-extrabold text-[#FACC15]" x-text="activeBadgeTitle"></h4>
                        <p class="text-xs text-slate-200 mt-1" x-text="activeBadgeDesc"></p>
                    </div>

                    <p class="text-sm font-extrabold italic text-[#FACC15] pt-1">
                        "Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!"
                    </p>
                </div>

                <!-- Certificate Footer -->
                <div class="pt-4 border-t-2 border-white/20 flex items-end justify-between text-xs relative z-10">
                    <div class="space-y-1">
                        <p class="text-[11px] text-slate-400">Tanggal Diterbitkan:</p>
                        <p class="font-bold text-slate-200" x-text="activeBadgeDate"></p>
                        <p class="text-[10px] text-slate-400">
                            📍 Perumahan Amarylis Garden Blok I No. 11, Harapan Jaya, Cibinong
                        </p>
                    </div>

                    <div class="text-right space-y-1">
                        <p class="text-[11px] text-slate-400">Pengajar Pembimbing:</p>
                        <p class="font-extrabold text-[#FACC15] text-sm">Kak Mustika &amp; Tim Pengajar</p>
                        <p class="text-[10px] text-slate-300">WA Resmi: 0877-0555-5190</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <span class="flex items-center gap-1.5">
                <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                Gambar PNG kualitas tinggi dengan watermark dan kontak resmi MustikaBimbel.
            </span>
            <button type="button" @click="downloadCertificate()"
                    class="text-xs font-bold text-[#0F2C59] hover:underline flex items-center gap-1">
                <span>Unduh Gambar Sekarang</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
@endpush
