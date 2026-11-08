@extends('layouts.app')

@section('title', 'Karier & Rekrutmen | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section -->
<section class="relative min-h-[360px] lg:min-h-[420px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1920&q=80" 
         alt="Karier Bank Daerah Lamongan" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.38]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Peluang Berkarier
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Bertumbuh Bersama Bank Daerah Lamongan
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                Jadilah bagian dari insan perbankan yang profesional, berintegritas, dan berkontribusi nyata dalam memajukan perekonomian daerah serta pelaku UMKM.
            </p>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Tab -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <a href="#posisi-tersedia" class="text-bdl-primary font-bold transition whitespace-nowrap">Lowongan Pekerjaan</a>
            <a href="#budaya-kerja" class="hover:text-bdl-primary transition whitespace-nowrap">Budaya & Lingkungan Kerja</a>
            <a href="#tahapan-seleksi" class="hover:text-bdl-primary transition whitespace-nowrap">Tahapan Seleksi</a>
            <a href="#peringatan-penipuan" class="text-rose-600 hover:text-rose-700 transition whitespace-nowrap font-medium">Waspada Penipuan Rekrutmen</a>
        </div>
    </div>
</nav>

<!-- Konten Utama Karier -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-16">

    <!-- 1. Daftar Lowongan Kerja Tersedia -->
    <section id="posisi-tersedia" class="scroll-mt-36 space-y-8">
        <div class="border-b border-slate-200 pb-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Penerimaan Pegawai</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy mt-1">Posisi yang Sedang Dibuka</h2>
                <p class="text-xs text-slate-500 mt-1">Pilih formasi jabatan yang sesuai dengan kualifikasi dan kompetensi Anda.</p>
            </div>

            <!-- Form Pencarian Posisi -->
            <form action="{{ route('services.career') }}" method="GET" class="flex items-center gap-2 max-w-xs w-full">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari posisi pekerjaan..." 
                       class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-bdl-primary">
                <button type="submit" class="px-4 py-2.5 rounded-lg text-xs font-bold text-white bg-bdl-primary hover:bg-bdl-navy transition shrink-0">
                    Cari
                </button>
                @if(request('q'))
                    <a href="{{ route('services.career') }}" class="text-xs font-bold text-rose-600 hover:underline">Reset</a>
                @endif
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($vacancies as $job)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:border-bdl-primary hover:shadow-md transition duration-200 space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-[#D6E4F0]/60 text-bdl-navy">
                                Rekrutmen Terbuka
                            </span>
                            <span class="text-slate-400 font-medium text-[11px]">
                                Penempatan Lamongan
                            </span>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-bdl-navy leading-snug">
                                {{ $job->title }}
                            </h3>
                        </div>

                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                            {{ $job->description }}
                        </p>

                        <div class="p-3 bg-slate-50 rounded-xl space-y-1 text-[11px] text-slate-600">
                            <div class="flex justify-between">
                                <span>Batas Pendaftaran:</span>
                                <strong class="font-num text-rose-600">
                                    {{ \Carbon\Carbon::parse($job->deadline)->translatedFormat('d F Y') }}
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('services.career.detail', $job->slug) }}" class="text-xs font-bold text-bdl-primary hover:text-bdl-navy transition flex items-center gap-1">
                            <span>Lihat Kualifikasi & Lamar</span>
                            <span class="text-sm font-bold">&rarr;</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
                    <svg class="w-12 h-12 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <h3 class="text-sm font-bold text-bdl-navy">Saat Ini Belum Ada Lowongan Terbuka</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                        Terima kasih atas minat Anda. Informasi rekrutmen pegawai baru akan selalu diperbarui di laman ini dan diumumkan melalui akun media sosial resmi bank.
                    </p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 2. Budaya & Nilai Kerja -->
    <section id="budaya-kerja" class="scroll-mt-36 p-8 lg:p-12 rounded-3xl bg-slate-50 border border-slate-200 space-y-8">
        <div class="max-w-2xl space-y-2">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Nilai Organisasi</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-bdl-navy">Lingkungan Kerja yang Sehat & Suportif</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Kami berkomitmen membangun tempat kerja yang mengedepankan kesetaraan, integritas, dan pengembangan kompetensi berkelanjutan.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-bdl-primary flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <h4 class="text-base font-bold text-bdl-navy">Jenjang Karier Terbuka</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Apresiasi berbasis kinerja dan peluang promosi jabatan yang transparan di seluruh jaringan kantor operasional.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-bdl-primary flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h4 class="text-base font-bold text-bdl-navy">Pelatihan & Sertifikasi</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Dukungan pelatihan berkala dan fasilitas sertifikasi profesi perbankan (LSPP / BNSP) bagi seluruh insan bank.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-bdl-primary flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h4 class="text-base font-bold text-bdl-navy">Semangat Kekeluargaan</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Kolaborasi tim yang kuat dengan semangat melayani kebutuhan masyarakat ekonomi riil Kabupaten Lamongan.
                </p>
            </div>
        </div>
    </section>

    <!-- 3. Tahapan Seleksi -->
    <section id="tahapan-seleksi" class="scroll-mt-36 space-y-6">
        <div class="border-b border-slate-200 pb-4">
            <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Alur Penerimaan</span>
            <h3 class="text-xl font-bold text-bdl-navy mt-1">Tahapan Seleksi Rekrutmen</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 text-xs">
            <div class="p-5 rounded-2xl bg-white border border-slate-200 space-y-2">
                <span class="font-num font-extrabold text-base text-bdl-primary block">01</span>
                <strong class="text-slate-800 block text-xs">Seleksi Administrasi</strong>
                <p class="text-[11px] text-slate-500">Pemeriksaan kelengkapan dokumen dan kesesuaian kualifikasi berkas lamaran.</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200 space-y-2">
                <span class="font-num font-extrabold text-base text-bdl-primary block">02</span>
                <strong class="text-slate-800 block text-xs">Tes Potensi & Psikotes</strong>
                <p class="text-[11px] text-slate-500">Ujian pengetahuan dasar perbankan, numerik, dan tes kepribadian.</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200 space-y-2">
                <span class="font-num font-extrabold text-base text-bdl-primary block">03</span>
                <strong class="text-slate-800 block text-xs">Wawancara Kompetensi</strong>
                <p class="text-[11px] text-slate-500">Pendalaman kompetensi teknis bersama pimpinan divisi operasional.</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200 space-y-2">
                <span class="font-num font-extrabold text-base text-emerald-600 block">04</span>
                <strong class="text-slate-800 block text-xs">Tes Kesehatan & Penawaran</strong>
                <p class="text-[11px] text-slate-500">Pemeriksaan medis (MCU) dan penandatanganan perjanjian kerja.</p>
            </div>
        </div>
    </section>

    <!-- 4. Peringatan Penipuan Rekrutmen -->
    <section id="peringatan-penipuan" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-rose-50 border border-rose-200 text-rose-900 space-y-2">
        <div class="flex items-center gap-2 font-bold text-sm text-rose-800">
            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>Himbauan Waspada Penipuan Rekrutmen!</span>
        </div>
        <p class="text-xs text-rose-800 leading-relaxed">
            Proses rekrutmen pegawai pada <strong>{{ $profile->name ?? 'PT BPR Bank Daerah Lamongan (Perseroda)' }}</strong> bersifat <strong>GRATIS dan TIDAK PERNAH memungut biaya apapun</strong>, baik biaya pendaftaran, akomodasi perjalanan, tiket transportasi, maupun biaya seragam. Seluruh pengumuman resmi hanya disampaikan melalui situs web ini dan kanal resmi bank.
        </p>
    </section>

</div>
@endsection