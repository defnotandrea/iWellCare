<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::with('user')->paginate(10);

        // Get recent appointments count for display
        $recentAppointments = Appointment::where('created_at', '>=', now()->subDays(7))->count();

        return view('staff.patients.index', compact('patients', 'recentAppointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'contact' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:10',
            'allergies' => 'nullable|string|max:1000',
            'medical_history' => 'nullable|string|max:1000',
            'current_medications' => 'nullable|string|max:1000',
            'family_history' => 'nullable|string|max:1000',
            'emergency_contact' => 'nullable|string|max:20',
            'emergency_contact_name' => 'nullable|string|max:255',
        ]);

        // Create user account
        $user = User::create([
            'first_name' => $request->first_name ?: explode(' ', $request->full_name)[0] ?? '',
            'last_name' => $request->last_name ?: (explode(' ', $request->full_name)[1] ?? ''),
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'phone_number' => $request->contact,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'street_address' => $request->address,
            'city' => $request->city,
            'state_province' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'role' => 'patient',
            'is_active' => true,
        ]);

        // Create patient profile
        $patient = Patient::create([
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact' => $request->contact,
            'email' => $request->email,
            'address' => $request->address,
            'emergency_contact' => $request->emergency_contact,
            'emergency_contact_name' => $request->emergency_contact_name,
            'blood_type' => $request->blood_type,
            'allergies' => $request->allergies,
            'medical_history' => $request->medical_history,
            'current_medications' => $request->current_medications,
            'family_history' => $request->family_history,
        ]);

        return redirect()->route('staff.patients.index')->with('success', 'Patient created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $patient->load(['user', 'appointments', 'consultations']);

        return view('staff.patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $patient->load('user');

        return view('staff.patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $patient->load('user');

        $request->validate([
            'full_name' => 'required|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,{$patient->user->id}",
            'username' => "required|string|max:255|unique:users,username,{$patient->user->id}",
            'contact' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:10',
            'allergies' => 'nullable|string|max:1000',
            'medical_history' => 'nullable|string|max:1000',
            'current_medications' => 'nullable|string|max:1000',
            'family_history' => 'nullable|string|max:1000',
            'emergency_contact' => 'nullable|string|max:20',
            'emergency_contact_name' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Update user account
        $patient->user->update([
            'first_name' => $request->first_name ?: explode(' ', $request->full_name)[0] ?? '',
            'last_name' => $request->last_name ?: (explode(' ', $request->full_name)[1] ?? ''),
            'email' => $request->email,
            'username' => $request->username,
            'phone_number' => $request->contact,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'street_address' => $request->address,
            'city' => $request->city,
            'state_province' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'is_active' => $request->is_active,
        ]);

        // Update patient profile
        $patient->update([
            'full_name' => $request->full_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact' => $request->contact,
            'email' => $request->email,
            'address' => $request->address,
            'emergency_contact' => $request->emergency_contact,
            'emergency_contact_name' => $request->emergency_contact_name,
            'blood_type' => $request->blood_type,
            'allergies' => $request->allergies,
            'medical_history' => $request->medical_history,
            'current_medications' => $request->current_medications,
            'family_history' => $request->family_history,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('staff.patients.show', $patient)->with('success', 'Patient updated successfully.');
    }

    /**
     * Show patient history.
     */
    public function history(Patient $patient)
    {
        $patient->load([
            'appointments.doctor',
            'consultations.doctor',
            'prescriptions.doctor',
            'medicalRecords.doctor',
        ]);

        return view('staff.patients.history', compact('patient'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->user->delete();
        $patient->delete();

        return redirect()->route('staff.patients.index')->with('success', 'Patient deleted successfully.');
    }
}
