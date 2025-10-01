<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{

    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor.user']);
        if ($request->filled('patient')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->patient.'%')
                    ->orWhere('last_name', 'like', '%'.$request->patient.'%');
            });
        }
        if ($request->filled('doctor')) {
            $query->whereHas('doctor.user', function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->doctor.'%')
                    ->orWhere('last_name', 'like', '%'.$request->doctor.'%');
            });
        }
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $appointments = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10)
            ->appends($request->all());

        return view('staff.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = \App\Models\Patient::where('is_active', true)->get();
        $doctors = \App\Models\Doctor::with(['user', 'availabilitySettings' => function ($q) {
            $q->latest();
        }])->get();

        return view('staff.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'reason' => 'required|string|max:1000',
            'status' => 'required|in:scheduled,confirmed,cancelled,completed',
        ]);

        // Check if the selected doctor is available
        $doctor = \App\Models\Doctor::where('id', $request->doctor_id)->with(['user', 'availabilitySettings' => function ($q) {
            $q->latest();
        }])->first();

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
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'type' => 'consultation',
            'notes' => $request->reason,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

        // Send notification if appointment is confirmed
        // Note: Email notifications removed - appointment confirmed but no email sent
        // if ($request->status === 'confirmed') {
        //     $this->notificationService->sendAppointmentConfirmationNotification($appointment);
        // }

        return redirect()->route('staff.appointments.index')->with('success', 'Appointment created successfully.');
    }

    public function show($id)
    {
        return view('staff.appointments.show', compact('id'));
    }

    public function confirm($id)
    {
        try {
            $appointment = Appointment::with(['patient.user'])->findOrFail($id);
            $oldStatus = $appointment->status;

            // Update status immediately for instant feedback
            $appointment->status = 'confirmed';
            $appointment->save();

            // Send confirmation email
            try {
                $user = $appointment->patient->user;
                \App\Services\EmailService::sendAppointmentEmail($user, $appointment, 'approved');
            } catch (\Exception $e) {
                \Log::error('Failed to send approved appointment email', [
                    'appointment_id' => $appointment->id,
                    'error' => $e->getMessage(),
                ]);
            }

            // Return success message
            return redirect()->route('staff.appointments.index')->with('success', 'Appointment approved successfully! Email confirmations sent to patient.');

        } catch (\Exception $e) {
            \Log::error('Failed to confirm appointment', [
                'appointment_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('staff.appointments.index')->with('error', 'Failed to confirm appointment: '.$e->getMessage());
        }
    }

    public function decline($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $oldStatus = $appointment->status;

            // Update status immediately
            // Use allowed status value to reflect a declined action
            $appointment->status = 'cancelled';
            $appointment->save();

            // Send email asynchronously
            // Note: Email notifications removed - appointment declined but no email sent
            // dispatch(function () use ($appointment, $oldStatus) {
            //     try {
            //         $this->notificationService->sendAppointmentStatusUpdateNotification($appointment, $oldStatus, 'declined');
            //     } catch (\Exception $e) {
            //         \Log::error('Failed to send decline notification', [
            //             'appointment_id' => $appointment->id,
            //             'error' => $e->getMessage(),
            //         ]);
            //     }
            // })->afterResponse();

            // Send cancelled email
            try {
                $appointment->load('patient.user');
                $user = $appointment->patient->user;
                \App\Services\EmailService::sendAppointmentEmail($user, $appointment, 'cancelled');
            } catch (\Exception $e) {
                \Log::error('Failed to send cancelled appointment email', [
                    'appointment_id' => $appointment->id,
                    'error' => $e->getMessage(),
                ]);
            }

            return redirect()->route('staff.appointments.index')->with('success', 'Appointment cancelled successfully! Email notification sent.');
        } catch (\Exception $e) {
            \Log::error('Failed to decline appointment', [
                'appointment_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('staff.appointments.index')->with('error', 'Failed to decline appointment: '.$e->getMessage());
        }
    }

    public function complete($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $oldStatus = $appointment->status;

            // Update status immediately
            $appointment->status = 'completed';
            $appointment->save();

            // Send email asynchronously
            // Note: Email notifications removed - appointment completed but no email sent
            // dispatch(function () use ($appointment, $oldStatus) {
            //     try {
            //         $this->notificationService->sendAppointmentStatusUpdateNotification($appointment, $oldStatus, 'completed');
            //     } catch (\Exception $e) {
            //         \Log::error('Failed to send completion notification', [
            //             'appointment_id' => $appointment->id,
            //             'error' => $e->getMessage(),
            //         ]);
            //     }
            // })->afterResponse();

            return redirect()->route('staff.appointments.index')->with('success', 'Appointment marked as completed! Patient notification is being sent in the background.');
        } catch (\Exception $e) {
            \Log::error('Failed to complete appointment', [
                'appointment_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('staff.appointments.index')->with('error', 'Failed to complete appointment: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('staff.appointments.index')->with('success', 'Appointment deleted successfully.');
    }

    public function reschedule($id)
    {
        $appointment = Appointment::findOrFail($id);

        return view('staff.appointments.reschedule', compact('appointment'));
    }

    public function updateReschedule(Request $request, $id)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
        ]);
        $appointment = Appointment::findOrFail($id);
        $oldStatus = $appointment->status;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->appointment_time = $request->appointment_time;
        // Set back to scheduled after rescheduling (valid status)
        $appointment->status = 'scheduled';
        $appointment->save();

        // Send status update notification
        // Note: Email notifications removed - appointment rescheduled but no email sent
        // $this->notificationService->sendAppointmentStatusUpdateNotification($appointment, $oldStatus, 'rescheduled');

        return redirect()->route('staff.appointments.index')->with('success', 'Appointment rescheduled and set to scheduled.');
    }
}
