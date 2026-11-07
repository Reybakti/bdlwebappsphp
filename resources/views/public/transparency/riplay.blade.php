@extends('layouts.app')

@section('title', 'Ringkasan Informasi Produk (RIPLAY) | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section -->
<section class="relative min-h-[360px] lg:min-h-[420px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=1920&q=80" 
         alt="Transparansi Informasi Produk Perbankan BDL" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.40]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Perlindungan Konsumen (POJK No. 22/2023)
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Ringkasan Informasi Produk (RIPLAY)
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                Dokumen resmi yang merangkum fitur, biaya, manfaat, risiko, dan tata cara penggunaan produk perbankan secara transparan sebelum nasabah mengambil keputusan finansial.
            </p>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Transparansi -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <a href="{{ route('transparency.financial') }}" class="hover:text-bdl-primary transition whitespace-nowrap">Laporan Keuangan</a>
            <a href="{{ route('transparency.gcg') }}" class="hover:text-bdl-primary transition whitespace-nowrap">Laporan Tata Kelola (GCG)</a>
            <a href="{{ route('transparency.lps') }}" class="hover:text-bdl-primary transition whitespace-nowrap">Tingkat Bunga Penjaminan LPS</a>
            <span class="text-bdl-primary font-bold border-b-2 border-bdl-primary pb-1 whitespace-nowrap">Dokumen RIPLAY</span>
        </div>
    </div>
</nav>

<!-- Konten Utama RIPLAY -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-12">

    <div class="border-b border-slate-200 pb-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Katalog RIPLAY Versi Umum</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy mt-1">Unduh Ringkasan Informasi Produk</h2>
            <p class="text-xs text-slate-500 mt-1 max-w-xl leading-relaxed">
                Pilih kategori produk untuk melihat rincian ketentuan umum dan mengunduh berkas PDF RIPLAY resmi.
            </p>
        </div>

        <!-- Filter Tab Kategori Produk -->
        <div class="flex items-center gap-2 overflow-x-auto text-xs font-semibold p-1 bg-slate-100 rounded-xl">
            <a href="{{ route('transparency.riplay') }}" 
               class="px-4 py-2 rounded-lg transition {{ !request('category') ? 'bg-white text-bdl-navy shadow-sm' : 'text-slate-600 hover:text-bdl-navy' }}">
                Semua Produk
            </a>
            <a href="{{ route('transparency.riplay') }}?category=tabungan" 
               class="px-4 py-2 rounded-lg transition {{ request('category') === 'tabungan' ? 'bg-white text-bdl-navy shadow-sm' : 'text-slate-600 hover:text-bdl-navy' }}">
                Tabungan
            </a>
            <a href="{{ route('transparency.riplay') }}?category=deposito" 
               class="px-4 py-2 rounded-lg transition {{ request('category') === 'deposito' ? 'bg-white text-bdl-navy shadow-sm' : 'text-slate-600 hover:text-bdl-navy' }}">
                Deposito
            </a>
            <a href="{{ route('transparency.riplay') }}?category=kredit" 
               class="px-4 py-2 rounded-lg transition {{ request('category') === 'kredit' ? 'bg-white text-bdl-navy shadow-sm' : 'text-slate-600 hover:text-bdl-navy' }}">
                Kredit
            </a>
        </div>
    </div>

    <!-- Grid Dokumen RIPLAY -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:border-bdl-primary hover:shadow-md transition duration-200">
                <div class="space-y-4">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded bg-[#D6E4F0]/50 text-bdl-navy">
                            {{ $product->category->name ?? 'Produk Bank' }}
                        </span>
                        <span class="text-emerald-700 font-semibold text-[11px] bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                            Versi Umum
                        </span>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-bdl-navy leading-snug">
                            {{ $product->name }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                            {{ $product->short_description }}
                        </p>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-xl space-y-2 text-xs text-slate-600">
                        @if($product->simulationParam)
                            <div class="flex justify-between">
                                <span>Indikasi Bunga:</span>
                                <strong class="font-num text-bdl-navy">{{ $product->simulationParam->base_interest_rate_pa }}% p.a.</strong>
                            </div>
                        @else
                            <div class="flex justify-between">
                                <span>Biaya Bulanan:</span>
                                <strong class="text-emerald-600 font-semibold">Bebas Biaya Admin</strong>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span>Kepatuhan:</span>
                            <strong class="text-slate-700">Standar OJK & LPS</strong>
                        </div>
                    </div>
                </div>

                <div class="pt-5 mt-6 border-t border-slate-100 flex items-center justify-between">
                    @if($product->riplay_file_url)
                        <a href="{{ str_starts_with($product->riplay_file_url, 'http') ? $product->riplay_file_url : asset($product->riplay_file_url) }}" 
                           target="_blank" 
                           class="inline-flex items-center gap-1.5 text-xs font-bold text-bdl-primary hover:text-bdl-navy transition">
                            <span>Unduh RIPLAY (PDF)</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </a>
                    @else
                        <span class="text-xs text-slate-400 italic">Dokumen tersedia di Cabang</span>
                    @endif

                    <span class="text-[10px] text-slate-400">PDF Terverifikasi</span>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-slate-50 rounded-2xl border border-slate-200 text-xs text-slate-500">
                Belum ada produk aktif pada kategori yang dipilih.
            </div>
        @endforelse
    </div>

</div>
@endsection