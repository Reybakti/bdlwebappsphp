<header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <!-- 1. Top Bar Tipis (Kepatuhan, Kontak & Jam Layanan) -->
    <div class="bg-bdl-navy text-white text-[11px] py-1.5 px-4 sm:px-6 lg:px-8 border-b border-white/10">
        <div class="max-w-[1440px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-1.5">
            <div class="flex items-center gap-4 text-bdl-soft">
                <span class="inline-flex items-center gap-1.5 font-num">
                    <svg class="w-3.5 h-3.5 text-bdl-soft" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $companyProfile->phone ?? '(0322) 321175' }}
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-bdl-soft" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ $companyProfile->email ?? 'info@bdl.co.id' }}
                </span>
                <span class="hidden md:inline text-white/30">|</span>
                <span class="hidden md:inline text-slate-300">Jam Layanan: Senin - Jumat (08:00 - 15:00 WIB)</span>
            </div>
            
            <div class="flex items-center gap-2 font-medium">
                <span class="inline-flex items-center gap-1 text-slate-200">
                    Berizin & diawasi OJK
                </span>
                <span class="text-white/30">•</span>
                <span class="text-bdl-soft font-semibold">Peserta Penjaminan LPS</span>
            </div>
        </div>
    </div>

    <!-- 2. Main Navigation Bar -->
    <div id="navbar-main" class="transition-all duration-300 bg-gradient-to-b from-black/85 via-black/55 to-transparent backdrop-blur-[2px]">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Logo & Identitas Bank (Dinamis dari Database) -->
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0 group">
                    <img src="{{ asset('assets/images/logo-bdl.png') }}" 
                         alt="Logo {{ $companyProfile->name ?? 'Bank Daerah Lamongan' }}" 
                         class="h-10 sm:h-11 w-auto object-contain filter drop-shadow">
                    
                    @php
                        $fullName = $companyProfile->name ?? 'PT. BPR Bank Daerah Lamongan Perseroda';
                        if (preg_match('/^(.*?)(Lamongan.*)$/i', $fullName, $matches)) {
                            $line1 = trim($matches[1]);
                            $line2 = trim($matches[2]);
                        } else {
                            $words = explode(' ', $fullName);
                            if (count($words) > 2) {
                                $half = ceil(count($words) / 2);
                                $line1 = implode(' ', array_slice($words, 0, $half));
                                $line2 = implode(' ', array_slice($words, $half));
                            } else {
                                $line1 = $fullName;
                                $line2 = '';
                            }
                        }
                    @endphp

                    <div class="text-white">
                        <div class="text-[12px] sm:text-xs 2xl:text-sm font-bold tracking-tight leading-tight uppercase group-hover:text-bdl-soft transition">
                            {{ $line1 }}
                        </div>
                        @if(!empty($line2))
                            <div class="text-[10px] 2xl:text-xs font-semibold tracking-wide text-bdl-soft leading-tight uppercase">
                                {{ $line2 }}
                            </div>
                        @endif
                    </div>
                </a>

                <!-- 3. Susunan Menu Publik (Desktop Nav) -->
                <nav class="hidden xl:flex items-center gap-3 2xl:gap-5 text-[12px] 2xl:text-[13px] font-semibold text-white/95">
                    
                    <!-- 1. Beranda -->
                    <a href="{{ route('home') }}" class="px-2 py-1.5 hover:text-bdl-soft transition whitespace-nowrap {{ request()->routeIs('home') ? 'text-white border-b-2 border-white' : '' }}">
                        Beranda
                    </a>

                    <!-- 2. Tentang Kami (Dropdown) -->
                    <div class="relative group py-2">
                        <button class="inline-flex items-center gap-1 px-2 py-1.5 hover:text-bdl-soft transition focus:outline-none whitespace-nowrap">
                            <span>Tentang Kami</span>
                            <svg class="w-3 h-3 opacity-70 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="absolute top-full left-0 w-60 bg-white text-slate-800 rounded-xl shadow-xl border border-slate-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 transform group-hover:translate-y-0 translate-y-1">
                            <a href="{{ route('about.profile') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Profil & Sejarah</a>
                            <a href="{{ route('about.profile') }}#visi-misi" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Visi, Misi & Budaya Kerja</a>
                            <a href="{{ route('about.management') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Manajemen (Direksi & Dekom)</a>
                            <a href="{{ route('about.profile') }}#legalitas" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Legalitas & Penghargaan</a>
                            <a href="{{ route('about.structure') }}" class="block px-4 py-2 hover:bg-slate-50 text-slate-700 transition">
    Struktur Organisasi
