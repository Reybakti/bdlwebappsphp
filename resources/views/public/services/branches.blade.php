@extends('layouts.app')

@section('title', 'Jaringan Kantor & Titik Layanan | ' . ($profile->name ?? 'PT BPR Bank Daerah Lamongan (Perseroda)'))

@section('content')
<!-- Hero Header Section -->
<section class="relative min-h-[360px] lg:min-h-[420px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80" 
         alt="Jaringan Kantor Bank Daerah Lamongan" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.38]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Jangkauan Wilayah Layanan
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Jaringan Kantor Pelayanan
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                Temukan lokasi Kantor Pusat, Kantor Cabang, dan Kantor Kas kami yang tersebar di seluruh kecamatan Kabupaten Lamongan untuk kemudahan transaksi perbankan Anda.
            </p>
        </div>
    </div>
</section>

<!-- Solid Blue Metric Bar Titik Layanan -->
<section class="bg-bdl-primary text-white border-y border-white/10">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-white/20">
            <div class="py-5 px-4 text-center space-y-1">
                <span class="text-2xl sm:text-3xl font-extrabold font-num block">{{ $totalBranches }}</span>
                <span class="text-xs text-bdl-soft font-semibold">Total Kantor Layanan</span>
            </div>
            <div class="py-5 px-4 text-center space-y-1">
                <span class="text-2xl sm:text-3xl font-extrabold font-num block">1</span>
                <span class="text-xs text-bdl-soft font-semibold">Kantor Pusat Operasional</span>
            </div>
            <div class="py-5 px-4 text-center space-y-1">
                <span class="text-2xl sm:text-3xl font-extrabold font-num block">{{ $branchCount }}</span>
                <span class="text-xs text-bdl-soft font-semibold">Kantor Cabang</span>
            </div>
            <div class="py-5 px-4 text-center space-y-1">
                <span class="text-2xl sm:text-3xl font-extrabold font-num block">{{ $cashOfficeCount }}</span>
                <span class="text-xs text-bdl-soft font-semibold">Kantor Kas Pembantu</span>
            </div>
        </div>
    </div>
</section>

