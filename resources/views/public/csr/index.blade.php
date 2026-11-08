@extends('layouts.app')

@section('title', 'Tanggung Jawab Sosial & Lingkungan (CSR) | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section -->
<section class="relative min-h-[360px] lg:min-h-[420px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?auto=format&fit=crop&w=1920&q=80" 
         alt="Program CSR Bank Daerah Lamongan" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.38]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Corporate Social Responsibility
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Tanggung Jawab Sosial & Lingkungan
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                Komitmen berkelanjutan PT BPR Bank Daerah Lamongan (Perseroda) dalam memajukan perekonomian daerah, kesejahteraan sosial, dan kelestarian lingkungan hidup di Kabupaten Lamongan.
            </p>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Tab Sticky -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <a href="{{ route('about.profile') }}" class="hover:text-bdl-primary transition whitespace-nowrap">Profil Lembaga</a>
            <a href="{{ route('about.management') }}" class="hover:text-bdl-primary transition whitespace-nowrap">Direksi & Dekom</a>
            <span class="text-bdl-primary font-bold border-b-2 border-bdl-primary pb-1 whitespace-nowrap">Tanggung Jawab Sosial (CSR)</span>
        </div>
    </div>
</nav>

<!-- Konten Utama Program CSR -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-16">

    <!-- 4 Pilar CSR -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-2 hover:border-bdl-primary transition">
            <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 font-bold flex items-center justify-center text-xs">01</span>
            <h4 class="font-bold text-xs text-bdl-navy">Pemberdayaan UMKM</h4>
            <p class="text-[11px] text-slate-500 leading-relaxed">Penyediaan modal stimulus, pelatihan tata kelola, dan pendampingan usaha mikro daerah.</p>
        </div>
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-2 hover:border-bdl-primary transition">
            <span class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 font-bold flex items-center justify-center text-xs">02</span>
            <h4 class="font-bold text-xs text-bdl-navy">Pendidikan & Literasi</h4>
            <p class="text-[11px] text-slate-500 leading-relaxed">Edukasi cerdas keuangan untuk pelajar, santri, dan beasiswa keluarga prasejahtera.</p>
        </div>
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-2 hover:border-bdl-primary transition">
            <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 font-bold flex items-center justify-center text-xs">03</span>
            <h4 class="font-bold text-xs text-bdl-navy">Sosial Kemasyarakatan</h4>
            <p class="text-[11px] text-slate-500 leading-relaxed">Bantuan tanggap darurat bencana, santunan kemanusiaan, serta sarana peribadatan.</p>
        </div>
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-2 hover:border-bdl-primary transition">
            <span class="w-8 h-8 rounded-lg bg-teal-50 text-teal-700 font-bold flex items-center justify-center text-xs">04</span>
            <h4 class="font-bold text-xs text-bdl-navy">Lingkungan Hidup</h4>
            <p class="text-[11px] text-slate-500 leading-relaxed">Program konservasi pesisir pantai utara, penghijauan daerah aliran sungai, dan sanitasi.</p>
        </div>
    </div>

    <!-- Arsip Kegiatan CSR -->
    <div class="space-y-8">
        <div class="border-b border-slate-200 pb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Dokumentasi Realisasi Program</span>
                <h2 class="text-2xl font-extrabold text-bdl-navy mt-1">Kegiatan Tanggung Jawab Sosial</h2>
            </div>

            <!-- Filter Kategori & Pencarian -->
            <form action="{{ route('about.csr') }}" method="GET" class="flex flex-wrap items-center gap-2.5">
                <select name="category" onchange="this.form.submit()" class="text-xs font-semibold text-slate-700 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-bdl-primary">
                    <option value="">Semua Pilar CSR ({{ $counts['all'] }})</option>
                    <option value="PEMBERDAYAAN_UMKM" {{ request('category') === 'PEMBERDAYAAN_UMKM' ? 'selected' : '' }}>Pemberdayaan UMKM ({{ $counts['umkm'] }})</option>
                    <option value="PENDIDIKAN_LITERASI" {{ request('category') === 'PENDIDIKAN_LITERASI' ? 'selected' : '' }}>Pendidikan & Literasi ({{ $counts['pendidikan'] }})</option>
                    <option value="SOSIAL_KEMASYARAKATAN" {{ request('category') === 'SOSIAL_KEMASYARAKATAN' ? 'selected' : '' }}>Sosial Kemasyarakatan ({{ $counts['sosial'] }})</option>
                    <option value="LINGKUNGAN_HIDUP" {{ request('category') === 'LINGKUNGAN_HIDUP' ? 'selected' : '' }}>Lingkungan Hidup ({{ $counts['lingkungan'] }})</option>
                </select>

                <div class="relative min-w-[200px]">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kegiatan, lokasi..." 
                           class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-8 pr-3 py-2 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-bdl-primary transition">
                    <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                <button type="submit" class="px-4 py-2 bg-bdl-primary hover:bg-bdl-navy text-white text-xs font-bold rounded-lg transition">
                    Filter
                </button>

                @if(request()->anyFilled(['category', 'q']))
                    <a href="{{ route('about.csr') }}" class="text-xs font-bold text-rose-600 hover:text-rose-700 px-1">Reset</a>
                @endif
            </form>
        </div>

        <!-- Grid Program CSR -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($programs as $item)
                @php
                    $categoryBadge = match($item->category) {
                        'PEMBERDAYAAN_UMKM' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                        'PENDIDIKAN_LITERASI' => 'bg-sky-50 text-sky-800 border-sky-200',
                        'SOSIAL_KEMASYARAKATAN' => 'bg-amber-50 text-amber-800 border-amber-200',
                        'LINGKUNGAN_HIDUP' => 'bg-teal-50 text-teal-800 border-teal-200',
                        default => 'bg-slate-50 text-slate-700 border-slate-200',
                    };
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden flex flex-col justify-between hover:border-bdl-primary hover:shadow-md transition duration-200 group">
                    <div>
                        <!-- Thumbnail Cover -->
                        <div class="relative w-full aspect-[16/10] overflow-hidden bg-slate-100">
                            @if($item->image_url)
                                <img src="{{ asset($item->image_url) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif

                            <div class="absolute top-3 left-3">
                                <span class="font-bold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded border {{ $categoryBadge }} backdrop-blur-md shadow-sm">
                                    {{ str_replace('_', ' ', $item->category) }}
                                </span>
                            </div>
                        </div>

                        <!-- Info Program -->
                        <div class="p-6 space-y-3">
                            <div class="flex items-center gap-2 text-xs text-slate-400 font-mono">
                                <span>{{ \Carbon\Carbon::parse($item->activity_date)->translatedFormat('d M Y') }}</span>
                                <span>•</span>
                                <span class="truncate">{{ $item->location }}</span>
                            </div>

                            <h3 class="text-base font-bold text-bdl-navy group-hover:text-bdl-primary transition leading-snug line-clamp-2">
                                <a href="{{ route('about.csr.detail', $item->slug) }}">
                                    {{ $item->title }}
                                </a>
                            </h3>

                            <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                {{ Str::limit(strip_tags($item->description), 130) }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer Kartu -->
                    <div class="p-6 pt-0 mt-2">
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                            <a href="{{ route('about.csr.detail', $item->slug) }}" 
                               class="inline-flex items-center gap-1.5 font-bold text-bdl-primary hover:text-bdl-navy transition">
                                <span>Dokumentasi Lengkap</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>

                            @if($item->document_url)
                                <a href="{{ asset($item->document_url) }}" target="_blank" download class="inline-flex items-center gap-1 text-[11px] text-slate-400 hover:text-bdl-primary font-semibold" title="Unduh Berkas Laporan">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span>PDF</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
                    <p class="text-xs text-slate-500">Tidak ada program CSR yang sesuai dengan kriteria filter.</p>
                    <a href="{{ route('about.csr') }}" class="text-xs font-bold text-bdl-primary hover:underline">
                        Reset Filter
                    </a>
                </div>
            @endforelse
        </div>

        @if($programs->hasPages())
            <div class="pt-4 flex justify-center">
                {{ $programs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection