@extends('layouts.admin')

@section('title', 'Perbarui Program CSR ' . $program->title)
@section('page_title', 'Perbarui Program CSR')
@section('page_subtitle', 'Koreksi uraian kegiatan, ganti sampul, atau kelola galeri dokumentasi foto.')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div>
        <a href="{{ route('admin.csr.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#0066B2] hover:underline">
            <span>&larr;</span> Kembali ke Daftar Program CSR
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
            <h2 class="text-base font-extrabold text-[#0A2540]">Ubah Data Program CSR</h2>
        </div>

        <form action="{{ route('admin.csr.update', $program->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-1">
                    <label class="block font-bold text-slate-700 mb-1">Pilar Kategori CSR <span class="text-rose-500">*</span></label>
                    <select name="category" required class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-semibold">
                        <option value="PEMBERDAYAAN_UMKM" {{ old('category', $program->category) === 'PEMBERDAYAAN_UMKM' ? 'selected' : '' }}>Pemberdayaan UMKM</option>
                        <option value="PENDIDIKAN_LITERASI" {{ old('category', $program->category) === 'PENDIDIKAN_LITERASI' ? 'selected' : '' }}>Pendidikan & Literasi</option>
                        <option value="SOSIAL_KEMASYARAKATAN" {{ old('category', $program->category) === 'SOSIAL_KEMASYARAKATAN' ? 'selected' : '' }}>Sosial Kemasyarakatan</option>
                        <option value="LINGKUNGAN_HIDUP" {{ old('category', $program->category) === 'LINGKUNGAN_HIDUP' ? 'selected' : '' }}>Lingkungan Hidup</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Judul Kegiatan CSR <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $program->title) }}" required 
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Lokasi Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="location" value="{{ old('location', $program->location) }}" required 
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Pelaksanaan <span class="text-rose-500">*</span></label>
                    <input type="date" name="activity_date" value="{{ old('activity_date', \Carbon\Carbon::parse($program->activity_date)->format('Y-m-d')) }}" required 
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Alokasi Anggaran (Rp)</label>
                    <input type="number" step="0.01" name="budget_amount" value="{{ old('budget_amount', $program->budget_amount) }}" 
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>
            </div>

            <!-- Sampul Utama -->
            <div>
                <label class="block font-bold text-slate-700 mb-1">Ganti Sampul Utama (Opsional, Maks. 3 MB)</label>
                <input type="file" name="cover_image" accept="image/*" 
                       class="w-full text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0066B2]/10 file:text-[#0066B2] hover:file:bg-[#0066B2]/20 cursor-pointer border border-slate-200 rounded-xl p-2 bg-[#F4F7FC]">
                @if($program->image_url)
                    <div class="mt-2 flex items-center gap-3 p-2 bg-[#F4F7FC] rounded-xl border border-slate-200 w-fit">
                        <img src="{{ asset($program->image_url) }}" alt="Sampul CSR" class="w-14 h-14 rounded-lg object-cover">
                        <span class="text-[11px] text-slate-500 font-medium">Sampul utama aktif</span>
                    </div>
                @endif
            </div>

            <!-- Galeri Foto Saat Ini -->
            <div>
                <label class="block font-bold text-slate-700 mb-2">Dokumentasi Galeri Tersimpan ({{ $program->galleryImages->count() }} Foto)</label>
                
                @if($program->galleryImages->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3 p-3 bg-[#F4F7FC] rounded-2xl border border-slate-200 mb-3">
                        @foreach($program->galleryImages as $photo)
                            <div class="relative group rounded-xl overflow-hidden aspect-square border border-slate-200 bg-white shadow-sm">
                                <img src="{{ asset($photo->image_url) }}" alt="Galeri" class="w-full h-full object-cover">
                                
                                <!-- Tombol Hapus Satuan -->
                                <button type="button" 
                                        onclick="if(confirm('Hapus foto dokumentasi ini?')) document.getElementById('delete-img-{{ $photo->id }}').submit();"
                                        class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-bold transition">
                                    <svg class="w-5 h-5 text-rose-400 hover:text-rose-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-[11px] text-slate-400 italic mb-3">Belum ada foto tambahan di galeri kegiatan ini.</p>
                @endif

                <!-- Input Tambah Foto Baru ke Galeri -->
                <label class="block font-bold text-slate-700 mb-1">Tambah Foto ke Galeri Dokumentasi (Pilih Satu atau Banyak)</label>
                <input type="file" name="gallery_images[]" accept="image/*" multiple 
                       class="w-full text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-slate-200 rounded-xl p-2 bg-[#F4F7FC]">
            </div>

            <!-- Bagian Dokumen Pendukung -->
<div class="p-4 bg-[#F4F7FC] rounded-2xl border border-slate-200 space-y-3">
    <label class="block font-bold text-slate-700">Dokumen Pendukung / Laporan CSR (PDF / DOCX, Maks. 15 MB)</label>
    
    @if($program->document_url)
        <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-slate-200">
            <div class="flex items-center gap-2.5 min-w-0">
                <svg class="w-5 h-5 text-[#0066B2] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <div class="min-w-0">
                    <span class="font-bold text-slate-800 text-xs truncate block">{{ $program->document_name ?? 'Dokumen Kegiatan CSR' }}</span>
                    <a href="{{ asset($program->document_url) }}" target="_blank" class="text-[10px] text-[#0066B2] font-semibold hover:underline">
                        Lihat / Unduh Dokumen Aktif &rarr;
                    </a>
                </div>
            </div>

            <label class="flex items-center gap-1.5 cursor-pointer text-rose-600 font-semibold text-[11px] hover:text-rose-800">
                <input type="checkbox" name="remove_document" value="1" class="accent-rose-600 rounded">
                <span>Hapus Berkas</span>
            </label>
        </div>
    @endif

    <div>
        <span class="text-[11px] text-slate-500 block mb-1">{{ $program->document_url ? 'Ganti dengan berkas baru:' : 'Unggah berkas dokumen:' }}</span>
        <input type="file" name="document_file" accept=".pdf,.doc,.docx,.xls,.xlsx" 
               class="w-full text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0A2540]/10 file:text-[#0A2540] hover:file:bg-[#0A2540]/20 cursor-pointer border border-slate-200 rounded-xl p-2 bg-white">
    </div>
</div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Deskripsi Lengkap & Dampak Kegiatan <span class="text-rose-500">*</span></label>
                <textarea name="description" rows="8" required 
                          class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-4 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 leading-relaxed font-mono text-xs">{{ old('description', $program->description) }}</textarea>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $program->is_published) ? 'checked' : '' }} class="accent-[#0066B2] w-4 h-4 rounded">
                    <span class="text-slate-700 font-semibold">Publikasikan kegiatan CSR ini di website</span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.csr.index') }}" class="px-5 py-3 text-slate-500 hover:text-slate-800 transition font-bold">Batal</a>
                <button type="submit" class="px-6 py-3 bg-[#0066B2] hover:bg-[#0A2540] text-white font-bold rounded-xl transition shadow-md shadow-[#0066B2]/25">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>

<!-- Form Tersembunyi untuk Hapus Foto Galeri -->
@foreach($program->galleryImages as $photo)
    <form id="delete-img-{{ $photo->id }}" action="{{ route('admin.csr.image.delete', $photo->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endforeach

@endsection