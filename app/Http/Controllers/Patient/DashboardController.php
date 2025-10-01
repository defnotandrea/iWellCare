<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Consultation;
use App\Models\MedicalRecord;
use App\Models\Prescription;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $patient = $user->patient;
        if (! $patient) {
            // Gracefully handle users without a linked patient record
            return redirect()->route('home')->with('error', 'No patient profile found for this account.');
        }

        // Get patient's appointments
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('appointment_date', '>=', now())
            ->where('status', '!=', 'cancelled')
            ->with('doctor')
            ->orderBy('appointment_date')
            ->limit(5)
            ->get();

        // Get recent appointments (all appointments, not just upcoming)
        $recentAppointments = Appointment::where('patient_id', $patient->id)
            ->with('doctor')
            ->orderBy('appointment_date', 'desc')
            ->limit(5)
            ->get();

        // Get recent consultations
        $recentConsultations = Consultation::where('patient_id', $patient->id)
            ->with('doctor')
            ->orderBy('consultation_date', 'desc')
            ->limit(3)
            ->get();

        // Get recent prescriptions
        $recentPrescriptions = Prescription::where('patient_id', $patient->id)
            ->with('doctor')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Get recent medical records
        $recentMedicalRecords = MedicalRecord::where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Get recent invoices
        $recentInvoices = Invoice::where('patient_id', $patient->id)
            ->with('appointment')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Statistics
        $totalAppointments = Appointment::where('patient_id', $patient->id)->count();
        $pendingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('status', 'pending')
            ->count();
        $completedConsultations = Consultation::where('patient_id', $patient->id)
            ->where('status', 'completed')
            ->count();
        $unpaidInvoices = Invoice::where('patient_id', $patient->id)
            ->where('status', 'unpaid')
            ->count();

        return view('patient.dashboard', compact(
            'upcomingAppointments',
            'recentAppointments',
            'recentConsultations',
            'recentPrescriptions',
            'recentMedicalRecords',
            'recentInvoices',
            'totalAppointments',
            'pendingAppointments',
            'completedConsultations',
            'unpaidInvoices'
        ));
    }
}
