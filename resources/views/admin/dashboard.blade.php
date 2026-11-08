@extends('layouts.admin')

@section('title', 'Dashboard Backoffice')
@section('page_title', 'Ringkasan Eksekutif')
@section('page_subtitle', 'Pemantauan indikator kinerja pelayanan, kepatuhan OJK/LPS, dan operasional bank secara real-time.')

@section('content')
<div class="space-y-6">

    <!-- ========================================== -->
    <!-- 1. ROW ATAS: 4 STAT METRIC CARDS           -->
    <!-- ========================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Pengaduan Masuk -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 block">Pengaduan Nasabah</span>
                <span class="text-2xl font-extrabold text-[#0A2540] font-mono block">{{ $pendingComplaintsCount }}</span>
                <span class="text-[11px] {{ $pendingComplaintsCount > 0 ? 'text-amber-600' : 'text-emerald-600' }} font-semibold flex items-center gap-1">
                    <span>●</span> {{ $pendingComplaintsCount > 0 ? $pendingComplaintsCount . ' Menunggu Penanganan' : 'Semua Tiket Ditangani' }}
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
        </div>

        <!-- Laporan Dugaan Fraud (WBS) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 block">Laporan WBS</span>
                <span class="text-2xl font-extrabold text-rose-600 font-mono block">{{ $submittedWbsCount }}</span>
                <span class="text-[11px] text-rose-600 font-semibold flex items-center gap-1">
                    <span>●</span> Kanal Pengawasan SKAI
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>

        <!-- Katalog Produk Aktif -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 block">Katalog Produk</span>
                <span class="text-2xl font-extrabold text-[#0066B2] font-mono block">{{ $activeProductsCount }}</span>
                <span class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1">
                    <span>↑</span> Aktif di Portal Publik
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#0066B2] flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <!-- Jaringan Kantor -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 block">Jaringan Kantor</span>
                <span class="text-2xl font-extrabold text-[#0A2540] font-mono block">{{ $activeBranchesCount }}</span>
                <span class="text-[11px] text-slate-400">Pusat, Cabang & Kas</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- 2. ROW TENGAH: GAUGE METERS & ACTIVITY COLUMN BARS       -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">
        
        <!-- Circular Progress Ring (Tingkat Efektivitas Layanan Dinamis) -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-[#0A2540]">Tingkat Efektivitas Layanan</h3>
                <span class="text-[11px] font-semibold text-slate-400">POJK 22/2023</span>
            </div>

            <div class="grid grid-cols-2 gap-4 my-6">
                
                <!-- Gauge 1: SLA Pengaduan -->
                <div class="text-center space-y-2">
                    <div class="relative w-28 h-28 mx-auto flex items-center justify-center">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-slate-100" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-[#0066B2]" stroke-dasharray="{{ $complaintSlaRate }}, 100" stroke-width="3.5" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-xl font-extrabold text-[#0A2540] font-mono leading-none">{{ $complaintSlaRate }}%</span>
                        </div>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-slate-700 block">SLA Tiket Selesai</span>
                        <span class="text-[10px] text-slate-400 block">{{ $totalComplaintsCount }} Total Pengaduan</span>
                    </div>
                </div>

                <!-- Gauge 2: Respons WBS -->
                <div class="text-center space-y-2">
                    <div class="relative w-28 h-28 mx-auto flex items-center justify-center">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-slate-100" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-emerald-500" stroke-dasharray="{{ $wbsResponseRate }}, 100" stroke-width="3.5" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-xl font-extrabold text-[#0A2540] font-mono leading-none">{{ $wbsResponseRate }}%</span>
                        </div>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-slate-700 block">Tindak Lanjut WBS</span>
                        <span class="text-[10px] text-slate-400 block">{{ $totalWbsCount }} Laporan Masuk</span>
                    </div>
                </div>

            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                <span class="inline-flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-[#0066B2]"></span> Pengaduan Nasabah</span>
                <span class="inline-flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Pengawasan Internal</span>
            </div>
        </div>

        <!-- Activity Column Bars Chart (Dihitung Real Berdasarkan Bulan Database) -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-sm font-bold text-[#0A2540]">Aktivitas Pengaduan Bulanan</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Perbandingan tiket masuk vs penyelesaian tahun {{ $currentYear }}</p>
                </div>
                <div class="text-[11px] font-semibold text-[#0066B2] bg-[#F4F7FC] px-3 py-1 rounded-full border border-slate-200">
                    Tahun {{ $currentYear }}
                </div>
            </div>

            <div class="h-44 flex items-end justify-between gap-2 sm:gap-3 pt-6 pb-2 px-1 sm:px-2">
                @foreach($chartData as $bar)
                    <div class="flex flex-col items-center gap-1.5 flex-1 h-full justify-end group">
                        <div class="w-full flex items-end justify-center gap-1 h-32" title="{{ $bar['name'] }}: {{ $bar['in'] }} Masuk, {{ $bar['resolved'] }} Selesai">
                            <!-- Bar 1: Tiket Masuk -->
                            <div style="height: {{ $bar['in_height'] }}%;" class="w-2 sm:w-2.5 bg-[#0066B2] rounded-t-full transition-all group-hover:brightness-110"></div>
                            <!-- Bar 2: Tiket Selesai -->
                            <div style="height: {{ $bar['res_height'] }}%;" class="w-2 sm:w-2.5 bg-[#63B3ED] rounded-t-full transition-all group-hover:brightness-110"></div>
                        </div>
                        <span class="text-[10px] font-semibold text-slate-400">{{ $bar['name'] }}</span>
                    </div>
                @endforeach
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded bg-[#0066B2]"></span> Tiket Masuk</span>
                    <span class="inline-flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded bg-[#63B3ED]"></span> Penyelesaian Tiket</span>
                </div>
                <span class="text-emerald-600 font-bold font-mono">Efisiensi: {{ $complaintSlaRate }}%</span>
            </div>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- 3. ROW SOLID COLOR METRIC BANNERS                        -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        
        <!-- Banner 1: Laporan Kepatuhan Transparansi -->
        <div class="bg-[#0066B2] text-white rounded-3xl p-6 shadow-md shadow-[#0066B2]/20 flex flex-col justify-between relative overflow-hidden">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-white/80 block">Kepatuhan Regulasi</span>
                <span class="text-3xl font-extrabold font-mono block">{{ $totalReportsCount }}</span>
                <p class="text-xs text-white/85 pt-1 leading-relaxed">
                    Dokumen Laporan Keuangan Publikasi & Tata Kelola (GCG) resmi terbit.
                </p>
            </div>
            <div class="pt-4 border-t border-white/20 mt-4 flex items-center justify-between text-xs font-semibold">
                <a href="{{ route('admin.reports.index') }}" class="hover:underline">Buka Laporan Regulasi &rarr;</a>
                <span class="bg-white/20 px-2 py-0.5 rounded-full text-[10px]">Terdokumentasi</span>
            </div>
        </div>

        <!-- Banner 2: Warta & Artikel -->
        <div class="bg-[#0284C7] text-white rounded-3xl p-6 shadow-md shadow-sky-600/20 flex flex-col justify-between relative overflow-hidden">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-white/80 block">Warta & Literasi</span>
                <span class="text-3xl font-extrabold font-mono block">{{ $totalArticlesCount }}</span>
                <p class="text-xs text-white/85 pt-1 leading-relaxed">
                    Artikel warta kegiatan operasional dan konten edukasi keuangan terbit.
                </p>
            </div>
            <div class="pt-4 border-t border-white/20 mt-4 flex items-center justify-between text-xs font-semibold">
                <a href="{{ route('admin.articles.index') }}" class="hover:underline">Kelola Naskah Berita &rarr;</a>
                <span class="bg-white/20 px-2 py-0.5 rounded-full text-[10px]">Aktif</span>
            </div>
        </div>

        <!-- Banner 3: Lowongan Karier Terbuka -->
        <div class="bg-[#0D9488] text-white rounded-3xl p-6 shadow-md shadow-teal-600/20 flex flex-col justify-between relative overflow-hidden">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-white/80 block">Rekrutmen SDM</span>
                <span class="text-3xl font-extrabold font-mono block">{{ $activeCareersCount }}</span>
                <p class="text-xs text-white/85 pt-1 leading-relaxed">
                    Formasi penerimaan pegawai bank yang sedang aktif menerima pendaftaran.
                </p>
            </div>
            <div class="pt-4 border-t border-white/20 mt-4 flex items-center justify-between text-xs font-semibold">
                <a href="{{ route('admin.careers.index') }}" class="hover:underline">Kelola Formasi &rarr;</a>
                <span class="bg-white/20 px-2 py-0.5 rounded-full text-[10px]">Terbuka</span>
            </div>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- 4. ROW BAWAH: TABEL PENGADUAN & KATEGORI LAYANAN         -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        
        <!-- Tabel Pengaduan Nasabah Terkini (Data Riil) -->
        <div class="lg:col-span-8 bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-sm font-bold text-[#0A2540]">Pengaduan Nasabah Terkini</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Tiket terbaru yang terdaftar dalam sistem pengaduan POJK 22/2023</p>
                </div>
                <a href="{{ route('admin.complaints.index') }}" class="text-xs font-bold text-[#0066B2] hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="text-slate-400 font-semibold border-b border-slate-100 uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="pb-3">No. Tiket</th>
                            <th class="pb-3">Nama Nasabah</th>
                            <th class="pb-3">Kategori</th>
                            <th class="pb-3">Tanggal</th>
                            <th class="pb-3 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($latestComplaints as $complaint)
                            @php
                                $statusBadge = match($complaint->status) {
                                    'RECEIVED' => 'bg-amber-50 text-amber-800 border-amber-200',
                                    'IN_REVIEW' => 'bg-sky-50 text-sky-800 border-sky-200',
                                    'RESOLVED' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                    'REJECTED' => 'bg-rose-50 text-rose-800 border-rose-200',
                                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 font-mono font-bold text-[#0066B2]">
                                    <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="hover:underline">
                                        {{ $complaint->ticket_code }}
                                    </a>
                                </td>
                                <td class="py-3 font-semibold text-slate-800">{{ $complaint->full_name }}</td>
                                <td class="py-3 text-slate-600">{{ $complaint->category }}</td>
                                <td class="py-3 text-slate-400 text-[11px]">{{ $complaint->created_at->format('d/m/Y') }}</td>
                                <td class="py-3 text-right">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $statusBadge }}">
                                        {{ $complaint->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">Belum ada pengaduan nasabah yang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Ringkasan Kategori Pengaduan Terbanyak (Data Riil) -->
        <div class="lg:col-span-4 bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-[#0A2540]">Kategori Pengaduan</h3>
                <span class="text-[10px] font-semibold text-slate-400 font-mono">{{ $totalComplaintsCount }} Total</span>
            </div>

            <div class="space-y-3.5">
                @forelse($complaintCategories as $categoryItem)
                    @php
                        $pct = $totalComplaintsCount > 0 ? round(($categoryItem->total / $totalComplaintsCount) * 100) : 0;
                    @endphp
                    <div class="space-y-1.5 text-xs">
                        <div class="flex items-center justify-between text-slate-700 font-semibold">
                            <span class="truncate max-w-[180px]">{{ $categoryItem->category }}</span>
                            <span class="font-mono text-slate-900 font-bold">{{ $categoryItem->total }} ({{ $pct }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-[#0066B2] h-full rounded-full" style="width: {{ $pct }}%;"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada kategori pengaduan.</p>
                @endforelse
            </div>

            <div class="pt-3 border-t border-slate-100 text-center">
                <a href="{{ route('admin.wbs.index') }}" class="text-[11px] font-bold text-rose-600 hover:underline">
                    Periksa Kanal Khusus WBS &rarr;
                </a>
            </div>
        </div>

    </div>

</div>
@endsection