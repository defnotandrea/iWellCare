<?php

namespace App\Console\Commands;

use App\Models\OtpCode;
use App\Models\User;
use App\Notifications\OtpVerificationNotification;
use Illuminate\Console\Command;

class TestPasswordResetOtp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:password-reset-otp {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test password reset OTP for a specific user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->argument('username');

        $this->info("Testing password reset OTP for user: {$username}");

        // Find the user
        $user = User::where('username', $username)->first();

        if (! $user) {
            $this->error("User with username '{$username}' not found!");

            return 1;
        }

        $this->info("Found user: {$user->first_name} {$user->last_name}");
        $this->info("Email: {$user->email}");

        // Check existing OTP codes
        $existingOtps = OtpCode::where('email', $user->email)
            ->where('type', 'password_reset')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($existingOtps->count() > 0) {
            $this->info("Found {$existingOtps->count()} existing OTP codes:");
            foreach ($existingOtps as $otp) {
                $status = $otp->is_used ? 'Used' : ($otp->isExpired() ? 'Expired' : 'Valid');
                $this->line("  - Code: {$otp->code} | Status: {$status} | Created: {$otp->created_at}");
            }
        } else {
            $this->info('No existing OTP codes found.');
        }

        // Generate new OTP
        $this->info('Generating new OTP code...');
        try {
            $code = OtpCode::generateCode($user->email, 'password_reset');
            $this->info("Generated OTP code: {$code}");

            // Send notification
            $this->info('Sending OTP notification...');
            $user->notify(new OtpVerificationNotification($code, 'password_reset'));
            $this->info('✅ OTP notification sent successfully!');

            $this->info("The user should receive an email with the code: {$code}");
            $this->info("Email address: {$user->email}");

        } catch (\Exception $e) {
            $this->error('Failed to send OTP: '.$e->getMessage());

            return 1;
        }

        return 0;
    }
}
