@extends('layouts.admin')

@section('title', 'Perbarui Pengguna ' . $user->name)
@section('page_title', 'Perbarui Akun Pengguna')
@section('page_subtitle', 'Sunting profil pegawai, ubah kewenangan peran, atau lakukan reset kata sandi.')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#0066B2] hover:underline">
            <span>&larr;</span> Kembali ke Daftar Pengguna
        </a>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-3">
            <h2 class="text-base font-extrabold text-[#0A2540]">Ubah Informasi Akun</h2>
            <p class="text-xs text-slate-400">Kosongkan kolom kata sandi jika tidak ingin mengubah kata sandi akun ini.</p>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4 text-xs" autocomplete="off">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-bold text-slate-700 mb-1">Peran Akses (Role) <span class="text-rose-500">*</span></label>
                <select name="role_id" required class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-semibold">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                            {{ strtoupper(str_replace('_', ' ', $role->name)) }} — ({{ $role->description }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Lengkap Pegawai <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Alamat Email Kedinasan <span class="text-rose-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-mono">
            </div>

            <!-- Bagian Reset Kata Sandi -->
            <div class="pt-3 border-t border-slate-100">
                <span class="text-[11px] font-bold text-[#0066B2] uppercase block tracking-wider mb-2">Reset Kata Sandi (Opsional)</span>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kata Sandi Baru</label>
                        <input type="password" name="password" 
                               placeholder="Biarkan kosong jika tidak diubah"
                               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" 
                               placeholder="Biarkan kosong jika tidak diubah"
                               class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} class="accent-[#0066B2] w-4 h-4 rounded">
                    <span class="text-slate-700 font-semibold">Status akun aktif (Izinkan login)</span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-3 text-slate-500 hover:text-slate-800 transition font-bold">Batal</a>
                <button type="submit" class="px-6 py-3 bg-[#0066B2] hover:bg-[#0A2540] text-white font-bold rounded-xl transition shadow-md shadow-[#0066B2]/25">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection