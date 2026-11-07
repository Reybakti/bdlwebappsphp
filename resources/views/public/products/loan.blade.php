@extends('layouts.app')

@section('title', 'Kredit & Pembiayaan Usaha | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section -->
<section class="relative min-h-[360px] lg:min-h-[420px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1556742049-0a67c5574f73?auto=format&fit=crop&w=1920&q=80" 
         alt="Pembiayaan Usaha Bank Daerah Lamongan" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.45]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Solusi Permodalan UMKM
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Kredit & Pembiayaan Usaha
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                Fasilitas pinjaman modal kerja, investasi, dan kebutuhan multiguna dengan skema bunga transparan serta proses verifikasi cepat.
            </p>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Tab Cepat -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <a href="#katalog-kredit" class="hover:text-bdl-primary transition whitespace-nowrap">Pilihan Produk Kredit</a>
            <a href="#kalkulator-kredit" class="hover:text-bdl-primary transition whitespace-nowrap text-bdl-primary font-bold">Kalkulator Simulasi Angsuran</a>
            <a href="#persyaratan" class="hover:text-bdl-primary transition whitespace-nowrap">Persyaratan & Prosedur</a>
            <a href="{{ route('products.deposit') }}" class="hover:text-bdl-primary transition whitespace-nowrap text-slate-400">Simulasi Deposito &rarr;</a>
        </div>
    </div>
</nav>

