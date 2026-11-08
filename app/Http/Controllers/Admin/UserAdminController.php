<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserAdminController extends Controller
{
    /**
     * Daftar Pengguna / Akun Staf
     */
    public function index(Request $request)
    {
        $query = User::with('role');

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        $roles = Role::all();

        $counts = [
            'all' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
        ];

        return view('admin.users.index', compact('users', 'roles', 'counts'));
    }

    /**
     * Form Tambah Pengguna Baru
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Simpan Pengguna Baru + Audit Log
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'nullable|boolean',
        ], [
            'role_id.required' => 'Pilih peran otorisasi untuk pengguna ini.',
            'name.required' => 'Nama lengkap pegawai wajib diisi.',
            'email.required' => 'Alamat email kedinasan wajib diisi.',
            'email.unique' => 'Alamat email ini sudah terdaftar pada sistem.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'role_id' => $validated['role_id'],
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'is_active' => $request->boolean('is_active', true),
        ]);

        ActivityLogger::log(
            'USER_MANAGEMENT',
            'CREATE',
            "Mendaftarkan akun operator baru: {$user->name} ({$user->email})",
            [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'is_active' => $user->is_active,
            ]
        );

        return redirect()->route('admin.users.index')
            ->with('success', "Akun pegawai '{$user->name}' berhasil dibuat.");
    }

    /**
     * Form Edit Pengguna
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Perbarui Profil, Peran, atau Kata Sandi Pengguna + Audit Log
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $oldSnapshot = $user->toArray();

        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:150',
            'email' => ['required', 'email', 'max:150', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'nullable|boolean',
        ], [
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        // Pencegahan: Super Admin tidak boleh menonaktifkan akun sendiri
        if ($user->id === Auth::id() && !$request->boolean('is_active', true)) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun yang sedang aktif digunakan.');
        }

        $updateData = [
            'role_id' => $validated['role_id'],
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'is_active' => $request->boolean('is_active', true),
        ];

        $passwordChanged = false;
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
            $passwordChanged = true;
        }

        $user->update($updateData);

        ActivityLogger::log(
            'USER_MANAGEMENT',
            'UPDATE',
            "Memperbarui data akun pengguna: {$user->name} ({$user->email})" . ($passwordChanged ? ' (Kata sandi direset)' : ''),
            [
                'user_id' => $user->id,
                'before' => $oldSnapshot,
                'after' => $user->fresh()->toArray(),
                'password_reset' => $passwordChanged,
            ]
        );

        return redirect()->route('admin.users.index')
            ->with('success', "Data pengguna '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Hapus Pengguna
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak diizinkan menghapus akun Anda sendiri.');
        }

        $deletedSnapshot = $user->toArray();
        $user->delete();

        ActivityLogger::log(
            'USER_MANAGEMENT',
            'DELETE',
            "Menghapus akun staf pengguna: {$deletedSnapshot['name']} ({$deletedSnapshot['email']})",
            ['deleted_user' => $deletedSnapshot]
        );

        return redirect()->route('admin.users.index')
            ->with('success', "Akun '{$deletedSnapshot['name']}' berhasil dihapus.");
    }
}