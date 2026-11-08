@extends('layouts.admin')

@section('title', 'Jaringan Kantor Operasional')
@section('page_title', 'Jaringan Kantor Operasional')
@section('page_subtitle', 'Direktori Kantor Pusat, Kantor Cabang, dan Kantor Kas Bank Daerah Lamongan.')

@section('content')
<div class="space-y-6">

    <!-- Filter & Aksi -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        
        <!-- Filter Kategori Tipe Kantor -->
        <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
            <a href="{{ route('admin.branches.index') }}" 
               class="px-3.5 py-2 rounded-xl transition {{ !request('type') ? 'bg-[#0066B2] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Semua ({{ $counts['all'] }})
            </a>
            <a href="{{ route('admin.branches.index', ['type' => 'HEAD_OFFICE']) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ request('type') === 'HEAD_OFFICE' ? 'bg-[#0066B2] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Kantor Pusat ({{ $counts['head'] }})
            </a>
            <a href="{{ route('admin.branches.index', ['type' => 'BRANCH']) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ request('type') === 'BRANCH' ? 'bg-[#0066B2] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Cabang ({{ $counts['branch'] }})
            </a>
            <a href="{{ route('admin.branches.index', ['type' => 'CASH_OFFICE']) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ request('type') === 'CASH_OFFICE' ? 'bg-[#0066B2] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Kantor Kas ({{ $counts['cash'] }})
            </a>
        </div>

        <!-- Pencarian & Tombol Tambah -->
        <div class="flex flex-wrap items-center gap-3">
            <form action="{{ route('admin.branches.index') }}" method="GET" class="relative">
                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kantor, alamat, email..." 
                       class="w-full sm:w-64 bg-[#F4F7FC] border border-slate-200 rounded-xl pl-8 pr-3 py-2 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#0066B2] focus:bg-white transition">
                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </form>

            <a href="{{ route('admin.branches.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0066B2] hover:bg-[#0A2540] text-white text-xs font-bold rounded-xl transition shadow-md shadow-[#0066B2]/20 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Kantor Baru</span>
            </a>
        </div>
    </div>

    <!-- Tabel Jaringan Kantor -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50/75 text-slate-400 uppercase font-semibold border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Unit Kantor & Tipe</th>
                        <th class="py-3.5 px-4">Alamat Lengkap</th>
                        <th class="py-3.5 px-4">Kontak Layanan</th>
                        <th class="py-3.5 px-4">Titik Maps</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($branches as $item)
                        @php
                            $typeBadge = match($item->type) {
                                'HEAD_OFFICE' => 'bg-amber-50 text-amber-800 border-amber-200',
                                'BRANCH' => 'bg-sky-50 text-sky-800 border-sky-200',
                                'CASH_OFFICE' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                default => 'bg-slate-50 text-slate-700 border-slate-200',
                            };
                            $mapsLink = $item->google_maps_url 
                                ?? ($item->latitude && $item->longitude 
                                    ? 'https://www.google.com/maps/search/?api=1&query=' . $item->latitude . ',' . $item->longitude 
                                    : null);
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-800 text-[13px] block">{{ $item->name }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold border {{ $typeBadge }} inline-block mt-1">
                                    {{ str_replace('_', ' ', $item->type) }}
                                </span>
                            </td>
                            <td class="py-4 px-4 max-w-xs">
                                <span class="text-slate-600 leading-relaxed block">{{ $item->address }}</span>
                                @if($item->city)
                                    <span class="text-[11px] text-slate-400 block mt-0.5">{{ $item->city }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 space-y-1">
                                <div class="font-mono text-slate-800 font-semibold flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span>{{ $item->phone }}</span>
                                </div>
                                @if($item->whatsapp)
                                    <div class="font-mono text-emerald-600 text-[11px] flex items-center gap-1.5">
                                        <span class="font-bold">WA:</span>
                                        <span>{{ $item->whatsapp }}</span>
                                    </div>
                                @endif
                                @if($item->email)
                                    <div>
                                        <a href="mailto:{{ $item->email }}" class="inline-flex items-center gap-1.5 text-[#0066B2] hover:underline text-[11px] font-medium" title="{{ $item->email }}">
                                            <svg class="w-3 h-3 text-[#0066B2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                            <span class="truncate max-w-[150px]">{{ $item->email }}</span>
                                        </a>
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                @if($mapsLink)
                                    <a href="{{ $mapsLink }}" target="_blank" 
                                       class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#F4F7FC] text-[#0066B2] hover:bg-[#0066B2] hover:text-white transition font-bold text-[10px] border border-slate-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>Buka Maps</span>
                                    </a>
                                @else
                                    <span class="text-slate-400 text-[11px] italic">-</span>
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
                                        Tutup
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.branches.edit', $item->id) }}" 
                                       class="p-2 text-slate-500 hover:text-[#0066B2] hover:bg-blue-50 rounded-lg transition" title="Edit Data Kantor">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    @if($item->type !== 'HEAD_OFFICE')
                                        <form action="{{ route('admin.branches.destroy', $item->id) }}" method="POST" 
                                              onsubmit="return confirm('Hapus kantor operasional ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                Belum ada unit kantor yang terdaftar atau sesuai dengan kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($branches->hasPages())
            <div class="p-4 border-t border-slate-100 flex justify-center">
                {{ $branches->links() }}
            </div>
        @endif
    </div>

</div>
@endsection