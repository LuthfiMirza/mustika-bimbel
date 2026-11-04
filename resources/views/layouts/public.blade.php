<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MustikaBimbel — Bimbel Jarimatika (TK-SD) & MIPA (SD-SMP) Cibinong')</title>
    <meta name="description" content="MustikaBimbel Cibinong: Bimbel MIPA untuk Masa Depanmu. Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya! Program Jarimatika TK-SD & Bimbel MIPA SD-SMP di Perumahan Amarylis Garden Cibinong.">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN with MustikaBimbel Brand Palette -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        navy: {
                            DEFAULT: '#0F2C59',
                            hover: '#163A70',
                            dark: '#091C3A',
                            light: '#1E4682',
                        },
                        gold: {
                            DEFAULT: '#FACC15',
                            bright: '#FFD100',
                            hover: '#EAB308',
                        },
                        edu: {
                            teal: '#0D9488',
                            light: '#F0FDFA',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js & Lucide Icons -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        [x-cloak] { display: none !important; }
        .bg-grid-pattern {
            background-image: radial-gradient(rgba(250, 204, 21, 0.16) 1.5px, transparent 1.5px);
            background-size: 24px 24px;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#F8FAFC] text-slate-800 font-sans antialiased selection:bg-[#FACC15] selection:text-[#0F2C59]"
      x-data="{ mobileMenuOpen: false, reportModalOpen: {{ session('report_error') ? 'true' : 'false' }} }">

    <!-- Top Announcement Bar -->
    <div class="bg-[#091C3A] text-white text-xs sm:text-sm py-2 px-4 border-b border-white/10">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-[#FACC15] text-[#0F2C59]">
                    KUOTA TERBATAS
                </span>
                <span class="text-slate-200 font-medium">Klaim Kelas Coba Gratis (Free Trial) Jarimatika TK-SD & MIPA SD-SMP!</span>
            </div>
            <div class="hidden md:flex items-center gap-5 text-slate-300 text-xs">
                <span class="flex items-center gap-1.5">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#FACC15]"></i>
                    Perumahan Amarylis Garden Blok I No. 11, Cibinong
                </span>
                <a href="https://wa.me/6287705555190" target="_blank" class="flex items-center gap-1.5 text-[#FACC15] font-semibold hover:underline">
                    <i data-lucide="phone-call" class="w-3.5 h-3.5"></i>
                    0877-0555-5190
                </a>
            </div>
        </div>
    </div>

    <!-- Sticky Navbar Modern -->
    <header class="sticky top-0 z-40 bg-[#0F2C59]/95 backdrop-blur-md shadow-lg border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <!-- Brand Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-[#FACC15] flex items-center justify-center text-[#0F2C59] font-extrabold text-xl shadow-md group-hover:scale-105 transition-transform">
                        M
                    </div>
                    <div>
                        <span class="text-xl sm:text-2xl font-extrabold tracking-tight text-white block leading-none">
                            Mustika<span class="text-[#FACC15]">Bimbel</span>
                        </span>
                        <span class="text-[11px] text-slate-300 font-medium tracking-wide block mt-0.5">
                            Bimbel MIPA untuk Masa Depanmu
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-6 text-sm font-semibold text-slate-200">
                    <a href="#keunggulan" class="hover:text-[#FACC15] transition-colors">Keunggulan</a>
                    <a href="#tantangan-30-detik" class="hover:text-[#FACC15] transition-colors flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-[#FACC15] animate-ping"></span>
                        Tantangan 30 Detik
                    </a>
                    <a href="#metode-kurikulum" class="hover:text-[#FACC15] transition-colors">Program TK/SD/SMP</a>
                    <a href="#jadwal-belajar" class="hover:text-[#FACC15] transition-colors">Jadwal</a>
                    <a href="#lokasi" class="hover:text-[#FACC15] transition-colors">Lokasi</a>
                </nav>

                <!-- Action Buttons -->
                <div class="hidden sm:flex items-center gap-3">
                    <button @click="reportModalOpen = true" type="button"
                            class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-white/10 hover:bg-white/20 border border-white/20 transition-all">
                        <i data-lucide="file-bar-chart-2" class="w-4 h-4 text-[#FACC15]"></i>
                        Cek Raport Siswa
                    </button>
                    <a href="#form-trial"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-md hover:shadow-xl hover:-translate-y-0.5 transition-all">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                        Daftar Coba Gratis
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="flex items-center gap-2 sm:hidden">
                    <button @click="reportModalOpen = true" type="button"
                            class="p-2 rounded-lg text-[#FACC15] bg-white/10 border border-white/15 text-xs font-bold flex items-center gap-1">
                        <i data-lucide="file-bar-chart-2" class="w-4 h-4"></i>
                        Raport
                    </button>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                            class="p-2 rounded-lg text-white hover:bg-white/10 focus:outline-none"
                            aria-label="Buka Menu">
                        <i data-lucide="menu" class="w-6 h-6" x-show="!mobileMenuOpen"></i>
                        <i data-lucide="x" class="w-6 h-6" x-show="mobileMenuOpen" x-cloak></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" x-collapse x-cloak class="lg:hidden bg-[#091C3A] border-t border-white/10 px-4 pt-3 pb-5 space-y-2">
            <a @click="mobileMenuOpen = false" href="#keunggulan" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-slate-200 hover:bg-white/10 hover:text-[#FACC15]">Keunggulan Kami</a>
            <a @click="mobileMenuOpen = false" href="#tantangan-30-detik" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-[#FACC15] bg-white/5 hover:bg-white/10">⚡ Tantangan Hitung Cepat 30 Detik</a>
            <a @click="mobileMenuOpen = false" href="#metode-kurikulum" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-slate-200 hover:bg-white/10 hover:text-[#FACC15]">Program Jarimatika & MIPA (TK/SD/SMP)</a>
            <a @click="mobileMenuOpen = false" href="#jadwal-belajar" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-slate-200 hover:bg-white/10 hover:text-[#FACC15]">Jadwal Belajar & Sisa Kursi</a>
            <a @click="mobileMenuOpen = false" href="#lokasi" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-slate-200 hover:bg-white/10 hover:text-[#FACC15]">Lokasi Amarylis Garden Cibinong</a>
            <div class="pt-2 flex flex-col gap-2">
                <a @click="mobileMenuOpen = false" href="#form-trial"
                   class="w-full py-3 rounded-xl text-center text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] shadow-md">
                    Daftar Coba Gratis Sekarang
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Official Footer -->
    <footer class="bg-[#091C3A] text-slate-300 pt-14 pb-10 border-t-4 border-[#FACC15]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-10 border-b border-white/10">
                <!-- Col 1: Brand -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#FACC15] flex items-center justify-center text-[#0F2C59] font-extrabold text-xl">
                            M
                        </div>
                        <div>
                            <span class="text-xl font-extrabold text-white block leading-none">
                                Mustika<span class="text-[#FACC15]">Bimbel</span>
                            </span>
                            <span class="text-xs text-slate-400">Bimbel MIPA untuk Masa Depanmu</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-300 font-semibold italic text-[#FACC15]">
                        "Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!"
                    </p>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Belajar bukan sekadar menghafal rumus. Pahami cara kerjanya, kuasai langkahnya, dan temukan cara menyelesaikan soal dengan lebih efektif.
                    </p>
                </div>

                <!-- Col 2: Program Unggulan -->
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Program Unggulan</h3>
                    <ul class="space-y-2.5 text-sm text-slate-300">
                        <li class="flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-[#FACC15] shrink-0"></i>
                            Jarimatika & Hitung Cepat (TK – SD)
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-[#FACC15] shrink-0"></i>
                            Bimbel Matematika & Sains SD (Kelas 1–6)
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-[#FACC15] shrink-0"></i>
                            Bimbel MIPA SMP (Matematika, Fisika, Kimia, Biologi)
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-[#FACC15] shrink-0"></i>
                            Persiapan Ujian Sekolah & Masuk SMA
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Jadwal Belajar Resmi -->
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Jadwal Belajar Resmi</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="bg-white/5 p-2.5 rounded-lg border border-white/10">
                            <span class="font-bold text-[#FACC15] block">Senin – Kamis</span>
                            <span class="text-xs text-slate-300">18.30 – 20.00 WIB</span>
                        </li>
                        <li class="bg-white/5 p-2.5 rounded-lg border border-white/10">
                            <span class="font-bold text-[#FACC15] block">Sabtu</span>
                            <span class="text-xs text-slate-300">16.00 – 17.30 WIB</span>
                        </li>
                        <li class="bg-white/5 p-2.5 rounded-lg border border-white/10">
                            <span class="font-bold text-[#FACC15] block">Minggu</span>
                            <span class="text-xs text-slate-300">18.30 – 20.00 WIB</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Kontak & Lokasi -->
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Lokasi & Kontak</h3>
                    <p class="text-sm flex items-start gap-2.5 text-slate-300">
                        <i data-lucide="map-pin" class="w-5 h-5 text-[#FACC15] shrink-0 mt-0.5"></i>
                        <span>Perumahan Amarylis Garden, Jalan H Abdul Gani II Blok I No. 11, Harapan Jaya, Cibinong</span>
                    </p>
                    <p class="text-sm flex items-center gap-2.5 text-slate-300">
                        <i data-lucide="phone" class="w-4 h-4 text-[#FACC15] shrink-0"></i>
                        <a href="https://wa.me/6287705555190" target="_blank" class="hover:text-[#FACC15] font-bold">087705555190 (WhatsApp)</a>
                    </p>
                    <div class="pt-2 flex items-center gap-3">
                        <a href="{{ url('/login') }}" class="text-xs text-slate-400 hover:text-[#FACC15] underline flex items-center gap-1">
                            <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                            Login Pengajar / Admin
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
                <p>&copy; {{ date('Y') }} <strong>MustikaBimbel Cibinong</strong>. Seluruh hak cipta dilindungi.</p>
                <p class="text-slate-400">MIPA Lebih Mudah — Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!</p>
            </div>
        </div>
    </footer>

    @stack('modals')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

