<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Inventory;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Safely compute dashboard metrics even if tables are missing or migrations not yet run
        $todaysAppointments = 0;
        $pendingConfirmations = 0;
        $lowInventory = 0;
        $unpaidBills = 0;

        try {
            $todaysAppointments = Appointment::whereDate('appointment_date', $today)->count();
            $pendingConfirmations = Appointment::where('status', 'pending')->count();
        } catch (\Throwable $e) {
            $todaysAppointments = 0;
            $pendingConfirmations = 0;
        }

        // Get recent appointments
        $recentAppointments = collect();
        try {
            $recentAppointments = Appointment::with(['patient', 'doctor'])
                ->latest()
                ->take(5)
                ->get();
        } catch (\Throwable $e) {
            $recentAppointments = collect();
        }

        try {
            $lowInventory = Inventory::whereColumn('quantity', '<=', 'reorder_level')->count();
        } catch (\Throwable $e) {
            $lowInventory = 0;
        }

        try {
            $unpaidBills = Invoice::where('status', 'unpaid')->count();
        } catch (\Throwable $e) {
            $unpaidBills = 0;
        }

        // Build recent activity without using array spread to support older PHP
        $recentActivity = [];
        try {
            $apptActivities = Appointment::with('patient')
                ->latest()
                ->take(2)
                ->get()
                ->map(function ($a) {
                    return [
                        'type' => 'appointment',
                        'desc' => 'Appointment confirmed for '.($a->patient ? $a->patient->first_name : 'Unknown Patient'),
                        'time' => method_exists($a, 'created_at') && $a->created_at ? $a->created_at->diffForHumans() : null,
                    ];
                })
                ->toArray();
        } catch (\Throwable $e) {
            $apptActivities = [];
        }

        try {
            $billingActivities = Invoice::with('patient')
                ->latest()
                ->take(2)
                ->get()
                ->map(function ($b) {
                    return [
                        'type' => 'payment',
                        'desc' => 'Payment recorded for '.($b->patient ? $b->patient->first_name : 'Unknown Patient'),
                        'time' => method_exists($b, 'created_at') && $b->created_at ? $b->created_at->diffForHumans() : null,
                    ];
                })
                ->toArray();
        } catch (\Throwable $e) {
            $billingActivities = [];
        }

        try {
            $inventoryActivities = Inventory::latest()
                ->take(1)
                ->get()
                ->map(function ($i) {
                    return [
                        'type' => 'inventory',
                        'desc' => 'Inventory updated: '.$i->name,
                        'time' => method_exists($i, 'updated_at') && $i->updated_at ? $i->updated_at->diffForHumans() : null,
                    ];
                })
                ->toArray();
        } catch (\Throwable $e) {
            $inventoryActivities = [];
        }

        $recentActivity = array_merge($apptActivities, $billingActivities, $inventoryActivities);

        return view('staff.dashboard', compact(
            'todaysAppointments',
            'pendingConfirmations',
            'lowInventory',
            'unpaidBills',
            'recentActivity',
            'recentAppointments'
        ));
    }
}
