@extends('layouts.app')

@section('title', 'Pelacakan Status Tiket Pengaduan | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section Minimalis -->
<section class="bg-bdl-navy text-white pt-36 pb-14 border-b border-white/10">
    <div class="max-w-4xl mx-auto px-4 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
            Sistem Pemantauan Terpadu
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight">
            Lacak Status Tiket Pengaduan
        </h1>
        <p class="text-white/80 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
            Pantau perkembangan tindak lanjut pengaduan transaksi Anda secara real-time berdasarkan nomor tiket resmi.
        </p>

        <!-- Form Input Pencarian Tiket -->
        <form action="{{ route('services.ticket') }}" method="GET" class="max-w-md mx-auto pt-4 flex gap-2">
            <input type="text" name="ticket" value="{{ $ticketCode }}" required 
                   placeholder="Contoh: BDL-20261107-XXXX"
                   class="w-full text-xs text-slate-800 bg-white rounded-xl px-4 py-3 font-num uppercase tracking-wider focus:outline-none shadow-sm">
            <button type="submit" class="px-6 py-3 rounded-xl text-xs font-bold text-bdl-navy bg-white hover:bg-bdl-soft transition shadow shrink-0">
                Lacak
            </button>
        </form>
    </div>
</section>

<!-- Konten Hasil Pelacakan Tiket -->
<div class="max-w-4xl mx-auto px-4 lg:px-8 py-16">

    @if(session('success'))
        <div class="mb-8 p-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 space-y-2 shadow-sm">
            <div class="flex items-center gap-2 font-bold text-sm text-emerald-800">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Pengaduan Berhasil Terkirim!</span>
            </div>
            <p class="text-xs leading-relaxed text-emerald-700">
                {{ session('success') }}
            </p>
            <div class="p-3 bg-white rounded-xl border border-emerald-200 inline-block font-num font-bold text-lg text-bdl-navy tracking-wider">
                {{ $ticketCode }}
            </div>
        </div>
    @endif

    @if($ticketCode && $complaint)
        @php
            $status = $complaint->status;
            $badgeColor = match($status) {
                'PENDING' => 'bg-amber-100 text-amber-800 border-amber-200',
                'IN_PROGRESS' => 'bg-blue-100 text-blue-800 border-blue-200',
                'RESOLVED' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                'REJECTED' => 'bg-rose-100 text-rose-800 border-rose-200',
                default => 'bg-slate-100 text-slate-800 border-slate-200'
            };
            $statusText = match($status) {
                'PENDING' => 'Menunggu Verifikasi Kepatuhan',
                'IN_PROGRESS' => 'Sedang Diproses & Dikonfirmasi Cabang',
                'RESOLVED' => 'Pengaduan Telah Selesai Ditindaklanjuti',
                'REJECTED' => 'Pengaduan Ditolak (Tidak Memenuhi Syarat)',
                default => $status
            };
        @endphp

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden space-y-8 p-6 sm:p-10">
            <!-- Header Kartu Tiket -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                <div>
                    <span class="text-xs font-bold text-slate-400 block uppercase">Nomor Tiket Pengaduan:</span>
                    <h2 class="text-2xl font-extrabold font-num text-bdl-navy mt-0.5 tracking-wider">
                        {{ $complaint->ticket_number }}
                    </h2>
                </div>
                <div>
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $badgeColor }} inline-block">
                        {{ $statusText }}
                    </span>
                </div>
            </div>

            <!-- Timeline Tahapan Penanganan -->
            <div class="space-y-4">
                <span class="text-xs font-bold text-bdl-navy uppercase tracking-wider block">Progres Penanganan:</span>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                    <div class="p-4 rounded-2xl {{ in_array($status, ['PENDING', 'IN_PROGRESS', 'RESOLVED']) ? 'bg-sky-50 border border-bdl-primary/30 text-bdl-navy' : 'bg-slate-50 text-slate-400' }}">
                        <span class="font-bold block text-xs">1. Diterima Sistem</span>
                        <span class="text-[11px] font-num">{{ \Carbon\Carbon::parse($complaint->created_at)->translatedFormat('d M Y, H:i') }} WIB</span>
                    </div>

                    <div class="p-4 rounded-2xl {{ in_array($status, ['IN_PROGRESS', 'RESOLVED']) ? 'bg-sky-50 border border-bdl-primary/30 text-bdl-navy' : 'bg-slate-50 text-slate-400' }}">
                        <span class="font-bold block text-xs">2. Investigasi & Verifikasi</span>
                        <span class="text-[11px]">{{ in_array($status, ['IN_PROGRESS', 'RESOLVED']) ? 'Sedang Ditinjau Petugas' : 'Menunggu antrean' }}</span>
                    </div>

                    <div class="p-4 rounded-2xl {{ $status === 'RESOLVED' ? 'bg-emerald-50 border border-emerald-300 text-emerald-900 font-bold' : ($status === 'REJECTED' ? 'bg-rose-50 border border-rose-200 text-rose-800' : 'bg-slate-50 text-slate-400') }}">
                        <span class="font-bold block text-xs">3. Hasil Akhir</span>
                        <span class="text-[11px]">{{ $status === 'RESOLVED' ? 'Penyelesaian Diberikan' : ($status === 'REJECTED' ? 'Ditolak' : 'Menunggu hasil') }}</span>
                    </div>
                </div>
            </div>

            <!-- Detail Pengaduan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs text-slate-700 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                <div>
                    <span class="text-slate-400 block text-[11px]">Nama Nasabah:</span>
                    <strong class="text-slate-800 font-medium">{{ $complaint->customer_name }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block text-[11px]">Kategori Produk:</span>
                    <strong class="text-bdl-navy uppercase font-bold">{{ $complaint->category }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block text-[11px]">Pokok Masalah:</span>
                    <strong class="text-slate-800">{{ $complaint->subject }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block text-[11px]">Nomor Rekening Terkait:</span>
                    <span class="font-num text-slate-800 font-semibold">{{ $complaint->account_number ?? '-' }}</span>
                </div>
                <div class="sm:col-span-2 pt-2 border-t border-slate-200/60">
                    <span class="text-slate-400 block text-[11px]">Uraian Kendala:</span>
                    <p class="text-slate-700 leading-relaxed mt-1 text-xs">
                        {{ $complaint->description }}
                    </p>
                </div>
            </div>

            <!-- Tanggapan Resmi dari Bank (Jika Ada) -->
            @if(isset($complaint->resolution_notes) && $complaint->resolution_notes)
                <div class="p-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-900 space-y-2">
                    <span class="font-bold text-emerald-800 block uppercase text-[11px]">Tanggapan / Solusi Resmi Bank:</span>
                    <p class="leading-relaxed text-xs">
                        {{ $complaint->resolution_notes }}
                    </p>
                </div>
            @endif

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <a href="{{ route('services.complaint') }}" class="font-bold text-bdl-primary hover:underline">
                    &larr; Buat Pengaduan Baru
                </a>
                <span>Layanan Resmi BDL Peduli</span>
            </div>
        </div>

    @elseif($ticketCode)
        <!-- Jika Tiket Tidak Ditemukan -->
        <div class="bg-white rounded-3xl border border-slate-200 p-10 text-center space-y-4 shadow-sm">
            <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center mx-auto font-bold text-lg">!</div>
            <h3 class="text-base font-bold text-bdl-navy">Nomor Tiket Tidak Ditemukan</h3>
            <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                Nomor tiket <strong>{{ $ticketCode }}</strong> tidak terdaftar pada sistem kami. Pastikan format tiket yang Anda masukkan benar (contoh: <code>BDL-20261107-XXXX</code>).
            </p>
            <div class="pt-2">
                <a href="{{ route('services.complaint') }}" class="inline-block px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-bdl-primary hover:bg-bdl-navy transition shadow">
                    Ajukan Pengaduan Baru &rarr;
                </a>
            </div>
        </div>
    @endif

</div>
@endsection