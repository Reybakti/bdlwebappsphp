@extends('layouts.admin')

@section('title', 'Perbarui Laporan ' . $report->title)
@section('page_title', 'Perbarui Laporan Publikasi')
@section('page_subtitle', 'Pembaruan data rincian atau penggantian berkas PDF publikasi.')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div>
        <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#0066B2] hover:underline">
            <span>&larr;</span> Kembali ke Daftar Laporan
        </a>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-3">
            <h2 class="text-base font-extrabold text-[#0A2540]">Ubah Dokumen Laporan</h2>
            <p class="text-xs text-slate-400">Kosongkan kolom berkas PDF jika tidak ingin mengubah berkas yang sudah ada.</p>
        </div>

        @if($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.reports.update', $report->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-bold text-slate-700 mb-1">Judul Dokumen Publikasi <span class="text-rose-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $report->title) }}" required 
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Jenis Laporan <span class="text-rose-500">*</span></label>
                    <select name="type" required class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                        <option value="TRIWULAN_1" {{ old('type', $report->type) === 'TRIWULAN_1' ? 'selected' : '' }}>Triwulan I (Maret)</option>
                        <option value="TRIWULAN_2" {{ old('type', $report->type) === 'TRIWULAN_2' ? 'selected' : '' }}>Triwulan II (Juni)</option>
                        <option value="TRIWULAN_3" {{ old('type', $report->type) === 'TRIWULAN_3' ? 'selected' : '' }}>Triwulan III (September)</option>
                        <option value="TRIWULAN_4" {{ old('type', $report->type) === 'TRIWULAN_4' ? 'selected' : '' }}>Triwulan IV (Desember)</option>
                        <option value="TAHUNAN_AUDITED" {{ old('type', $report->type) === 'TAHUNAN_AUDITED' ? 'selected' : '' }}>Tahunan Diaudit (KAP)</option>
                        <option value="GCG" {{ old('type', $report->type) === 'GCG' ? 'selected' : '' }}>Laporan Tata Kelola (GCG)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tahun Buku <span class="text-rose-500">*</span></label>
                    <input type="number" name="year" value="{{ old('year', $report->year) }}" required min="2010" max="{{ date('Y') + 1 }}"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Tanggal Publikasi Resmi <span class="text-rose-500">*</span></label>
                <input type="date" name="published_at" value="{{ old('published_at', \Carbon\Carbon::parse($report->published_at)->format('Y-m-d')) }}" required 
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Ganti Berkas PDF (Opsional, Maksimal 15 MB)</label>
                <input type="file" name="pdf_file" accept=".pdf" 
                       class="w-full text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0066B2]/10 file:text-[#0066B2] hover:file:bg-[#0066B2]/20 cursor-pointer border border-slate-200 rounded-xl p-2 bg-[#F4F7FC]">
                <div class="mt-2 text-[11px] text-slate-500 flex items-center gap-2">
                    <span>Berkas saat ini:</span>
                    <a href="{{ asset($report->file_url) }}" target="_blank" class="font-bold text-[#0066B2] hover:underline">
                        Buka PDF Aktif &rarr;
                    </a>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.reports.index') }}" class="px-4 py-2.5 text-slate-500 hover:text-slate-800 transition font-bold">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-[#0066B2] hover:bg-[#0A2540] text-white font-bold rounded-xl transition shadow-md shadow-[#0066B2]/20">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection