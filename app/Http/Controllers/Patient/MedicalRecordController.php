<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Patient;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $patient = $user->patient;

        $medicalRecords = MedicalRecord::where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('patient.medical-records.index', compact('medicalRecords'));
    }

    public function show(MedicalRecord $record)
    {
        $user = auth()->user();
        $patient = $user->patient;

        // Ensure the record belongs to the authenticated patient
        if ($record->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access.');
        }

        return view('patient.medical-records.show', compact('record'));
    }
}
