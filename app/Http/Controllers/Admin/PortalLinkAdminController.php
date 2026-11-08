<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortalLink;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PortalLinkAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = PortalLink::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $links = $query->orderBy('category')->orderBy('order_index')->paginate(15)->withQueryString();

        $categories = [
            'REGULATOR' => 'Regulator & Pengawas Resmi',
            'PEMDA' => 'Pemerintah Daerah & BUMD',
            'LAYANAN_PUBLIK' => 'Layanan Nasabah & Aduan',
            'DOKUMEN_PUBLIKASI' => 'Dokumen & Kepatuhan Transparansi',
            'REKANAN' => 'Mitra & Afiliasi Finansial',
        ];

        return view('admin.portals.index', compact('links', 'categories'));
    }

    public function create()
    {
        $categories = [
            'REGULATOR' => 'Regulator & Pengawas Resmi (OJK, LPS, BI)',
            'PEMDA' => 'Pemerintah Daerah & Mitra BUMD',
            'LAYANAN_PUBLIK' => 'Layanan Nasabah & Aduan',
            'DOKUMEN_PUBLIKASI' => 'Dokumen & Kepatuhan Transparansi',
            'REKANAN' => 'Mitra Finansial & Afiliasi',
        ];

        return view('admin.portals.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'required|in:REGULATOR,PEMDA,LAYANAN_PUBLIK,DOKUMEN_PUBLIKASI,REKANAN',
            'url' => 'required|url|max:255',
            'description' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:50',
            'icon_name' => 'nullable|string|max:50',
            'is_external' => 'boolean',
            'is_active' => 'boolean',
            'order_index' => 'integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['is_external'] = $request->has('is_external');
        $validated['is_active'] = $request->has('is_active');
        $validated['order_index'] = $request->input('order_index', 0);

        $portal = PortalLink::create($validated);

        ActivityLogger::log(
            'PORTAL_LINK',
            'CREATE',
            "Menambahkan tautan direktori portal: {$portal->title}",
            $portal->toArray()
        );

        return redirect()->route('admin.portals.index')->with('success', 'Tautan portal informasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $link = PortalLink::findOrFail($id);
        $categories = [
            'REGULATOR' => 'Regulator & Pengawas Resmi (OJK, LPS, BI)',
            'PEMDA' => 'Pemerintah Daerah & Mitra BUMD',
            'LAYANAN_PUBLIK' => 'Layanan Nasabah & Aduan',
            'DOKUMEN_PUBLIKASI' => 'Dokumen & Kepatuhan Transparansi',
            'REKANAN' => 'Mitra Finansial & Afiliasi',
        ];

        return view('admin.portals.edit', compact('link', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $link = PortalLink::findOrFail($id);
        $oldSnapshot = $link->toArray();

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'required|in:REGULATOR,PEMDA,LAYANAN_PUBLIK,DOKUMEN_PUBLIKASI,REKANAN',
            'url' => 'required|url|max:255',
            'description' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:50',
            'icon_name' => 'nullable|string|max:50',
            'order_index' => 'integer|min:0',
        ]);

        $validated['is_external'] = $request->has('is_external');
        $validated['is_active'] = $request->has('is_active');
        $validated['order_index'] = $request->input('order_index', 0);

        $link->update($validated);

        ActivityLogger::log(
            'PORTAL_LINK',
            'UPDATE',
            "Memperbarui tautan portal direktori: {$link->title}",
            [
                'before' => $oldSnapshot,
                'after' => $link->fresh()->toArray(),
            ]
        );

        return redirect()->route('admin.portals.index')->with('success', 'Tautan portal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $link = PortalLink::findOrFail($id);
        $title = $link->title;

        ActivityLogger::log(
            'PORTAL_LINK',
            'DELETE',
            "Menghapus tautan portal direktori: {$title}",
            $link->toArray()
        );

        $link->delete();

        return redirect()->route('admin.portals.index')->with('success', "Tautan portal '{$title}' berhasil dihapus.");
    }
}