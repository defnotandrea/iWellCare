<?php

namespace App\Console\Commands;

use App\Models\OtpCode;
use App\Models\User;
use App\Notifications\OtpVerificationNotification;
use Illuminate\Console\Command;

class SetupEmailVerification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:email-verification {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up email verification for a specific user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->argument('username');

        $this->info("Setting up email verification for user: {$username}");

        // Find the user
        $user = User::where('username', $username)->first();

        if (! $user) {
            $this->error("User with username '{$username}' not found!");

            return 1;
        }

        $this->info("Found user: {$user->first_name} {$user->last_name}");
        $this->info("Email: {$user->email}");
        $this->info('Email verified: '.($user->email_verified_at ? 'Yes' : 'No'));

        if ($user->email_verified_at) {
            $this->info("✅ User's email is already verified!");

            return 0;
        }

        // Generate new OTP for email verification
        $this->info('Generating new email verification OTP code...');
        try {
            $code = OtpCode::generateCode($user->email, 'email_verification');
            $this->info("Generated OTP code: {$code}");

            // Send notification
            $user->notify(new OtpVerificationNotification($code, 'email_verification'));
            $this->info('✅ OTP notification sent successfully!');

            $this->info("\n📧 Email verification setup complete!");
            $this->info("Email: {$user->email}");
            $this->info("OTP Code: {$code}");
            $this->info('URL: http://127.0.0.1:8000/verify-email');
            $this->info("\nInstructions:");
            $this->info('1. Go to: http://127.0.0.1:8000/verify-email');
            $this->info("2. Enter the OTP code: {$code}");
            $this->info("3. Click 'Verify Email'");

        } catch (\Exception $e) {
            $this->error('Failed to setup email verification: '.$e->getMessage());

            return 1;
        }

        return 0;
    }
}
