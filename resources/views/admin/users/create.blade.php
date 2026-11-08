@extends('layouts.admin')

@section('title', 'Tambah Pegawai Baru')
@section('page_title', 'Tambah Pengguna Baru')
@section('page_subtitle', 'Pendaftaran akun staf internal, pengaturan peran kerja, dan pemberian kata sandi awal.')

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
            <h2 class="text-base font-extrabold text-[#0A2540]">Kredensial & Otorisasi Pengguna</h2>
            <p class="text-xs text-slate-400">Pastikan alamat email yang didaftarkan merupakan email kedinasan BDL resmi.</p>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4 text-xs" autocomplete="off">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 mb-1">Peran Akses (Role) <span class="text-rose-500">*</span></label>
                <select name="role_id" required class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-semibold">
                    <option value="">-- Pilih Peran / Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ strtoupper(str_replace('_', ' ', $role->name)) }} — ({{ $role->description }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Lengkap Pegawai <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                       placeholder="Contoh: Muhammad Ilham Santoso, S.Kom."
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Alamat Email Kedinasan <span class="text-rose-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                       placeholder="nama.pegawai@bdl.co.id"
                       class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-mono">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kata Sandi Awal <span class="text-rose-500">*</span></label>
                    <input type="password" name="password" required 
                           placeholder="••••••••"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Ulangi Kata Sandi <span class="text-rose-500">*</span></label>
                    <input type="password" name="password_confirmation" required 
                           placeholder="••••••••"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-3 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="accent-[#0066B2] w-4 h-4 rounded">
                    <span class="text-slate-700 font-semibold">Aktifkan akun ini segera (Bisa langsung login)</span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-3 text-slate-500 hover:text-slate-800 transition font-bold">Batal</a>
                <button type="submit" class="px-6 py-3 bg-[#0066B2] hover:bg-[#0A2540] text-white font-bold rounded-xl transition shadow-md shadow-[#0066B2]/25">
                    Buat Akun Pegawai
                </button>
            </div>
        </form>
    </div>

</div>
@endsection