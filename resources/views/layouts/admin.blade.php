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
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    @stack('styles')
</head>
<body class="bg-[#F8FAFC] font-sans text-slate-800 antialiased selection:bg-[#FACC15] selection:text-[#0F2C59]"
      x-data="{
          sidebarOpen: false,
          sidebarCollapsed: JSON.parse(localStorage.getItem('mb_sidebar_collapsed') || 'false'),
          cmdOpen: false,
          cmdQuery: '',
          quickStudents: @js($adminQuickStudents ?? []),
          quickMenus: [
              { label: 'Dashboard Utama', desc: 'Ringkasan metrik, kas & target', url: '{{ route('admin.dashboard') }}', badge: 'Menu' },
              { label: 'Presensi & Jurnal WA', desc: 'Absen 1-klik & laporan pulang WA', url: '{{ route('admin.attendance.index') }}', badge: 'Menu' },
              { label: 'Pendaftar Trial (Leads)', desc: 'Follow-up calon siswa & konversi', url: '{{ route('admin.leads.index') }}', badge: 'Menu' },
              { label: 'Data Siswa & Badges', desc: 'Daftar siswa, Profil 360 & lencana', url: '{{ route('admin.students.index') }}', badge: 'Menu' },
              { label: 'Tambah Siswa Baru', desc: 'Formulir pendaftaran siswa baru', url: '{{ route('admin.students.create') }}', badge: 'Aksi' },
              { label: 'Jadwal & Kuota Kelas', desc: 'Atur sesi belajar & kapasitas kursi', url: '{{ route('admin.schedules.index') }}', badge: 'Menu' },
              { label: 'Tagihan SPP & Cicilan', desc: 'Generate tagihan, catat bayar & cicilan', url: '{{ route('admin.invoices.index') }}', badge: 'Keuangan' },
              { label: 'Kartu SPP 12 Bulan', desc: 'Matriks status SPP 1 tahun penuh', url: '{{ route('admin.invoices.card') }}', badge: 'Keuangan' },
              { label: 'Pengeluaran Operasional', desc: 'Catat biaya ATK, modul & listrik', url: '{{ route('admin.expenses.index') }}', badge: 'Keuangan' },
              { label: 'Laporan Laba Bersih', desc: 'Grafik kas masuk, keluar & profit 12 bln', url: '{{ route('admin.reports.index') }}', badge: 'Keuangan' },
              { label: 'Pengaturan & Template WA', desc: 'Rekening/QRIS, jatuh tempo & teks WA', url: '{{ route('admin.settings.index') }}', badge: 'Sistem' }
          ],
          toggleSidebar() {
              if (window.innerWidth >= 1280) {
                  this.sidebarCollapsed = !this.sidebarCollapsed;
                  localStorage.setItem('mb_sidebar_collapsed', JSON.stringify(this.sidebarCollapsed));
              } else {
                  this.sidebarOpen = !this.sidebarOpen;
              }
          },
          openCommand() {
              this.cmdOpen = true;
              this.$nextTick(() => this.$refs.cmdInput?.focus());
          },
          get filteredStudents() {
              const q = this.cmdQuery.trim().toLowerCase();
              if (!q) return this.quickStudents.slice(0, 5);
              return this.quickStudents.filter(s =>
                  s.name.toLowerCase().includes(q) || s.code.toLowerCase().includes(q)
              ).slice(0, 6);
          },
          get filteredMenus() {
              const q = this.cmdQuery.trim().toLowerCase();
              if (!q) return this.quickMenus.slice(0, 5);
              return this.quickMenus.filter(m =>
                  m.label.toLowerCase().includes(q) || m.desc.toLowerCase().includes(q)
              ).slice(0, 6);
          }
      }"
      @keydown.window="if ((($event.metaKey || $event.ctrlKey) && $event.key.toLowerCase() === 'k')) { $event.preventDefault(); openCommand(); }">

    <div class="flex h-screen overflow-hidden">
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" x-cloak
             @click="sidebarOpen = false"
             x-transition.opacity
             class="fixed inset-0 z-40 bg-[#091C3A]/60 backdrop-blur-xs xl:hidden"></div>

        <!-- ===== TailAdmin-style Sidebar ===== -->
        <aside class="fixed inset-y-0 left-0 z-50 flex h-screen flex-col justify-between bg-[#091C3A] text-white border-r border-[#0F2C59] transition-all duration-300 xl:static xl:translate-x-0 shrink-0"
               :class="[
                   sidebarOpen ? 'translate-x-0' : '-translate-x-full',
                   sidebarCollapsed ? 'xl:w-[88px] px-3' : 'w-[276px] px-4'
               ]">

            <div class="flex flex-col flex-1 min-h-0">
                <!-- Sidebar Header (Logo) -->
                <div class="h-18 flex items-center pt-5 pb-6 shrink-0"
                     :class="sidebarCollapsed ? 'xl:justify-center justify-between' : 'justify-between px-1'">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-[10px] bg-[#FACC15] text-[#0F2C59] flex items-center justify-center font-extrabold text-lg shadow-sm shrink-0">
                            M
                        </div>
                        <div class="min-w-0" :class="sidebarCollapsed ? 'xl:hidden' : ''">
                            <span class="text-base font-extrabold tracking-tight text-white block leading-tight truncate">
                                Mustika<span class="text-[#FACC15]">Bimbel</span>
                            </span>
                            <span class="text-[11px] text-slate-400 font-medium block truncate">Admin &amp; Pengajar</span>
                        </div>
                    </a>
                    <button type="button" @click="sidebarOpen = false" class="xl:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-white/10">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Scrollable Grouped Navigation -->
                <div class="no-scrollbar flex-1 overflow-y-auto space-y-6 pb-6">

                    <!-- Group 1: MENU UTAMA -->
                    <div>
                        <h3 class="mb-2.5 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                            :class="sidebarCollapsed ? 'xl:text-center xl:px-0' : ''">
                            <span :class="sidebarCollapsed ? 'xl:hidden' : ''">Menu Utama</span>
                            <span class="hidden" :class="sidebarCollapsed ? 'xl:inline-block' : ''">•••</span>
                        </h3>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" title="Dashboard Utama"
                                   class="group flex items-center gap-3 rounded-[10px] px-3 py-2.5 text-[13.5px] font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#FACC15] text-[#0F2C59] font-bold shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
                                   :class="sidebarCollapsed ? 'xl:justify-center xl:px-0' : ''">
                                    <i data-lucide="layout-grid" class="w-5 h-5 shrink-0"></i>
                                    <span class="truncate" :class="sidebarCollapsed ? 'xl:hidden' : ''">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.attendance.index') }}" title="Presensi & Jurnal WA"
                                   class="group flex items-center gap-3 rounded-[10px] px-3 py-2.5 text-[13.5px] font-medium transition-colors {{ request()->routeIs('admin.attendance*') ? 'bg-[#FACC15] text-[#0F2C59] font-bold shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
                                   :class="sidebarCollapsed ? 'xl:justify-center xl:px-0' : ''">
                                    <i data-lucide="calendar-check-2" class="w-5 h-5 shrink-0"></i>
                                    <span class="truncate" :class="sidebarCollapsed ? 'xl:hidden' : ''">Presensi &amp; Jurnal WA</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.leads.index') }}" title="Pendaftar Trial (Leads)"
                                   class="group flex items-center justify-between rounded-[10px] px-3 py-2.5 text-[13.5px] font-medium transition-colors {{ request()->routeIs('admin.leads*') ? 'bg-[#FACC15] text-[#0F2C59] font-bold shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
                                   :class="sidebarCollapsed ? 'xl:justify-center xl:px-0' : ''">
                                    <span class="flex items-center gap-3 min-w-0">
                                        <i data-lucide="user-plus" class="w-5 h-5 shrink-0"></i>
                                        <span class="truncate" :class="sidebarCollapsed ? 'xl:hidden' : ''">Pendaftar Trial</span>
                                    </span>
                                    @if(($adminNotifLeads?->count() ?? 0) > 0)
                                        <span class="px-1.5 py-0.5 rounded-md text-[10px] font-extrabold {{ request()->routeIs('admin.leads*') ? 'bg-[#0F2C59] text-[#FACC15]' : 'bg-[#FACC15]/20 text-[#FACC15]' }}"
                                              :class="sidebarCollapsed ? 'xl:hidden' : ''">
                                            {{ $adminNotifLeads->count() }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Group 2: AKADEMIK -->
                    <div>
                        <h3 class="mb-2.5 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                            :class="sidebarCollapsed ? 'xl:text-center xl:px-0' : ''">
                            <span :class="sidebarCollapsed ? 'xl:hidden' : ''">Akademik</span>
                            <span class="hidden" :class="sidebarCollapsed ? 'xl:inline-block' : ''">•••</span>
                        </h3>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('admin.students.index') }}" title="Data Siswa & Badges"
                                   class="group flex items-center gap-3 rounded-[10px] px-3 py-2.5 text-[13.5px] font-medium transition-colors {{ request()->routeIs('admin.students*') ? 'bg-[#FACC15] text-[#0F2C59] font-bold shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
                                   :class="sidebarCollapsed ? 'xl:justify-center xl:px-0' : ''">
                                    <i data-lucide="graduation-cap" class="w-5 h-5 shrink-0"></i>
                                    <span class="truncate" :class="sidebarCollapsed ? 'xl:hidden' : ''">Data Siswa &amp; Badges</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.schedules.index') }}" title="Jadwal & Kuota Kelas"
                                   class="group flex items-center gap-3 rounded-[10px] px-3 py-2.5 text-[13.5px] font-medium transition-colors {{ request()->routeIs('admin.schedules*') ? 'bg-[#FACC15] text-[#0F2C59] font-bold shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
                                   :class="sidebarCollapsed ? 'xl:justify-center xl:px-0' : ''">
                                    <i data-lucide="clock-3" class="w-5 h-5 shrink-0"></i>
                                    <span class="truncate" :class="sidebarCollapsed ? 'xl:hidden' : ''">Jadwal &amp; Kuota Kelas</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Group 3: KEUANGAN & SISTEM -->
                    <div x-data="{ openFinance: {{ request()->routeIs('admin.invoices*', 'admin.expenses*', 'admin.reports*') ? 'true' : 'false' }} }">
                        <h3 class="mb-2.5 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                            :class="sidebarCollapsed ? 'xl:text-center xl:px-0' : ''">
                            <span :class="sidebarCollapsed ? 'xl:hidden' : ''">Keuangan &amp; Sistem</span>
                            <span class="hidden" :class="sidebarCollapsed ? 'xl:inline-block' : ''">•••</span>
                        </h3>
                        <ul class="space-y-1">
                            <!-- Accordion Submenu Keuangan -->
                            <li>
                                <button type="button"
                                        @click="if (sidebarCollapsed && window.innerWidth >= 1280) { window.location = '{{ route('admin.invoices.index') }}'; } else { openFinance = !openFinance; }"
                                        title="Administrasi SPP & Keuangan"
                                        class="w-full group flex items-center justify-between rounded-[10px] px-3 py-2.5 text-[13.5px] font-medium transition-colors {{ request()->routeIs('admin.invoices*', 'admin.expenses*', 'admin.reports*') ? 'bg-white/10 text-[#FACC15] font-semibold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
                                        :class="sidebarCollapsed ? 'xl:justify-center xl:px-0' : ''">
                                    <span class="flex items-center gap-3 min-w-0">
                                        <i data-lucide="receipt" class="w-5 h-5 shrink-0"></i>
                                        <span class="truncate" :class="sidebarCollapsed ? 'xl:hidden' : ''">Keuangan &amp; SPP</span>
                                    </span>
                                    <i data-lucide="chevron-down"
                                       class="w-4 h-4 shrink-0 transition-transform duration-200"
                                       :class="[openFinance ? 'rotate-180' : '', sidebarCollapsed ? 'xl:hidden' : '']"></i>
                                </button>

                                <ul x-show="openFinance" x-cloak
                                    :class="sidebarCollapsed ? 'xl:hidden' : ''"
                                    class="mt-1 space-y-1 pl-9 pr-1">
                                    <li>
                                        <a href="{{ route('admin.invoices.index') }}"
                                           class="block rounded-lg px-3 py-2 text-[13px] font-medium transition-colors {{ request()->routeIs('admin.invoices.index') ? 'bg-[#FACC15] text-[#0F2C59] font-bold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                                            Tagihan &amp; Cicilan
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.invoices.card') }}"
                                           class="block rounded-lg px-3 py-2 text-[13px] font-medium transition-colors {{ request()->routeIs('admin.invoices.card') ? 'bg-[#FACC15] text-[#0F2C59] font-bold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                                            Kartu SPP 12 Bulan
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.expenses.index') }}"
                                           class="block rounded-lg px-3 py-2 text-[13px] font-medium transition-colors {{ request()->routeIs('admin.expenses*') ? 'bg-[#FACC15] text-[#0F2C59] font-bold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                                            Pengeluaran
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.reports.index') }}"
                                           class="block rounded-lg px-3 py-2 text-[13px] font-medium transition-colors {{ request()->routeIs('admin.reports*') ? 'bg-[#FACC15] text-[#0F2C59] font-bold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                                            Laporan Laba Bersih
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{ route('admin.settings.index') }}" title="Pengaturan & Template WA"
                                   class="group flex items-center gap-3 rounded-[10px] px-3 py-2.5 text-[13.5px] font-medium transition-colors {{ request()->routeIs('admin.settings*') ? 'bg-[#FACC15] text-[#0F2C59] font-bold shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
                                   :class="sidebarCollapsed ? 'xl:justify-center xl:px-0' : ''">
                                    <i data-lucide="settings" class="w-5 h-5 shrink-0"></i>
                                    <span class="truncate" :class="sidebarCollapsed ? 'xl:hidden' : ''">Pengaturan &amp; WA</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- TailAdmin-style Bottom Promo / Shortcut Card -->
            <div class="pb-4 pt-2 shrink-0" :class="sidebarCollapsed ? 'xl:hidden' : ''">
                <div class="rounded-2xl bg-[#0F2C59]/80 border border-white/10 p-4 text-center">
                    <div class="text-xs font-bold text-white">{{ $adminBimbelName ?? 'MustikaBimbel' }}</div>
                    <p class="text-[11px] text-slate-300 mt-1 mb-3 leading-relaxed">
                        Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!
                    </p>
                    <a href="{{ url('/') }}" target="_blank"
                       class="inline-flex w-full items-center justify-center gap-1.5 rounded-[10px] bg-[#0D9488] hover:bg-teal-600 px-3 py-2 text-xs font-bold text-white transition-colors">
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                        <span>Buka Landing Page</span>
                    </a>
                </div>
            </div>
        </aside>

        <!-- ===== Content Area Wrapper ===== -->
        <div class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto">

            <!-- ===== TailAdmin Sticky Header ===== -->
            <header class="sticky top-0 z-30 flex w-full shrink-0 border-b border-slate-200 bg-white">
                <div class="flex grow items-center justify-between gap-3 px-4 py-3 xl:px-6 xl:py-3.5">
                    <!-- Left: Sidebar Toggle + Global Search (⌘K) -->
                    <div class="flex items-center gap-3 sm:gap-4">
                        <button type="button"
                                @click="toggleSidebar()"
                                aria-label="Toggle Sidebar"
                                class="inline-flex size-10 shrink-0 items-center justify-center rounded-[10px] border border-slate-200 bg-white text-slate-500 transition-colors hover:bg-slate-50 hover:text-[#0F2C59]">
                            <i data-lucide="panel-left" class="w-5 h-5 hidden xl:block"></i>
                            <i data-lucide="menu" class="w-5 h-5 xl:hidden"></i>
                        </button>

                        <!-- Global Search Trigger (⌘K) -->
                        <button type="button"
                                @click="openCommand()"
                                class="hidden md:flex items-center justify-between w-72 lg:w-96 h-10 rounded-[10px] border border-slate-200 bg-slate-50/60 px-3.5 text-sm text-slate-400 hover:border-slate-300 hover:bg-white transition-colors">
                            <span class="flex items-center gap-2.5 truncate">
                                <i data-lucide="search" class="w-4 h-4 text-slate-400 shrink-0"></i>
                                <span class="text-xs sm:text-[13px]">Cari cepat siswa, kode MB, atau menu...</span>
                            </span>
                            <span class="inline-flex items-center gap-0.5 rounded-md border border-slate-200 bg-white px-1.5 py-0.5 text-[11px] font-semibold text-slate-500 shadow-2xs">
                                ⌘K
                            </span>
                        </button>
                    </div>

                    <!-- Right: Quick Search Mobile + WA Admin + Notifications + User Profile Dropdown -->
                    <div class="flex items-center gap-2 sm:gap-3">
                        <button type="button" @click="openCommand()" aria-label="Cari Cepat"
                                class="md:hidden inline-flex size-10 items-center justify-center rounded-[10px] border border-slate-200 bg-white text-slate-600 hover:bg-slate-50">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </button>

                        <a href="https://wa.me/{{ $adminWaFormatted ?? '6287705555190' }}" target="_blank"
                           class="hidden sm:inline-flex h-10 items-center gap-1.5 rounded-[10px] border border-emerald-200 bg-emerald-50/70 px-3 text-xs font-bold text-emerald-800 hover:bg-emerald-100 transition-colors">
                            <i data-lucide="message-circle" class="w-4 h-4 text-emerald-600"></i>
                            <span class="hidden lg:inline">WA: {{ $adminWaDisplay ?? '087705555190' }}</span>
                        </a>

                        <!-- Notification Bell Dropdown -->
                        <div class="relative" x-data="{ notifOpen: false }" @click.outside="notifOpen = false" @keydown.escape.window="notifOpen = false">
                            <button type="button" @click="notifOpen = !notifOpen" aria-label="Notifikasi"
                                    class="relative inline-flex size-10 items-center justify-center rounded-[10px] border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:text-[#0F2C59] transition-colors">
                                @if(($adminNotifTotal ?? 0) > 0)
                                    <span class="absolute right-2 top-2 flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                                    </span>
                                @endif
                                <i data-lucide="bell" class="w-5 h-5"></i>
                            </button>

                            <div x-show="notifOpen" x-cloak x-transition
                                 class="absolute right-0 mt-2 w-80 max-w-[calc(100vw-2rem)] rounded-2xl border border-slate-200 bg-white p-3 shadow-xl z-50">
                                <div class="flex items-center justify-between px-2 pb-2.5 border-b border-slate-100">
                                    <span class="text-sm font-bold text-[#0F2C59]">Notifikasi Operasional</span>
                                    <span class="px-2 py-0.5 rounded-md bg-[#FACC15]/30 text-[#0F2C59] text-[11px] font-bold">
                                        {{ $adminNotifTotal ?? 0 }} Info
                                    </span>
                                </div>
                                <div class="mt-2 space-y-1 max-h-72 overflow-y-auto">
                                    @if(($adminNotifOverdue ?? 0) > 0)
                                        <a href="{{ route('admin.students.index', ['attention' => 1]) }}"
                                           class="flex items-start gap-2.5 rounded-xl p-2.5 hover:bg-rose-50/70 transition-colors">
                                            <div class="size-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                                                <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                                            </div>
                                            <div class="text-xs">
                                                <div class="font-bold text-slate-800">{{ $adminNotifOverdue }} Siswa Tunggakan SPP</div>
                                                <div class="text-slate-500 mt-0.5">Klik untuk tinjau &amp; kirim pengingat WA.</div>
                                            </div>
                                        </a>
                                    @endif

                                    @forelse($adminNotifLeads ?? [] as $nl)
                                        <a href="{{ route('admin.leads.index', ['status' => 'Baru']) }}"
                                           class="flex items-start gap-2.5 rounded-xl p-2.5 hover:bg-slate-50 transition-colors">
                                            <div class="size-8 rounded-lg bg-[#0F2C59]/10 text-[#0F2C59] flex items-center justify-center shrink-0">
                                                <i data-lucide="sparkles" class="w-4 h-4"></i>
                                            </div>
                                            <div class="text-xs min-w-0">
                                                <div class="font-bold text-slate-800 truncate">Trial Baru: {{ $nl->student_name }}</div>
                                                <div class="text-slate-500 mt-0.5">Jenjang {{ $nl->grade_level }} &bull; {{ $nl->created_at?->diffForHumans() }}</div>
                                            </div>
                                        </a>
                                    @empty
                                        @if(($adminNotifOverdue ?? 0) === 0)
                                            <div class="py-6 text-center text-xs text-slate-400">
                                                Semua aman! Tidak ada antrean baru.
                                            </div>
                                        @endif
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- User Profile Dropdown (TailAdmin rounded-lg square avatar) -->
                        <div class="relative" x-data="{ userOpen: false }" @click.outside="userOpen = false" @keydown.escape.window="userOpen = false">
                            <button type="button" @click="userOpen = !userOpen"
                                    class="flex items-center gap-2.5 rounded-[10px] p-1 hover:bg-slate-50 transition-colors">
                                <div class="size-10 rounded-[10px] bg-[#0F2C59] text-[#FACC15] flex items-center justify-center font-extrabold text-sm shrink-0">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </div>
                                <div class="hidden sm:block text-left leading-tight">
                                    <span class="block text-xs font-bold text-slate-800 max-w-[130px] truncate">{{ Auth::user()->name ?? 'Admin' }}</span>
                                    <span class="block text-[11px] text-slate-500 capitalize">{{ Auth::user()->role ?? 'Admin' }}</span>
                                </div>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 hidden sm:block transition-transform" :class="userOpen ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="userOpen" x-cloak x-transition
                                 class="absolute right-0 mt-2 w-60 rounded-2xl border border-slate-200 bg-white p-2.5 shadow-xl z-50">
                                <div class="px-3 py-2 border-b border-slate-100 mb-1.5">
                                    <div class="text-xs font-bold text-slate-800 truncate">{{ Auth::user()->name ?? 'Pengguna' }}</div>
                                    <div class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email ?? '' }}</div>
                                </div>
                                <a href="{{ route('admin.settings.index') }}"
                                   class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#0F2C59]">
                                    <i data-lucide="settings" class="w-4 h-4 text-slate-400"></i>
                                    <span>Pengaturan &amp; Template WA</span>
                                </a>
                                <a href="{{ url('/') }}" target="_blank"
                                   class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#0F2C59]">
                                    <i data-lucide="external-link" class="w-4 h-4 text-slate-400"></i>
                                    <span>Lihat Website Publik</span>
                                </a>
                                <div class="my-1.5 h-px bg-slate-100"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50">
                                        <i data-lucide="log-out" class="w-4 h-4"></i>
                                        <span>Keluar dari Panel</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- ===== Main Content ===== -->
            <main id="main-content" class="flex-1">
                <div class="mx-auto w-full max-w-[1536px] p-4 pb-16 md:p-6">
                    <!-- TailAdmin Page Title & Breadcrumb -->
                    @if(! View::hasSection('hide_breadcrumb'))
                        <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                            <h1 class="text-lg sm:text-xl font-bold text-[#0F2C59] tracking-tight">
                                @yield('header_title', 'Dashboard')
                            </h1>
                            <nav aria-label="Breadcrumb">
                                <ol class="flex items-center gap-1.5 text-xs font-medium text-slate-500">
                                    <li>
                                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1 hover:text-[#0F2C59]">
                                            <span>Dashboard</span>
                                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                        </a>
                                    </li>
                                    <li class="font-semibold text-[#0F2C59]">
                                        @yield('breadcrumb', View::yieldContent('header_title', 'Ringkasan'))
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-5 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs sm:text-sm font-semibold text-emerald-800 flex items-center gap-2.5">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-5 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-xs sm:text-sm font-semibold text-rose-800 flex items-center gap-2.5">
                            <i data-lucide="alert-triangle" class="w-5 h-5 text-rose-600 shrink-0"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Global ⌘K Command Palette Modal -->
    <div x-show="cmdOpen" x-cloak
         class="fixed inset-0 z-[60] flex items-start justify-center pt-16 sm:pt-24 px-4 bg-[#091C3A]/60 backdrop-blur-xs"
         @keydown.escape.window="cmdOpen = false">
        <div @click.outside="cmdOpen = false"
             class="w-full max-w-xl rounded-2xl border border-slate-200 bg-white shadow-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-4 py-3.5 border-b border-slate-100">
                <i data-lucide="search" class="w-5 h-5 text-slate-400 shrink-0"></i>
                <input type="text" x-ref="cmdInput" x-model="cmdQuery"
                       placeholder="Ketik nama siswa, kode MB-..., atau nama menu admin..."
                       class="w-full text-sm text-slate-800 placeholder:text-slate-400 outline-none bg-transparent">
                <button type="button" @click="cmdOpen = false"
                        class="px-2 py-0.5 rounded-md border border-slate-200 text-[11px] font-semibold text-slate-500 hover:bg-slate-50">
                    ESC
                </button>
            </div>
            <div class="max-h-96 overflow-y-auto p-3 space-y-4">
                <div x-show="filteredStudents.length > 0">
                    <div class="px-2 pb-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Siswa Binaan (Profil 360°)</div>
                    <div class="space-y-1">
                        <template x-for="st in filteredStudents" :key="st.id">
                            <a :href="st.url"
                               class="flex items-center justify-between rounded-xl px-3 py-2 text-xs hover:bg-slate-50 transition-colors">
                                <div>
                                    <span class="font-bold text-[#0F2C59]" x-text="st.name"></span>
                                    <span class="ml-1.5 font-mono text-[11px] text-[#0D9488]" x-text="st.code"></span>
                                </div>
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold" x-text="st.grade"></span>
                            </a>
                        </template>
                    </div>
                </div>

                <div x-show="filteredMenus.length > 0">
                    <div class="px-2 pb-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Pintasan Menu Admin</div>
                    <div class="space-y-1">
                        <template x-for="m in filteredMenus" :key="m.url">
                            <a :href="m.url"
                               class="flex items-center justify-between rounded-xl px-3 py-2 text-xs hover:bg-slate-50 transition-colors">
                                <div>
                                    <div class="font-bold text-slate-800" x-text="m.label"></div>
                                    <div class="text-[11px] text-slate-500" x-text="m.desc"></div>
                                </div>
                                <span class="px-2 py-0.5 rounded-md bg-[#FACC15]/30 text-[#0F2C59] text-[10px] font-bold" x-text="m.badge"></span>
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons({
                    attrs: {
                        'stroke-width': '1.65'
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
