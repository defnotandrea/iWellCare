<?php

namespace App\Console\Commands;

use App\Models\OtpCode;
use Illuminate\Console\Command;

class CleanupExpiredOtpCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired OTP codes from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Cleaning up expired OTP codes...');

        try {
            $deletedCount = OtpCode::cleanupExpired();

            $this->info("✅ Successfully cleaned up {$deletedCount} expired OTP codes.");

            // Log the cleanup
            \Log::info('OTP cleanup completed', [
                'deleted_count' => $deletedCount,
                'timestamp' => now(),
            ]);

        } catch (\Exception $e) {
            $this->error('❌ Error cleaning up expired OTP codes: '.$e->getMessage());
            \Log::error('OTP cleanup failed', [
                'error' => $e->getMessage(),
                'timestamp' => now(),
            ]);

            return 1;
        }

        return 0;
    }
}
