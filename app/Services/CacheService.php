<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CacheService
{
    /**
     * Cache duration in minutes
     */
    const CACHE_DURATION = 60;

    const LONG_CACHE_DURATION = 1440; // 24 hours

    /**
     * Cache dashboard statistics
     */
    public static function getDashboardStats($userId, $role)
    {
        $cacheKey = "dashboard_stats_{$role}_{$userId}";

        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($role, $userId) {
            switch ($role) {
                case 'staff':
                    return [
                        'total_patients' => DB::table('patients')->count(),
                        'total_appointments' => DB::table('appointments')->count(),
                        'pending_appointments' => DB::table('appointments')->where('status', 'pending')->count(),
                        'total_billings' => DB::table('billings')->count(),
                    ];
                case 'patient':
                    $patient = DB::table('patients')->where('user_id', $userId)->first();

                    return [
                        'total_appointments' => DB::table('appointments')->where('patient_id', $patient->id ?? 0)->count(),
                        'upcoming_appointments' => DB::table('appointments')
                            ->where('patient_id', $patient->id ?? 0)
                            ->where('appointment_date', '>=', now())
                            ->count(),
                        'total_consultations' => DB::table('consultations')
                            ->where('patient_id', $patient->id ?? 0)
                            ->count(),
                    ];
                default:
                    return [];
            }
        });
    }

    /**
     * Cache user permissions
     */
    public static function getUserPermissions($userId)
    {
        $cacheKey = "user_permissions_{$userId}";

        return Cache::remember($cacheKey, self::LONG_CACHE_DURATION, function () use ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();

            return [
                'role' => $user->role ?? 'guest',
                'permissions' => self::getRolePermissions($user->role ?? 'guest'),
            ];
        });
    }

    /**
     * Cache inventory data
     */
    public static function getInventoryData()
    {
        $cacheKey = 'inventory_data';

        return Cache::remember($cacheKey, self::CACHE_DURATION, function () {
            return [
                'total_items' => DB::table('inventory')->count(),
                'low_stock_items' => DB::table('inventory')->whereRaw('quantity <= COALESCE(reorder_level, minimum_stock)')->count(),
                'out_of_stock_items' => DB::table('inventory')->where('quantity', '<=', 0)->count(),
                'expiring_soon' => DB::table('inventory')
                    ->where(function ($q) {
                        $q->whereNotNull('expiration_date')
                            ->where('expiration_date', '<=', now()->addDays(30))
                            ->where('expiration_date', '>', now());
                    })
                    ->count(),
            ];
        });
    }

    /**
     * Clear user-specific cache
     */
    public static function clearUserCache($userId, $role)
    {
        Cache::forget("dashboard_stats_{$role}_{$userId}");
        Cache::forget("user_permissions_{$userId}");
    }

    /**
     * Clear all cache
     */
    public static function clearAllCache()
    {
        Cache::flush();
    }

    /**
     * Get role permissions
     */
    private static function getRolePermissions($role)
    {
        $permissions = [
            'doctor' => [
                'view_patients', 'manage_patients', 'view_appointments', 'manage_appointments',
                'view_consultations', 'manage_consultations', 'view_prescriptions', 'manage_prescriptions',
                'view_inventory', 'manage_inventory', 'view_reports', 'manage_staff',
            ],
            'staff' => [
                'view_patients', 'manage_patients', 'view_appointments', 'manage_appointments',
                'view_consultations', 'manage_consultations', 'view_billing', 'manage_billing',
                'view_inventory', 'manage_inventory', 'view_reports',
            ],
            'patient' => [
                'view_own_appointments', 'book_appointments', 'view_own_consultations',
                'view_own_prescriptions', 'view_own_medical_records', 'view_own_billing',
            ],
            'guest' => [],
        ];

        return $permissions[$role] ?? [];
    }
}
