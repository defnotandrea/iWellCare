<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorAvailabilitySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    /**
     * Display the availability management page.
     */
    public function index()
    {
        $doctors = Doctor::with('user')->get();
        $availabilitySettings = DoctorAvailabilitySetting::with(['doctor', 'setBy'])->latest()->get();

        return view('staff.doctor-availability.index', compact('doctors', 'availabilitySettings'));
    }

    /**
     * Toggle doctor availability.
     */
    public function toggleAvailability(Request $request, $doctorId)
    {
        $doctor = Doctor::findOrFail($doctorId);
        $currentSetting = DoctorAvailabilitySetting::where('doctor_id', $doctor->user_id)->latest()->first();

        $isAvailable = ! ($currentSetting && $currentSetting->is_available);

        DoctorAvailabilitySetting::create([
            'doctor_id' => $doctor->user_id,
            'is_available' => $isAvailable,
            'unavailable_message' => $isAvailable ? null : 'Doctor is temporarily unavailable',
            'status' => $isAvailable ? 'available' : 'unavailable',
            'set_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => $isAvailable ? 'Doctor is now available' : 'Doctor is now unavailable',
            'is_available' => $isAvailable,
        ]);
    }

    /**
     * Set doctor as unavailable.
     */
    public function setUnavailable(Request $request, $doctorId)
    {
        $request->validate([
            'status' => 'required|in:unavailable,on_leave,emergency',
            'message' => 'nullable|string|max:500',
            'until' => 'nullable|date|after:now',
        ]);

        $doctor = Doctor::findOrFail($doctorId);

        DoctorAvailabilitySetting::create([
            'doctor_id' => $doctor->user_id,
            'is_available' => false,
            'unavailable_message' => $request->message ?? 'Doctor is temporarily unavailable',
            'unavailable_until' => $request->until,
            'status' => $request->status,
            'notes' => $request->notes ?? null,
            'set_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor availability updated successfully',
        ]);
    }

    /**
     * Set doctor as available.
     */
    public function setAvailable(Request $request, $doctorId)
    {
        $doctor = Doctor::findOrFail($doctorId);

        DoctorAvailabilitySetting::create([
            'doctor_id' => $doctor->user_id,
            'is_available' => true,
            'unavailable_message' => null,
            'unavailable_until' => null,
            'status' => 'available',
            'notes' => 'Doctor is now available',
            'set_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor is now available',
        ]);
    }

    /**
     * Get current availability status.
     */
    public function getAvailabilityStatus()
    {
        $doctors = Doctor::with(['user', 'availabilitySettings' => function ($query) {
            $query->latest();
        }])->get();

        $status = [];
        foreach ($doctors as $doctor) {
            $latestSetting = $doctor->availabilitySettings->first();
            $status[$doctor->id] = $latestSetting ? $latestSetting->getCurrentStatus() : [
                'is_available' => true,
                'message' => 'Doctor is available',
                'status' => 'available',
            ];
        }

        return response()->json($status);
    }

    /**
     * Show the form for creating a new availability setting.
     */
    public function create()
    {
        $doctors = Doctor::with('user')->get();

        return view('staff.doctor-availability.create', compact('doctors'));
    }

    /**
     * Store a newly created availability setting.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'is_available' => 'required|boolean',
            'status' => 'required|in:available,unavailable,on_leave,emergency',
            'unavailable_message' => 'nullable|string|max:500',
            'unavailable_until' => 'nullable|date|after:now',
            'notes' => 'nullable|string',
        ]);

        $doctor = Doctor::findOrFail($request->doctor_id);

        DoctorAvailabilitySetting::create([
            'doctor_id' => $doctor->user_id,
            'is_available' => $request->is_available,
            'unavailable_message' => $request->unavailable_message,
            'unavailable_until' => $request->unavailable_until,
            'status' => $request->status,
            'notes' => $request->notes,
            'set_by' => Auth::id(),
        ]);

        return redirect()->route('staff.doctor-availability.index')
            ->with('success', 'Doctor availability setting created successfully.');
    }

    /**
     * Display the specified availability setting.
     */
    public function show($id)
    {
        $availabilitySetting = DoctorAvailabilitySetting::with(['doctor', 'setBy'])->findOrFail($id);

        return view('staff.doctor-availability.show', compact('availabilitySetting'));
    }

    /**
     * Show the form for editing the specified availability setting.
     */
    public function edit($id)
    {
        $availabilitySetting = DoctorAvailabilitySetting::with(['doctor'])->findOrFail($id);
        $doctors = Doctor::with('user')->get();

        return view('staff.doctor-availability.edit', compact('availabilitySetting', 'doctors'));
    }

    /**
     * Update the specified availability setting.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'is_available' => 'required|boolean',
            'status' => 'required|in:available,unavailable,on_leave,emergency',
            'unavailable_message' => 'nullable|string|max:500',
            'unavailable_until' => 'nullable|date|after:now',
            'notes' => 'nullable|string',
        ]);

        $availabilitySetting = DoctorAvailabilitySetting::findOrFail($id);
        $doctor = Doctor::findOrFail($request->doctor_id);

        $availabilitySetting->update([
            'doctor_id' => $doctor->user_id,
            'is_available' => $request->is_available,
            'unavailable_message' => $request->unavailable_message,
            'unavailable_until' => $request->unavailable_until,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('staff.doctor-availability.index')
            ->with('success', 'Doctor availability setting updated successfully.');
    }

    /**
     * Remove the specified availability setting.
     */
    public function destroy($id)
    {
        $availabilitySetting = DoctorAvailabilitySetting::findOrFail($id);
        $availabilitySetting->delete();

        return redirect()->route('staff.doctor-availability.index')
            ->with('success', 'Doctor availability setting deleted successfully.');
    }
}
