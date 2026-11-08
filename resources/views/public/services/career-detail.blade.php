@extends('layouts.app')

@section('title', $vacancy->title . ' | Rekrutmen ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Header Banner Minimalis -->
<section class="bg-bdl-navy text-white pt-36 pb-12">
    <div class="max-w-4xl mx-auto px-4 lg:px-8 space-y-4">
        <div class="flex items-center gap-3 text-xs">
            <a href="{{ route('services.career') }}" class="text-slate-300 hover:text-white transition">&larr; Kembali ke Daftar Lowongan</a>
            <span class="text-white/40">/</span>
            <span class="text-bdl-soft font-bold uppercase tracking-wider">Rekrutmen Terbuka</span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight leading-tight">
            {{ $vacancy->title }}
        </h1>
        <div class="flex flex-wrap items-center gap-4 text-xs text-slate-300 pt-1 font-num">
            <span>Penempatan: Kantor Layanan Lamongan</span>
            <span>•</span>
            <span class="text-rose-300 font-semibold">Batas Pendaftaran: {{ \Carbon\Carbon::parse($vacancy->deadline)->translatedFormat('d F Y') }}</span>
        </div>
    </div>
</section>

<!-- Konten Rincian Kualifikasi & Tata Cara Lamar -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        
        <!-- Kolom Kiri: Deskripsi & Kualifikasi -->
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 space-y-6 shadow-sm">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-bdl-navy border-b border-slate-100 pb-2">Deskripsi Tugas & Tanggung Jawab</h2>
                    <div class="prose max-w-none text-slate-700 text-xs sm:text-sm leading-relaxed pt-3">
                        {!! nl2br(e($vacancy->description)) !!}
                    </div>
                </div>

                <div>
                    <h2 class="text-base sm:text-lg font-bold text-bdl-navy border-b border-slate-100 pb-2">Kualifikasi & Persyaratan Berkas</h2>
                    <div class="prose max-w-none text-slate-700 text-xs sm:text-sm leading-relaxed pt-3">
                        {!! nl2br(e($vacancy->requirements)) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Panduan Penyerahan Berkas -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-slate-50 rounded-3xl border border-slate-200 p-6 sm:p-7 space-y-5">
                <div class="border-b border-slate-200 pb-3">
                    <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Tata Cara Pengiriman</span>
                    <h3 class="text-base font-extrabold text-bdl-navy mt-0.5">Kirim Berkas Lamaran</h3>
                </div>

                <div class="space-y-4 text-xs text-slate-600 leading-relaxed">
                    <p>
                        Kirimkan berkas lamaran lengkap (Surat Lamaran, CV, Salinan e-KTP, Ijazah, Transkrip Nilai, dan Pasfoto terbaru) ke salah satu kanal berikut:
                    </p>

                    <!-- Opsi 1: Pengiriman Fisik -->
                    <div class="p-4 bg-white rounded-2xl border border-slate-200 space-y-1.5">
                        <span class="font-bold text-bdl-navy block text-xs">1. Pengiriman Langsung / Pos:</span>
                        <p class="text-[11px] text-slate-500">
                            <strong>Bagian SDM & Umum</strong><br>
                            {{ $profile->name ?? 'PT BPR Bank Daerah Lamongan (Perseroda)' }}<br>
                            {{ $profile->head_office_address ?? 'Jl. KH. Ahmad Dahlan No. 1, Lamongan, Jawa Timur' }}
                        </p>
                    </div>

                    <!-- Opsi 2: Email Resmi -->
                    <div class="p-4 bg-white rounded-2xl border border-slate-200 space-y-1.5">
                        <span class="font-bold text-bdl-navy block text-xs">2. Melalui Email Resmi:</span>
                        <p class="text-[11px] text-slate-500">
                            Kirimkan dokumen dalam 1 berkas PDF ke:<br>
                            <a href="mailto:{{ $profile->email ?? 'info@bdl.co.id' }}?subject=Lamaran%20Kerja%20-%20{{ urlencode($vacancy->title) }}" class="font-bold text-bdl-primary hover:underline">
                                {{ $profile->email ?? 'info@bdl.co.id' }}
                            </a><br>
                            <span class="text-[10px] text-slate-400">Subjek: Lamaran Kerja - {{ $vacancy->title }}</span>
                        </p>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="mailto:{{ $profile->email ?? 'info@bdl.co.id' }}?subject=Lamaran%20Kerja%20-%20{{ urlencode($vacancy->title) }}" 
                       class="block text-center w-full py-3 rounded-xl text-xs font-bold text-white bg-bdl-primary hover:bg-bdl-navy transition shadow">
                        Kirim via Email &rarr;
                    </a>
                </div>
            </div>

            <!-- Box Bantuan SDM -->
            <div class="p-6 rounded-3xl bg-bdl-navy text-white text-xs space-y-2">
                <span class="font-bold block text-sm">Pertanyaan Rekrutmen?</span>
                <p class="text-slate-300 text-[11px] leading-relaxed">
                    Hubungi bagian SDM kami pada hari kerja (Senin – Jumat, 08.00 – 15.00 WIB) di nomor telepon:
                </p>
                <div class="font-num font-bold text-bdl-soft text-sm pt-1">
                    {{ $profile->phone ?? '(0322) 321xxx' }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection