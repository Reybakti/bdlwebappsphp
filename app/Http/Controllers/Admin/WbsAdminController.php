<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WbsReport;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class WbsAdminController extends Controller
{
    /**
     * Daftar Laporan Whistleblowing Masuk
     */
    public function index(Request $request)
    {
        $query = WbsReport::query();

        // Filter Status Investigasi (Mendukung alias skema baru & lama)
        if ($request->filled('status')) {
            $status = strtoupper($request->status);
            if ($status === 'RECEIVED' || $status === 'SUBMITTED') {
                $query->whereIn('status', ['RECEIVED', 'SUBMITTED']);
            } elseif ($status === 'IN_INVESTIGATION' || $status === 'INVESTIGATING') {
                $query->whereIn('status', ['IN_INVESTIGATION', 'INVESTIGATING']);
            } elseif ($status === 'CLOSED' || $status === 'RESOLVED') {
                $query->whereIn('status', ['CLOSED', 'RESOLVED']);
            } else {
                $query->where('status', $status);
            }
        }

        // Filter Jenis Dugaan Pelanggaran
        if ($request->filled('incident_type')) {
            $query->where('incident_type', $request->incident_type);
        }

        // Pencarian (Kode Tracking WBS, Pihak Terlapor, Lokasi Kejadian, Jenis Pelanggaran)
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('tracking_code', 'like', "%{$search}%")
                  ->orWhere('reported_person', 'like', "%{$search}%")
                  ->orWhere('incident_location', 'like', "%{$search}%")
                  ->orWhere('incident_type', 'like', "%{$search}%");
            });
        }

        $reports = $query->latest()->paginate(10)->withQueryString();

        // Hitungan Ringkas dengan Alias Lengkap untuk Tab Filter View
        $receivedCount = WbsReport::whereIn('status', ['RECEIVED', 'SUBMITTED'])->count();
        $investigatingCount = WbsReport::whereIn('status', ['IN_INVESTIGATION', 'INVESTIGATING'])->count();
        $closedCount = WbsReport::whereIn('status', ['CLOSED', 'RESOLVED'])->count();

        $counts = [
            'all'              => WbsReport::count(),
            'received'         => $receivedCount,
            'submitted'        => $receivedCount,      // Alias untuk template blade yang memanggil 'submitted'
            'investigating'    => $investigatingCount,
            'in_investigation' => $investigatingCount,  // Alias untuk template blade yang memanggil 'in_investigation'
            'closed'           => $closedCount,
            'resolved'         => $closedCount,         // Alias untuk template blade yang memanggil 'resolved'
        ];

        return view('admin.wbs.index', compact('reports', 'counts'));
    }

    /**
     * Detail Laporan Rahasia WBS
     */
    public function show($id)
    {
        $report = WbsReport::findOrFail($id);

        return view('admin.wbs.show', compact('report'));
    }

    /**
     * Perbarui Status & Catatan Investigasi Audit Intern (SKAI) + Audit Log
     */
    public function update(Request $request, $id)
    {
        $report = WbsReport::findOrFail($id);
        $oldStatus = $report->status;

        $validated = $request->validate([
            'status' => 'required|in:RECEIVED,SUBMITTED,IN_INVESTIGATION,INVESTIGATING,RESOLVED,CLOSED',
            'investigation_notes' => 'nullable|string|max:3000',
        ], [
            'status.required' => 'Pilih status investigasi kasus.',
            'status.in' => 'Pilihan status investigasi tidak valid.',
            'investigation_notes.max' => 'Catatan telaah investigasi maksimal 3000 karakter.',
        ]);

        $newStatus = $validated['status'];

        $report->update([
            'status' => $newStatus,
            'investigation_notes' => $validated['investigation_notes'],
        ]);

        // Catat Rekam Jejak Audit Intern (Confidential Audit Trail)
        ActivityLogger::log(
            'WBS',
            'UPDATE',
            "Memperbarui status investigasi WBS {$report->tracking_code} dari [{$oldStatus}] menjadi [{$newStatus}]",
            [
                'tracking_code' => $report->tracking_code,
                'incident_type' => $report->incident_type,
                'reported_person' => $report->reported_person,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'has_notes' => !empty($validated['investigation_notes']),
            ]
        );

        return redirect()->route('admin.wbs.show', $report->id)
            ->with('success', "Status investigasi laporan {$report->tracking_code} berhasil diperbarui.");
    }
}