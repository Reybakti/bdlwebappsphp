@extends('layouts.app')

@section('title', 'Manajemen & Tata Kelola | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section -->
<section class="relative min-h-[340px] lg:min-h-[380px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1920&q=80" 
         alt="Tata Kelola Manajemen Bank Daerah Lamongan" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.40]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Tata Kelola Perusahaan (GCG)
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Dewan Komisaris & Direksi
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                Kepemimpinan yang berintegritas, berdedikasi tinggi, dan berpengalaman dalam mengawal pertumbuhan perbankan yang sehat serta berkelanjutan.
            </p>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Tab Cepat -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <a href="{{ route('about.profile') }}" class="hover:text-bdl-primary transition whitespace-nowrap">&larr; Profil & Sejarah</a>
            <a href="#dewan-komisaris" class="hover:text-bdl-primary transition whitespace-nowrap">Dewan Komisaris</a>
            <a href="#direksi" class="hover:text-bdl-primary transition whitespace-nowrap">Direksi</a>
            <a href="{{ route('transparency.reports') }}?type=GCG" class="text-bdl-primary hover:text-bdl-navy transition whitespace-nowrap font-bold">Laporan GCG Tahunan &rarr;</a>
        </div>
    </div>
</nav>

<!-- Konten Utama Manajemen -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-20">

    <!-- 1. DEWAN KOMISARIS -->
    <section id="dewan-komisaris" class="scroll-mt-36 space-y-8">
        <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Fungsi Pengawasan</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy mt-1">Dewan Komisaris</h2>
            </div>
            <p class="text-xs text-slate-500 max-w-xs">
                Mengawasi kebijakan operasional serta memastikan kepatuhan perbankan terhadap regulasi OJK dan LPS.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($commissioners as $member)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                    <div>
                        <!-- Foto Profil -->
                        <div class="w-full h-72 bg-slate-100 overflow-hidden relative">
                            @if($member->photo_url)
                                <img src="{{ str_starts_with($member->photo_url, 'http') ? $member->photo_url : asset($member->photo_url) }}" 
                                     alt="{{ $member->name }}" 
                                     class="w-full h-full object-cover object-top filter contrast-[1.02]">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-tr from-bdl-navy via-bdl-primary to-slate-800 text-white font-extrabold text-4xl">
                                    {{ substr($member->name, 0, 2) }}
                                </div>
                            @endif
                            <div class="absolute bottom-3 left-3 bg-bdl-navy/90 backdrop-blur-sm text-white px-3 py-1 rounded-md text-[11px] font-semibold">
                                Dewan Komisaris
                            </div>
                        </div>

                        <!-- Keterangan Eksekutif -->
                        <div class="p-6 space-y-3">
                            <div>
                                <h3 class="text-base sm:text-lg font-bold text-bdl-navy leading-snug">
                                    {{ $member->name }}
                                </h3>
                                <span class="text-xs font-semibold text-bdl-primary block mt-0.5">
                                    {{ $member->position }}
                                </span>
                            </div>

                            @if($member->bio)
                                <p class="text-xs text-slate-600 leading-relaxed pt-2 border-t border-slate-100">
                                    {{ $member->bio }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="px-6 pb-6 pt-2">
                        <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded">
                            Lolos Fit & Proper Test OJK
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-10 bg-slate-50 rounded-2xl border border-slate-200 text-xs text-slate-400">
                    Data Dewan Komisaris belum dikonfigurasi di basis data.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 2. DIREKSI -->
    <section id="direksi" class="scroll-mt-36 space-y-8">
        <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Fungsi Eksekutif</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy mt-1">Direksi</h2>
            </div>
            <p class="text-xs text-slate-500 max-w-xs">
                Memimpin operasional harian, pengelolaan likuiditas, manajemen risiko, serta penyaluran pembiayaan UMKM.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($directors as $member)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                    <div>
                        <!-- Foto Profil -->
                        <div class="w-full h-72 bg-slate-100 overflow-hidden relative">
                            @if($member->photo_url)
                                <img src="{{ str_starts_with($member->photo_url, 'http') ? $member->photo_url : asset($member->photo_url) }}" 
                                     alt="{{ $member->name }}" 
                                     class="w-full h-full object-cover object-top filter contrast-[1.02]">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-tr from-bdl-primary via-bdl-navy to-slate-900 text-white font-extrabold text-4xl">
                                    {{ substr($member->name, 0, 2) }}
                                </div>
                            @endif
                            <div class="absolute bottom-3 left-3 bg-bdl-primary/95 backdrop-blur-sm text-white px-3 py-1 rounded-md text-[11px] font-semibold">
                                Direksi
                            </div>
                        </div>

                        <!-- Keterangan Eksekutif -->
                        <div class="p-6 space-y-3">
                            <div>
                                <h3 class="text-base sm:text-lg font-bold text-bdl-navy leading-snug">
                                    {{ $member->name }}
                                </h3>
                                <span class="text-xs font-semibold text-bdl-primary block mt-0.5">
                                    {{ $member->position }}
                                </span>
                            </div>

                            @if($member->bio)
                                <p class="text-xs text-slate-600 leading-relaxed pt-2 border-t border-slate-100">
                                    {{ $member->bio }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="px-6 pb-6 pt-2">
                        <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded">
                            Lolos Fit & Proper Test OJK
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-10 bg-slate-50 rounded-2xl border border-slate-200 text-xs text-slate-400">
                    Data Direksi belum dikonfigurasi di basis data.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 3. Kepatuhan Tata Kelola (GCG) -->
    <section class="p-8 rounded-3xl bg-slate-50 border border-slate-200 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-2">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Transparansi Kepatuhan</span>
            <h3 class="text-xl font-bold text-bdl-navy">Laporan Penerapan Tata Kelola (GCG)</h3>
            <p class="text-xs text-slate-600 max-w-xl leading-relaxed">
                Informasi mendalam mengenai struktur remunerasi, independensi dewan komisaris, dan penilaian komite audit tersedia dalam laporan tahunan resmi.
            </p>
        </div>
        <a href="{{ route('transparency.reports') }}?type=GCG" class="px-6 py-3 rounded-lg text-xs font-bold text-white bg-bdl-primary hover:bg-bdl-navy transition shadow-sm shrink-0 whitespace-nowrap">
            Unduh Laporan GCG &rarr;
        </a>
    </section>

</div>
@endsection