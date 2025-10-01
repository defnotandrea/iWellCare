<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class EmailService
{
    /**
     * Send OTP verification email
     */
    public static function sendOtpEmail($user, $type = 'email_verification')
    {
        try {
            // Generate OTP code
            $otpCode = self::generateOtpCode($user->email, $type);

            // Send email using Laravel Mail with HTML template
            Mail::send('emails.otp-verification', [
                'user' => $user,
                'otpCode' => $otpCode,
                'type' => $type
            ], function ($message) use ($user, $type) {
                $message->to($user->email)
                        ->subject('Your OTP Verification Code - iWellCare');
            });

            Log::info('OTP email sent successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'type' => $type,
            ]);

            return ['success' => true, 'message' => 'OTP sent successfully', 'code' => $otpCode];
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email', [
                'user_id' => $user->id,
                'email' => $user->email,
                'type' => $type,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // For log driver, still return success since the email is logged
            if (config('mail.default') === 'log') {
                Log::info('Log driver detected, treating as successful', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                ]);
                return ['success' => true, 'message' => 'OTP logged successfully (log driver)', 'code' => $otpCode];
            }

            return ['success' => false, 'message' => 'Failed to send OTP email: ' . $e->getMessage(), 'code' => null];
        }
    }

    /**
     * Generate and store OTP code
     */
    private static function generateOtpCode($email, $type)
    {
        // Generate 6-digit OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store in database
        $existingOtp = \App\Models\OtpCode::where('email', $email)
            ->where('type', $type)
            ->first();

        if ($existingOtp) {
            $existingOtp->update([
                'code' => $otpCode,
                'expires_at' => now()->addMinutes(10),
                'is_used' => false,
            ]);
        } else {
            \App\Models\OtpCode::create([
                'email' => $email,
                'type' => $type,
                'code' => $otpCode,
                'expires_at' => now()->addMinutes(10),
                'is_used' => false,
            ]);
        }

        return $otpCode;
    }

    /**
     * Send appointment notification email
     */
    public static function sendAppointmentEmail($user, $appointment, $type)
    {
        try {
            $template = 'emails.appointment-' . $type;
            $subject = 'Appointment ' . ucfirst($type) . ' - iWellCare';

            // Send email using Laravel Mail with HTML template
            Mail::send($template, [
                'user' => $user,
                'appointment' => $appointment,
            ], function ($message) use ($user, $subject) {
                $message->to($user->email)
                        ->subject($subject);
            });

            Log::info('Appointment email sent successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'type' => $type,
                'appointment_id' => $appointment->id ?? null,
            ]);

            return ['success' => true, 'message' => 'Appointment email sent successfully'];
        } catch (\Exception $e) {
            Log::error('Failed to send appointment email', [
                'user_id' => $user->id,
                'email' => $user->email,
                'type' => $type,
                'appointment_id' => $appointment->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ['success' => false, 'message' => 'Failed to send appointment email: ' . $e->getMessage()];
        }
    }

    /**
     * Get recent OTP codes from log
     */
    public static function getRecentOtpCodes($limit = 10)
    {
        $otpLogPath = storage_path('logs/otp_codes.log');
        if (! file_exists($otpLogPath)) {
            return [];
        }

        $content = file_get_contents($otpLogPath);
        $entries = explode('=== OTP VERIFICATION CODE ===', $content);
        $recentEntries = array_slice($entries, -$limit);

        $otpCodes = [];
        foreach ($recentEntries as $entry) {
            if (trim($entry)) {
                $lines = explode("\n", trim($entry));
                $otpData = [];
                foreach ($lines as $line) {
                    if (strpos($line, ':') !== false) {
                        [$key, $value] = explode(':', $line, 2);
                        $otpData[trim($key)] = trim($value);
                    }
                }
                if (! empty($otpData)) {
                    $otpCodes[] = $otpData;
                }
            }
        }

        return array_reverse($otpCodes);
    }
}