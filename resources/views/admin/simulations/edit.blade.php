@extends('layouts.admin')

@section('title', 'Atur Simulasi: ' . $product->name)
@section('page_title', 'Atur Parameter Simulasi')
@section('page_subtitle', 'Konfigurasi suku bunga p.a., nominal plafon, dan jangka waktu perhitungan kalkulator publik.')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div>
        <a href="{{ route('admin.simulations.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#0066B2] hover:underline">
            <span>&larr;</span> Kembali ke Daftar Parameter
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
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">{{ $product->category?->name ?? 'Produk' }}</span>
                <h2 class="text-base font-extrabold text-[#0A2540]">{{ $product->name }}</h2>
            </div>
            @if($product->is_featured)
                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-[#0066B2] text-white">Default Kalkulator Beranda</span>
            @endif
        </div>

        <form action="{{ route('admin.simulations.update', $product->id) }}" method="POST" class="space-y-5 text-xs">
            @csrf
            @method('PUT')

            <!-- Suku Bunga & Metode Perhitungan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-[#F4F7FC] rounded-2xl border border-slate-200">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Suku Bunga Dasar Tahunan (% p.a.) <span class="text-rose-500">*</span></label>
                    <input type="number" step="0.01" name="base_interest_rate_pa" 
                           value="{{ old('base_interest_rate_pa', $param->base_interest_rate_pa ?? '10.50') }}" required 
                           placeholder="Contoh: 10.50"
                           class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] font-mono font-bold text-sm text-[#0066B2]">
                    <span class="text-[11px] text-slate-400 block mt-1">Digunakan sebagai dasar kalkulasi angsuran atau bagi hasil.</span>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Metode Perhitungan Bunga <span class="text-rose-500">*</span></label>
                    <select name="calculation_method" required class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] font-semibold text-slate-800">
                        <option value="FLAT" {{ old('calculation_method', $param->calculation_method ?? 'FLAT') === 'FLAT' ? 'selected' : '' }}>FLAT (Angsuran Pokok & Bunga Tetap per Bulan)</option>
                        <option value="ANNUITY" {{ old('calculation_method', $param->calculation_method ?? '') === 'ANNUITY' ? 'selected' : '' }}>ANNUITY (Total Angsuran Tetap, Porsi Bunga Menurun)</option>
                        <option value="EFFECTIVE" {{ old('calculation_method', $param->calculation_method ?? '') === 'EFFECTIVE' ? 'selected' : '' }}>EFFECTIVE (Bunga Menurun Sesuai Sisa Pokok)</option>
                    </select>
                </div>
            </div>

            <!-- Batas Plafon Nominal -->
            <div class="space-y-2">
                <span class="font-bold text-slate-800 uppercase tracking-wider text-[11px] block">Rentang Plafon Nominal (Rp)</span>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-600 mb-1">Nominal Minimum (Rp) <span class="text-rose-500">*</span></label>
                        <input type="number" step="100000" name="min_amount" 
                               value="{{ old('min_amount', $param->min_amount ?? '5000000') }}" required 
                               placeholder="5000000"
                               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white font-mono text-slate-800">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-600 mb-1">Nominal Maksimum (Rp) <span class="text-rose-500">*</span></label>
                        <input type="number" step="100000" name="max_amount" 
                               value="{{ old('max_amount', $param->max_amount ?? '500000000') }}" required 
                               placeholder="500000000"
                               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white font-mono text-slate-800">
                    </div>
                </div>
            </div>

            <!-- Rentang Tenor Waktu -->
            <div class="space-y-2">
                <span class="font-bold text-slate-800 uppercase tracking-wider text-[11px] block">Rentang Jangka Waktu (Bulan)</span>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-600 mb-1">Tenor Minimum (Bulan) <span class="text-rose-500">*</span></label>
                        <input type="number" name="min_tenor_months" 
                               value="{{ old('min_tenor_months', $param->min_tenor_months ?? '1') }}" required min="1"
                               placeholder="1"
                               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white font-mono text-slate-800">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-600 mb-1">Tenor Maksimum (Bulan) <span class="text-rose-500">*</span></label>
                        <input type="number" name="max_tenor_months" 
                               value="{{ old('max_tenor_months', $param->max_tenor_months ?? '36') }}" required min="1"
                               placeholder="36"
                               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white font-mono text-slate-800">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.simulations.index') }}" class="px-5 py-3 text-slate-500 hover:text-slate-800 transition font-bold">Batal</a>
                <button type="submit" class="px-6 py-3 bg-[#0066B2] hover:bg-[#0A2540] text-white font-bold rounded-xl transition shadow-md shadow-[#0066B2]/25">
                    Simpan Parameter Simulasi
                </button>
            </div>
        </form>
    </div>

</div>
@endsection