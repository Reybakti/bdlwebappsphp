<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LpsInterestRate;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class LpsRateAdminController extends Controller
{
    /**
     * Tampilan Riwayat & Status Tingkat Bunga LPS
     */
    public function index()
    {
        $currentRate = LpsInterestRate::where('is_current', true)->first();
        $rateHistories = LpsInterestRate::orderBy('effective_start_date', 'desc')->paginate(10);

        return view('admin.lps.index', compact('currentRate', 'rateHistories'));
    }

    /**
     * Form Tambah Ketetapan Suku Bunga LPS Baru
     */
    public function create()
    {
        return view('admin.lps.create');
    }

    /**
     * Simpan Ketetapan Baru + Update Status Current + Audit Log
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rate_idr' => 'required|numeric|min:0|max:100',
            'rate_valas' => 'nullable|numeric|min:0|max:100',
            'effective_start_date' => 'required|date',
            'effective_end_date' => 'required|date|after_or_equal:effective_start_date',
            'is_current' => 'nullable|boolean',
        ], [
            'rate_idr.required' => 'Tingkat bunga penjaminan Rupiah wajib diisi.',
            'rate_idr.numeric' => 'Nilai suku bunga harus berupa angka.',
            'effective_start_date.required' => 'Tanggal awal berlaku wajib ditentukan.',
            'effective_end_date.required' => 'Tanggal akhir berlaku wajib ditentukan.',
            'effective_end_date.after_or_equal' => 'Tanggal akhir berlaku tidak boleh mendahului tanggal awal.',
        ]);

        $isCurrent = $request->boolean('is_current', true);

        // Jika diset sebagai suku bunga aktif utama, nonaktifkan periode sebelumnya
        if ($isCurrent) {
            LpsInterestRate::where('is_current', true)->update(['is_current' => false]);
        }

        $lpsRate = LpsInterestRate::create([
            'rate_idr' => $validated['rate_idr'],
            'rate_valas' => $validated['rate_valas'] ?? 0.00,
            'effective_start_date' => $validated['effective_start_date'],
            'effective_end_date' => $validated['effective_end_date'],
            'is_current' => $isCurrent,
        ]);

        // Audit Trail Pencatatan Suku Bunga LPS
        ActivityLogger::log(
            'LPS_RATE',
            'CREATE',
            "Menetapkan Suku Bunga Penjaminan LPS Baru: IDR {$lpsRate->rate_idr}% (Periode: {$lpsRate->effective_start_date} s.d. {$lpsRate->effective_end_date})" . ($isCurrent ? ' [Status: Berlaku Aktif]' : ''),
            [
                'rate_idr' => $lpsRate->rate_idr,
                'rate_valas' => $lpsRate->rate_valas,
                'effective_start_date' => $lpsRate->effective_start_date,
                'effective_end_date' => $lpsRate->effective_end_date,
                'is_current' => $lpsRate->is_current,
            ]
        );

        return redirect()->route('admin.lps.index')
            ->with('success', 'Ketetapan suku bunga penjaminan LPS berhasil diterbitkan.');
    }

    /**
     * Form Edit Ketetapan Bunga LPS
     */
    public function edit($id)
    {
        $rate = LpsInterestRate::findOrFail($id);

        return view('admin.lps.edit', compact('rate'));
    }

    /**
     * Perbarui Ketetapan Bunga LPS + Audit Log
     */
    public function update(Request $request, $id)
    {
        $rate = LpsInterestRate::findOrFail($id);
        $oldData = $rate->toArray();

        $validated = $request->validate([
            'rate_idr' => 'required|numeric|min:0|max:100',
            'rate_valas' => 'nullable|numeric|min:0|max:100',
            'effective_start_date' => 'required|date',
            'effective_end_date' => 'required|date|after_or_equal:effective_start_date',
            'is_current' => 'nullable|boolean',
        ]);

        $isCurrent = $request->boolean('is_current');

        if ($isCurrent && !$rate->is_current) {
            LpsInterestRate::where('id', '!=', $rate->id)->update(['is_current' => false]);
        }

        $rate->update([
            'rate_idr' => $validated['rate_idr'],
            'rate_valas' => $validated['rate_valas'] ?? 0.00,
            'effective_start_date' => $validated['effective_start_date'],
            'effective_end_date' => $validated['effective_end_date'],
            'is_current' => $isCurrent,
        ]);

        ActivityLogger::log(
            'LPS_RATE',
            'UPDATE',
            "Memperbarui Ketetapan Bunga LPS IDR: {$rate->rate_idr}% (Periode {$rate->effective_start_date} s.d. {$rate->effective_end_date})",
            [
                'before' => $oldData,
                'after' => $rate->toArray(),
            ]
        );

        return redirect()->route('admin.lps.index')
            ->with('success', 'Ketetapan suku bunga penjaminan LPS berhasil diperbarui.');
    }

    /**
     * Aktifkan Periode Tertentu Menjadi Current Rate
     */
    public function setCurrent($id)
    {
        $targetRate = LpsInterestRate::findOrFail($id);

        LpsInterestRate::where('is_current', true)->update(['is_current' => false]);
        $targetRate->update(['is_current' => true]);

        ActivityLogger::log(
            'LPS_RATE',
            'UPDATE',
            "Menetapkan suku bunga IDR {$targetRate->rate_idr}% sebagai tingkat bunga penjaminan aktif utama bank."
        );

        return redirect()->route('admin.lps.index')
            ->with('success', 'Tingkat bunga penjaminan aktif berhasil diperbarui.');
    }

    /**
     * Hapus Data Riwayat Suku Bunga
     */
    public function destroy($id)
    {
        $rate = LpsInterestRate::findOrFail($id);

        if ($rate->is_current) {
            return back()->with('error', 'Suku bunga penjaminan yang sedang berstatus AKTIF tidak boleh dihapus.');
        }

        $deletedSnapshot = $rate->toArray();
        $rate->delete();

        ActivityLogger::log(
            'LPS_RATE',
            'DELETE',
            "Menghapus riwayat suku bunga LPS IDR {$deletedSnapshot['rate_idr']}% (Periode {$deletedSnapshot['effective_start_date']})",
            ['deleted_rate' => $deletedSnapshot]
        );

        return redirect()->route('admin.lps.index')
            ->with('success', 'Riwayat ketetapan suku bunga berhasil dihapus.');
    }
}