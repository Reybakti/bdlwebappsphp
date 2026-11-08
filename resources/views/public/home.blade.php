@extends('layouts.app')

@section('title', ($profile->name ?? 'PT BPR Bank Daerah Lamongan (Perseroda)') . ' - Solusi Keuangan Terpercaya')

@section('content')
<!-- SECTION 1: HERO SLIDER BERANDA DINAMIS -->
@php
    $bannerList = $banners->isNotEmpty() ? $banners : collect([
        (object)[
            'title' => 'Solusi Permodalan Usaha & Simpanan Terpercaya',
            'subtitle' => 'Mendukung pertumbuhan pelaku usaha dan masyarakat Lamongan dengan layanan perbankan yang aman, transparan, dan dijamin LPS.',
            'image_desktop_url' => 'assets/images/banners/banner-1-desktop.webp',
            'image_mobile_url' => null,
            'button_text' => 'Ajukan Pinjaman',
            'button_url' => '#simulasi-section'
        ]
    ]);
@endphp

<section id="hero-slider" class="relative w-full min-h-[540px] sm:min-h-[580px] lg:min-h-[620px] flex items-center bg-slate-950 overflow-hidden select-none">
    @foreach($bannerList as $idx => $banner)
        @php
            $bgDesk = str_starts_with($banner->image_desktop_url, 'http') 
                ? $banner->image_desktop_url 
                : asset($banner->image_desktop_url);
            $bgMob = $banner->image_mobile_url 
                ? (str_starts_with($banner->image_mobile_url, 'http') ? $banner->image_mobile_url : asset($banner->image_mobile_url)) 
                : $bgDesk;
            $btnText = $banner->button_text ?: 'Ajukan Pinjaman';
            $btnUrl = $banner->button_url ?: '#simulasi-section';
        @endphp

        <div class="hero-slide absolute inset-0 flex items-center transition-opacity duration-500 {{ $idx === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none' }}" data-index="{{ $idx }}">
            <picture class="absolute inset-0 w-full h-full pointer-events-none">
                <source media="(max-width: 640px)" srcset="{{ $bgMob }}">
                <img src="{{ $bgDesk }}" alt="{{ $banner->title }}" class="w-full h-full object-cover object-center filter brightness-[0.40]">
            </picture>

            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-950/60 to-transparent pointer-events-none"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-20 pb-16">
                <div class="max-w-xl text-white space-y-5">
                    <span class="inline-block text-[11px] font-bold tracking-widest text-[#63B3ED] uppercase font-mono">
                        {{ $profile->name ?? 'PT BPR Bank Daerah Lamongan (Perseroda)' }}
                    </span>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight text-white">
                        {{ $banner->title }}
                    </h1>

                    @if(!empty($banner->subtitle))
                        <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                            {{ $banner->subtitle }}
                        </p>
                    @endif

                    <div class="pt-2 flex flex-wrap items-center gap-3">
                        <a href="{{ $btnUrl }}" class="px-5 py-3 bg-[#0066B2] hover:bg-[#0A2540] text-white text-xs font-bold rounded-lg transition shadow-sm">
                            {{ $btnText }} &rarr;
                        </a>
                        <a href="{{ route('services.complaint') }}" class="px-5 py-3 bg-white/10 hover:bg-white/20 text-white text-xs font-semibold rounded-lg border border-white/15 transition">
                            Layanan Pengaduan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @if($bannerList->count() > 1)
        <div class="absolute right-4 sm:right-8 bottom-6 z-20 flex items-center gap-2">
            <div class="flex items-center gap-1.5 mr-2">
                @foreach($bannerList as $idx => $b)
                    <button type="button" onclick="goToSlide({{ $idx }})" 
                            class="hero-dot h-1.5 transition-all duration-200 rounded-full {{ $idx === 0 ? 'w-6 bg-[#0066B2]' : 'w-2 bg-white/40' }}" 
                            aria-label="Slide {{ $idx + 1 }}"></button>
                @endforeach
            </div>

            <button type="button" onclick="prevHeroSlide()" aria-label="Sebelumnya" 
                    class="p-2 rounded-md bg-black/50 hover:bg-black/80 text-white border border-white/10 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button type="button" onclick="nextHeroSlide()" aria-label="Berikutnya" 
                    class="p-2 rounded-md bg-black/50 hover:bg-black/80 text-white border border-white/10 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    @endif
</section>

<!-- SECTION 2: SOLID BLUE METRIC BAR -->
<section class="bg-bdl-primary text-white border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 divide-y lg:divide-y-0 lg:divide-x divide-white/20">
            <div class="py-6 px-4 sm:px-6 text-center space-y-1">
                <div class="text-3xl sm:text-4xl font-extrabold font-num tracking-tight text-white">74+</div>
                <div class="text-xs sm:text-sm font-semibold text-white/90 leading-tight">Tahun Melayani</div>
            </div>

            <div class="py-6 px-4 sm:px-6 text-center space-y-1">
                <div class="text-3xl sm:text-4xl font-extrabold font-num tracking-tight text-white">
                    {{ $totalBranchesCount > 0 ? $totalBranchesCount : '33' }}
                </div>
                <div class="text-xs sm:text-sm font-semibold text-white/90 leading-tight">Kantor Layanan Aktif</div>
            </div>

            <div class="py-6 px-4 sm:px-6 flex flex-col items-center justify-center space-y-2">
                <div class="bg-white px-3.5 py-1.5 rounded-lg shadow-sm flex items-center justify-center">
                    <img src="{{ asset('assets/images/logo-ojk.png') }}" alt="Otoritas Jasa Keuangan" class="h-7 w-auto object-contain">
                </div>
                <div class="text-xs sm:text-sm font-semibold text-white/90 leading-tight">Terdaftar & Diawasi</div>
            </div>

            <div class="py-6 px-4 sm:px-6 flex flex-col items-center justify-center space-y-2">
                <div class="bg-white px-3.5 py-1.5 rounded-lg shadow-sm flex items-center justify-center">
                    <img src="{{ asset('assets/images/logo-lps.png') }}" alt="Lembaga Penjamin Simpanan" class="h-7 w-auto object-contain">
                </div>
                <div class="text-xs sm:text-sm font-semibold text-white/90 leading-tight">Simpanan Dijamin</div>
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
                <p class="text-xs text-slate-600 leading-relaxed">Pengalaman panjang dalam industri perbankan yang kokoh dan berorientasi pada kemajuan ekonomi nasabah.</p>
            </div>

            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-bdl-navy">Penjaminan Penuh LPS</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Seluruh saldo tabungan dan deposito nasabah dijamin oleh Lembaga Penjamin Simpanan (LPS) hingga Rp2 Miliar per nasabah.</p>
            </div>

            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-bdl-navy">Transparansi RIPLAY</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Pemberlakuan Ringkasan Informasi Produk dan Layanan memastikan nasabah memahami bunga, biaya, dan risiko secara terbuka.</p>
            </div>

            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-bdl-navy">Kedekatan dengan UMKM</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Petugas lapangan profesional menjangkau sentra pasar tradisional, peternak, petani, dan pelaku usaha mikro di seluruh kecamatan.</p>
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
                                    {{ number_format($product->simulationParam->base_interest_rate_pa, 2) }}% p.a.
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
                            <a href="{{ asset($product->riplay_file_url) }}" target="_blank" class="text-[10px] font-medium text-slate-400 hover:text-bdl-primary underline">
                                PDF RIPLAY
                            </a>
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

<!-- SECTION 5: KALKULATOR SIMULASI DUAL-MODE DINAMIS -->
@php
    // Parameter Kredit dari Database
    $loanParam = $loanProduct?->simulationParam;
    $loanMinAmount = (float)($loanParam?->min_amount ?? 5000000);
    $loanMaxAmount = (float)($loanParam?->max_amount ?? 200000000);
    $loanRate = (float)($loanParam?->base_interest_rate_pa ?? 10.50);
    $loanMethod = $loanParam?->calculation_method ?? 'FLAT';
    $loanMinTenor = (int)($loanParam?->min_tenor_months ?? 6);
    $loanMaxTenor = (int)($loanParam?->max_tenor_months ?? 36);
    $defaultLoanAmount = max($loanMinAmount, min(25000000, $loanMaxAmount));

    // Menentukan opsi tenor kredit yang aktif
    $candidateLoanTenors = [6, 12, 24, 36, 48, 60];
    $loanTenorOptions = array_values(array_filter($candidateLoanTenors, fn($t) => $t >= $loanMinTenor && $t <= $loanMaxTenor));
    if (empty($loanTenorOptions)) {
        $loanTenorOptions = [$loanMinTenor, $loanMaxTenor];
    }
    $initialLoanTenor = in_array(12, $loanTenorOptions) ? 12 : $loanTenorOptions[0];

    // Parameter Deposito dari Database
    $depositParam = $depositProduct?->simulationParam;
    $depositMinAmount = (float)($depositParam?->min_amount ?? 5000000);
    $depositMaxAmount = (float)($depositParam?->max_amount ?? 500000000);
    $depositRate = (float)($depositParam?->base_interest_rate_pa ?? ($lpsRate?->rate_idr ?? 6.75));
    $depositMinTenor = (int)($depositParam?->min_tenor_months ?? 1);
    $depositMaxTenor = (int)($depositParam?->max_tenor_months ?? 12);
    $defaultDepositAmount = max($depositMinAmount, min(50000000, $depositMaxAmount));

    // Menentukan opsi tenor deposito yang aktif
    $candidateDepTenors = [1, 3, 6, 12, 24];
    $depTenorOptions = array_values(array_filter($candidateDepTenors, fn($t) => $t >= $depositMinTenor && $t <= $depositMaxTenor));
    if (empty($depTenorOptions)) {
        $depTenorOptions = [$depositMinTenor, $depositMaxTenor];
    }
    $initialDepTenor = in_array(3, $depTenorOptions) ? 3 : $depTenorOptions[0];
@endphp

<section id="simulasi-section" class="py-16 bg-slate-50 border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 space-y-8">
        <div class="max-w-2xl">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Kalkulator Interaktif Transparan</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy mt-1">Simulasi Perhitungan Keuangan</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Hitung estimasi kewajiban angsuran kredit atau potensi imbal hasil deposito Anda secara mandiri sebelum berkunjung ke kantor cabang.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Box Simulasi Kredit -->
            <div class="lg:col-span-6 bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="text-base font-bold text-bdl-navy">{{ $loanProduct->name ?? 'Simulasi Kredit Modal Kerja' }}</h3>
                        <p class="text-xs text-slate-500">Metode suku bunga {{ strtolower($loanMethod) }} tahunan (p.a.)</p>
                    </div>
                    <span class="text-xs font-num font-bold text-bdl-primary bg-[#D6E4F0]/40 px-2.5 py-1 rounded">
                        {{ number_format($loanRate, 2) }}% {{ ucfirst(strtolower($loanMethod)) }}
                    </span>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-2">
                            <span>Plafon Pinjaman:</span>
                            <span id="quickAmountLabel" class="text-bdl-primary font-num text-base font-bold">
                                Rp{{ number_format($defaultLoanAmount, 0, ',', '.') }}
                            </span>
                        </div>
                        <input type="range" id="quickAmount" 
                               min="{{ $loanMinAmount }}" 
                               max="{{ $loanMaxAmount }}" 
                               step="1000000" 
                               value="{{ $defaultLoanAmount }}"
                               class="w-full accent-bdl-primary h-2 bg-slate-200 rounded-lg cursor-pointer" 
                               oninput="updateQuickCalc()">
                        <div class="flex justify-between text-[10px] text-slate-400 font-num mt-1">
                            <span>Rp{{ number_format($loanMinAmount, 0, ',', '.') }}</span>
                            <span>Rp{{ number_format(($loanMinAmount + $loanMaxAmount) / 2, 0, ',', '.') }}</span>
                            <span>Rp{{ number_format($loanMaxAmount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Jangka Waktu Pinjaman (Tenor):</label>
                        <div class="grid grid-cols-{{ count($loanTenorOptions) > 4 ? 4 : count($loanTenorOptions) }} gap-2">
                            @foreach($loanTenorOptions as $tOption)
                                <button type="button" onclick="setQuickTenor({{ $tOption }}, this)" 
                                        class="tenor-btn py-2 text-xs font-semibold rounded-lg border {{ $tOption === $initialLoanTenor ? 'border-bdl-primary bg-bdl-navy text-white shadow-sm' : 'border-slate-200 text-slate-600 hover:border-bdl-primary' }} transition font-num">
                                    {{ $tOption }} Bulan
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Estimasi Angsuran Bulanan</span>
                            <span id="quickMonthlyRes" class="text-2xl font-extrabold text-bdl-navy font-num">Rp0</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Pokok + Porsi Bunga</span>
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
                        <p class="text-xs text-slate-500">Pajak bunga PPh 20% berlaku untuk saldo nominal &ge; Rp7,5 Juta</p>
                    </div>
                    <span class="text-xs font-num font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded">
                        Bunga: {{ number_format($depositRate, 2) }}% p.a.
                    </span>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-2">
                            <span>Nominal Deposito:</span>
                            <span id="depositAmountLabel" class="text-bdl-primary font-num text-base font-bold">
                                Rp{{ number_format($defaultDepositAmount, 0, ',', '.') }}
                            </span>
                        </div>
                        <input type="range" id="depositAmount" 
                               min="{{ $depositMinAmount }}" 
                               max="{{ $depositMaxAmount }}" 
                               step="1000000" 
                               value="{{ $defaultDepositAmount }}"
                               class="w-full accent-bdl-primary h-2 bg-slate-200 rounded-lg cursor-pointer" 
                               oninput="updateDepositCalc()">
                        <div class="flex justify-between text-[10px] text-slate-400 font-num mt-1">
                            <span>Rp{{ number_format($depositMinAmount, 0, ',', '.') }}</span>
                            <span>Rp{{ number_format(($depositMinAmount + $depositMaxAmount) / 2, 0, ',', '.') }}</span>
                            <span>Rp{{ number_format($depositMaxAmount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Jangka Waktu Penempatan:</label>
                        <div class="grid grid-cols-{{ count($depTenorOptions) > 4 ? 4 : count($depTenorOptions) }} gap-2">
                            @foreach($depTenorOptions as $dOption)
                                <button type="button" onclick="setDepositTenor({{ $dOption }}, this)" 
                                        class="dep-tenor-btn py-2 text-xs font-semibold rounded-lg border {{ $dOption === $initialDepTenor ? 'border-bdl-primary bg-bdl-navy text-white shadow-sm' : 'border-slate-200 text-slate-600 hover:border-bdl-primary' }} transition font-num">
                                    {{ $dOption }} Bulan
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Estimasi Bunga Bersih Total</span>
                            <span id="depositNetRes" class="text-2xl font-extrabold text-emerald-700 font-num">Rp0</span>
                            <span id="depositTaxNote" class="text-[10px] text-slate-400 block mt-0.5">Sudah dipotong PPh 20%</span>
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
            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-xs text-slate-400">
                        <span class="font-bold text-bdl-primary uppercase">{{ $latestFinancialReport->type ?? 'TRIWULAN II' }} {{ $latestFinancialReport->year ?? '2026' }}</span>
                        <span>{{ $latestFinancialReport ? \Carbon\Carbon::parse($latestFinancialReport->published_at)->translatedFormat('d F Y') : '-' }}</span>
                    </div>
                    <h3 class="text-base font-bold text-bdl-navy">{{ $latestFinancialReport->title ?? 'Laporan Keuangan Publikasi' }}</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Ringkasan Neraca, Laporan Laba Rugi, Kualitas Aktiva Produktif (KAP), dan Rasio Keuangan Publikasi sesuai ketentuan SEOJK.
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('transparency.financial') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-bdl-primary hover:text-bdl-navy">
                        <span>Buka Laporan Keuangan</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    @if($latestFinancialReport && $latestFinancialReport->file_url)
                        <a href="{{ asset($latestFinancialReport->file_url) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-bdl-primary" title="Unduh PDF Langsung">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Laporan GCG Terkini -->
            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-xs text-slate-400">
                        <span class="font-bold text-bdl-primary uppercase">TATA KELOLA (GCG) {{ $latestGcgReport->year ?? '2025' }}</span>
                        <span>{{ $latestGcgReport ? \Carbon\Carbon::parse($latestGcgReport->published_at)->translatedFormat('d F Y') : '-' }}</span>
                    </div>
                    <h3 class="text-base font-bold text-bdl-navy">{{ $latestGcgReport->title ?? 'Laporan Tata Kelola (GCG)' }}</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Evaluasi kepatuhan direksi, dewan komisaris, komite audit, dan penerapan manajemen risiko perbankan tahunan.
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('transparency.gcg') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-bdl-primary hover:text-bdl-navy">
                        <span>Buka Laporan GCG</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    @if($latestGcgReport && $latestGcgReport->file_url)
                        <a href="{{ asset($latestGcgReport->file_url) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-bdl-primary" title="Unduh PDF Langsung">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Ketentuan LPS Terkini -->
            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-xs text-slate-400">
                        <span class="font-bold text-bdl-primary">PENJAMINAN LPS</span>
                        <span>{{ $lpsRate ? \Carbon\Carbon::parse($lpsRate->effective_start_date)->translatedFormat('M Y') : 'Aktif' }}</span>
                    </div>
                    <h3 class="text-base font-bold text-bdl-navy">Tingkat Bunga Penjaminan (TBP) LPS</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Batas suku bunga simpanan Rupiah BPR yang dijamin sebesar <strong class="font-num text-bdl-navy">{{ number_format($lpsRate?->rate_idr ?? 6.75, 2) }}% p.a.</strong> Berlaku s/d {{ $lpsRate ? \Carbon\Carbon::parse($lpsRate->effective_end_date)->translatedFormat('d M Y') : 'periode aktif' }}.
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('transparency.lps') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-bdl-primary hover:text-bdl-navy">
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
            <a href="{{ route('media.news') }}" class="text-xs font-bold text-bdl-primary hover:text-bdl-navy">
                Lihat Seluruh Warta &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($latestArticles as $article)
                <article class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3 flex flex-col justify-between hover:border-bdl-primary hover:shadow-md transition">
                    <div class="space-y-3">
                        <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-[#D6E4F0]/50 text-bdl-navy inline-block">
                            {{ $article->category->name ?? 'Warta' }}
                        </span>
                        <h3 class="text-base font-bold text-bdl-navy leading-snug hover:text-bdl-primary transition">
                            <a href="{{ route('media.show', $article->slug) }}">
                                {{ $article->title }}
                            </a>
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                            {{ strip_tags($article->content) }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                        <span>{{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('d M Y') }}</span>
                        <a href="{{ route('media.show', $article->slug) }}" class="font-bold text-bdl-primary hover:underline">
                            Baca Selengkapnya &rarr;
                        </a>
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
                <div class="p-5 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-2 hover:border-bdl-primary transition">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-bdl-navy text-sm">{{ $branch->name }}</span>
                        <span class="text-[10px] font-semibold text-bdl-primary bg-[#D6E4F0]/50 px-2 py-0.5 rounded">
                            {{ $branch->type === 'HEAD_OFFICE' ? 'Kantor Pusat' : ($branch->type === 'BRANCH' ? 'Kantor Cabang' : 'Kantor Kas') }}
                        </span>
                    </div>
                    <p class="text-slate-600 text-xs leading-relaxed">
                        {{ $branch->address }}
                    </p>
                    <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-500">
                        <div class="flex items-center gap-3">
                            <span>Telp: <span class="font-num text-slate-700 font-semibold">{{ $branch->phone ?? '-' }}</span></span>
                            
                            @if($branch->whatsapp)
                                @php
                                    $cleanWa = preg_replace('/[^0-9]/', '', $branch->whatsapp);
                                    if (str_starts_with($cleanWa, '0')) {
                                        $cleanWa = '62' . substr($cleanWa, 1);
                                    }
                                @endphp
                                <a href="https://wa.me/{{ $cleanWa }}" target="_blank" rel="noopener noreferrer" class="text-emerald-700 hover:underline font-semibold font-num">
                                    WA: {{ $branch->whatsapp }}
                                </a>
                            @endif
                        </div>

                        @if($branch->email)
                            <a href="mailto:{{ $branch->email }}" class="text-[#0066B2] hover:underline font-medium text-[11px] truncate max-w-[160px]" title="{{ $branch->email }}">
                                {{ $branch->email }}
                            </a>
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
// --- SCRIPT HERO BANNER CAROUSEL ---
let currentSlideIndex = 0;
const slides = document.querySelectorAll('.hero-slide');
const dots = document.querySelectorAll('.hero-dot');
let slideInterval = null;

function showSlide(index) {
    if (!slides || slides.length <= 1) return;
    
    if (index >= slides.length) currentSlideIndex = 0;
    else if (index < 0) currentSlideIndex = slides.length - 1;
    else currentSlideIndex = index;

    slides.forEach((slide, idx) => {
        const isCurrent = (idx === currentSlideIndex);
        slide.classList.toggle('opacity-100', isCurrent);
        slide.classList.toggle('z-10', isCurrent);
        slide.classList.toggle('opacity-0', !isCurrent);
        slide.classList.toggle('z-0', !isCurrent);
        slide.classList.toggle('pointer-events-none', !isCurrent);
    });

    if (dots && dots.length) {
        dots.forEach((dot, idx) => {
            const isCurrent = (idx === currentSlideIndex);
            dot.className = isCurrent 
                ? 'hero-dot h-1.5 transition-all duration-200 rounded-full w-6 bg-[#0066B2]' 
                : 'hero-dot h-1.5 transition-all duration-200 rounded-full w-2 bg-white/40';
        });
    }
}

function nextHeroSlide() { showSlide(currentSlideIndex + 1); resetSlideTimer(); }
function prevHeroSlide() { showSlide(currentSlideIndex - 1); resetSlideTimer(); }
function goToSlide(index) { showSlide(index); resetSlideTimer(); }

function startSlideTimer() {
    if (slides && slides.length > 1) {
        slideInterval = setInterval(() => { showSlide(currentSlideIndex + 1); }, 6000);
    }
}

function resetSlideTimer() {
    if (slideInterval) { clearInterval(slideInterval); startSlideTimer(); }
}

// --- SCRIPT KALKULATOR KREDIT DINAMIS DARI DATABASE ---
let currentLoanTenor = {{ $initialLoanTenor }};
const loanRatePa = parseFloat("{{ $loanRate }}") / 100;
const loanMethod = "{{ strtoupper($loanMethod) }}";
const currencyFormatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });

function setQuickTenor(tenor, btn) {
    currentLoanTenor = tenor;
    document.querySelectorAll('.tenor-btn').forEach(b => {
        b.className = 'tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num';
    });
    btn.className = 'tenor-btn py-2 text-xs font-semibold rounded-lg border border-bdl-primary bg-bdl-navy text-white transition shadow-sm font-num';
    updateQuickCalc();
}

function updateQuickCalc() {
    const amountInput = document.getElementById('quickAmount');
    if (!amountInput) return;

    const P = parseFloat(amountInput.value);
    const n = currentLoanTenor;

    const labelEl = document.getElementById('quickAmountLabel');
    if (labelEl) labelEl.innerText = currencyFormatter.format(P);

    let monthlyTotal = 0;
    if (loanMethod === 'ANNUITY') {
        const monthlyRate = loanRatePa / 12;
        if (monthlyRate > 0) {
            monthlyTotal = P * (monthlyRate * Math.pow(1 + monthlyRate, n)) / (Math.pow(1 + monthlyRate, n) - 1);
        } else {
            monthlyTotal = P / n;
        }
    } else {
        // FLAT (Default standard BPR)
        const monthlyPrincipal = P / n;
        const monthlyInterest = (P * loanRatePa) / 12;
        monthlyTotal = monthlyPrincipal + monthlyInterest;
    }

    const resEl = document.getElementById('quickMonthlyRes');
    if (resEl) resEl.innerText = currencyFormatter.format(monthlyTotal);
}

// --- SCRIPT KALKULATOR DEPOSITO DINAMIS DARI DATABASE ---
let currentDepTenor = {{ $initialDepTenor }};
const depRatePa = parseFloat("{{ $depositRate }}") / 100;

function setDepositTenor(tenor, btn) {
    currentDepTenor = tenor;
    document.querySelectorAll('.dep-tenor-btn').forEach(b => {
        b.className = 'dep-tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num';
    });
    btn.className = 'dep-tenor-btn py-2 text-xs font-semibold rounded-lg border border-bdl-primary bg-bdl-navy text-white transition shadow-sm font-num';
    updateDepositCalc();
}

function updateDepositCalc() {
    const depInput = document.getElementById('depositAmount');
    if (!depInput) return;

    const nominal = parseFloat(depInput.value);
    const tenor = currentDepTenor;

    const labelEl = document.getElementById('depositAmountLabel');
    if (labelEl) labelEl.innerText = currencyFormatter.format(nominal);

    const monthlyGross = (nominal * depRatePa) / 12;
    // Ketentuan pajak deposito nasional: saldo >= 7.500.000 dikenakan PPh 20%
    const isTaxable = nominal >= 7500000;
    const taxRate = isTaxable ? 0.20 : 0.00;
    const monthlyTax = monthlyGross * taxRate;
    const monthlyNet = monthlyGross - monthlyTax;
    const totalNet = monthlyNet * tenor;

    const resEl = document.getElementById('depositNetRes');
    if (resEl) resEl.innerText = currencyFormatter.format(totalNet);

    const taxNoteEl = document.getElementById('depositTaxNote');
    if (taxNoteEl) {
        taxNoteEl.innerText = isTaxable ? 'Sudah dipotong PPh 20%' : 'Bebas Pajak (Nominal < Rp7,5 Juta)';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    startSlideTimer();
    updateQuickCalc();
    updateDepositCalc();
});
</script>
@endsection