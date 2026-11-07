@extends('layouts.app')

@section('title', 'Laporan Keuangan Publikasi | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section -->
<section class="relative min-h-[360px] lg:min-h-[420px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1920&q=80" 
         alt="Laporan Keuangan Publikasi Bank Daerah Lamongan" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.40]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Transparansi Finansial
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Laporan Keuangan Publikasi
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                Publikasi neraca, laba rugi, kualitas aktiva produktif, dan rasio keuangan triwulanan serta tahunan yang telah diaudit oleh Kantor Akuntan Publik independen.
            </p>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Tab -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <span class="text-bdl-primary font-bold border-b-2 border-bdl-primary pb-1 whitespace-nowrap">Laporan Keuangan Publikasi</span>
            <a href="{{ route('transparency.gcg') }}" class="hover:text-bdl-primary transition whitespace-nowrap">Laporan Tata Kelola (GCG) &rarr;</a>
        </div>
    </div>
</nav>

<!-- Konten Arsip Laporan Keuangan -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-12">
    <div class="border-b border-slate-200 pb-6 flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div>
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Keterbukaan Informasi Finansial</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy mt-1">Arsip Publikasi Keuangan</h2>
            <p class="text-xs text-slate-500 mt-1 max-w-lg">
                Sesuai dengan Peraturan dan Surat Edaran Otoritas Jasa Keuangan (SEOJK) terkait publikasi berkala BPR.
            </p>
        </div>

        <!-- Filter Form -->
        <form action="{{ route('transparency.financial') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <div class="min-w-[130px]">
                <select name="year" onchange="this.form.submit()" class="w-full text-xs font-semibold text-slate-700 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-bdl-primary">
                    <option value="">Semua Tahun</option>
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            Tahun {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="min-w-[160px]">
                <select name="type" onchange="this.form.submit()" class="w-full text-xs font-semibold text-slate-700 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-bdl-primary">
                    <option value="">Semua Periode</option>
                    <option value="TRIWULAN_I" {{ request('type') == 'TRIWULAN_I' ? 'selected' : '' }}>Triwulan I</option>
                    <option value="TRIWULAN_II" {{ request('type') == 'TRIWULAN_II' ? 'selected' : '' }}>Triwulan II</option>
                    <option value="TRIWULAN_III" {{ request('type') == 'TRIWULAN_III' ? 'selected' : '' }}>Triwulan III</option>
                    <option value="TRIWULAN_IV" {{ request('type') == 'TRIWULAN_IV' ? 'selected' : '' }}>Triwulan IV</option>
                    <option value="AUDITED" {{ request('type') == 'AUDITED' ? 'selected' : '' }}>Tahunan (Audited)</option>
                </select>
            </div>

            @if(request()->hasAny(['year', 'type']))
                <a href="{{ route('transparency.financial') }}" class="text-xs font-bold text-rose-600 hover:text-rose-700 px-2 py-2.5 transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Grid Laporan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($reports as $report)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:border-bdl-primary hover:shadow-md transition duration-200">
                <div class="space-y-4">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded bg-[#D6E4F0]/50 text-bdl-navy">
                            {{ str_replace('_', ' ', $report->type) }}
                        </span>
                        <span class="text-slate-400 font-num">
                            Tahun {{ $report->year }}
                        </span>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-bdl-navy leading-snug">
                            {{ $report->title }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                            Neraca, Laporan Komitmen & Kontinjensi, Laba Rugi, dan Rasio Permodalan (CAR, NPL, LDR, BOPO).
                        </p>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl space-y-1 text-[11px] text-slate-600">
                        <div class="flex justify-between">
                            <span>Tanggal Rilis:</span>
                            <strong class="font-num text-slate-700">
                                {{ $report->published_at ? \Carbon\Carbon::parse($report->published_at)->translatedFormat('d F Y') : '-' }}
                            </strong>
                        </div>
                        <div class="flex justify-between">
                            <span>Format:</span>
                            <strong class="text-bdl-navy uppercase">PDF Resmi</strong>
                        </div>
                    </div>
                </div>

                <div class="pt-5 mt-6 border-t border-slate-100 flex items-center justify-between">
                    @if($report->file_url)
                        <a href="{{ str_starts_with($report->file_url, 'http') ? $report->file_url : asset($report->file_url) }}" 
                           target="_blank" 
                           class="inline-flex items-center gap-1.5 text-xs font-bold text-bdl-primary hover:text-bdl-navy transition">
                            <span>Unduh PDF</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </a>
                    @else
                        <span class="text-xs text-slate-400 italic">Belum diunggah</span>
                    @endif
                    <span class="text-[10px] text-slate-400">Verifikasi SEOJK</span>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
                <p class="text-xs text-slate-500">Tidak ada laporan keuangan publikasi pada filter yang dipilih.</p>
                <a href="{{ route('transparency.financial') }}" class="text-xs font-bold text-bdl-primary hover:underline">
                    Reset Filter
                </a>
            </div>
        @endforelse
    </div>

    @if($reports->hasPages())
        <div class="pt-4 flex justify-center">
            {{ $reports->links() }}
        </div>
    @endif
</div>
@endsection