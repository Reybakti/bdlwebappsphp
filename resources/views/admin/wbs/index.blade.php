@extends('layouts.admin')

@section('title', 'Kanal Rahasia Whistleblowing (WBS)')
@section('page_title', 'Whistleblowing System (WBS)')
@section('page_subtitle', 'Pengawasan independen dugaan kecurangan, fraud, dan pelanggaran integritas.')

@section('content')
<div class="space-y-6">

    <!-- Banner Peringatan Kerahasiaan SKAI -->
    <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4 text-xs text-rose-800 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <div>
                <span class="font-bold block text-rose-900">Kanal Kepatuhan Bersifat Sangat Rahasia (Confidential)</span>
                <span class="text-[11px] text-rose-700">Akses hanya diberikan kepada Tim Audit Intern (SKAI) dan Direksi Bidang Kepatuhan. Lindungi privasi saksi dan pelapor.</span>
            </div>
        </div>
    </div>

    <!-- Filter Tab Status -->
    <div class="flex flex-wrap items-center justify-between gap-4 bg-white p-3 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
            <a href="{{ route('admin.wbs.index') }}" 
               class="px-3.5 py-2 rounded-xl transition {{ !request('status') ? 'bg-[#0066B2] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Semua Laporan ({{ $counts['all'] }})
            </a>
            <a href="{{ route('admin.wbs.index', ['status' => 'SUBMITTED']) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ request('status') === 'SUBMITTED' ? 'bg-rose-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Menunggu Telaah ({{ $counts['submitted'] }})
            </a>
            <a href="{{ route('admin.wbs.index', ['status' => 'INVESTIGATING']) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ request('status') === 'INVESTIGATING' ? 'bg-[#0284C7] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Proses Audit ({{ $counts['investigating'] }})
            </a>
            <a href="{{ route('admin.wbs.index', ['status' => 'CLOSED']) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ request('status') === 'CLOSED' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Kasus Ditutup ({{ $counts['closed'] }})
            </a>
        </div>

        <!-- Form Pencarian -->
        <form action="{{ route('admin.wbs.index') }}" method="GET" class="flex items-center gap-2 max-w-xs w-full">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode WBS, terlapor, lokasi..." 
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl pl-8 pr-3 py-2 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#0066B2] focus:bg-white transition">
                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <button type="submit" class="px-3 py-2 bg-[#0066B2] text-white text-xs font-bold rounded-xl hover:bg-[#0A2540] transition shrink-0">
                Cari
            </button>
            @if(request('q'))
                <a href="{{ route('admin.wbs.index', request()->only('status')) }}" class="text-xs font-bold text-rose-600 hover:underline">Reset</a>
            @endif
        </form>
    </div>

    <!-- Tabel Daftar WBS -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50/75 text-slate-400 uppercase font-semibold border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Kode Registrasi</th>
                        <th class="py-3.5 px-4">Klasifikasi Pelanggaran</th>
                        <th class="py-3.5 px-4">Pihak Terlapor</th>
                        <th class="py-3.5 px-4">Unit Kerja / Lokasi</th>
                        <th class="py-3.5 px-4">Status Anonim</th>
                        <th class="py-3.5 px-4">Status Investigasi</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($reports as $item)
                        @php
                            $badge = match($item->status) {
                                'SUBMITTED' => 'bg-rose-50 text-rose-700 border-rose-200',
                                'INVESTIGATING' => 'bg-sky-50 text-sky-700 border-sky-200',
                                'CLOSED' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                default => 'bg-slate-50 text-slate-700 border-slate-200',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6">
                                <span class="font-mono font-bold text-rose-700 block text-[13px]">{{ $item->registration_code }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y, H:i') }} WIB</span>
                            </td>
                            <td class="py-4 px-4 font-semibold text-slate-800">
                                {{ str_replace('_', ' ', $item->violation_type) }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="font-bold text-slate-800 block">{{ $item->involved_parties }}</span>
                            </td>
                            <td class="py-4 px-4 text-slate-600">
                                {{ $item->incident_location }}
                            </td>
                            <td class="py-4 px-4">
                                @if($item->is_anonymous)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        ANONIM
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-[#0066B2] border border-blue-200">
                                        {{ $item->reporter_name }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $badge }} inline-block">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.wbs.show', $item->id) }}" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#F4F7FC] hover:bg-[#0066B2] hover:text-white text-[#0066B2] font-bold rounded-xl transition shadow-sm text-xs">
                                    <span>Periksa Kasus</span>
                                    <span>&rarr;</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Belum ada laporan dugaan pelanggaran WBS yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reports->hasPages())
            <div class="p-4 border-t border-slate-100 flex justify-center">
                {{ $reports->links() }}
            </div>
        @endif
    </div>

</div>
@endsection