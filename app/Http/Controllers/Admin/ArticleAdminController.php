<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleAdminController extends Controller
{
    /**
     * Daftar Artikel Berita & Edukasi
     */
    public function index(Request $request)
    {
        $query = Article::with(['category', 'author']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->latest('published_at')->paginate(10)->withQueryString();
        $categories = ArticleCategory::all();

        $counts = [
            'all' => Article::count(),
            'published' => Article::where('status', 'PUBLISHED')->count(),
            'draft' => Article::where('status', 'DRAFT')->count(),
        ];

        return view('admin.articles.index', compact('articles', 'categories', 'counts'));
    }

    /**
     * Form Tulis Artikel Baru
     */
    public function create()
    {
        $categories = ArticleCategory::all();

        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Simpan Artikel & Upload Thumbnail + Audit Log
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:article_categories,id',
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'status' => 'required|in:DRAFT,PUBLISHED',
            'published_at' => 'nullable|date',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072', // Maks 3 MB
        ], [
            'category_id.required' => 'Pilih kategori artikel.',
            'title.required' => 'Judul artikel wajib diisi.',
            'content.required' => 'Isi artikel tidak boleh kosong.',
            'thumbnail.image' => 'Berkas sampul harus berupa gambar.',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 3 MB.',
        ]);

        $slug = Str::slug($validated['title']);
        if (Article::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::lower(Str::random(4));
        }

        $thumbnailUrl = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = 'thumb_' . $slug . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('articles', $fileName, 'public');
            $thumbnailUrl = '/storage/' . $path;
        }

        $publishedAt = $validated['status'] === 'PUBLISHED' 
            ? ($validated['published_at'] ?? now()) 
            : null;

        $article = Article::create([
            'category_id' => $validated['category_id'],
            'author_id' => Auth::id(),
            'title' => $validated['title'],
            'slug' => $slug,
            'thumbnail_url' => $thumbnailUrl,
            'content' => $validated['content'],
            'status' => $validated['status'],
            'published_at' => $publishedAt,
            'views_count' => 0,
        ]);

        ActivityLogger::log(
            'ARTICLE',
            'CREATE',
            "Menerbitkan artikel baru: {$article->title} [Status: {$article->status}]",
            [
                'article_id' => $article->id,
                'category_id' => $article->category_id,
                'title' => $article->title,
                'status' => $article->status,
                'published_at' => $article->published_at,
            ]
        );

        return redirect()->route('admin.articles.index')
            ->with('success', "Artikel '{$article->title}' berhasil disimpan.");
    }

    /**
     * Form Edit Artikel
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = ArticleCategory::all();

        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Perbarui Artikel + Audit Log
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $oldSnapshot = $article->toArray();

        $validated = $request->validate([
            'category_id' => 'required|exists:article_categories,id',
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'status' => 'required|in:DRAFT,PUBLISHED',
            'published_at' => 'nullable|date',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $updateData = [
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'PUBLISHED' 
                ? ($validated['published_at'] ?? $article->published_at ?? now()) 
                : null,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail_url && str_contains($article->thumbnail_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $article->thumbnail_url);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $file = $request->file('thumbnail');
            $fileName = 'thumb_' . $article->slug . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('articles', $fileName, 'public');
            $updateData['thumbnail_url'] = '/storage/' . $path;
        }

        $article->update($updateData);

        ActivityLogger::log(
            'ARTICLE',
            'UPDATE',
            "Memperbarui artikel: {$article->title} [ID: {$article->id}]",
            [
                'article_id' => $article->id,
                'before' => $oldSnapshot,
                'after' => $article->fresh()->toArray(),
            ]
        );

        return redirect()->route('admin.articles.index')
            ->with('success', "Artikel '{$article->title}' berhasil diperbarui.");
    }

    /**
     * Hapus Artikel
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $deletedSnapshot = $article->toArray();

        if ($article->thumbnail_url && str_contains($article->thumbnail_url, '/storage/')) {
            $filePath = str_replace('/storage/', '', $article->thumbnail_url);
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        $article->delete();

        ActivityLogger::log(
            'ARTICLE',
            'DELETE',
            "Menghapus artikel: {$deletedSnapshot['title']} [ID: {$deletedSnapshot['id']}]",
            ['deleted_article' => $deletedSnapshot]
        );

        return redirect()->route('admin.articles.index')
            ->with('success', "Artikel '{$deletedSnapshot['title']}' berhasil dihapus.");
    }
}