<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin & Pengajar — MustikaBimbel')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
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
                            dark: '#091C3A',
                            hover: '#163A70',
                        },
                        gold: {
                            DEFAULT: '#FACC15',
                            hover: '#FFD100',
                        },
                        edu: {
                            teal: '#0D9488',
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
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased selection:bg-[#FACC15] selection:text-[#0F2C59]"
      x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex">
        <!-- Sidebar Backdrop for Mobile -->
        <div x-show="sidebarOpen" x-cloak
             @click="sidebarOpen = false"
             class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden transition-opacity"></div>

        <!-- Sidebar Navigation -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#091C3A] text-white flex flex-col justify-between transition-transform duration-300 lg:static lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div>
                <!-- Brand Header -->
                <div class="h-20 flex items-center justify-between px-6 border-b border-white/10">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#FACC15] text-[#0F2C59] flex items-center justify-center font-extrabold text-xl shadow">
                            M
                        </div>
                        <div>
                            <span class="text-lg font-extrabold tracking-tight text-white block leading-none">
                                Mustika<span class="text-[#FACC15]">Bimbel</span>
                            </span>
                            <span class="text-[10px] text-slate-400 font-medium">Panel Pengajar &amp; Admin</span>
                        </div>
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Nav Menu Items -->
                <nav class="p-4 space-y-1 text-sm font-semibold">
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#FACC15] text-[#0F2C59] font-extrabold shadow' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        <span>Dashboard Utama</span>
                    </a>

                    <a href="{{ route('admin.attendance.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.attendance*') ? 'bg-[#FACC15] text-[#0F2C59] font-extrabold shadow' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i data-lucide="calendar-check" class="w-4 h-4"></i>
                        <span>Presensi &amp; Jurnal WA</span>
                    </a>

                    <a href="{{ route('admin.leads.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.leads*') ? 'bg-[#FACC15] text-[#0F2C59] font-extrabold shadow' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>Pendaftar Trial (Leads)</span>
                    </a>

                    <a href="{{ route('admin.students.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.students*') ? 'bg-[#FACC15] text-[#0F2C59] font-extrabold shadow' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                        <span>Data Siswa &amp; Badges</span>
                    </a>

                    <a href="{{ route('admin.schedules.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.schedules*') ? 'bg-[#FACC15] text-[#0F2C59] font-extrabold shadow' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        <span>Jadwal &amp; Kuota Kelas</span>
                    </a>

                    <a href="{{ route('admin.invoices.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.invoices*') ? 'bg-[#FACC15] text-[#0F2C59] font-extrabold shadow' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i data-lucide="receipt" class="w-4 h-4"></i>
                        <span>Tagihan SPP &amp; Kwitansi</span>
                    </a>

                    <div class="pt-4 border-t border-white/10 mt-4">
                        <span class="px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-2">
                            Pintasan Cepat
                        </span>
                        <a href="{{ url('/') }}" target="_blank"
                           class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-300 hover:bg-white/10 hover:text-[#FACC15] text-xs">
                            <i data-lucide="external-link" class="w-4 h-4"></i>
                            <span>Buka Landing Page</span>
                        </a>
                    </div>
                </nav>
            </div>

            <!-- User Footer & Logout -->
            <div class="p-4 border-t border-white/10 bg-black/20">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-9 h-9 rounded-xl bg-[#0F2C59] border border-white/20 text-[#FACC15] flex items-center justify-center font-extrabold text-sm shrink-0">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-white block truncate">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                            <span class="text-[10px] text-slate-400 block capitalize">{{ Auth::user()->role ?? 'Admin' }}</span>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" title="Keluar"
                                class="p-2 rounded-lg text-rose-300 hover:text-white hover:bg-rose-600/30 transition-colors">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Bar -->
            <header class="h-16 sm:h-20 bg-white border-b border-slate-200 px-4 sm:px-8 flex items-center justify-between sticky top-0 z-30 shadow-sm">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <h1 class="text-base sm:text-xl font-extrabold text-[#0F2C59]">@yield('header_title', 'Dashboard')</h1>
                        <p class="text-xs text-slate-500 hidden sm:block">Perumahan Amarylis Garden Blok I No. 11, Cibinong</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="https://wa.me/6287705555190" target="_blank"
                       class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-200 hover:bg-emerald-100 transition-colors">
                        <i data-lucide="phone" class="w-3.5 h-3.5 text-emerald-600"></i>
                        WA: 087705555190
                    </a>
                </div>
            </header>

            <!-- Page Body -->
            <main class="p-4 sm:p-8 flex-1">
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-sm font-bold text-emerald-800 flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-sm font-bold text-rose-800 flex items-center gap-2">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-rose-600 shrink-0"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

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
