<?php

namespace App\Console\Commands;

use App\Services\EmailService;
use Illuminate\Console\Command;

class TestEmailSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email?} {type?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the email system by sending test emails (otp, appointment_confirmed, appointment_declined, appointment_rescheduled, appointment_reminder)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?: 'test@example.com';
        $type = $this->argument('type') ?: 'otp';

        $this->info("Testing email system with email: {$email}, type: {$type}");

        // Create a mock user object
        $user = (object) [
            'id' => 1,
            'email' => $email,
            'first_name' => 'John',
            'last_name' => 'Doe',
        ];

        try {
            if ($type === 'otp') {
                $result = EmailService::sendOtpEmail($user, 'email_verification');
                if ($result['success']) {
                    $this->info('✅ OTP Email sent successfully!');
                    $this->info("OTP Code: {$result['code']}");
                    $this->info('Check your email inbox for the test message.');
                } else {
                    $this->error('❌ Failed to send OTP email: ' . $result['message']);
                }
            } elseif (str_starts_with($type, 'appointment_')) {
                // Create a mock appointment object
                $appointment = (object) [
                    'id' => 1,
                    'date' => now()->addDays(1)->format('Y-m-d'),
                    'time' => '10:00 AM',
                    'doctor_name' => 'Dr. Smith',
                    'reason' => 'General Checkup',
                ];

                $appointmentType = str_replace('appointment_', '', $type);
                $result = EmailService::sendAppointmentEmail($user, $appointment, $appointmentType);

                if ($result['success']) {
                    $this->info('✅ Appointment Email sent successfully!');
                    $this->info('Check your email inbox for the test message.');
                } else {
                    $this->error('❌ Failed to send appointment email: ' . $result['message']);
                }
            } else {
                $this->error('❌ Invalid email type. Supported types: otp, appointment_confirmed, appointment_declined, appointment_rescheduled, appointment_reminder');
            }
        } catch (\Exception $e) {
            $this->error('❌ Exception occurred: ' . $e->getMessage());
        }

        return self::SUCCESS;
    }
}