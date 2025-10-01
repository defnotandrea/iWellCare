<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request)
    {
        $email = $request->session()->get('password_reset_email');

        if (! $email) {
            return redirect()->route('password.request')
                ->with('error', 'Please request a password reset first.');
        }

        return view('auth.passwords.reset', compact('email'));
    }

    /**
     * Verify OTP and show password reset form.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
        ], [
            'otp.required' => 'Please enter the verification code.',
            'otp.size' => 'The verification code must be 6 digits.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        $email = $request->email;
        $otp = $request->otp;

        // Verify OTP
        if (! OtpCode::verifyCode($email, $otp, 'password_reset')) {
            return redirect()->back()
                ->withErrors(['otp' => 'Invalid or expired verification code. Please try again.'])
                ->withInput($request->only('email'));
        }

        // Store email in session for the password reset form
        $request->session()->put('password_reset_email', $email);
        $request->session()->put('otp_verified', true);

        Log::info('Password reset OTP verified', ['email' => $email]);

        return redirect()->route('password.reset')
            ->with('success', 'Verification successful! Please enter your new password.');
    }

    /**
     * Reset the given user's password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        $email = $request->session()->get('password_reset_email');
        $otpVerified = $request->session()->get('otp_verified');

        if (! $email || ! $otpVerified) {
            return redirect()->route('password.request')
                ->with('error', 'Please complete the verification process first.');
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        try {
            $user = User::where('email', $email)->first();

            if (! $user) {
                return redirect()->route('password.request')
                    ->with('error', 'User not found.');
            }

            // Update password
            $user->password = Hash::make($request->password);
            $user->save();

            // Mark OTP as used
            OtpCode::where('email', $email)
                ->where('type', 'password_reset')
                ->where('is_used', false)
                ->update(['is_used' => true]);

            // Clear session data
            $request->session()->forget(['password_reset_email', 'otp_verified']);

            Log::info('Password reset completed successfully', ['email' => $email]);

            return redirect()->route('login')
                ->with('success', 'Your password has been reset successfully! You can now login with your new password.');

        } catch (\Exception $e) {
            Log::error('Failed to reset password', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withErrors(['password' => 'There was an error resetting your password. Please try again.']);
        }
    }

    /**
     * Check if OTP verification is required
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkVerificationStatus(Request $request)
    {
        $email = $request->session()->get('password_reset_email');
        $otpVerified = $request->session()->get('otp_verified');

        return response()->json([
            'email' => $email,
            'otp_verified' => $otpVerified,
            'requires_verification' => $email && ! $otpVerified,
        ]);
    }
}
