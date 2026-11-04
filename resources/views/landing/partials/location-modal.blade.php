<!-- Seksi 8: Lokasi MustikaBimbel Amarylis Garden Cibinong & Peta Interaktif -->
<section id="lokasi" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <!-- Left: Informasi Alamat & Jam Operasional -->
            <div class="lg:col-span-5 space-y-6">
                <span class="inline-block px-3.5 py-1 rounded-full bg-[#0F2C59]/10 text-[#0F2C59] text-xs font-extrabold uppercase tracking-wider">
                    Lokasi Strategis &amp; Aman di Cibinong
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-[#0F2C59] tracking-tight">
                    Kunjungi Ruang Belajar MustikaBimbel
                </h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                    Berlokasi di lingkungan perumahan yang tenang, aman, dan nyaman untuk belajar anak-anak TK, SD, hingga SMP di wilayah Harapan Jaya, Cibinong dan sekitarnya.
                </p>

                <div class="space-y-4">
                    <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-[#F8FAFC] border border-slate-200">
                        <div class="w-10 h-10 rounded-xl bg-[#0F2C59] text-[#FACC15] flex items-center justify-center shrink-0">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-[#0F2C59]">Alamat Lengkap</h3>
                            <p class="text-xs sm:text-sm text-slate-700 mt-0.5">
                                Perumahan Amarylis Garden, Jalan H Abdul Gani II Blok I No. 11, Harapan Jaya, Cibinong, Kabupaten Bogor
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-[#F8FAFC] border border-slate-200">
                        <div class="w-10 h-10 rounded-xl bg-[#0D9488] text-white flex items-center justify-center shrink-0">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-[#0F2C59]">Jadwal Belajar Resmi</h3>
                            <ul class="text-xs sm:text-sm text-slate-700 mt-1 space-y-1">
                                <li>&bull; <strong>Senin – Kamis:</strong> 18.30 – 20.00 WIB</li>
                                <li>&bull; <strong>Sabtu:</strong> 16.00 – 17.30 WIB</li>
                                <li>&bull; <strong>Minggu:</strong> 18.30 – 20.00 WIB</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="pt-2 flex flex-wrap items-center gap-3">
                    <a href="https://www.google.com/maps/search/?api=1&query=Perumahan+Amarylis+Garden+Jalan+H+Abdul+Gani+II+Harapan+Jaya+Cibinong"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl text-sm font-extrabold text-white bg-[#0F2C59] hover:bg-[#163A70] shadow-md transition-all">
                        <i data-lucide="navigation" class="w-4 h-4 text-[#FACC15]"></i>
                        Buka Rute di Google Maps
                    </a>
                    <a href="https://wa.me/6287705555190?text=Halo%20Admin%20MustikaBimbel%2C%20saya%20ingin%20bertanya%20lokasi%20dan%20jadwal%20bimbel."
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 px-5 py-3.5 rounded-xl text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-md transition-all">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        Chat WA 0877-0555-5190
                    </a>
                </div>
            </div>

            <!-- Right: Embedded Interactive Google Map -->
            <div class="lg:col-span-7">
                <div class="rounded-3xl overflow-hidden shadow-xl border-4 border-slate-100 bg-slate-100 h-80 sm:h-96 relative">
                    <iframe
                        title="Peta Lokasi MustikaBimbel Perumahan Amarylis Garden Cibinong"
                        src="https://www.google.com/maps?q=Perumahan+Amarylis+Garden+Jl.+H.+Abdul+Gani+II+Harapan+Jaya+Cibinong&output=embed"
                        class="w-full h-full border-0"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal "Cek Raport Siswa dengan Kode Siswa" -->
<div x-show="reportModalOpen" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#091C3A]/80 backdrop-blur-sm"
     @keydown.escape.window="reportModalOpen = false">
    <div @click.outside="reportModalOpen = false"
         class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border-4 border-[#FACC15] relative">
        <button type="button" @click="reportModalOpen = false"
                class="absolute top-4 right-4 p-2 rounded-full text-slate-400 hover:text-slate-700 hover:bg-slate-100">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <div class="flex items-center gap-3 mb-4">
            <div class="w-11 h-11 rounded-2xl bg-[#0F2C59] text-[#FACC15] flex items-center justify-center font-extrabold">
                <i data-lucide="file-bar-chart-2" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-lg font-extrabold text-[#0F2C59]">Portal Orang Tua &amp; E-Raport</h3>
                <p class="text-xs text-slate-500">Pantau grafik perkembangan &amp; sertifikat anak</p>
            </div>
        </div>

        @if (session('report_error'))
            <div class="mb-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-xs font-semibold text-rose-700">
                {{ session('report_error') }}
            </div>
        @endif

        <form action="{{ route('landing.check-report') }}" method="GET" class="space-y-4">
            <div>
                <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">
                    Masukkan Kode Induk Siswa
                </label>
                <input type="text" name="kode" required
                       placeholder="Contoh: MB-2026-001"
                       class="w-full px-4 py-3.5 rounded-xl border-2 border-slate-300 text-sm font-bold text-[#0F2C59] uppercase focus:border-[#0F2C59] outline-none">
            </div>

            <button type="submit"
                    class="w-full py-3.5 px-5 rounded-xl text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-md transition-all flex items-center justify-center gap-2">
                <i data-lucide="search" class="w-4 h-4"></i>
                <span>Buka E-Raport Siswa Sekarang</span>
            </button>
        </form>

        @if(isset($sampleStudents) && $sampleStudents->count() > 0)
            <div class="mt-6 pt-4 border-t border-slate-100">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2.5">
                    Klik Contoh E-Raport Siswa Aktif:
                </p>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($sampleStudents as $sample)
                        <a href="{{ url('/raport/' . $sample->portal_token) }}"
                           class="p-2.5 rounded-xl bg-slate-50 hover:bg-[#0F2C59] hover:text-white border border-slate-200 transition-colors text-left group">
                            <span class="text-xs font-extrabold text-[#0F2C59] group-hover:text-[#FACC15] block">{{ $sample->student_code }}</span>
                            <span class="text-[11px] text-slate-600 group-hover:text-slate-200 truncate block">{{ $sample->full_name }} ({{ $sample->grade_level }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