</a>
                        </div>
                    </div>

                    <!-- 3. Produk & Layanan (Dropdown) -->
                    <div class="relative group py-2">
                        <button class="inline-flex items-center gap-1 px-2 py-1.5 hover:text-bdl-soft transition focus:outline-none whitespace-nowrap">
                            <span>Produk & Layanan</span>
                            <svg class="w-3 h-3 opacity-70 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="absolute top-full left-0 w-64 bg-white text-slate-800 rounded-xl shadow-xl border border-slate-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 transform group-hover:translate-y-0 translate-y-1">
                            <a href="{{ route('products.savings') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Tabungan</a>
                            <a href="{{ route('products.deposit') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Deposito Berjangka</a>
                            <a href="{{ route('products.loan') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Kredit & Pembiayaan</a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <a href="{{ route('home') }}#simulasi-section" class="block px-4 py-2 text-bdl-primary bg-sky-50/50 hover:bg-sky-50 transition text-xs font-bold">Simulasi Kalkulator (Kredit & Deposito)</a>
                        </div>
                    </div>

                    <!-- 4. Transparansi & GCG (Dropdown) -->
                    <div class="relative group py-2">
                        <button class="inline-flex items-center gap-1 px-2 py-1.5 hover:text-bdl-soft transition focus:outline-none whitespace-nowrap">
                            <span>Transparansi & GCG</span>
                            <svg class="w-3 h-3 opacity-70 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="absolute top-full left-0 w-64 bg-white text-slate-800 rounded-xl shadow-xl border border-slate-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 transform group-hover:translate-y-0 translate-y-1">
                            <a href="{{ route('transparency.financial') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Laporan Keuangan Publikasi</a>
                            <a href="{{ route('transparency.gcg') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Laporan Tata Kelola (GCG)</a>
                            <a href="{{ route('transparency.lps') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Tingkat Bunga Penjaminan LPS</a>
                            <a href="{{ route('transparency.riplay') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Ringkasan Informasi Produk (RIPLAY)</a>
                            <a href="{{ route('about.csr') }}" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-100 hover:text-[#0066B2]">
    Tanggung Jawab Sosial (CSR)
</a>
                        </div>
                    </div>

                    <!-- 5. Media & Berita (Dropdown) -->
                    <div class="relative group py-2">
                        <button class="inline-flex items-center gap-1 px-2 py-1.5 hover:text-bdl-soft transition focus:outline-none whitespace-nowrap">
                            <span>Media & Berita</span>
                            <svg class="w-3 h-3 opacity-70 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="absolute top-full left-0 w-60 bg-white text-slate-800 rounded-xl shadow-xl border border-slate-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 transform group-hover:translate-y-0 translate-y-1">
                            <a href="{{ route('media.news') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Berita & Agenda</a>
                            <a href="{{ route('media.education') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Edukasi & Literasi Keuangan</a>
                            <a href="{{ route('media.announcements') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Pengumuman & Lelang Agunan</a>
                            <a href="{{ route('public.portals.index') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Peta Situs & Portal Direktori</a>
                        </div>
                    </div>

                    <!-- 6. Jaringan Kantor -->
                    <a href="{{ route('services.branches') }}" class="px-2 py-1.5 hover:text-bdl-soft transition whitespace-nowrap {{ request()->routeIs('services.branches') ? 'text-white border-b-2 border-white' : '' }}">
                        Jaringan Kantor
                    </a>

                    <!-- 7. Layanan Nasabah (Dropdown) -->
                    <div class="relative group py-2">
                        <button class="inline-flex items-center gap-1 px-2 py-1.5 hover:text-bdl-soft transition focus:outline-none whitespace-nowrap">
                            <span>Layanan Nasabah</span>
                            <svg class="w-3 h-3 opacity-70 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="absolute top-full right-0 w-60 bg-white text-slate-800 rounded-xl shadow-xl border border-slate-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 transform group-hover:translate-y-0 translate-y-1">
                            <a href="{{ route('services.complaint') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Pengaduan Nasabah (Form Online)</a>
                            <a href="{{ route('services.ticket') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Cek Status Tiket Pengaduan</a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <a href="{{ route('services.wbs') }}" class="block px-4 py-2 text-rose-700 hover:bg-rose-50 transition text-xs font-bold">Whistleblowing System (WBS)</a>
                            <a href="{{ route('services.career') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-bdl-primary transition text-xs font-medium">Karier / Rekrutmen</a>
                        </div>
                    </div>

                </nav>

                <!-- 4. Tombol Aksi Cepat (Desktop) & Hamburger (Mobile/Tablet) -->
                <div class="flex items-center gap-2.5 shrink-0">
                    <a href="{{ route('services.complaint') }}" class="hidden sm:inline-block text-[11.5px] 2xl:text-xs font-bold text-bdl-navy bg-white hover:bg-bdl-soft px-3.5 2xl:px-4 py-2 rounded-lg transition shadow-md hover:shadow-lg whitespace-nowrap">
                        Pengaduan
                    </a>

                    <!-- Hamburger Button untuk Layar < xl -->
                    <button type="button" id="mobile-menu-btn" aria-label="Toggle Navigation" class="xl:hidden p-2 rounded-lg text-white hover:bg-white/10 transition focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path id="hamburger-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- 5. Mobile Menu Drawer -->
        <div id="mobile-menu" class="hidden xl:hidden bg-bdl-navy/95 border-t border-white/10 px-4 pt-3 pb-6 space-y-2 text-xs text-white max-h-[75vh] overflow-y-auto">
            <a href="{{ route('home') }}" class="block py-2 border-b border-white/5 font-semibold">Beranda</a>
            
            <details class="group py-1 border-b border-white/5">
                <summary class="flex justify-between items-center py-1 cursor-pointer font-semibold list-none">
                    <span>Tentang Kami</span>
                    <svg class="w-3.5 h-3.5 transition group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <div class="pl-3 py-1 space-y-1.5 text-slate-300 text-[11px]">
                    <a href="{{ route('about.profile') }}" class="block py-1">Profil & Sejarah</a>
                    <a href="{{ route('about.profile') }}#visi-misi" class="block py-1">Visi, Misi & Budaya Kerja</a>
                    <a href="{{ route('about.management') }}" class="block py-1">Manajemen (Direksi & Dekom)</a>
                    <a href="{{ route('about.profile') }}#legalitas" class="block py-1">Legalitas & Penghargaan</a>
                    <a href="{{ route('about.structure') }}" class="block px-4 py-2 hover:bg-slate-50 text-slate-700 transition">
    Struktur Organisasi
</a>
                </div>
            </details>

            <details class="group py-1 border-b border-white/5">
                <summary class="flex justify-between items-center py-1 cursor-pointer font-semibold list-none">
                    <span>Produk & Layanan</span>
                    <svg class="w-3.5 h-3.5 transition group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <div class="pl-3 py-1 space-y-1.5 text-slate-300 text-[11px]">
                    <a href="{{ route('products.savings') }}" class="block py-1">Tabungan</a>
                    <a href="{{ route('products.deposit') }}" class="block py-1">Deposito Berjangka</a>
                    <a href="{{ route('products.loan') }}" class="block py-1">Kredit & Pembiayaan</a>
                    <a href="{{ route('home') }}#simulasi-section" class="block py-1 text-bdl-soft font-bold">Simulasi Kalkulator (Kredit & Deposito)</a>
                </div>
            </details>

            <details class="group py-1 border-b border-white/5">
                <summary class="flex justify-between items-center py-1 cursor-pointer font-semibold list-none">
                    <span>Transparansi & GCG</span>
                    <svg class="w-3.5 h-3.5 transition group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <div class="pl-3 py-1 space-y-1.5 text-slate-300 text-[11px]">
                    <a href="{{ route('transparency.financial') }}" class="block py-1">Laporan Keuangan Publikasi</a>
                    <a href="{{ route('transparency.gcg') }}" class="block py-1">Laporan Tata Kelola (GCG)</a>
                    <a href="{{ route('transparency.lps') }}" class="block py-1">Tingkat Bunga Penjaminan LPS</a>
                    <a href="{{ route('transparency.riplay') }}" class="block py-1">Ringkasan Informasi Produk (RIPLAY)</a>
                    <a href="{{ route('about.csr') }}" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-100 hover:text-[#0066B2]">
    Tanggung Jawab Sosial (CSR)
</a>
                </div>
            </details>

            <details class="group py-1 border-b border-white/5">
                <summary class="flex justify-between items-center py-1 cursor-pointer font-semibold list-none">
                    <span>Media & Berita</span>
                    <svg class="w-3.5 h-3.5 transition group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <div class="pl-3 py-1 space-y-1.5 text-slate-300 text-[11px]">
                    <a href="{{ route('media.news') }}" class="block py-1">Berita & Agenda</a>
                    <a href="{{ route('media.education') }}" class="block py-1">Edukasi & Literasi Keuangan</a>
                    <a href="{{ route('media.announcements') }}" class="block py-1">Pengumuman & Lelang Agunan</a>
                    <a href="{{ route('public.portals.index') }}" class="block py-1">Peta Situs & Portal Direktori</a>
                </div>
            </details>

            <a href="{{ route('services.branches') }}" class="block py-2 border-b border-white/5 font-semibold">Jaringan Kantor</a>

            <details class="group py-1 border-b border-white/5">
                <summary class="flex justify-between items-center py-1 cursor-pointer font-semibold list-none">
                    <span>Layanan Nasabah</span>
                    <svg class="w-3.5 h-3.5 transition group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <div class="pl-3 py-1 space-y-1.5 text-slate-300 text-[11px]">
                    <a href="{{ route('services.complaint') }}" class="block py-1">Pengaduan Nasabah (Form Online)</a>
                    <a href="{{ route('services.ticket') }}" class="block py-1">Cek Status Tiket Pengaduan</a>
                    <a href="{{ route('services.wbs') }}" class="block py-1 text-rose-300 font-bold">Whistleblowing System (WBS)</a>
                    <a href="{{ route('services.career') }}" class="block py-1">Karier / Rekrutmen</a>
                </div>
            </details>

            <div class="pt-3">
                <a href="{{ route('services.complaint') }}" class="block text-center text-xs font-bold text-bdl-navy bg-white hover:bg-bdl-soft py-2.5 rounded-lg transition shadow">
                    Pengaduan
                </a>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const navbarMain = document.getElementById('navbar-main');
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const closeIcon = document.getElementById('close-icon');

    // Scroll Navbar Effect
    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            navbarMain.classList.remove('bg-gradient-to-b', 'from-black/85', 'via-black/55', 'to-transparent', 'backdrop-blur-[2px]');
            navbarMain.classList.add('bg-bdl-navy/95', 'backdrop-blur-md', 'shadow-md', 'border-b', 'border-white/10');
        } else {
            navbarMain.classList.add('bg-gradient-to-b', 'from-black/85', 'via-black/55', 'to-transparent', 'backdrop-blur-[2px]');
            navbarMain.classList.remove('bg-bdl-navy/95', 'backdrop-blur-md', 'shadow-md', 'border-b', 'border-white/10');
        }
    });

    // Mobile Toggle
    if (mobileBtn) {
        mobileBtn.addEventListener('click', () => {
            const isHidden = mobileMenu.classList.contains('hidden');
            if (isHidden) {
                mobileMenu.classList.remove('hidden');
                hamburgerIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        });
    }
});
</script>