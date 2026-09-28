<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClinicSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class ClinicSubmissionController extends Controller
{
   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phc'         => ['required', 'string', 'max:255'],
            'clinic_name' => ['required', 'string', 'max:255'],
            'doctor_name' => ['nullable', 'string', 'max:255'],
            'phone'       => ['required', 'digits:10'],
            'lat'         => ['required', 'numeric', 'between:-90,90'],
            'lng'         => ['required', 'numeric', 'between:-180,180'],
            'image'       => ['nullable', 'url', 'max:2048'],
        ]);

        try {
            $submission = ClinicSubmission::create([
                'phc'         => $validated['phc'],
                'clinic_name' => $validated['clinic_name'],
                'doctor_name' => $validated['doctor_name'] ?? null,
                'phone'       => $validated['phone'],
                'lat'         => $validated['lat'],
                'lng'         => $validated['lng'],
                'image'       => $validated['image'] ?? null,
                'source'      => 'whatsapp',
                'raw_payload' => $request->all(),
            ]);

            return response()->json([
                'success' => true,
                'id'      => $submission->id,
            ], 201);

        } catch (\Throwable $e) {

            Log::error('Clinic submission failed', [
                'error' => $e->getMessage(),
                'phone' => $validated['phone'] ?? null,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Submission failed',
            ], 422);
        }
    }

   
    public function index()
    {
        $complaints = ClinicSubmission::latest()->paginate(20);

        return view('complaints.index', compact('complaints'));
    }

  
    public function show($id)
    {
        $complaint = ClinicSubmission::findOrFail($id);

        return view('complaints.show', compact('complaint'));
    }

   
    public function exportPdf()
    {
        $complaints = ClinicSubmission::latest()->get();

        $pdf = Pdf::loadView('complaints.pdf', compact('complaints'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('clinic-complaints.pdf');
    }
}
