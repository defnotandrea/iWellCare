<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OtpVerificationController extends Controller
{
    /**
     * Show the OTP verification form
     */
    public function showVerificationForm(Request $request)
    {
        $email = $request->session()->get('verification_email');

        // Debug information
        \Log::info('OtpVerificationController::showVerificationForm called', [
            'email' => $email,
            'user_authenticated' => auth()->check(),
            'authenticated_user' => auth()->check() ? auth()->user()->email : null,
        ]);

        // If no email in session, check if user is authenticated and get their email
        if (! $email && auth()->check()) {
            $user = auth()->user();
            $email = $user->email;

            // Only auto-send OTP if user is not already verified and we don't have an email in session
            // AND if this is the first time they're visiting the page (not a form submission)
            if ($email && ! $user->email_verified_at && ! $request->session()->has('verification_email') && $request->isMethod('get')) {
                try {
                    // Send OTP email using EmailService
                    EmailService::sendOtpEmail($user, 'email_verification');

                    // Store email in session for verification
                    $request->session()->put('verification_email', $email);
                    $request->session()->put('otp_sent_time', time());

                    Log::info('Auto-sent OTP for authenticated user', [
                        'email' => $email,
                        'user_id' => $user->id,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to auto-send OTP', [
                        'email' => $email,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        // If no email in session, allow user to enter email manually
        if (! $email) {
            Log::info('No email in session, showing email input form');

            return view('auth.verify-otp-simple', ['email' => null]);
        }

        Log::info('Showing OTP verification form', ['email' => $email]);

        return view('auth.verify-otp-simple', compact('email'));
    }

    /**
     * Send OTP code
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email address.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        $email = $request->email;

        // Check if user is already verified
        $user = User::where('email', $email)->first();
        if ($user && $user->email_verified_at) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email is already verified.',
                ], 422);
            }

            return redirect()->back()
                ->withErrors(['email' => 'Email is already verified.'])
                ->withInput($request->only('email'));
        }

        // Check if OTP was already sent recently to prevent duplicates (reduced to 30 seconds)
        if ($request->session()->has('verification_email') && $request->session()->get('verification_email') === $email) {
            // Check if OTP was sent within the last 30 seconds
            $lastOtpTime = $request->session()->get('otp_sent_time');
            if ($lastOtpTime && (time() - $lastOtpTime) < 30) {
                $remainingTime = 30 - (time() - $lastOtpTime);
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Verification code already sent. Please wait {$remainingTime} seconds before requesting a new code.",
                        'remaining_time' => $remainingTime,
                    ], 422);
                }

                return redirect()->back()
                    ->withErrors(['email' => "Verification code already sent. Please wait {$remainingTime} seconds before requesting a new code."])
                    ->withInput($request->only('email'));
            }
        }

        // Get user object
        $user = User::where('email', $email)->first();
        if (! $user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ], 404);
            }

            return redirect()->back()
                ->withErrors(['email' => 'User not found.'])
                ->withInput($request->only('email'));
        }

        // Use EmailService
        $result = EmailService::sendOtpEmail($user, 'email_verification');

        // Store email in session for verification
        $request->session()->put('verification_email', $email);
        $request->session()->put('otp_sent_time', time());

        if ($result['success']) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'email' => $email,
                ]);
            }

            return redirect()->route('otp.verify.form')
                ->with('success', $result['message']);
        } else {
            // Email failed
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email sending failed.',
                    'code' => $result['code'],
                ], 500);
            }

            return redirect()->route('otp.verify.form')
                ->with('error', 'Email sending failed.')
                ->with('otp_code', $result['code']);
        }
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please enter a valid 6-digit code.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        $email = $request->email;
        $code = $request->code;

        try {
            // Verify OTP code
            if (OtpCode::verifyCode($email, $code, 'email_verification')) {
                // Mark user as verified
                $user = User::where('email', $email)->first();
                $user->update([
                    'email_verified_at' => now(),
                ]);

                // Don't log in the user automatically - let them log in manually
                Log::info('Email verified successfully', [
                    'email' => $email,
                    'user_id' => $user->id,
                ]);

                // Clear session
                $request->session()->forget('verification_email');

                // Set flag to indicate OTP verification was completed
                $request->session()->put('otp_verification_completed', true);
                $request->session()->put('otp_verification_email', $email);

                // Debug logging
                Log::info('OTP verification completed - session flag set', [
                    'email' => $email,
                    'user_id' => $user->id,
                    'session_flag_set' => $request->session()->has('otp_verification_completed'),
                ]);

                // Redirect to login page with success message
                $redirectUrl = url('/login');

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Email verified successfully! Your account has been activated. You can now log in to continue. After login, you\'ll be redirected to your dashboard.',
                        'redirect' => $redirectUrl,
                        'showModal' => true,
                    ]);
                }

                return redirect($redirectUrl)
                    ->with('success', 'Email verified successfully! Please log in to continue.');
            } else {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid or expired verification code. Please try again.',
                    ], 422);
                }

                return redirect()->back()
                    ->withErrors(['code' => 'Invalid or expired verification code. Please try again.'])
                    ->withInput($request->only('email'));
            }

        } catch (\Exception $e) {
            Log::error('Failed to verify OTP', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred during verification. Please try again.',
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['code' => 'An error occurred during verification. Please try again.'])
                ->withInput($request->only('email'));
        }
    }

    /**
     * Resend OTP code
     */
    public function resendOtp(Request $request)
    {
        Log::info('Resend OTP called', [
            'email' => $request->email,
            'all_data' => $request->all(),
            'expects_json' => $request->expectsJson(),
            'session_email' => $request->session()->get('verification_email'),
        ]);

        $email = $request->email;

        if (! $email) {
            Log::warning('Resend OTP: Email address is required');
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email address is required.',
                ], 422);
            }

            return redirect()->back()
                ->withErrors(['email' => 'Email address is required.']);
        }

        try {
            // Check if user exists
            $user = User::where('email', $email)->first();
            if (! $user) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User not found.',
                    ], 404);
                }

                return redirect()->back()
                    ->withErrors(['email' => 'User not found.']);
            }

            // Check if already verified
            if ($user->email_verified_at) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email is already verified.',
                    ], 422);
                }

                return redirect()->back()
                    ->withErrors(['email' => 'Email is already verified.']);
            }

            // Check if OTP was already sent recently to prevent spam (reduced to 30 seconds)
            $lastOtpTime = $request->session()->get('otp_sent_time');
            if ($lastOtpTime && (time() - $lastOtpTime) < 30) {
                $remainingTime = 30 - (time() - $lastOtpTime);
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Please wait {$remainingTime} seconds before requesting a new code.",
                        'remaining_time' => $remainingTime,
                    ], 422);
                }

                return redirect()->back()
                    ->withErrors(['email' => "Please wait {$remainingTime} seconds before requesting a new code."]);
            }

            // Ensure verification_email is set in session
            $request->session()->put('verification_email', $email);

            // Use EmailService with fallback for resending
            $result = EmailService::sendOtpEmail($user, 'email_verification');

            // Update session with new timestamp
            $request->session()->put('otp_sent_time', time());

            Log::info('Resend OTP result', [
                'email' => $email,
                'success' => $result['success'],
                'message' => $result['message'],
                'code' => $result['code'],
            ]);

            if ($result['success']) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Verification code sent successfully! Please check your email.',
                        'email' => $email,
                    ]);
                }

                return redirect()->back()
                    ->with('success', 'Verification code sent successfully! Please check your email.');
            } else {
                // Email failed, generate fallback OTP code
                $fallbackCode = OtpCode::generateCode($email, 'email_verification');

                Log::warning('Email sending failed, using fallback OTP', [
                    'email' => $email,
                    'user_id' => $user->id,
                    'fallback_code' => $fallbackCode,
                ]);

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email delivery failed. Please use the code shown below to verify your account.',
                        'code' => $fallbackCode,
                        'fallback' => true,
                        'email' => $email,
                    ], 500);
                }

                return redirect()->back()
                    ->with('error', 'Email delivery failed. Your verification code is: ' . $fallbackCode)
                    ->with('otp_code', $fallbackCode);
            }

        } catch (\Exception $e) {
            Log::error('Failed to resend OTP', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);

            // Generate fallback OTP code
            $fallbackCode = OtpCode::generateCode($email, 'email_verification');

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred. Please use the verification code shown below.',
                    'code' => $fallbackCode,
                    'fallback' => true,
                    'email' => $email,
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'An error occurred. Your verification code is: ' . $fallbackCode)
                ->with('otp_code', $fallbackCode);
        }
    }

    /**
     * Check if email is verified
     */
    public function checkVerificationStatus(Request $request)
    {
        $email = $request->email;

        if (! $email) {
            return response()->json([
                'success' => false,
                'message' => 'Email address is required.',
            ], 422);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'verified' => ! is_null($user->email_verified_at),
            'email' => $email,
        ]);
    }

    /**
     * Clear expired OTP codes (called by scheduler)
     */
    public function clearExpiredOtpCodes()
    {
        try {
            $deletedCount = OtpCode::where('expires_at', '<', now())->delete();

            Log::info('Cleared expired OTP codes', [
                'deleted_count' => $deletedCount,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Cleared {$deletedCount} expired OTP codes.",
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to clear expired OTP codes', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to clear expired OTP codes.',
            ], 500);
        }
    }

    /**
     * Get OTP verification statistics
     */
    public function getOtpStats()
    {
        try {
            $totalOtpCodes = OtpCode::count();
            $expiredOtpCodes = OtpCode::where('expires_at', '<', now())->count();
            $activeOtpCodes = OtpCode::where('expires_at', '>', now())->count();

            return response()->json([
                'success' => true,
                'stats' => [
                    'total_otp_codes' => $totalOtpCodes,
                    'expired_otp_codes' => $expiredOtpCodes,
                    'active_otp_codes' => $activeOtpCodes,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get OTP stats', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get OTP statistics.',
            ], 500);
        }
    }
}
