<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class DoctorController extends Controller
{
    /**
     * Get all doctors.
     */
    public function index()
    {
        $doctors = User::where('role', 'doctor')
            ->select('id', 'first_name', 'last_name', 'email', 'specialization')
            ->get();

        return response()->json($doctors);
    }

    /**
     * Get available doctors.
     */
    public function available()
    {
        $totalDoctors = User::where('role', 'doctor')->count();
        $availableDoctors = User::where('role', 'doctor')
            ->where('is_available', true)
            ->select('id', 'first_name', 'last_name', 'email', 'specialization')
            ->get();

        return response()->json([
            'total' => $totalDoctors,
            'available' => $availableDoctors->count(),
            'doctors' => $availableDoctors,
        ]);
    }

    /**
     * Get a specific doctor.
     */
    public function show($id)
    {
        $doctor = User::where('role', 'doctor')
            ->where('id', $id)
            ->select('id', 'first_name', 'last_name', 'email', 'specialization', 'phone')
            ->first();

        if (! $doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        return response()->json($doctor);
    }
}
