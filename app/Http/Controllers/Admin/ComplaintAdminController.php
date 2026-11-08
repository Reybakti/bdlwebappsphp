<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerComplaint;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintAdminController extends Controller
{
    /**
     * Daftar Pengaduan Nasabah
     */
    public function index(Request $request)
    {
        $query = CustomerComplaint::query();

        // Filter Status Penanganan
        if ($request->filled('status')) {
            $status = strtoupper($request->status);
            if ($status === 'RECEIVED' || $status === 'PENDING') {
                $query->whereIn('status', ['RECEIVED', 'PENDING']);
            } elseif ($status === 'IN_REVIEW' || $status === 'IN_PROGRESS') {
                $query->whereIn('status', ['IN_REVIEW', 'IN_PROGRESS']);
            } else {
                $query->where('status', $status);
            }
        }

        // Filter Kategori Masalah
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Pencarian (Kode Tiket, Nama Lengkap, NIK, No Rekening, Telepon)
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_code', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('account_number', 'like', "%{$search}%");
            });
        }

        $complaints = $query->latest()->paginate(10)->withQueryString();

        // Agregasi Hitungan dengan Alias Lengkap agar Aman di View Blade
        $pendingCount = CustomerComplaint::whereIn('status', ['RECEIVED', 'PENDING'])->count();
        $inReviewCount = CustomerComplaint::whereIn('status', ['IN_REVIEW', 'IN_PROGRESS'])->count();

        $counts = [
            'all'         => CustomerComplaint::count(),
            'pending'     => $pendingCount,
            'received'    => $pendingCount,   // Alias untuk template view yang memanggil 'received'
            'in_review'   => $inReviewCount,
            'in_progress' => $inReviewCount,  // Alias untuk template view yang memanggil 'in_progress'
            'resolved'    => CustomerComplaint::where('status', 'RESOLVED')->count(),
            'rejected'    => CustomerComplaint::where('status', 'REJECTED')->count(),
        ];

        return view('admin.complaints.index', compact('complaints', 'counts'));
    }

    /**
     * Detail Pengaduan Nasabah
     */
    public function show($id)
    {
        // Muat relasi petugas penangan jika relasi tersedia di Model CustomerComplaint
        $complaint = CustomerComplaint::findOrFail($id);

        if (method_exists($complaint, 'handler')) {
            $complaint->load('handler');
        } elseif (method_exists($complaint, 'handledBy')) {
            $complaint->load('handledBy');
        }

        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Perbarui Status & Solusi Penanganan (POJK 22/2023) + Audit Log
     */
    public function update(Request $request, $id)
    {
        $complaint = CustomerComplaint::findOrFail($id);
        $oldStatus = $complaint->status;

        $validated = $request->validate([
            'status' => 'required|in:RECEIVED,PENDING,IN_REVIEW,IN_PROGRESS,RESOLVED,REJECTED',
            'resolution_notes' => 'nullable|string|max:2000',
        ], [
            'status.required' => 'Pilih status pengaduan.',
            'status.in' => 'Pilihan status pengaduan tidak valid.',
            'resolution_notes.max' => 'Catatan penyelesaian maksimal 2000 karakter.',
        ]);

        $newStatus = $validated['status'];

        $updateData = [
            'status' => $newStatus,
            'resolution_notes' => $validated['resolution_notes'],
            'handled_by' => Auth::id(),
        ];

        // Kelola timestamp tuntas jika status berubah menjadi RESOLVED
        if ($newStatus === 'RESOLVED' && $oldStatus !== 'RESOLVED') {
            $updateData['resolved_at'] = now();
        } elseif ($newStatus !== 'RESOLVED') {
            $updateData['resolved_at'] = null;
        }

        $complaint->update($updateData);

        // Catat Audit Trail Aktivitas Kepatuhan
        ActivityLogger::log(
            'COMPLAINT',
            'UPDATE',
            "Memperbarui status tiket pengaduan {$complaint->ticket_code} dari [{$oldStatus}] menjadi [{$newStatus}]",
            [
                'ticket_code' => $complaint->ticket_code,
                'customer_name' => $complaint->full_name,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'resolution_notes' => $validated['resolution_notes'],
            ]
        );

        return redirect()->route('admin.complaints.show', $complaint->id)
            ->with('success', "Status tiket {$complaint->ticket_code} berhasil diperbarui.");
    }
}