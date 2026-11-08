@extends('layouts.admin')

@section('title', 'Tambah Kantor Baru')
@section('page_title', 'Tambah Kantor Baru')
@section('page_subtitle', 'Daftarkan titik operasional kantor cabang atau kantor kas baru.')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div>
        <a href="{{ route('admin.branches.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#0066B2] hover:underline">
            <span>&larr;</span> Kembali ke Jaringan Kantor
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
            <h2 class="text-base font-extrabold text-[#0A2540]">Informasi Unit Kantor</h2>
            <p class="text-xs text-slate-400">Pastikan data kontak dan alamat sesuai dengan perizinan operasional OJK.</p>
        </div>

        <form action="{{ route('admin.branches.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-1">
                    <label class="block font-bold text-slate-700 mb-1">Tipe Kantor <span class="text-rose-500">*</span></label>
                    <select name="type" required class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-semibold">
                        <option value="BRANCH" {{ old('type') === 'BRANCH' ? 'selected' : '' }}>Kantor Cabang</option>
                        <option value="CASH_OFFICE" {{ old('type') === 'CASH_OFFICE' ? 'selected' : '' }}>Kantor Kas</option>
                        <option value="HEAD_OFFICE" {{ old('type') === 'HEAD_OFFICE' ? 'selected' : '' }}>Kantor Pusat</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Nama Unit Kantor <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           placeholder="Contoh: Kantor Cabang Babat"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Alamat Lengkap <span class="text-rose-500">*</span></label>
                <textarea name="address" rows="3" required 
                          placeholder="Jalan, kelurahan, kecamatan, nomor ruko/gedung..."
                          class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-3.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 leading-relaxed">{{ old('address') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div>
        <label class="block font-bold text-slate-700 mb-1">Telepon Kantor</label>
        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Contoh: (0322) 321175"
               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] text-slate-800 font-mono text-xs">
    </div>

    <div>
        <label class="block font-bold text-slate-700 mb-1">Nomor WhatsApp</label>
        <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="Contoh: 081234567890"
               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] text-slate-800 font-mono text-xs">
    </div>

    <div>
        <label class="block font-bold text-slate-700 mb-1">Email Kantor</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Contoh: cabang.babat@bdl.co.id"
               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] text-slate-800 text-xs">
    </div>
</div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Latitude (Koordinat GPS)</label>
                    <input type="text" name="latitude" value="{{ old('latitude') }}" 
                           placeholder="-7.114521"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Longitude (Koordinat GPS)</label>
                    <input type="text" name="longitude" value="{{ old('longitude') }}" 
                           placeholder="112.163214"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Tautan Lokasi Google Maps</label>
                <input type="url" name="google_maps_url" value="{{ old('google_maps_url') }}" 
                       placeholder="https://maps.google.com/?q=..."
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="accent-[#0066B2] w-4 h-4 rounded">
                    <span class="text-slate-700 font-semibold">Aktifkan operasional kantor ini</span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.branches.index') }}" class="px-4 py-2.5 text-slate-500 hover:text-slate-800 transition font-bold">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-[#0066B2] hover:bg-[#0A2540] text-white font-bold rounded-xl transition shadow-md shadow-[#0066B2]/20">
                    Simpan Kantor Baru
                </button>
            </div>
        </form>
    </div>

</div>
@endsection