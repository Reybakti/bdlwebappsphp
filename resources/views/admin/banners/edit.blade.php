@extends('layouts.admin')

@section('title', 'Perbarui Banner ' . $banner->title)
@section('page_title', 'Perbarui Slide Banner')
@section('page_subtitle', 'Sunting teks headline, ganti gambar banner, atau atur nomor urutan tampil.')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div>
        <a href="{{ route('admin.banners.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#0066B2] hover:underline">
            <span>&larr;</span> Kembali ke Daftar Banner
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
            <h2 class="text-base font-extrabold text-[#0A2540]">Ubah Data Banner</h2>
        </div>

        <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div class="sm:col-span-3">
                    <label class="block font-bold text-slate-700 mb-1">Judul Headline Banner <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $banner->title) }}" required 
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <div class="sm:col-span-1">
                    <label class="block font-bold text-slate-700 mb-1">Urutan Slide <span class="text-rose-500">*</span></label>
                    <input type="number" name="order_index" value="{{ old('order_index', $banner->order_index) }}" required min="1" max="99"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Teks Subtitle / Deskripsi Singkat</label>
                <textarea name="subtitle" rows="3" 
                          class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-3.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 leading-relaxed">{{ old('subtitle', $banner->subtitle) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Ganti Gambar Desktop (Maks. 4 MB)</label>
                    <input type="file" name="image_desktop" accept="image/*" 
                           class="w-full text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0066B2]/10 file:text-[#0066B2] hover:file:bg-[#0066B2]/20 cursor-pointer border border-slate-200 rounded-xl p-2 bg-[#F4F7FC]">
                    @if($banner->image_desktop_url)
                        <div class="mt-2 flex items-center gap-2 text-[11px] text-slate-500">
                            <span>Gambar aktif:</span>
                            <a href="{{ str_starts_with($banner->image_desktop_url, 'http') ? $banner->image_desktop_url : asset($banner->image_desktop_url) }}" target="_blank" class="font-bold text-[#0066B2] hover:underline">
                                Pratinjau Desktop &rarr;
                            </a>
                        </div>
                    @endif
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Ganti Gambar Mobile (Maks. 3 MB)</label>
                    <input type="file" name="image_mobile" accept="image/*" 
                           class="w-full text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0066B2]/10 file:text-[#0066B2] hover:file:bg-[#0066B2]/20 cursor-pointer border border-slate-200 rounded-xl p-2 bg-[#F4F7FC]">
                    @if($banner->image_mobile_url)
                        <div class="mt-2 flex items-center gap-2 text-[11px] text-slate-500">
                            <span>Gambar aktif:</span>
                            <a href="{{ str_starts_with($banner->image_mobile_url, 'http') ? $banner->image_mobile_url : asset($banner->image_mobile_url) }}" target="_blank" class="font-bold text-[#0066B2] hover:underline">
                                Pratinjau Mobile &rarr;
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Teks Tombol Aksi (Button CTA)</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}" 
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tautan / Link URL Tombol</label>
                    <input type="text" name="button_url" value="{{ old('button_url', $banner->button_url) }}" 
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-mono">
                </div>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }} class="accent-[#0066B2] w-4 h-4 rounded">
                    <span class="text-slate-700 font-semibold">Aktifkan slide banner ini di halaman beranda</span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.banners.index') }}" class="px-5 py-3 text-slate-500 hover:text-slate-800 transition font-bold">Batal</a>
                <button type="submit" class="px-6 py-3 bg-[#0066B2] hover:bg-[#0A2540] text-white font-bold rounded-xl transition shadow-md shadow-[#0066B2]/25">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection