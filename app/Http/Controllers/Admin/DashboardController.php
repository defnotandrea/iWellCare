<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Consultation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $thisWeek = Carbon::now()->startOfWeek();
        $lastWeek = Carbon::now()->subWeek()->startOfWeek();

        try {
            // Staff Statistics
            $totalStaff = User::where('role', 'staff')->count();
            $activeStaff = User::where('role', 'staff')->where('is_active', true)->count();
            $inactiveStaff = User::where('role', 'staff')->where('is_active', false)->count();
            $newStaffThisMonth = User::where('role', 'staff')->where('created_at', '>=', $thisMonth)->count();
            $newStaffThisWeek = User::where('role', 'staff')->where('created_at', '>=', $thisWeek)->count();

            // Staff Activities - Appointments created by staff
            $staffCreatedAppointments = Appointment::whereHas('createdBy', function ($query) {
                $query->where('role', 'staff');
            })->count();
            $staffAppointmentsThisMonth = Appointment::whereHas('createdBy', function ($query) {
                $query->where('role', 'staff');
            })->where('created_at', '>=', $thisMonth)->count();
            $staffAppointmentsThisWeek = Appointment::whereHas('createdBy', function ($query) {
                $query->where('role', 'staff');
            })->where('created_at', '>=', $thisWeek)->count();

            // Staff Activities - Consultations created by staff
            $staffCreatedConsultations = Consultation::whereHas('createdBy', function ($query) {
                $query->where('role', 'staff');
            })->count();
            $staffConsultationsThisMonth = Consultation::whereHas('createdBy', function ($query) {
                $query->where('role', 'staff');
            })->where('created_at', '>=', $thisMonth)->count();
            $staffConsultationsThisWeek = Consultation::whereHas('createdBy', function ($query) {
                $query->where('role', 'staff');
            })->where('created_at', '>=', $thisWeek)->count();

            // Staff Activities - Prescriptions (staff don't create prescriptions, doctors do)
            $staffCreatedPrescriptions = 0; // Placeholder
            $staffPrescriptionsThisMonth = 0; // Placeholder

            // Staff Activities - Invoicing (assuming staff handle invoicing)
            $staffHandledBills = Invoice::whereHas('appointment.createdBy', function ($query) {
                $query->where('role', 'staff');
            })->count();
            $staffBillsThisMonth = Invoice::whereHas('appointment.createdBy', function ($query) {
                $query->where('role', 'staff');
            })->where('created_at', '>=', $thisMonth)->count();

            // Recent Staff Activities
            $recentStaffAppointments = Appointment::with(['patient', 'createdBy'])
                ->whereHas('createdBy', function ($query) {
                    $query->where('role', 'staff');
                })
                ->latest()
                ->take(10)
                ->get();

            $recentStaffConsultations = Consultation::with(['patient', 'createdBy'])
                ->whereHas('createdBy', function ($query) {
                    $query->where('role', 'staff');
                })
                ->latest()
                ->take(10)
                ->get();

            // Top Performing Staff
            $topStaffByAppointments = User::where('role', 'staff')
                ->withCount(['createdAppointments' => function ($query) use ($thisMonth) {
                    $query->where('created_at', '>=', $thisMonth);
                }])
                ->orderBy('created_appointments_count', 'desc')
                ->take(5)
                ->get();

            $topStaffByConsultations = User::where('role', 'staff')
                ->withCount(['createdConsultations' => function ($query) use ($thisMonth) {
                    $query->where('created_at', '>=', $thisMonth);
                }])
                ->orderBy('created_consultations_count', 'desc')
                ->take(5)
                ->get();

            // Staff Growth Rate
            $staffGrowthRate = $this->calculateGrowthRate(
                User::where('role', 'staff')->whereBetween('created_at', [$lastMonth, $thisMonth])->count(),
                $newStaffThisMonth
            );

            // System Health (keep as is)
            $systemHealth = $this->getSystemHealth();

        } catch (\Exception $e) {
            // Fallback values
            $totalStaff = $activeStaff = $inactiveStaff = $newStaffThisMonth = $newStaffThisWeek = 0;
            $staffCreatedAppointments = $staffAppointmentsThisMonth = $staffAppointmentsThisWeek = 0;
            $staffCreatedConsultations = $staffConsultationsThisMonth = $staffConsultationsThisWeek = 0;
            $staffCreatedPrescriptions = $staffPrescriptionsThisMonth = 0;
            $staffHandledBills = $staffBillsThisMonth = 0;
            $recentStaffAppointments = $recentStaffConsultations = collect();
            $topStaffByAppointments = $topStaffByConsultations = collect();
            $staffGrowthRate = 0;
            $systemHealth = ['status' => 'error', 'message' => 'Database connection issue'];
        }

        return view('admin.dashboard', compact(
            // Staff Stats
            'totalStaff', 'activeStaff', 'inactiveStaff', 'newStaffThisMonth', 'newStaffThisWeek',

            // Staff Activities
            'staffCreatedAppointments', 'staffAppointmentsThisMonth', 'staffAppointmentsThisWeek',
            'staffCreatedConsultations', 'staffConsultationsThisMonth', 'staffConsultationsThisWeek',
            'staffCreatedPrescriptions', 'staffPrescriptionsThisMonth',
            'staffHandledBills', 'staffBillsThisMonth',

            // Recent Activities
            'recentStaffAppointments', 'recentStaffConsultations',

            // Top Performers
            'topStaffByAppointments', 'topStaffByConsultations',

            // Growth
            'staffGrowthRate', 'systemHealth'
        ));
    }

    private function calculateGrowthRate($oldValue, $newValue)
    {
        if ($oldValue == 0) {
            return $newValue > 0 ? 100 : 0;
        }

        return round((($newValue - $oldValue) / $oldValue) * 100, 1);
    }

    private function getWeeklyStats()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        return [
            'appointments' => Appointment::whereBetween('appointment_date', [$startOfWeek, $endOfWeek])->count(),
            'consultations' => Consultation::whereBetween('consultation_date', [$startOfWeek, $endOfWeek])->count(),
            'revenue' => Invoice::where('status', 'paid')
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->sum('grand_total') ?? 0,
            'newUsers' => User::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count(),
        ];
    }

    private function getMonthlyStats()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return [
            'appointments' => Appointment::whereBetween('appointment_date', [$startOfMonth, $endOfMonth])->count(),
            'consultations' => Consultation::whereBetween('consultation_date', [$startOfMonth, $endOfMonth])->count(),
            'revenue' => Invoice::where('status', 'paid')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('grand_total') ?? 0,
            'newUsers' => User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
        ];
    }

    private function getSystemHealth()
    {
        try {
            // Check database connection
            DB::connection()->getPdo();

            // Check if critical tables exist and have data
            $userCount = User::count();
            $appointmentCount = Appointment::count();

            if ($userCount > 0 && $appointmentCount >= 0) {
                return [
                    'status' => 'healthy',
                    'message' => 'All systems operational',
                    'database' => 'Connected',
                    'tables' => 'Accessible',
                ];
            } else {
                return [
                    'status' => 'warning',
                    'message' => 'System operational but no data found',
                    'database' => 'Connected',
                    'tables' => 'Empty',
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Database connection failed',
                'database' => 'Disconnected',
                'tables' => 'Inaccessible',
            ];
        }
    }
}
