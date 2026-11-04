<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengajar & Admin — MustikaBimbel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#091C3A] min-h-screen flex items-center justify-center p-4 selection:bg-[#FACC15] selection:text-[#0F2C59]"
      x-data="{
        email: '{{ old('email', 'admin@mustikabimbel.com') }}',
        password: 'password',
        fillCredentials(roleEmail) {
            this.email = roleEmail;
            this.password = 'password';
        }
      }">

    <div class="max-w-md w-full space-y-6">
        <!-- Logo & Brand Header -->
        <div class="text-center space-y-2">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-[#FACC15] flex items-center justify-center text-[#0F2C59] font-extrabold text-2xl shadow-lg group-hover:scale-105 transition-transform">
                    M
                </div>
                <div class="text-left">
                    <span class="text-2xl font-extrabold tracking-tight text-white block leading-none">
                        Mustika<span class="text-[#FACC15]">Bimbel</span>
                    </span>
                    <span class="text-xs text-slate-300 font-medium">Sistem Informasi Pengajar &amp; Admin</span>
                </div>
            </a>
            <p class="text-xs text-slate-300 font-medium pt-1">
                "Kuat Konsepnya, Cepat Hitungnya, Tepat Jawabannya!"
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl p-7 sm:p-8 shadow-2xl border-4 border-[#FACC15] relative overflow-hidden">
            <div class="border-b border-slate-100 pb-4 mb-5">
                <h1 class="text-xl font-extrabold text-[#0F2C59]">Masuk ke Portal Internal</h1>
                <p class="text-xs text-slate-500 mt-0.5">Kelola presensi WA, jurnal belajar, siswa &amp; SPP</p>
            </div>

            @if (session('info'))
                <div class="mb-4 p-3 rounded-xl bg-blue-50 border border-blue-200 text-xs font-semibold text-blue-700">
                    {{ session('info') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-xs font-semibold text-rose-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>&bull; {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                        <input type="email" name="email" x-model="email" required autofocus
                               placeholder="nama@mustikabimbel.com"
                               class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0F2C59] focus:border-[#0F2C59] outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-600 mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                        <input type="password" name="password" x-model="password" required
                               placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0F2C59] focus:border-[#0F2C59] outline-none">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none text-slate-600">
                        <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-[#0F2C59] focus:ring-[#0F2C59]">
                        <span>Ingat Saya di Perangkat Ini</span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full py-3.5 px-4 rounded-xl text-sm font-extrabold text-[#0F2C59] bg-[#FACC15] hover:bg-[#FFD100] shadow-md transition-all flex items-center justify-center gap-2">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>

            <!-- Quick Demo Credentials Selector -->
            <div class="mt-6 pt-5 border-t border-slate-100 space-y-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block text-center">
                    Klik Cepat Akun Demo (Seeder):
                </span>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <button type="button" @click="fillCredentials('admin@mustikabimbel.com')"
                            class="p-2.5 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-left transition-colors">
                        <strong class="text-[#0F2C59] block">Pengelola / Admin</strong>
                        <span class="text-[10px] text-slate-500 block truncate">admin@mustikabimbel.com</span>
                    </button>
                    <button type="button" @click="fillCredentials('tutor@mustikabimbel.com')"
                            class="p-2.5 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-left transition-colors">
                        <strong class="text-[#0D9488] block">Pengajar MIPA / Tutor</strong>
                        <span class="text-[10px] text-slate-500 block truncate">tutor@mustikabimbel.com</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="text-center text-xs text-slate-400">
            <a href="{{ url('/') }}" class="hover:text-[#FACC15] underline flex items-center justify-center gap-1">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                Kembali ke Halaman Publik MustikaBimbel
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
