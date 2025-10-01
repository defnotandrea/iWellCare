<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $patient = $user->patient;

        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor.user', 'patient'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('patient.appointments.index', compact('appointments'));
    }

    public function create()
    {
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
        // Determine default doctor: prefer currently available doctor; fallback to first active
        $defaultDoctor = $this->getDefaultAvailableDoctor($doctors);

        return view('patient.appointments.create', compact('doctors', 'defaultDoctor'));
    }

    public function store(Request $request)
    {
        // If no doctor selected, choose a default available one before validation
        if (! $request->filled('doctor_id')) {
            $defaultDoctor = $this->getDefaultAvailableDoctor();
            if ($defaultDoctor) {
                $request->merge(['doctor_id' => $defaultDoctor->id]);
            }
        }

        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'type' => 'required|in:checkup,consultation,emergency,follow-up',
            'notes' => 'nullable|string|max:500',
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

        $user = auth()->user();
        $patient = $user->patient;

        // Check if the selected time slot is available
        $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($existingAppointment) {
            return back()->withErrors(['appointment_time' => 'This time slot is already booked. Please choose another time.']);
        }

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'type' => $request->type,
            'notes' => $request->notes,
            'status' => 'pending',
            'priority' => 'medium',
        ]);

        // Send booking notification
        // Note: Email notifications removed - appointment booked but no email sent
        // $this->notificationService->sendAppointmentBookingNotification($appointment);

        // Send admin notification
        // $this->notificationService->sendAdminAppointmentNotification($appointment);

        return redirect()->route('patient.appointments.index')
            ->with('success', 'Appointment booked successfully! We will notify you once it\'s confirmed.');
    }

    /**
     * Get a sensible default available doctor.
     * If a collection is provided, pick from it; otherwise query.
     */
    private function getDefaultAvailableDoctor($doctors = null)
    {
        if ($doctors === null) {
            $doctors = Doctor::where('status', 'active')->with(['user', 'availabilitySettings' => function ($q) {
                $q->latest();
            }])->get();
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
        }

        // Prefer currently available
        $available = $doctors->first(function ($d) {
            return ($d->current_availability['is_available'] ?? true) === true;
        });
        if ($available) {
            return $available;
        }
        // Fallback to first active doctor
        return $doctors->first();
    }

    public function show(Appointment $appointment)
    {
        $user = auth()->user();
        $patient = $user->patient;

        // Ensure the appointment belongs to the authenticated patient
        if ($appointment->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access.');
        }

        $appointment->load(['doctor.user', 'patient']);

        return view('patient.appointments.show', compact('appointment'));
    }

    public function cancel(Appointment $appointment)
    {
        $user = auth()->user();
        $patient = $user->patient;

        // Ensure the appointment belongs to the authenticated patient
        if ($appointment->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access.');
        }

        // Only allow cancellation of pending or confirmed appointments
        if (! in_array($appointment->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'This appointment cannot be cancelled.');
        }

        $oldStatus = $appointment->status;
        $appointment->update(['status' => 'cancelled']);

        // Send status update notification
        // Note: Email notifications removed - appointment cancelled but no email sent
        // $this->notificationService->sendAppointmentStatusUpdateNotification($appointment, $oldStatus, 'cancelled');

        return redirect()->route('patient.appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }
}
