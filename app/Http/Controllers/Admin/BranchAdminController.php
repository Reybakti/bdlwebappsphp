<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class BranchAdminController extends Controller
{
    /**
     * Daftar Jaringan Kantor
     */
    public function index(Request $request)
    {
        $query = Branch::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $branches = $query->orderByRaw("FIELD(type, 'HEAD_OFFICE', 'BRANCH', 'CASH_OFFICE')")
                          ->latest()
                          ->paginate(10)
                          ->withQueryString();

        $counts = [
            'all' => Branch::count(),
            'head' => Branch::where('type', 'HEAD_OFFICE')->count(),
            'branch' => Branch::where('type', 'BRANCH')->count(),
            'cash' => Branch::where('type', 'CASH_OFFICE')->count(),
        ];

        return view('admin.branches.index', compact('branches', 'counts'));
    }

    /**
     * Form Tambah Kantor Baru
     */
    public function create()
    {
        return view('admin.branches.create');
    }

    /**
     * Simpan Kantor Baru + Audit Log
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'type' => 'required|in:HEAD_OFFICE,BRANCH,CASH_OFFICE',
            'address' => 'required|string',
            'phone' => 'required|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'google_maps_url' => 'nullable|url',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama unit kantor wajib diisi.',
            'type.required' => 'Pilih jenis unit kantor.',
            'address.required' => 'Alamat lengkap kantor wajib diisi.',
            'phone.required' => 'Nomor telepon kantor wajib diisi.',
            'email.email' => 'Format email kantor tidak valid.',
            'google_maps_url.url' => 'Tautan Google Maps harus berformat URL yang valid.',
        ]);

        $branch = Branch::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'whatsapp' => $validated['whatsapp'] ?? null,
            'email' => $validated['email'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'google_maps_url' => $validated['google_maps_url'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        ActivityLogger::log(
            'BRANCH',
            'CREATE',
            "Mendaftarkan unit kantor baru: {$branch->name} [Tipe: {$branch->type}]",
            $branch->toArray()
        );

        return redirect()->route('admin.branches.index')
            ->with('success', "Kantor '{$branch->name}' berhasil ditambahkan ke direktori.");
    }

    /**
     * Form Edit Kantor
     */
    public function edit($id)
    {
        $branch = Branch::findOrFail($id);

        return view('admin.branches.edit', compact('branch'));
    }

    /**
     * Perbarui Data Kantor + Audit Log
     */
    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);
        $oldData = $branch->toArray();

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'type' => 'required|in:HEAD_OFFICE,BRANCH,CASH_OFFICE',
            'address' => 'required|string',
            'phone' => 'required|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'google_maps_url' => 'nullable|url',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama unit kantor wajib diisi.',
            'type.required' => 'Pilih jenis unit kantor.',
            'address.required' => 'Alamat lengkap kantor wajib diisi.',
            'phone.required' => 'Nomor telepon kantor wajib diisi.',
            'email.email' => 'Format email kantor tidak valid.',
            'google_maps_url.url' => 'Tautan Google Maps harus berformat URL yang valid.',
        ]);

        $branch->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'whatsapp' => $validated['whatsapp'] ?? null,
            'email' => $validated['email'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'google_maps_url' => $validated['google_maps_url'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        ActivityLogger::log(
            'BRANCH',
            'UPDATE',
            "Memperbarui data unit kantor: {$branch->name} [ID: {$branch->id}]",
            [
                'before' => $oldData,
                'after' => $branch->fresh()->toArray(),
            ]
        );

        return redirect()->route('admin.branches.index')
            ->with('success', "Data kantor '{$branch->name}' berhasil diperbarui.");
    }

    /**
     * Hapus Unit Kantor
     */
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);

        if ($branch->type === 'HEAD_OFFICE') {
            return back()->with('error', 'Kantor Pusat tidak diperkenankan untuk dihapus dari sistem.');
        }

        $deletedSnapshot = $branch->toArray();
        $branch->delete();

        ActivityLogger::log(
            'BRANCH',
            'DELETE',
            "Menghapus unit operasional kantor: {$deletedSnapshot['name']} [{$deletedSnapshot['type']}]",
            ['deleted_branch' => $deletedSnapshot]
        );

        return redirect()->route('admin.branches.index')
            ->with('success', "Unit kantor '{$deletedSnapshot['name']}' berhasil dihapus.");
    }
}