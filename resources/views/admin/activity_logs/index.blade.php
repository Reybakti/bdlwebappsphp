@extends('layouts.admin')

@section('title', 'Audit Trail & Log Aktivitas')
@section('page_title', 'Audit Trail Log Aktivitas')
@section('page_subtitle', 'Rekam jejak digital audit kepatuhan, autentikasi, dan riwayat manipulasi data sistem.')

@section('content')
<div class="space-y-6">

    <!-- Filter & Pencarian -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.activity_logs.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 w-full">
            
            <!-- Filter Modul -->
            <select name="module" onchange="this.form.submit()" class="text-xs bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2 font-semibold text-slate-700 focus:outline-none focus:border-[#0066B2]">
                <option value="">Semua Modul</option>
                @foreach($modules as $mod)
                    <option value="{{ $mod }}" {{ request('module') === $mod ? 'selected' : '' }}>{{ $mod }}</option>
                @endforeach
            </select>

            <!-- Filter Aksi -->
            <select name="action" onchange="this.form.submit()" class="text-xs bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2 font-semibold text-slate-700 focus:outline-none focus:border-[#0066B2]">
                <option value="">Semua Tipe Aksi</option>
                <option value="LOGIN" {{ request('action') === 'LOGIN' ? 'selected' : '' }}>LOGIN</option>
                <option value="LOGOUT" {{ request('action') === 'LOGOUT' ? 'selected' : '' }}>LOGOUT</option>
                <option value="CREATE" {{ request('action') === 'CREATE' ? 'selected' : '' }}>CREATE</option>
                <option value="UPDATE" {{ request('action') === 'UPDATE' ? 'selected' : '' }}>UPDATE</option>
                <option value="DELETE" {{ request('action') === 'DELETE' ? 'selected' : '' }}>DELETE</option>
            </select>

            <!-- Search Field -->
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari keterangan, nama staf, IP address..." 
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl pl-8 pr-3 py-2 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#0066B2] focus:bg-white transition">
                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <button type="submit" class="px-4 py-2 bg-[#0066B2] text-white text-xs font-bold rounded-xl hover:bg-[#0A2540] transition">
                Filter
            </button>
            @if(request()->anyFilled(['module', 'action', 'q']))
                <a href="{{ route('admin.activity_logs.index') }}" class="text-xs font-bold text-rose-600 hover:underline px-2">Reset</a>
            @endif
        </form>
    </div>

    <!-- Tabel Audit Log -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50/75 text-slate-400 uppercase font-semibold border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6 whitespace-nowrap">Waktu Kejadian</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Pengguna & Peran</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Modul & Aksi</th>
                        <th class="py-3.5 px-4 min-w-[280px]">Deskripsi Aktivitas</th>
                        <th class="py-3.5 px-6 min-w-[200px]">IP Address & Perangkat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 align-top">
                    @forelse($logs as $log)
                        @php
                            $actionBadge = match($log->action) {
                                'LOGIN' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'LOGOUT' => 'bg-slate-100 text-slate-600 border-slate-200',
                                'CREATE' => 'bg-sky-50 text-sky-700 border-sky-200',
                                'UPDATE' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'DELETE' => 'bg-rose-50 text-rose-700 border-rose-200',
                                'FAILED_LOGIN' => 'bg-rose-100 text-rose-800 border-rose-300',
                                default => 'bg-slate-50 text-slate-700 border-slate-200',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Waktu Kejadian -->
                            <td class="py-4 px-6 whitespace-nowrap font-mono text-slate-500 text-[11px]">
                                <span class="font-bold text-slate-800 block text-xs">{{ $log->created_at->translatedFormat('d M Y') }}</span>
                                <span>{{ $log->created_at->format('H:i:s') }} WIB</span>
                            </td>

                            <!-- Pengguna & Peran -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="font-bold text-slate-800 block text-xs">{{ $log->user_name }}</span>
                                <span class="text-[10px] text-slate-400 font-mono uppercase">{{ str_replace('_', ' ', $log->user_role) }}</span>
                            </td>

                            <!-- Modul & Aksi -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-slate-100 text-slate-700 border border-slate-200 block w-fit mb-1.5">
                                    {{ $log->module }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $actionBadge }} inline-block">
                                    {{ $log->action }}
                                </span>
                            </td>

                            <!-- Deskripsi Aktivitas (Lengkap Tanpa Terpotong) -->
                            <td class="py-4 px-4 whitespace-normal break-words leading-relaxed">
                                <span class="text-slate-800 font-medium block">{{ $log->description }}</span>
                                
                                @if($log->changes)
                                    <details class="mt-2 group">
                                        <summary class="text-[10px] text-[#0066B2] hover:text-[#0A2540] cursor-pointer font-bold select-none inline-flex items-center gap-1">
                                            <span>Lihat Rincian Perubahan Data</span>
                                            <span class="group-open:rotate-180 transition-transform text-[9px]">&darr;</span>
                                        </summary>
                                        <pre class="text-[10px] font-mono bg-slate-900 text-slate-200 p-3 rounded-xl mt-1.5 overflow-x-auto whitespace-pre-wrap break-all max-h-60 overflow-y-auto leading-relaxed border border-slate-800 shadow-inner">{{ json_encode($log->changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </details>
                                @endif
                            </td>

                            <!-- IP Address & User Agent (Teks Utuh) -->
                            <td class="py-4 px-6 whitespace-normal break-words font-mono text-[11px] leading-relaxed">
                                <span class="font-bold text-slate-800 block">{{ $log->ip_address }}</span>
                                <span class="text-[10px] text-slate-400 break-all block mt-0.5">
                                    {{ $log->user_agent }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                Belum ada aktivitas yang terekam pada filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="p-4 border-t border-slate-100 flex justify-center">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection