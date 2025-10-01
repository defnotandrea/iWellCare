<?php

namespace App\Console\Commands;

use App\Models\OtpCode;
use Illuminate\Console\Command;

class TestOtpFunctionality extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:otp {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test OTP generation and verification functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?: 'test@example.com';

        $this->info("Testing OTP functionality with email: {$email}");

        // Generate OTP
        $code = OtpCode::generateCode($email, 'email_verification');
        $this->info("Generated OTP code: {$code}");

        // Verify OTP
        $result = OtpCode::verifyCode($email, $code, 'email_verification');
        $this->info("OTP verification result: " . ($result ? 'SUCCESS' : 'FAILED'));

        // Try to verify again (should fail)
        $result2 = OtpCode::verifyCode($email, $code, 'email_verification');
        $this->info("Second verification attempt: " . ($result2 ? 'SUCCESS' : 'FAILED (expected)'));

        // Check if valid code exists
        $hasValid = OtpCode::hasValidCode($email, 'email_verification');
        $this->info("Has valid OTP code: " . ($hasValid ? 'YES' : 'NO'));

        $this->info('✅ OTP functionality test completed!');
    }
}