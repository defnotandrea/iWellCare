<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        // Redirect authenticated users to their role dashboards to avoid showing public layout
        if (auth()->check()) {
            $user = auth()->user();
            $role = $user->role;
            if ($role === 'admin' || $role === 'doctor') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'staff') {
                return redirect()->route('staff.dashboard');
            } elseif ($role === 'patient') {
                // If patient relation is missing, send to profile edit to avoid redirect loops
                if (! $user->patient) {
                    return redirect()->route('patient.profile.edit')->with('error', 'No patient profile found for this account.');
                }
                return redirect()->route('patient.dashboard');
            }
        }

        // Get all doctors with their availability status
        $doctors = \App\Models\User::where('role', 'doctor')->with(['availabilitySettings' => function ($q) {
            $q->latest();
        }])->get();

        // Check overall clinic availability
        $availableDoctors = 0;
        $totalDoctors = $doctors->count();
        $unavailableMessages = [];

        foreach ($doctors as $doctor) {
            $latestSetting = $doctor->availabilitySettings->first();
            if ($latestSetting) {
                $availabilityStatus = $latestSetting->getCurrentStatus();
                if ($availabilityStatus['is_available']) {
                    $availableDoctors++;
                } else {
                    $unavailableMessages[] = "Dr. {$doctor->first_name} {$doctor->last_name}: {$availabilityStatus['message']}";
                }
            } else {
                // If no availability setting, assume doctor is available
                $availableDoctors++;
            }
        }

        // Determine overall clinic status
        $isAvailable = $availableDoctors > 0; // Clinic is available if at least one doctor is available
        $unavailableMessage = '';
        $resumeDate = null;

        if (! $isAvailable) {
            $unavailableMessage = 'All doctors are currently unavailable.';
        } elseif ($availableDoctors < $totalDoctors) {
            // Some doctors are unavailable
            $unavailableMessage = 'Some doctors are currently unavailable.';
        }

        // Get some basic statistics for the homepage
        $totalAppointments = Appointment::count();
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();

        return view('home', compact(
            'isAvailable',
            'unavailableMessage',
            'resumeDate',
            'totalDoctors',
            'totalAppointments',
            'todayAppointments',
            'availableDoctors',
            'unavailableMessages'
        ));
    }

    /**
     * Show the about page
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Show the services page
     */
    public function services()
    {
        return view('services');
    }

    /**
     * Show the contact page
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Show the privacy policy page
     */
    public function privacy()
    {
        return view('privacy');
    }

    /**
     * Show the terms of service page
     */
    public function terms()
    {
        return view('terms');
    }
}
