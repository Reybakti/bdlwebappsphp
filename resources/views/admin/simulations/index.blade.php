@extends('layouts.admin')

@section('title', 'Parameter Simulasi Produk')
@section('page_title', 'Parameter Simulasi Keuangan')
@section('page_subtitle', 'Pengaturan suku bunga dasar tahunan (p.a.), batas plafon nominal, dan tenor pinjaman/deposito.')

@section('content')
<div class="space-y-6">

    <!-- Bar Filter -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.simulations.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 w-full sm:w-auto flex-1">
            <select name="category" onchange="this.form.submit()" class="text-xs bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2 font-semibold text-slate-700 focus:outline-none focus:border-[#0066B2]">
                <option value="">Semua Kategori Produk ({{ $counts['all'] }})</option>
                <option value="kredit" {{ request('category') === 'kredit' ? 'selected' : '' }}>Kredit & Pembiayaan ({{ $counts['kredit'] }})</option>
                <option value="deposito" {{ request('category') === 'deposito' ? 'selected' : '' }}>Deposito Berjangka ({{ $counts['deposito'] }})</option>
            </select>

            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama produk..." 
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl pl-8 pr-3 py-2 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#0066B2] focus:bg-white transition">
                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <button type="submit" class="px-4 py-2 bg-[#0066B2] text-white text-xs font-bold rounded-xl hover:bg-[#0A2540] transition">
                Cari
            </button>
            @if(request()->anyFilled(['category', 'q']))
                <a href="{{ route('admin.simulations.index') }}" class="text-xs font-bold text-rose-600 hover:underline px-2">Reset</a>
            @endif
        </form>
    </div>

    <!-- Tabel Produk & Parameter Simulasi -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50/75 text-slate-400 uppercase font-semibold border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Nama Produk</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Suku Bunga Dasar</th>
                        <th class="py-3.5 px-4">Metode Bunga</th>
                        <th class="py-3.5 px-4">Batas Nominal Plafon</th>
                        <th class="py-3.5 px-4">Rentang Tenor</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($products as $item)
                        @php
                            $param = $item->simulationParam;
                            $catSlug = $item->category?->slug;
                            $catBadge = match($catSlug) {
                                'kredit' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                'deposito' => 'bg-amber-50 text-amber-800 border-amber-200',
                                default => 'bg-slate-50 text-slate-700 border-slate-200',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6 font-bold text-slate-800 text-[13px]">
                                {{ $item->name }}
                                @if($item->is_featured)
                                    <span class="ml-1.5 px-2 py-0.5 rounded text-[9px] font-bold bg-[#0066B2] text-white">Unggulan</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $catBadge }} uppercase">
                                    {{ $item->category?->name ?? 'Produk' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 font-mono font-bold text-base {{ $param ? 'text-[#0066B2]' : 'text-slate-400' }}">
                                {{ $param ? number_format($param->base_interest_rate_pa, 2) . '% p.a.' : 'Belum Diatur' }}
                            </td>
                            <td class="py-4 px-4">
                                @if($param)
                                    <span class="px-2 py-0.5 rounded font-mono font-bold text-[10px] bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $param->calculation_method }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 font-mono text-[11px]">
                                @if($param)
                                    <span class="block text-slate-700 font-semibold">Min: Rp{{ number_format($param->min_amount, 0, ',', '.') }}</span>
                                    <span class="block text-slate-500">Maks: Rp{{ number_format($param->max_amount, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-slate-400 italic">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 font-mono text-[11px]">
                                @if($param)
                                    <span class="font-bold text-slate-800">{{ $param->min_tenor_months }} - {{ $param->max_tenor_months }} Bulan</span>
                                @else
                                    <span class="text-slate-400 italic">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.simulations.edit', $item->id) }}" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#0066B2] hover:bg-[#0A2540] text-white font-bold text-xs rounded-xl transition shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>Atur Bunga & Tenor</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                Belum ada data produk pembiayaan atau simpanan berjangka.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-4 border-t border-slate-100 flex justify-center">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection