<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Get calendar data for appointments.
     */
    public function calendar(Request $request)
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereBetween('appointment_date', [
                $request->get('start', now()->startOfMonth()),
                $request->get('end', now()->endOfMonth()),
            ])
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'title' => $appointment->patient->first_name.' '.$appointment->patient->last_name,
                    'start' => $appointment->appointment_date.' '.$appointment->appointment_time,
                    'status' => $appointment->status,
                    'doctor' => $appointment->doctor->first_name.' '.$appointment->doctor->last_name,
                ];
            });

        return response()->json($appointments);
    }
}
