@extends('layouts.app')

@section('title', 'Laporan Tata Kelola (GCG) | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section -->
<section class="relative min-h-[360px] lg:min-h-[420px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1920&q=80" 
         alt="Laporan Tata Kelola GCG Bank Daerah Lamongan" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.40]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Good Corporate Governance
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Laporan Tata Kelola (GCG)
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                Pertanggungjawaban tahunan pelaksanaan prinsip keterbukaan, akuntabilitas, tanggung jawab, independensi, dan kewajaran dalam pengelolaan bank.
            </p>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Tab -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <a href="{{ route('transparency.financial') }}" class="hover:text-bdl-primary transition whitespace-nowrap">&larr; Laporan Keuangan Publikasi</a>
            <span class="text-bdl-primary font-bold border-b-2 border-bdl-primary pb-1 whitespace-nowrap">Laporan Tata Kelola (GCG)</span>
        </div>
    </div>
</nav>

<!-- Konten Arsip Laporan GCG -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-16">

    <!-- 5 Pilar GCG -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-2">
            <span class="w-8 h-8 rounded-lg bg-sky-50 text-bdl-primary font-bold flex items-center justify-center text-xs">01</span>
            <h4 class="font-bold text-xs text-bdl-navy">Transparansi</h4>
            <p class="text-[11px] text-slate-500 leading-relaxed">Keterbukaan informasi materiil dan relevan secara tepat waktu.</p>
        </div>
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-2">
            <span class="w-8 h-8 rounded-lg bg-sky-50 text-bdl-primary font-bold flex items-center justify-center text-xs">02</span>
            <h4 class="font-bold text-xs text-bdl-navy">Akuntabilitas</h4>
            <p class="text-[11px] text-slate-500 leading-relaxed">Kejelasan fungsi dan tanggung jawab organ kepengurusan bank.</p>
        </div>
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-2">
            <span class="w-8 h-8 rounded-lg bg-sky-50 text-bdl-primary font-bold flex items-center justify-center text-xs">03</span>
            <h4 class="font-bold text-xs text-bdl-navy">Responsibilitas</h4>
            <p class="text-[11px] text-slate-500 leading-relaxed">Kesesuaian pengelolaan bank dengan peraturan dan etika bisnis.</p>
        </div>
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-2">
            <span class="w-8 h-8 rounded-lg bg-sky-50 text-bdl-primary font-bold flex items-center justify-center text-xs">04</span>
            <h4 class="font-bold text-xs text-bdl-navy">Independensi</h4>
            <p class="text-[11px] text-slate-500 leading-relaxed">Pengelolaan mandiri bebas dari intervensi benturan kepentingan.</p>
        </div>
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-2">
            <span class="w-8 h-8 rounded-lg bg-sky-50 text-bdl-primary font-bold flex items-center justify-center text-xs">05</span>
            <h4 class="font-bold text-xs text-bdl-navy">Kewajaran</h4>
            <p class="text-[11px] text-slate-500 leading-relaxed">Perlakuan adil dan setara bagi seluruh pemangku kepentingan.</p>
        </div>
    </div>

    <!-- Arsip Dokumen GCG -->
    <div class="space-y-8">
        <div class="border-b border-slate-200 pb-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Dokumen Resmi Tahunan</span>
                <h2 class="text-2xl font-extrabold text-bdl-navy mt-1">Publikasi Pelaksanaan Tata Kelola (GCG)</h2>
            </div>

            <!-- Filter Tahun GCG -->
            <form action="{{ route('transparency.gcg') }}" method="GET" class="flex items-center gap-3">
                <select name="year" onchange="this.form.submit()" class="text-xs font-semibold text-slate-700 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-bdl-primary">
                    <option value="">Semua Tahun Buku</option>
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            Tahun Buku {{ $year }}
                        </option>
                    @endforeach
                </select>
                @if(request('year'))
                    <a href="{{ route('transparency.gcg') }}" class="text-xs font-bold text-rose-600 hover:text-rose-700">Reset</a>
                @endif
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($reports as $report)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:border-bdl-primary hover:shadow-md transition duration-200">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded bg-amber-50 text-amber-800 border border-amber-200">
                                Laporan GCG Tahunan
                            </span>
                            <span class="text-slate-400 font-num font-bold">
                                Tahun Buku {{ $report->year }}
                            </span>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-bdl-navy leading-snug">
                                {{ $report->title }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-2 line-clamp-3 leading-relaxed">
                                Penilaian mandiri (self-assessment), struktur kepengurusan, komite audit, remunerasi, kepemilikan saham, dan kepatuhan anti-fraud.
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
                                <span>Regulasi:</span>
                                <strong class="text-bdl-navy">POJK Tata Kelola BPR</strong>
                            </div>
                        </div>
                    </div>

                    <div class="pt-5 mt-6 border-t border-slate-100 flex items-center justify-between">
                        @if($report->file_url)
                            <a href="{{ str_starts_with($report->file_url, 'http') ? $report->file_url : asset($report->file_url) }}" 
                               target="_blank" 
                               class="inline-flex items-center gap-1.5 text-xs font-bold text-bdl-primary hover:text-bdl-navy transition">
                                <span>Unduh PDF GCG</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </a>
                        @else
                            <span class="text-xs text-slate-400 italic">Belum diunggah</span>
                        @endif
                        <span class="text-[10px] text-slate-400">Arsip Resmi</span>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
                    <p class="text-xs text-slate-500">Tidak ada dokumen laporan GCG pada tahun yang dipilih.</p>
                    <a href="{{ route('transparency.gcg') }}" class="text-xs font-bold text-bdl-primary hover:underline">
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

</div>
@endsection