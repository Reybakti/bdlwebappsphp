<?php

namespace App\Http\Controllers;

use App\Models\WbsReport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WbsController extends Controller
{
    public function create()
    {
        return view('public.services.wbs');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reporter_name' => 'nullable|string|max:150',
            'reporter_contact' => 'nullable|string|max:150',
            'incident_type' => 'required|string|max:100',
            'reported_person' => 'required|string|max:150',
            'incident_date' => 'required|date',
            'incident_location' => 'required|string|max:150',
            'description' => 'required|string',
            'evidence_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $trackingCode = 'WBS-' . strtoupper(Str::random(12));

        $evidencePath = null;
        if ($request->hasFile('evidence_file')) {
            $evidencePath = $request->file('evidence_file')->store('wbs_evidence', 'public');
        }

        WbsReport::create([
            'tracking_code' => $trackingCode,
            'reporter_name' => $validated['reporter_name'] ?? null,
            'reporter_contact' => $validated['reporter_contact'] ?? null,
            'incident_type' => $validated['incident_type'],
            'reported_person' => $validated['reported_person'],
            'incident_date' => $validated['incident_date'],
            'incident_location' => $validated['incident_location'],
            'description' => $validated['description'],
            'evidence_file_url' => $evidencePath,
            'status' => 'RECEIVED',
        ]);

        return redirect()->route('services.wbs')
            ->with('tracking_code', $trackingCode);
    }
}