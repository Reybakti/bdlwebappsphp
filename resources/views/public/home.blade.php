@extends('layouts.app')

@section('title', 'PT. BPR Bank Daerah Lamongan Perseroda - Solusi Keuangan Terpercaya')

@section('content')
<!-- SECTION 1: HERO FOTOGRAFI PASAR & UMKM LOKAL -->
@php
    $mainBanner = $banners->first();
    $bannerImage = ($mainBanner && $mainBanner->image_desktop_url) 
        ? (str_starts_with($mainBanner->image_desktop_url, 'http') ? $mainBanner->image_desktop_url : asset($mainBanner->image_desktop_url)) 
        : 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1920&q=80';
@endphp

<section class="relative min-h-[580px] lg:min-h-[640px] flex items-center bg-slate-900 overflow-hidden">
    <!-- Gambar Background Banner dari Database -->
    <img src="{{ $bannerImage }}" 
         alt="{{ $mainBanner->title ?? 'Layanan Finansial Bank Daerah Lamongan' }}" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.70]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-28 pb-16">
        <div class="max-w-2xl text-white space-y-6">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-xs font-semibold text-bdl-soft tracking-wider uppercase">
                Bank Perekonomian Rakyat Terpercaya
            </div>
            
            <h1 class="text-3xl sm:text-4xl lg:text-[50px] font-extrabold tracking-tight leading-[1.18]">
                {{ $mainBanner->title ?? 'Solusi Keuangan Terpercaya untuk Lamongan' }}
            </h1>
            
            <p class="text-white/90 text-sm sm:text-base leading-relaxed font-normal max-w-xl">
                {{ $mainBanner->subtitle ?? 'Mendukung pertumbuhan ekonomi masyarakat Lamongan dengan layanan perbankan yang profesional, transparan, dan terpercaya.' }}
            </p>

            <div class="pt-2 flex flex-wrap items-center gap-4">
                <a href="{{ $mainBanner->button_url ?? '#simulasi-section' }}" class="inline-flex items-center gap-2.5 text-xs sm:text-sm font-extrabold text-white tracking-wider uppercase hover:text-bdl-soft transition group">
                    <span>{{ $mainBanner->button_text ?? 'KAMI SIAP MEMBANTU ANDA' }}</span>
                    <span class="text-base font-bold group-hover:translate-x-1 transition duration-150">&gt;</span>
                </a>
                <span class="text-white/40 hidden sm:inline">|</span>
                <a href="{{ route('services.complaint') }}" class="text-xs sm:text-sm font-semibold text-bdl-soft hover:text-white transition">
                    Layanan Pengaduan Konsumen &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Navigasi Panah Carousel -->
    <div class="absolute right-6 sm:right-12 bottom-8 z-20 flex items-center gap-2 text-white/80">
        <button class="p-2.5 rounded-full bg-black/40 hover:bg-black/60 border border-white/20 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
        </button>
    </div>
</section>

<!-- SECTION 2: SOLID BLUE METRIC BAR -->
<section class="bg-bdl-primary text-white border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 divide-y lg:divide-y-0 lg:divide-x divide-white/20">
            
            <div class="py-6 px-4 sm:px-6 text-center space-y-1">
                <div class="text-3xl sm:text-4xl font-extrabold font-num tracking-tight text-white">
                    74+
                </div>
                <div class="text-xs sm:text-sm font-semibold text-white/90 leading-tight">
                    Tahun Melayani
                </div>
            </div>

            <div class="py-6 px-4 sm:px-6 text-center space-y-1">
                <div class="text-3xl sm:text-4xl font-extrabold font-num tracking-tight text-white">
                    {{ $totalBranchesCount > 0 ? $totalBranchesCount : '33' }}
                </div>
                <div class="text-xs sm:text-sm font-semibold text-white/90 leading-tight">
                    Kantor Layanan Aktif
                </div>
            </div>

            <div class="py-6 px-4 sm:px-6 flex flex-col items-center justify-center space-y-2">
                <div class="bg-white px-3.5 py-1.5 rounded-lg shadow-sm flex items-center justify-center">
                    <img src="{{ asset('assets/images/logo-ojk.png') }}" 
                         alt="Otoritas Jasa Keuangan" 
                         class="h-7 w-auto object-contain">
                </div>
                <div class="text-xs sm:text-sm font-semibold text-white/90 leading-tight">
                    Terdaftar & Diawasi
                </div>
            </div>

            <div class="py-6 px-4 sm:px-6 flex flex-col items-center justify-center space-y-2">
                <div class="bg-white px-3.5 py-1.5 rounded-lg shadow-sm flex items-center justify-center">
                    <img src="{{ asset('assets/images/logo-lps.png') }}" 
                         alt="Lembaga Penjamin Simpanan" 
                         class="h-7 w-auto object-contain">
                </div>
                <div class="text-xs sm:text-sm font-semibold text-white/90 leading-tight">
                    Simpanan Dijamin
                </div>
            </div>

        </div>
    </div>
