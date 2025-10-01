<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentBookingController extends Controller
{
    /**
     * Show the appointment booking form
     */
    public function showBookingForm()
    {
        // Check if user is authenticated
        if (! Auth::check()) {
            return redirect()->route('register')->with('message', 'Please register or login to book an appointment.');
        }

        // Check if user is a patient
        if (Auth::user()->role !== 'patient') {
            return redirect()->route('home')->with('error', 'Only patients can book appointments.');
        }

        // Get available doctors with their availability status
        $doctors = Doctor::where('status', 'active')->with(['user', 'availabilitySettings' => function ($q) {
            $q->latest();
        }])->get();

        // Attach latest availability status to each doctor
        foreach ($doctors as $doctor) {
            $latestSetting = $doctor->availabilitySettings->first();
            if ($latestSetting) {
                $doctor->current_availability = $latestSetting->getCurrentStatus();
            } else {
                $doctor->current_availability = [
                    'is_available' => true,
                    'message' => 'Available',
                    'status' => 'available',
                ];
            }
        }

        return view('appointments.booking', compact('doctors'));
    }

    /**
     * Store the appointment booking
     */
    public function bookAppointment(Request $request)
    {
        // Check if user is authenticated
        if (! Auth::check()) {
            return redirect()->route('register')->with('message', 'Please register or login to book an appointment.');
        }

        // Check if user is a patient
        if (Auth::user()->role !== 'patient') {
            return redirect()->route('home')->with('error', 'Only patients can book appointments.');
        }

        // Validate the request
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|date_format:H:i',
            'appointment_type' => 'required|string|max:255',
            'symptoms' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Check if the selected doctor is available
        $doctor = Doctor::with(['availabilitySettings' => function ($q) {
            $q->latest();
        }])->findOrFail($request->doctor_id);

        $latestSetting = $doctor->availabilitySettings->first();
        $isAvailable = true;
        $unavailableMessage = '';

        if ($latestSetting) {
            $availabilityStatus = $latestSetting->getCurrentStatus();
            $isAvailable = $availabilityStatus['is_available'];
            $unavailableMessage = $availabilityStatus['message'];
        }

        if (! $isAvailable) {
            return back()->withErrors(['doctor_id' => "This doctor is currently unavailable: {$unavailableMessage}"]);
        }

        // Check if the selected time slot is available
        $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($existingAppointment) {
            return back()->withErrors(['appointment_time' => 'This time slot is already booked. Please select another time.']);
        }

        // Create the appointment
        $appointment = Appointment::create([
            'patient_id' => Auth::user()->patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'appointment_type' => $request->appointment_type,
            'symptoms' => $request->symptoms,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('login')->with('success', 'Appointment booked successfully! Please login to view your appointment details.');
    }

    /**
     * Show available time slots for a doctor on a specific date
     */
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after:today',
        ]);

        $doctor = Doctor::findOrFail($request->doctor_id);
        $date = $request->date;

        // Get booked time slots for this doctor on this date
        $bookedSlots = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $date)
            ->where('status', '!=', 'cancelled')
            ->pluck('appointment_time')
            ->toArray();

        // Define available time slots (9 AM to 5 PM, 30-minute intervals)
        $allSlots = [];
        for ($hour = 9; $hour <= 17; $hour++) {
            for ($minute = 0; $minute < 60; $minute += 30) {
                if ($hour == 17 && $minute == 30) {
                    break;
                } // Don't include 5:30 PM
                $time = sprintf('%02d:%02d', $hour, $minute);
                $allSlots[] = $time;
            }
        }

        // Filter out booked slots
        $availableSlots = array_diff($allSlots, $bookedSlots);

        return response()->json([
            'available_slots' => array_values($availableSlots),
        ]);
    }
}