<!-- Konten Utama Direktori Kantor -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-12">

    <!-- Filter & Bar Pencarian -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 border-b border-slate-200 pb-6">
        <!-- Filter Kategori Tipe Kantor -->
        <div class="flex items-center gap-2 overflow-x-auto text-xs font-semibold p-1 bg-slate-100 rounded-xl scrollbar-none">
            <a href="{{ route('services.branches') }}" 
               class="px-4 py-2 rounded-lg transition {{ !request('type') ? 'bg-white text-bdl-navy shadow-sm' : 'text-slate-600 hover:text-bdl-navy' }}">
                Semua Kantor ({{ $totalBranches }})
            </a>
            <a href="{{ route('services.branches') }}?type=HEAD_OFFICE" 
               class="px-4 py-2 rounded-lg transition {{ request('type') === 'HEAD_OFFICE' ? 'bg-white text-bdl-navy shadow-sm' : 'text-slate-600 hover:text-bdl-navy' }}">
                Kantor Pusat
            </a>
            <a href="{{ route('services.branches') }}?type=BRANCH" 
               class="px-4 py-2 rounded-lg transition {{ request('type') === 'BRANCH' ? 'bg-white text-bdl-navy shadow-sm' : 'text-slate-600 hover:text-bdl-navy' }}">
                Kantor Cabang
            </a>
            <a href="{{ route('services.branches') }}?type=CASH_OFFICE" 
               class="px-4 py-2 rounded-lg transition {{ request('type') === 'CASH_OFFICE' ? 'bg-white text-bdl-navy shadow-sm' : 'text-slate-600 hover:text-bdl-navy' }}">
                Kantor Kas
            </a>
        </div>

        <!-- Form Pencarian Lokasi/Nama -->
        <form action="{{ route('services.branches') }}" method="GET" class="flex items-center gap-2 max-w-sm w-full">
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif
            <div class="relative w-full">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kantor, kecamatan, alamat..." 
                       class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-lg pl-9 pr-3 py-2.5 focus:outline-none focus:border-bdl-primary">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <button type="submit" class="px-4 py-2.5 rounded-lg text-xs font-bold text-white bg-bdl-primary hover:bg-bdl-navy transition shrink-0">
                Cari
            </button>
            @if(request('q'))
                <a href="{{ route('services.branches', request()->only('type')) }}" class="text-xs font-bold text-rose-600 hover:text-rose-700 whitespace-nowrap">Reset</a>
            @endif
        </form>
    </div>

    <!-- Grid Kartu Kantor Cabang & Kas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($branches as $branch)
            @php
                $isHead = $branch->type === 'HEAD_OFFICE';
                $isBranch = $branch->type === 'BRANCH';
                $typeLabel = $isHead ? 'Kantor Pusat' : ($isBranch ? 'Kantor Cabang' : 'Kantor Kas');
                $badgeStyle = $isHead 
                    ? 'bg-bdl-navy text-white' 
                    : ($isBranch ? 'bg-[#D6E4F0]/60 text-bdl-navy border border-bdl-primary/20' : 'bg-slate-100 text-slate-700');

                $mapsUrl = $branch->google_maps_url 
                    ?? ($branch->latitude && $branch->longitude 
                        ? 'https://www.google.com/maps/search/?api=1&query=' . $branch->latitude . ',' . $branch->longitude 
                        : 'https://www.google.com/maps/search/?api=1&query=' . urlencode($branch->name . ' Bank Daerah Lamongan ' . $branch->address));
            @endphp
            <div class="bg-white rounded-2xl border {{ $isHead ? 'border-bdl-primary/60 shadow-md ring-1 ring-bdl-primary/10' : 'border-slate-200 shadow-sm' }} p-6 flex flex-col justify-between hover:border-bdl-primary hover:shadow-md transition duration-200 space-y-5">
                
                <div class="space-y-4">
                    <!-- Header Kartu & Tipe Kantor -->
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded {{ $badgeStyle }}">
                            {{ $typeLabel }}
                        </span>
                        @if(!empty($branch->postal_code))
                            <span class="text-[11px] font-mono font-semibold text-slate-400">
                                Pos: {{ $branch->postal_code }}
                            </span>
                        @endif
                    </div>

                    <!-- Nama Kantor -->
                    <div>
                        <h3 class="text-base font-bold text-bdl-navy leading-snug">
                            {{ $branch->name }}
                        </h3>
                        @if($branch->city)
                            <span class="text-[11px] text-slate-400 block mt-0.5">{{ $branch->city }}</span>
                        @endif
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="flex items-start gap-2.5 text-xs text-slate-600 leading-relaxed">
                        <svg class="w-4 h-4 text-bdl-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $branch->address }}</span>
                    </div>

                    <!-- Keterangan Kontak & Jam Layanan -->
                    <div class="p-3.5 bg-slate-50 rounded-xl space-y-2 text-xs text-slate-600 border border-slate-100">
                        @if($branch->phone)
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 text-[11px]">Telepon:</span>
                                <a href="tel:{{ preg_replace('/[^0-9]/', '', $branch->phone) }}" class="font-num font-semibold text-bdl-navy hover:underline">
                                    {{ $branch->phone }}
                                </a>
                            </div>
                        @endif

                        @if($branch->whatsapp)
                            @php
                                $cleanWa = preg_replace('/[^0-9]/', '', $branch->whatsapp);
                                if (str_starts_with($cleanWa, '0')) {
                                    $cleanWa = '62' . substr($cleanWa, 1);
                                }
                            @endphp
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 text-[11px]">WhatsApp:</span>
                                <a href="https://wa.me/{{ $cleanWa }}" target="_blank" rel="noopener noreferrer" class="font-num font-semibold text-emerald-600 hover:underline">
                                    {{ $branch->whatsapp }}
                                </a>
                            </div>
                        @endif

                        @if($branch->email)
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 text-[11px]">Email:</span>
                                <a href="mailto:{{ $branch->email }}" class="font-medium text-[#0066B2] hover:underline truncate max-w-[180px]" title="{{ $branch->email }}">
                                    {{ $branch->email }}
                                </a>
                            </div>
                        @endif

                        <div class="flex items-center justify-between pt-1 border-t border-slate-200/60 text-[11px] text-slate-500">
                            <span>Jam Layanan:</span>
                            <span class="font-medium">{{ $branch->operating_hours ?? 'Senin - Jumat (08.00 - 15.00 WIB)' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Kartu: Navigasi Google Maps & Aksi Kontak -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="inline-flex items-center gap-1.5 text-xs font-bold text-bdl-primary hover:text-bdl-navy transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>Petunjuk Arah</span>
                    </a>

                    @if($branch->whatsapp)
                        @php
                            $cleanWaBtn = preg_replace('/[^0-9]/', '', $branch->whatsapp);
                            if (str_starts_with($cleanWaBtn, '0')) {
                                $cleanWaBtn = '62' . substr($cleanWaBtn, 1);
                            }
                        @endphp
                        <a href="https://wa.me/{{ $cleanWaBtn }}?text={{ urlencode('Halo ' . $branch->name . ', saya ingin konsultasi layanan perbankan.') }}" 
                           target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 text-xs font-bold transition">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            <span>Hubungi WA</span>
                        </a>
                    @elseif($branch->phone)
                        <a href="tel:{{ preg_replace('/[^0-9]/', '', $branch->phone) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-bold transition">
                            <span>Hubungi</span>
                        </a>
                    @endif
                </div>

            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
                <svg class="w-12 h-12 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <p class="text-xs text-slate-500">Tidak ada kantor layanan yang ditemukan sesuai kriteria pencarian.</p>
                <a href="{{ route('services.branches') }}" class="text-xs font-bold text-bdl-primary hover:underline">
                    Tampilkan Seluruh Jaringan Kantor
                </a>
            </div>
        @endforelse
    </div>

    <!-- Informasi Layanan Setor Jemput Bola -->
    <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-1.5">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Layanan Jemput Bola (Pick-up Service)</span>
            <h3 class="text-xl font-bold text-bdl-navy">Jauh dari Kantor Layanan Fisik Kami?</h3>
            <p class="text-xs text-slate-600 max-w-xl leading-relaxed">
                Petugas layanan lapangan kami siap menjangkau toko, kios pasar tradisional, atau tempat tinggal Anda untuk memfasilitasi setoran tabungan harian secara aman dan tercatat resmi.
            </p>
        </div>
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->phone ?? '081234567890') }}" target="_blank" rel="noopener noreferrer" 
           class="px-6 py-3 rounded-lg text-xs font-bold text-white bg-emerald-700 hover:bg-emerald-800 transition shadow shrink-0 whitespace-nowrap flex items-center gap-2">
            <span>Hubungi Petugas Lapangan via WA</span>
            <span>&rarr;</span>
        </a>
    </div>

</div>
@endsection