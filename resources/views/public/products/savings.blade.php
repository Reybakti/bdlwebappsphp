@extends('layouts.app')

@section('title', 'Produk Tabungan | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section -->
<section class="relative min-h-[360px] lg:min-h-[420px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1559526324-4b87b5e36e44?auto=format&fit=crop&w=1920&q=80" 
         alt="Layanan Tabungan Bank Daerah Lamongan" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.40]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Simpanan Likuid & Aman
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Produk Tabungan
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                Fasilitas simpanan harian, tabungan berencana, dan simpanan pelajar dengan setoran awal ringan, bebas biaya admin bulanan, serta jaminan perlindungan penuh dari LPS.
            </p>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Tab Cepat Antar Produk -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <a href="#katalog-tabungan" class="text-bdl-primary font-bold transition whitespace-nowrap">Daftar Produk Tabungan</a>
            <a href="#keunggulan" class="hover:text-bdl-primary transition whitespace-nowrap">Keunggulan Menabung</a>
            <a href="#persyaratan" class="hover:text-bdl-primary transition whitespace-nowrap">Syarat Pembukaan</a>
            <span class="text-slate-300">|</span>
            <a href="{{ route('products.deposit') }}" class="hover:text-bdl-primary transition whitespace-nowrap font-medium text-slate-500">Selanjutnya: Deposito Berjangka &rarr;</a>
        </div>
    </div>
</nav>

<!-- Konten Utama Tabungan -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-20">

    <!-- 1. Katalog Produk Tabungan Dinamis dari Database -->
    <section id="katalog-tabungan" class="scroll-mt-36 space-y-8">
        <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Portofolio Simpanan</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy mt-1">Pilihan Rekening Tabungan</h2>
            </div>
            <p class="text-xs text-slate-500 max-w-xs">
                Seluruh saldo simpanan tabungan dijamin LPS hingga batas Rp2 Miliar per nasabah.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($savingsProducts as $product)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:border-bdl-primary hover:shadow-md transition duration-200">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-[#D6E4F0]/50 text-bdl-navy">
                                {{ $product->category->name ?? 'Tabungan' }}
                            </span>
                            <span class="text-xs font-num font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                Bebas Potongan Bulanan
                            </span>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-bdl-navy">{{ $product->name }}</h3>
                            <p class="text-xs text-slate-600 leading-relaxed mt-1">
                                {{ $product->short_description }}
                            </p>
                        </div>

                        <!-- Ringkasan Ketentuan -->
                        @if($product->terms_and_conditions)
                            <div class="p-4 bg-slate-50 rounded-xl space-y-1.5 text-xs text-slate-600">
                                <span class="font-bold text-bdl-navy block text-[11px]">Ketentuan Rekening:</span>
                                <div class="text-[11px] text-slate-500 leading-relaxed">
                                    {{ $product->terms_and_conditions }}
                                </div>
                            </div>
                        @else
                            <div class="p-4 bg-slate-50 rounded-xl space-y-2 text-xs text-slate-600">
                                <div class="flex justify-between">
                                    <span>Setoran Awal:</span>
                                    <strong class="font-num text-bdl-navy">Mulai Rp20.000</strong>
                                </div>
                                <div class="flex justify-between">
                                    <span>Biaya Administrasi:</span>
                                    <strong class="text-emerald-600 font-bold">Gratis (Rp0)</strong>
                                </div>
                                <div class="flex justify-between">
                                    <span>Penarikan Dana:</span>
                                    <strong class="text-slate-700">Setiap Hari Kerja</strong>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="pt-5 mt-6 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('services.branches') }}" class="text-xs font-bold text-bdl-primary hover:text-bdl-navy transition">
                            Buka di Kantor Terdekat &rarr;
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
                <!-- Fallback Representasi Standar Perbankan jika DB Kosong -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:border-bdl-primary hover:shadow-md transition duration-200">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-[#D6E4F0]/50 text-bdl-navy">
                                Tabungan Umum
                            </span>
                            <span class="text-xs font-num font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                Tanpa Biaya Admin
                            </span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-bdl-navy">Tabungan SIMAPAN</h3>
                            <p class="text-xs text-slate-600 leading-relaxed mt-1">
                                Simpanan harian terpercaya bagi pedagang, petani, dan masyarakat umum untuk mengelola kebutuhan likuiditas harian secara aman.
                            </p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl space-y-2 text-xs text-slate-600">
                            <div class="flex justify-between"><span>Setoran Awal:</span> <strong class="font-num text-bdl-navy">Rp20.000</strong></div>
                            <div class="flex justify-between"><span>Saldo Minimum:</span> <strong class="font-num text-bdl-navy">Rp10.000</strong></div>
                            <div class="flex justify-between"><span>Biaya Bulanan:</span> <strong class="text-emerald-600">Rp0 (Gratis)</strong></div>
                        </div>
                    </div>
                    <div class="pt-5 mt-6 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('services.branches') }}" class="text-xs font-bold text-bdl-primary hover:text-bdl-navy transition">Buka Rekening &rarr;</a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:border-bdl-primary hover:shadow-md transition duration-200">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-[#D6E4F0]/50 text-bdl-navy">
                                Pelajar & Edukasi
                            </span>
                            <span class="text-xs font-num font-bold text-bdl-primary bg-sky-50 px-2 py-0.5 rounded border border-sky-200">
                                Program OJK
                            </span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-bdl-navy">Simpanan Pelajar (SimPel)</h3>
                            <p class="text-xs text-slate-600 leading-relaxed mt-1">
                                Tabungan khusus bagi siswa PAUD hingga SMA/sederajat dengan persyaratan mudah guna menumbuhkan budaya gemar menabung sejak dini.
                            </p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl space-y-2 text-xs text-slate-600">
                            <div class="flex justify-between"><span>Setoran Awal:</span> <strong class="font-num text-bdl-navy">Rp5.000</strong></div>
                            <div class="flex justify-between"><span>Setoran Lanjutan:</span> <strong class="font-num text-bdl-navy">Rp1.000</strong></div>
                            <div class="flex justify-between"><span>Buku Tabungan:</span> <strong class="text-bdl-navy">Atas Nama Siswa</strong></div>
                        </div>
                    </div>
                    <div class="pt-5 mt-6 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('services.branches') }}" class="text-xs font-bold text-bdl-primary hover:text-bdl-navy transition">Buka Rekening &rarr;</a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:border-bdl-primary hover:shadow-md transition duration-200">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-[#D6E4F0]/50 text-bdl-navy">
                                Tabungan Berencana
                            </span>
                            <span class="text-xs font-num font-bold text-bdl-primary bg-sky-50 px-2 py-0.5 rounded border border-sky-200">
                                Target Finansial
                            </span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-bdl-navy">Tabungan Kurban & Hari Raya</h3>
                            <p class="text-xs text-slate-600 leading-relaxed mt-1">
                                Solusi perencanaan dana ibadah kurban dan perayaan Idul Fitri dengan sistem setoran periodik yang teratur dan aman.
                            </p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl space-y-2 text-xs text-slate-600">
                            <div class="flex justify-between"><span>Setoran Rutin:</span> <strong class="font-num text-bdl-navy">Fleksibel</strong></div>
                            <div class="flex justify-between"><span>Jangka Waktu:</span> <strong class="text-bdl-navy">12 Bulan</strong></div>
                            <div class="flex justify-between"><span>Pencairan Dana:</span> <strong class="text-emerald-600">Menjelang Hari Raya</strong></div>
                        </div>
                    </div>
                    <div class="pt-5 mt-6 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('services.branches') }}" class="text-xs font-bold text-bdl-primary hover:text-bdl-navy transition">Buka Rekening &rarr;</a>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 2. Keunggulan Menabung di BDL -->
    <section id="keunggulan" class="scroll-mt-36 p-8 lg:p-12 rounded-3xl bg-slate-50 border border-slate-200 space-y-8">
        <div class="max-w-2xl space-y-2">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Fasilitas & Manfaat</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy">Mengapa Menabung di Bank Daerah Lamongan?</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Memberikan kepastian rasa aman, transparansi buku tabungan, dan jangkauan kantor yang dekat dengan tempat usaha Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h4 class="text-base font-bold text-bdl-navy">Aman Dijamin LPS</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Setiap rupiah saldo tabungan Anda tercatat resmi dan dijamin keamanannya oleh Lembaga Penjamin Simpanan (LPS).
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-bdl-primary flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h4 class="text-base font-bold text-bdl-navy">Bebas Biaya Bulanan</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Saldo simpanan Anda tidak akan tergerus oleh biaya administrasi bulanan tersembunyi.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-bdl-primary flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h4 class="text-base font-bold text-bdl-navy">Layanan Jemput Bola</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Petugas lapangan kami siap melayani setoran tabungan harian langsung di tempat usaha atau toko Anda di pasar.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-bdl-primary flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h4 class="text-base font-bold text-bdl-navy">Jaringan Luas</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Setor dan tarik tunai dapat dilakukan di seluruh kantor cabang dan kantor kas kami di Kabupaten Lamongan.
                </p>
            </div>
        </div>
    </section>

    <!-- 3. Persyaratan Pembukaan Rekening -->
    <section id="persyaratan" class="scroll-mt-36 space-y-8">
        <div class="border-b border-slate-200 pb-4">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Panduan Pembukaan</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy mt-1">Syarat & Ketentuan Membuka Tabungan</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">U</div>
                    <h4 class="font-bold text-sm text-bdl-navy">Nasabah Umum (Perorangan)</h4>
                </div>
                <ul class="space-y-2 text-slate-600 list-disc list-inside leading-relaxed">
                    <li>Fotokopi Kartu Tanda Penduduk (e-KTP) yang masih berlaku.</li>
                    <li>Mengisi dan menandatangani formulir pembukaan rekening tabungan.</li>
                    <li>Setoran awal pembukaan rekening mulai dari Rp20.000,-.</li>
                    <li>Mendapatkan buku tabungan resmi atas nama pemilik rekening.</li>
                </ul>
            </div>

            <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm space-y-3">
                <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-[#D6E4F0]/60 text-bdl-primary flex items-center justify-center font-bold">P</div>
                    <h4 class="font-bold text-sm text-bdl-navy">Nasabah Pelajar (SimPel)</h4>
                </div>
                <ul class="space-y-2 text-slate-600 list-disc list-inside leading-relaxed">
                    <li>Fotokopi Kartu Pelajar / Surat Keterangan dari Sekolah.</li>
                    <li>Fotokopi Akta Kelahiran siswa dan Kartu Keluarga (KK).</li>
                    <li>Fotokopi e-KTP salah satu orang tua / wali murid.</li>
                    <li>Setoran awal pembukaan sangat ringan mulai Rp5.000,-.</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Banner Transisi ke Deposito & Kredit -->
    <section class="p-8 rounded-3xl bg-bdl-navy text-white flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-1.5">
            <span class="text-xs font-bold text-bdl-soft uppercase tracking-wider block">Portofolio Finansial Lainnya</span>
            <h3 class="text-xl font-bold">Ingin Mengembangkan Dana dengan Bunga Lebih Optimal?</h3>
            <p class="text-xs text-slate-300 max-w-xl leading-relaxed">
                Pelajari produk Deposito Berjangka dengan imbal hasil penjaminan LPS aktif atau ajukan Kredit Modal Kerja untuk ekspansi bisnis Anda.
            </p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('products.deposit') }}" class="px-5 py-2.5 rounded-lg text-xs font-bold text-bdl-navy bg-white hover:bg-bdl-soft transition shadow">
                Simulasi Deposito &rarr;
            </a>
            <a href="{{ route('products.loan') }}" class="px-5 py-2.5 rounded-lg text-xs font-bold text-white bg-white/10 hover:bg-white/20 border border-white/20 transition">
                Simulasi Kredit &rarr;
            </a>
        </div>
    </section>

</div>
@endsection