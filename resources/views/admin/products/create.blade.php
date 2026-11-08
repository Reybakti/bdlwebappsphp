@extends('layouts.admin')

@section('title', 'Tambah Produk Perbankan')
@section('page_title', 'Tambah Produk Perbankan')
@section('page_subtitle', 'Terbitkan produk simpanan, deposito, atau kredit baru beserta parameter simulasi & dokumen RIPLAY.')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div>
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#0066B2] hover:underline">
            <span>&larr;</span> Kembali ke Katalog Produk
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

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
        @csrf

        <!-- 1. IDENTITAS DASAR PRODUK -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-base font-extrabold text-[#0A2540]">1. Identitas & Informasi Produk</h2>
                <p class="text-xs text-slate-400">Tentukan klasifikasi produk dan ringkasan fitur utama bagi calon nasabah.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-1">
                    <label class="block font-bold text-slate-700 mb-1">Kategori Produk <span class="text-rose-500">*</span></label>
                    <select name="category_id" required class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-semibold">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Nama Produk Perbankan <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           placeholder="Contoh: Tabungan SIMAPAN (Simpanan Masa Depan)"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Deskripsi Singkat (Tampil pada Card Beranda) <span class="text-rose-500">*</span></label>
                <input type="text" name="short_description" value="{{ old('short_description') }}" required 
                       placeholder="Contoh: Tabungan harian fleksibel dengan setoran awal ringan dan bebas biaya administrasi."
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Deskripsi Lengkap & Manfaat Produk <span class="text-rose-500">*</span></label>
                <textarea name="full_description" rows="5" required 
                          placeholder="Jelaskan keunggulan produk, target nasabah, serta kemudahan transaksi..."
                          class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-3.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 leading-relaxed">{{ old('full_description') }}</textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Syarat & Ketentuan Pengajuan (Per Poin Baris)</label>
                <textarea name="terms_and_conditions" rows="4" 
                          placeholder="1. Fotokopi KTP Pemohon&#10;2. Setoran awal minimal Rp 20.000,-&#10;3. Saldo minimum mengendap..."
                          class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-3.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 leading-relaxed font-mono">{{ old('terms_and_conditions') }}</textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Unggah Dokumen Ringkasan Informasi Produk (RIPLAY PDF)</label>
                <input type="file" name="riplay_file" accept=".pdf" 
                       class="w-full text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0066B2]/10 file:text-[#0066B2] hover:file:bg-[#0066B2]/20 cursor-pointer border border-slate-200 rounded-xl p-2 bg-[#F4F7FC]">
                <span class="text-[11px] text-slate-400 block mt-1">Format PDF wajib sesuai standar POJK Perlindungan Konsumen (Maks. 10 MB).</span>
            </div>

            <div class="flex flex-wrap items-center gap-6 pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="accent-[#0066B2] w-4 h-4 rounded">
                    <span class="text-slate-700 font-semibold">Aktifkan & terbitkan produk di website publik</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="accent-amber-500 w-4 h-4 rounded">
                    <span class="text-slate-700 font-semibold">Jadikan Produk Unggulan (Featured di Beranda)</span>
                </label>
            </div>
        </div>

        <!-- 2. PARAMETER KALKULATOR SIMULASI (KHUSUS PINJAMAN / DEPOSITO) -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h2 class="text-base font-extrabold text-[#0A2540]">2. Parameter Simulasi Interaktif</h2>
                    <p class="text-xs text-slate-400">Aktifkan bagian ini jika produk memiliki kalkulator hitung angsuran kredit atau estimasi bunga deposito.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="has_simulation" id="toggleSimulation" value="1" {{ old('has_simulation') ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0066B2]"></div>
                </label>
            </div>

            <div id="simulationFields" class="space-y-4 {{ old('has_simulation') ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Suku Bunga Acuan (% p.a.)</label>
                        <input type="number" step="0.01" name="base_interest_rate_pa" value="{{ old('base_interest_rate_pa', '10.50') }}" 
                               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Skema Perhitungan Bunga</label>
                        <select name="interest_type" class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-semibold">
                            <option value="FLAT" {{ old('interest_type') === 'FLAT' ? 'selected' : '' }}>FLAT</option>
                            <option value="EFEKTIF" {{ old('interest_type') === 'EFEKTIF' ? 'selected' : '' }}>EFEKTIF (Menurun)</option>
                            <option value="ANUITAS" {{ old('interest_type') === 'ANUITAS' ? 'selected' : '' }}>ANUITAS</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Biaya Provisi (%)</label>
                        <input type="number" step="0.01" name="provision_fee_percent" value="{{ old('provision_fee_percent', '1.00') }}" 
                               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nominal Plafon Minimal (Rp)</label>
                        <input type="number" name="min_amount" value="{{ old('min_amount', '5000000') }}" 
                               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nominal Plafon Maksimal (Rp)</label>
                        <input type="number" name="max_amount" value="{{ old('max_amount', '500000000') }}" 
                               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tenor Minimal (Bulan)</label>
                        <input type="number" name="min_tenor_months" value="{{ old('min_tenor_months', '6') }}" 
                               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tenor Maksimal (Bulan)</label>
                        <input type="number" name="max_tenor_months" value="{{ old('max_tenor_months', '60') }}" 
                               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Biaya Administrasi (Rp)</label>
                        <input type="number" name="admin_fee_amount" value="{{ old('admin_fee_amount', '150000') }}" 
                               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.products.index') }}" class="px-5 py-3 text-slate-500 hover:text-slate-800 transition font-bold">Batal</a>
            <button type="submit" class="px-6 py-3 bg-[#0066B2] hover:bg-[#0A2540] text-white font-bold rounded-xl transition shadow-md shadow-[#0066B2]/25">
                Simpan & Terbitkan Produk
            </button>
        </div>
    </form>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.getElementById('toggleSimulation');
        const container = document.getElementById('simulationFields');
        if (toggle && container) {
            toggle.addEventListener('change', () => {
                container.classList.toggle('hidden', !toggle.checked);
            });
        }
    });
</script>
@endsection