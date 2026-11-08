@extends('layouts.app')

@section('title', 'Profil & Sejarah | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section -->
<section class="relative min-h-[360px] lg:min-h-[420px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80" 
         alt="Gedung Kantor {{ $profile->name ?? 'Bank Daerah Lamongan' }}" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.45]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Profil Perusahaan
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                {{ $profile->name ?? 'PT BPR Bank Daerah Lamongan (Perseroda)' }}
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                {{ $profile->description ?? 'Lembaga perbankan daerah terpercaya yang melayani kebutuhan finansial masyarakat secara profesional, sehat, dan berintegritas.' }}
            </p>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Tab Cepat -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <a href="#sejarah" class="hover:text-bdl-primary transition whitespace-nowrap">Sejarah & Pendirian</a>
            @if(($profile->video_source_type === 'URL' && !empty($profile->video_url)) || ($profile->video_source_type === 'UPLOAD' && !empty($profile->video_file_path)))
                <a href="#video-profil" class="hover:text-bdl-primary transition whitespace-nowrap text-bdl-primary font-bold">Video Profil</a>
            @endif
            <a href="#visi-misi" class="hover:text-bdl-primary transition whitespace-nowrap">Visi & Misi</a>
            <a href="#legalitas" class="hover:text-bdl-primary transition whitespace-nowrap">Legalitas & Kepatuhan</a>
            <a href="{{ route('about.management') }}" class="text-bdl-primary hover:text-bdl-navy transition whitespace-nowrap font-bold">Struktur Manajemen &rarr;</a>
        </div>
    </div>
</nav>

<!-- Konten Utama Profil Murni Database -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-20">

    <!-- 1. Sejarah & Ringkasan Perjalanan -->
    <section id="sejarah" class="scroll-mt-36">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            <div class="lg:col-span-7 space-y-5">
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Rekam Jejak & Dedikasi</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy leading-tight">
                    Sejarah Singkat Lembaga
                </h2>
                
                <div class="text-slate-600 leading-relaxed space-y-4 text-xs sm:text-sm">
                    @if($profile && !empty($profile->history))
                        {!! nl2br(e($profile->history)) !!}
                    @else
                        <p class="italic text-slate-400">Data narasi sejarah lembaga belum diisi di basis data.</p>
                    @endif
                </div>

                <!-- Statistik Data Dinamis -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-4">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-2xl sm:text-3xl font-extrabold font-num text-bdl-primary block">
                            {{ $totalBranchesCount ?? 33 }}
                        </span>
                        <span class="text-[11px] text-slate-500 font-medium">Kantor Layanan Aktif</span>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-2xl sm:text-3xl font-extrabold font-num text-bdl-navy block">
                            {{ $directorsCount ?? 2 }}
                        </span>
                        <span class="text-[11px] text-slate-500 font-medium">Anggota Direksi</span>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 col-span-2 sm:col-span-1">
                        <span class="text-2xl sm:text-3xl font-extrabold font-num text-emerald-600 block">
                            {{ $commissionersCount ?? 2 }}
                        </span>
                        <span class="text-[11px] text-slate-500 font-medium">Dewan Komisaris</span>
                    </div>
                </div>
            </div>

            <!-- Card Informasi Entitas Dinamis -->
            <div class="lg:col-span-5 space-y-4">
                <div class="rounded-3xl overflow-hidden border border-slate-200 shadow-md bg-white p-6 space-y-4">
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                        <img src="{{ asset('assets/images/logo-bdl.png') }}" 
                             alt="Logo {{ $profile->name ?? 'Bank Daerah Lamongan' }}" 
                             class="h-10 w-auto object-contain">
                        <div>
                            <div class="font-bold text-sm text-bdl-navy">{{ $profile->name ?? '-' }}</div>
                            <div class="text-[11px] text-slate-400">Data Entitas Terdaftar</div>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div>
                            <span class="text-slate-400 block text-[11px]">Alamat Kantor Pusat:</span>
                            <span class="font-medium text-slate-700 leading-relaxed block">
                                {{ $profile->head_office_address ?? '-' }}
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100">
                            <div>
                                <span class="text-slate-400 block text-[11px]">Telepon:</span>
                                <span class="font-num font-semibold text-bdl-navy">{{ $profile->phone ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px]">Email Resmi:</span>
                                <span class="font-medium text-bdl-navy truncate block">{{ $profile->email ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Section Video Profil Perusahaan (Jika Tersedia) -->
    @php
        $hasVideoUrl = ($profile->video_source_type === 'URL' && !empty($profile->video_url));
        $hasVideoUpload = ($profile->video_source_type === 'UPLOAD' && !empty($profile->video_file_path));
    @endphp

    @if($hasVideoUrl || $hasVideoUpload)
        <section id="video-profil" class="scroll-mt-36 p-6 sm:p-10 rounded-3xl bg-slate-900 text-white space-y-6">
            <div class="max-w-2xl space-y-2">
                <span class="text-xs font-bold text-bdl-soft uppercase tracking-wider block">Tayangan Multimedia</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white">
                    {{ $profile->video_title ?? 'Video Profil Bank Daerah Lamongan' }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-300">
                    Mengenal lebih dekat dedikasi dan kontribusi nyata kami bagi penguatan ekonomi masyarakat di Lamongan.
                </p>
            </div>

            <!-- Kontainer Video Responsif -->
            <div class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-2xl bg-black border border-white/10">
                @if($profile->video_source_type === 'URL')
                    @php
                        $embedUrl = $profile->youtube_embed_url;
                    @endphp
                    <iframe src="{{ $embedUrl }}" 
                            title="{{ $profile->video_title ?? 'Video Profil' }}" 
                            class="w-full h-full"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen></iframe>
                @else
                    <video controls playsinline class="w-full h-full object-contain">
                        <source src="{{ asset('storage/' . $profile->video_file_path) }}" type="video/mp4">
                        Peramban Anda tidak mendukung pemutar video HTML5.
                    </video>
                @endif
            </div>
        </section>
    @endif

    <!-- 3. Visi & Misi Lembaga -->
    <section id="visi-misi" class="scroll-mt-36 py-12 bg-slate-50 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 border-y border-slate-200">
        <div class="max-w-7xl mx-auto space-y-10">
            <div class="text-center max-w-xl mx-auto space-y-2">
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider">Arah Strategis</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy">Visi & Misi Perusahaan</h2>
                <p class="text-xs text-slate-500">Nilai landasan yang tercantum dalam rencana strategis perusahaan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-stretch">
                <!-- Visi dari Database -->
                <div class="md:col-span-5 bg-bdl-navy text-white rounded-2xl p-8 flex flex-col justify-between shadow-sm space-y-6">
                    <div class="space-y-4">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-bdl-soft font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold tracking-tight">Visi Lembaga</h3>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed italic">
                            @if($profile && !empty($profile->vision))
                                "{{ $profile->vision }}"
                            @else
                                <span class="text-slate-400 not-italic">Data visi belum diisi di basis data.</span>
                            @endif
                        </p>
                    </div>
                    <span class="text-[10px] text-bdl-soft font-semibold tracking-wider uppercase block border-t border-white/10 pt-4">
                        Arah Strategis Lembaga
                    </span>
                </div>

                <!-- Misi dari Database -->
                <div class="md:col-span-7 bg-white rounded-2xl p-8 border border-slate-200 shadow-sm space-y-4">
                    <div class="w-10 h-10 rounded-xl bg-[#D6E4F0]/60 flex items-center justify-center text-bdl-primary font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-bdl-navy tracking-tight">Misi Lembaga</h3>
                    
                    <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-3">
                        @if($profile && !empty($profile->mission))
                            {!! nl2br(e($profile->mission)) !!}
                        @else
                            <p class="italic text-slate-400">Data misi belum diisi di basis data.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Legalitas & Pernyataan Kepatuhan OJK/LPS -->
    <section id="legalitas" class="scroll-mt-36 p-8 rounded-3xl bg-slate-50 border border-slate-200 space-y-6">
        <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Kepatuhan Regulasi</span>
                <h3 class="text-xl font-bold text-bdl-navy mt-0.5">Pernyataan Legalitas & Penjaminan</h3>
            </div>
            <div class="flex items-center gap-3 bg-white px-3.5 py-1.5 rounded-lg border border-slate-200 shadow-sm shrink-0">
                <img src="{{ asset('assets/images/logo-ojk.png') }}" alt="Otoritas Jasa Keuangan" class="h-6 w-auto object-contain">
                <span class="text-slate-300 font-bold">|</span>
                <img src="{{ asset('assets/images/logo-lps.png') }}" alt="Lembaga Penjamin Simpanan" class="h-6 w-auto object-contain">
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-slate-200 text-xs sm:text-sm text-slate-700 leading-relaxed">
            @if($profile && !empty($profile->ojk_lps_statement))
                {{ $profile->ojk_lps_statement }}
            @else
                {{ $profile->name ?? 'PT BPR Bank Daerah Lamongan (Perseroda)' }} berizin dan diawasi oleh Otoritas Jasa Keuangan (OJK) serta merupakan peserta penjaminan Lembaga Penjamin Simpanan (LPS).
            @endif
        </div>
    </section>

</div>
@endsection