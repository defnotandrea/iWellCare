<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of patients.
     */
    public function index()
    {
        $patients = Patient::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('doctor.patients.index', compact('patients'));
    }

    /**
     * Display the specified patient.
     */
    public function show(Patient $patient)
    {
        $patient->load(['user', 'appointments.doctor', 'consultations.doctor']);

        return view('doctor.patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified patient.
     */
    public function edit(Patient $patient)
    {
        return view('doctor.patients.edit', compact('patient'));
    }

    /**
     * Update the specified patient in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string|max:500',
        ]);

        // Update patient information directly
        $patient->update([
            'full_name' => $request->full_name,
            'first_name' => $request->first_name ?: explode(' ', $request->full_name)[0] ?? '',
            'last_name' => $request->last_name ?: (explode(' ', $request->full_name)[1] ?? ''),
            'email' => $request->email,
            'contact' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
        ]);

        // If patient has a user relationship, update it too
        if ($patient->user) {
            $patient->user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
        }

        return redirect()->route('doctor.patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified patient from storage.
     */
    public function destroy(Patient $patient)
    {
        try {
            // Start transaction
            \DB::beginTransaction();

            // Delete related records first - handle each safely
            try {
                $patient->prescriptions()->delete();
            } catch (\Exception $e) {
                \Log::warning('Failed to delete prescriptions for patient '.$patient->id.': '.$e->getMessage());
            }

            try {
                $patient->medicalRecords()->delete();
            } catch (\Exception $e) {
                \Log::warning('Failed to delete medical records for patient '.$patient->id.': '.$e->getMessage());
            }

            try {
                $patient->consultations()->delete();
            } catch (\Exception $e) {
                \Log::warning('Failed to delete consultations for patient '.$patient->id.': '.$e->getMessage());
            }

            try {
                $patient->appointments()->delete();
            } catch (\Exception $e) {
                \Log::warning('Failed to delete appointments for patient '.$patient->id.': '.$e->getMessage());
            }

            // Try to delete billing records if the relationship exists
            try {
                if (method_exists($patient, 'billingRecords')) {
                    $patient->billingRecords()->delete();
                }
            } catch (\Exception $e) {
                \Log::warning('Failed to delete billing records for patient '.$patient->id.': '.$e->getMessage());
            }

            // Also try to delete from billing table directly if it exists
            try {
                if (\Schema::hasTable('billing')) {
                    \DB::table('billing')->where('patient_id', $patient->id)->delete();
                }
            } catch (\Exception $e) {
                \Log::warning('Failed to delete billing records directly for patient '.$patient->id.': '.$e->getMessage());
            }

            // Delete patient record
            $patient->delete();

            // Delete user account
            if ($patient->user) {
                $patient->user->delete();
            }

            // Commit transaction
            \DB::commit();

            // Log the deletion
            \Log::info('Patient deleted', [
                'patient_id' => $patient->id,
                'patient_name' => $patient->full_name,
                'deleted_by' => auth()->user()->full_name,
                'deleted_at' => now(),
            ]);

            // Return JSON for AJAX, redirect for browser
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Patient deleted successfully',
                ]);
            }

            return redirect()->route('doctor.patients.index')->with('success', 'Patient deleted successfully.');

        } catch (\Exception $e) {
            // Rollback transaction on error
            \DB::rollback();

            \Log::error('Error deleting patient', [
                'patient_id' => $patient->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting patient: '.$e->getMessage(),
                ], 500);
            }

            return redirect()->route('doctor.patients.index')->with('error', 'Error deleting patient: '.$e->getMessage());
        }
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

        return view('doctor.patients.history', compact('patient'));
    }
}
