<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of prescriptions.
     */
    public function index(Request $request)
    {
        $query = Prescription::with(['patient.user', 'doctor']);

        // Search by patient name or diagnosis
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient.user', function ($userQuery) use ($search) {
                    $userQuery->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                })
                    ->orWhere('diagnosis', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('prescription_date', $request->date);
        }

        $prescriptions = $query->orderBy('created_at', 'desc')->paginate(15);

        $patients = \App\Models\Patient::with('user')->where('is_active', true)->get();
        $doctors = \App\Models\User::where('role', 'doctor')->where('is_active', true)->get();

        return view('doctor.prescriptions.index', compact('prescriptions', 'patients', 'doctors'));
    }

    /**
     * Show the form for creating a new prescription.
     */
    public function create()
    {
        $patients = Patient::with('user')->where('is_active', true)->get();
        $doctors = User::where('role', 'doctor')->where('is_active', true)->get();

        return view('doctor.prescriptions.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created prescription in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'prescription_date' => 'required|date',
            'diagnosis' => 'required|string|max:500',
            'instructions' => 'nullable|string|max:1000',
            'medications' => 'required|array|min:1',
            'medications.*.medication_name' => 'required|string|max:255',
            'medications.*.dosage' => 'required|string|max:100',
            'medications.*.frequency' => 'required|string|max:100',
            'medications.*.duration' => 'required|string|max:100',
            'medications.*.quantity' => 'required|string|max:100',
            'medications.*.instructions' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $prescription = Prescription::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'prescription_date' => $request->prescription_date,
                'diagnosis' => $request->diagnosis,
                'instructions' => $request->instructions,
                'status' => $request->status ?? 'active',
            ]);

            // Add medications
            foreach ($request->medications as $medicationData) {
                $prescription->medications()->create($medicationData);
            }

            DB::commit();

            return redirect()->route('doctor.prescriptions.index')
                ->with('success', 'Prescription created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->withErrors(['error' => 'Error creating prescription: '.$e->getMessage()]);
        }
    }

    /**
     * Display the specified prescription.
     */
    public function show(Prescription $prescription)
    {
        $prescription->load(['patient.user', 'doctor', 'medications']);

        return view('doctor.prescriptions.show', compact('prescription'));
    }

    /**
     * Show the form for editing the specified prescription.
     */
    public function edit(Prescription $prescription)
    {
        $patients = Patient::with('user')->where('is_active', true)->get();
        $doctors = User::where('role', 'doctor')->where('is_active', true)->get();

        return view('doctor.prescriptions.edit', compact('prescription', 'patients', 'doctors'));
    }

    /**
     * Update the specified prescription in storage.
     */
    public function update(Request $request, Prescription $prescription)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'prescription_date' => 'required|date',
            'diagnosis' => 'required|string|max:500',
            'instructions' => 'nullable|string|max:1000',
            'status' => 'required|in:active,completed,cancelled',
        ]);

        $prescription->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'prescription_date' => $request->prescription_date,
            'diagnosis' => $request->diagnosis,
            'instructions' => $request->instructions,
            'status' => $request->status,
        ]);

        return redirect()->route('doctor.prescriptions.index')
            ->with('success', 'Prescription updated successfully.');
    }

    /**
     * Remove the specified prescription from storage.
     */
    public function destroy(Request $request, Prescription $prescription)
    {
        try {
            $prescription->delete();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Prescription deleted successfully.',
                ]);
            }

            return redirect()->route('doctor.prescriptions.index')
                ->with('success', 'Prescription deleted successfully.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting prescription: '.$e->getMessage(),
                ], 500);
            }

            return redirect()->route('doctor.prescriptions.index')
                ->with('error', 'Error deleting prescription: '.$e->getMessage());
        }
    }

    /**
     * Complete a prescription.
     */
    public function complete(Request $request, Prescription $prescription)
    {
        try {
            $prescription->update(['status' => 'completed']);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Prescription marked as completed.',
                ]);
            }

            return redirect()->route('doctor.prescriptions.index')
                ->with('success', 'Prescription marked as completed.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error completing prescription: '.$e->getMessage(),
                ], 500);
            }

            return redirect()->route('doctor.prescriptions.index')
                ->with('error', 'Error completing prescription: '.$e->getMessage());
        }
    }

    /**
     * Cancel a prescription.
     */
    public function cancel(Request $request, Prescription $prescription)
    {
        try {
            $prescription->update(['status' => 'cancelled']);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Prescription cancelled.',
                ]);
            }

            return redirect()->route('doctor.prescriptions.index')
                ->with('success', 'Prescription cancelled.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error cancelling prescription: '.$e->getMessage(),
                ], 500);
            }

            return redirect()->route('doctor.prescriptions.index')
                ->with('error', 'Error cancelling prescription: '.$e->getMessage());
        }
    }
}
