@extends('layouts.app')

@section('title', 'Layanan Pengaduan Konsumen (POJK 22/2023) | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section -->
<section class="relative min-h-[340px] lg:min-h-[380px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1556742049-0a67c5574f73?auto=format&fit=crop&w=1920&q=80" 
         alt="Layanan Pengaduan Konsumen Bank Daerah Lamongan" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.38]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[11px] font-semibold text-bdl-soft tracking-wider uppercase">
                Perlindungan Konsumen
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Layanan Pengaduan Nasabah
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                Penyampaian keberatan atau keluhan transaksi perbankan secara resmi sesuai POJK No. 22/2023. Setiap laporan diproses dengan jaminan kerahasiaan data dan nomor pelacakan tiket mandiri.
            </p>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Tab -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <span class="text-bdl-primary font-bold border-b-2 border-bdl-primary pb-1 whitespace-nowrap">Form Pengaduan Online</span>
            <a href="{{ route('services.ticket') }}" class="hover:text-bdl-primary transition whitespace-nowrap font-medium text-slate-600">Lacak Status Tiket Pengaduan &rarr;</a>
            <a href="{{ route('services.wbs') }}" class="hover:text-rose-600 transition whitespace-nowrap font-medium text-slate-400">Whistleblowing System (WBS)</a>
        </div>
    </div>
</nav>

