@extends('layouts.admin')

@section('title', 'Tambah Program CSR')
@section('page_title', 'Tambah Program CSR Baru')
@section('page_subtitle', 'Publikasikan realisasi kegiatan kepedulian sosial perbankan dan galeri foto dokumentasi.')

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
            <h2 class="text-base font-extrabold text-[#0A2540]">Formulir Pelaksanaan Program CSR</h2>
        </div>

        <form action="{{ route('admin.csr.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-1">
                    <label class="block font-bold text-slate-700 mb-1">Pilar Kategori CSR <span class="text-rose-500">*</span></label>
                    <select name="category" required class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-semibold">
                        <option value="PEMBERDAYAAN_UMKM" {{ old('category') === 'PEMBERDAYAAN_UMKM' ? 'selected' : '' }}>Pemberdayaan UMKM</option>
                        <option value="PENDIDIKAN_LITERASI" {{ old('category') === 'PENDIDIKAN_LITERASI' ? 'selected' : '' }}>Pendidikan & Literasi</option>
                        <option value="SOSIAL_KEMASYARAKATAN" {{ old('category') === 'SOSIAL_KEMASYARAKATAN' ? 'selected' : '' }}>Sosial Kemasyarakatan</option>
                        <option value="LINGKUNGAN_HIDUP" {{ old('category') === 'LINGKUNGAN_HIDUP' ? 'selected' : '' }}>Lingkungan Hidup</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Judul Kegiatan CSR <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required 
                           placeholder="Contoh: Penyerahan Bantuan Alat Produksi bagi Pelaku Usaha Olahan Ikan di Brondong"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Lokasi Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="location" value="{{ old('location') }}" required 
                           placeholder="Contoh: Kec. Babat, Lamongan"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Pelaksanaan <span class="text-rose-500">*</span></label>
                    <input type="date" name="activity_date" value="{{ old('activity_date', date('Y-m-d')) }}" required 
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Alokasi Anggaran (Rp, Opsional)</label>
                    <input type="number" step="0.01" name="budget_amount" value="{{ old('budget_amount') }}" 
                           placeholder="Contoh: 25000000"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>
            </div>

            <!-- Upload Foto Sampul Utama -->
            <div>
                <label class="block font-bold text-slate-700 mb-1">Foto Sampul Utama / Cover (Maks. 3 MB)</label>
                <input type="file" name="cover_image" accept="image/*" 
                       class="w-full text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0066B2]/10 file:text-[#0066B2] hover:file:bg-[#0066B2]/20 cursor-pointer border border-slate-200 rounded-xl p-2 bg-[#F4F7FC]">
                <span class="text-[11px] text-slate-400 block mt-1">Ditampilkan sebagai thumbnail utama di kartu daftar program.</span>
            </div>

            <!-- Upload Multi Foto Galeri Dokumentasi -->
            <div>
                <label class="block font-bold text-slate-700 mb-1">Galeri Dokumentasi Foto Kegiatan (Bisa Pilih Banyak Foto Sekaligus)</label>
                <input type="file" name="gallery_images[]" accept="image/*" multiple 
                       class="w-full text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-slate-200 rounded-xl p-2 bg-[#F4F7FC]">
                <span class="text-[11px] text-slate-400 block mt-1">Tahan tombol <strong>Ctrl</strong> (atau <strong>Cmd</strong> di Mac) saat memilih file untuk mengunggah lebih dari 1 foto.</span>
            </div>

            <!-- Upload Dokumen Laporan / Lampiran CSR -->
<div>
    <label class="block font-bold text-slate-700 mb-1">Dokumen Pendukung / Laporan CSR (PDF / DOCX, Maks. 15 MB)</label>
    <input type="file" name="document_file" accept=".pdf,.doc,.docx,.xls,.xlsx" 
           class="w-full text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0A2540]/10 file:text-[#0A2540] hover:file:bg-[#0A2540]/20 cursor-pointer border border-slate-200 rounded-xl p-2 bg-[#F4F7FC]">
    <span class="text-[11px] text-slate-400 block mt-1">Opsional: Lampirkan berkas laporan pertanggungjawaban kegiatan, proposal realisasi, atau berita acara.</span>
</div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Deskripsi Lengkap & Dampak Kegiatan <span class="text-rose-500">*</span></label>
                <textarea name="description" rows="8" required 
                          placeholder="Jelaskan latar belakang kegiatan CSR, kelompok masyarakat penerima manfaat, serta dampak positif yang dihasilkan..."
                          class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-4 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 leading-relaxed font-mono text-xs">{{ old('description') }}</textarea>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', '1') ? 'checked' : '' }} class="accent-[#0066B2] w-4 h-4 rounded">
                    <span class="text-slate-700 font-semibold">Publikasikan langsung kegiatan CSR ini di website</span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.csr.index') }}" class="px-5 py-3 text-slate-500 hover:text-slate-800 transition font-bold">Batal</a>
                <button type="submit" class="px-6 py-3 bg-[#0066B2] hover:bg-[#0A2540] text-white font-bold rounded-xl transition shadow-md shadow-[#0066B2]/25">
                    Simpan & Terbitkan CSR
                </button>
            </div>
        </form>
    </div>

</div>
@endsection