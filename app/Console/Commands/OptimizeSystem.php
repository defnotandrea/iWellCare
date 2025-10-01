<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OptimizeSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize system performance by clearing cache, optimizing database, and preloading data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting system optimization...');

        // Clear all caches
        $this->info('Clearing caches...');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        // Optimize database
        $this->info('Optimizing database...');
        DB::statement('OPTIMIZE TABLE users, patients, appointments, consultations, prescriptions, inventory, billings, medical_records');

        // Preload cache with frequently accessed data
        $this->info('Preloading cache...');
        $this->preloadCache();

        // Generate optimized routes
        $this->info('Generating optimized routes...');
        Artisan::call('route:cache');

        // Generate optimized config
        $this->info('Generating optimized config...');
        Artisan::call('config:cache');

        // Generate optimized views
        $this->info('Generating optimized views...');
        Artisan::call('view:cache');

        $this->info('System optimization completed successfully!');
    }

    /**
     * Preload cache with frequently accessed data
     */
    private function preloadCache()
    {
        // Cache dashboard statistics for all users
        $users = DB::table('users')->select('id', 'role')->get();

        foreach ($users as $user) {
            \App\Services\CacheService::getDashboardStats($user->id, $user->role);
            \App\Services\CacheService::getUserPermissions($user->id);
        }

        // Cache inventory data
        \App\Services\CacheService::getInventoryData();

        // Cache system settings
        Cache::remember('system_settings', 1440, function () {
            return [
                'clinic_name' => 'ADULT WELLNESS CLINIC AND MEDICAL LABORATORY',
                'clinic_address' => 'Capitulacion Street, Zone 2, Bangued, Abra',
                'clinic_phone' => '09352410173',
                'clinic_email' => 'adultwellnessclinicandm@gmail.com',
                'working_hours' => [
                    'monday_friday' => '9:00 AM - 2:00 PM',
                    'saturday' => '9:00 AM - 2:00 PM',
                    'sunday' => 'Closed (Emergency Only)',
                ],
            ];
        });
    }
}
