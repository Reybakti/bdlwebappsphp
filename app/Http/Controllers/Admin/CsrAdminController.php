<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CsrProgram;
use App\Models\CsrProgramImage;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CsrAdminController extends Controller
{
    /**
     * Daftar Program CSR
     */
    public function index(Request $request)
    {
        $query = CsrProgram::with('galleryImages');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $isPublished = $request->status === 'published';
            $query->where('is_published', $isPublished);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $programs = $query->latest('activity_date')->paginate(10)->withQueryString();

        $counts = [
            'all' => CsrProgram::count(),
            'published' => CsrProgram::where('is_published', true)->count(),
            'draft' => CsrProgram::where('is_published', false)->count(),
        ];

        return view('admin.csr.index', compact('programs', 'counts'));
    }

    /**
     * Form Tambah Program CSR
     */
    public function create()
    {
        return view('admin.csr.create');
    }

    /**
     * Simpan Program CSR + Sampul + Multi Foto + Dokumen Berkas + Audit Log
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category' => 'required|in:PEMBERDAYAAN_UMKM,PENDIDIKAN_LITERASI,SOSIAL_KEMASYARAKATAN,LINGKUNGAN_HIDUP',
            'budget_amount' => 'nullable|numeric|min:0',
            'location' => 'required|string|max:150',
            'activity_date' => 'required|date',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:15360', // Maks 15 MB
            'description' => 'required|string',
            'is_published' => 'nullable|boolean',
        ], [
            'title.required' => 'Judul kegiatan CSR wajib diisi.',
            'category.required' => 'Pilih pilar kategori CSR.',
            'location.required' => 'Lokasi kegiatan wajib diisi.',
            'activity_date.required' => 'Tanggal pelaksanaan kegiatan wajib diisi.',
            'description.required' => 'Uraian pelaksanaan CSR wajib diisi.',
            'document_file.mimes' => 'Format dokumen harus berformat PDF, DOC, DOCX, XLS, atau XLSX.',
            'document_file.max' => 'Ukuran berkas dokumen maksimal 15 MB.',
        ]);

        $slug = Str::slug($validated['title']);
        if (CsrProgram::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::lower(Str::random(4));
        }

        // 1. Simpan Foto Sampul (Cover)
        $coverUrl = null;
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $fileName = 'cover_' . $slug . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('csr_programs', $fileName, 'public');
            $coverUrl = '/storage/' . $path;
        }

        // 2. Simpan Dokumen Berkas Pendukung (Laporan / BA)
        $documentUrl = null;
        $documentName = null;
        if ($request->hasFile('document_file')) {
            $doc = $request->file('document_file');
            $documentName = $doc->getClientOriginalName();
            $docFileName = 'doc_' . $slug . '_' . time() . '.' . $doc->getClientOriginalExtension();
            $docPath = $doc->storeAs('csr_programs/documents', $docFileName, 'public');
            $documentUrl = '/storage/' . $docPath;
        }

        $program = CsrProgram::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'budget_amount' => $validated['budget_amount'] ?? null,
            'location' => $validated['location'],
            'activity_date' => $validated['activity_date'],
            'image_url' => $coverUrl,
            'document_url' => $documentUrl,
            'document_name' => $documentName,
            'description' => $validated['description'],
            'is_published' => $request->boolean('is_published', true),
        ]);

        // 3. Simpan Galeri Multi Foto
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $idx => $imgFile) {
                $galleryName = 'gal_' . $slug . '_' . time() . '_' . $idx . '.' . $imgFile->getClientOriginalExtension();
                $galleryPath = $imgFile->storeAs('csr_programs/gallery', $galleryName, 'public');

                CsrProgramImage::create([
                    'csr_program_id' => $program->id,
                    'image_url' => '/storage/' . $galleryPath,
                ]);

                if (!$coverUrl && $idx === 0) {
                    $program->update(['image_url' => '/storage/' . $galleryPath]);
                }
            }
        }

        ActivityLogger::log(
            'CSR',
            'CREATE',
            "Mempublikasikan program CSR: {$program->title} [Kategori: {$program->category}]",
            $program->load('galleryImages')->toArray()
        );

        return redirect()->route('admin.csr.index')
            ->with('success', "Program CSR '{$program->title}' berhasil ditambahkan.");
    }

    /**
     * Form Edit Program CSR & Galeri & Dokumen
     */
    public function edit($id)
    {
        $program = CsrProgram::with('galleryImages')->findOrFail($id);

        return view('admin.csr.edit', compact('program'));
    }

    /**
     * Perbarui Program CSR, Galeri & Dokumen + Audit Log
     */
    public function update(Request $request, $id)
    {
        $program = CsrProgram::with('galleryImages')->findOrFail($id);
        $oldSnapshot = $program->toArray();

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category' => 'required|in:PEMBERDAYAAN_UMKM,PENDIDIKAN_LITERASI,SOSIAL_KEMASYARAKATAN,LINGKUNGAN_HIDUP',
            'budget_amount' => 'nullable|numeric|min:0',
            'location' => 'required|string|max:150',
            'activity_date' => 'required|date',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:15360',
            'remove_document' => 'nullable|boolean',
            'description' => 'required|string',
            'is_published' => 'nullable|boolean',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'category' => $validated['category'],
            'budget_amount' => $validated['budget_amount'] ?? null,
            'location' => $validated['location'],
            'activity_date' => $validated['activity_date'],
            'description' => $validated['description'],
            'is_published' => $request->boolean('is_published', true),
        ];

        // 1. Pembaruan Foto Sampul
        if ($request->hasFile('cover_image')) {
            if ($program->image_url && str_contains($program->image_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $program->image_url);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $file = $request->file('cover_image');
            $fileName = 'cover_' . $program->slug . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('csr_programs', $fileName, 'public');
            $updateData['image_url'] = '/storage/' . $path;
        }

        // 2. Pembaruan Dokumen Berkas
        if ($request->boolean('remove_document')) {
            if ($program->document_url) {
                $oldDocPath = str_replace('/storage/', '', $program->document_url);
                if (Storage::disk('public')->exists($oldDocPath)) {
                    Storage::disk('public')->delete($oldDocPath);
                }
            }
            $updateData['document_url'] = null;
            $updateData['document_name'] = null;
        } elseif ($request->hasFile('document_file')) {
            if ($program->document_url) {
                $oldDocPath = str_replace('/storage/', '', $program->document_url);
                if (Storage::disk('public')->exists($oldDocPath)) {
                    Storage::disk('public')->delete($oldDocPath);
                }
            }

            $doc = $request->file('document_file');
            $docName = $doc->getClientOriginalName();
            $docFileName = 'doc_' . $program->slug . '_' . time() . '.' . $doc->getClientOriginalExtension();
            $docPath = $doc->storeAs('csr_programs/documents', $docFileName, 'public');
            $updateData['document_url'] = '/storage/' . $docPath;
            $updateData['document_name'] = $docName;
        }

        $program->update($updateData);

        // 3. Tambah Foto Baru ke Galeri
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $idx => $imgFile) {
                $galleryName = 'gal_' . $program->slug . '_' . time() . '_' . $idx . '.' . $imgFile->getClientOriginalExtension();
                $galleryPath = $imgFile->storeAs('csr_programs/gallery', $galleryName, 'public');

                CsrProgramImage::create([
                    'csr_program_id' => $program->id,
                    'image_url' => '/storage/' . $galleryPath,
                ]);
            }
        }

        ActivityLogger::log(
            'CSR',
            'UPDATE',
            "Memperbarui program CSR: {$program->title} [ID: {$program->id}]",
            [
                'before' => $oldSnapshot,
                'after' => $program->fresh()->load('galleryImages')->toArray(),
            ]
        );

        return redirect()->route('admin.csr.index')
            ->with('success', "Program CSR '{$program->title}' berhasil diperbarui.");
    }

    /**
     * Hapus Satu Foto Galeri
     */
    public function deleteImage($id)
    {
        $image = CsrProgramImage::findOrFail($id);

        $filePath = str_replace('/storage/', '', $image->image_url);
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $image->delete();

        ActivityLogger::log(
            'CSR',
            'DELETE',
            "Menghapus satu foto dokumentasi galeri program CSR [ID Foto: {$id}]"
        );

        return back()->with('success', 'Foto dokumentasi galeri berhasil dihapus.');
    }

    /**
     * Hapus Program CSR Beserta Foto Galeri & Dokumen
     */
    public function destroy($id)
    {
        $program = CsrProgram::with('galleryImages')->findOrFail($id);
        $deletedSnapshot = $program->toArray();

        // Hapus Cover
        if ($program->image_url && str_contains($program->image_url, '/storage/')) {
            $filePath = str_replace('/storage/', '', $program->image_url);
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        // Hapus Dokumen
        if ($program->document_url && str_contains($program->document_url, '/storage/')) {
            $docPath = str_replace('/storage/', '', $program->document_url);
            if (Storage::disk('public')->exists($docPath)) {
                Storage::disk('public')->delete($docPath);
            }
        }

        // Hapus Foto Galeri
        foreach ($program->galleryImages as $gal) {
            $galPath = str_replace('/storage/', '', $gal->image_url);
            if (Storage::disk('public')->exists($galPath)) {
                Storage::disk('public')->delete($galPath);
            }
        }

        $program->delete();

        ActivityLogger::log(
            'CSR',
            'DELETE',
            "Menghapus program CSR: {$deletedSnapshot['title']} [ID: {$deletedSnapshot['id']}]",
            ['deleted_csr' => $deletedSnapshot]
        );

        return redirect()->route('admin.csr.index')
            ->with('success', "Program CSR '{$deletedSnapshot['title']}' berhasil dihapus.");
    }
}