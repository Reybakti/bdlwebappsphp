<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyProfileAdminController extends Controller
{
    public function index()
    {
        $profile = CompanyProfile::firstOrCreate(['id' => 1], [
            'name' => 'PT BPR Bank Daerah Lamongan (Perseroda)',
            'head_office_address' => 'Jl. Panglima Sudirman No. 85, Sukorejo, Kec. Lamongan, Kab. Lamongan, Jawa Timur 62215',
            'phone' => '(0322) 321175',
            'email' => 'sekretariat@bdl.co.id',
            'whatsapp_hotline' => '081234567890',
            'ojk_lps_statement' => 'PT BPR Bank Daerah Lamongan (Perseroda) berizin dan diawasi oleh Otoritas Jasa Keuangan (OJK) serta merupakan peserta penjaminan Lembaga Penjamin Simpanan (LPS).',
            'video_source_type' => 'URL',
        ]);

        return view('admin.profile.index', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = CompanyProfile::firstOrFail();
        $oldSnapshot = $profile->toArray();

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'head_office_address' => 'required|string',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'history' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'ojk_lps_statement' => 'required|string',

            // Validasi Video Profil
            'video_title' => 'nullable|string|max:150',
            'video_source_type' => 'required|in:URL,UPLOAD',
            'video_url' => 'nullable|required_if:video_source_type,URL|url|max:255',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg|max:61440', // Maksimal 60MB

            // Validasi Struktur Organisasi (POJK Tata Kelola GCG)
            'org_chart_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120', // Maksimal 5MB
            'org_structure_decree' => 'nullable|string|max:150',
            'org_structure_effective_date' => 'nullable|date',
            'org_structure_notes' => 'nullable|string|max:3000',

            // Validasi Media Sosial & Humas
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'whatsapp_hotline' => 'nullable|string|max:50',
            'media_contact_person' => 'nullable|string|max:150',
            'media_contact_phone' => 'nullable|string|max:50',
            'media_contact_email' => 'nullable|email|max:100',
        ], [
            'video_url.required_if' => 'Tautan video wajib diisi jika memilih sumber URL/YouTube.',
            'video_url.url' => 'Tautan video harus berupa URL valid.',
            'video_file.mimes' => 'Format berkas video harus MP4, WebM, atau OGG.',
            'video_file.max' => 'Ukuran berkas video maksimal 60 MB.',
            'org_chart_image.image' => 'Berkas bagan struktur organisasi harus berupa gambar.',
            'org_chart_image.mimes' => 'Format gambar bagan harus JPG, PNG, WebP, atau SVG.',
            'org_chart_image.max' => 'Ukuran gambar bagan organisasi maksimal 5 MB.',
        ]);

        // 1. Simpan Berkas Video jika ada upload baru
        if ($request->hasFile('video_file')) {
            if ($profile->video_file_path && Storage::disk('public')->exists($profile->video_file_path)) {
                Storage::disk('public')->delete($profile->video_file_path);
            }

            $videoPath = $request->file('video_file')->store('company/videos', 'public');
            $validated['video_file_path'] = $videoPath;
        }

        // 2. Simpan Bagan Struktur Organisasi jika ada upload baru
        if ($request->hasFile('org_chart_image')) {
            if ($profile->org_chart_image && Storage::disk('public')->exists($profile->org_chart_image)) {
                Storage::disk('public')->delete($profile->org_chart_image);
            }

            $chartPath = $request->file('org_chart_image')->store('company/structure', 'public');
            $validated['org_chart_image'] = $chartPath;
        }

        $profile->update($validated);

        ActivityLogger::log(
            'COMPANY_PROFILE',
            'UPDATE',
            'Memperbarui profil lembaga, video profil, bagan struktur organisasi, dan kontak media resmi',
            [
                'before' => $oldSnapshot,
                'after' => $profile->fresh()->toArray(),
            ]
        );

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profil lembaga, bagan struktur organisasi, dan pengaturan media berhasil disimpan.');
    }
}