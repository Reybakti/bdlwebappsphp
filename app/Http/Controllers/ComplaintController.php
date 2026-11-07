<?php

namespace App\Http\Controllers;

use App\Models\CustomerComplaint;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function create()
    {
        return view('public.services.complaint');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'nik' => 'required|numeric|digits:16',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:150',
            'account_number' => 'nullable|string|max:50',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Generate Nomor Tiket: BDL-YYYYMMDD-XXXX
        $today = Carbon::now()->format('Ymd');
        $randomSeq = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
        $ticketCode = "BDL-{$today}-{$randomSeq}";

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('complaints_attachments', 'public');
        }

        $complaint = CustomerComplaint::create([
            'ticket_code' => $ticketCode,
            'full_name' => $validated['full_name'],
            'nik' => $validated['nik'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'account_number' => $validated['account_number'] ?? null,
            'category' => $validated['category'],
            'description' => $validated['description'],
            'attachment_url' => $attachmentPath,
            'status' => 'PENDING',
        ]);

        return redirect()->route('services.ticket', ['code' => $ticketCode])
            ->with('success', 'Pengaduan berhasil diajukan dengan Nomor Tiket: ' . $ticketCode);
    }

    public function checkTicket(Request $request)
    {
        $ticket = null;
        if ($request->filled('ticket_code')) {
            $ticket = CustomerComplaint::where('ticket_code', trim($request->ticket_code))->first();
        }

        return view('public.services.check-ticket', compact('ticket'));
    }
}