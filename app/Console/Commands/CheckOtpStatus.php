<?php

namespace App\Console\Commands;

use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Console\Command;

class CheckOtpStatus extends Command
{
    protected $signature = 'check:otp-status {username}';

    protected $description = 'Check OTP status for a user';

    public function handle()
    {
        $username = $this->argument('username');

        $this->info("Checking OTP status for user: {$username}");

        // Find the user
        $user = User::where('username', $username)->first();

        if (! $user) {
            $this->error("User with username '{$username}' not found!");

            return 1;
        }

        $this->info("Found user: {$user->first_name} {$user->last_name}");
        $this->info("Email: {$user->email}");
        $this->info('Email verified: '.($user->email_verified_at ? 'Yes' : 'No'));

        // Check active OTP codes
        $activeOtps = OtpCode::where('email', $user->email)
            ->where('type', 'email_verification')
            ->where('expires_at', '>', now())
            ->get();

        if ($activeOtps->count() > 0) {
            $this->info('Active OTP codes:');
            foreach ($activeOtps as $otp) {
                $this->info("- Code: {$otp->code} (expires: {$otp->expires_at})");
            }
        } else {
            $this->warn('No active OTP codes found.');
        }

        // Test verification
        if ($activeOtps->count() > 0) {
            $testCode = $activeOtps->first()->code;
            $this->info("Testing verification with code: {$testCode}");

            if (OtpCode::verifyCode($user->email, $testCode, 'email_verification')) {
                $this->info('✅ OTP verification successful!');
            } else {
                $this->error('❌ OTP verification failed!');
            }
        }

        return 0;
    }
}
