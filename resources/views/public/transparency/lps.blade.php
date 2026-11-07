@extends('layouts.app')

@section('title', 'Tingkat Bunga Penjaminan LPS | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section -->
<section class="relative min-h-[360px] lg:min-h-[420px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?auto=format&fit=crop&w=1920&q=80" 
         alt="Penjaminan Simpanan LPS Bank Daerah Lamongan" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.38]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Perlindungan Dana Nasabah
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Tingkat Bunga Penjaminan LPS
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                Keterbukaan informasi suku bunga penjaminan Lembaga Penjamin Simpanan (LPS) untuk memastikan seluruh simpanan tabungan dan deposito nasabah terlindungi 100%.
            </p>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Transparansi -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <a href="{{ route('transparency.financial') }}" class="hover:text-bdl-primary transition whitespace-nowrap">Laporan Keuangan</a>
            <a href="{{ route('transparency.gcg') }}" class="hover:text-bdl-primary transition whitespace-nowrap">Laporan Tata Kelola (GCG)</a>
            <span class="text-bdl-primary font-bold border-b-2 border-bdl-primary pb-1 whitespace-nowrap">Tingkat Bunga Penjaminan LPS</span>
            <a href="{{ route('transparency.riplay') }}" class="hover:text-bdl-primary transition whitespace-nowrap">Dokumen RIPLAY &rarr;</a>
        </div>
    </div>
</nav>

<!-- Konten Utama Suku Bunga LPS -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-16">

    <!-- 1. Banner Suku Bunga Aktif Saat Ini -->
    <section class="bg-gradient-to-br from-bdl-navy via-slate-900 to-bdl-primary text-white rounded-3xl p-8 lg:p-12 shadow-lg border border-white/10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            <div class="lg:col-span-7 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="bg-white px-3.5 py-1.5 rounded-xl shadow-sm">
                        <img src="{{ asset('assets/images/logo-lps.png') }}" alt="Logo LPS" class="h-6 w-auto object-contain">
                    </div>
                    <span class="text-xs font-bold text-bdl-soft uppercase tracking-wider">Ketetapan Resmi LPS</span>
                </div>
                
                <h2 class="text-2xl sm:text-3xl font-extrabold leading-tight">
                    Tingkat Bunga Penjaminan (TBP) Periode Berjalan
                </h2>
                
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-xl">
                    Sesuai keputusan Dewan Komisioner LPS, bank senantiasa menetapkan suku bunga simpanan tabungan dan deposito sesuai ketentuan agar memenuhi kriteria penjaminan pemerintah.
                </p>

                <div class="pt-2 text-xs text-slate-400">
                    Masa Berlaku Ketetapan: 
                    <strong class="text-white font-num">
                        {{ $currentRate ? \Carbon\Carbon::parse($currentRate->effective_start_date)->translatedFormat('d F Y') : 'Saat Ini' }}
                    </strong> 
                    s/d 
                    <strong class="text-white font-num">
                        {{ $currentRate ? \Carbon\Carbon::parse($currentRate->effective_end_date)->translatedFormat('d F Y') : 'Sekarang' }}
                    </strong>
                </div>
            </div>

            <!-- Card Metrik Bunga -->
            <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-6 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/15 text-center space-y-1">
                    <span class="text-[11px] text-bdl-soft font-semibold block uppercase">Simpanan Rupiah BPR</span>
                    <span class="text-4xl font-extrabold font-num text-white block">
                        {{ number_format($currentRate->rate_idr ?? 6.75, 2) }}%
                    </span>
                    <span class="text-[10px] text-slate-300 block">per tahun (p.a.)</span>
                </div>

                <div class="p-6 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/15 text-center space-y-1">
                    <span class="text-[11px] text-bdl-soft font-semibold block uppercase">Maksimal Nilai Dijamin</span>
                    <span class="text-3xl sm:text-4xl font-extrabold font-num text-white block">
                        Rp2 M
                    </span>
                    <span class="text-[10px] text-slate-300 block">per nasabah per bank</span>
                </div>
            </div>

        </div>
    </section>

    <!-- 2. Prinsip 3T Penjaminan LPS -->
    <section class="space-y-6">
        <div class="border-b border-slate-200 pb-4">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Kriteria Kelayakan Penjaminan</span>
            <h3 class="text-2xl font-extrabold text-bdl-navy mt-1">Prinsip 3T Agar Simpanan Anda Dijamin LPS</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 font-bold flex items-center justify-center text-sm">
                    1T
                </div>
                <h4 class="font-bold text-sm text-bdl-navy">Tercatat dalam Pembukuan Bank</h4>
                <p class="text-slate-600 leading-relaxed">
                    Data saldo dan transaksi simpanan nasabah tercatat secara sah dan benar dalam sistem pembukuan administrasi resmi perbankan.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-bdl-primary font-bold flex items-center justify-center text-sm">
                    2T
                </div>
                <h4 class="font-bold text-sm text-bdl-navy">Tingkat Bunga Sesuai Ketentuan</h4>
                <p class="text-slate-600 leading-relaxed">
                    Suku bunga simpanan tabungan atau deposito yang diperoleh nasabah tidak melebihi Tingkat Bunga Penjaminan (TBP) LPS yang berlaku.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 font-bold flex items-center justify-center text-sm">
                    3T
                </div>
                <h4 class="font-bold text-sm text-bdl-navy">Tidak Melakukan Tindakan Merugikan Bank</h4>
                <p class="text-slate-600 leading-relaxed">
                    Nasabah penyimpan tidak memiliki kredit macet di bank bersangkutan atau tidak terlibat perbuatan melawan hukum yang merugikan kelangsungan bank.
                </p>
            </div>
        </div>
    </section>

    <!-- 3. Tabel Riwayat Perubahan Suku Bunga LPS Dinamis -->
    <section class="space-y-6">
        <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Arsip Kebijakan</span>
                <h3 class="text-xl font-bold text-bdl-navy mt-1">Riwayat Tingkat Bunga Penjaminan LPS</h3>
            </div>
            <p class="text-xs text-slate-500">Mencatat penyesuaian suku bunga makroekonomi secara historis.</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3.5">Periode Efektif</th>
                            <th class="px-6 py-3.5">Mata Uang</th>
                            <th class="px-6 py-3.5">Suku Bunga Simpanan BPR</th>
                            <th class="px-6 py-3.5">Status Kebijakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        @forelse($rateHistories as $rate)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-4 font-num font-medium text-slate-900">
                                    {{ \Carbon\Carbon::parse($rate->effective_start_date)->translatedFormat('d M Y') }} - 
                                    {{ \Carbon\Carbon::parse($rate->effective_end_date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-700">Rupiah (IDR)</td>
                                <td class="px-6 py-4 font-num font-bold text-bdl-primary text-sm">
                                    {{ number_format($rate->rate_idr, 2) }}% p.a.
                                </td>
                                <td class="px-6 py-4">
                                    @if($rate->is_current)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            Berlaku Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-500">
                                            Arsip Lalu
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                    Data riwayat suku bunga LPS belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($rateHistories->hasPages())
                <div class="p-4 border-t border-slate-100 flex justify-center">
                    {{ $rateHistories->links() }}
                </div>
            @endif
        </div>
    </section>

</div>
@endsection