<!-- Konten Utama Kredit -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-20">

    <!-- 1. Katalog Produk Kredit Dinamis -->
    <section id="katalog-kredit" class="scroll-mt-36 space-y-8">
        <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Portofolio Pembiayaan</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy mt-1">Fasilitas Pinjaman</h2>
            </div>
            <p class="text-xs text-slate-500 max-w-xs">
                Perhitungan transparan tanpa biaya terselubung sesuai standar RIPLAY OJK.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($loanProducts as $product)
                @php
                    $param = $product->simulationParam;
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:border-bdl-primary hover:shadow-md transition duration-200">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-[#D6E4F0]/50 text-bdl-navy">
                                {{ $product->category->name ?? 'Kredit' }}
                            </span>
                            @if($param)
                                <span class="text-xs font-num font-bold text-bdl-primary">
                                    {{ $param->base_interest_rate_pa }}% p.a. Flat
                                </span>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-bdl-navy">{{ $product->name }}</h3>
                            <p class="text-xs text-slate-600 leading-relaxed mt-1">
                                {{ $product->short_description }}
                            </p>
                        </div>

                        <!-- Parameter Batasan Pinjaman -->
                        @if($param)
                            <div class="p-4 bg-slate-50 rounded-xl space-y-2 text-xs text-slate-600">
                                <div class="flex justify-between">
                                    <span>Plafon Maksimal:</span>
                                    <strong class="font-num text-bdl-navy">Rp{{ number_format($param->max_amount, 0, ',', '.') }}</strong>
                                </div>
                                <div class="flex justify-between">
                                    <span>Maksimal Tenor:</span>
                                    <strong class="font-num text-bdl-navy">{{ $param->max_tenor_months }} Bulan</strong>
                                </div>
                                <div class="flex justify-between">
                                    <span>Biaya Provisi:</span>
                                    <strong class="font-num text-slate-700">{{ $param->provision_fee_pct ?? 1.0 }}%</strong>
                                </div>
                            </div>
                        @endif

                        @if($product->terms_and_conditions)
                            <div class="text-[11px] text-slate-500 leading-relaxed">
                                <span class="font-bold text-bdl-navy block mb-0.5">Ketentuan Agunan:</span>
                                {{ Str::limit($product->terms_and_conditions, 120) }}
                            </div>
                        @endif
                    </div>

                    <div class="pt-5 mt-6 border-t border-slate-100 flex items-center justify-between">
                        <button type="button" 
                                onclick="selectProductForCalc('{{ $product->name }}', {{ $param->base_interest_rate_pa ?? 10.5 }}, {{ $param->min_amount ?? 5000000 }}, {{ $param->max_amount ?? 200000000 }}, {{ $param->provision_fee_pct ?? 1.0 }})"
                                class="text-xs font-bold text-bdl-primary hover:text-bdl-navy transition">
                            Simulasikan Angsuran &darr;
                        </button>
                        
                        @if($product->riplay_file_url)
                            <a href="{{ asset($product->riplay_file_url) }}" target="_blank" class="text-[11px] font-semibold text-slate-500 hover:text-bdl-primary flex items-center gap-1">
                                <span>Unduh RIPLAY</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-10 bg-slate-50 rounded-2xl border border-slate-200 text-xs text-slate-400">
                    Belum ada data produk kredit yang aktif di basis data.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 2. Kalkulator Simulasi Kredit Interaktif -->
    @php
        $calcParam = $primaryLoan?->simulationParam;
        $calcMinAmount = $calcParam?->min_amount ?? 5000000;
        $calcMaxAmount = $calcParam?->max_amount ?? 200000000;
        $calcDefaultAmount = $calcMinAmount > 25000000 ? $calcMinAmount : 25000000;
        $calcRate = $calcParam?->base_interest_rate_pa ?? 10.50;
        $calcProvision = $calcParam?->provision_fee_pct ?? 1.0;
    @endphp

    <section id="kalkulator-kredit" class="scroll-mt-36 p-8 lg:p-12 rounded-3xl bg-slate-50 border border-slate-200 space-y-8">
        <div class="max-w-2xl space-y-2">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Simulasi Mandiri</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy">Kalkulator Perhitungan Angsuran</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Menghitung estimasi pokok, bunga bulanan, serta perkiraan biaya administrasi/provisi awal.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <!-- Form Input Simulasi -->
            <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <span id="calcProductName" class="text-xs font-bold text-bdl-navy">
                        {{ $primaryLoan->name ?? 'Kredit Modal Kerja UMKM' }}
                    </span>
                    <span id="calcRateBadge" class="text-xs font-num font-bold text-bdl-primary bg-[#D6E4F0]/40 px-2.5 py-1 rounded">
                        {{ number_format($calcRate, 2) }}% Flat p.a.
                    </span>
                </div>

                <!-- Input Nominal Plafon -->
                <div class="space-y-2">
                    <div class="flex justify-between text-xs font-bold text-slate-700">
                        <span>Plafon Pinjaman:</span>
                        <span id="loanAmountDisplay" class="text-bdl-primary font-num text-base font-bold">
                            Rp{{ number_format($calcDefaultAmount, 0, ',', '.') }}
                        </span>
                    </div>
                    <input type="range" id="loanRange" 
                           min="{{ $calcMinAmount }}" 
                           max="{{ $calcMaxAmount }}" 
                           step="5000000" 
                           value="{{ $calcDefaultAmount }}"
                           class="w-full accent-bdl-primary h-2 bg-slate-200 rounded-lg cursor-pointer" 
                           oninput="recalculateLoan()">
                    <div class="flex justify-between text-[10px] text-slate-400 font-num">
                        <span>Rp{{ number_format($calcMinAmount, 0, ',', '.') }}</span>
                        <span>Rp{{ number_format($calcMaxAmount / 2, 0, ',', '.') }}</span>
                        <span>Rp{{ number_format($calcMaxAmount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Pilihan Tenor -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700">Jangka Waktu Pinjaman (Tenor):</label>
                    <div class="grid grid-cols-4 gap-2">
                        <button type="button" onclick="setLoanTenor(6, this)" class="loan-tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num">6 Bulan</button>
                        <button type="button" onclick="setLoanTenor(12, this)" class="loan-tenor-btn py-2 text-xs font-semibold rounded-lg border border-bdl-primary bg-bdl-navy text-white transition shadow-sm font-num">12 Bulan</button>
                        <button type="button" onclick="setLoanTenor(24, this)" class="loan-tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num">24 Bulan</button>
                        <button type="button" onclick="setLoanTenor(36, this)" class="loan-tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num">36 Bulan</button>
                    </div>
                </div>
            </div>

            <!-- Panel Rincian Output Simulasi -->
            <div class="lg:col-span-5 bg-bdl-navy text-white rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
                <div>
                    <span class="text-[11px] font-semibold text-bdl-soft uppercase tracking-wider block">Estimasi Total Angsuran</span>
                    <div id="monthlyTotalDisplay" class="text-3xl sm:text-4xl font-extrabold font-num text-white mt-1">
                        Rp0
                    </div>
                    <span class="text-[10px] text-slate-400 block mt-0.5">per bulan</span>
                </div>

                <div class="space-y-3 pt-4 border-t border-white/10 text-xs">
                    <div class="flex justify-between text-slate-300">
                        <span>Angsuran Pokok:</span>
                        <strong id="principalDisplay" class="font-num text-white">Rp0</strong>
                    </div>
                    <div class="flex justify-between text-slate-300">
                        <span>Angsuran Bunga:</span>
                        <strong id="interestDisplay" class="font-num text-white">Rp0</strong>
                    </div>
                    <div class="flex justify-between text-slate-300">
                        <span>Estimasi Biaya Provisi (<span id="provisionPctDisplay">{{ $calcProvision }}</span>%):</span>
                        <strong id="provisionFeeDisplay" class="font-num text-bdl-soft">Rp0</strong>
                    </div>
                </div>

                <div class="p-3 bg-white/5 rounded-xl border border-white/10 text-[11px] text-slate-300 leading-relaxed">
                    *Hasil simulasi merupakan estimasi matematis. Nilai definitif, biaya administrasi, dan asuransi ditentukan pada saat akad kredit di kantor cabang.
                </div>

                <a href="{{ route('services.branches') }}" class="block text-center text-xs font-bold text-bdl-navy bg-white hover:bg-bdl-soft py-3 rounded-lg transition shadow">
                    Kunjungi Kantor Cabang Terdekat &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- 3. Persyaratan Umum & Alur Pengajuan -->
    <section id="persyaratan" class="scroll-mt-36 space-y-8">
        <div class="border-b border-slate-200 pb-4">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Panduan Nasabah</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy mt-1">Persyaratan Dokumen & Prosedur</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
            <!-- Box 1 -->
            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="w-9 h-9 rounded-xl bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">1</div>
                <h4 class="font-bold text-sm text-bdl-navy">Dokumen Identitas</h4>
                <ul class="space-y-1.5 text-slate-600 list-disc list-inside leading-relaxed">
                    <li>Fotokopi e-KTP Pemohon & Pasangan</li>
                    <li>Fotokopi Kartu Keluarga (KK)</li>
                    <li>Fotokopi Surat Nikah / Akta Cerai</li>
                    <li>Fotokopi NPWP (plafon > Rp50 Juta)</li>
                </ul>
            </div>

            <!-- Box 2 -->
            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="w-9 h-9 rounded-xl bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">2</div>
                <h4 class="font-bold text-sm text-bdl-navy">Bukti Usaha / Penghasilan</h4>
                <ul class="space-y-1.5 text-slate-600 list-disc list-inside leading-relaxed">
                    <li>Surat Keterangan Usaha (SKU) dari Desa/Kelurahan</li>
                    <li>Catatan pembukuan / nota penjualan sederhana</li>
                    <li>Slip gaji asli & SK (khusus kredit konsumtif)</li>
                    <li>Rekening koran tabungan 3 bulan terakhir</li>
                </ul>
            </div>

            <!-- Box 3 -->
            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="w-9 h-9 rounded-xl bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">3</div>
                <h4 class="font-bold text-sm text-bdl-navy">Legalitas Agunan</h4>
                <ul class="space-y-1.5 text-slate-600 list-disc list-inside leading-relaxed">
                    <li>Sertifikat Hak Milik (SHM) / SHGB</li>
                    <li>Bukti Pembayaran PBB tahun terakhir</li>
                    <li>BPKB Kendaraan bermotor beserta STNK aktif</li>
                    <li>Bilyet Deposito (khusus kredit agunan deposito)</li>
                </ul>
            </div>
        </div>
    </section>

</div>
@endsection

@section('scripts')
<script>
let activeLoanRate = parseFloat("{{ $calcRate }}");
let activeProvisionPct = parseFloat("{{ $calcProvision }}");
let selectedTenor = 12;

function selectProductForCalc(name, rate, min, max, prov) {
    document.getElementById('calcProductName').innerText = name;
    document.getElementById('calcRateBadge').innerText = rate.toFixed(2) + '% Flat p.a.';
    document.getElementById('provisionPctDisplay').innerText = prov;
    
    activeLoanRate = rate;
    activeProvisionPct = prov;

    const range = document.getElementById('loanRange');
    range.min = min;
    range.max = max;
    if (parseFloat(range.value) > max) range.value = max;
    if (parseFloat(range.value) < min) range.value = min;

    recalculateLoan();

    // Smooth scroll ke bagian kalkulator
    document.getElementById('kalkulator-kredit').scrollIntoView({ behavior: 'smooth' });
}

function setLoanTenor(tenor, btn) {
    selectedTenor = tenor;
    document.querySelectorAll('.loan-tenor-btn').forEach(b => {
        b.className = 'loan-tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num';
    });
    btn.className = 'loan-tenor-btn py-2 text-xs font-semibold rounded-lg border border-bdl-primary bg-bdl-navy text-white transition shadow-sm font-num';
    recalculateLoan();
}

function recalculateLoan() {
    const P = parseFloat(document.getElementById('loanRange').value);
    const n = selectedTenor;
    const r = activeLoanRate / 100;
    const provPct = activeProvisionPct / 100;

    const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });
    document.getElementById('loanAmountDisplay').innerText = formatter.format(P);

    // Formula Bunga Flat Perbankan:
    // Angsuran Pokok = P / n
    // Angsuran Bunga = (P * r) / 12
    const principalMonthly = P / n;
    const interestMonthly = (P * r) / 12;
    const totalMonthly = principalMonthly + interestMonthly;
    const provisionFee = P * provPct;

    document.getElementById('monthlyTotalDisplay').innerText = formatter.format(totalMonthly);
    document.getElementById('principalDisplay').innerText = formatter.format(principalMonthly);
    document.getElementById('interestDisplay').innerText = formatter.format(interestMonthly);
    document.getElementById('provisionFeeDisplay').innerText = formatter.format(provisionFee);
}

document.addEventListener('DOMContentLoaded', () => {
    recalculateLoan();
});
</script>
@endsection