@extends('layouts.admin')

@section('title', 'Detail Tiket ' . $complaint->ticket_number)
@section('page_title', 'Tindak Lanjut Pengaduan')
@section('page_subtitle', 'Pemeriksaan kronologi, berkas pendukung, dan penetapan solusi bank.')

@section('content')
<div class="space-y-6">

    <!-- Tombol Kembali -->
    <div>
        <a href="{{ route('admin.complaints.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#0066B2] hover:underline">
            <span>&larr;</span> Kembali ke Daftar Pengaduan
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Kolom Kiri: Rincian Data Pelapor & Kronologi -->
        <div class="lg:col-span-7 space-y-6">
            
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                <!-- Header Tiket -->
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nomor Tiket Resmi</span>
                        <h2 class="text-xl font-extrabold font-mono text-[#0066B2]">{{ $complaint->ticket_number }}</h2>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] text-slate-400 block">Waktu Pengajuan</span>
                        <span class="text-xs font-mono font-semibold text-slate-700">{{ \Carbon\Carbon::parse($complaint->created_at)->translatedFormat('d F Y, H:i') }} WIB</span>
                    </div>
                </div>

                <!-- Identitas Nasabah -->
                <div>
                    <h3 class="text-xs font-bold text-[#0A2540] uppercase tracking-wider mb-3">1. Identitas Nasabah</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs bg-[#F4F7FC] p-4 rounded-2xl border border-slate-100">
                        <div>
                            <span class="text-slate-400 text-[11px] block">Nama Sesuai e-KTP:</span>
                            <strong class="text-slate-800">{{ $complaint->customer_name }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[11px] block">Nomor NIK:</span>
                            <span class="font-mono font-semibold text-slate-800">{{ $complaint->nik }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[11px] block">WhatsApp / Kontak:</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $complaint->phone) }}" target="_blank" class="font-mono font-bold text-emerald-600 hover:underline">
                                {{ $complaint->phone }} &rarr;
                            </a>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[11px] block">Email:</span>
                            <span class="text-slate-800">{{ $complaint->email ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Detail Kasus -->
                <div>
                    <h3 class="text-xs font-bold text-[#0A2540] uppercase tracking-wider mb-3">2. Uraian Masalah</h3>
                    <div class="space-y-3 text-xs">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 text-[11px] block">Kategori Produk:</span>
                                <strong class="text-[#0A2540] uppercase">{{ $complaint->category }}</strong>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 text-[11px] block">No. Rekening Terkait:</span>
                                <span class="font-mono font-bold text-slate-800">{{ $complaint->account_number ?? '-' }}</span>
                            </div>
                        </div>

                        <div>
                            <span class="text-slate-400 text-[11px] block mb-1">Pokok Permasalahan:</span>
                            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 font-bold text-slate-800">
                                {{ $complaint->subject }}
                            </div>
                        </div>

                        <div>
                            <span class="text-slate-400 text-[11px] block mb-1">Kronologi Kejadian:</span>
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-slate-700 leading-relaxed whitespace-pre-line">
                                {{ $complaint->description }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bukti Pendukung -->
                <div>
                    <h3 class="text-xs font-bold text-[#0A2540] uppercase tracking-wider mb-2">3. Berkas Bukti Pendukung</h3>
                    @if($complaint->evidence_file_url)
                        <a href="{{ asset($complaint->evidence_file_url) }}" target="_blank" 
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#F4F7FC] hover:bg-[#0066B2] hover:text-white text-[#0066B2] font-bold rounded-xl transition text-xs border border-slate-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Unduh / Lihat Berkas Bukti</span>
                        </a>
                    @else
                        <span class="text-xs text-slate-400 italic">Tidak ada lampiran dokumen.</span>
                    @endif
                </div>

            </div>

        </div>

        <!-- Kolom Kanan: Form Penetapan Solusi & Status Bank -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#0066B2] block">Tindak Lanjut Bank</span>
                    <h3 class="text-base font-extrabold text-[#0A2540]">Pembaruan Status & Tanggapan</h3>
                </div>

                <form action="{{ route('admin.complaints.update', $complaint->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">Status Pengaduan</label>
                        <select name="status" required class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-semibold text-slate-800">
                            <option value="PENDING" {{ $complaint->status === 'PENDING' ? 'selected' : '' }}>PENDING (Menunggu Verifikasi)</option>
                            <option value="IN_PROGRESS" {{ $complaint->status === 'IN_PROGRESS' ? 'selected' : '' }}>IN_PROGRESS (Sedang Dikonfirmasi ke Cabang)</option>
                            <option value="RESOLVED" {{ $complaint->status === 'RESOLVED' ? 'selected' : '' }}>RESOLVED (Selesai & Diberi Solusi)</option>
                            <option value="REJECTED" {{ $complaint->status === 'REJECTED' ? 'selected' : '' }}>REJECTED (Ditolak / Tidak Memenuhi Syarat)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">
                            Catatan Solusi / Tanggapan Resmi Bank
                        </label>
                        <textarea name="resolution_notes" rows="6" 
                                  placeholder="Tuliskan hasil investigasi, solusi yang disepakati, serta rincian penyelesaian masalah nasabah..."
                                  class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-3.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition leading-relaxed text-slate-800">{{ old('resolution_notes', $complaint->resolution_notes) }}</textarea>
                        <span class="text-[10px] text-slate-400 block mt-1">Catatan ini akan tampil secara transparan saat nasabah mengecek status tiket.</span>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-white bg-[#0066B2] hover:bg-[#0A2540] transition shadow-md shadow-[#0066B2]/20">
                        Simpan Tindak Lanjut
                    </button>
                </form>
            </div>

            <!-- Petunjuk SLA Kepatuhan POJK 22/2023 -->
            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 text-xs space-y-2 text-slate-600">
                <span class="font-bold text-[#0A2540] block">Ketentuan SLA POJK 22/2023:</span>
                <ul class="list-disc list-inside space-y-1 text-[11px] leading-relaxed text-slate-500">
                    <li>Pengaduan lisan wajib diselesaikan paling lama <strong>5 hari kerja</strong>.</li>
                    <li>Pengaduan tertulis diselesaikan maksimal <strong>10 hari kerja</strong> (dapat diperpanjang 10 hari kerja).</li>
                </ul>
            </div>

        </div>

    </div>

</div>
@endsection