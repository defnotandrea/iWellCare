<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Search patients.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        $patients = Patient::where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'first_name', 'last_name', 'email', 'phone']);

        return response()->json($patients);
    }
}
