@extends('layouts.admin')

@section('title', 'Manajemen Pengguna & Otorisasi')
@section('page_title', 'Manajemen Pengguna & Hak Akses')
@section('page_subtitle', 'Pengelolaan akun pegawai operasional, pembagian peran RBAC, dan audit status akun.')

@section('content')
<div class="space-y-6">

    <!-- Filter & Tombol Tambah Pengguna -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 w-full sm:w-auto flex-1">
            
            <select name="role_id" onchange="this.form.submit()" class="text-xs bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2 font-semibold text-slate-700 focus:outline-none focus:border-[#0066B2]">
                <option value="">Semua Peran (Role)</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                        {{ strtoupper(str_replace('_', ' ', $role->name)) }}
                    </option>
                @endforeach
            </select>

            <select name="status" onchange="this.form.submit()" class="text-xs bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2 font-semibold text-slate-700 focus:outline-none focus:border-[#0066B2]">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif ({{ $counts['active'] }})</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif ({{ $counts['inactive'] }})</option>
            </select>

            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama pegawai, alamat email..." 
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl pl-8 pr-3 py-2 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#0066B2] focus:bg-white transition">
                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <button type="submit" class="px-4 py-2 bg-[#0066B2] text-white text-xs font-bold rounded-xl hover:bg-[#0A2540] transition">
                Cari
            </button>
            @if(request()->anyFilled(['role_id', 'status', 'q']))
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-rose-600 hover:underline px-2">Reset</a>
            @endif
        </form>

        <a href="{{ route('admin.users.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0066B2] hover:bg-[#0A2540] text-white text-xs font-bold rounded-xl transition shadow-md shadow-[#0066B2]/20 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            <span>Tambah Pegawai Baru</span>
        </a>
    </div>

    <!-- Tabel Pengguna -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50/75 text-slate-400 uppercase font-semibold border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Nama Pegawai & Inisial</th>
                        <th class="py-3.5 px-4">Email Kedinasan</th>
                        <th class="py-3.5 px-4">Peran (Role RBAC)</th>
                        <th class="py-3.5 px-4">Status Akun</th>
                        <th class="py-3.5 px-4">Terdaftar Sejak</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($users as $item)
                        @php
                            $words = explode(' ', $item->name);
                            $initials = '';
                            foreach (array_slice($words, 0, 2) as $w) {
                                $initials .= strtoupper(substr($w, 0, 1));
                            }
                            $roleName = $item->role?->name ?? 'user';
                            $roleBadge = match($roleName) {
                                'super_admin' => 'bg-purple-50 text-purple-700 border-purple-200',
                                'compliance_officer' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'content_editor' => 'bg-sky-50 text-sky-700 border-sky-200',
                                default => 'bg-slate-50 text-slate-700 border-slate-200',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition {{ $item->id === auth()->id() ? 'bg-blue-50/30' : '' }}">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-[#0066B2] to-[#63B3ED] text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-sm">
                                        {{ $initials ?: 'ST' }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-slate-800 text-[13px] block leading-tight">{{ $item->name }}</span>
                                            @if($item->id === auth()->id())
                                                <span class="px-2 py-0.5 rounded-md text-[9px] font-bold bg-[#0066B2] text-white">Akun Anda</span>
                                            @endif
                                        </div>
                                        <span class="text-[10px] text-slate-400 font-mono mt-0.5 block">ID: {{ substr($item->id, 0, 8) }}...</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 font-mono font-medium text-slate-700">
                                {{ $item->email }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold font-mono border {{ $roleBadge }} uppercase">
                                    {{ str_replace('_', ' ', $roleName) }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                @if($item->is_active)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        Dinonaktifkan
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 font-mono text-[11px] text-slate-400">
                                {{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.users.edit', $item->id) }}" 
                                       class="p-2 text-slate-500 hover:text-[#0066B2] hover:bg-blue-50 rounded-lg transition" title="Edit Profil / Reset Password">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    @if($item->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pegawai ini? Tindakan ini akan dicatat ke audit log.');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Pengguna">
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
                                Tidak ada data pengguna yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100 flex justify-center">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection