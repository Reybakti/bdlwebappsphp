@extends('layouts.app')

@section('title', 'Deposito Berjangka | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section -->
<section class="relative min-h-[360px] lg:min-h-[420px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?auto=format&fit=crop&w=1920&q=80" 
         alt="Investasi Deposito Bank Daerah Lamongan" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.40]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Simpanan Investasi Berjangka
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Deposito Berjangka
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                Pilihan investasi penempatan dana yang aman dengan imbal hasil optimal yang mematuhi batas tingkat bunga penjaminan Lembaga Penjamin Simpanan (LPS).
            </p>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Tab Cepat Antar Produk -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <a href="{{ route('products.savings') }}" class="hover:text-bdl-primary transition whitespace-nowrap text-slate-500 font-medium">&larr; Tabungan</a>
            <span class="text-slate-300">|</span>
            <a href="#katalog-deposito" class="text-bdl-primary font-bold transition whitespace-nowrap">Pilihan Tenor Deposito</a>
            <a href="#kalkulator-deposito" class="hover:text-bdl-primary transition whitespace-nowrap font-bold">Kalkulator Simulasi Bunga</a>
            <a href="#tbp-lps" class="hover:text-bdl-primary transition whitespace-nowrap">Ketentuan Penjaminan LPS</a>
            <a href="#persyaratan" class="hover:text-bdl-primary transition whitespace-nowrap">Syarat Pembukaan</a>
            <span class="text-slate-300">|</span>
            <a href="{{ route('products.loan') }}" class="hover:text-bdl-primary transition whitespace-nowrap font-medium text-slate-500">Selanjutnya: Kredit Usaha &rarr;</a>
        </div>
    </div>
</nav>

<!-- Konten Utama Deposito -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-20">

    <!-- 1. Katalog & Keunggulan Deposito -->
    <section id="katalog-deposito" class="scroll-mt-36 space-y-8">
        <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Investasi Terpercaya</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy mt-1">Produk Deposito Berjangka</h2>
            </div>
            <p class="text-xs text-slate-500 max-w-xs">
                Dijamin penuh oleh LPS hingga batas maksimum Rp2.000.000.000,- per nasabah.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($depositProducts as $product)
                @php
                    $param = $product->simulationParam;
                    $rateDisplay = $param ? number_format($param->base_interest_rate_pa, 2) . '% p.a.' : ($lpsRate ? number_format($lpsRate->rate_idr, 2) . '% p.a.' : '6.75% p.a.');
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:border-bdl-primary hover:shadow-md transition duration-200">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-[#D6E4F0]/50 text-bdl-navy">
                                {{ $product->category->name ?? 'Deposito' }}
                            </span>
                            <span class="text-xs font-num font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded border border-emerald-200">
                                {{ $rateDisplay }}
                            </span>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-bdl-navy">{{ $product->name }}</h3>
                            <p class="text-xs text-slate-600 leading-relaxed mt-1">
                                {{ $product->short_description }}
                            </p>
                        </div>

                        <div class="p-4 bg-slate-50 rounded-xl space-y-2 text-xs text-slate-600">
                            <div class="flex justify-between">
                                <span>Setoran Minimum:</span>
                                <strong class="font-num text-bdl-navy">Rp{{ number_format($param->min_amount ?? 1000000, 0, ',', '.') }}</strong>
                            </div>
                            <div class="flex justify-between">
                                <span>Pilihan Jangka Waktu:</span>
                                <strong class="text-bdl-navy">
                                    {{ $param ? $param->min_tenor_months . ' - ' . $param->max_tenor_months . ' Bulan' : '1, 3, 6, 12 Bulan' }}
                                </strong>
                            </div>
                            <div class="flex justify-between">
                                <span>Metode Perpanjangan:</span>
                                <strong class="text-slate-700">ARO / Non-ARO</strong>
                            </div>
                        </div>

                        @if($product->terms_and_conditions)
                            <div class="text-[11px] text-slate-500 leading-relaxed">
                                <span class="font-bold text-bdl-navy block mb-0.5">Ketentuan Pencairan:</span>
                                {{ Str::limit($product->terms_and_conditions, 120) }}
                            </div>
                        @endif
                    </div>

                    <div class="pt-5 mt-6 border-t border-slate-100 flex items-center justify-between">
                        <a href="#kalkulator-deposito" class="text-xs font-bold text-bdl-primary hover:text-bdl-navy transition">
                            Hitung Imbal Hasil &darr;
                        </a>
                        
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
                    Belum ada data produk deposito yang aktif di basis data.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 2. Kalkulator Simulasi Deposito Interaktif -->
    @php
        $depositParam = $primaryDeposit?->simulationParam;
        $depMinAmount = (float)($depositParam?->min_amount ?? 1000000);
        $depMaxAmount = (float)($depositParam?->max_amount ?? 500000000);
        $depDefaultAmount = max($depMinAmount, min(50000000, $depMaxAmount));
        $currentDepRate = (float)($depositParam?->base_interest_rate_pa ?? ($lpsRate?->rate_idr ?? 6.75));

        // Rentang Tenor Dinamis
        $depMinTenor = (int)($depositParam?->min_tenor_months ?? 1);
        $depMaxTenor = (int)($depositParam?->max_tenor_months ?? 12);
        $candidateDepTenors = [1, 3, 6, 12, 24];
        $availableDepTenors = array_values(array_filter($candidateDepTenors, fn($t) => $t >= $depMinTenor && $t <= $depMaxTenor));
        if (empty($availableDepTenors)) {
            $availableDepTenors = [$depMinTenor, $depMaxTenor];
        }
        $initialActiveTenor = in_array(3, $availableDepTenors) ? 3 : $availableDepTenors[0];
    @endphp

    <section id="kalkulator-deposito" class="scroll-mt-36 p-8 lg:p-12 rounded-3xl bg-slate-50 border border-slate-200 space-y-8">
        <div class="max-w-2xl space-y-2">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Kalkulator Bersih Pajak</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy">Simulasi Hasil Bunga Deposito</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Perhitungan bunga bruto, potongan PPh Pasal 4 ayat (2) sebesar 20% untuk simpanan di atas Rp7.500.000,-, serta total saldo akhir saat jatuh tempo.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <!-- Form Input Deposito -->
            <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <span class="text-xs font-bold text-bdl-navy">
                        {{ $primaryDeposit->name ?? 'Deposito Berjangka BDL' }}
                    </span>
                    <span class="text-xs font-num font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded border border-emerald-200">
                        Bunga: {{ number_format($currentDepRate, 2) }}% p.a.
                    </span>
                </div>

                <!-- Slider Nominal Penempatan -->
                <div class="space-y-2">
                    <div class="flex justify-between text-xs font-bold text-slate-700">
                        <span>Nominal Penempatan Dana:</span>
                        <span id="depAmountDisplay" class="text-bdl-primary font-num text-base font-bold">
                            Rp{{ number_format($depDefaultAmount, 0, ',', '.') }}
                        </span>
                    </div>
                    <input type="range" id="depRange" 
                           min="{{ $depMinAmount }}" 
                           max="{{ $depMaxAmount }}" 
                           step="1000000" 
                           value="{{ $depDefaultAmount }}"
                           class="w-full accent-bdl-primary h-2 bg-slate-200 rounded-lg cursor-pointer" 
                           oninput="recalculateDeposit()">
                    <div class="flex justify-between text-[10px] text-slate-400 font-num">
                        <span>Rp{{ number_format($depMinAmount, 0, ',', '.') }}</span>
                        <span>Rp{{ number_format(($depMinAmount + $depMaxAmount) / 2, 0, ',', '.') }}</span>
                        <span>Rp{{ number_format($depMaxAmount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Pilihan Tenor Penempatan Dinamis -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700">Jangka Waktu Penempatan:</label>
                    <div class="grid grid-cols-{{ count($availableDepTenors) > 4 ? 4 : count($availableDepTenors) }} gap-2">
                        @foreach($availableDepTenors as $tOption)
                            <button type="button" onclick="setDepTenor({{ $tOption }}, this)" 
                                    class="dep-tenor-btn py-2 text-xs font-semibold rounded-lg border {{ $tOption === $initialActiveTenor ? 'border-bdl-primary bg-bdl-navy text-white shadow-sm' : 'border-slate-200 text-slate-600 hover:border-bdl-primary' }} transition font-num">
                                {{ $tOption }} Bulan
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Info Pajak -->
                <div id="taxNoticeBox" class="p-3.5 rounded-xl bg-amber-50 border border-amber-200/80 text-[11px] text-amber-900 leading-relaxed">
                    <strong>Pemberitahuan Pajak:</strong> Nominal deposito di atas Rp7.500.000,- dikenakan Pajak Penghasilan (PPh Final) atas bunga sebesar <strong>20%</strong> sesuai peraturan perpajakan pemerintah RI.
                </div>
            </div>

            <!-- Panel Rincian Imbal Hasil -->
            <div class="lg:col-span-5 bg-bdl-navy text-white rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
                <div>
                    <span class="text-[11px] font-semibold text-bdl-soft uppercase tracking-wider block">Total Bunga Bersih (Net)</span>
                    <div id="netInterestTotalDisplay" class="text-3xl sm:text-4xl font-extrabold font-num text-emerald-400 mt-1">
                        Rp0
                    </div>
                    <span id="tenorSummaryLabel" class="text-[10px] text-slate-400 block mt-0.5">
                        selama {{ $initialActiveTenor }} bulan penempatan
                    </span>
                </div>

                <div class="space-y-3 pt-4 border-t border-white/10 text-xs">
                    <div class="flex justify-between text-slate-300">
                        <span>Bunga Kotor Total (Gross):</span>
                        <strong id="grossTotalDisplay" class="font-num text-white">Rp0</strong>
                    </div>
                    <div class="flex justify-between text-slate-300">
                        <span>Potongan PPh 20%:</span>
                        <strong id="taxTotalDisplay" class="font-num text-rose-300">Rp0</strong>
                    </div>
                    <div class="flex justify-between text-slate-300 pt-2 border-t border-white/10">
                        <span>Bunga Bersih per Bulan:</span>
                        <strong id="netMonthlyDisplay" class="font-num text-emerald-400">Rp0</strong>
                    </div>
                    <div class="flex justify-between text-white font-bold pt-2 border-t border-white/10 text-sm">
                        <span>Saldo Total Saat Jatuh Tempo:</span>
                        <strong id="finalBalanceDisplay" class="font-num text-bdl-soft">Rp0</strong>
                    </div>
                </div>

                <div class="p-3 bg-white/5 rounded-xl border border-white/10 text-[11px] text-slate-300 leading-relaxed">
                    *Bunga bulanan dapat ditransfer langsung ke rekening Tabungan Anda atau ditambahkan kembali ke pokok deposito (ARO).
                </div>

                <a href="{{ route('services.branches') }}" class="block text-center text-xs font-bold text-bdl-navy bg-white hover:bg-bdl-soft py-3 rounded-lg transition shadow">
                    Buka Deposito di Kantor Cabang &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- 3. Ketentuan Penjaminan LPS -->
    <section id="tbp-lps" class="scroll-mt-36 p-8 rounded-3xl bg-white border border-slate-200 space-y-6">
        <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Keamanan Simpanan</span>
                <h3 class="text-xl font-bold text-bdl-navy mt-0.5">Informasi Tingkat Bunga Penjaminan (TBP) LPS</h3>
            </div>
            <div class="bg-white px-3.5 py-1.5 rounded-lg border border-slate-200 shadow-sm shrink-0">
                <img src="{{ asset('assets/images/logo-lps.png') }}" alt="Lembaga Penjamin Simpanan" class="h-6 w-auto object-contain">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-xs text-slate-600 leading-relaxed">
            <div class="space-y-3">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-1">
                    <span class="text-[11px] text-slate-500 font-semibold uppercase block">Suku Bunga Penjaminan BPR Aktif:</span>
                    <span class="text-2xl font-extrabold font-num text-bdl-navy block">{{ number_format($lpsRate?->rate_idr ?? 6.75, 2) }}% p.a.</span>
                    <span class="text-[10px] text-slate-400 block font-num">
                        Periode: {{ $lpsRate ? \Carbon\Carbon::parse($lpsRate->effective_start_date)->translatedFormat('d M Y') : 'Aktif' }} s/d {{ $lpsRate ? \Carbon\Carbon::parse($lpsRate->effective_end_date)->translatedFormat('d M Y') : 'Sekarang' }}
                    </span>
                </div>
                <p>
                    Lembaga Penjamin Simpanan (LPS) menetapkan syarat penjaminan simpanan dengan prinsip <strong>3T</strong>:
                </p>
                <ul class="space-y-1 list-disc list-inside text-slate-700">
                    <li><strong>Tercatat</strong> dalam pembukuan bank.</li>
                    <li><strong>Tingkat bunga</strong> tidak melebihi tingkat bunga penjaminan LPS yang berlaku.</li>
                    <li><strong>Tidak melakukan</strong> tindakan yang merugikan bank (kredit macet).</li>
                </ul>
            </div>

            <div class="space-y-3">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-1">
                    <span class="text-[11px] text-slate-500 font-semibold uppercase block">Nilai Maksimal Simpanan yang Dijamin:</span>
                    <span class="text-2xl font-extrabold font-num text-bdl-primary block">Rp2.000.000.000,-</span>
                    <span class="text-[10px] text-slate-400 block">per nasabah per bank terdaftar</span>
                </div>
                <p>
                    {{ $profile->name ?? 'PT BPR Bank Daerah Lamongan (Perseroda)' }} senantiasa mematuhi regulasi batas suku bunga penjaminan agar seluruh dana deposito nasabah terlindungi 100% oleh pemerintah Republik Indonesia melalui LPS.
                </p>
            </div>
        </div>
    </section>

    <!-- 4. Syarat Pembukaan Rekening Deposito -->
    <section id="persyaratan" class="scroll-mt-36 space-y-8">
        <div class="border-b border-slate-200 pb-4">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Panduan Nasabah</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy mt-1">Persyaratan Pembukaan Deposito</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <!-- Nasabah Perorangan -->
            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">P</div>
                    <h4 class="font-bold text-sm text-bdl-navy">Nasabah Perorangan (Individu)</h4>
                </div>
                <ul class="space-y-2 text-slate-600 list-disc list-inside leading-relaxed">
                    <li>Fotokopi Kartu Tanda Penduduk (e-KTP) yang masih berlaku.</li>
                    <li>Fotokopi Nomor Pokok Wajib Pajak (NPWP).</li>
                    <li>Mengisi dan menandatangani formulir pembukaan rekening deposito.</li>
                    <li>Menyetorkan dana penempatan awal sesuai ketentuan minimum bilyet.</li>
                </ul>
            </div>

            <!-- Nasabah Badan Usaha / Lembaga -->
            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">B</div>
                    <h4 class="font-bold text-sm text-bdl-navy">Nasabah Badan Usaha / Yayasan / Koperasi</h4>
                </div>
                <ul class="space-y-2 text-slate-600 list-disc list-inside leading-relaxed">
                    <li>Fotokopi Akta Pendirian Perusahaan beserta Perubahan Anggaran Dasar Terakhir.</li>
                    <li>Fotokopi NIB (Nomor Induk Berusaha) / Izin Usaha dan NPWP Badan.</li>
                    <li>Fotokopi e-KTP pengurus / direksi yang berwenang bertindak atas nama badan.</li>
                    <li>Surat Kuasa khusus (apabila diwakilkan kepada pihak lain).</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Banner Ajakan ke Kredit & Pembiayaan -->
    <section class="p-8 rounded-3xl bg-bdl-navy text-white flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-1.5">
            <span class="text-xs font-bold text-bdl-soft uppercase tracking-wider block">Portofolio Pembiayaan</span>
            <h3 class="text-xl font-bold">Butuh Tambahan Likuiditas Modal Usaha?</h3>
            <p class="text-xs text-slate-300 max-w-xl leading-relaxed">
                Manfaatkan fasilitas Kredit Modal Kerja dan Investasi UMKM dengan skema bunga flat terjangkau dan agunan fleksibel.
            </p>
        </div>
        <a href="{{ route('products.loan') }}" class="px-6 py-3 rounded-lg text-xs font-bold text-bdl-navy bg-white hover:bg-bdl-soft transition shadow shrink-0 whitespace-nowrap">
            Simulasi Kredit UMKM &rarr;
        </a>
    </section>

</div>
@endsection

@section('scripts')
<script>
const depositInterestRatePa = parseFloat("{{ $currentDepRate }}") / 100;
let activeDepTenor = {{ $initialActiveTenor }};

function setDepTenor(tenor, btn) {
    activeDepTenor = tenor;
    document.querySelectorAll('.dep-tenor-btn').forEach(b => {
        b.className = 'dep-tenor-btn py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:border-bdl-primary transition font-num';
    });
    btn.className = 'dep-tenor-btn py-2 text-xs font-semibold rounded-lg border border-bdl-primary bg-bdl-navy text-white transition shadow-sm font-num';
    
    const summaryLabel = document.getElementById('tenorSummaryLabel');
    if (summaryLabel) {
        summaryLabel.innerText = `selama ${tenor} bulan penempatan`;
    }
    recalculateDeposit();
}

function recalculateDeposit() {
    const rangeInput = document.getElementById('depRange');
    if (!rangeInput) return;

    const P = parseFloat(rangeInput.value);
    const n = activeDepTenor;
    const r = depositInterestRatePa;

    const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });
    const amountDisplay = document.getElementById('depAmountDisplay');
    if (amountDisplay) {
        amountDisplay.innerText = formatter.format(P);
    }

    // Bunga Kotor Bulanan = (P * r) / 12
    const monthlyGross = (P * r) / 12;
    const totalGross = monthlyGross * n;

    // Pajak PPh Final 20% jika nominal >= Rp7.500.000
    const isTaxable = (P >= 7500000);
    const taxRate = isTaxable ? 0.20 : 0.00;
    const totalTax = totalGross * taxRate;
    const monthlyNet = monthlyGross * (1 - taxRate);
    const totalNet = totalGross - totalTax;
    const finalBalance = P + totalNet;

    // Update Output
    const netTotalEl = document.getElementById('netInterestTotalDisplay');
    if (netTotalEl) netTotalEl.innerText = formatter.format(totalNet);

    const grossTotalEl = document.getElementById('grossTotalDisplay');
    if (grossTotalEl) grossTotalEl.innerText = formatter.format(totalGross);

    const taxTotalEl = document.getElementById('taxTotalDisplay');
    if (taxTotalEl) {
        taxTotalEl.innerText = isTaxable ? '- ' + formatter.format(totalTax) : 'Rp0 (Bebas Pajak)';
    }

    const netMonthlyEl = document.getElementById('netMonthlyDisplay');
    if (netMonthlyEl) netMonthlyEl.innerText = formatter.format(monthlyNet);

    const finalBalanceEl = document.getElementById('finalBalanceDisplay');
    if (finalBalanceEl) finalBalanceEl.innerText = formatter.format(finalBalance);

    // Update Box Notifikasi Pajak
    const taxBox = document.getElementById('taxNoticeBox');
    if (taxBox) {
        if (isTaxable) {
            taxBox.className = 'p-3.5 rounded-xl bg-amber-50 border border-amber-200/80 text-[11px] text-amber-900 leading-relaxed';
            taxBox.innerHTML = '<strong>Pemberitahuan Pajak:</strong> Nominal deposito &ge; Rp7.500.000,- dikenakan Pajak Penghasilan (PPh Final) atas bunga sebesar <strong>20%</strong> sesuai peraturan perpajakan RI.';
        } else {
            taxBox.className = 'p-3.5 rounded-xl bg-emerald-50 border border-emerald-200/80 text-[11px] text-emerald-900 leading-relaxed';
            taxBox.innerHTML = '<strong>Bebas Pajak:</strong> Nominal penempatan dana di bawah Rp7.500.000,- <strong>tidak dikenakan pemotongan PPh bunga</strong> (Pajak 0%).';
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    recalculateDeposit();
});
</script>
@endsection