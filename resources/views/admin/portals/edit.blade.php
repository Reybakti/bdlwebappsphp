@extends('layouts.admin')

@section('title', 'Perbarui Tautan Portal')
@section('page_title', 'Perbarui Tautan Portal')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div>
        <a href="{{ route('admin.portals.index') }}" class="text-xs font-bold text-[#0066B2] hover:underline">&larr; Kembali ke Daftar Portal</a>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.portals.update', $link->id) }}" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Nama / Judul Portal <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $link->title) }}" required
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kategori Tautan <span class="text-rose-500">*</span></label>
                    <select name="category" required class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-semibold">
                        @foreach($categories as $cVal => $cText)
                            <option value="{{ $cVal }}" {{ old('category', $link->category) === $cVal ? 'selected' : '' }}>{{ $cText }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Label Lencana (Opsional)</label>
                    <input type="text" name="badge_text" value="{{ old('badge_text', $link->badge_text) }}"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">URL Lengkap Tujuan <span class="text-rose-500">*</span></label>
                    <input type="url" name="url" value="{{ old('url', $link->url) }}" required
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-mono">
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Keterangan Singkat</label>
                    <textarea name="description" rows="2"
                              class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">{{ old('description', $link->description) }}</textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Urutan Tampil (0 = paling awal)</label>
                    <input type="number" name="order_index" value="{{ old('order_index', $link->order_index) }}" min="0"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-mono">
                </div>

                <div class="flex items-center gap-6 pt-5">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_external" value="1" {{ old('is_external', $link->is_external) ? 'checked' : '' }} class="accent-[#0066B2] w-4 h-4">
                        <span class="text-slate-700 font-semibold">Buka Tab Baru (External)</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $link->is_active) ? 'checked' : '' }} class="accent-[#0066B2] w-4 h-4">
                        <span class="text-slate-700 font-semibold">Tampilkan (Aktif)</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('admin.portals.index') }}" class="px-5 py-2.5 text-slate-500 font-bold hover:text-slate-800 transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-[#0066B2] hover:bg-[#0A2540] text-white font-bold rounded-xl transition shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection