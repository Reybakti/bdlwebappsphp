@extends('layouts.admin')

@section('title', 'Perbarui Lowongan ' . $career->title)
@section('page_title', 'Perbarui Lowongan Karier')
@section('page_subtitle', 'Koreksi persyaratan kualifikasi, perpanjangan masa pendaftaran, atau penutupan formasi.')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div>
        <a href="{{ route('admin.careers.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#0066B2] hover:underline">
            <span>&larr;</span> Kembali ke Daftar Karier
        </a>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-3">
            <h2 class="text-base font-extrabold text-[#0A2540]">Ubah Data Formasi Jabatan</h2>
        </div>

        <form action="{{ route('admin.careers.update', $career->id) }}" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Posisi / Jabatan Pekerjaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $career->title) }}" required 
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <div class="sm:col-span-1">
                    <label class="block font-bold text-slate-700 mb-1">Batas Waktu Pendaftaran <span class="text-rose-500">*</span></label>
                    <input type="date" name="deadline" value="{{ old('deadline', \Carbon\Carbon::parse($career->deadline)->format('Y-m-d')) }}" required 
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Uraian Tugas & Tanggung Jawab <span class="text-rose-500">*</span></label>
                <textarea name="description" rows="4" required 
                          class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-3.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 leading-relaxed">{{ old('description', $career->description) }}</textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Persyaratan & Kualifikasi Pelamar <span class="text-rose-500">*</span></label>
                <textarea name="requirements" rows="6" required 
                          class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-3.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 leading-relaxed font-mono">{{ old('requirements', $career->requirements) }}</textarea>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $career->is_active) ? 'checked' : '' }} class="accent-[#0066B2] w-4 h-4 rounded">
                    <span class="text-slate-700 font-semibold">Lowongan dibuka aktif di halaman web</span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.careers.index') }}" class="px-5 py-3 text-slate-500 hover:text-slate-800 transition font-bold">Batal</a>
                <button type="submit" class="px-6 py-3 bg-[#0066B2] hover:bg-[#0A2540] text-white font-bold rounded-xl transition shadow-md shadow-[#0066B2]/25">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection