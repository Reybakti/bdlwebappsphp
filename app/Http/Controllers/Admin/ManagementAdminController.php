<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManagementMember;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManagementAdminController extends Controller
{
    /**
     * Daftar Susunan Direksi & Dewan Komisaris
     */
    public function index(Request $request)
    {
        $query = ManagementMember::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        $members = $query->orderBy('order_index', 'asc')
                         ->paginate(12)
                         ->withQueryString();

        $counts = [
            'all' => ManagementMember::count(),
            'commissioners' => ManagementMember::where('type', 'COMMISSIONER')->count(),
            'directors' => ManagementMember::where('type', 'DIRECTOR')->count(),
        ];

        return view('admin.management.index', compact('members', 'counts'));
    }

    /**
     * Form Tambah Pejabat Pengurus Baru
     */
    public function create()
    {
        return view('admin.management.create');
    }

    /**
     * Simpan Pejabat Baru + Unggah Foto + Audit Log
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'title' => 'required|string|max:100',
            'type' => 'required|in:DIRECTOR,COMMISSIONER',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // Maks 2 MB
            'bio' => 'nullable|string',
            'order_index' => 'required|integer|min:1|max:99',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama lengkap beserta gelar wajib diisi.',
            'title.required' => 'Jabatan kepengurusan wajib diisi.',
            'type.required' => 'Pilih klasifikasi kepengurusan (Direksi/Komisaris).',
            'order_index.required' => 'Nomor urut posisi wajib ditentukan.',
            'photo.image' => 'Berkas pas foto harus berupa gambar.',
        ]);

        $photoUrl = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = 'mgmt_' . Str::slug($validated['name']) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('management', $fileName, 'public');
            $photoUrl = '/storage/' . $path;
        }

        $member = ManagementMember::create([
            'name' => $validated['name'],
            'title' => $validated['title'],
            'type' => $validated['type'],
            'photo_url' => $photoUrl,
            'bio' => $validated['bio'] ?? null,
            'order_index' => $validated['order_index'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        ActivityLogger::log(
            'MANAGEMENT',
            'CREATE',
            "Mendaftarkan pejabat pengurus baru: {$member->name} ({$member->title})",
            $member->toArray()
        );

        return redirect()->route('admin.management.index')
            ->with('success', "Pejabat '{$member->name}' berhasil ditambahkan ke susunan kepengurusan.");
    }

    /**
     * Form Edit Pejabat
     */
    public function edit($id)
    {
        $member = ManagementMember::findOrFail($id);

        return view('admin.management.edit', compact('member'));
    }

    /**
     * Perbarui Data Pejabat + Audit Log
     */
    public function update(Request $request, $id)
    {
        $member = ManagementMember::findOrFail($id);
        $oldSnapshot = $member->toArray();

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'title' => 'required|string|max:100',
            'type' => 'required|in:DIRECTOR,COMMISSIONER',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bio' => 'nullable|string',
            'order_index' => 'required|integer|min:1|max:99',
            'is_active' => 'nullable|boolean',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'title' => $validated['title'],
            'type' => $validated['type'],
            'bio' => $validated['bio'] ?? null,
            'order_index' => $validated['order_index'],
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('photo')) {
            if ($member->photo_url && str_contains($member->photo_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $member->photo_url);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $file = $request->file('photo');
            $fileName = 'mgmt_' . Str::slug($validated['name']) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('management', $fileName, 'public');
            $updateData['photo_url'] = '/storage/' . $path;
        }

        $member->update($updateData);

        ActivityLogger::log(
            'MANAGEMENT',
            'UPDATE',
            "Memperbarui profil pejabat: {$member->name} [ID: {$member->id}]",
            [
                'before' => $oldSnapshot,
                'after' => $member->fresh()->toArray(),
            ]
        );

        return redirect()->route('admin.management.index')
            ->with('success', "Data pejabat '{$member->name}' berhasil diperbarui.");
    }

    /**
     * Hapus Pejabat
     */
    public function destroy($id)
    {
        $member = ManagementMember::findOrFail($id);
        $deletedSnapshot = $member->toArray();

        if ($member->photo_url && str_contains($member->photo_url, '/storage/')) {
            $filePath = str_replace('/storage/', '', $member->photo_url);
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        $member->delete();

        ActivityLogger::log(
            'MANAGEMENT',
            'DELETE',
            "Menghapus pejabat dari struktur: {$deletedSnapshot['name']} ({$deletedSnapshot['title']})",
            ['deleted_member' => $deletedSnapshot]
        );

        return redirect()->route('admin.management.index')
            ->with('success', "Pejabat '{$deletedSnapshot['name']}' berhasil dihapus dari struktur.");
    }
}