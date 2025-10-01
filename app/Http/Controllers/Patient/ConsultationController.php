<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Patient;

class ConsultationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $patient = $user->patient;

        $consultations = Consultation::where('patient_id', $patient->id)
            ->with(['doctor', 'appointment'])
            ->orderBy('consultation_date', 'desc')
            ->paginate(10);

        return view('patient.consultations.index', compact('consultations'));
    }

    public function show(Consultation $consultation)
    {
        $user = auth()->user();
        $patient = $user->patient;

        // Ensure the consultation belongs to the authenticated patient
        if ($consultation->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access.');
        }

        return view('patient.consultations.show', compact('consultation'));
    }
}
