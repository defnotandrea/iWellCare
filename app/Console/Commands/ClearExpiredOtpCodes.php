<?php

namespace App\Console\Commands;

use App\Models\OtpCode;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ClearExpiredOtpCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:clear-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear expired OTP codes from the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $deletedCount = OtpCode::where('expires_at', '<', now())->delete();

            Log::info('Cleared expired OTP codes via command', [
                'deleted_count' => $deletedCount,
                'command' => 'otp:clear-expired',
            ]);

            $this->info("Successfully cleared {$deletedCount} expired OTP codes.");

            return 0;
        } catch (\Exception $e) {
            Log::error('Failed to clear expired OTP codes via command', [
                'error' => $e->getMessage(),
                'command' => 'otp:clear-expired',
            ]);

            $this->error('Failed to clear expired OTP codes: '.$e->getMessage());

            return 1;
        }
    }
}