<!-- Konten Utama Form & Alur SOP -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        
        <!-- Formulir Pengaduan (Kolom Kiri) -->
        <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm space-y-8">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold text-bdl-primary uppercase tracking-wider block">Formulir Resmi</span>
                <h2 class="text-2xl font-extrabold text-bdl-navy mt-1">Sampaikan Pengaduan Anda</h2>
                <p class="text-xs text-slate-500 mt-1">
                    Isi data diri dan kronologi masalah dengan lengkap dan benar untuk mempermudah verifikasi tim kepatuhan kami.
                </p>
            </div>

            @if($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                    <strong class="font-bold block">Mohon periksa kembali formulir Anda:</strong>
                    <ul class="list-disc list-inside space-y-0.5 text-[11px]">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('services.complaint.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Informasi Pelapor -->
                <div class="space-y-4">
                    <h3 class="text-xs font-bold text-bdl-navy uppercase tracking-wider border-b border-slate-100 pb-2">
                        1. Data Identitas Nasabah
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Nama Lengkap (Sesuai e-KTP) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="customer_name" value="{{ old('customer_name') }}" required 
                                   placeholder="Contoh: Ahmad Fauzi"
                                   class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-bdl-primary focus:bg-white transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Nomor Induk Kependudukan (NIK 16 Digit) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nik" value="{{ old('nik') }}" required maxlength="16"
                                   placeholder="16 digit angka NIK"
                                   class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-num focus:outline-none focus:border-bdl-primary focus:bg-white transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Nomor WhatsApp / Telepon Aktif <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required 
                                   placeholder="Contoh: 081234567890"
                                   class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-num focus:outline-none focus:border-bdl-primary focus:bg-white transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Alamat Email (Opsional)
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   placeholder="nama@email.com"
                                   class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-bdl-primary focus:bg-white transition">
                        </div>
                    </div>
                </div>

                <!-- Informasi Rekening & Masalah -->
                <div class="space-y-4 pt-2">
                    <h3 class="text-xs font-bold text-bdl-navy uppercase tracking-wider border-b border-slate-100 pb-2">
                        2. Rincian Pengaduan
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Kategori Produk / Layanan <span class="text-rose-500">*</span>
                            </label>
                            <select name="category" required 
                                    class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-bdl-primary focus:bg-white transition">
                                <option value="">-- Pilih Kategori Masalah --</option>
                                <option value="TABUNGAN" {{ old('category') == 'TABUNGAN' ? 'selected' : '' }}>Tabungan (Buku Tabungan / Mutasi / Biaya)</option>
                                <option value="DEPOSITO" {{ old('category') == 'DEPOSITO' ? 'selected' : '' }}>Deposito (Bilyet / Bunga / Pencairan)</option>
                                <option value="KREDIT" {{ old('category') == 'KREDIT' ? 'selected' : '' }}>Kredit & Pembiayaan (Angsuran / Agunan / Pelunasan)</option>
                                <option value="LAYANAN_KASIR" {{ old('category') == 'LAYANAN_KASIR' ? 'selected' : '' }}>Layanan Teller & Kantor Cabang</option>
                                <option value="LAINNYA" {{ old('category') == 'LAINNYA' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Nomor Rekening / Perjanjian Kredit (Jika Ada)
                            </label>
                            <input type="text" name="account_number" value="{{ old('account_number') }}" 
                                   placeholder="Contoh: 101.02.00xxx"
                                   class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-num focus:outline-none focus:border-bdl-primary focus:bg-white transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Pokok Masalah / Judul Pengaduan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required 
                               placeholder="Contoh: Selisih pencatatan setoran tabungan pada buku tabungan"
                               class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-bdl-primary focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Uraian Kronologi Pengaduan <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="description" rows="5" required 
                                  placeholder="Sebutkan tanggal kejadian, lokasi kantor layanan, petugas terkait, serta rincian kronologi secara jelas..."
                                  class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl p-4 focus:outline-none focus:border-bdl-primary focus:bg-white transition leading-relaxed">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Unggah Berkas / Bukti Pendukung (Opsional)
                        </label>
                        <input type="file" name="evidence_file" accept=".jpg,.jpeg,.png,.pdf" 
                               class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#D6E4F0]/60 file:text-bdl-navy hover:file:bg-[#D6E4F0] cursor-pointer">
                        <span class="text-[10px] text-slate-400 block mt-1">Format didukung: PDF, JPG, PNG (Maksimal 5 MB).</span>
                    </div>
                </div>

                <!-- Persetujuan PDP -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 space-y-2">
                    <label class="flex items-start gap-2.5 cursor-pointer">
                        <input type="checkbox" required class="mt-0.5 accent-bdl-primary w-4 h-4 rounded">
                        <span class="text-[11px] leading-relaxed">
                            Saya menyatakan bahwa data dan kronologi yang saya sampaikan adalah benar dan dapat dipertanggungjawabkan sesuai ketentuan hukum yang berlaku serta menyetujui pemrosesan data identitas sesuai UU No. 27/2022 (Pelindungan Data Pribadi).
                        </span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-xl text-xs font-bold text-white bg-bdl-primary hover:bg-bdl-navy transition shadow-md">
                        Kirim Pengaduan & Dapatkan Nomor Tiket
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Alur & SLA Penanganan (Kolom Kanan) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Box Cek Tiket Cepat -->
            <div class="bg-bdl-navy text-white rounded-3xl p-6 sm:p-7 shadow-sm space-y-4">
                <span class="text-[10px] font-bold uppercase tracking-wider text-bdl-soft block">Sudah Punya Tiket?</span>
                <h3 class="text-base font-bold">Lacak Status Pengaduan Anda</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Masukkan nomor tiket berformat <strong>BDL-YYYYMMDD-XXXX</strong> untuk memantau proses tindak lanjut penyelesaian pengaduan Anda.
                </p>
                <form action="{{ route('services.ticket') }}" method="GET" class="space-y-3 pt-1">
                    <input type="text" name="ticket" required placeholder="BDL-20261107-XXXX" 
                           class="w-full text-xs text-slate-900 bg-white rounded-xl px-4 py-2.5 font-num uppercase tracking-wider focus:outline-none">
                    <button type="submit" class="w-full py-2.5 rounded-xl text-xs font-bold text-bdl-navy bg-bdl-soft hover:bg-white transition shadow">
                        Cek Status Pengaduan &rarr;
                    </button>
                </form>
            </div>

            <!-- Box Standar Alur SOP POJK 22/2023 -->
            <div class="bg-slate-50 rounded-3xl border border-slate-200 p-6 sm:p-7 space-y-4">
                <h4 class="text-xs font-bold text-bdl-navy uppercase tracking-wider border-b border-slate-200 pb-2">
                    Standar Waktu Penyelesaian (SLA)
                </h4>
                
                <div class="space-y-3 text-xs">
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-lg bg-[#D6E4F0]/60 text-bdl-primary font-bold flex items-center justify-center text-[11px] shrink-0 font-num">1</span>
                        <div>
                            <strong class="text-slate-800 block text-xs">Pengaduan Lisan</strong>
                            <p class="text-[11px] text-slate-500">Maksimal diselesaikan dalam 5 (lima) hari kerja.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-lg bg-[#D6E4F0]/60 text-bdl-primary font-bold flex items-center justify-center text-[11px] shrink-0 font-num">2</span>
                        <div>
                            <strong class="text-slate-800 block text-xs">Pengaduan Tertulis</strong>
                            <p class="text-[11px] text-slate-500">Maksimal diselesaikan dalam 10 (sepuluh) hari kerja dan dapat diperpanjang maksimal 10 hari kerja sesuai POJK 22/2023.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-lg bg-[#D6E4F0]/60 text-bdl-primary font-bold flex items-center justify-center text-[11px] shrink-0 font-num">3</span>
                        <div>
                            <strong class="text-slate-800 block text-xs">Eskalasi ke OJK / LAPS SJK</strong>
                            <p class="text-[11px] text-slate-500">Apabila belum tercapai kesepakatan, nasabah dapat mengajukan sengketa ke LAPS SJK atau Kontak OJK 157.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection