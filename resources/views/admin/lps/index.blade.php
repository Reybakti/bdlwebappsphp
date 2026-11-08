@extends('layouts.admin')

@section('title', 'Tingkat Bunga Penjaminan LPS')
@section('page_title', 'Tingkat Bunga Penjaminan LPS')
@section('page_subtitle', 'Penetapan kepatuhan suku bunga maksimum simpanan berpenjaminan Lembaga Penjamin Simpanan.')

@section('content')
<div class="space-y-6">

    <!-- Hero Card Tingkat Bunga Aktif Saat Ini -->
    <div class="bg-gradient-to-br from-[#0A2540] via-[#0066B2] to-[#0A2540] rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 relative z-10">
            <div class="space-y-2 max-w-xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-400/20 text-emerald-300 text-[11px] font-bold font-mono tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    STATUS PENJAMINAN AKTIF
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Suku Bunga Penjaminan BPR Berlaku
                </h2>
                <p class="text-xs text-slate-200 leading-relaxed">
                    Setiap simpanan (Tabungan & Deposito) yang melebihi suku bunga ini dinyatakan <strong>tidak dijamin</strong> oleh LPS sesuai ketentuan regulasi UU Perbankan & LPS.
                </p>
            </div>

            @if($currentRate)
                <div class="flex items-center gap-6 bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/20 shrink-0">
                    <div class="text-center sm:text-right">
                        <span class="text-[11px] text-slate-300 block font-semibold">Maksimum Rupiah (IDR)</span>
                        <span class="text-4xl font-extrabold font-mono text-white tracking-tight">
                            {{ number_format($currentRate->rate_idr, 2) }}%
                        </span>
                        <span class="text-[10px] text-slate-300 block font-mono mt-1">
                            {{ \Carbon\Carbon::parse($currentRate->effective_start_date)->translatedFormat('d M Y') }} s.d. {{ \Carbon\Carbon::parse($currentRate->effective_end_date)->translatedFormat('d M Y') }}
                        </span>
                    </div>
                </div>
            @else
                <div class="p-4 bg-amber-500/20 border border-amber-300/30 rounded-2xl text-xs text-amber-200">
                    Belum ada ketetapan suku bunga yang diaktifkan.
                </div>
            @endif
        </div>
    </div>

    <!-- Bar Aksi Riwayat -->
    <div class="flex items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h3 class="text-sm font-bold text-[#0A2540]">Riwayat Ketetapan Berkala LPS</h3>
            <p class="text-xs text-slate-400 mt-0.5">Daftar penyesuaian suku bunga penjaminan dari waktu ke waktu</p>
        </div>

        <a href="{{ route('admin.lps.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0066B2] hover:bg-[#0A2540] text-white text-xs font-bold rounded-xl transition shadow-md shadow-[#0066B2]/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tetapkan Bunga Baru</span>
        </a>
    </div>

    <!-- Tabel Riwayat Suku Bunga -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50/75 text-slate-400 uppercase font-semibold border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Bunga Simpanan IDR</th>
                        <th class="py-3.5 px-4">Bunga Valas</th>
                        <th class="py-3.5 px-4">Periode Masa Berlaku</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($rateHistories as $item)
                        <tr class="hover:bg-slate-50/80 transition {{ $item->is_current ? 'bg-blue-50/30' : '' }}">
                            <td class="py-4 px-6 font-mono">
                                <span class="text-base font-extrabold text-[#0066B2]">{{ number_format($item->rate_idr, 2) }}%</span>
                                <span class="text-[10px] text-slate-400 block font-sans">p.a. (per annum)</span>
                            </td>
                            <td class="py-4 px-4 font-mono text-slate-600">
                                {{ number_format($item->rate_valas, 2) }}%
                            </td>
                            <td class="py-4 px-4 font-mono">
                                <span class="font-bold text-slate-800 block">
                                    {{ \Carbon\Carbon::parse($item->effective_start_date)->translatedFormat('d F Y') }}
                                </span>
                                <span class="text-slate-400 text-[11px]">
                                    s.d. {{ \Carbon\Carbon::parse($item->effective_end_date)->translatedFormat('d F Y') }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                @if($item->is_current)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        BERLAKU AKTIF
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        Kedaluwarsa
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    @if(!$item->is_current)
                                        <form action="{{ route('admin.lps.set_current', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1.5 bg-[#F4F7FC] hover:bg-emerald-600 hover:text-white text-emerald-700 font-bold rounded-xl transition text-[11px]" title="Jadikan suku bunga acuan aktif">
                                                Aktifkan
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('admin.lps.edit', $item->id) }}" class="p-2 text-slate-500 hover:text-[#0066B2] hover:bg-blue-50 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    @if(!$item->is_current)
                                        <form action="{{ route('admin.lps.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat suku bunga ini?');" class="inline">
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
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                Belum ada ketetapan suku bunga penjaminan LPS.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rateHistories->hasPages())
            <div class="p-4 border-t border-slate-100 flex justify-center">
                {{ $rateHistories->links() }}
            </div>
        @endif
    </div>

</div>
@endsection