<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerPosting;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CareerAdminController extends Controller
{
    /**
     * Daftar Lowongan Karier
     */
    public function index(Request $request)
    {
        $query = CareerPosting::query();

        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('requirements', 'like', "%{$search}%");
            });
        }

        $careers = $query->latest()->paginate(10)->withQueryString();

        $counts = [
            'all' => CareerPosting::count(),
            'active' => CareerPosting::where('is_active', true)->count(),
            'closed' => CareerPosting::where('is_active', false)->count(),
        ];

        return view('admin.careers.index', compact('careers', 'counts'));
    }

    /**
     * Form Tambah Lowongan Baru
     */
    public function create()
    {
        return view('admin.careers.create');
    }

    /**
     * Simpan Lowongan Baru + Audit Log
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'deadline' => 'required|date',
            'is_active' => 'nullable|boolean',
        ], [
            'title.required' => 'Posisi / jabatan lowongan wajib diisi.',
            'description.required' => 'Deskripsi tanggung jawab pekerjaan wajib diisi.',
            'requirements.required' => 'Kualifikasi & persyaratan pelamar wajib diisi.',
            'deadline.required' => 'Batas waktu pendaftaran wajib ditentukan.',
        ]);

        $slug = Str::slug($validated['title']);
        if (CareerPosting::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::lower(Str::random(4));
        }

        $career = CareerPosting::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'requirements' => $validated['requirements'],
            'deadline' => $validated['deadline'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        ActivityLogger::log(
            'CAREER',
            'CREATE',
            "Membuka formasi lowongan kerja baru: {$career->title} [Batas Pendaftaran: {$career->deadline}]",
            $career->toArray()
        );

        return redirect()->route('admin.careers.index')
            ->with('success', "Formasi lowongan '{$career->title}' berhasil dipublikasikan.");
    }

    /**
     * Form Edit Lowongan
     */
    public function edit($id)
    {
        $career = CareerPosting::findOrFail($id);

        return view('admin.careers.edit', compact('career'));
    }

    /**
     * Perbarui Data Lowongan + Audit Log
     */
    public function update(Request $request, $id)
    {
        $career = CareerPosting::findOrFail($id);
        $oldSnapshot = $career->toArray();

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'deadline' => 'required|date',
            'is_active' => 'nullable|boolean',
        ]);

        $career->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'requirements' => $validated['requirements'],
            'deadline' => $validated['deadline'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        ActivityLogger::log(
            'CAREER',
            'UPDATE',
            "Memperbarui informasi lowongan kerja: {$career->title} [ID: {$career->id}]",
            [
                'before' => $oldSnapshot,
                'after' => $career->fresh()->toArray(),
            ]
        );

        return redirect()->route('admin.careers.index')
            ->with('success', "Data formasi lowongan '{$career->title}' berhasil diperbarui.");
    }

    /**
     * Hapus Lowongan Kerja
     */
    public function destroy($id)
    {
        $career = CareerPosting::findOrFail($id);
        $deletedSnapshot = $career->toArray();

        $career->delete();

        ActivityLogger::log(
            'CAREER',
            'DELETE',
            "Menghapus formasi lowongan kerja: {$deletedSnapshot['title']} [ID: {$deletedSnapshot['id']}]",
            ['deleted_career' => $deletedSnapshot]
        );

        return redirect()->route('admin.careers.index')
            ->with('success', "Formasi lowongan '{$deletedSnapshot['title']}' berhasil dihapus.");
    }
}