<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FinancialReportAdminController extends Controller
{
    /**
     * Daftar Laporan Publikasi & GCG
     */
    public function index(Request $request)
    {
        $query = FinancialReport::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        // Pengurutan berdasarkan tahun dan tanggal publikasi
        $reports = $query->orderBy('year', 'desc')
                         ->orderBy('published_at', 'desc')
                         ->paginate(12)
                         ->withQueryString();

        $years = FinancialReport::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        // Hitungan per kategori laporan
        $counts = [
            'all' => FinancialReport::count(),
            'triwulan' => FinancialReport::where('type', 'like', 'TRIWULAN%')->count(),
            'audited' => FinancialReport::where('type', 'TAHUNAN_AUDITED')->count(),
            'gcg' => FinancialReport::where('type', 'GCG')->count(),
        ];

        return view('admin.reports.index', compact('reports', 'years', 'counts'));
    }

    /**
     * Form Unggah Laporan Baru
     */
    public function create()
    {
        return view('admin.reports.create');
    }

    /**
     * Simpan Laporan Baru + Audit Log
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'type' => 'required|in:TRIWULAN_1,TRIWULAN_2,TRIWULAN_3,TRIWULAN_4,TAHUNAN_AUDITED,GCG',
            'year' => 'required|digits:4|integer|min:2010|max:' . (date('Y') + 1),
            'published_at' => 'required|date',
            'pdf_file' => 'required|file|mimes:pdf|max:15360', // Maks 15 MB
        ], [
            'title.required' => 'Judul publikasi laporan wajib diisi.',
            'type.required' => 'Pilih jenis publikasi laporan.',
            'year.required' => 'Tahun buku laporan wajib diisi.',
            'published_at.required' => 'Tanggal publikasi wajib ditentukan.',
            'pdf_file.required' => 'Berkas PDF laporan wajib diunggah.',
            'pdf_file.mimes' => 'Format dokumen wajib berekstensi PDF.',
            'pdf_file.max' => 'Ukuran berkas PDF maksimal 15 MB.',
        ]);

        $file = $request->file('pdf_file');
        $fileName = 'report_' . Str::slug($validated['type']) . '_' . $validated['year'] . '_' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('financial_reports', $fileName, 'public');

        $report = FinancialReport::create([
            'created_by' => Auth::id(),
            'title' => $validated['title'],
            'type' => $validated['type'],
            'year' => $validated['year'],
            'published_at' => $validated['published_at'],
            'file_url' => '/storage/' . $filePath,
        ]);

        // Audit Trail Pencatatan Dokumen Baru
        ActivityLogger::log(
            'REPORT',
            'CREATE',
            "Mengunggah laporan publikasi: {$report->title} [{$report->type} - Tahun {$report->year}]",
            [
                'report_id' => $report->id,
                'title' => $report->title,
                'type' => $report->type,
                'year' => $report->year,
                'published_at' => $report->published_at,
                'file_url' => $report->file_url,
            ]
        );

        return redirect()->route('admin.reports.index')
            ->with('success', 'Laporan publikasi berhasil ditambahkan ke sistem.');
    }

    /**
     * Form Edit Laporan
     */
    public function edit($id)
    {
        $report = FinancialReport::findOrFail($id);

        return view('admin.reports.edit', compact('report'));
    }

    /**
     * Perbarui Laporan + Audit Log
     */
    public function update(Request $request, $id)
    {
        $report = FinancialReport::findOrFail($id);
        $oldData = $report->only(['title', 'type', 'year', 'published_at', 'file_url']);

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'type' => 'required|in:TRIWULAN_1,TRIWULAN_2,TRIWULAN_3,TRIWULAN_4,TAHUNAN_AUDITED,GCG',
            'year' => 'required|digits:4|integer|min:2010|max:' . (date('Y') + 1),
            'published_at' => 'required|date',
            'pdf_file' => 'nullable|file|mimes:pdf|max:15360',
        ], [
            'title.required' => 'Judul publikasi laporan wajib diisi.',
            'pdf_file.mimes' => 'Format berkas wajib berekstensi PDF.',
            'pdf_file.max' => 'Ukuran berkas PDF maksimal 15 MB.',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'type' => $validated['type'],
            'year' => $validated['year'],
            'published_at' => $validated['published_at'],
        ];

        $fileReplaced = false;
        if ($request->hasFile('pdf_file')) {
            $oldPath = str_replace('/storage/', '', $report->file_url);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            $file = $request->file('pdf_file');
            $fileName = 'report_' . Str::slug($validated['type']) . '_' . $validated['year'] . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('financial_reports', $fileName, 'public');
            $updateData['file_url'] = '/storage/' . $filePath;
            $fileReplaced = true;
        }

        $report->update($updateData);

        // Audit Trail Pembaruan Dokumen
        ActivityLogger::log(
            'REPORT',
            'UPDATE',
            "Memperbarui dokumen laporan publikasi: {$report->title} [ID: {$report->id}]" . ($fileReplaced ? ' (Berkas PDF diganti)' : ''),
            [
                'report_id' => $report->id,
                'before' => $oldData,
                'after' => $report->only(['title', 'type', 'year', 'published_at', 'file_url']),
                'file_replaced' => $fileReplaced,
            ]
        );

        return redirect()->route('admin.reports.index')
            ->with('success', 'Laporan publikasi berhasil diperbarui.');
    }

    /**
     * Hapus Laporan + Audit Log
     */
    public function destroy($id)
    {
        $report = FinancialReport::findOrFail($id);
        $deletedSnapshot = $report->toArray();

        $filePath = str_replace('/storage/', '', $report->file_url);
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $report->delete();

        // Audit Trail Penghapusan Dokumen
        ActivityLogger::log(
            'REPORT',
            'DELETE',
            "Menghapus laporan publikasi: {$deletedSnapshot['title']} [{$deletedSnapshot['type']} - Tahun {$deletedSnapshot['year']}]",
            [
                'deleted_report' => $deletedSnapshot,
            ]
        );

        return redirect()->route('admin.reports.index')
            ->with('success', 'Dokumen laporan publikasi berhasil dihapus.');
    }
}