@extends('layouts.admin')

@section('title', 'Tambah Anggota Dewan')
@section('page_title', 'Tambah Anggota Dewan')
@section('page_subtitle', 'Tambahkan profil Direktur atau Komisaris ke struktur kepengurusan bank.')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div>
        <a href="{{ route('admin.management.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#0066B2] hover:underline">
            <span>&larr;</span> Kembali ke Struktur Dewan
        </a>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-3">
            <h2 class="text-base font-extrabold text-[#0A2540]">Data Identitas Pejabat</h2>
        </div>

        <form action="{{ route('admin.management.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-1">
                    <label class="block font-bold text-slate-700 mb-1">Klasifikasi Dewan <span class="text-rose-500">*</span></label>
                    <select name="type" required class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-semibold">
                        <option value="DIRECTOR" {{ old('type') === 'DIRECTOR' ? 'selected' : '' }}>Dewan Direksi</option>
                        <option value="COMMISSIONER" {{ old('type') === 'COMMISSIONER' ? 'selected' : '' }}>Dewan Komisaris</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           placeholder="Contoh: Drs. H. Suhartono, M.Si."
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Jabatan Resmi <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required 
                           placeholder="Contoh: Direktur Utama"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <div class="sm:col-span-1">
                    <label class="block font-bold text-slate-700 mb-1">Urutan Posisi <span class="text-rose-500">*</span></label>
                    <input type="number" name="order_index" value="{{ old('order_index', '1') }}" required min="1" max="99"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Pas Foto Resmi Kedinasan (Maks. 2 MB)</label>
                <input type="file" name="photo" accept="image/*" 
                       class="w-full text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0066B2]/10 file:text-[#0066B2] hover:file:bg-[#0066B2]/20 cursor-pointer border border-slate-200 rounded-xl p-2 bg-[#F4F7FC]">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Riwayat Singkat & Pengalaman Profesional (Bio)</label>
                <textarea name="bio" rows="4" 
                          placeholder="Jelaskan rekam jejak profesional, bidang pengawasan, dan keahlian di sektor keuangan..."
                          class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-3.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 leading-relaxed">{{ old('bio') }}</textarea>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="accent-[#0066B2] w-4 h-4 rounded">
                    <span class="text-slate-700 font-semibold">Tampilkan pejabat ini di website publik (Status Aktif)</span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.management.index') }}" class="px-5 py-3 text-slate-500 hover:text-slate-800 transition font-bold">Batal</a>
                <button type="submit" class="px-6 py-3 bg-[#0066B2] hover:bg-[#0A2540] text-white font-bold rounded-xl transition shadow-md shadow-[#0066B2]/25">
                    Simpan Pejabat
                </button>
            </div>
        </form>
    </div>

</div>
@endsection