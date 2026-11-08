@extends('layouts.app')

@section('title', 'Struktur Organisasi | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Header Banner -->
<section class="relative min-h-[340px] lg:min-h-[380px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1920&q=80" 
         alt="Tata Kelola {{ $profile->name ?? 'Bank Daerah Lamongan' }}" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.38]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-32 pb-14 text-white">
        <div class="max-w-2xl space-y-3">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Tata Kelola & Organisasi
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Struktur Organisasi
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                Struktur kepemimpinan dan organisasi {{ $profile->name ?? 'PT BPR Bank Daerah Lamongan (Perseroda)' }} yang profesional, terintegrasi, dan mematuhi tata kelola perbankan yang sehat.
            </p>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Tab Cepat -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <a href="{{ route('about.profile') }}" class="hover:text-bdl-primary transition whitespace-nowrap">Profil & Sejarah</a>
            <a href="{{ route('about.management') }}" class="hover:text-bdl-primary transition whitespace-nowrap">Dewan Direksi & Komisaris</a>
            <a href="{{ route('about.structure') }}" class="text-bdl-primary font-bold border-b-2 border-bdl-primary pb-1 whitespace-nowrap">Struktur Organisasi</a>
            <a href="{{ route('transparency.gcg') }}" class="hover:text-bdl-primary transition whitespace-nowrap">Laporan Tata Kelola (GCG)</a>
            <a href="{{ route('services.branches') }}" class="hover:text-bdl-primary transition whitespace-nowrap">Jaringan Kantor</a>
        </div>
    </div>
</nav>

<!-- Konten Utama -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-20">

    <!-- 1. BAGAN DIAGRAM VISUAL (JIKA DIUNGGAH DARI ADMIN) -->
    <section class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-4">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Diagram Alur Komando</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy">Bagan Struktur Organisasi Resmi</h2>
            </div>

            @if($profile && $profile->org_chart_image)
                <a href="{{ asset('storage/' . $profile->org_chart_image) }}" target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-bdl-primary text-white rounded-xl text-xs font-bold hover:bg-bdl-navy transition shadow-sm w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Lihat Bagan Penuh</span>
                </a>
            @endif
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-4 sm:p-8 shadow-sm overflow-hidden flex flex-col items-center justify-center min-h-[300px]">
            @if($profile && $profile->org_chart_image)
                <div class="w-full overflow-x-auto flex justify-center py-2">
                    <img src="{{ asset('storage/' . $profile->org_chart_image) }}" 
                         alt="Bagan Struktur Organisasi {{ $profile->name ?? 'Bank Daerah Lamongan' }}" 
                         class="max-w-full h-auto rounded-xl shadow-sm border border-slate-100">
                </div>
            @else
                <div class="text-center space-y-2 py-8 max-w-md mx-auto">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-bdl-primary flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Bagan Visual Terintegrasi</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Diagram bagan alur komando dapat diunggah melalui menu Profil Lembaga di panel kendali admin.
                    </p>
                </div>
            @endif
        </div>
    </section>

    <!-- 2. HIERARKI KEPEMIMPINAN & STRUKTUR ORGANISASI (SESUAI BDL.CO.ID) -->
    <section class="space-y-12">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Tata Hubungan Organisasi</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy">Susunan Jabatan & Penugasan Kerja</h2>
            <p class="text-xs text-slate-500 leading-relaxed">
                Struktur penugasan kerja yang dirancang untuk menjaga prinsip kehati-hatian (*prudential banking*) dan akuntabilitas pelayanan.
            </p>
        </div>

        <!-- TINGKAT 1: PIMPINAN UTAMA -->
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-bdl-navy"></span>
                <h3 class="text-base font-extrabold text-bdl-navy uppercase tracking-wide">Pimpinan Tertinggi</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-gradient-to-br from-bdl-navy to-[#10375C] text-white p-6 rounded-2xl shadow-sm space-y-2">
                    <span class="text-[10px] uppercase font-mono tracking-wider text-bdl-soft block font-bold">Kekuasaan Tertinggi</span>
                    <h4 class="text-lg font-bold">RUPS</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Rapat Umum Pemegang Saham sebagai pemegang kekuasaan tertinggi dalam penetapan arah kebijakan perusahaan.
                    </p>
                </div>

                <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm space-y-2 hover:border-bdl-primary transition">
                    <span class="text-[10px] uppercase font-mono tracking-wider text-amber-600 block font-bold">Fungsi Pengawasan</span>
                    <h4 class="text-lg font-bold text-bdl-navy">Dewan Komisaris</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Melakukan fungsi pengawasan berkala dan memberikan nasihat atas kepengurusan kebijakan direksi.
                    </p>
                </div>

                <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm space-y-2 hover:border-bdl-primary transition">
                    <span class="text-[10px] uppercase font-mono tracking-wider text-emerald-600 block font-bold">Pucuk Pimpinan Eksekutif</span>
                    <h4 class="text-lg font-bold text-bdl-navy">Direktur Utama</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Memimpin pengelolaan perusahaan, merumuskan strategi bisnis, dan mengoordinasikan seluruh operasional bank.
                    </p>
                </div>
            </div>
        </div>

        <!-- TINGKAT 2: JAJARAN DIREKSI -->
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-bdl-primary"></span>
                <h3 class="text-base font-extrabold text-bdl-navy uppercase tracking-wide">Direksi</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm space-y-2">
                    <div class="flex items-center justify-between">
                        <h4 class="text-base font-bold text-bdl-navy">Direktur Operasional & Bisnis</h4>
                        <span class="text-[10px] bg-blue-50 text-bdl-primary px-2.5 py-1 rounded-full font-bold">Operasional</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Membawahi seluruh operasional kantor cabang, pelayanan dana nasabah, penyaluran kredit, dan ekspansi portofolio bisnis.
                    </p>
                </div>

                <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm space-y-2">
                    <div class="flex items-center justify-between">
                        <h4 class="text-base font-bold text-bdl-navy">Direktur Kepatuhan</h4>
                        <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full font-bold">Kepatuhan & Regulasi</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Membawahi fungsi kepatuhan regulasi OJK & LPS, manajemen risiko (MR), serta program pencegahan APU-PPT & P3SPM.
                    </p>
                </div>
            </div>
        </div>

        <!-- TINGKAT 3: KEPALA DIVISI (KADIV) -->
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-[#0284C7]"></span>
                <h3 class="text-base font-extrabold text-bdl-navy uppercase tracking-wide">Kepala Divisi</h3>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $divisiList = [
                        ['title' => 'Kadiv Operasional / LPPK', 'desc' => 'Manajemen operasional harian, tata kelola kasir/teller, dan pelaporan perbankan.'],
                        ['title' => 'Kadiv Bisnis / Literasi & Inklusi', 'desc' => 'Perluasan pasar pembiayaan, program tabungan, serta edukasi keuangan masyarakat.'],
                        ['title' => 'Kadiv SDM & Umum', 'desc' => 'Pengembangan kompetensi pegawai, rekrutmen, sarana prasarana, dan administrasi umum.'],
                        ['title' => 'Kadiv Audit Internal & SAF/IPKB', 'desc' => 'Pengawasan sistem pengendalian intern independen dan kepatuhan audit satuan kerja.'],
                        ['title' => 'Kadiv Kepatuhan / MR / APU-PPT & Legal Kredit', 'desc' => 'Pengawasan limit risiko kredit, legalitas agunan, dan kepatuhan regulasi jasa keuangan.'],
                    ];
                @endphp

                @foreach($divisiList as $div)
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5 hover:bg-white hover:border-bdl-primary transition">
                        <span class="text-[10px] font-bold text-bdl-primary uppercase tracking-wider block">Divisi Kerja</span>
                        <h4 class="text-sm font-bold text-slate-800">{{ $div['title'] }}</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">{{ $div['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- TINGKAT 4: KEPALA BAGIAN (KABAG) -->
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-[#0D9488]"></span>
                <h3 class="text-base font-extrabold text-bdl-navy uppercase tracking-wide">Kepala Bagian</h3>
            </div>
            
            @php
                $kabagList = [
                    'Kabag Operasional',
                    'Kabag Kredit',
                    'Kabag Collection',
                    'Kabag SDM',
                    'Kabag IT & Digital',
                    'Kabag Akunting & Pelaporan',
                    'Kabag Dana',
                    'Kabag Bisnis',
                    'Kabag Perencanaan & Pengembangan',
                    'Kabag Kepatuhan',
                    'Kabag Manajemen Risiko',
                ];
            @endphp

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($kabagList as $kabag)
                    <div class="p-3.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 shadow-sm flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-teal-500 shrink-0"></span>
                        <span class="truncate">{{ $kabag }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- TINGKAT 5: KEPALA SUB BAGIAN (KASUBAG) -->
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-[#D97706]"></span>
                <h3 class="text-base font-extrabold text-bdl-navy uppercase tracking-wide">Kepala Sub Bagian</h3>
            </div>
            
            @php
                $kasubagList = [
                    'Kasubag Operasional',
                    'Kasubag Kredit Produktif',
                    'Kasubag Kredit Konsumtif',
                    'Kasubag Admin Kredit',
                    'Kasubag Analis Kredit',
                    'Kasubag Collection',
                    'Kasubag SDM',
                    'Kasubag Umum',
                    'Kasubag IT & Digital',
                    'Kasubag Arsip',
                    'Kasubag ABA',
                    'Kasubag Akunting',
                    'Kasubag Dana',
                    'Kasubag Bisnis',
                    'Kasubag MR & Legal Kredit',
                    'Kasubag Kepatuhan',
                    'Kasubag Perencanaan',
                ];
            @endphp

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2.5">
                @foreach($kasubagList as $kasubag)
                    <div class="p-3 bg-slate-50 border border-slate-200/70 rounded-xl text-[11px] font-medium text-slate-700 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0"></span>
                        <span class="truncate">{{ $kasubag }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- TINGKAT 6: PELAKSANA OPERASIONAL (FRONT & BACKOFFICE) -->
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-slate-400"></span>
                <h3 class="text-base font-extrabold text-bdl-navy uppercase tracking-wide">Pelaksana Operasional</h3>
            </div>
            
            @php
                $pelaksanaList = [
                    'Account Officer (AO)',
                    'Funding Officer (FO)',
                    'Marketing Officer',
                    'Customer Service (CS)',
                    'Teller',
                    'Staff Admin Kredit',
                    'Staff Analis Kredit',
                    'Staff Collection',
                    'Staff Admin Collection',
                    'Staff Akunting',
                    'Staff SDM',
                    'Staff Umum',
                    'Staff IT & Digital',
                    'Staff Arsip',
                    'Driver',
                    'Security',
                    'Office Boy',
                ];
            @endphp

            <div class="flex flex-wrap gap-2">
                @foreach($pelaksanaList as $pelaksana)
                    <span class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-[11px] font-semibold text-slate-600 shadow-sm">
                        {{ $pelaksana }}
                    </span>
                @endforeach
            </div>
        </div>

    </section>

</div>
@endsection