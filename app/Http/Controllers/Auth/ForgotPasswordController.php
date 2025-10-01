<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send a password reset OTP to the given user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'We could not find a user with that email address.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (! $user) {
            return redirect()->back()
                ->withErrors(['email' => 'We could not find a user with that email address.'])
                ->withInput($request->only('email'));
        }

        try {
            // Check if user already has a valid OTP
            if (OtpCode::hasValidCode($email, 'password_reset')) {
                return redirect()->back()
                    ->with('info', 'A password reset code has already been sent to your email. Please check your inbox or wait a few minutes before requesting another.');
            }

            // Generate and send OTP
            $code = OtpCode::generateCode($email, 'password_reset');
            $result = EmailService::sendOtpEmail($user, 'password_reset');

            // Store email in session for the reset form
            $request->session()->put('password_reset_email', $email);

            Log::info('Password reset OTP sent', ['email' => $email]);

            return redirect()->route('password.reset')
                ->with('success', 'A password reset code has been sent to your email address. Please check your inbox and enter the code below.');

        } catch (\Exception $e) {
            Log::error('Failed to send password reset OTP', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withErrors(['email' => 'There was an error sending the password reset code. Please try again.'])
                ->withInput($request->only('email'));
        }
    }

    /**
     * Resend password reset OTP
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email address.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $email = $request->email;
        $user = User::where('email', $email)->first();

        try {
            // Generate new OTP
            $code = OtpCode::generateCode($email, 'password_reset');
            $result = EmailService::sendOtpEmail($user, 'password_reset');

            Log::info('Password reset OTP resent', ['email' => $email]);

            return response()->json([
                'success' => true,
                'message' => 'A new password reset code has been sent to your email.',
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to resend password reset OTP', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'There was an error sending the password reset code. Please try again.',
            ], 500);
        }
    }
}
