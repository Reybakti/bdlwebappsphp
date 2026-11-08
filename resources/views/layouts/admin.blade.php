<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F4F7FC]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Kendali') | Backoffice BDL</title>

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
                            canvas: '#F4F7FC'
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

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="h-full flex overflow-hidden text-slate-800 antialiased selection:bg-[#0066B2] selection:text-white">

    <!-- ========================================== -->
    <!-- 1. SIDEBAR                                 -->
    <!-- ========================================== -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0A2540] text-white flex flex-col justify-between transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto shrink-0 shadow-xl">
        <div class="flex flex-col h-full overflow-y-auto scrollbar-none">
            
            <!-- Logo Brand Admin Header -->
            <div class="h-20 flex items-center gap-3 px-6 border-b border-white/10 shrink-0 bg-[#061727]/50">
                <img src="{{ asset('assets/images/logo-bdl.png') }}" alt="BDL" class="h-9 w-auto object-contain">
                <div>
                    <span class="font-extrabold text-sm tracking-wider uppercase text-white block leading-tight">BDL</span>
                    <span class="text-[10px] text-[#63B3ED] font-semibold block uppercase tracking-wider">Backoffice Core</span>
                </div>
            </div>

            <!-- Navigasi Menu Bertingkat -->
            <nav class="p-4 space-y-6 text-xs flex-1">
                
                <!-- Grup Utama -->
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 block mb-2">Dashboards</span>
                    
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#0066B2] text-white shadow-md shadow-[#0066B2]/30' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#63B3ED]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            <span>Dashboard Utama</span>
                        </div>
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.dashboard') ? 'bg-white' : 'bg-transparent' }}"></span>
                    </a>
                </div>

                <!-- Divisi Kepatuhan (compliance_officer & super_admin) -->
                @if(auth()->check() && auth()->user()->hasRole('compliance_officer'))
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 block mb-2">Compliance & Public</span>
                    
                    <a href="{{ route('admin.complaints.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition {{ request()->routeIs('admin.complaints.*') ? 'bg-[#0066B2] text-white' : '' }}">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span>Pengaduan Nasabah</span>
                    </a>

                    <a href="{{ route('admin.wbs.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition {{ request()->routeIs('admin.wbs.*') ? 'bg-[#0066B2] text-white' : '' }}">
                        <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>Whistleblowing (WBS)</span>
                    </a>

                    <a href="{{ route('admin.reports.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition {{ request()->routeIs('admin.reports.*') ? 'bg-[#0066B2] text-white' : '' }}">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Publikasi Keuangan & GCG</span>
                    </a>

                    <a href="{{ route('admin.lps.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition {{ request()->routeIs('admin.lps.*') ? 'bg-[#0066B2] text-white' : '' }}">
                        <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>Suku Bunga LPS</span>
                    </a>
                </div>
                @endif

                <!-- Divisi Media, Produk & Institusi (content_editor & super_admin) -->
                @if(auth()->check() && auth()->user()->hasRole('content_editor'))
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 block mb-2">Operation & Media</span>
                    
                    <a href="{{ route('admin.profile.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition {{ request()->routeIs('admin.profile.*') ? 'bg-[#0066B2] text-white' : '' }}">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Profil Lembaga</span>
                    </a>

                    <a href="{{ route('admin.management.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition {{ request()->routeIs('admin.management.*') ? 'bg-[#0066B2] text-white' : '' }}">
                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>Direksi & Dekom</span>
                    </a>

                    <a href="{{ route('admin.products.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition {{ request()->routeIs('admin.products.*') ? 'bg-[#0066B2] text-white' : '' }}">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Katalog Produk & RIPLAY</span>
                    </a>

                    <a href="{{ route('admin.branches.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition {{ request()->routeIs('admin.branches.*') ? 'bg-[#0066B2] text-white' : '' }}">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Jaringan Kantor & Kas</span>
                    </a>

                    <a href="{{ route('admin.articles.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition {{ request()->routeIs('admin.articles.*') ? 'bg-[#0066B2] text-white' : '' }}">
                        <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <span>Berita & Edukasi</span>
                    </a>

                    <a href="{{ route('admin.careers.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition {{ request()->routeIs('admin.careers.*') ? 'bg-[#0066B2] text-white' : '' }}">
                        <svg class="w-4 h-4 text-fuchsia-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Lowongan Karier</span>
                    </a>
                    <a href="{{ route('admin.csr.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition {{ request()->routeIs('admin.csr.*') ? 'bg-[#0066B2] text-white' : '' }}">
                        <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span>Tanggung Jawab Sosial (CSR)</span>
                    </a>
                    <a href="{{ route('admin.banners.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition {{ request()->routeIs('admin.banners.*') ? 'bg-[#0066B2] text-white' : '' }}">
                        <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Hero Banner Slider</span>
                    </a>
                    <a href="{{ route('admin.simulations.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition {{ request()->routeIs('admin.simulations.*') ? 'bg-[#0066B2] text-white' : '' }}">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <span>Parameter Simulasi</span>
                    </a>
                </div>
                @endif

                <!-- Divisi Sistem & Audit (Khusus super_admin) -->
                @if(auth()->check() && auth()->user()->role?->name === 'super_admin')
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 block mb-2">System & Security</span>

                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition {{ request()->routeIs('admin.users.*') ? 'bg-[#0066B2] text-white' : '' }}">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Kelola Pengguna</span>
                    </a>

                    <a href="{{ route('admin.activity_logs.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition {{ request()->routeIs('admin.activity_logs.*') ? 'bg-[#0066B2] text-white' : '' }}">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        <span>Log Aktivitas (Audit)</span>
                    </a>
                </div>
                @endif

            </nav>

            <!-- Tautan Web Publik -->
            <div class="p-4 border-t border-white/10 shrink-0 bg-[#061727]/30">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold text-[#63B3ED] hover:bg-white/5 transition">
                    <span>Lihat Portal Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>

        </div>
    </aside>

    <!-- Overlay Mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <!-- ========================================== -->
    <!-- 2. CANVAS UTAMA & TOPBAR                   -->
    <!-- ========================================== -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#F4F7FC]">
        
        <!-- Header Topbar Bersih Gaya Novo Dashboard -->
        <header class="h-20 bg-white border-b border-slate-200/80 px-4 sm:px-8 flex items-center justify-between shrink-0 shadow-sm">
            
            <div class="flex items-center gap-4 flex-1 max-w-lg">
                <!-- Hamburger Mobile -->
                <button type="button" id="toggle-sidebar-btn" aria-label="Toggle Sidebar" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <!-- Search Input Pill Bulat -->
                <div class="relative w-full max-w-sm hidden sm:block">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" placeholder="Search data, tiket, regulasi..." 
                           class="w-full bg-[#F4F7FC] border border-transparent rounded-full pl-9 pr-4 py-2 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#0066B2] focus:bg-white focus:ring-2 focus:ring-[#0066B2]/10 transition">
                </div>
            </div>

            <!-- Utilitas Kanan: Ikon & Profil -->
            <div class="flex items-center gap-3 sm:gap-4">
                
                <!-- Tombol Fullscreen -->
                <button type="button" onclick="document.fullscreenElement ? document.exitFullscreen() : document.documentElement.requestFullscreen()" 
                        class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full transition hidden sm:inline-flex" title="Fullscreen">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                </button>

                <!-- Profil User Pill Bar -->
                @auth
                    @php
                        $userName = auth()->user()->name ?? 'Administrator';
                        $words = explode(' ', $userName);
                        $initials = '';
                        foreach (array_slice($words, 0, 2) as $w) {
                            $initials .= strtoupper(substr($w, 0, 1));
                        }
                        $roleName = auth()->user()->role?->name ?? 'User';
                    @endphp

                    <div class="flex items-center gap-3 pl-2 sm:pl-4 border-l border-slate-200">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-[#0066B2] to-[#63B3ED] text-white font-bold flex items-center justify-center text-xs shadow-sm">
                            {{ $initials ?: 'AD' }}
                        </div>
                        <div class="hidden sm:block text-left">
                            <span class="text-xs font-bold text-slate-800 block leading-tight">{{ $userName }}</span>
                            <span class="text-[10px] text-emerald-600 font-semibold block uppercase font-mono tracking-wider">
                                {{ str_replace('_', ' ', $roleName) }}
                            </span>
                        </div>

                        <!-- Tombol Keluar -->
                        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Keluar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </button>
                        </form>
                    </div>
                @endauth

            </div>
        </header>

        <!-- Area Scroll Konten -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-6">
            
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs flex items-center gap-2.5 shadow-sm">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-xs flex items-center gap-2.5 shadow-sm">
                    <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    <!-- Script Drawer Mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('toggle-sidebar-btn');
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (toggleBtn && sidebar && overlay) {
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                });

                overlay.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            }
        });
    </script>
</body>
</html>