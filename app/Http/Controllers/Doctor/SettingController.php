<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        return view('doctor.settings.index');
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'clinic_name' => 'required|string|max:255',
            'clinic_address' => 'nullable|string|max:500',
            'clinic_phone' => 'nullable|string|max:20',
            'clinic_email' => 'nullable|email|max:255',
        ]);

        // Update settings logic here
        // For now, just return success
        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
