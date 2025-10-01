<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestDashboardRoute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-dashboard-route';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Dashboard Route...');

        try {
            // Test if we can access the dashboard controller
            $controller = new \App\Http\Controllers\Doctor\DashboardController;
            $this->info('✅ Dashboard controller loaded successfully');

            // Test if we can create a request
            $request = \Illuminate\Http\Request::create('/doctor/dashboard', 'GET');
            $this->info('✅ Request created successfully');

            // Test if the view exists
            if (view()->exists('doctor.dashboard')) {
                $this->info('✅ Dashboard view exists');
            } else {
                $this->error('❌ Dashboard view does not exist');
            }

        } catch (\Exception $e) {
            $this->error('❌ Error: '.$e->getMessage());
        }

        return self::SUCCESS;
    }
}
