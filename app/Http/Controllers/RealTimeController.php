<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Billing;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealTimeController extends Controller
{
    /**
     * Get real-time updates for the authenticated user
     */
    public function getUpdates(Request $request)
    {
        try {
            $user = Auth::user();
            $updates = [];

            // Get user-specific updates based on role
            switch ($user->role) {
                case 'staff':
                    $updates = $this->getStaffUpdates($user);
                    break;
                case 'patient':
                    $updates = $this->getPatientUpdates($user);
                    break;
                default:
                    $updates = $this->getGeneralUpdates($user);
            }

            return response()->json([
                'success' => true,
                'updates' => $updates,
                'timestamp' => now()->toISOString(),
                'user_role' => $user->role,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch updates',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get real-time updates for doctors
     */
    private function getDoctorUpdates($user)
    {
        $updates = [];

        // New appointments in the last 5 minutes
        $recentAppointments = Appointment::where('doctor_id', $user->id)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->with(['patient.user', 'patient'])
            ->get();

        if ($recentAppointments->count() > 0) {
            $updates['new_appointments'] = $recentAppointments->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'patient_name' => $appointment->patient->user->full_name,
                    'date' => $appointment->appointment_date,
                    'time' => $appointment->appointment_time,
                    'status' => $appointment->status,
                    'type' => 'new_appointment',
                    'timestamp' => $appointment->created_at->toISOString(),
                ];
            });
        }

        // Appointment cancellations in the last 5 minutes
        $cancelledAppointments = Appointment::where('doctor_id', $user->id)
            ->where('status', 'cancelled')
            ->where('updated_at', '>=', now()->subMinutes(5))
            ->with(['patient.user', 'patient'])
            ->get();

        if ($cancelledAppointments->count() > 0) {
            $updates['cancelled_appointments'] = $cancelledAppointments->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'patient_name' => $appointment->patient->user->full_name,
                    'date' => $appointment->appointment_date,
                    'time' => $appointment->appointment_time,
                    'cancelled_at' => $appointment->updated_at->toISOString(),
                    'type' => 'cancelled_appointment',
                ];
            });
        }

        // Today's appointment count
        $todayAppointments = Appointment::where('doctor_id', $user->id)
            ->whereDate('appointment_date', today())
            ->count();

        $updates['today_appointments_count'] = $todayAppointments;

        // Unread notifications count
        $unreadNotifications = $user->unreadNotifications()->count();
        $updates['unread_notifications_count'] = $unreadNotifications;

        return $updates;
    }

    /**
     * Get real-time updates for staff
     */
    private function getStaffUpdates($user)
    {
        $updates = [];

        // New appointments in the last 5 minutes
        $recentAppointments = Appointment::where('created_at', '>=', now()->subMinutes(5))
            ->with(['patient.user', 'patient', 'doctor.user'])
            ->get();

        if ($recentAppointments->count() > 0) {
            $updates['new_appointments'] = $recentAppointments->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'patient_name' => $appointment->patient->user->full_name,
                    'doctor_name' => $appointment->doctor->user->full_name,
                    'date' => $appointment->appointment_date,
                    'time' => $appointment->appointment_time,
                    'status' => $appointment->status,
                    'type' => 'new_appointment',
                    'timestamp' => $appointment->created_at->toISOString(),
                ];
            });
        }

        // Pending appointments count
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $updates['pending_appointments_count'] = $pendingAppointments;

        // Today's total appointments
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $updates['today_appointments_count'] = $todayAppointments;

        // Recent consultations
        $recentConsultations = Consultation::where('created_at', '>=', now()->subMinutes(10))
            ->with(['patient.user', 'doctor.user'])
            ->get();

        if ($recentConsultations->count() > 0) {
            $updates['recent_consultations'] = $recentConsultations->map(function ($consultation) {
                return [
                    'id' => $consultation->id,
                    'patient_name' => $consultation->patient->user->full_name,
                    'doctor_name' => $consultation->doctor->user->full_name,
                    'created_at' => $consultation->created_at->toISOString(),
                    'type' => 'new_consultation',
                ];
            });
        }

        return $updates;
    }

    /**
     * Get real-time updates for patients
     */
    private function getPatientUpdates($user)
    {
        $updates = [];

        // Get patient record
        $patient = Patient::where('user_id', $user->id)->first();

        if ($patient) {
            // Appointment status changes in the last 5 minutes
            $statusChanges = Appointment::where('patient_id', $patient->id)
                ->where('updated_at', '>=', now()->subMinutes(5))
                ->with(['doctor.user'])
                ->get();

            if ($statusChanges->count() > 0) {
                $updates['appointment_updates'] = $statusChanges->map(function ($appointment) {
                    return [
                        'id' => $appointment->id,
                        'doctor_name' => $appointment->doctor->user->full_name,
                        'date' => $appointment->appointment_date,
                        'time' => $appointment->appointment_time,
                        'old_status' => $appointment->getOriginal('status'),
                        'new_status' => $appointment->status,
                        'updated_at' => $appointment->updated_at->toISOString(),
                        'type' => 'status_change',
                    ];
                });
            }

            // Upcoming appointments
            $upcomingAppointments = Appointment::where('patient_id', $patient->id)
                ->where('appointment_date', '>=', today())
                ->where('status', 'confirmed')
                ->with(['doctor.user'])
                ->orderBy('appointment_date')
                ->orderBy('appointment_time')
                ->take(3)
                ->get();

            $updates['upcoming_appointments'] = $upcomingAppointments->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'doctor_name' => $appointment->doctor->user->full_name,
                    'date' => $appointment->appointment_date,
                    'time' => $appointment->appointment_time,
                    'type' => 'upcoming',
                ];
            });

            // Unread notifications count
            $unreadNotifications = $user->unreadNotifications()->count();
            $updates['unread_notifications_count'] = $unreadNotifications;
        }

        return $updates;
    }

    /**
     * Get general updates for any user
     */
    private function getGeneralUpdates($user)
    {
        $updates = [];

        // Unread notifications count
        $unreadNotifications = $user->unreadNotifications()->count();
        $updates['unread_notifications_count'] = $unreadNotifications;

        // System announcements (if any)
        $updates['system_status'] = 'operational';

        return $updates;
    }

    /**
     * Get real-time dashboard statistics
     */
    public function getDashboardStats(Request $request)
    {
        try {
            $user = Auth::user();
            $stats = [];

            switch ($user->role) {
                case 'staff':
                    $stats = $this->getStaffStats($user);
                    break;
                case 'patient':
                    $stats = $this->getPatientStats($user);
                    break;
            }

            return response()->json([
                'success' => true,
                'stats' => $stats,
                'timestamp' => now()->toISOString(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistics',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get doctor dashboard statistics
     */
    private function getDoctorStats($user)
    {
        $today = today();
        $thisWeek = now()->startOfWeek();
        $thisMonth = now()->startOfMonth();

        return [
            'today_appointments' => Appointment::where('doctor_id', $user->id)
                ->whereDate('appointment_date', $today)
                ->count(),
            'this_week_appointments' => Appointment::where('doctor_id', $user->id)
                ->whereBetween('appointment_date', [$thisWeek, now()])
                ->count(),
            'this_month_appointments' => Appointment::where('doctor_id', $user->id)
                ->whereBetween('appointment_date', [$thisMonth, now()])
                ->count(),
            'pending_appointments' => Appointment::where('doctor_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'total_patients' => Appointment::where('doctor_id', $user->id)
                ->distinct('patient_id')
                ->count('patient_id'),
            'consultations_today' => Consultation::where('doctor_id', $user->id)
                ->whereDate('created_at', $today)
                ->count(),
        ];
    }

    /**
     * Get staff dashboard statistics
     */
    private function getStaffStats($user)
    {
        $today = today();
        $thisWeek = now()->startOfWeek();
        $thisMonth = now()->startOfMonth();

        return [
            'today_appointments' => Appointment::whereDate('appointment_date', $today)->count(),
            'this_week_appointments' => Appointment::whereBetween('appointment_date', [$thisWeek, now()])->count(),
            'this_month_appointments' => Appointment::whereBetween('appointment_date', [$thisMonth, now()])->count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'total_patients' => Patient::count(),
            'total_doctors' => User::where('role', 'doctor')->count(),
            'consultations_today' => Consultation::whereDate('created_at', $today)->count(),
            'total_billings' => Billing::count(),
            'pending_billings' => Billing::where('status', 'pending')->count(),
        ];
    }

    /**
     * Get patient dashboard statistics
     */
    private function getPatientStats($user)
    {
        $patient = Patient::where('user_id', $user->id)->first();

        if (! $patient) {
            return [];
        }

        $today = today();
        $thisMonth = now()->startOfMonth();

        return [
            'total_appointments' => Appointment::where('patient_id', $patient->id)->count(),
            'upcoming_appointments' => Appointment::where('patient_id', $patient->id)
                ->where('appointment_date', '>=', $today)
                ->where('status', 'confirmed')
                ->count(),
            'completed_appointments' => Appointment::where('patient_id', $patient->id)
                ->where('status', 'completed')
                ->count(),
            'total_consultations' => Consultation::where('patient_id', $patient->id)->count(),
            'this_month_consultations' => Consultation::where('patient_id', $patient->id)
                ->whereBetween('created_at', [$thisMonth, now()])
                ->count(),
            'total_prescriptions' => 0, // Add when prescription model is available
            'unpaid_invoices' => Billing::where('patient_id', $patient->id)
                ->where('status', 'pending')
                ->count(),
        ];
    }

    /**
     * Mark notifications as read in real-time
     */
    public function markNotificationsAsRead(Request $request)
    {
        try {
            $user = Auth::user();
            $notificationIds = $request->input('notification_ids', []);

            if (empty($notificationIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No notification IDs provided',
                ], 400);
            }

            $user->notifications()
                ->whereIn('id', $notificationIds)
                ->update(['read_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => 'Notifications marked as read',
                'unread_count' => $user->unreadNotifications()->count(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark notifications as read',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
