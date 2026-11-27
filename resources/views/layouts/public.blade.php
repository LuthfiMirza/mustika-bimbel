<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MustikaBimbel — Bimbel Jarimatika (TK-SD) & MIPA (SD-SMP) Cibinong')</title>
    <meta name="description" content="MustikaBimbel Cibinong: Bimbel MIPA untuk Masa Depanmu. Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya! Program Jarimatika TK-SD & Bimbel MIPA SD-SMP di Perumahan Amarylis Garden Cibinong.">

    <!-- Google Fonts: Bowlby One, Caveat Brush, Plus Jakarta Sans, Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bowlby+One&family=Caveat+Brush&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN with Krackerz-inspired Neo-Brutalism Tokens & MustikaBimbel Palette -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['"Bowlby One"', 'sans-serif'],
                        script: ['"Caveat Brush"', 'cursive'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        label: ['"Space Grotesk"', 'sans-serif'],
                    },
                    colors: {
                        cream: '#F4F1E8',
                        paper: '#FFFDF7',
                        ink: '#111111',
                        lime: '#D7FF3A',
                        tomato: '#E8432E',
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

    <!-- Alpine.js Plugins (Intersect + Collapse) & Core + Lucide Icons -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.14.3/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.14.3/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --cream: #F4F1E8;
            --paper: #FFFDF7;
            --ink: #111111;
            --gold: #FACC15;
            --gold-bright: #FFD100;
            --lime: #D7FF3A;
            --tomato: #E8432E;
            --navy: #0F2C59;
            --navy-dark: #091C3A;
        }

        [x-cloak] { display: none !important; }
        html, body { overflow-x: clip; }

        /* Dot pattern background */
        .bg-dots {
            background-image: radial-gradient(rgba(17, 17, 17, 0.11) 1.5px, transparent 1.6px);
            background-size: 22px 22px;
        }
        .bg-dots-light {
            background-image: radial-gradient(rgba(255, 253, 247, 0.16) 1.5px, transparent 1.6px);
            background-size: 22px 22px;
        }

        /* Neo-brutalism hard shadows */
        .hard-shadow { box-shadow: 4px 4px 0 var(--ink); }
        .hard-shadow-lg { box-shadow: 8px 8px 0 var(--ink); }

        /* Display & Script Typography */
        .font-display-hero {
            font-family: 'Bowlby One', sans-serif;
            text-transform: uppercase;
            letter-spacing: -0.01em;
            line-height: 0.95;
        }

        /* 4.1 Pill CTA Button with Text Roll Effect */
        .btn-pop {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 0.85rem 1rem 0.85rem 1.55rem;
            border: 3px solid var(--ink);
            border-radius: 9999px;
            background: var(--gold);
            color: var(--ink);
            font-family: 'Bowlby One', sans-serif;
            text-transform: uppercase;
            font-size: 14px;
            line-height: 1.1;
            white-space: nowrap;
            box-shadow: 4px 4px 0 var(--ink);
            transition: transform 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease;
            cursor: pointer;
        }
        @media (max-width: 420px) {
            .btn-pop {
                font-size: 12px;
                padding: 0.75rem 0.85rem 0.75rem 1.2rem;
                gap: 0.55rem;
            }
        }
        .btn-pop:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0 var(--ink);
            background: var(--gold-bright);
        }
        .btn-pop:active {
            transform: translate(2px, 2px);
            box-shadow: 1px 1px 0 var(--ink);
        }
        .btn-pop--ink {
            background: var(--ink);
            color: var(--gold);
        }
        .btn-pop--ink:hover {
            background: #1f1f1f;
            color: var(--gold-bright);
        }
        .btn-pop--lime {
            background: var(--lime);
            color: var(--ink);
        }
        .btn-pop--lime:hover {
            background: #e4ff6b;
        }
        .btn-pop--sm {
            padding: 0.55rem 0.75rem 0.55rem 1.15rem;
            font-size: 12px;
            border-width: 2.5px;
            box-shadow: 3px 3px 0 var(--ink);
        }
        .btn-pop--sm:hover {
            box-shadow: 4px 4px 0 var(--ink);
        }
        .btn-roll {
            display: grid;
            height: 1.25em;
            overflow: hidden;
            line-height: 1.25em;
        }
        .btn-roll > span {
            display: block;
            white-space: nowrap;
            transition: transform 0.3s cubic-bezier(0.7, 0, 0.2, 1);
        }
        .btn-pop:hover .btn-roll > span {
            transform: translateY(-100%);
        }
        .btn-pop__dot {
            display: grid;
            place-items: center;
            width: 30px;
            height: 30px;
            border-radius: 9999px;
            background: var(--tomato);
            color: #fff;
            border: 2px solid var(--ink);
            flex-shrink: 0;
        }
        .btn-pop--sm .btn-pop__dot {
            width: 24px;
            height: 24px;
        }

        /* 4.2 Tilted Sticker Badges & Headline Stickers */
        .sticker {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.85rem;
            border: 3px solid var(--ink);
            border-radius: 9999px;
            box-shadow: 3px 3px 0 var(--ink);
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transform: rotate(var(--tilt, -3deg));
        }
        .sticker--gold { background: var(--gold); color: var(--ink); }
        .sticker--lime { background: var(--lime); color: var(--ink); }
        .sticker--tomato { background: var(--tomato); color: #fff; }
        .sticker--ink { background: var(--ink); color: var(--gold); }
        .sticker--paper { background: var(--paper); color: var(--ink); }

        .sticker-headline {
            display: inline-block;
            padding: 0.12em 0.36em;
            border-radius: 14px;
            border: 3px solid #fff;
            background: var(--ink);
            color: var(--lime);
            font-family: 'Bowlby One', sans-serif;
            text-transform: uppercase;
            transform: rotate(var(--tilt, -3deg));
            box-shadow: 6px 6px 0 rgba(0, 0, 0, 0.18);
            vertical-align: middle;
        }
        .sticker-headline--gold { color: var(--gold); }
        .sticker-headline--tomato { background: var(--tomato); color: #fff; border-color: var(--ink); box-shadow: 5px 5px 0 var(--ink); }

        /* 4.4 Scalloped Edges */
        .scallop-top { position: relative; }
        .scallop-top::before {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: -20px;
            height: 21px;
            background: radial-gradient(circle at 22px 22px, var(--scallop, var(--paper)) 21px, transparent 22px) 0 0 / 44px 22px repeat-x;
            pointer-events: none;
            z-index: 2;
        }
        .scallop-bottom { position: relative; }
        .scallop-bottom::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -20px;
            height: 21px;
            background: radial-gradient(circle at 22px 0px, var(--scallop, var(--paper)) 21px, transparent 22px) 0 0 / 44px 22px repeat-x;
            pointer-events: none;
            z-index: 2;
        }

        /* 4.5 Biscuit Scalloped Cards */
        .card-bite {
            position: relative;
            background: var(--paper);
            border: 2.5px solid var(--ink);
            border-radius: 24px;
            box-shadow: 4px 4px 0 var(--ink);
            overflow: hidden;
            transform: rotate(var(--r, -2deg));
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-bite:hover {
            transform: rotate(0deg) translateY(-6px);
            box-shadow: 6px 6px 0 var(--ink);
            z-index: 20;
        }
        .card-bite__foot {
            position: relative;
            background: var(--navy);
            color: #fff;
            --scallop: #0F2C59;
        }
        .card-bite__foot::before {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: -12px;
            height: 13px;
            background: radial-gradient(circle at 12px 13px, var(--navy) 12px, transparent 13px) 0 0 / 24px 13px repeat-x;
            pointer-events: none;
        }

        /* 4.6 Marquee */
        .marquee {
            overflow: hidden;
            border-block: 3px solid var(--ink);
            background: var(--gold);
            color: var(--ink);
            transform: rotate(var(--tilt, -2deg));
            margin-inline: -2%;
        }
        .marquee--lime { background: var(--lime); }
        .marquee--ink { background: var(--ink); color: var(--gold); }
        .marquee__track {
            display: flex;
            width: max-content;
            gap: 2rem;
            padding: 0.85rem 0;
            animation: marquee 28s linear infinite;
            font-family: 'Bowlby One', sans-serif;
            text-transform: uppercase;
            font-size: 15px;
            letter-spacing: 0.03em;
        }
        @keyframes marquee {
            to { transform: translateX(-50%); }
        }

        /* 4.9 Scroll Reveal */
        .reveal {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity 0.55s ease, transform 0.55s ease;
        }
        .reveal.is-in {
            opacity: 1;
            transform: translateY(0);
        }

        /* 4.10 Mascot Wiggle */
        @keyframes wiggle {
            0%, 100% { transform: rotate(-4deg); }
            50% { transform: rotate(4deg); }
        }
        .wiggle {
            animation: wiggle 3s ease-in-out infinite;
            transform-origin: center bottom;
        }

        /* Reduced Motion */
        @media (prefers-reduced-motion: reduce) {
            .marquee__track { animation: none !important; }
            .wiggle { animation: none !important; }
            .reveal {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
            .btn-roll > span { transition: none !important; }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-cream text-ink font-sans antialiased selection:bg-gold selection:text-ink"
      x-data="{ mobileMenuOpen: false, reportModalOpen: {{ session('report_error') ? 'true' : 'false' }}, scrolled: false }"
      @scroll.window="scrolled = window.scrollY > 10">

    <!-- Sticky Neo-Brutalist Navbar -->
    <header class="sticky top-0 z-40 transition-all duration-200"
            :class="scrolled ? 'bg-paper/95 backdrop-blur-md border-b-[2.5px] border-ink shadow-sm' : 'bg-cream/90 backdrop-blur-sm'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-[72px]">
                <!-- Wordmark Logo with Yellow Star replacing I -->
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 group select-none">
                    <span class="font-display text-xl sm:text-2xl tracking-tight text-ink flex items-center">
                        MUST
                        <span class="relative inline-flex flex-col items-center justify-end mx-[1px]">
                            <svg class="w-3.5 h-3.5 text-gold -mb-1.5 group-hover:rotate-12 transition-transform" viewBox="0 0 24 24" fill="currentColor" stroke="#111" stroke-width="2">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                            <span class="block w-[5px] h-[14px] bg-ink rounded-[2px]"></span>
                        </span>
                        KA
                        <span class="ml-1 px-2 py-0.5 rounded-lg bg-navy text-gold text-base sm:text-lg border-2 border-ink">BIMBEL</span>
                    </span>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden xl:flex items-center gap-6 font-label text-[13px] font-bold uppercase tracking-wide text-ink">
                    <a href="#keunggulan" class="hover:text-tomato transition-colors whitespace-nowrap">Keunggulan</a>
                    <a href="#tantangan-30-detik" class="hover:text-tomato transition-colors inline-flex items-center gap-1.5 whitespace-nowrap">
                        <span class="w-2.5 h-2.5 rounded-full bg-lime border border-ink shrink-0"></span>
                        Tantangan 30 Detik
                    </a>
                    <a href="#metode-kurikulum" class="hover:text-tomato transition-colors whitespace-nowrap">Program</a>
                    <a href="#jadwal-belajar" class="hover:text-tomato transition-colors whitespace-nowrap">Jadwal</a>
                    <a href="#lokasi" class="hover:text-tomato transition-colors whitespace-nowrap">Lokasi</a>
                </nav>

                <!-- Action Buttons & Hamburger -->
                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <!-- Tablet & Desktop Action Buttons -->
                    <div class="hidden sm:flex items-center gap-3">
                        <button @click="reportModalOpen = true" type="button"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full border-2 border-ink bg-paper hover:bg-lime font-label text-xs font-bold uppercase tracking-wide text-ink shadow-[2px_2px_0_#111] transition-all whitespace-nowrap">
                            <i data-lucide="file-bar-chart-2" class="w-4 h-4 shrink-0"></i>
                            <span>Cek Raport</span>
                        </button>
                        <a href="#form-trial" class="btn-pop btn-pop--sm">
                            <span class="btn-roll">
                                <span>Daftar Gratis</span>
                                <span aria-hidden="true">Daftar Gratis</span>
                            </span>
                            <span class="btn-pop__dot"><i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></span>
                        </a>
                    </div>

                    <!-- Mobile-Only Compact Raport Button -->
                    <button @click="reportModalOpen = true" type="button"
                            class="sm:hidden h-11 px-3 rounded-xl border-2 border-ink bg-paper text-ink font-label text-xs font-bold uppercase shadow-[3px_3px_0_#111] flex items-center gap-1 whitespace-nowrap">
                        <i data-lucide="file-bar-chart-2" class="w-4 h-4 shrink-0"></i>
                        <span>Raport</span>
                    </button>

                    <!-- Hamburger Button (< xl) -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                            class="xl:hidden w-11 h-11 rounded-xl border-2 border-ink bg-gold text-ink shadow-[3px_3px_0_#111] flex items-center justify-center shrink-0"
                            aria-label="Buka Menu">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Fullscreen Gold Mobile Menu (< xl) -->
    <div x-show="mobileMenuOpen" x-cloak x-transition.opacity
         class="fixed inset-0 z-50 bg-gold text-ink flex flex-col justify-between p-6 xl:hidden overflow-y-auto">
        <div class="flex items-center justify-between">
            <span class="font-display text-2xl">MUSTIKA BIMBEL</span>
            <button @click="mobileMenuOpen = false" type="button"
                    class="w-11 h-11 rounded-xl border-2 border-ink bg-paper text-ink shadow-[3px_3px_0_#111] flex items-center justify-center"
                    aria-label="Tutup Menu">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <nav class="my-8 flex flex-col gap-4">
            <a @click="mobileMenuOpen = false" href="#keunggulan" class="font-display text-4xl leading-none hover:text-navy">Keunggulan</a>
            <a @click="mobileMenuOpen = false" href="#tantangan-30-detik" class="font-display text-4xl leading-none hover:text-navy">Tantangan 30 Detik</a>
            <a @click="mobileMenuOpen = false" href="#metode-kurikulum" class="font-display text-4xl leading-none hover:text-navy">Program</a>
            <a @click="mobileMenuOpen = false" href="#jadwal-belajar" class="font-display text-4xl leading-none hover:text-navy">Jadwal</a>
            <a @click="mobileMenuOpen = false" href="#lokasi" class="font-display text-4xl leading-none hover:text-navy">Lokasi</a>
        </nav>

        <div class="space-y-3 pt-4 border-t-2 border-ink/20">
            <button @click="mobileMenuOpen = false; reportModalOpen = true" type="button"
                    class="w-full py-3.5 rounded-full border-[3px] border-ink bg-paper text-ink font-display text-sm uppercase shadow-[4px_4px_0_#111]">
                Cek Raport Siswa
            </button>
            <a @click="mobileMenuOpen = false" href="#form-trial" class="btn-pop btn-pop--ink w-full">
                <span class="btn-roll">
                    <span>Daftar Coba Gratis</span>
                    <span aria-hidden="true">Daftar Coba Gratis</span>
                </span>
                <span class="btn-pop__dot"><i data-lucide="arrow-right" class="w-4 h-4"></i></span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Official Footer (Navy Dark + Scalloped Top) -->
    <footer class="bg-navy-dark text-slate-200 pt-16 pb-12 scallop-top mt-8" style="--scallop: #091C3A;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Giant Tagline (Required exact string for SystemAuditTest) -->
            <div class="pb-10 mb-10 border-b-2 border-white/15">
                <p class="font-display text-2xl sm:text-4xl lg:text-5xl text-gold leading-tight">
                    Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!
                </p>
                <p class="font-script text-2xl sm:text-3xl text-lime mt-2">
                    Bimbel MIPA untuk Masa Depanmu
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-10 border-b border-white/10">
                <!-- Col 1: Brand -->
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2">
                        <span class="w-10 h-10 rounded-xl bg-gold border-2 border-ink flex items-center justify-center text-ink font-display text-xl">
                            M
                        </span>
                        <div>
                            <span class="font-display text-lg text-white block leading-none">MustikaBimbel</span>
                            <span class="text-xs text-slate-400">Bimbel MIPA untuk Masa Depanmu</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Belajar bukan sekadar menghafal rumus. Pahami cara kerjanya, kuasai langkahnya, dan temukan cara menyelesaikan soal dengan lebih efektif.
                    </p>
                </div>

                <!-- Col 2: Program Unggulan -->
                <div>
                    <h3 class="font-label text-xs font-bold text-gold uppercase tracking-wider mb-4">Program Unggulan</h3>
                    <ul class="space-y-2.5 text-sm text-slate-200">
                        <li class="flex items-center gap-2">
                            <i data-lucide="star" class="w-4 h-4 text-gold shrink-0"></i>
                            Jarimatika &amp; Hitung Cepat (TK – SD)
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="star" class="w-4 h-4 text-gold shrink-0"></i>
                            Bimbel Matematika &amp; Sains SD (Kelas 1–6)
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="star" class="w-4 h-4 text-gold shrink-0"></i>
                            Bimbel MIPA SMP (Mat, Fis, Kim, Bio)
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="star" class="w-4 h-4 text-gold shrink-0"></i>
                            Persiapan Ujian Sekolah &amp; Masuk SMA
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Jadwal Belajar Resmi -->
                <div>
                    <h3 class="font-label text-xs font-bold text-gold uppercase tracking-wider mb-4">Jadwal Belajar Resmi</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li class="bg-white/5 p-2.5 rounded-xl border border-white/15">
                            <span class="font-bold text-gold block">Senin – Kamis</span>
                            <span class="text-xs text-slate-300">18.30 – 20.00 WIB</span>
                        </li>
                        <li class="bg-white/5 p-2.5 rounded-xl border border-white/15">
                            <span class="font-bold text-gold block">Sabtu</span>
                            <span class="text-xs text-slate-300">16.00 – 17.30 WIB</span>
                        </li>
                        <li class="bg-white/5 p-2.5 rounded-xl border border-white/15">
                            <span class="font-bold text-gold block">Minggu</span>
                            <span class="text-xs text-slate-300">18.30 – 20.00 WIB</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Lokasi & Kontak -->
                <div class="space-y-3">
                    <h3 class="font-label text-xs font-bold text-gold uppercase tracking-wider mb-4">Lokasi &amp; Kontak</h3>
                    <p class="text-sm flex items-start gap-2.5 text-slate-200">
                        <i data-lucide="map-pin" class="w-5 h-5 text-gold shrink-0 mt-0.5"></i>
                        <span>Perumahan Amarylis Garden, Jalan H Abdul Gani II Blok I No. 11, Harapan Jaya, Cibinong</span>
                    </p>
                    <p class="text-sm flex items-center gap-2.5 text-slate-200">
                        <i data-lucide="phone" class="w-4 h-4 text-gold shrink-0"></i>
                        <a href="https://wa.me/6287705555190" target="_blank" class="hover:text-gold font-bold">087705555190 (WhatsApp)</a>
                    </p>
                    <div class="pt-2 flex items-center gap-3">
                        <a href="{{ url('/login') }}" class="text-xs text-slate-400 hover:text-gold underline flex items-center gap-1">
                            <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                            Login Pengajar / Admin
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
                <p>&copy; {{ date('Y') }} <strong class="text-white">MustikaBimbel Cibinong</strong>. Seluruh hak cipta dilindungi.</p>
                <p>Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!</p>
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
