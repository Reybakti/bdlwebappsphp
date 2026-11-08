@extends('layouts.admin')

@section('title', 'Publikasi Keuangan & GCG')
@section('page_title', 'Laporan Publikasi & Tata Kelola (GCG)')
@section('page_subtitle', 'Kepatuhan transparansi publikasi laporan keuangan dan GCG sesuai regulasi OJK.')

@section('content')
<div class="space-y-6">

    <!-- Filter & Aksi -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
            <a href="{{ route('admin.reports.index') }}" 
               class="px-3.5 py-2 rounded-xl transition {{ !request('type') ? 'bg-[#0066B2] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Semua ({{ $counts['all'] }})
            </a>
            <a href="{{ route('admin.reports.index', ['type' => 'TRIWULAN_2']) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ str_contains(request('type', ''), 'TRIWULAN') ? 'bg-[#0066B2] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Triwulanan ({{ $counts['triwulan'] }})
            </a>
            <a href="{{ route('admin.reports.index', ['type' => 'TAHUNAN_AUDITED']) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ request('type') === 'TAHUNAN_AUDITED' ? 'bg-[#0066B2] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Diaudit KAP ({{ $counts['audited'] }})
            </a>
            <a href="{{ route('admin.reports.index', ['type' => 'GCG']) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ request('type') === 'GCG' ? 'bg-[#0066B2] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Laporan GCG ({{ $counts['gcg'] }})
            </a>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.reports.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0066B2] hover:bg-[#0A2540] text-white text-xs font-bold rounded-xl transition shadow-md shadow-[#0066B2]/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Unggah Laporan PDF</span>
            </a>
        </div>
    </div>

    <!-- Grid Dokumen Laporan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($reports as $item)
            @php
                $badge = match(true) {
                    str_contains($item->type, 'TRIWULAN') => 'bg-sky-50 text-sky-700 border-sky-200',
                    $item->type === 'TAHUNAN_AUDITED' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    $item->type === 'GCG' => 'bg-purple-50 text-purple-700 border-purple-200',
                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                };
            @endphp
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between space-y-4 hover:border-[#0066B2] transition">
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-xs">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $badge }}">
                            {{ str_replace('_', ' ', $item->type) }}
                        </span>
                        <span class="text-xs font-mono font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded-md">
                            Tahun {{ $item->year }}
                        </span>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold text-[#0A2540] leading-snug line-clamp-2">
                            {{ $item->title }}
                        </h3>
                        <span class="text-[11px] text-slate-400 font-medium block mt-1 font-mono">
                            Publikasi: {{ \Carbon\Carbon::parse($item->published_at)->translatedFormat('d M Y') }}
                        </span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <a href="{{ asset($item->file_url) }}" target="_blank" 
                       class="inline-flex items-center gap-1.5 font-bold text-[#0066B2] hover:underline text-[11px]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Unduh PDF</span>
                    </a>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.reports.edit', $item->id) }}" 
                           class="p-2 text-slate-500 hover:text-[#0066B2] hover:bg-blue-50 rounded-lg transition" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>

                        <form action="{{ route('admin.reports.destroy', $item->id) }}" method="POST" 
                              onsubmit="return confirm('Hapus dokumen laporan ini?');" class="inline">
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
            <div class="col-span-3 py-16 bg-white rounded-3xl border border-slate-200/80 text-center space-y-2">
                <svg class="w-12 h-12 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <h3 class="text-sm font-bold text-[#0A2540]">Belum Ada Laporan Terdaftar</h3>
                <p class="text-xs text-slate-400">Gunakan tombol "Unggah Laporan PDF" untuk menerbitkan dokumen baru.</p>
            </div>
        @endforelse
    </div>

    @if($reports->hasPages())
        <div class="p-4 bg-white rounded-2xl border border-slate-200/80 flex justify-center">
            {{ $reports->links() }}
        </div>
    @endif

</div>
@endsection