<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Ensure that a patient record exists for the user
     */
    private function ensurePatientRecord($user)
    {
        $patient = $user->patient;

        if (! $patient) {
            // Create patient record if it doesn't exist
            $patient = Patient::create([
                'user_id' => $user->id,
                'full_name' => trim(($user->first_name ?? '').' '.($user->last_name ?? '')),
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'contact' => $user->phone_number,
                'email' => $user->email,
                'address' => $user->street_address.', '.$user->city,
                'date_of_birth' => null,
                'gender' => null,
                'blood_type' => null,
                'emergency_contact' => null,
                'emergency_contact_phone' => null,
                'medical_history' => null,
                'allergies' => null,
                'current_medications' => null,
                'insurance_provider' => null,
                'insurance_number' => null,
                'is_active' => true,
            ]);
        }

        return $patient;
    }

    public function index()
    {
        $user = auth()->user();
        $patient = $this->ensurePatientRecord($user);

        return view('patient.profile.index', compact('user', 'patient'));
    }

    public function edit()
    {
        $user = auth()->user();
        $patient = $this->ensurePatientRecord($user);

        return view('patient.profile.edit', compact('user', 'patient'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $patient = $this->ensurePatientRecord($user);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone_number' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'blood_type' => 'nullable|string|max:10',
            'emergency_contact' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'insurance_provider' => 'nullable|string|max:255',
            'insurance_number' => 'nullable|string|max:255',
            // Password validation rules
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        // Verify current password if changing password
        if ($request->filled('new_password')) {
            if (! $request->filled('current_password')) {
                return back()->withErrors(['current_password' => 'Current password is required to change password.'])->withInput();
            }

            if (! Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }
        }

        // Update user information
        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'street_address' => $request->street_address,
            'city' => $request->city,
        ];

        // Update password if provided
        if ($request->filled('new_password')) {
            $userData['password'] = Hash::make($request->new_password);
        }

        $user->update($userData);

        // Refresh the authenticated user instance and update the session
        $user = $user->fresh();
        auth()->login($user);

        // Update patient information
        $patient->update([
            'full_name' => trim(($request->first_name ?? '').' '.($request->last_name ?? '')),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact' => $request->contact,
            'email' => $request->email,
            'address' => $request->street_address.', '.$request->city,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'blood_type' => $request->blood_type,
            'emergency_contact' => $request->emergency_contact,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'medical_history' => $request->medical_history,
            'allergies' => $request->allergies,
            'current_medications' => $request->current_medications,
            'insurance_provider' => $request->insurance_provider,
            'insurance_number' => $request->insurance_number,
        ]);

        $message = 'Profile updated successfully!';
        if ($request->filled('new_password')) {
            $message .= ' Password has been updated.';
        }

        return redirect()->route('patient.profile.index')
            ->with('success', $message);
    }

    public function destroy(Request $request)
    {
        $user = auth()->user();

        // Validate the request
        $request->validate([
            'password' => 'required|string',
        ]);

        // Verify password before deletion
        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password is incorrect.'])->withInput();
        }

        try {
            // Delete associated patient record
            if ($user->patient) {
                $user->patient->delete();
            }

            // Delete associated appointments
            $user->appointments()->delete();

            // Delete associated consultations
            $user->consultations()->delete();

            // Delete associated prescriptions
            $user->prescriptions()->delete();

            // Delete associated medical records
            $user->medicalRecords()->delete();

            // Delete associated invoices
            $user->invoices()->delete();

            // Finally, delete the user
            $user->delete();

            // Logout the user
            auth()->logout();

            return redirect()->route('home')
                ->with('success', 'Your account has been permanently deleted. Thank you for using our service.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while deleting your account. Please try again.'])->withInput();
        }
    }
}
