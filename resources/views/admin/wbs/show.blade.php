@extends('layouts.admin')

@section('title', 'Investigasi WBS ' . $report->registration_code)
@section('page_title', 'Investigasi Dugaan Pelanggaran (WBS)')
@section('page_subtitle', 'Telaah bukti indikasi kecurangan dan audit forensik internal SKAI.')

@section('content')
<div class="space-y-6">

    <div>
        <a href="{{ route('admin.wbs.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#0066B2] hover:underline">
            <span>&larr;</span> Kembali ke Daftar Laporan WBS
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Kolom Kiri: Kronologi & Bukti Laporan -->
        <div class="lg:col-span-7 space-y-6">
            
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Kode Registrasi Rahasia</span>
                        <h2 class="text-xl font-extrabold font-mono text-rose-700">{{ $report->registration_code }}</h2>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] text-slate-400 block">Waktu Didaftarkan</span>
                        <span class="text-xs font-mono font-semibold text-slate-700">{{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d F Y, H:i') }} WIB</span>
                    </div>
                </div>

                <!-- Status Identitas Pelapor -->
                <div>
                    <h3 class="text-xs font-bold text-[#0A2540] uppercase tracking-wider mb-2">1. Status Pelapor</h3>
                    <div class="p-4 rounded-2xl border {{ $report->is_anonymous ? 'bg-slate-50 border-slate-200 text-slate-600' : 'bg-blue-50/50 border-blue-200 text-[#0A2540]' }} text-xs">
                        @if($report->is_anonymous)
                            <div class="flex items-center gap-2 font-bold text-slate-700">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                <span>Laporan Disampaikan Secara ANONIM</span>
                            </div>
                            <span class="text-[11px] text-slate-400 block mt-1">Identitas pelapor dilindungi penuh dan tidak tercatat di basis data.</span>
                        @else
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <span class="text-slate-400 text-[11px] block">Nama Pelapor:</span>
                                    <strong class="text-slate-800">{{ $report->reporter_name }}</strong>
                                </div>
                                <div>
                                    <span class="text-slate-400 text-[11px] block">Kontak Rahasia:</span>
                                    <span class="font-mono text-slate-800">{{ $report->reporter_contact ?? '-' }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pokok Pelanggaran & Pihak Terlapor -->
                <div>
                    <h3 class="text-xs font-bold text-[#0A2540] uppercase tracking-wider mb-2">2. Pihak Terlapor & Lokasi Kejadian</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs bg-[#F4F7FC] p-4 rounded-2xl border border-slate-100">
                        <div>
                            <span class="text-slate-400 text-[11px] block">Klasifikasi Dugaan:</span>
                            <strong class="text-rose-700">{{ str_replace('_', ' ', $report->violation_type) }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[11px] block">Tanggal / Periode Peristiwa:</span>
                            <span class="font-mono font-semibold text-slate-800">{{ \Carbon\Carbon::parse($report->incident_date)->translatedFormat('d F Y') }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[11px] block">Pihak yang Terlibat:</span>
                            <strong class="text-slate-800">{{ $report->involved_parties }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[11px] block">Unit Kerja / Cabang:</span>
                            <span class="text-slate-800">{{ $report->incident_location }}</span>
                        </div>
                    </div>
                </div>

                <!-- Kronologi -->
                <div>
                    <h3 class="text-xs font-bold text-[#0A2540] uppercase tracking-wider mb-2">3. Uraian Kronologi Dugaan Pelanggaran</h3>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-xs text-slate-700 leading-relaxed whitespace-pre-line">
                        {{ $report->chronology }}
                    </div>
                </div>

                <!-- Bukti Dokumen -->
                <div>
                    <h3 class="text-xs font-bold text-[#0A2540] uppercase tracking-wider mb-2">4. Berkas Lampiran / Bukti Forensik</h3>
                    @if($report->evidence_file_url)
                        <a href="{{ asset($report->evidence_file_url) }}" target="_blank" 
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-50 hover:bg-rose-700 hover:text-white text-rose-700 font-bold rounded-xl transition text-xs border border-rose-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Unduh Bukti Pelanggaran (PDF / ZIP / Gambar)</span>
                        </a>
                    @else
                        <span class="text-xs text-slate-400 italic">Pelapor tidak melampirkan berkas fisik.</span>
                    @endif
                </div>

            </div>

        </div>

        <!-- Kolom Kanan: Form Audit SKAI -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-rose-600 block">Tindakan Satuan Kerja Audit Intern</span>
                    <h3 class="text-base font-extrabold text-[#0A2540]">Status Investigasi & Berita Acara</h3>
                </div>

                <form action="{{ route('admin.wbs.update', $report->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">Status Penanganan Kasus</label>
                        <select name="status" required class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-semibold text-slate-800">
                            <option value="SUBMITTED" {{ $report->status === 'SUBMITTED' ? 'selected' : '' }}>SUBMITTED (Menunggu Telaah Awal SKAI)</option>
                            <option value="INVESTIGATING" {{ $report->status === 'INVESTIGATING' ? 'selected' : '' }}>INVESTIGATING (Audit Investigasi & Pemeriksaan Bukti)</option>
                            <option value="CLOSED" {{ $report->status === 'CLOSED' ? 'selected' : '' }}>CLOSED (Pemeriksaan Selesai / Kasus Ditutup)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">
                            Catatan Audit & Rekomendasi SKAI
                        </label>
                        <textarea name="investigation_notes" rows="7" 
                                  placeholder="Tuliskan temuan audit, hasil pemanggilan saksi/terlapor, serta rekomendasi sanksi atau pelimpahan hukum ke Direksi..."
                                  class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-3.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition leading-relaxed text-slate-800">{{ old('investigation_notes', $report->investigation_notes) }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-white bg-rose-700 hover:bg-rose-800 transition shadow-md shadow-rose-700/20">
                        Simpan Hasil Pemeriksaan SKAI
                    </button>
                </form>
            </div>

            <!-- Pedoman Anti-Fraud BPR -->
            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 text-xs space-y-2 text-slate-600">
                <span class="font-bold text-[#0A2540] block">Pedoman Kebijakan Anti-Fraud:</span>
                <p class="text-[11px] leading-relaxed text-slate-500">
                    Setiap indikasi fraud material wajib dilaporkan kepada Direksi Kepatuhan dan Dewan Komisaris paling lambat 3 hari kerja sejak audit awal diselesaikan.
                </p>
            </div>

        </div>

    </div>

</div>
@endsection