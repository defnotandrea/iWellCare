<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments.
     */
    public function index()
    {
        $appointments = Appointment::with('patient')
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->paginate(15);

        // Calculate statistics
        $stats = [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'today' => Appointment::whereDate('appointment_date', Carbon::today())->count(),
        ];

        return view('doctor.appointments.index', compact('appointments', 'stats'));
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load('patient');

        return view('doctor.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment.
     */
    public function edit(Appointment $appointment)
    {
        $patients = Patient::where('is_active', true)->get();

        return view('doctor.appointments.edit', compact('appointment', 'patients'));
    }

    /**
     * Update the specified appointment in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'reason' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $appointment->update([
            'patient_id' => $request->patient_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason' => $request->reason,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('doctor.appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified appointment from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('doctor.appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    /**
     * Confirm an appointment.
     */
    public function confirm(Appointment $appointment)
    {
        $appointment->update(['status' => 'confirmed']);

        return response()->json([
            'success' => true,
            'message' => 'Appointment confirmed successfully.',
        ]);
    }

    /**
     * Cancel an appointment.
     */
    public function cancel(Appointment $appointment)
    {
        $appointment->update([
            'status' => 'cancelled',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment cancelled successfully.',
        ]);
    }

    /**
     * Complete an appointment.
     */
    public function complete(Appointment $appointment)
    {
        $appointment->update(['status' => 'completed']);

        return response()->json([
            'success' => true,
            'message' => 'Appointment completed successfully.',
        ]);
    }

    /**
     * Get appointments for a specific date.
     */
    public function getAppointmentsByDate(Request $request)
    {
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));

        $appointments = Appointment::with('patient')
            ->whereDate('appointment_date', $date)
            ->orderBy('appointment_time')
            ->get();

        return response()->json([
            'success' => true,
            'appointments' => $appointments,
        ]);
    }

    /**
     * Get appointment statistics.
     */
    public function getStats()
    {
        $stats = [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'today' => Appointment::whereDate('appointment_date', Carbon::today())->count(),
            'this_week' => Appointment::whereBetween('appointment_date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek(),
            ])->count(),
            'this_month' => Appointment::whereMonth('appointment_date', Carbon::now()->month)->count(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats,
        ]);
    }

    /**
     * Handle appointment cancellation from patient side.
     */
    public function handlePatientCancellation(Request $request, Appointment $appointment)
    {
        // Verify the appointment belongs to the authenticated patient
        if ($appointment->patient->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }

        $appointment->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancelled_by' => auth()->id(),
            'cancellation_reason' => $request->input('reason', 'Cancelled by patient'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment cancelled successfully.',
        ]);
    }

    /**
     * Get cancelled appointments for doctor review.
     */
    public function getCancelledAppointments()
    {
        $cancelledAppointments = Appointment::with('patient')
            ->where('status', 'cancelled')
            ->where('cancelled_at', '>=', Carbon::now()->subDays(30))
            ->orderBy('cancelled_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'cancelled_appointments' => $cancelledAppointments,
        ]);
    }
}