</section>

<!-- SECTION 3: 4 PILAR TATA KELOLA LEMBAGA -->
<section class="py-16 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 space-y-12">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider">Komitmen Pelayanan</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy">Pilar Kepercayaan Bank Daerah Lamongan</h2>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                Menjalankan tata kelola perbankan yang sehat untuk menjamin rasa aman dan pertumbuhan bisnis seluruh nasabah di Kabupaten Lamongan.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h3 class="text-sm font-bold text-bdl-navy">Tata Kelola Terpercaya</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Pengalaman panjang dalam industri perbankan yang kokoh dan berorientasi pada kemajuan ekonomi nasabah.
                </p>
            </div>

            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-bdl-navy">Penjaminan Penuh LPS</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Seluruh saldo tabungan dan deposito nasabah dijamin oleh Lembaga Penjamin Simpanan (LPS) hingga Rp2 Miliar per nasabah sesuai syarat penjaminan.
                </p>
            </div>

            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-bdl-navy">Transparansi RIPLAY</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Pemberlakuan Ringkasan Informasi Produk dan Layanan (RIPLAY) versi umum memastikan nasabah memahami bunga, biaya, dan risiko secara terbuka.
                </p>
            </div>

            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-bdl-navy">Kedekatan dengan UMKM</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Didukung petugas lapangan profesional yang menjangkau sentra pasar tradisional, peternak, petani, dan pelaku usaha mikro di seluruh kecamatan.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 4: KATALOG PRODUK DINAMIS -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 space-y-10">
        <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Portofolio Layanan</span>
                <h2 class="text-2xl font-extrabold text-bdl-navy mt-1">Katalog Produk Simpanan & Pembiayaan</h2>
            </div>
            <p class="text-xs text-slate-500 max-w-xs">Seluruh simpanan dijamin LPS hingga Rp2 Miliar per nasabah.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($featuredProducts as $product)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:border-bdl-primary hover:shadow-md transition duration-150">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-[#D6E4F0]/50 text-bdl-navy">
                                {{ $product->category->name ?? 'Produk' }}
                            </span>
                            @if($product->simulationParam)
                                <span class="text-[11px] font-num font-bold text-bdl-primary">
                                    {{ $product->simulationParam->base_interest_rate_pa }}% p.a.
                                </span>
                            @else
                                <span class="text-[11px] font-num font-bold text-emerald-600">Bebas Biaya Admin</span>
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-bdl-navy">{{ $product->name }}</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $product->short_description }}
                        </p>
                        
                        @if($product->terms_and_conditions)
                            <div class="p-3 bg-slate-50 rounded-xl space-y-1 text-xs text-slate-600">
                                <span class="font-bold text-bdl-navy block text-[11px]">Ketentuan Utama:</span>
                                <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ Str::limit($product->terms_and_conditions, 95) }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="pt-5 mt-6 border-t border-slate-100 flex items-center justify-between">
                        @if($product->category && $product->category->slug === 'deposito')
                            <a href="{{ route('products.deposit') }}" class="text-xs font-bold text-bdl-primary hover:text-bdl-navy transition">
                                Simulasi Deposito &rarr;
                            </a>
                        @elseif($product->category && $product->category->slug === 'kredit')
                            <a href="{{ route('products.loan') }}" class="text-xs font-bold text-bdl-primary hover:text-bdl-navy transition">
                                Simulasi Kredit &rarr;
                            </a>
                        @else
                            <a href="{{ route('about.profile') }}" class="text-xs font-bold text-bdl-primary hover:text-bdl-navy transition">
                                Syarat Pembukaan &rarr;
                            </a>
                        @endif
                        
                        @if($product->riplay_file_url)
                            <span class="text-[10px] font-medium text-slate-400">PDF RIPLAY</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-8 text-xs text-slate-400">
                    Belum ada produk unggulan yang aktif di basis data.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- SECTION 5: KALKULATOR SIMULASI DUAL-MODE -->
