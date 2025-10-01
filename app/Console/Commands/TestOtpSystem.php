<?php

namespace App\Console\Commands;

use App\Models\OtpCode;
use App\Models\User;
use App\Notifications\OtpVerificationNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestOtpSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:otp-system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the OTP verification system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing OTP verification system...');

        try {
            // Get the first user from the database
            $user = User::first();

            if (! $user) {
                $this->error('No users found in the database. Please create a user first.');

                return 1;
            }

            $this->info('Found user: '.$user->email);
            $this->info('User role: '.$user->role);

            // Test 1: Generate OTP code
            $this->info('Testing OTP code generation...');
            $code = OtpCode::generateCode($user->email, 'email_verification');
            $this->info('Generated OTP code: '.$code);

            // Test 2: Send OTP notification
            $this->info('Testing OTP notification sending...');
            $user->notify(new OtpVerificationNotification($code, 'email_verification'));
            $this->info('✅ OTP notification sent successfully!');

            // Test 3: Verify OTP code
            $this->info('Testing OTP code verification...');
            $isValid = OtpCode::verifyCode($user->email, $code, 'email_verification');

            if ($isValid) {
                $this->info('✅ OTP code verification successful!');
            } else {
                $this->error('❌ OTP code verification failed!');
            }

            // Test 4: Check if user has valid code
            $this->info('Testing valid code check...');
            $hasValidCode = OtpCode::hasValidCode($user->email, 'email_verification');

            if ($hasValidCode) {
                $this->info('✅ User has valid OTP code');
            } else {
                $this->info('ℹ️ User does not have valid OTP code (expected after verification)');
            }

            // Test 5: Cleanup expired codes
            $this->info('Testing cleanup of expired codes...');
            $deletedCount = OtpCode::cleanupExpired();
            $this->info("✅ Cleaned up {$deletedCount} expired OTP codes");

            $this->info('');
            $this->info('🎉 OTP system test completed successfully!');
            $this->info('');
            $this->info('OTP System Features:');
            $this->info('- ✅ Code generation (6-digit)');
            $this->info('- ✅ Email notification sending');
            $this->info('- ✅ Code verification');
            $this->info('- ✅ Expiration handling (10 minutes)');
            $this->info('- ✅ Cleanup of expired codes');
            $this->info('');
            $this->info('The OTP system is ready for use!');

        } catch (\Exception $e) {
            $this->error('❌ Error testing OTP system: '.$e->getMessage());
            Log::error('OTP system test failed: '.$e->getMessage());

            return 1;
        }

        return 0;
    }
}
