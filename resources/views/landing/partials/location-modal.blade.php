<!-- 5.15 LOKASI (#lokasi) & MODAL CEK RAPORT -->
<section id="lokasi" class="py-16 sm:py-24 bg-cream relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <!-- Left: Info Alamat & Jadwal -->
            <div class="lg:col-span-5 space-y-6">
                <span class="sticker sticker--lime" style="--tilt: -2deg;">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                    <span>LOKASI STRATEGIS &amp; AMAN DI CIBINONG</span>
                </span>

                <h2 class="font-display text-3xl sm:text-5xl text-ink leading-tight">
                    KUNJUNGI RUANG BELAJAR MUSTIKA BIMBEL
                </h2>

                <p class="text-sm sm:text-base text-slate-700 leading-relaxed">
                    Berlokasi di lingkungan perumahan yang tenang, aman, dan nyaman untuk belajar anak-anak TK, SD, hingga SMP di wilayah Harapan Jaya, Cibinong dan sekitarnya.
                </p>

                <div class="space-y-4">
                    <div class="reveal flex items-start gap-3.5 p-4 rounded-2xl bg-paper border-2 border-ink shadow-[4px_4px_0_#111]"
                         x-intersect.once="$el.classList.add('is-in')">
                        <div class="w-10 h-10 rounded-xl bg-navy text-gold border-2 border-ink flex items-center justify-center shrink-0">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-display text-sm text-ink">Alamat Lengkap</h3>
                            <p class="text-xs sm:text-sm text-slate-700 mt-0.5">
                                Perumahan Amarylis Garden, Jalan H Abdul Gani II Blok I No. 11, Harapan Jaya, Cibinong, Kabupaten Bogor
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-paper border-2 border-ink shadow-[4px_4px_0_#111]">
                        <div class="w-10 h-10 rounded-xl bg-gold text-ink border-2 border-ink flex items-center justify-center shrink-0">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-display text-sm text-ink">Jadwal Belajar Resmi</h3>
                            <ul class="text-xs sm:text-sm text-slate-700 mt-1 space-y-1">
                                <li>&bull; <strong>Senin – Kamis:</strong> 18.30 – 20.00 WIB</li>
                                <li>&bull; <strong>Sabtu:</strong> 16.00 – 17.30 WIB</li>
                                <li>&bull; <strong>Minggu:</strong> 18.30 – 20.00 WIB</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="pt-2 flex flex-wrap items-center gap-4">
                    <a href="https://www.google.com/maps/search/?api=1&query=Perumahan+Amarylis+Garden+Jalan+H+Abdul+Gani+II+Harapan+Jaya+Cibinong"
                       target="_blank" rel="noopener"
                       class="btn-pop btn-pop--sm">
                        <span class="btn-roll">
                            <span>Buka Google Maps</span>
                            <span aria-hidden="true">Buka Google Maps</span>
                        </span>
                        <span class="btn-pop__dot"><i data-lucide="navigation" class="w-3.5 h-3.5"></i></span>
                    </a>

                    <a href="https://wa.me/6287705555190?text=Halo%20Admin%20MustikaBimbel%2C%20saya%20ingin%20bertanya%20lokasi%20dan%20jadwal%20bimbel."
                       target="_blank" rel="noopener"
                       class="btn-pop btn-pop--lime btn-pop--sm">
                        <span class="btn-roll">
                            <span>Chat WA 0877-0555-5190</span>
                            <span aria-hidden="true">Chat WA 0877-0555-5190</span>
                        </span>
                        <span class="btn-pop__dot"><i data-lucide="message-circle" class="w-3.5 h-3.5"></i></span>
                    </a>
                </div>
            </div>

            <!-- Right: Embedded Map in Neo-Brutalist Frame -->
            <div class="lg:col-span-7 relative reveal" x-intersect.once="$el.classList.add('is-in')" style="transition-delay: 100ms;">
                <div class="absolute -top-4 left-6 z-10">
                    <span class="sticker sticker--gold" style="--tilt: -2deg;">
                        📍 AMARYLIS GARDEN
                    </span>
                </div>
                <div class="rounded-[24px] overflow-hidden border-[3px] border-ink hard-shadow-lg bg-paper h-80 sm:h-[420px] relative">
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
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-ink/75 backdrop-blur-sm"
     @keydown.escape.window="reportModalOpen = false">
    <div @click.outside="reportModalOpen = false"
         class="bg-paper rounded-[28px] max-w-md w-full overflow-hidden border-[3px] border-ink hard-shadow-lg relative">
        <!-- Gold Modal Header -->
        <div class="bg-gold px-6 py-5 border-b-[3px] border-ink flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-navy text-gold border-2 border-ink flex items-center justify-center shrink-0">
                    <i data-lucide="file-bar-chart-2" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-display text-lg text-ink leading-tight">Portal Orang Tua &amp; E-Raport</h3>
                    <p class="text-xs font-semibold text-ink/80">Pantau grafik perkembangan &amp; sertifikat anak</p>
                </div>
            </div>
            <button type="button" @click="reportModalOpen = false"
                    class="w-9 h-9 rounded-xl border-2 border-ink bg-paper text-ink hover:bg-tomato hover:text-white flex items-center justify-center transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="p-6 sm:p-7">
            @if (session('report_error'))
                <div class="mb-4 p-3.5 rounded-xl bg-rose-50 border-2 border-tomato text-xs font-bold text-rose-800">
                    {{ session('report_error') }}
                </div>
            @endif

            <form action="{{ route('landing.check-report') }}" method="GET" class="space-y-4">
                <div>
                    <label class="block font-label text-xs font-bold uppercase text-ink mb-1.5">
                        Masukkan Kode Induk Siswa
                    </label>
                    <input type="text" name="kode" required
                           placeholder="Contoh: MB-2026-001"
                           class="w-full px-4 py-3.5 rounded-[14px] border-2 border-ink bg-white text-sm font-bold text-navy uppercase focus:outline focus:outline-[3px] focus:outline-gold focus:outline-offset-2">
                </div>

                <button type="submit" class="btn-pop w-full">
                    <span class="btn-roll">
                        <span>Buka E-Raport Siswa</span>
                        <span aria-hidden="true">Buka E-Raport Siswa</span>
                    </span>
                    <span class="btn-pop__dot"><i data-lucide="search" class="w-4 h-4"></i></span>
                </button>
            </form>

            @if(isset($sampleStudents) && $sampleStudents->count() > 0)
                <div class="mt-6 pt-4 border-t-2 border-ink/10">
                    <p class="font-label text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-2.5">
                        Klik Contoh E-Raport Siswa Aktif:
                    </p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($sampleStudents as $sample)
                            <a href="{{ url('/raport/' . $sample->portal_token) }}"
                               class="p-2.5 rounded-xl bg-cream hover:bg-gold border-2 border-ink transition-colors text-left shadow-[2px_2px_0_#111]">
                                <span class="font-display text-xs text-navy block">{{ $sample->student_code }}</span>
                                <span class="text-[11px] font-semibold text-ink truncate block">{{ $sample->full_name }} ({{ $sample->grade_level }})</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
