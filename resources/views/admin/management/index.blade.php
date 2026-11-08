@extends('layouts.admin')

@section('title', 'Direksi & Dewan Komisaris')
@section('page_title', 'Direksi & Dewan Komisaris')
@section('page_subtitle', 'Struktur tata kelola pengurus bank resmi sesuai prinsip kepatuhan Good Corporate Governance.')

@section('content')
<div class="space-y-6">

    <!-- Filter & Aksi -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
            <a href="{{ route('admin.management.index') }}" 
               class="px-3.5 py-2 rounded-xl transition {{ !request('type') ? 'bg-[#0066B2] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Semua Dewan ({{ $counts['all'] }})
            </a>
            <a href="{{ route('admin.management.index', ['type' => 'COMMISSIONER']) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ request('type') === 'COMMISSIONER' ? 'bg-[#0066B2] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Dewan Komisaris ({{ $counts['commissioners'] }})
            </a>
            <a href="{{ route('admin.management.index', ['type' => 'DIRECTOR']) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ request('type') === 'DIRECTOR' ? 'bg-[#0066B2] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Dewan Direksi ({{ $counts['directors'] }})
            </a>
        </div>

        <a href="{{ route('admin.management.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0066B2] hover:bg-[#0A2540] text-white text-xs font-bold rounded-xl transition shadow-md shadow-[#0066B2]/20 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Anggota Dewan</span>
        </a>
    </div>

    <!-- Grid Kartu Manajemen -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @forelse($members as $item)
            @php
                $isDirector = $item->type === 'DIRECTOR';
            @endphp
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-sm flex flex-col justify-between space-y-4 hover:border-[#0066B2] transition">
                <div class="space-y-4">
                    <!-- Foto & Badge -->
                    <div class="relative w-full aspect-square rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center">
                        @if($item->photo_url)
                            <img src="{{ asset($item->photo_url) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-slate-400 flex flex-col items-center">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span class="text-[10px] font-semibold mt-1">Tanpa Foto</span>
                            </div>
                        @endif

                        <div class="absolute top-2 left-2 flex items-center gap-1.5">
                            <span class="px-2 py-0.5 rounded-md text-[9px] font-bold font-mono bg-black/60 text-white backdrop-blur-md">
                                #{{ $item->order_index }}
                            </span>
                            <span class="px-2 py-0.5 rounded-md text-[9px] font-bold {{ $isDirector ? 'bg-[#0066B2] text-white' : 'bg-amber-500 text-white' }} shadow-sm">
                                {{ $item->type }}
                            </span>
                        </div>

                        <div class="absolute top-2 right-2">
                            @if($item->is_active)
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 ring-2 ring-white inline-block" title="Menjabat Aktif"></span>
                            @else
                                <span class="w-2.5 h-2.5 rounded-full bg-slate-400 ring-2 ring-white inline-block" title="Nonaktif"></span>
                            @endif
                        </div>
                    </div>

                    <!-- Identitas Pejabat -->
                    <div>
                        <span class="text-[11px] font-bold text-[#0066B2] uppercase block tracking-wider">{{ $item->title }}</span>
                        <h3 class="text-sm font-extrabold text-[#0A2540] leading-snug line-clamp-1 mt-0.5">{{ $item->name }}</h3>
                        <p class="text-[11px] text-slate-400 line-clamp-2 mt-2 leading-relaxed">
                            {{ $item->bio ?? 'Belum ada profil ringkas biodata.' }}
                        </p>
                    </div>
                </div>

                <!-- Aksi Bawah -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-[10px] text-slate-400 font-mono">
                        {{ $item->is_active ? 'Menjabat' : 'Tidak Menjabat' }}
                    </span>

                    <div class="flex items-center gap-1">
                        <a href="{{ route('admin.management.edit', $item->id) }}" 
                           class="p-2 text-slate-500 hover:text-[#0066B2] hover:bg-blue-50 rounded-lg transition" title="Edit Profil">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>

                        <form action="{{ route('admin.management.destroy', $item->id) }}" method="POST" 
                              onsubmit="return confirm('Hapus pejabat ini dari struktur kepengurusan?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 py-16 bg-white rounded-3xl border border-slate-200/80 text-center space-y-2">
                <svg class="w-12 h-12 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <h3 class="text-sm font-bold text-[#0A2540]">Belum Ada Anggota Dewan Terdaftar</h3>
                <p class="text-xs text-slate-400">Gunakan tombol "Tambah Anggota Dewan" untuk menyusun struktur kepengurusan.</p>
            </div>
        @endforelse
    </div>

    @if($members->hasPages())
        <div class="p-4 bg-white rounded-2xl border border-slate-200/80 flex justify-center">
            {{ $members->links() }}
        </div>
    @endif

</div>
@endsection