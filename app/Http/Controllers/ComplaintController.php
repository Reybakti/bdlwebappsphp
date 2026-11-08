<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{
    /**
     * Tampilan Formulir Pengaduan Nasabah
     */
    public function create()
    {
        $profile = CompanyProfile::first();
        return view('public.services.complaint', compact('profile'));
    }

    /**
     * Simpan Pengaduan Nasabah & Terbitkan Nomor Tiket
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:150',
            'nik' => 'required|digits:16',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'account_number' => 'nullable|string|max:50',
            'category' => 'required|string|in:TABUNGAN,DEPOSITO,KREDIT,LAYANAN_KASIR,LAINNYA',
            'subject' => 'required|string|max:200',
            'description' => 'required|string|min:20',
            'evidence_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // Maksimal 5MB
        ], [
            'customer_name.required' => 'Nama lengkap wajib diisi sesuai e-KTP.',
            'nik.required' => 'Nomor NIK 16 digit wajib diisi.',
            'nik.digits' => 'Nomor NIK harus berjumlah tepat 16 digit angka.',
            'phone.required' => 'Nomor WhatsApp / HP aktif wajib diisi untuk konfirmasi.',
            'category.required' => 'Silakan pilih kategori pengaduan perbankan.',
            'subject.required' => 'Judul ringkas kendala wajib diisi.',
            'description.required' => 'Mohon jelaskan kronologi kendala secara mendetail.',
            'description.min' => 'Kronologi pengaduan minimal berisi 20 karakter.',
            'evidence_file.mimes' => 'Format berkas bukti harus berupa PDF, JPG, atau PNG.',
            'evidence_file.max' => 'Ukuran berkas bukti maksimal 5 MB.',
        ]);

        // Upload Berkas Lampiran jika ada
        $filePath = null;
        if ($request->hasFile('evidence_file')) {
            $file = $request->file('evidence_file');
            $fileName = 'bukti_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('complaints_evidence', $fileName, 'public');
        }

        // Generate Nomor Tiket Unik Format: BDL-YYYYMMDD-XXXX
        $datePrefix = date('Ymd');
        $randomCode = strtoupper(Str::random(4));
        $ticketNumber = 'BDL-' . $datePrefix . '-' . $randomCode;

        // Simpan ke tabel complaints
        DB::table('complaints')->insert([
            'ticket_number' => $ticketNumber,
            'customer_name' => $validated['customer_name'],
            'nik' => $validated['nik'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'account_number' => $validated['account_number'],
            'category' => $validated['category'],
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'evidence_file_url' => $filePath ? '/storage/' . $filePath : null,
            'status' => 'PENDING', // PENDING, IN_PROGRESS, RESOLVED, REJECTED
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('services.ticket', ['ticket' => $ticketNumber])
            ->with('success', 'Pengaduan Anda berhasil dikirim. Harap catat dan simpan Nomor Tiket Anda di bawah ini.');
    }

    /**
     * Tampilan & Logika Pengecekan Status Tiket Pengaduan
     */
    public function checkTicket(Request $request)
    {
        $profile = CompanyProfile::first();
        $ticketCode = $request->query('ticket') ?? $request->input('ticket');
        $complaint = null;

        if ($ticketCode) {
            $complaint = DB::table('complaints')
                ->where('ticket_number', trim($ticketCode))
                ->first();
        }

        return view('public.services.ticket', compact('profile', 'ticketCode', 'complaint'));
    }
}