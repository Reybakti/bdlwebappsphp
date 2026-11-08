@extends('layouts.admin')

@section('title', 'Tulis Artikel Baru')
@section('page_title', 'Tulis Artikel & Literasi')
@section('page_subtitle', 'Tulis berita kegiatan bank, edukasi pelindungan nasabah, atau pengumuman resmi.')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div>
        <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#0066B2] hover:underline">
            <span>&larr;</span> Kembali ke Daftar Berita
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
            <h2 class="text-base font-extrabold text-[#0A2540]">Editor Publikasi Berita & Literasi</h2>
        </div>

        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-1">
                    <label class="block font-bold text-slate-700 mb-1">Kategori Artikel <span class="text-rose-500">*</span></label>
                    <select name="category_id" required class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-semibold">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Judul Artikel / Berita <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required 
                           placeholder="Contoh: Tips Aman Membedakan Pinjaman Legal dan Ilegal..."
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Publikasi <span class="text-rose-500">*</span></label>
                    <select name="status" required class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-semibold">
                        <option value="PUBLISHED" {{ old('status') === 'PUBLISHED' ? 'selected' : '' }}>PUBLISHED (Terbitkan Langsung)</option>
                        <option value="DRAFT" {{ old('status') === 'DRAFT' ? 'selected' : '' }}>DRAFT (Simpan Sebagai Draf)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Waktu Terbit</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at', date('Y-m-d\TH:i')) }}" 
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Gambar Sampul / Thumbnail (Maks. 3 MB)</label>
                <input type="file" name="thumbnail" accept="image/*" 
                       class="w-full text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0066B2]/10 file:text-[#0066B2] hover:file:bg-[#0066B2]/20 cursor-pointer border border-slate-200 rounded-xl p-2 bg-[#F4F7FC]">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Isi Konten Berita / Materi Edukasi (HTML / Paragraf) <span class="text-rose-500">*</span></label>
                <textarea name="content" rows="12" required 
                          placeholder="Tuliskan isi warta atau materi edukasi keuangan secara lengkap di sini..."
                          class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-4 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 leading-relaxed font-mono text-xs">{{ old('content') }}</textarea>
                <span class="text-[11px] text-slate-400 block mt-1">Dapat menggunakan tag HTML dasar seperti &lt;p&gt;, &lt;strong&gt;, &lt;ul&gt;, &lt;li&gt;.</span>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.articles.index') }}" class="px-5 py-3 text-slate-500 hover:text-slate-800 transition font-bold">Batal</a>
                <button type="submit" class="px-6 py-3 bg-[#0066B2] hover:bg-[#0A2540] text-white font-bold rounded-xl transition shadow-md shadow-[#0066B2]/25">
                    Simpan Artikel
                </button>
            </div>
        </form>
    </div>

</div>
@endsection