<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSimulationParam;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductAdminController extends Controller
{
    /**
     * Daftar Seluruh Produk Perbankan
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'simulationParam']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = ProductCategory::all();

        $counts = [
            'all' => Product::count(),
            'active' => Product::where('is_active', true)->count(),
            'featured' => Product::where('is_featured', true)->count(),
        ];

        return view('admin.products.index', compact('products', 'categories', 'counts'));
    }

    /**
     * Form Tambah Produk Baru
     */
    public function create()
    {
        $categories = ProductCategory::all();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Simpan Produk, Parameter Simulasi, dan Berkas RIPLAY
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:150',
            'short_description' => 'required|string|max:255',
            'full_description' => 'required|string',
            'terms_and_conditions' => 'nullable|string',
            'riplay_file' => 'nullable|file|mimes:pdf|max:10240', // Maks 10 MB
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',

            // Parameter Simulasi (Opsional untuk Deposito/Kredit)
            'has_simulation' => 'nullable|boolean',
            'min_amount' => 'nullable|required_if:has_simulation,1|numeric|min:0',
            'max_amount' => 'nullable|required_if:has_simulation,1|numeric|gte:min_amount',
            'min_tenor_months' => 'nullable|required_if:has_simulation,1|integer|min:1',
            'max_tenor_months' => 'nullable|required_if:has_simulation,1|integer|gte:min_tenor_months',
            'base_interest_rate_pa' => 'nullable|required_if:has_simulation,1|numeric|min:0|max:100',
            'interest_type' => 'nullable|in:FLAT,EFEKTIF,ANUITAS',
            'provision_fee_percent' => 'nullable|numeric|min:0|max:100',
            'admin_fee_amount' => 'nullable|numeric|min:0',
        ], [
            'category_id.required' => 'Pilih kategori produk perbankan.',
            'name.required' => 'Nama produk wajib diisi.',
            'short_description.required' => 'Deskripsi ringkas produk wajib diisi.',
            'full_description.required' => 'Deskripsi lengkap produk wajib diisi.',
            'riplay_file.mimes' => 'Berkas RIPLAY wajib berformat PDF.',
        ]);

        $slug = Str::slug($validated['name']);
        if (Product::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::lower(Str::random(4));
        }

        // Simpan Berkas RIPLAY jika diunggah
        $riplayUrl = null;
        if ($request->hasFile('riplay_file')) {
            $file = $request->file('riplay_file');
            $fileName = 'riplay_' . $slug . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('riplay', $fileName, 'public');
            $riplayUrl = '/storage/' . $path;
        }

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'short_description' => $validated['short_description'],
            'full_description' => $validated['full_description'],
            'terms_and_conditions' => $validated['terms_and_conditions'] ?? null,
            'riplay_file_url' => $riplayUrl,
            'is_featured' => $request->boolean('is_featured', false),
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Simpan Parameter Simulasi jika diaktifkan
        if ($request->boolean('has_simulation')) {
            ProductSimulationParam::create([
                'product_id' => $product->id,
                'min_amount' => $validated['min_amount'],
                'max_amount' => $validated['max_amount'],
                'min_tenor_months' => $validated['min_tenor_months'],
                'max_tenor_months' => $validated['max_tenor_months'],
                'base_interest_rate_pa' => $validated['base_interest_rate_pa'],
                'interest_type' => $validated['interest_type'] ?? 'FLAT',
                'provision_fee_percent' => $validated['provision_fee_percent'] ?? 0.00,
                'admin_fee_amount' => $validated['admin_fee_amount'] ?? 0.00,
            ]);
        }

        // Catat Audit Log
        ActivityLogger::log(
            'PRODUCT',
            'CREATE',
            "Menerbitkan produk perbankan baru: {$product->name} (Slug: {$product->slug})",
            [
                'product_id' => $product->id,
                'category_id' => $product->category_id,
                'name' => $product->name,
                'has_simulation' => $request->boolean('has_simulation'),
            ]
        );

        return redirect()->route('admin.products.index')
            ->with('success', "Produk '{$product->name}' berhasil diterbitkan.");
    }

    /**
     * Form Edit Produk
     */
    public function edit($id)
    {
        $product = Product::with('simulationParam')->findOrFail($id);
        $categories = ProductCategory::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Perbarui Produk & Parameter Simulasi + Audit Log
     */
    public function update(Request $request, $id)
    {
        $product = Product::with('simulationParam')->findOrFail($id);
        $oldSnapshot = $product->toArray();

        $validated = $request->validate([
            'category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:150',
            'short_description' => 'required|string|max:255',
            'full_description' => 'required|string',
            'terms_and_conditions' => 'nullable|string',
            'riplay_file' => 'nullable|file|mimes:pdf|max:10240',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',

            'has_simulation' => 'nullable|boolean',
            'min_amount' => 'nullable|required_if:has_simulation,1|numeric|min:0',
            'max_amount' => 'nullable|required_if:has_simulation,1|numeric|gte:min_amount',
            'min_tenor_months' => 'nullable|required_if:has_simulation,1|integer|min:1',
            'max_tenor_months' => 'nullable|required_if:has_simulation,1|integer|gte:min_tenor_months',
            'base_interest_rate_pa' => 'nullable|required_if:has_simulation,1|numeric|min:0|max:100',
            'interest_type' => 'nullable|in:FLAT,EFEKTIF,ANUITAS',
            'provision_fee_percent' => 'nullable|numeric|min:0|max:100',
            'admin_fee_amount' => 'nullable|numeric|min:0',
        ]);

        $updateData = [
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'short_description' => $validated['short_description'],
            'full_description' => $validated['full_description'],
            'terms_and_conditions' => $validated['terms_and_conditions'] ?? null,
            'is_featured' => $request->boolean('is_featured', false),
            'is_active' => $request->boolean('is_active', true),
        ];

        // Ganti Berkas RIPLAY jika diunggah
        if ($request->hasFile('riplay_file')) {
            if ($product->riplay_file_url) {
                $oldPath = str_replace('/storage/', '', $product->riplay_file_url);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $file = $request->file('riplay_file');
            $fileName = 'riplay_' . $product->slug . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('riplay', $fileName, 'public');
            $updateData['riplay_file_url'] = '/storage/' . $path;
        }

        $product->update($updateData);

        // Perbarui / Hapus Parameter Simulasi
        if ($request->boolean('has_simulation')) {
            ProductSimulationParam::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'min_amount' => $validated['min_amount'],
                    'max_amount' => $validated['max_amount'],
                    'min_tenor_months' => $validated['min_tenor_months'],
                    'max_tenor_months' => $validated['max_tenor_months'],
                    'base_interest_rate_pa' => $validated['base_interest_rate_pa'],
                    'interest_type' => $validated['interest_type'] ?? 'FLAT',
                    'provision_fee_percent' => $validated['provision_fee_percent'] ?? 0.00,
                    'admin_fee_amount' => $validated['admin_fee_amount'] ?? 0.00,
                ]
            );
        } else {
            if ($product->simulationParam) {
                $product->simulationParam->delete();
            }
        }

        ActivityLogger::log(
            'PRODUCT',
            'UPDATE',
            "Memperbarui katalog produk: {$product->name} [ID: {$product->id}]",
            [
                'product_id' => $product->id,
                'before' => $oldSnapshot,
                'after' => $product->fresh()->toArray(),
            ]
        );

        return redirect()->route('admin.products.index')
            ->with('success', "Produk '{$product->name}' berhasil diperbarui.");
    }

    /**
     * Hapus Produk & Berkas RIPLAY
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $deletedSnapshot = $product->toArray();

        if ($product->riplay_file_url) {
            $filePath = str_replace('/storage/', '', $product->riplay_file_url);
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        $product->delete();

        ActivityLogger::log(
            'PRODUCT',
            'DELETE',
            "Menghapus produk perbankan: {$deletedSnapshot['name']} [ID: {$deletedSnapshot['id']}]",
            ['deleted_product' => $deletedSnapshot]
        );

        return redirect()->route('admin.products.index')
            ->with('success', "Produk '{$deletedSnapshot['name']}' berhasil dihapus.");
    }
}