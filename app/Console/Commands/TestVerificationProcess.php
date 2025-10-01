<?php

namespace App\Console\Commands;

use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Console\Command;

class TestVerificationProcess extends Command
{
    protected $signature = 'test:verification-process {username} {code}';

    protected $description = 'Test the complete verification process';

    public function handle()
    {
        $username = $this->argument('username');
        $code = $this->argument('code');

        $this->info("Testing verification process for user: {$username}");
        $this->info("Using code: {$code}");

        // Find the user
        $user = User::where('username', $username)->first();

        if (! $user) {
            $this->error("User with username '{$username}' not found!");

            return 1;
        }

        $this->info("Found user: {$user->first_name} {$user->last_name}");
        $this->info("Email: {$user->email}");
        $this->info('Email verified before: '.($user->email_verified_at ? 'Yes' : 'No'));

        // Test OTP verification
        $this->info('Testing OTP verification...');
        if (OtpCode::verifyCode($user->email, $code, 'email_verification')) {
            $this->info('✅ OTP verification successful!');

            // Update user
            $user->update([
                'email_verified_at' => now(),
            ]);

            $this->info('✅ User email marked as verified!');

            // Don't log in user automatically - they should log in manually
            $this->info('✅ User email verified (not logged in automatically)');

            // Check redirect URL
            $redirectUrl = route('login');
            $this->info("Redirect URL: {$redirectUrl}");

            // Check user role and expected dashboard
            switch ($user->role) {
                case 'staff':
                    $expectedUrl = route('staff.dashboard');
                    break;
                case 'patient':
                    $expectedUrl = route('patient.dashboard');
                    break;
                default:
                    $expectedUrl = '/';
            }

            $this->info("User role: {$user->role}");
            $this->info("After login, user will be redirected to: {$expectedUrl}");

        } else {
            $this->error('❌ OTP verification failed!');
        }

        return 0;
    }
}
