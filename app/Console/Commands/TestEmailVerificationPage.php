<?php

namespace App\Console\Commands;

use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Console\Command;

class TestEmailVerificationPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email-verification-page {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email verification page for a specific user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->argument('username');

        $this->info("Testing email verification page for user: {$username}");

        // Find the user
        $user = User::where('username', $username)->first();

        if (! $user) {
            $this->error("User with username '{$username}' not found!");

            return 1;
        }

        $this->info("Found user: {$user->first_name} {$user->last_name}");
        $this->info("Email: {$user->email}");
        $this->info('Email verified: '.($user->email_verified_at ? 'Yes' : 'No'));

        // Check existing OTP codes
        $existingOtps = OtpCode::where('email', $user->email)
            ->where('type', 'email_verification')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($existingOtps->count() > 0) {
            $this->info("Found {$existingOtps->count()} existing email verification OTP codes:");
            foreach ($existingOtps as $otp) {
                $status = $otp->is_used ? 'Used' : ($otp->isExpired() ? 'Expired' : 'Valid');
                $this->line("  - Code: {$otp->code} | Status: {$status} | Created: {$otp->created_at}");
            }
        } else {
            $this->info('No existing email verification OTP codes found.');
        }

        // Generate new OTP for email verification
        $this->info('Generating new email verification OTP code...');
        try {
            $code = OtpCode::generateCode($user->email, 'email_verification');
            $this->info("Generated OTP code: {$code}");

            $this->info("The user should receive an email with the code: {$code}");
            $this->info("Email address: {$user->email}");
            $this->info('URL to verify: http://127.0.0.1:8000/verify-email');

        } catch (\Exception $e) {
            $this->error('Failed to generate OTP: '.$e->getMessage());

            return 1;
        }

        return 0;
    }
}
