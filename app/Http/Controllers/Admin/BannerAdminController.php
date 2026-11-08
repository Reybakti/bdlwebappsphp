<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerAdminController extends Controller
{
    /**
     * Daftar Seluruh Banner
     */
    public function index(Request $request)
    {
        $query = Banner::query();

        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%");
            });
        }

        $banners = $query->orderBy('order_index', 'asc')
                         ->paginate(10)
                         ->withQueryString();

        $counts = [
            'all' => Banner::count(),
            'active' => Banner::where('is_active', true)->count(),
            'inactive' => Banner::where('is_active', false)->count(),
        ];

        return view('admin.banners.index', compact('banners', 'counts'));
    }

    /**
     * Form Tambah Banner Baru
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Simpan Banner Baru + Upload Gambar + Audit Log
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'subtitle' => 'nullable|string|max:300',
            'image_desktop' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096', // Maks 4 MB
            'image_mobile' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'button_text' => 'nullable|string|max:60',
            'button_url' => 'nullable|string|max:200',
            'order_index' => 'required|integer|min:1|max:99',
            'is_active' => 'nullable|boolean',
        ], [
            'title.required' => 'Judul headline banner wajib diisi.',
            'image_desktop.required' => 'Gambar banner desktop wajib diunggah.',
            'image_desktop.image' => 'Berkas desktop harus berupa gambar.',
            'order_index.required' => 'Nomor urutan tampil wajib ditentukan.',
        ]);

        $slug = Str::slug($validated['title']);

        // Upload Gambar Desktop
        $fileDesktop = $request->file('image_desktop');
        $fileNameDesktop = 'banner_desk_' . $slug . '_' . time() . '.' . $fileDesktop->getClientOriginalExtension();
        $pathDesktop = $fileDesktop->storeAs('banners', $fileNameDesktop, 'public');
        $desktopUrl = '/storage/' . $pathDesktop;

        // Upload Gambar Mobile (Opsional)
        $mobileUrl = null;
        if ($request->hasFile('image_mobile')) {
            $fileMobile = $request->file('image_mobile');
            $fileNameMobile = 'banner_mob_' . $slug . '_' . time() . '.' . $fileMobile->getClientOriginalExtension();
            $pathMobile = $fileMobile->storeAs('banners', $fileNameMobile, 'public');
            $mobileUrl = '/storage/' . $pathMobile;
        }

        $banner = Banner::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'image_desktop_url' => $desktopUrl,
            'image_mobile_url' => $mobileUrl,
            'button_text' => $validated['button_text'] ?? null,
            'button_url' => $validated['button_url'] ?? null,
            'order_index' => $validated['order_index'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        ActivityLogger::log(
            'BANNER',
            'CREATE',
            "Menambahkan hero banner baru: {$banner->title} (Urutan: {$banner->order_index})",
            $banner->toArray()
        );

        return redirect()->route('admin.banners.index')
            ->with('success', "Banner '{$banner->title}' berhasil dipublikasikan.");
    }

    /**
     * Form Edit Banner
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);

        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Perbarui Banner + Audit Log
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $oldSnapshot = $banner->toArray();

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'subtitle' => 'nullable|string|max:300',
            'image_desktop' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'image_mobile' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'button_text' => 'nullable|string|max:60',
            'button_url' => 'nullable|string|max:200',
            'order_index' => 'required|integer|min:1|max:99',
            'is_active' => 'nullable|boolean',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_url' => $validated['button_url'] ?? null,
            'order_index' => $validated['order_index'],
            'is_active' => $request->boolean('is_active', true),
        ];

        // Ganti Gambar Desktop
        if ($request->hasFile('image_desktop')) {
            if ($banner->image_desktop_url && str_contains($banner->image_desktop_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $banner->image_desktop_url);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $fileDesktop = $request->file('image_desktop');
            $fileNameDesktop = 'banner_desk_' . Str::slug($validated['title']) . '_' . time() . '.' . $fileDesktop->getClientOriginalExtension();
            $pathDesktop = $fileDesktop->storeAs('banners', $fileNameDesktop, 'public');
            $updateData['image_desktop_url'] = '/storage/' . $pathDesktop;
        }

        // Ganti Gambar Mobile
        if ($request->hasFile('image_mobile')) {
            if ($banner->image_mobile_url && str_contains($banner->image_mobile_url, '/storage/')) {
                $oldMobPath = str_replace('/storage/', '', $banner->image_mobile_url);
                if (Storage::disk('public')->exists($oldMobPath)) {
                    Storage::disk('public')->delete($oldMobPath);
                }
            }

            $fileMobile = $request->file('image_mobile');
            $fileNameMobile = 'banner_mob_' . Str::slug($validated['title']) . '_' . time() . '.' . $fileMobile->getClientOriginalExtension();
            $pathMobile = $fileMobile->storeAs('banners', $fileNameMobile, 'public');
            $updateData['image_mobile_url'] = '/storage/' . $pathMobile;
        }

        $banner->update($updateData);

        ActivityLogger::log(
            'BANNER',
            'UPDATE',
            "Memperbarui banner: {$banner->title} [ID: {$banner->id}]",
            [
                'before' => $oldSnapshot,
                'after' => $banner->fresh()->toArray(),
            ]
        );

        return redirect()->route('admin.banners.index')
            ->with('success', "Banner '{$banner->title}' berhasil diperbarui.");
    }

    /**
     * Hapus Banner
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $deletedSnapshot = $banner->toArray();

        // Hapus file desktop
        if ($banner->image_desktop_url && str_contains($banner->image_desktop_url, '/storage/')) {
            $filePath = str_replace('/storage/', '', $banner->image_desktop_url);
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        // Hapus file mobile
        if ($banner->image_mobile_url && str_contains($banner->image_mobile_url, '/storage/')) {
            $mobPath = str_replace('/storage/', '', $banner->image_mobile_url);
            if (Storage::disk('public')->exists($mobPath)) {
                Storage::disk('public')->delete($mobPath);
            }
        }

        $banner->delete();

        ActivityLogger::log(
            'BANNER',
            'DELETE',
            "Menghapus banner: {$deletedSnapshot['title']} [ID: {$deletedSnapshot['id']}]",
            ['deleted_banner' => $deletedSnapshot]
        );

        return redirect()->route('admin.banners.index')
            ->with('success', "Banner '{$deletedSnapshot['title']}' berhasil dihapus.");
    }
}