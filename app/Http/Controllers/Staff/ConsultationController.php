<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consultations = Consultation::with(['patient.user', 'doctor.user'])->paginate(10);

        return view('staff.consultations.index', compact('consultations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->where('status', 'active')->get();
        $appointments = \App\Models\Appointment::with(['patient.user', 'doctor.user'])
            ->where('status', 'scheduled')
            ->where('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        // Get the selected patient ID from the request
        $selectedPatientId = $request->get('patient_id');

        return view('staff.consultations.create', compact('patients', 'doctors', 'appointments', 'selectedPatientId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Determine if this is a draft save
        $isDraft = $request->get('status') === 'draft';

        // Validation rules - less strict for drafts
        $rules = [
            'appointment_id' => 'nullable|exists:appointments,id',
            'patient_id' => $isDraft ? 'nullable|exists:patients,id' : 'required|exists:patients,id',
            'doctor_id' => $isDraft ? 'nullable|exists:users,id' : 'required|exists:users,id',
            'consultation_date' => $isDraft ? 'nullable|date' : 'required|date',
            'chief_complaint' => $isDraft ? 'nullable|string' : 'required|string',
            'present_illness' => 'nullable|string',
            'past_medical_history' => 'nullable|string',
            'medications' => 'nullable|string',
            'allergies' => 'nullable|string',
            'blood_pressure' => 'nullable|string',
            'heart_rate' => 'nullable|string',
            'temperature' => 'nullable|string',
            'respiratory_rate' => 'nullable|string',
            'height' => 'nullable|string',
            'weight' => 'nullable|string',
            'bmi' => 'nullable|string',
        ];

        $request->validate($rules);

        // Prepare vital signs data
        $clinicalMeasurements = [];
        if ($request->filled('blood_pressure')) {
            $clinicalMeasurements['blood_pressure'] = $request->blood_pressure;
        }
        if ($request->filled('heart_rate')) {
            $clinicalMeasurements['heart_rate'] = $request->heart_rate;
        }
        if ($request->filled('temperature')) {
            $clinicalMeasurements['temperature'] = $request->temperature;
        }
        if ($request->filled('respiratory_rate')) {
            $clinicalMeasurements['respiratory_rate'] = $request->respiratory_rate;
        }
        if ($request->filled('height')) {
            $clinicalMeasurements['height'] = $request->height;
        }
        if ($request->filled('weight')) {
            $clinicalMeasurements['weight'] = $request->weight;
        }
        if ($request->filled('bmi')) {
            $clinicalMeasurements['bmi'] = $request->bmi;
        }

        // Determine status based on request
        $status = $request->get('status', 'in_progress');

        $consultation = Consultation::create([
            'appointment_id' => $request->appointment_id,
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'consultation_date' => $request->consultation_date,
            'consultation_time' => now(),
            'chief_complaint' => $request->chief_complaint,
            'present_illness' => $request->present_illness,
            'past_medical_history' => $request->past_medical_history,
            'medications' => $request->medications,
            'allergies' => $request->allergies,
            'clinical_measurements' => ! empty($clinicalMeasurements) ? json_encode($clinicalMeasurements) : null,
            'status' => $status,
            'created_by' => auth()->id(),
        ]);

        // Handle AJAX requests for draft saving
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $status === 'draft' ? 'Draft saved successfully!' : 'Consultation created successfully!',
                'consultation_id' => $consultation->id,
            ]);
        }

        $message = $status === 'draft'
            ? 'Consultation draft saved successfully. You can continue editing it later.'
            : 'Consultation created successfully. You can now add diagnosis and treatment plan.';

        return redirect()->route('staff.consultations.show', $consultation)->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultation $consultation)
    {
        $consultation->load(['patient.user', 'doctor.user']);

        return view('staff.consultations.show', compact('consultation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consultation $consultation)
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->where('status', 'active')->get();

        return view('staff.consultations.edit', compact('consultation', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consultation $consultation)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'consultation_date' => 'required|date',
            'consultation_time' => 'required',
            'chief_complaint' => 'required|string',
            'vital_signs' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $consultation->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'consultation_date' => $request->consultation_date,
            'consultation_time' => $request->consultation_time,
            'chief_complaint' => $request->chief_complaint,
            'vital_signs' => $request->vital_signs,
            'diagnosis' => $request->diagnosis,
            'treatment_plan' => $request->treatment_plan,
            'prescription' => $request->prescription,
            'notes' => $request->notes,
        ]);

        return redirect()->route('staff.consultations.index')->with('success', 'Consultation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return redirect()->route('staff.consultations.index')->with('success', 'Consultation deleted successfully.');
    }

    /**
     * Show physical examination form
     */
    public function physicalExam(Consultation $consultation)
    {
        return view('admin.consultations.physical-exam', compact('consultation'));
    }

    /**
     * Store physical examination
     */
    public function storePhysicalExam(Request $request, Consultation $consultation)
    {
        $request->validate([
            'blood_pressure' => 'required|string',
            'heart_rate' => 'required|string',
            'temperature' => 'required|string',
            'respiratory_rate' => 'required|string',
            'height' => 'nullable|string',
            'weight' => 'nullable|string',
            'bmi' => 'nullable|string',
            'general_appearance' => 'nullable|string',
            'head_neck' => 'nullable|string',
            'chest_lungs' => 'nullable|string',
            'cardiovascular' => 'nullable|string',
            'abdomen' => 'nullable|string',
            'extremities' => 'nullable|string',
            'neurological' => 'nullable|string',
        ]);

        $consultation->update([
            'vital_signs' => json_encode([
                'blood_pressure' => $request->blood_pressure,
                'heart_rate' => $request->heart_rate,
                'temperature' => $request->temperature,
                'respiratory_rate' => $request->respiratory_rate,
                'height' => $request->height,
                'weight' => $request->weight,
                'bmi' => $request->bmi,
            ]),
            'physical_examination' => json_encode([
                'general_appearance' => $request->general_appearance,
                'head_neck' => $request->head_neck,
                'chest_lungs' => $request->chest_lungs,
                'cardiovascular' => $request->cardiovascular,
                'abdomen' => $request->abdomen,
                'extremities' => $request->extremities,
                'neurological' => $request->neurological,
            ]),
        ]);

        return redirect()->route('staff.consultations.show', $consultation)->with('success', 'Physical examination saved successfully.');
    }

    /**
     * Show diagnosis form
     */
    public function diagnosis(Consultation $consultation)
    {
        return view('admin.consultations.diagnosis', compact('consultation'));
    }

    /**
     * Store diagnosis
     */
    public function storeDiagnosis(Request $request, Consultation $consultation)
    {
        $request->validate([
            'diagnosis' => 'required|string',
            'treatment_plan' => 'required|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $consultation->update([
            'diagnosis' => $request->diagnosis,
            'treatment_plan' => $request->treatment_plan,
            'prescription' => $request->prescription,
            'notes' => $request->notes,
        ]);

        return redirect()->route('staff.consultations.show', $consultation)->with('success', 'Diagnosis saved successfully.');
    }

    /**
     * Complete consultation
     */
    public function complete(Consultation $consultation)
    {
        $consultation->update(['status' => 'completed']);

        return redirect()->route('staff.consultations.index')->with('success', 'Consultation marked as completed.');
    }

    /**
     * Fetch patient data for AJAX request
     */
    public function fetchPatientData(Request $request)
    {
        $patient = Patient::with('user')->find($request->patient_id);

        if ($patient) {
            return response()->json([
                'success' => true,
                'patient' => $patient
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Patient not found'
            ]);
        }
    }
}
