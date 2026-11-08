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
            <span class="text-slate-300">|</span>
            <a href="{{ route('products.deposit') }}" class="hover:text-bdl-primary transition whitespace-nowrap text-slate-500 font-medium">Simulasi Deposito &rarr;</a>
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
                    $rate = $param ? (float)$param->base_interest_rate_pa : 10.50;
                    $minAmt = $param ? (float)$param->min_amount : 5000000;
                    $maxAmt = $param ? (float)$param->max_amount : 200000000;
                    $minTenor = $param ? (int)$param->min_tenor_months : 6;
                    $maxTenor = $param ? (int)$param->max_tenor_months : 36;
                    $method = $param ? $param->calculation_method : 'FLAT';
                    $provision = 1.0;
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:border-bdl-primary hover:shadow-md transition duration-200">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-[#D6E4F0]/50 text-bdl-navy">
                                {{ $product->category->name ?? 'Kredit' }}
                            </span>
                            @if($param)
                                <span class="text-xs font-num font-bold text-bdl-primary bg-blue-50 px-2 py-0.5 rounded border border-blue-200">
                                    {{ number_format($rate, 2) }}% p.a. ({{ ucfirst(strtolower($method)) }})
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
                                    <span>Plafon Pinjaman:</span>
                                    <strong class="font-num text-bdl-navy">
                                        Rp{{ number_format($minAmt, 0, ',', '.') }} - Rp{{ number_format($maxAmt, 0, ',', '.') }}
                                    </strong>
                                </div>
                                <div class="flex justify-between">
                                    <span>Jangka Waktu (Tenor):</span>
                                    <strong class="font-num text-bdl-navy">{{ $minTenor }} s/d {{ $maxTenor }} Bulan</strong>
                                </div>
                                <div class="flex justify-between">
                                    <span>Metode Perhitungan:</span>
                                    <strong class="text-slate-800 uppercase font-mono">{{ $method }}</strong>
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
                                onclick="selectProductForCalc('{{ addslashes($product->name) }}', {{ $rate }}, {{ $minAmt }}, {{ $maxAmt }}, {{ $minTenor }}, {{ $maxTenor }}, '{{ $method }}', {{ $provision }})"
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
        $calcMinAmount = (float)($calcParam?->min_amount ?? 5000000);
        $calcMaxAmount = (float)($calcParam?->max_amount ?? 200000000);
        $calcDefaultAmount = max($calcMinAmount, min(25000000, $calcMaxAmount));
        $calcRate = (float)($calcParam?->base_interest_rate_pa ?? 10.50);
        $calcMethod = $calcParam?->calculation_method ?? 'FLAT';
        $calcMinTenor = (int)($calcParam?->min_tenor_months ?? 6);
        $calcMaxTenor = (int)($calcParam?->max_tenor_months ?? 36);
        $calcProvision = 1.0;

        $candidateLoanTenors = [6, 12, 24, 36, 48, 60];
        $availableLoanTenors = array_values(array_filter($candidateLoanTenors, fn($t) => $t >= $calcMinTenor && $t <= $calcMaxTenor));
        if (empty($availableLoanTenors)) {
            $availableLoanTenors = [$calcMinTenor, $calcMaxTenor];
        }
        $initialActiveTenor = in_array(12, $availableLoanTenors) ? 12 : $availableLoanTenors[0];
    @endphp

    <section id="kalkulator-kredit" class="scroll-mt-36 p-8 lg:p-12 rounded-3xl bg-slate-50 border border-slate-200 space-y-8">
        <div class="max-w-2xl space-y-2">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Simulasi Mandiri</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy">Kalkulator Perhitungan Angsuran</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Menghitung estimasi pokok, porsi bunga bulanan, serta perkiraan biaya provisi administrasi awal secara transparan.
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
                        {{ number_format($calcRate, 2) }}% ({{ ucfirst(strtolower($calcMethod)) }})
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
                           step="1000000" 
                           value="{{ $calcDefaultAmount }}"
                           class="w-full accent-bdl-primary h-2 bg-slate-200 rounded-lg cursor-pointer" 
                           oninput="recalculateLoan()">
                    <div class="flex justify-between text-[10px] text-slate-400 font-num">
                        <span id="minAmountLabel">Rp{{ number_format($calcMinAmount, 0, ',', '.') }}</span>
                        <span id="midAmountLabel">Rp{{ number_format(($calcMinAmount + $calcMaxAmount) / 2, 0, ',', '.') }}</span>
                        <span id="maxAmountLabel">Rp{{ number_format($calcMaxAmount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Pilihan Tenor -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700">Jangka Waktu Pinjaman (Tenor):</label>
                    <div id="tenorButtonsContainer" class="grid grid-cols-{{ count($availableLoanTenors) > 4 ? 4 : count($availableLoanTenors) }} gap-2">
                        @foreach($availableLoanTenors as $tOption)
                            <button type="button" onclick="setLoanTenor({{ $tOption }}, this)" 
                                    class="loan-tenor-btn py-2 text-xs font-semibold rounded-lg border {{ $tOption === $initialActiveTenor ? 'border-bdl-primary bg-bdl-navy text-white shadow-sm' : 'border-slate-200 text-slate-600 hover:border-bdl-primary' }} transition font-num">
                                {{ $tOption }} Bulan
                            </button>
                        @endforeach
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
                    <span id="tenorSummaryLabel" class="text-[10px] text-slate-400 block mt-0.5">
                        per bulan selama {{ $initialActiveTenor }} bulan
                    </span>
                </div>

                <div class="space-y-3 pt-4 border-t border-white/10 text-xs">
                    <div class="flex justify-between text-slate-300">
                        <span>Angsuran Pokok:</span>
                        <strong id="principalDisplay" class="font-num text-white">Rp0</strong>
                    </div>
                    <div class="flex justify-between text-slate-300">
                        <span>Porsi Bunga:</span>
                        <strong id="interestDisplay" class="font-num text-white">Rp0</strong>
                    </div>
                    <div class="flex justify-between text-slate-300">
                        <span>Estimasi Biaya Provisi (<span id="provisionPctDisplay">{{ $calcProvision }}</span>%):</span>
                        <strong id="provisionFeeDisplay" class="font-num text-bdl-soft">Rp0</strong>
                    </div>
                </div>

                <div class="p-3 bg-white/5 rounded-xl border border-white/10 text-[11px] text-slate-300 leading-relaxed">
                    *Hasil simulasi merupakan estimasi perhitungan. Nilai definitif, biaya pengikatan notaris/agunan, dan asuransi ditentukan pada saat akad kredit di kantor operasional BDL.
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

            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="w-9 h-9 rounded-xl bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">2</div>
                <h4 class="font-bold text-sm text-bdl-navy">Bukti Usaha / Penghasilan</h4>
                <ul class="space-y-1.5 text-slate-600 list-disc list-inside leading-relaxed">
                    <li>Surat Keterangan Usaha (SKU) dari Desa/Kelurahan</li>
                    <li>Catatan pembukuan / nota penjualan sederhana</li>
                    <li>Slip gaji asli & SK (khusus pegawai/konsumtif)</li>
                    <li>Rekening koran tabungan 3 bulan terakhir</li>
                </ul>
            </div>

            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="w-9 h-9 rounded-xl bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">3</div>
                <h4 class="font-bold text-sm text-bdl-navy">Legalitas Agunan</h4>
                <ul class="space-y-1.5 text-slate-600 list-disc list-inside leading-relaxed">
                    <li>Sertifikat Hak Milik (SHM) / SHGB asli</li>
                    <li>Bukti Pembayaran PBB tahun terakhir</li>
                    <li>BPKB Kendaraan bermotor beserta STNK aktif</li>
                    <li>Bilyet Deposito (khusus kredit *back-to-back*)</li>
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
let activeCalculationMethod = "{{ strtoupper($calcMethod) }}";
let selectedTenor = {{ $initialActiveTenor }};
const currencyFormatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });

function selectProductForCalc(name, rate, min, max, minTenor, maxTenor, method, prov) {
    document.getElementById('calcProductName').innerText = name;
    document.getElementById('calcRateBadge').innerText = rate.toFixed(2) + '% (' + method.toLowerCase() + ')';
    document.getElementById('provisionPctDisplay').innerText = prov;
    
    activeLoanRate = rate;
    activeProvisionPct = prov;
    activeCalculationMethod = method.toUpperCase();

    const range = document.getElementById('loanRange');
    range.min = min;
    range.max = max;

    document.getElementById('minAmountLabel').innerText = currencyFormatter.format(min);
    document.getElementById('midAmountLabel').innerText = currencyFormatter.format((min + max) / 2);
    document.getElementById('maxAmountLabel').innerText = currencyFormatter.format(max);

    if (parseFloat(range.value) > max) range.value = max;
    if (parseFloat(range.value) < min) range.value = min;

    // Rekonstruksi tombol tenor berdasarkan rentang produk
    const container = document.getElementById('tenorButtonsContainer');
    if (container) {
        const candidates = [6, 12, 24, 36, 48, 60];
        let available = candidates.filter(t => t >= minTenor && t <= maxTenor);
        if (available.length === 0) available = [minTenor, maxTenor];

        container.className = `grid grid-cols-${available.length > 4 ? 4 : available.length} gap-2`;
        container.innerHTML = '';

        if (!available.includes(selectedTenor)) {
            selectedTenor = available.includes(12) ? 12 : available[0];
        }

        available.forEach(t => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = `loan-tenor-btn py-2 text-xs font-semibold rounded-lg border ${t === selectedTenor ? 'border-bdl-primary bg-bdl-navy text-white shadow-sm' : 'border-slate-200 text-slate-600 hover:border-bdl-primary'} transition font-num`;
            btn.innerText = `${t} Bulan`;
            btn.onclick = function() { setLoanTenor(t, btn); };
            container.appendChild(btn);
        });
    }

    recalculateLoan();

    // Scroll mulus menuju kalkulator
    const target = document.getElementById('kalkulator-kredit');
    if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
    }
}

function setLoanTenor(tenor, btn) {
    selectedTenor = tenor;
    document.querySelectorAll('.loan-tenor-btn').forEach(b => {
        b.className = 'loan-tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num';
    });
    btn.className = 'loan-tenor-btn py-2 text-xs font-semibold rounded-lg border border-bdl-primary bg-bdl-navy text-white transition shadow-sm font-num';
    
    const summaryLabel = document.getElementById('tenorSummaryLabel');
    if (summaryLabel) {
        summaryLabel.innerText = `per bulan selama ${tenor} bulan`;
    }
    recalculateLoan();
}

function recalculateLoan() {
    const range = document.getElementById('loanRange');
    if (!range) return;

    const P = parseFloat(range.value);
    const n = selectedTenor;
    const r = activeLoanRate / 100;
    const provPct = activeProvisionPct / 100;

    const amountDisplay = document.getElementById('loanAmountDisplay');
    if (amountDisplay) {
        amountDisplay.innerText = currencyFormatter.format(P);
    }

    let principalMonthly = 0;
    let interestMonthly = 0;
    let totalMonthly = 0;

    if (activeCalculationMethod === 'ANNUITY') {
        const monthlyRate = r / 12;
        if (monthlyRate > 0) {
            totalMonthly = P * (monthlyRate * Math.pow(1 + monthlyRate, n)) / (Math.pow(1 + monthlyRate, n) - 1);
        } else {
            totalMonthly = P / n;
        }
        interestMonthly = (totalMonthly * n - P) / n;
        principalMonthly = totalMonthly - interestMonthly;
    } else {
        // FLAT (Default BPR)
        principalMonthly = P / n;
        interestMonthly = (P * r) / 12;
        totalMonthly = principalMonthly + interestMonthly;
    }

    const provisionFee = P * provPct;

    const totalDisplay = document.getElementById('monthlyTotalDisplay');
    if (totalDisplay) totalDisplay.innerText = currencyFormatter.format(totalMonthly);

    const princDisplay = document.getElementById('principalDisplay');
    if (princDisplay) princDisplay.innerText = currencyFormatter.format(principalMonthly);

    const intDisplay = document.getElementById('interestDisplay');
    if (intDisplay) intDisplay.innerText = currencyFormatter.format(interestMonthly);

    const provDisplay = document.getElementById('provisionFeeDisplay');
    if (provDisplay) provDisplay.innerText = currencyFormatter.format(provisionFee);
}

document.addEventListener('DOMContentLoaded', () => {
    recalculateLoan();
});
</script>
@endsection