@extends('layouts.admin')

@section('title', 'Program CSR & Keberlanjutan')
@section('page_title', 'Tanggung Jawab Sosial (CSR)')
@section('page_subtitle', 'Publikasi kegiatan sosial kemasyarakatan, pemberdayaan UMKM daerah, dan pelestarian lingkungan.')

@section('content')
<div class="space-y-6">

    <!-- Filter & Tombol Tambah Program CSR -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.csr.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 w-full sm:w-auto flex-1">
            
            <select name="category" onchange="this.form.submit()" class="text-xs bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2 font-semibold text-slate-700 focus:outline-none focus:border-[#0066B2]">
                <option value="">Semua Kategori Pilar</option>
                <option value="PEMBERDAYAAN_UMKM" {{ request('category') === 'PEMBERDAYAAN_UMKM' ? 'selected' : '' }}>Pemberdayaan UMKM</option>
                <option value="PENDIDIKAN_LITERASI" {{ request('category') === 'PENDIDIKAN_LITERASI' ? 'selected' : '' }}>Pendidikan & Literasi</option>
                <option value="SOSIAL_KEMASYARAKATAN" {{ request('category') === 'SOSIAL_KEMASYARAKATAN' ? 'selected' : '' }}>Sosial Kemasyarakatan</option>
                <option value="LINGKUNGAN_HIDUP" {{ request('category') === 'LINGKUNGAN_HIDUP' ? 'selected' : '' }}>Lingkungan Hidup</option>
            </select>

            <select name="status" onchange="this.form.submit()" class="text-xs bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2 font-semibold text-slate-700 focus:outline-none focus:border-[#0066B2]">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Terbit ({{ $counts['published'] }})</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draf ({{ $counts['draft'] }})</option>
            </select>

            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kegiatan, lokasi kecamatan..." 
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl pl-8 pr-3 py-2 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#0066B2] focus:bg-white transition">
                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <button type="submit" class="px-4 py-2 bg-[#0066B2] text-white text-xs font-bold rounded-xl hover:bg-[#0A2540] transition">
                Cari
            </button>
            @if(request()->anyFilled(['category', 'status', 'q']))
                <a href="{{ route('admin.csr.index') }}" class="text-xs font-bold text-rose-600 hover:underline px-2">Reset</a>
            @endif
        </form>

        <a href="{{ route('admin.csr.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0066B2] hover:bg-[#0A2540] text-white text-xs font-bold rounded-xl transition shadow-md shadow-[#0066B2]/20 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Program CSR</span>
        </a>
    </div>

    <!-- Tabel Program CSR -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50/75 text-slate-400 uppercase font-semibold border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Kegiatan & Tanggal</th>
                        <th class="py-3.5 px-4">Pilar Kategori</th>
                        <th class="py-3.5 px-4">Lokasi Pelaksanaan</th>
                        <th class="py-3.5 px-4">Realisasi Dana</th>
                        <th class="py-3.5 px-4">Dokumen</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($programs as $item)
                        @php
                            $categoryBadge = match($item->category) {
                                'PEMBERDAYAAN_UMKM' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                'PENDIDIKAN_LITERASI' => 'bg-sky-50 text-sky-800 border-sky-200',
                                'SOSIAL_KEMASYARAKATAN' => 'bg-amber-50 text-amber-800 border-amber-200',
                                'LINGKUNGAN_HIDUP' => 'bg-teal-50 text-teal-800 border-teal-200',
                                default => 'bg-slate-50 text-slate-700 border-slate-200',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6 max-w-md">
                                <div class="flex items-center gap-3">
                                    @if($item->image_url)
                                        <img src="{{ asset($item->image_url) }}" alt="Dokumentasi" class="w-12 h-12 rounded-xl object-cover border border-slate-200 shrink-0">
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center shrink-0 border border-slate-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <span class="font-bold text-slate-800 text-[13px] leading-snug line-clamp-1 block">{{ $item->title }}</span>
                                        <span class="text-[10px] text-slate-400 font-mono mt-0.5 block">
                                            {{ \Carbon\Carbon::parse($item->activity_date)->translatedFormat('d F Y') }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
    @if($item->document_url)
        <a href="{{ asset($item->document_url) }}" target="_blank" 
           class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-blue-50 text-[#0066B2] hover:bg-[#0066B2] hover:text-white transition font-bold text-[10px] border border-blue-200" title="{{ $item->document_name ?? 'Dokumen CSR' }}">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>Unduh Berkas</span>
        </a>
    @else
        <span class="text-slate-400 text-[10px] italic">-</span>
    @endif
</td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $categoryBadge }}">
                                    {{ str_replace('_', ' ', $item->category) }}
                                </span>
                            </td>
                            <td class="py-4 px-4 font-semibold text-slate-700">
                                {{ $item->location }}
                            </td>
                            <td class="py-4 px-4 font-mono font-bold text-[#0066B2]">
                                {{ $item->budget_amount ? 'Rp ' . number_format($item->budget_amount, 0, ',', '.') : '-' }}
                            </td>
                            <td class="py-4 px-4">
                                @if($item->is_published)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Terbit
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        Draf
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.csr.edit', $item->id) }}" 
                                       class="p-2 text-slate-500 hover:text-[#0066B2] hover:bg-blue-50 rounded-lg transition" title="Edit CSR">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <form action="{{ route('admin.csr.destroy', $item->id) }}" method="POST" 
                                          onsubmit="return confirm('Hapus program CSR ini?');" class="inline">
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
                                Belum ada publikasi program CSR yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($programs->hasPages())
            <div class="p-4 border-t border-slate-100 flex justify-center">
                {{ $programs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection