@extends('layouts.app')

@section('title', 'Portal Informasi & Direktori Layanan | Bank Daerah Lamongan')

@section('content')
<!-- Header Banner -->
<section class="relative min-h-[320px] lg:min-h-[360px] flex items-center bg-slate-900 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-bdl-navy via-slate-900 to-black/90"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-32 pb-14 text-white">
        <div class="max-w-2xl space-y-3">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Pusat Tautan & Informasi
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Direktori Portal Resmi
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                Pintu gerbang akses cepat menuju regulator resmi, portal pengaduan perbankan, dokumen publikasi, dan situs rekanan pemerintah.
            </p>
        </div>
    </div>
</section>

<!-- Konten Direktori -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-14 space-y-12">

    @php
        $categoryLabels = [
            'REGULATOR' => [
                'title' => 'Regulator & Otoritas Lembaga Keuangan',
                'desc' => 'Lembaga negara yang mengawasi, mengatur, dan menjamin operasional perbankan.',
                'color' => 'border-[#0066B2]',
            ],
            'PEMDA' => [
                'title' => 'Pemerintah Daerah & Afiliasi Resmi',
                'desc' => 'Situs resmi pemerintah kabupaten dan portal layanan publik daerah.',
                'color' => 'border-amber-500',
            ],
            'LAYANAN_PUBLIK' => [
                'title' => 'Portal Layanan & Pengaduan Konsumen',
                'desc' => 'Kanal aduan resmi, whistleblowing system, dan bantuan nasabah.',
                'color' => 'border-rose-500',
            ],
            'DOKUMEN_PUBLIKASI' => [
                'title' => 'Dokumen Transparansi & Publikasi',
                'desc' => 'Laporan keuangan berkala, tata kelola GCG, suku bunga penjaminan LPS, dan RIPLAY.',
                'color' => 'border-emerald-500',
            ],
            'REKANAN' => [
                'title' => 'Mitra & Jaringan Finansial',
                'desc' => 'Asosiasi industri BPR dan lembaga pendukung operasional keuangan.',
                'color' => 'border-purple-500',
            ],
        ];
    @endphp

    @forelse($categoryLabels as $catKey => $catInfo)
        @if(isset($portals[$catKey]) && $portals[$catKey]->count() > 0)
            <div class="space-y-4">
                <div class="border-l-4 {{ $catInfo['color'] }} pl-4">
                    <h2 class="text-base sm:text-lg font-bold text-bdl-navy">{{ $catInfo['title'] }}</h2>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $catInfo['desc'] }}</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($portals[$catKey] as $item)
                        <a href="{{ $item->url }}" 
                           {{ $item->is_external ? 'target="_blank" rel="noopener noreferrer"' : '' }}
                           class="group bg-white p-5 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md hover:border-[#0066B2] transition flex flex-col justify-between space-y-3">
                            <div class="space-y-1.5">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-bold text-slate-800 text-xs sm:text-sm group-hover:text-[#0066B2] transition">
                                        {{ $item->title }}
                                    </h3>
                                    @if($item->is_external)
                                        <span class="text-slate-400 group-hover:text-[#0066B2] transition text-xs shrink-0">&nearr;</span>
                                    @endif
                                </div>
                                @if($item->description)
                                    <p class="text-[11px] text-slate-500 leading-relaxed line-clamp-2">
                                        {{ $item->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-[10px]">
                                <span class="font-mono text-slate-400 truncate max-w-[190px]">
                                    {{ parse_url($item->url, PHP_URL_HOST) ?? $item->url }}
                                </span>
                                @if($item->badge_text)
                                    <span class="px-2 py-0.5 rounded-full bg-blue-50 text-[#0066B2] font-semibold border border-blue-200/60">
                                        {{ $item->badge_text }}
                                    </span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    @empty
        <div class="text-center py-16 bg-white rounded-3xl border border-slate-200">
            <p class="text-slate-400 text-xs">Belum ada tautan portal yang terdaftar.</p>
        </div>
    @endforelse

</div>
@endsection