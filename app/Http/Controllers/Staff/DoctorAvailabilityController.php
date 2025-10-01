<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorAvailabilityController extends Controller
{
    /**
     * Display a listing of doctor availability.
     */
    public function index()
    {
        $doctors = Doctor::with('user')
            ->orderBy('user_id')
            ->get();

        $availabilitySettings = \App\Models\DoctorAvailabilitySetting::with(['doctor', 'setBy'])->latest()->get();

        return view('staff.doctor-availability.index', compact('doctors', 'availabilitySettings'));
    }

    /**
     * Show the form for creating a new availability record.
     */
    public function create()
    {
        $doctors = Doctor::with('user')
            ->orderBy('user_id')
            ->get();

        return view('staff.doctor-availability.create', compact('doctors'));
    }

    /**
     * Store a newly created availability record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'availability_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:available,unavailable,on_leave',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if availability already exists for this doctor and date
        $existingAvailability = DoctorAvailability::where('doctor_id', $request->doctor_id)
            ->where('availability_date', $request->availability_date)
            ->first();

        if ($existingAvailability) {
            return back()->withErrors(['availability_date' => 'Availability for this doctor and date already exists.'])->withInput();
        }

        // Create availability record
        DoctorAvailability::create([
            'doctor_id' => $request->doctor_id,
            'availability_date' => $request->availability_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('staff.doctor-availability.index')
            ->with('success', 'Doctor availability set successfully.');
    }

    /**
     * Show the form for editing the specified availability record.
     */
    public function edit($id)
    {
        $availability = DoctorAvailability::find($id);

        if (! $availability) {
            return redirect()->route('staff.doctor-availability.index')
                ->with('error', 'Availability record not found.');
        }

        $doctors = Doctor::with('user')
            ->orderBy('user_id')
            ->get();

        return view('staff.doctor-availability.edit', compact('availability', 'doctors'));
    }

    /**
     * Update the specified availability record.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'availability_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:available,unavailable,on_leave',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if availability already exists for this doctor and date (excluding current record)
        $existingAvailability = DoctorAvailability::where('doctor_id', $request->doctor_id)
            ->where('availability_date', $request->availability_date)
            ->where('id', '!=', $id)
            ->first();

        if ($existingAvailability) {
            return back()->withErrors(['availability_date' => 'Availability for this doctor and date already exists.'])->withInput();
        }

        // Update availability record
        DoctorAvailability::where('id', $id)->update([
            'doctor_id' => $request->doctor_id,
            'availability_date' => $request->availability_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('staff.doctor-availability.index')
            ->with('success', 'Doctor availability updated successfully.');
    }

    /**
     * Remove the specified availability record.
     */
    public function destroy($id)
    {
        $availability = DoctorAvailability::find($id);

        if (! $availability) {
            return redirect()->route('staff.doctor-availability.index')
                ->with('error', 'Availability record not found.');
        }

        $availability->delete();

        return redirect()->route('staff.doctor-availability.index')
            ->with('success', 'Doctor availability removed successfully.');
    }

    /**
     * Toggle doctor availability status.
     */
    public function toggleStatus($id)
    {
        $availability = DoctorAvailability::find($id);

        if (! $availability) {
            return redirect()->route('staff.doctor-availability.index')
                ->with('error', 'Availability record not found.');
        }

        $newStatus = $availability->status === 'available' ? 'unavailable' : 'available';

        $availability->update([
            'status' => $newStatus,
        ]);

        return redirect()->route('staff.doctor-availability.index')
            ->with('success', 'Doctor availability status updated successfully.');
    }

    /**
     * Get doctor availability for a specific date range.
     */
    public function getAvailability(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $availability = DoctorAvailability::where('doctor_id', $request->doctor_id)
            ->whereBetween('availability_date', [$request->start_date, $request->end_date])
            ->orderBy('availability_date')
            ->orderBy('start_time')
            ->get();

        return response()->json($availability);
    }

    /**
     * Bulk update doctor availability.
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'dates' => 'required|array',
            'dates.*' => 'date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:available,unavailable,on_leave',
            'notes' => 'nullable|string|max:500',
        ]);

        $dates = $request->dates;
        $insertData = [];

        foreach ($dates as $date) {
            // Check if availability already exists
            $existing = DoctorAvailability::where('doctor_id', $request->doctor_id)
                ->where('availability_date', $date)
                ->first();

            if (! $existing) {
                $insertData[] = [
                    'doctor_id' => $request->doctor_id,
                    'availability_date' => $date,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'status' => $request->status,
                    'notes' => $request->notes,
                ];
            }
        }

        if (! empty($insertData)) {
            DoctorAvailability::insert($insertData);
        }

        return redirect()->route('staff.doctor-availability.index')
            ->with('success', 'Bulk availability update completed successfully.');
    }
}
