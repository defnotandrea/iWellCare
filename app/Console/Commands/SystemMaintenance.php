<?php

namespace App\Console\Commands;

use App\Models\OtpCode;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SystemMaintenance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:maintenance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform system maintenance tasks including cleanup and optimization';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting system maintenance...');

        // Clean up expired OTP codes
        $this->cleanupExpiredOtps();

        // Clean up old logs
        $this->cleanupOldLogs();

        // Optimize database tables
        $this->optimizeDatabase();

        // Clear old cache entries
        $this->clearOldCache();

        // Update system statistics
        $this->updateSystemStatistics();

        $this->info('System maintenance completed successfully!');
    }

    /**
     * Clean up expired OTP codes
     */
    private function cleanupExpiredOtps()
    {
        $this->info('Cleaning up expired OTP codes...');

        $expiredCount = OtpCode::where('expires_at', '<', now())->count();
        OtpCode::where('expires_at', '<', now())->delete();

        $this->info("Removed {$expiredCount} expired OTP codes");
        Log::info("System maintenance: Removed {$expiredCount} expired OTP codes");
    }

    /**
     * Clean up old logs
     */
    private function cleanupOldLogs()
    {
        $this->info('Cleaning up old logs...');

        $logPath = storage_path('logs');
        $files = glob($logPath.'/laravel-*.log');
        $cutoffDate = now()->subDays(30);
        $deletedCount = 0;

        foreach ($files as $file) {
            if (filemtime($file) < $cutoffDate->timestamp) {
                unlink($file);
                $deletedCount++;
            }
        }

        $this->info("Removed {$deletedCount} old log files");
        Log::info("System maintenance: Removed {$deletedCount} old log files");
    }

    /**
     * Optimize database tables
     */
    private function optimizeDatabase()
    {
        $this->info('Optimizing database tables...');

        $tables = [
            'users', 'patients', 'appointments', 'consultations',
            'prescriptions', 'inventory', 'billings', 'medical_records',
            'otp_codes', 'inventory_logs',
        ];

        foreach ($tables as $table) {
            try {
                DB::statement("OPTIMIZE TABLE {$table}");
                $this->info("Optimized table: {$table}");
            } catch (\Exception $e) {
                $this->error("Failed to optimize table {$table}: ".$e->getMessage());
                Log::error("System maintenance: Failed to optimize table {$table}", ['error' => $e->getMessage()]);
            }
        }
    }

    /**
     * Clear old cache entries
     */
    private function clearOldCache()
    {
        $this->info('Clearing old cache entries...');

        // Clear cache entries older than 24 hours
        $cacheKeys = [
            'dashboard_stats_*',
            'user_permissions_*',
            'inventory_data',
            'system_settings',
        ];

        foreach ($cacheKeys as $pattern) {
            if (str_contains($pattern, '*')) {
                // For patterns with wildcards, we'll clear specific known keys
                continue;
            }
            Cache::forget($pattern);
        }

        $this->info('Old cache entries cleared');
        Log::info('System maintenance: Old cache entries cleared');
    }

    /**
     * Update system statistics
     */
    private function updateSystemStatistics()
    {
        $this->info('Updating system statistics...');

        $stats = [
            'total_users' => DB::table('users')->count(),
            'total_patients' => DB::table('patients')->count(),
            'total_appointments' => DB::table('appointments')->count(),
            'total_consultations' => DB::table('consultations')->count(),
            'total_prescriptions' => DB::table('prescriptions')->count(),
            'total_inventory_items' => DB::table('inventory')->count(),
            'total_billings' => DB::table('billings')->count(),
            'last_updated' => now()->toISOString(),
        ];

        Cache::put('system_statistics', $stats, 1440); // Cache for 24 hours

        $this->info('System statistics updated');
        Log::info('System maintenance: System statistics updated', $stats);
    }
}
