<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Prescription;

class PrescriptionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $patient = $user->patient;

        $prescriptions = Prescription::where('patient_id', $patient->id)
            ->with(['doctor', 'medications'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('patient.prescriptions.index', compact('prescriptions'));
    }

    public function show(Prescription $prescription)
    {
        $user = auth()->user();
        $patient = $user->patient;

        // Ensure the prescription belongs to the authenticated patient
        if ($prescription->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access.');
        }

        return view('patient.prescriptions.show', compact('prescription'));
    }
}
