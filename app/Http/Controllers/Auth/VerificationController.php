<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Request $request)
    {
        // Redirect to our custom OTP verification system
        return redirect()->route('otp.verify.form')->with('info', 'Please verify your email address using the OTP system.');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        // Since we're using OTP, redirect to our verification system
        Log::info('Default email verification attempted, redirecting to OTP system', [
            'user_id' => $request->user()->id,
            'email' => $request->user()->email,
        ]);

        return redirect()->route('otp.verify.form')->with('info', 'Please use the OTP verification system to verify your email address.');
    }

    /**
     * Resend the email verification notification.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Use the main dashboard route which automatically redirects to the appropriate role-based dashboard
            return redirect()->intended(route('dashboard'));
        }

        // Send OTP instead of default verification email
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'A new verification code has been sent to your email address.');
    }
}
