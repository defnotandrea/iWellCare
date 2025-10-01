<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'code',
        'type',
        'expires_at',
        'is_used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    /**
     * Generate a new OTP code
     */
    public static function generateCode(string $email, string $type = 'email_verification'): string
    {
        // Generate a 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Expires in 10 minutes
        $expiresAt = Carbon::now()->addMinutes(10);

        // Create the OTP record
        self::create([
            'email' => $email,
            'code' => $code,
            'type' => $type,
            'expires_at' => $expiresAt,
        ]);

        return $code;
    }

    /**
     * Verify an OTP code
     */
    public static function verifyCode(string $email, string $code, string $type = 'email_verification'): bool
    {
        $otp = self::where('email', $email)
            ->where('code', $code)
            ->where('type', $type)
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($otp) {
            $otp->update(['is_used' => true]);

            return true;
        }

        return false;
    }

    /**
     * Check if user has a valid OTP code
     */
    public static function hasValidCode(string $email, string $type = 'email_verification'): bool
    {
        return self::where('email', $email)
            ->where('type', $type)
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->exists();
    }

    /**
     * Clean up expired OTP codes
     */
    public static function cleanupExpired(): int
    {
        return self::where('expires_at', '<', Carbon::now())->delete();
    }

    /**
     * Get remaining time for OTP code
     */
    public function getRemainingTimeAttribute(): int
    {
        return max(0, Carbon::now()->diffInSeconds($this->expires_at));
    }

    /**
     * Check if OTP code is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if OTP code is valid (not used and not expired)
     */
    public function isValid(): bool
    {
        return ! $this->is_used && ! $this->isExpired();
    }
}
