<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0A2540]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk Backoffice | PT BPR Bank Daerah Lamongan (Perseroda)</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bdl: {
                            navy: '#0A2540',
                            dark: '#061727',
                            primary: '#0066B2',
                            hover: '#005291',
                            soft: '#63B3ED',
                            ice: '#F4F7FC'
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace']
                    }
                }
            }
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-grid {
            background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="h-full min-h-screen flex items-center justify-center p-4 relative overflow-hidden bg-gradient-to-br from-[#061727] via-[#0A2540] to-[#0A2540]">

    <!-- Ambient Glow & Pattern -->
    <div class="absolute inset-0 bg-grid opacity-70 pointer-events-none"></div>
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-[#0066B2]/25 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-[#63B3ED]/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-md">
        
        <!-- Kartu Login Modern Floating -->
        <div class="bg-white rounded-[28px] p-8 sm:p-10 shadow-2xl border border-white/20 space-y-7">
            
            <!-- Logo & Brand Header -->
            <div class="text-center space-y-3">
                <div class="inline-flex items-center justify-center p-3 rounded-2xl bg-[#F4F7FC] border border-slate-100 shadow-sm">
                    <img src="{{ asset('assets/images/logo-bdl.png') }}" 
                         alt="Logo BDL" 
                         class="h-12 w-auto max-h-12 object-contain">
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-[#0A2540] tracking-tight">Portal Kendali</h1>
                    <p class="text-xs text-slate-400 font-medium mt-0.5">Sistem Tata Kelola & Backoffice BDL</p>
                </div>
            </div>

            <!-- Alert Notifikasi Flash -->
            @if(session('error'))
                <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs flex items-center gap-2.5">
                    <svg class="w-4 h-4 shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs flex items-center gap-2.5">
                    <svg class="w-4 h-4 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Form Autentikasi -->
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4 text-xs" autocomplete="off">
                @csrf

                <!-- Input Email -->
                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700">Email Pegawai / Operator</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="nama@bdl.co.id"
                               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#0066B2] focus:bg-white focus:ring-4 focus:ring-[#0066B2]/10 transition">
                    </div>
                    @error('email')
                        <span class="text-rose-600 text-[11px] block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Input Kata Sandi -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="block font-bold text-slate-700">Kata Sandi</label>
                        <span id="capsWarning" class="hidden text-[10px] text-amber-600 font-bold uppercase tracking-wider">Caps Lock Aktif</span>
                    </div>
                    <div class="relative">
                        <input type="password" id="password" name="password" required 
                               placeholder="••••••••"
                               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-2xl px-4 pr-11 py-3.5 text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#0066B2] focus:bg-white focus:ring-4 focus:ring-[#0066B2]/10 transition">
                        
                        <button type="button" id="togglePasswordBtn" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <svg id="eyeOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg id="eyeClosed" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-rose-600 text-[11px] block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="accent-[#0066B2] w-4 h-4 rounded text-[#0066B2] border-slate-300">
                        <span class="text-slate-600 font-medium">Ingat Sesi Saya</span>
                    </label>
                    <a href="mailto:it@bdl.co.id" class="text-[#0066B2] hover:text-[#0A2540] font-bold">Lupa Sandi?</a>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 rounded-2xl font-bold text-white bg-gradient-to-r from-[#0066B2] to-[#0A2540] hover:opacity-95 active:scale-[0.99] transition shadow-lg shadow-[#0066B2]/25">
                        <span>Masuk ke Dashboard</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </form>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                <a href="{{ route('home') }}" class="font-bold text-[#0066B2] hover:underline flex items-center gap-1">
                    <span>&larr;</span> Web Publik
                </a>
                <span>Enkripsi TLS Aktif</span>
            </div>
        </div>

        <div class="text-center mt-6 text-[11px] text-white/50">
            &copy; 2026 PT BPR Bank Daerah Lamongan (Perseroda). Seluruh Hak Cipta Dilindungi.
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');
            const capsWarning = document.getElementById('capsWarning');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', () => {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    eyeOpen.classList.toggle('hidden', isPassword);
                    eyeClosed.classList.toggle('hidden', !isPassword);
                });
            }

            if (passwordInput && capsWarning) {
                passwordInput.addEventListener('keyup', (e) => {
                    if (e.getModifierState && e.getModifierState('CapsLock')) {
                        capsWarning.classList.remove('hidden');
                    } else {
                        capsWarning.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>