<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class SecurityService
{
    /**
     * Enhanced password validation
     */
    public static function validatePassword($password)
    {
        $errors = [];

        // Length check
        if (strlen($password) < 10) {
            $errors[] = 'Password must be at least 10 characters long';
        }

        // Uppercase check
        if (! preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter';
        }

        // Lowercase check
        if (! preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase letter';
        }

        // Number check
        if (! preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number';
        }

        // Special character check
        if (! preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $errors[] = 'Password must contain at least one special character';
        }

        // Common password check
        if (self::isCommonPassword($password)) {
            $errors[] = 'Password is too common, please choose a more unique password';
        }

        // Sequential character check
        if (self::hasSequentialCharacters($password)) {
            $errors[] = 'Password cannot contain sequential characters';
        }

        return $errors;
    }

    /**
     * Check if password is common
     */
    private static function isCommonPassword($password)
    {
        $commonPasswords = [
            'password', '123456', '123456789', 'qwerty', 'abc123',
            'password123', 'admin', 'letmein', 'welcome', 'monkey',
        ];

        return in_array(strtolower($password), $commonPasswords);
    }

    /**
     * Check for sequential characters
     */
    private static function hasSequentialCharacters($password)
    {
        $sequences = ['123', '234', '345', '456', '567', '678', '789', '890',
            'abc', 'bcd', 'cde', 'def', 'efg', 'fgh', 'ghi', 'hij',
            'ijk', 'jkl', 'klm', 'lmn', 'mno', 'nop', 'opq', 'pqr',
            'qrs', 'rst', 'stu', 'tuv', 'uvw', 'vwx', 'wxy', 'xyz'];

        $password = strtolower($password);

        foreach ($sequences as $sequence) {
            if (strpos($password, $sequence) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Rate limiting for login attempts
     */
    public static function checkLoginRateLimit($email)
    {
        $key = 'login_attempts_'.$email;
        $maxAttempts = 5;
        $decayMinutes = 15;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            Log::warning('Login rate limit exceeded', [
                'email' => $email,
                'seconds_remaining' => $seconds,
            ]);

            return [
                'allowed' => false,
                'message' => "Too many login attempts. Please try again in {$seconds} seconds.",
                'seconds_remaining' => $seconds,
            ];
        }

        return ['allowed' => true];
    }

    /**
     * Record failed login attempt
     */
    public static function recordFailedLogin($email, $ip)
    {
        $key = 'login_attempts_'.$email;
        RateLimiter::hit($key, 900); // 15 minutes

        Log::warning('Failed login attempt', [
            'email' => $email,
            'ip' => $ip,
            'timestamp' => now(),
        ]);
    }

    /**
     * Clear login attempts on successful login
     */
    public static function clearLoginAttempts($email)
    {
        $key = 'login_attempts_'.$email;
        RateLimiter::clear($key);
    }

    /**
     * Session security validation
     */
    public static function validateSession($request)
    {
        $session = $request->session();
        $user = $request->user();

        if (! $user) {
            return ['valid' => false, 'reason' => 'No authenticated user'];
        }

        // Check if user is still active
        if (! $user->is_active) {
            return ['valid' => false, 'reason' => 'User account is inactive'];
        }

        // Check session age
        $sessionAge = now()->diffInMinutes($session->get('created_at', now()));
        if ($sessionAge > 480) { // 8 hours
            return ['valid' => false, 'reason' => 'Session expired'];
        }

        // Check for suspicious activity
        if (self::detectSuspiciousActivity($request)) {
            return ['valid' => false, 'reason' => 'Suspicious activity detected'];
        }

        return ['valid' => true];
    }

    /**
     * Detect suspicious activity
     */
    private static function detectSuspiciousActivity($request)
    {
        $user = $request->user();
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        // Check IP change
        $lastIp = Cache::get("user_last_ip_{$user->id}");
        if ($lastIp && $lastIp !== $ip) {
            Log::warning('IP address change detected', [
                'user_id' => $user->id,
                'old_ip' => $lastIp,
                'new_ip' => $ip,
            ]);
        }

        // Check user agent change
        $lastUserAgent = Cache::get("user_last_ua_{$user->id}");
        if ($lastUserAgent && $lastUserAgent !== $userAgent) {
            Log::warning('User agent change detected', [
                'user_id' => $user->id,
                'old_ua' => $lastUserAgent,
                'new_ua' => $userAgent,
            ]);
        }

        // Update cached values
        Cache::put("user_last_ip_{$user->id}", $ip, 1440);
        Cache::put("user_last_ua_{$user->id}", $userAgent, 1440);

        return false; // For now, just log suspicious activity
    }

    /**
     * Generate secure token
     */
    public static function generateSecureToken($length = 32)
    {
        return bin2hex(random_bytes($length));
    }

    /**
     * Encrypt sensitive data
     */
    public static function encryptData($data)
    {
        $key = config('app.key');
        $iv = random_bytes(16);
        $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);

        return base64_encode($iv.$encrypted);
    }

    /**
     * Decrypt sensitive data
     */
    public static function decryptData($encryptedData)
    {
        $key = config('app.key');
        $data = base64_decode($encryptedData);
        $iv = substr($data, 0, 16);
        $encrypted = substr($data, 16);

        return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);
    }

    /**
     * Audit log for security events
     */
    public static function logSecurityEvent($event, $userId = null, $details = [])
    {
        Log::channel('security')->info($event, [
            'user_id' => $userId,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now(),
            'details' => $details,
        ]);
    }

    /**
     * Check for SQL injection attempts
     */
    public static function detectSqlInjection($input)
    {
        $sqlPatterns = [
            '/(\b(SELECT|INSERT|UPDATE|DELETE|DROP|CREATE|ALTER|EXEC|UNION|SCRIPT)\b)/i',
            '/(\b(OR|AND)\s+\d+\s*=\s*\d+)/i',
            '/(\b(OR|AND)\s+\'\s*=\s*\')/i',
            '/(\b(OR|AND)\s+\"\s*=\s*\")/i',
            '/(\b(OR|AND)\s+\d+\s*=\s*\d+)/i',
            '/(\b(OR|AND)\s+\'\s*=\s*\')/i',
            '/(\b(OR|AND)\s+\"\s*=\s*\")/i',
            '/(\b(OR|AND)\s+\d+\s*=\s*\d+)/i',
            '/(\b(OR|AND)\s+\'\s*=\s*\')/i',
            '/(\b(OR|AND)\s+\"\s*=\s*\")/i',
        ];

        foreach ($sqlPatterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for XSS attempts
     */
    public static function detectXss($input)
    {
        $xssPatterns = [
            '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi',
            '/<iframe\b[^<]*(?:(?!<\/iframe>)<[^<]*)*<\/iframe>/mi',
            '/<object\b[^<]*(?:(?!<\/object>)<[^<]*)*<\/object>/mi',
            '/<embed\b[^<]*(?:(?!<\/embed>)<[^<]*)*<\/embed>/mi',
            '/<link\b[^<]*(?:(?!<\/link>)<[^<]*)*<\/link>/mi',
            '/<meta\b[^<]*(?:(?!<\/meta>)<[^<]*)*<\/meta>/mi',
            '/javascript:/i',
            '/vbscript:/i',
            '/onload\s*=/i',
            '/onerror\s*=/i',
            '/onclick\s*=/i',
            '/onmouseover\s*=/i',
        ];

        foreach ($xssPatterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Sanitize input data
     */
    public static function sanitizeInput($input)
    {
        if (is_array($input)) {
            return array_map([self::class, 'sanitizeInput'], $input);
        }

        // Remove null bytes
        $input = str_replace(chr(0), '', $input);

        // Trim whitespace
        $input = trim($input);

        // Check for SQL injection
        if (self::detectSqlInjection($input)) {
            self::logSecurityEvent('SQL injection attempt detected', null, ['input' => $input]);
            throw new \Exception('Invalid input detected');
        }

        // Check for XSS
        if (self::detectXss($input)) {
            self::logSecurityEvent('XSS attempt detected', null, ['input' => $input]);
            throw new \Exception('Invalid input detected');
        }

        return $input;
    }

    /**
     * Generate CSRF token
     */
    public static function generateCsrfToken()
    {
        return csrf_token();
    }

    /**
     * Validate CSRF token
     */
    public static function validateCsrfToken($token)
    {
        return hash_equals(session()->token(), $token);
    }
}
