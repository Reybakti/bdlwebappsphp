@extends('layouts.admin')

@section('title', 'Direktori Portal & Tautan Situs')
@section('page_title', 'Direktori Portal Informasi')
@section('page_subtitle', 'Kelola daftar tautan regulator, portal mitra pemda, dan akses layanan publik.')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.portals.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 flex-1">
            <select name="category" onchange="this.form.submit()" class="text-xs bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2 font-semibold text-slate-700 focus:outline-none focus:border-[#0066B2]">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cKey => $cName)
                    <option value="{{ $cKey }}" {{ request('category') === $cKey ? 'selected' : '' }}>{{ $cName }}</option>
                @endforeach
            </select>

            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama portal, alamat web..." 
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl pl-8 pr-3 py-2 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#0066B2] focus:bg-white transition">
                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <button type="submit" class="px-4 py-2 bg-[#0066B2] text-white text-xs font-bold rounded-xl hover:bg-[#0A2540] transition">Filter</button>
            @if(request()->anyFilled(['category', 'q']))
                <a href="{{ route('admin.portals.index') }}" class="text-xs font-bold text-rose-600 hover:underline px-2">Reset</a>
            @endif
        </form>

        <a href="{{ route('admin.portals.create') }}" class="px-5 py-2.5 bg-[#0066B2] hover:bg-[#0A2540] text-white text-xs font-bold rounded-xl transition shadow-sm whitespace-nowrap">
            + Tambah Portal Baru
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50/75 text-slate-400 uppercase font-semibold border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Nama Portal & Tautan</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Keterangan</th>
                        <th class="py-3.5 px-4">Urutan</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($links as $link)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-800 block text-xs">{{ $link->title }}</span>
                                <a href="{{ $link->url }}" target="_blank" class="text-[11px] text-[#0066B2] hover:underline font-mono truncate max-w-xs block mt-0.5">
                                    {{ $link->url }} &nearr;
                                </a>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $link->category }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-slate-500 max-w-xs">
                                <span class="line-clamp-2">{{ $link->description ?? '-' }}</span>
                            </td>
                            <td class="py-4 px-4 font-mono font-semibold text-slate-800">
                                {{ $link->order_index }}
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $link->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                    {{ $link->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap space-x-2">
                                <a href="{{ route('admin.portals.edit', $link->id) }}" class="text-[#0066B2] font-bold hover:underline">Edit</a>
                                <form action="{{ route('admin.portals.destroy', $link->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tautan portal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 font-bold hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">Belum ada tautan portal yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($links->hasPages())
            <div class="p-4 border-t border-slate-100 flex justify-center">
                {{ $links->links() }}
            </div>
        @endif
    </div>

</div>
@endsection