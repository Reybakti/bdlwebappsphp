@extends('layouts.app')

@section('title', $article->title . ' | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Header Banner Minimalis -->
<section class="bg-bdl-navy text-white pt-36 pb-12">
    <div class="max-w-4xl mx-auto px-4 lg:px-8 space-y-4">
        <div class="flex items-center gap-3 text-xs">
            <a href="{{ route('home') }}" class="text-slate-300 hover:text-white transition">Beranda</a>
            <span class="text-white/40">/</span>
            <span class="text-bdl-soft font-bold uppercase tracking-wider">{{ $article->category->name ?? 'Warta' }}</span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight leading-tight">
            {{ $article->title }}
        </h1>
        <div class="flex items-center gap-4 text-xs text-slate-300 pt-1">
            <span class="font-num">{{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('l, d F Y') }}</span>
            <span>•</span>
            <span>Dipublikasikan oleh Humas BDL</span>
        </div>
    </div>
</section>

<!-- Konten Utama Artikel & Sidebar -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        
        <!-- Kolom Badan Artikel -->
        <article class="lg:col-span-8 space-y-8">
            @if($article->thumbnail_url)
                <div class="rounded-3xl overflow-hidden shadow border border-slate-200">
                    <img src="{{ str_starts_with($article->thumbnail_url, 'http') ? $article->thumbnail_url : asset($article->thumbnail_url) }}" 
                         alt="{{ $article->title }}" 
                         class="w-full max-h-[460px] object-cover">
                </div>
            @endif

            <!-- Isi Teks Artikel -->
            <div class="prose max-w-none text-slate-700 text-sm leading-relaxed space-y-4">
                {!! nl2br(e($article->content)) !!}
            </div>

            <!-- Tombol Kembali & Bagikan -->
            <div class="pt-8 border-t border-slate-200 flex flex-wrap items-center justify-between gap-4 text-xs">
                <a href="javascript:history.back()" class="font-bold text-bdl-primary hover:text-bdl-navy transition flex items-center gap-1.5">
                    <span>&larr;</span>
                    <span>Kembali ke Daftar Berita</span>
                </a>
                <div class="text-slate-400">
                    Kategori: <strong class="text-slate-700">{{ $article->category->name ?? 'Warta' }}</strong>
                </div>
            </div>
        </article>

        <!-- Sidebar Berita Terkait -->
        <aside class="lg:col-span-4 space-y-6">
            <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 space-y-5">
                <h3 class="text-sm font-bold text-bdl-navy uppercase tracking-wider border-b border-slate-200 pb-2">
                    Artikel Terkait Lainnya
                </h3>

                <div class="space-y-4">
                    @forelse($relatedArticles as $related)
                        <div class="space-y-1">
                            <span class="text-[10px] text-slate-400 font-num">
                                {{ \Carbon\Carbon::parse($related->published_at)->translatedFormat('d M Y') }}
                            </span>
                            <h4 class="text-xs font-bold text-bdl-navy leading-snug hover:text-bdl-primary transition">
                                <a href="{{ route('media.show', $related->slug) }}">
                                    {{ $related->title }}
                                </a>
                            </h4>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic">Belum ada artikel terkait lainnya.</p>
                    @endforelse
                </div>
            </div>

            <!-- Box Bantuan Pengaduan Singkat -->
            <div class="bg-bdl-navy text-white rounded-2xl p-6 space-y-3">
                <h4 class="font-bold text-sm">Pusat Layanan Konsumen</h4>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Menemukan kendala operasional atau memiliki pertanyaan terkait perbankan? Sampaikan melalui kanal resmi kami.
                </p>
                <a href="{{ route('services.complaint') }}" class="inline-block px-4 py-2 bg-white text-bdl-navy text-xs font-bold rounded-lg hover:bg-bdl-soft transition">
                    Pengaduan Nasabah &rarr;
                </a>
            </div>
        </aside>

    </div>
</div>
@endsection