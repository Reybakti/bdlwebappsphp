@extends('layouts.app')

@section('title', $program->title . ' | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section -->
<section class="relative min-h-[320px] lg:min-h-[380px] flex items-center bg-slate-900 overflow-hidden">
    @if($program->image_url)
        <img src="{{ asset($program->image_url) }}" 
             alt="{{ $program->title }}" 
             class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.35]">
    @else
        <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?auto=format&fit=crop&w=1920&q=80" 
             alt="CSR Bank Daerah Lamongan" 
             class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.35]">
    @endif

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-3xl space-y-4">
            @php
                $categoryBadge = match($program->category) {
                    'PEMBERDAYAAN_UMKM' => 'bg-emerald-500/20 text-emerald-300 border-emerald-400/30',
                    'PENDIDIKAN_LITERASI' => 'bg-sky-500/20 text-sky-300 border-sky-400/30',
                    'SOSIAL_KEMASYARAKATAN' => 'bg-amber-500/20 text-amber-300 border-amber-400/30',
                    'LINGKUNGAN_HIDUP' => 'bg-teal-500/20 text-teal-300 border-teal-400/30',
                    default => 'bg-white/10 text-bdl-soft border-white/20',
                };
            @endphp
            <div class="inline-flex items-center gap-2 px-3 py-1 backdrop-blur-md border rounded-full text-[11px] font-semibold tracking-wider uppercase {{ $categoryBadge }}">
                {{ str_replace('_', ' ', $program->category) }}
            </div>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight leading-snug">
                {{ $program->title }}
            </h1>

            <div class="flex flex-wrap items-center gap-3 text-xs text-white/80 font-mono">
                <span>{{ \Carbon\Carbon::parse($program->activity_date)->translatedFormat('d F Y') }}</span>
                <span>•</span>
                <span>Lokasi: {{ $program->location }}</span>
            </div>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Breadcrumbs Sticky -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-3 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <a href="{{ route('about.csr') }}" class="hover:text-bdl-primary transition whitespace-nowrap">&larr; Kembali ke Daftar Program CSR</a>
            <span class="text-slate-300">/</span>
            <span class="text-bdl-navy truncate max-w-sm font-bold">{{ $program->title }}</span>
        </div>
    </div>
</nav>

<!-- Konten Rincian Program -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- Kolom Kiri: Narasi & Galeri Foto -->
        <div class="lg:col-span-2 space-y-10">
            
            <!-- Foto Utama -->
            @if($program->image_url)
                <div class="rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 shadow-sm aspect-[16/9]">
                    <img src="{{ asset($program->image_url) }}" alt="{{ $program->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <!-- Uraian Naskah -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-4">
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Deskripsi Kegiatan</span>
                <div class="text-xs sm:text-sm text-slate-700 leading-relaxed space-y-4 font-normal">
                    {!! nl2br(e($program->description)) !!}
                </div>
            </div>

            <!-- Galeri Multi Foto Lapangan -->
            @if($program->galleryImages && $program->galleryImages->count() > 0)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-5">
                    <div>
                        <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Dokumentasi Visual</span>
                        <h3 class="text-lg font-bold text-bdl-navy mt-1">Galeri Foto Pelaksanaan Lapangan</h3>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($program->galleryImages as $photo)
                            <a href="{{ asset($photo->image_url) }}" target="_blank" class="rounded-xl overflow-hidden aspect-square border border-slate-200 bg-slate-100 group block shadow-sm">
                                <img src="{{ asset($photo->image_url) }}" alt="Galeri CSR" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <!-- Kolom Kanan: Panel Info, Dokumen Unduhan & Program Terkait -->
        <div class="space-y-6">

            <!-- Ringkasan Metadata -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-5 shadow-sm">
                <h4 class="text-xs font-bold uppercase tracking-wider text-bdl-navy border-b border-slate-100 pb-3">Informasi Pelaksanaan</h4>

                <div class="space-y-3.5 text-xs">
                    <div>
                        <span class="text-slate-400 block text-[11px]">Pilar Kategori:</span>
                        <strong class="text-bdl-navy">{{ str_replace('_', ' ', $program->category) }}</strong>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Wilayah / Lokasi:</span>
                        <strong class="text-slate-800">{{ $program->location }}</strong>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Tanggal Realisasi:</span>
                        <strong class="text-slate-800 font-mono">{{ \Carbon\Carbon::parse($program->activity_date)->translatedFormat('d F Y') }}</strong>
                    </div>

                    @if($program->budget_amount)
                        <div>
                            <span class="text-slate-400 block text-[11px]">Alokasi Anggaran:</span>
                            <strong class="text-bdl-primary font-mono text-sm">Rp {{ number_format($program->budget_amount, 0, ',', '.') }}</strong>
                        </div>
                    @endif
                </div>

                <!-- Tombol Unduh Dokumen Pendukung -->
                @if($program->document_url)
                    <div class="pt-4 border-t border-slate-100">
                        <a href="{{ asset($program->document_url) }}" target="_blank" download 
                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-bdl-primary hover:bg-bdl-navy text-white text-xs font-bold rounded-xl transition shadow-md shadow-bdl-primary/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Unduh Laporan / BA</span>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Program Terkait Lainnya -->
            @if(isset($otherPrograms) && $otherPrograms->count() > 0)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4 shadow-sm">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-bdl-navy border-b border-slate-100 pb-3">Kegiatan CSR Lainnya</h4>
                    
                    <div class="space-y-3.5">
                        @foreach($otherPrograms as $other)
                            <a href="{{ route('about.csr.detail', $other->slug) }}" class="flex items-center gap-3 group">
                                @if($other->image_url)
                                    <img src="{{ asset($other->image_url) }}" alt="{{ $other->title }}" class="w-14 h-14 rounded-xl object-cover shrink-0 border border-slate-100">
                                @else
                                    <div class="w-14 h-14 rounded-xl bg-slate-100 flex items-center justify-center text-slate-300 shrink-0 border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <span class="text-[10px] text-slate-400 font-mono block">{{ \Carbon\Carbon::parse($other->activity_date)->translatedFormat('d M Y') }}</span>
                                    <h5 class="text-xs font-bold text-bdl-navy group-hover:text-bdl-primary transition line-clamp-2 leading-snug">{{ $other->title }}</h5>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    </div>
</div>
@endsection