<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WbsController extends Controller
{
    /**
     * Tampilan Formulir Whistleblowing System (WBS)
     */
    public function create()
    {
        $profile = CompanyProfile::first();
        return view('public.services.wbs', compact('profile'));
    }

    /**
     * Simpan Laporan WBS & Terbitkan Kode Registrasi Rahasia
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'is_anonymous' => 'nullable|boolean',
            'reporter_name' => 'nullable|string|max:150',
            'reporter_contact' => 'nullable|string|max:100',
            'violation_type' => 'required|string|in:FRAUD_KORUPSI,SUAP_GRATIFIKASI,PENGGELAPAN_DANA,BENTURAN_KEPENTINGAN,PELANGGARAN_SOP,LAINNYA',
            'involved_parties' => 'required|string|max:255',
            'incident_location' => 'required|string|max:200',
            'incident_date' => 'required|date',
            'chronology' => 'required|string|min:30',
            'evidence_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,zip|max:10240', // Maksimal 10MB
        ], [
            'violation_type.required' => 'Pilih jenis dugaan pelanggaran.',
            'involved_parties.required' => 'Sebutkan pihak/pejabat/karyawan yang diduga terlibat.',
            'incident_location.required' => 'Sebutkan lokasi unit kerja atau cabang terjadinya pelanggaran.',
            'incident_date.required' => 'Pilih perkiraan tanggal terjadinya peristiwa.',
            'chronology.required' => 'Uraikan kronologi dugaan pelanggaran secara mendalam.',
            'chronology.min' => 'Kronologi kejadian minimal berisi 30 karakter.',
            'evidence_file.mimes' => 'Format berkas bukti harus berupa PDF, JPG, PNG, atau ZIP.',
            'evidence_file.max' => 'Ukuran berkas bukti maksimal 10 MB.',
        ]);

        $filePath = null;
        if ($request->hasFile('evidence_file')) {
            $file = $request->file('evidence_file');
            $fileName = 'wbs_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('wbs_evidence', $fileName, 'public');
        }

        // Format Kode Tiket Rahasia WBS: WBS-YYYYMMDD-XXXX
        $registrationCode = 'WBS-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        $isAnonymous = $request->boolean('is_anonymous');

        DB::table('wbs_reports')->insert([
            'registration_code' => $registrationCode,
            'is_anonymous' => $isAnonymous,
            'reporter_name' => $isAnonymous ? 'ANONIM' : ($validated['reporter_name'] ?? 'ANONIM'),
            'reporter_contact' => $isAnonymous ? null : ($validated['reporter_contact'] ?? null),
            'violation_type' => $validated['violation_type'],
            'involved_parties' => $validated['involved_parties'],
            'incident_location' => $validated['incident_location'],
            'incident_date' => $validated['incident_date'],
            'chronology' => $validated['chronology'],
            'evidence_file_url' => $filePath ? '/storage/' . $filePath : null,
            'status' => 'SUBMITTED', // SUBMITTED, INVESTIGATING, CLOSED
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('services.wbs')
            ->with('wbs_success', 'Laporan dugaan pelanggaran berhasil tercatat secara rahasia.')
            ->with('registration_code', $registrationCode);
    }
}