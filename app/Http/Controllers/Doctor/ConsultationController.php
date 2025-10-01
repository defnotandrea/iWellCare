<?php

namespace App\Http\Controllers\Doctor;

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
        $user = auth()->user();

        // Admin users or users accessing admin routes can see all consultations
        if ($user->role === 'admin' || $user->username === 'admin_doctor' || str_starts_with(request()->route()->getName(), 'admin.')) {
            $consultations = Consultation::with(['patient.user', 'appointment', 'doctor'])
                ->orderBy('consultation_date', 'desc')
                ->paginate(10);
        } else {
            $doctor = $user->doctor;

            if (! $doctor) {
                return redirect()->route('admin.dashboard')->with('error', 'Doctor profile not found. Please contact administrator.');
            }

            $consultations = Consultation::where('doctor_id', $doctor->user_id)
                ->with(['patient.user', 'appointment'])
                ->orderBy('consultation_date', 'desc')
                ->paginate(10);
        }

        return view('admin.consultations.index', compact('consultations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = auth()->user();

        // Admin users can see all patients and doctors
        if ($user->role === 'admin' || $user->username === 'admin_doctor' || str_starts_with(request()->route()->getName(), 'admin.')) {
            $patients = Patient::with('user')->get();
            $doctors = Doctor::with('user')->get();

            // Set default doctor to "Dr. Augustus Caesar Butch B. Bigornia"
            $defaultDoctor = Doctor::whereHas('user', function ($query) {
                $query->where('first_name', 'Augustus Caesar Butch B.')
                      ->where('last_name', 'Bigornia');
            })->first();

            $selectedDoctorId = $defaultDoctor ? $defaultDoctor->id : null;
        } else {
            $doctor = $user->doctor;

            if (! $doctor) {
                return redirect()->route('admin.dashboard')->with('error', 'Doctor profile not found. Please contact administrator.');
            }

            // Get patients who have appointments with this doctor
            $patients = Patient::whereHas('appointments', function ($query) use ($doctor) {
                $query->where('doctor_id', $doctor->user_id);
            })->with('user')->get();

            // For doctors, only show themselves as the doctor option
            $doctors = Doctor::where('id', $doctor->id)->with('user')->get();
            $selectedDoctorId = $doctor->id;
        }

        // Get the selected patient ID from the request
        $selectedPatientId = $request->get('patient_id');

        return view('admin.consultations.create', compact('patients', 'doctors', 'selectedPatientId', 'selectedDoctorId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'consultation_date' => 'required|date',
            'chief_complaint' => 'required|string',
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
        ]);

        // For non-admin users, verify they can only create consultations for themselves
        if (! ($user->role === 'admin' || $user->username === 'admin_doctor' || str_starts_with(request()->route()->getName(), 'admin.'))) {
            $doctor = $user->doctor;

            if (! $doctor) {
                return redirect()->route('admin.dashboard')->with('error', 'Doctor profile not found. Please contact administrator.');
            }

            // Ensure the selected doctor is the current user
            if ($request->doctor_id != $doctor->id) {
                return back()->withErrors(['doctor_id' => 'You can only create consultations for yourself.']);
            }

            // Verify the patient has an appointment with this doctor
            $hasAppointment = \App\Models\Appointment::where('patient_id', $request->patient_id)
                ->where('doctor_id', $doctor->user_id)
                ->exists();

            if (! $hasAppointment) {
                return back()->withErrors(['patient_id' => 'You can only create consultations for patients who have appointments with you.']);
            }

            $doctorId = $doctor->user_id;
        } else {
            // For admin, get the doctor_id from the selected doctor
            $selectedDoctor = Doctor::find($request->doctor_id);
            if (! $selectedDoctor) {
                return back()->withErrors(['doctor_id' => 'Selected doctor not found.']);
            }
            $doctorId = $selectedDoctor->user_id;
        }

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
            'patient_id' => $request->patient_id,
            'doctor_id' => $doctorId,
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

        return redirect()->route('doctor.consultations.show', $consultation)->with('success', 'Consultation created successfully. You can now add diagnosis and treatment plan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultation $consultation)
    {
        $user = auth()->user();
        $doctor = $user->doctor;

        if (! $doctor) {
            return redirect()->route('admin.dashboard')->with('error', 'Doctor profile not found. Please contact administrator.');
        }

        // Ensure the consultation belongs to the authenticated doctor
        if ($consultation->doctor_id !== $doctor->user_id) {
            abort(403, 'Unauthorized access.');
        }

        $consultation->load(['patient.user', 'appointment']);

        return view('admin.consultations.show', compact('consultation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consultation $consultation)
    {
        $user = auth()->user();
        $doctor = $user->doctor;

        if (! $doctor) {
            return redirect()->route('admin.dashboard')->with('error', 'Doctor profile not found. Please contact administrator.');
        }

        // Ensure the consultation belongs to the authenticated doctor
        if ($consultation->doctor_id !== $doctor->user_id) {
            abort(403, 'Unauthorized access.');
        }

        $patients = Patient::whereHas('appointments', function ($query) use ($doctor) {
            $query->where('doctor_id', $doctor->user_id);
        })->with('user')->get();

        // For doctors, only show themselves as the doctor option
        $doctors = Doctor::where('id', $doctor->id)->with('user')->get();

        return view('admin.consultations.edit', compact('consultation', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consultation $consultation)
    {
        $user = auth()->user();
        $doctor = $user->doctor;

        if (! $doctor) {
            return redirect()->route('admin.dashboard')->with('error', 'Doctor profile not found. Please contact administrator.');
        }

        // Ensure the consultation belongs to the authenticated doctor
        if ($consultation->doctor_id !== $doctor->user_id) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
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
            'doctor_id' => $doctor->user_id,
            'consultation_date' => $request->consultation_date,
            'consultation_time' => $request->consultation_time,
            'chief_complaint' => $request->chief_complaint,
            'vital_signs' => $request->vital_signs,
            'diagnosis' => $request->diagnosis,
            'treatment_plan' => $request->treatment_plan,
            'prescription' => $request->prescription,
            'notes' => $request->notes,
        ]);

        return redirect()->route('doctor.consultations.index')->with('success', 'Consultation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultation $consultation)
    {
        $user = auth()->user();
        $doctor = $user->doctor;

        if (! $doctor) {
            return redirect()->route('admin.dashboard')->with('error', 'Doctor profile not found. Please contact administrator.');
        }

        // Ensure the consultation belongs to the authenticated doctor
        if ($consultation->doctor_id !== $doctor->user_id) {
            abort(403, 'Unauthorized access.');
        }

        $consultation->delete();

        return redirect()->route('doctor.consultations.index')->with('success', 'Consultation deleted successfully.');
    }

    /**
     * Show physical examination form
     */
    public function physicalExam(Consultation $consultation)
    {
        $user = auth()->user();
        $doctor = $user->doctor;

        if (! $doctor) {
            return redirect()->route('admin.dashboard')->with('error', 'Doctor profile not found. Please contact administrator.');
        }

        // Ensure the consultation belongs to the authenticated doctor
        if ($consultation->doctor_id !== $doctor->user_id) {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.consultations.physical-exam', compact('consultation'));
    }

    /**
     * Store physical examination
     */
    public function storePhysicalExam(Request $request, Consultation $consultation)
    {
        $user = auth()->user();
        $doctor = $user->doctor;

        if (! $doctor) {
            return redirect()->route('admin.dashboard')->with('error', 'Doctor profile not found. Please contact administrator.');
        }

        // Ensure the consultation belongs to the authenticated doctor
        if ($consultation->doctor_id !== $doctor->user_id) {
            abort(403, 'Unauthorized access.');
        }

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

        return redirect()->route('doctor.consultations.show', $consultation)->with('success', 'Physical examination saved successfully.');
    }

    /**
     * Show diagnosis form
     */
    public function diagnosis(Consultation $consultation)
    {
        $user = auth()->user();
        $doctor = $user->doctor;

        if (! $doctor) {
            return redirect()->route('admin.dashboard')->with('error', 'Doctor profile not found. Please contact administrator.');
        }

        // Ensure the consultation belongs to the authenticated doctor
        if ($consultation->doctor_id !== $doctor->user_id) {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.consultations.diagnosis', compact('consultation'));
    }

    /**
     * Store diagnosis
     */
    public function storeDiagnosis(Request $request, Consultation $consultation)
    {
        $user = auth()->user();
        $doctor = $user->doctor;

        if (! $doctor) {
            return redirect()->route('admin.dashboard')->with('error', 'Doctor profile not found. Please contact administrator.');
        }

        // Ensure the consultation belongs to the authenticated doctor
        if ($consultation->doctor_id !== $doctor->user_id) {
            abort(403, 'Unauthorized access.');
        }

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

        return redirect()->route('doctor.consultations.show', $consultation)->with('success', 'Diagnosis saved successfully.');
    }

    /**
     * Complete consultation
     */
    public function complete(Consultation $consultation)
    {
        $user = auth()->user();
        $doctor = $user->doctor;

        if (! $doctor) {
            return redirect()->route('admin.dashboard')->with('error', 'Doctor profile not found. Please contact administrator.');
        }

        // Ensure the consultation belongs to the authenticated doctor
        if ($consultation->doctor_id !== $doctor->user_id) {
            abort(403, 'Unauthorized access.');
        }

        $consultation->update(['status' => 'completed']);

        return redirect()->route('doctor.consultations.index')->with('success', 'Consultation marked as completed.');
    }

    /**
     * Fetch patient data for AJAX request
     */
    public function fetchPatientData(Request $request)
    {
        $user = auth()->user();
        $doctor = $user->doctor;

        if (! $doctor) {
            return response()->json(['error' => 'Doctor profile not found'], 403);
        }

        $patient = Patient::whereHas('appointments', function ($query) use ($doctor) {
            $query->where('doctor_id', $doctor->user_id);
        })->with('user')->find($request->patient_id);

        return response()->json($patient);
    }
}
