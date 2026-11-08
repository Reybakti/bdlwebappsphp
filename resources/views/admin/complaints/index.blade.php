@extends('layouts.admin')

@section('title', 'Kelola Pengaduan Nasabah')
@section('page_title', 'Pengaduan Nasabah (POJK 22/2023)')
@section('page_subtitle', 'Pusat tindak lanjut dan penanganan keluhan nasabah perbankan.')

@section('content')
<div class="space-y-6">

    <!-- Tab Filter Status Bergaya Pill Novo Dashboard -->
    <div class="flex flex-wrap items-center justify-between gap-4 bg-white p-3 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
            <a href="{{ route('admin.complaints.index') }}" 
               class="px-3.5 py-2 rounded-xl transition {{ !request('status') ? 'bg-[#0066B2] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Semua ({{ $counts['all'] }})
            </a>
            <a href="{{ route('admin.complaints.index', ['status' => 'PENDING']) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ request('status') === 'PENDING' ? 'bg-amber-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Menunggu ({{ $counts['pending'] }})
            </a>
            <a href="{{ route('admin.complaints.index', ['status' => 'IN_PROGRESS']) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ request('status') === 'IN_PROGRESS' ? 'bg-[#0284C7] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Diproses ({{ $counts['in_progress'] }})
            </a>
            <a href="{{ route('admin.complaints.index', ['status' => 'RESOLVED']) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ request('status') === 'RESOLVED' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Selesai ({{ $counts['resolved'] }})
            </a>
            <a href="{{ route('admin.complaints.index', ['status' => 'REJECTED']) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ request('status') === 'REJECTED' ? 'bg-rose-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Ditolak ({{ $counts['rejected'] }})
            </a>
        </div>

        <!-- Form Pencarian Cepat -->
        <form action="{{ route('admin.complaints.index') }}" method="GET" class="flex items-center gap-2 max-w-xs w-full">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari tiket, nasabah, NIK..." 
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl pl-8 pr-3 py-2 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#0066B2] focus:bg-white transition">
                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <button type="submit" class="px-3 py-2 bg-[#0066B2] text-white text-xs font-bold rounded-xl hover:bg-[#0A2540] transition shrink-0">
                Cari
            </button>
            @if(request('q'))
                <a href="{{ route('admin.complaints.index', request()->only('status')) }}" class="text-xs font-bold text-rose-600 hover:underline">Reset</a>
            @endif
        </form>
    </div>

    <!-- Tabel Data Pengaduan -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50/75 text-slate-400 uppercase font-semibold border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Tiket & Tanggal</th>
                        <th class="py-3.5 px-4">Nasabah</th>
                        <th class="py-3.5 px-4">Kategori Produk</th>
                        <th class="py-3.5 px-4">Pokok Masalah</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($complaints as $item)
                        @php
                            $badge = match($item->status) {
                                'PENDING' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'IN_PROGRESS' => 'bg-sky-50 text-sky-700 border-sky-200',
                                'RESOLVED' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'REJECTED' => 'bg-rose-50 text-rose-700 border-rose-200',
                                default => 'bg-slate-50 text-slate-700 border-slate-200',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6">
                                <span class="font-mono font-bold text-[#0066B2] block text-[13px]">{{ $item->ticket_number }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y, H:i') }} WIB</span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="font-bold text-slate-800 block">{{ $item->customer_name }}</span>
                                <span class="text-[11px] text-slate-500 font-mono">NIK: {{ substr($item->nik, 0, 6) }}******{{ substr($item->nik, -4) }}</span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-[#F4F7FC] text-[#0A2540] border border-slate-200 uppercase">
                                    {{ $item->category }}
                                </span>
                            </td>
                            <td class="py-4 px-4 max-w-xs">
                                <span class="font-semibold text-slate-800 line-clamp-1 block">{{ $item->subject }}</span>
                                <span class="text-[11px] text-slate-400 line-clamp-1">{{ $item->description }}</span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $badge }} inline-block">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.complaints.show', $item->id) }}" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#F4F7FC] hover:bg-[#0066B2] hover:text-white text-[#0066B2] font-bold rounded-xl transition shadow-sm text-xs">
                                    <span>Tindak Lanjut</span>
                                    <span>&rarr;</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Tidak ada data pengaduan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($complaints->hasPages())
            <div class="p-4 border-t border-slate-100 flex justify-center">
                {{ $complaints->links() }}
            </div>
        @endif
    </div>

</div>
@endsection