@php
    $loanParam = $loanProduct?->simulationParam;
    $defaultLoanAmount = $loanParam ? ($loanParam->min_amount > 25000000 ? $loanParam->min_amount : 25000000) : 25000000;
    $loanMinAmount = $loanParam?->min_amount ?? 5000000;
    $loanMaxAmount = $loanParam?->max_amount ?? 500000000;
    $loanRate = $loanParam?->base_interest_rate_pa ?? 10.50;

    $depositParam = $depositProduct?->simulationParam;
    $lpsCurrentRate = $lpsRate?->rate_idr ?? ($depositParam?->base_interest_rate_pa ?? 6.75);
@endphp

<section id="simulasi-section" class="py-16 bg-slate-50 border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 space-y-8">
        <div class="max-w-2xl">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Kalkulator Interaktif Transparan</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy mt-1">Simulasi Perhitungan Keuangan</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Hitung estimasi kewajiban angsuran kredit atau potensi imbal hasil bersih deposito Anda secara mandiri sebelum berkunjung ke kantor cabang.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Box Simulasi Kredit -->
            <div class="lg:col-span-6 bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="text-base font-bold text-bdl-navy">{{ $loanProduct->name ?? 'Simulasi Kredit Modal Kerja' }}</h3>
                        <p class="text-xs text-slate-500">Perhitungan suku bunga flat per tahun (p.a.)</p>
                    </div>
                    <span class="text-xs font-num font-bold text-bdl-primary bg-[#D6E4F0]/40 px-2.5 py-1 rounded">
                        {{ number_format($loanRate, 2) }}% Flat
                    </span>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-2">
                            <span>Plafon Pinjaman:</span>
                            <span id="quickAmountLabel" class="text-bdl-primary font-num text-base font-bold">Rp{{ number_format($defaultLoanAmount, 0, ',', '.') }}</span>
                        </div>
                        <input type="range" id="quickAmount" 
                               min="{{ $loanMinAmount }}" 
                               max="{{ $loanMaxAmount > 200000000 ? 200000000 : $loanMaxAmount }}" 
                               step="5000000" 
                               value="{{ $defaultLoanAmount }}"
                               class="w-full accent-bdl-primary h-2 bg-slate-200 rounded-lg cursor-pointer" oninput="updateQuickCalc()">
                        <div class="flex justify-between text-[10px] text-slate-400 font-num mt-1">
                            <span>Rp{{ number_format($loanMinAmount, 0, ',', '.') }}</span>
                            <span>Rp100.000.000</span>
                            <span>Rp200.000.000</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Jangka Waktu Pinjaman (Tenor):</label>
                        <div class="grid grid-cols-4 gap-2">
                            <button type="button" onclick="setQuickTenor(6, this)" class="tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num">6 Bulan</button>
                            <button type="button" onclick="setQuickTenor(12, this)" class="tenor-btn py-2 text-xs font-semibold rounded-lg border border-bdl-primary bg-bdl-navy text-white transition shadow-sm font-num">12 Bulan</button>
                            <button type="button" onclick="setQuickTenor(24, this)" class="tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num">24 Bulan</button>
                            <button type="button" onclick="setQuickTenor(36, this)" class="tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num">36 Bulan</button>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Estimasi Angsuran Bulanan</span>
                            <span id="quickMonthlyRes" class="text-2xl font-extrabold text-bdl-navy font-num">Rp0</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Pokok + Bunga Flat</span>
                        </div>
                        <a href="{{ route('products.loan') }}" class="px-4 py-2.5 rounded-lg text-xs font-bold text-white bg-bdl-primary hover:bg-bdl-navy transition shadow-sm">
                            Detail RIPLAY
                        </a>
                    </div>
                </div>
            </div>

            <!-- Box Simulasi Deposito -->
            <div class="lg:col-span-6 bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="text-base font-bold text-bdl-navy">{{ $depositProduct->name ?? 'Deposito Berjangka' }}</h3>
                        <p class="text-xs text-slate-500">Perhitungan bunga bersih setelah pajak (PPh 20% &ge; Rp7,5 Juta)</p>
                    </div>
                    <span class="text-xs font-num font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded">
                        TBP LPS: {{ number_format($lpsCurrentRate, 2) }}% p.a.
                    </span>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-2">
                            <span>Nominal Deposito:</span>
                            <span id="depositAmountLabel" class="text-bdl-primary font-num text-base font-bold">Rp50.000.000</span>
                        </div>
                        <input type="range" id="depositAmount" min="5000000" max="500000000" step="5000000" value="50000000"
                            class="w-full accent-bdl-primary h-2 bg-slate-200 rounded-lg cursor-pointer" oninput="updateDepositCalc()">
                        <div class="flex justify-between text-[10px] text-slate-400 font-num mt-1">
                            <span>Rp5.000.000</span>
                            <span>Rp250.000.000</span>
                            <span>Rp500.000.000</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Jangka Waktu Penempatan:</label>
                        <div class="grid grid-cols-4 gap-2">
                            <button type="button" onclick="setDepositTenor(1, this)" class="dep-tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num">1 Bulan</button>
                            <button type="button" onclick="setDepositTenor(3, this)" class="dep-tenor-btn py-2 text-xs font-semibold rounded-lg border border-bdl-primary bg-bdl-navy text-white transition shadow-sm font-num">3 Bulan</button>
                            <button type="button" onclick="setDepositTenor(6, this)" class="dep-tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num">6 Bulan</button>
                            <button type="button" onclick="setDepositTenor(12, this)" class="dep-tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num">12 Bulan</button>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Estimasi Bunga Bersih Total</span>
                            <span id="depositNetRes" class="text-2xl font-extrabold text-emerald-700 font-num">Rp0</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Sudah dipotong PPh 20%</span>
                        </div>
                        <a href="{{ route('products.deposit') }}" class="px-4 py-2.5 rounded-lg text-xs font-bold text-bdl-navy bg-[#D6E4F0]/60 hover:bg-[#D6E4F0] transition shadow-sm">
                            Detail Deposito
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 6: KEPATUHAN & TRANSPARANSI LAPORAN -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 space-y-10">
        <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Akuntabilitas Lembaga</span>
                <h2 class="text-2xl font-extrabold text-bdl-navy mt-1">Transparansi Laporan & Kinerja Keuangan</h2>
            </div>
            <a href="{{ route('transparency.financial') }}" class="text-xs font-bold text-bdl-primary hover:text-bdl-navy">
                Lihat Seluruh Arsip Laporan &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Laporan Keuangan Berkala Terkini -->
            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="flex items-center justify-between text-xs text-slate-400">
                    <span class="font-bold text-bdl-primary">{{ $latestFinancialReport->type ?? 'TRIWULAN II' }} {{ $latestFinancialReport->year ?? '2026' }}</span>
                    <span>{{ $latestFinancialReport ? \Carbon\Carbon::parse($latestFinancialReport->published_at)->translatedFormat('d F Y') : '-' }}</span>
                </div>
                <h3 class="text-base font-bold text-bdl-navy">{{ $latestFinancialReport->title ?? 'Laporan Keuangan Publikasi' }}</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Ringkasan Neraca, Laporan Laba Rugi, Kualitas Aktiva Produktif (KAP), dan Rasio Keuangan Publikasi sesuai ketentuan SEOJK.
                </p>
                <div class="pt-2">
                    <a href="{{ route('transparency.reports') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-bdl-primary hover:text-bdl-navy">
                        <span>Unduh PDF Resmi</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    </a>
                </div>
            </div>

            <!-- Laporan GCG Terkini -->
            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="flex items-center justify-between text-xs text-slate-400">
                    <span class="font-bold text-bdl-primary">TATA KELOLA (GCG) {{ $latestGcgReport->year ?? '2025' }}</span>
                    <span>{{ $latestGcgReport ? \Carbon\Carbon::parse($latestGcgReport->published_at)->translatedFormat('d F Y') : '-' }}</span>
                </div>
                <h3 class="text-base font-bold text-bdl-navy">{{ $latestGcgReport->title ?? 'Laporan Tata Kelola (GCG)' }}</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Evaluasi kepatuhan direksi, dewan komisaris, komite audit, dan penerapan manajemen risiko perbankan tahunan.
                </p>
                <div class="pt-2">
                    <a href="{{ route('transparency.reports') }}?type=GCG" class="inline-flex items-center gap-1.5 text-xs font-bold text-bdl-primary hover:text-bdl-navy">
                        <span>Unduh PDF GCG</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    </a>
                </div>
            </div>

            <!-- Ketentuan LPS Terkini -->
            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="flex items-center justify-between text-xs text-slate-400">
                    <span class="font-bold text-bdl-primary">PENJAMINAN LPS</span>
                    <span>{{ $lpsRate ? \Carbon\Carbon::parse($lpsRate->effective_start_date)->translatedFormat('M Y') : 'Aktif' }}</span>
                </div>
                <h3 class="text-base font-bold text-bdl-navy">Tingkat Bunga Penjaminan (TBP) LPS</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Batas suku bunga simpanan Rupiah BPR yang dijamin sebesar <strong class="font-num text-bdl-navy">{{ number_format($lpsCurrentRate, 2) }}% p.a.</strong> Berlaku s/d {{ $lpsRate ? \Carbon\Carbon::parse($lpsRate->effective_end_date)->translatedFormat('d M Y') : 'periode aktif' }}.
                </p>
                <div class="pt-2">
                    <a href="{{ route('transparency.reports') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-bdl-primary hover:text-bdl-navy">
                        <span>Ketentuan Penjaminan LPS</span>
                        <span class="text-sm font-bold">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 7: LAYANAN PENGADUAN KONSUMEN & WBS -->
<section class="py-16 bg-slate-50 border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Pengaduan Konsumen POJK 22/2023 -->
            <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <span class="text-[11px] font-bold text-bdl-primary uppercase tracking-wider">Perlindungan Konsumen Perbankan</span>
                    <h3 class="text-lg font-bold text-bdl-navy mt-0.5">Alur Layanan Pengaduan Nasabah (POJK No. 22/2023)</h3>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Nasabah yang mengalami kendala transaksi, keberatan suku bunga, atau masalah layanan dapat menyampaikan pengaduan resmi secara online. Sistem secara otomatis menerbitkan nomor tiket unik untuk memantau status penyelesaian secara transparan.
                </p>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 py-2 text-xs">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <span class="font-num font-bold text-bdl-primary block text-sm">01. Pengajuan</span>
                        <p class="text-slate-500 text-[11px]">Isi data diri, NIK, dan kronologi keluhan.</p>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <span class="font-num font-bold text-bdl-primary block text-sm">02. Nomor Tiket</span>
                        <p class="text-slate-500 text-[11px]">Dapatkan kode tiket format BDL-YYYYMMDD-XXXX.</p>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <span class="font-num font-bold text-bdl-primary block text-sm">03. Penyelesaian</span>
                        <p class="text-slate-500 text-[11px]">Pantau progres tindak lanjut oleh tim kepatuhan.</p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ route('services.complaint') }}" class="px-5 py-2.5 rounded-lg text-xs font-bold text-white bg-bdl-primary hover:bg-bdl-navy transition shadow-sm">
                        Buat Pengaduan Online
                    </a>
                    <a href="{{ route('services.ticket') }}" class="px-5 py-2.5 rounded-lg text-xs font-bold text-bdl-navy bg-[#D6E4F0]/60 hover:bg-[#D6E4F0] transition shadow-sm">
                        Lacak Status Tiket Anda
                    </a>
                </div>
            </div>

            <!-- Whistleblowing System (WBS) -->
            <div class="lg:col-span-5 bg-bdl-navy rounded-2xl p-6 sm:p-8 text-white space-y-4 shadow-sm">
                <div class="flex items-center justify-between pb-2 border-b border-white/10">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-rose-300">Pengawasan Terenkripsi</span>
                    <span class="text-[10px] font-mono bg-white/10 px-2 py-0.5 rounded">ANONIM & AMAN</span>
                </div>
                <h3 class="text-base font-bold text-white">Whistleblowing System (WBS)</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Kanal pelaporan rahasia bagi karyawan maupun masyarakat yang mengetahui adanya dugaan tindak pidana perbankan, gratifikasi, benturan kepentingan, kecurangan (fraud), atau pelanggaran etika operasional.
                </p>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 text-xs text-slate-300 space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="text-emerald-400 font-bold">&#10003;</span>
                        <span>Identitas pelapor dilindungi kerahasiaannya.</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-emerald-400 font-bold">&#10003;</span>
                        <span>Diberikan kode pelacak rahasia (Tracking Token).</span>
                    </div>
                </div>
                <div class="pt-2">
                    <a href="{{ route('services.wbs') }}" class="inline-block px-5 py-2.5 rounded-lg text-xs font-bold text-white bg-rose-700 hover:bg-rose-800 transition shadow">
                        Masuk Kanal WBS &rarr;
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- SECTION 8: WARTA & LITERASI KEUANGAN DINAMIS -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 space-y-10">
        <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Warta & Edukasi</span>
                <h2 class="text-2xl font-extrabold text-bdl-navy mt-1">Publikasi Terkini & Literasi Keuangan</h2>
            </div>
            <p class="text-xs text-slate-500">Mendorong pemahaman inklusi finansial masyarakat Lamongan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($latestArticles as $article)
                <article class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3 flex flex-col justify-between">
                    <div class="space-y-3">
                        <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-[#D6E4F0]/50 text-bdl-navy">
                            {{ $article->category->name ?? 'Warta' }}
                        </span>
                        <h3 class="text-base font-bold text-bdl-navy leading-snug">
                            {{ $article->title }}
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                            {{ strip_tags($article->content) }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                        <span>{{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('d M Y') }}</span>
                        <span class="font-bold text-bdl-primary">Baca Selengkapnya &rarr;</span>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-8 text-xs text-slate-400">
                    Belum ada publikasi artikel di basis data.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- SECTION 9: JARINGAN KANTOR CABANG DINAMIS -->
<section class="py-16 bg-slate-50 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 space-y-8">
        <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Jangkauan Wilayah</span>
                <h2 class="text-2xl font-extrabold text-bdl-navy mt-1">Jaringan Kantor Pelayanan</h2>
            </div>
            <a href="{{ route('services.branches') }}" class="text-xs font-bold text-bdl-primary hover:text-bdl-navy">
                Lihat Seluruh Direktori ({{ $totalBranchesCount }} Kantor Layanan) &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @forelse($branches->take(3) as $branch)
                <div class="p-5 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-bdl-navy text-sm">{{ $branch->name }}</span>
                        <span class="text-[10px] font-semibold text-bdl-primary bg-[#D6E4F0]/50 px-2 py-0.5 rounded">
                            {{ $branch->type === 'HEAD_OFFICE' ? 'Kantor Pusat' : ($branch->type === 'BRANCH' ? 'Kantor Cabang' : 'Kantor Kas') }}
                        </span>
                    </div>
                    <p class="text-slate-600 text-xs leading-relaxed">
                        {{ $branch->address }}
                    </p>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span>Telp: <span class="font-num">{{ $branch->phone ?? '-' }}</span></span>
                        @if($branch->whatsapp)
                            <span class="text-emerald-700 font-semibold font-num">WA: {{ $branch->whatsapp }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-6 text-xs text-slate-400">
                    Data kantor layanan belum tersedia.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
// --- Script Simulasi Kredit Berdasarkan Data Parameter DB ---
let currentTenor = 12;
const interestRatePa = parseFloat("{{ $loanRate }}") / 100;

function setQuickTenor(tenor, btn) {
    currentTenor = tenor;
    document.querySelectorAll('.tenor-btn').forEach(b => {
        b.className = 'tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num';
    });
    btn.className = 'tenor-btn py-2 text-xs font-semibold rounded-lg border border-bdl-primary bg-bdl-navy text-white transition shadow-sm font-num';
    updateQuickCalc();
}

function updateQuickCalc() {
    const P = parseFloat(document.getElementById('quickAmount').value);
    const n = currentTenor;

    const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });
    document.getElementById('quickAmountLabel').innerText = formatter.format(P);

    const monthlyPrincipal = P / n;
    const monthlyInterest = (P * interestRatePa) / 12;
    const monthlyTotal = monthlyPrincipal + monthlyInterest;

    document.getElementById('quickMonthlyRes').innerText = formatter.format(monthlyTotal);
}

// --- Script Simulasi Deposito Berdasarkan Data Bunga LPS DB ---
let currentDepTenor = 3;
const depInterestRatePa = parseFloat("{{ $lpsCurrentRate }}") / 100;

function setDepositTenor(tenor, btn) {
    currentDepTenor = tenor;
    document.querySelectorAll('.dep-tenor-btn').forEach(b => {
        b.className = 'dep-tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num';
    });
    btn.className = 'dep-tenor-btn py-2 text-xs font-semibold rounded-lg border border-bdl-primary bg-bdl-navy text-white transition shadow-sm font-num';
    updateDepositCalc();
}

function updateDepositCalc() {
    const nominal = parseFloat(document.getElementById('depositAmount').value);
    const tenor = currentDepTenor;

    const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });
    document.getElementById('depositAmountLabel').innerText = formatter.format(nominal);

    const monthlyGross = (nominal * depInterestRatePa) / 12;
    const taxRate = (nominal >= 7500000) ? 0.20 : 0.00;
    const monthlyTax = monthlyGross * taxRate;
    const monthlyNet = monthlyGross - monthlyTax;
    const totalNet = monthlyNet * tenor;

    document.getElementById('depositNetRes').innerText = formatter.format(totalNet);
}

document.addEventListener('DOMContentLoaded', () => {
    updateQuickCalc();
    updateDepositCalc();
});
</script>
@endsection