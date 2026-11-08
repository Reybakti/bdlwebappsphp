@extends('layouts.admin')

@section('title', 'Ketetapan Bunga LPS Baru')
@section('page_title', 'Ketetapan Suku Bunga LPS Baru')
@section('page_subtitle', 'Masukkan besaran suku bunga penjaminan baru berdasarkan siaran pers resmi LPS.')

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    <div>
        <a href="{{ route('admin.lps.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#0066B2] hover:underline">
            <span>&larr;</span> Kembali ke Daftar Bunga LPS
        </a>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-3">
            <h2 class="text-base font-extrabold text-[#0A2540]">Formulir Penetapan Suku Bunga</h2>
            <p class="text-xs text-slate-400">Nilai yang diinput akan otomatis ditampilkan pada widget penjaminan di halaman publik.</p>
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

        <form action="{{ route('admin.lps.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Bunga Rupiah (IDR) % p.a. <span class="text-rose-500">*</span></label>
                    <input type="number" step="0.01" name="rate_idr" value="{{ old('rate_idr', '6.75') }}" required 
                           placeholder="6.75"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono font-bold text-slate-800 text-sm">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Bunga Valas % p.a. (Opsional)</label>
                    <input type="number" step="0.01" name="rate_valas" value="{{ old('rate_valas', '0.00') }}" 
                           placeholder="0.00"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800 text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Mulai Berlaku <span class="text-rose-500">*</span></label>
                    <input type="date" name="effective_start_date" value="{{ old('effective_start_date', date('Y-m-d')) }}" required 
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Berakhir Berlaku <span class="text-rose-500">*</span></label>
                    <input type="date" name="effective_end_date" value="{{ old('effective_end_date', date('Y-m-d', strtotime('+3 months'))) }}" required 
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_current" value="1" {{ old('is_current', '1') ? 'checked' : '' }} class="accent-[#0066B2] w-4 h-4 rounded">
                    <span class="text-slate-700 font-semibold">Terapkan langsung sebagai suku bunga acuan aktif utama bank</span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.lps.index') }}" class="px-4 py-2.5 text-slate-500 hover:text-slate-800 transition font-bold">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-[#0066B2] hover:bg-[#0A2540] text-white font-bold rounded-xl transition shadow-md shadow-[#0066B2]/20">
                    Simpan Ketetapan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection