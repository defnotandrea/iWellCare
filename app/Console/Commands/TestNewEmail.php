<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailService;
use Illuminate\Console\Command;

class TestNewEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:new-email {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the new email service by sending an OTP email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?: 'test@example.com';

        // Find or create a test user
        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->info("Creating test user with email: {$email}");
            $user = User::create([
                'first_name' => 'Test',
                'last_name' => 'User',
                'username' => 'testuser',
                'email' => $email,
                'password' => bcrypt('password'),
                'role' => 'patient',
                'is_active' => true,
            ]);
        }

        $this->info("Sending OTP email to: {$email}");

        $result = EmailService::sendOtpEmail($user, 'email_verification');

        if ($result['success']) {
            $this->info('✅ Email sent successfully!');
            $this->info("OTP Code: {$result['code']}");
        } else {
            $this->error('❌ Failed to send email');
            $this->error($result['message']);
        }

        return 0;
    }
}