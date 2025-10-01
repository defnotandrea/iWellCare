<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Prescription;
use App\Models\PrescriptionMedication;
use App\Models\User;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prescriptions = Prescription::with(['patient', 'doctor', 'medications'])
            ->orderBy('prescription_date', 'desc')
            ->paginate(10);

        return view('staff.prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = User::where('role', 'patient')->where('is_active', true)->get();
        $doctors = Doctor::where('status', 'active')->get();

        return view('staff.prescriptions.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'medications' => 'required|array|min:1',
            'medications.*.medication_name' => 'required|string|max:255',
            'medications.*.dosage' => 'required|string|max:255',
            'medications.*.frequency' => 'required|string|max:255',
            'medications.*.duration' => 'nullable|string|max:255',
            'medications.*.quantity' => 'nullable|integer',
            'medications.*.instructions' => 'nullable|string',
            'prescribed_date' => 'required|date',
            'status' => 'required|in:active,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        // Generate prescription number
        $prescriptionNumber = 'PRES-'.date('Y').'-'.str_pad(Prescription::count() + 1, 6, '0', STR_PAD_LEFT);

        // Create the prescription
        $prescription = Prescription::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'prescription_date' => $request->prescribed_date,
            'status' => $request->status,
            'notes' => $request->notes,
            'prescription_number' => $prescriptionNumber,
        ]);

        // Create the medications
        foreach ($request->medications as $medicationData) {
            PrescriptionMedication::create([
                'prescription_id' => $prescription->id,
                'medication_name' => $medicationData['medication_name'],
                'dosage' => $medicationData['dosage'],
                'frequency' => $medicationData['frequency'],
                'duration' => $medicationData['duration'] ?? null,
                'quantity' => $medicationData['quantity'] ?? null,
                'instructions' => $medicationData['instructions'] ?? null,
            ]);
        }

        return redirect()->route('staff.prescriptions.index')->with('success', 'Prescription created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prescription $prescription)
    {
        $prescription->load(['patient', 'doctor', 'medications']);

        return view('staff.prescriptions.show', compact('prescription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prescription $prescription)
    {
        $patients = User::where('role', 'patient')->where('is_active', true)->get();
        $doctors = Doctor::where('status', 'active')->get();
        $prescription->load(['patient', 'doctor', 'medications']);

        return view('staff.prescriptions.edit', compact('prescription', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prescription $prescription)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'medications' => 'required|array|min:1',
            'medications.*.medication_name' => 'required|string|max:255',
            'medications.*.dosage' => 'required|string|max:255',
            'medications.*.frequency' => 'required|string|max:255',
            'medications.*.duration' => 'nullable|string|max:255',
            'medications.*.quantity' => 'nullable|integer',
            'medications.*.instructions' => 'nullable|string',
            'prescribed_date' => 'required|date',
            'status' => 'required|in:active,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        // Update the prescription
        $prescription->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'prescription_date' => $request->prescribed_date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        // Delete existing medications
        $prescription->medications()->delete();

        // Create new medications
        foreach ($request->medications as $medicationData) {
            PrescriptionMedication::create([
                'prescription_id' => $prescription->id,
                'medication_name' => $medicationData['medication_name'],
                'dosage' => $medicationData['dosage'],
                'frequency' => $medicationData['frequency'],
                'duration' => $medicationData['duration'] ?? null,
                'quantity' => $medicationData['quantity'] ?? null,
                'instructions' => $medicationData['instructions'] ?? null,
            ]);
        }

        return redirect()->route('staff.prescriptions.index')->with('success', 'Prescription updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prescription $prescription)
    {
        // Delete associated medications first
        $prescription->medications()->delete();

        // Delete the prescription
        $prescription->delete();

        return redirect()->route('staff.prescriptions.index')->with('success', 'Prescription deleted successfully.');
    }
}
