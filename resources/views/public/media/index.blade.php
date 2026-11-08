@extends('layouts.app')

@section('title', $pageTitle . ' | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section -->
<section class="relative min-h-[340px] lg:min-h-[380px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=1920&q=80" 
         alt="{{ $pageTitle }}" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.38]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Pusat Informasi & Warta
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                {{ $pageTitle }}
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                {{ $pageSubtitle }}
            </p>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Tab Media & Berita -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <a href="{{ route('media.news') }}" 
               class="whitespace-nowrap transition {{ $activeCategory === 'berita' ? 'text-bdl-primary font-bold border-b-2 border-bdl-primary pb-1' : 'hover:text-bdl-primary' }}">
                Berita & Agenda
            </a>
            <a href="{{ route('media.education') }}" 
               class="whitespace-nowrap transition {{ $activeCategory === 'edukasi' ? 'text-bdl-primary font-bold border-b-2 border-bdl-primary pb-1' : 'hover:text-bdl-primary' }}">
                Edukasi & Literasi Keuangan
            </a>
            <a href="{{ route('media.announcements') }}" 
               class="whitespace-nowrap transition {{ $activeCategory === 'pengumuman' ? 'text-bdl-primary font-bold border-b-2 border-bdl-primary pb-1' : 'hover:text-bdl-primary' }}">
                Pengumuman & Lelang Agunan
            </a>
        </div>
    </div>
</nav>

<!-- Konten Utama Daftar Artikel -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-12">

    <!-- Bar Pencarian & Total Artikel -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-6">
        <div>
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Publikasi Terverifikasi</span>
            <div class="text-xs text-slate-500 mt-0.5">Menampilkan seluruh konten yang dipublikasikan secara resmi.</div>
        </div>

        <!-- Form Pencarian -->
        <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-2 max-w-sm w-full">
            <div class="relative w-full">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul artikel..." 
                       class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-lg pl-9 pr-3 py-2.5 focus:outline-none focus:border-bdl-primary">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <button type="submit" class="px-4 py-2.5 rounded-lg text-xs font-bold text-white bg-bdl-primary hover:bg-bdl-navy transition shrink-0">
                Cari
            </button>
            @if(request('q'))
                <a href="{{ url()->current() }}" class="text-xs font-bold text-rose-600 hover:text-rose-700 whitespace-nowrap">Reset</a>
            @endif
        </form>
    </div>

    <!-- Grid Kartu Artikel -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($articles as $article)
            <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md hover:border-bdl-primary transition duration-200 flex flex-col justify-between">
                <div>
                    <!-- Thumbnail Artikel -->
                    <div class="w-full h-48 bg-slate-100 overflow-hidden relative">
                        @if($article->thumbnail_url)
                            <img src="{{ str_starts_with($article->thumbnail_url, 'http') ? $article->thumbnail_url : asset($article->thumbnail_url) }}" 
                                 alt="{{ $article->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-tr from-bdl-navy to-bdl-primary text-white/40">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                        @endif
                        <span class="absolute top-3 left-3 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-bdl-navy/85 backdrop-blur-sm text-white">
                            {{ $article->category->name ?? 'Warta' }}
                        </span>
                    </div>

                    <!-- Judul & Cuplikan Konten -->
                    <div class="p-6 space-y-3">
                        <span class="text-[11px] text-slate-400 font-num block">
                            {{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('d F Y') }}
                        </span>
                        
                        <h3 class="text-base font-bold text-bdl-navy leading-snug hover:text-bdl-primary transition">
                            <a href="{{ route('media.show', $article->slug) }}">
                                {{ $article->title }}
                            </a>
                        </h3>

                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                            {{ strip_tags($article->content) }}
                        </p>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-2 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('media.show', $article->slug) }}" class="text-xs font-bold text-bdl-primary hover:text-bdl-navy transition flex items-center gap-1">
                        <span>Baca Selengkapnya</span>
                        <span class="text-sm font-bold">&rarr;</span>
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-3 text-center py-16 bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
                <svg class="w-12 h-12 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <p class="text-xs text-slate-500">Belum ada publikasi artikel pada kategori ini.</p>
                @if(request('q'))
                    <a href="{{ url()->current() }}" class="text-xs font-bold text-bdl-primary hover:underline">Reset Pencarian</a>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
        <div class="pt-6 flex justify-center">
            {{ $articles->links() }}
        </div>
    @endif

</div>
@endsection