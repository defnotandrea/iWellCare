<?php

namespace App\Http\Controllers;

use App\Services\EmailService;

class OtpDisplayController extends Controller
{
    /**
     * Show OTP codes page
     */
    public function index()
    {
        $otpCodes = EmailService::getRecentOtpCodes(20);

        return view('otp-display', compact('otpCodes'));
    }

    /**
     * Get OTP codes via AJAX
     */
    public function getOtpCodes()
    {
        $otpCodes = EmailService::getRecentOtpCodes(10);

        return response()->json([
            'success' => true,
            'otp_codes' => $otpCodes,
        ]);
    }
}
