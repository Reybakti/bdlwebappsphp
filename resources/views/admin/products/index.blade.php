@extends('layouts.admin')

@section('title', 'Katalog Produk & RIPLAY')
@section('page_title', 'Katalog Produk & RIPLAY')
@section('page_subtitle', 'Pengelolaan produk simpanan, pinjaman, parameter simulasi angsuran, dan dokumen transparansi RIPLAY.')

@section('content')
<div class="space-y-6">

    <!-- Bar Filter & Tombol Tambah Produk -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 w-full sm:w-auto flex-1">
            
            <select name="category_id" onchange="this.form.submit()" class="text-xs bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2 font-semibold text-slate-700 focus:outline-none focus:border-[#0066B2]">
                <option value="">Semua Kategori Produk</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama produk, deskripsi..." 
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl pl-8 pr-3 py-2 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#0066B2] focus:bg-white transition">
                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <button type="submit" class="px-4 py-2 bg-[#0066B2] text-white text-xs font-bold rounded-xl hover:bg-[#0A2540] transition">
                Cari
            </button>
            @if(request()->anyFilled(['category_id', 'q']))
                <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-rose-600 hover:underline px-2">Reset</a>
            @endif
        </form>

        <a href="{{ route('admin.products.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0066B2] hover:bg-[#0A2540] text-white text-xs font-bold rounded-xl transition shadow-md shadow-[#0066B2]/20 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Produk Baru</span>
        </a>
    </div>

    <!-- Tabel Produk -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50/75 text-slate-400 uppercase font-semibold border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Nama Produk</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Parameter Bunga & Tenor</th>
                        <th class="py-3.5 px-4">Dokumen RIPLAY</th>
                        <th class="py-3.5 px-4">Status Terbit</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($products as $item)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-800 text-[13px] block">{{ $item->name }}</span>
                                    @if($item->is_featured)
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-100 text-amber-800">
                                            UNGGULAN
                                        </span>
                                    @endif
                                </div>
                                <span class="text-[11px] text-slate-400 line-clamp-1 mt-0.5">{{ $item->short_description }}</span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-[#F4F7FC] text-[#0A2540] border border-slate-200 uppercase">
                                    {{ $item->category?->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 font-mono">
                                @if($item->simulationParam)
                                    <span class="font-bold text-[#0066B2] block">
                                        {{ number_format($item->simulationParam->base_interest_rate_pa, 2) }}% p.a. ({{ $item->simulationParam->interest_type }})
                                    </span>
                                    <span class="text-[10px] text-slate-400 block font-sans">
                                        Tenor: {{ $item->simulationParam->min_tenor_months }} - {{ $item->simulationParam->max_tenor_months }} bln
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">Tanpa Simulasi</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                @if($item->riplay_file_url)
                                    <a href="{{ asset($item->riplay_file_url) }}" target="_blank" 
                                       class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-blue-50 text-[#0066B2] hover:bg-[#0066B2] hover:text-white transition font-bold text-[10px] border border-blue-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span>PDF RIPLAY</span>
                                    </a>
                                @else
                                    <span class="text-slate-400 text-[10px] italic">Belum Ada</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                @if($item->is_active)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.products.edit', $item->id) }}" 
                                       class="p-2 text-slate-500 hover:text-[#0066B2] hover:bg-blue-50 rounded-lg transition" title="Edit Produk">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST" 
                                          onsubmit="return confirm('Hapus produk perbankan ini? Data simulasi terkait juga akan terhapus.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                Belum ada katalog produk perbankan terdaftar.
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