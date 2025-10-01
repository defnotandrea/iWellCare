<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    /**
     * Search medications.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        // This is a placeholder - you would typically search a medications database
        $medications = [
            ['id' => 1, 'name' => 'Paracetamol', 'dosage' => '500mg'],
            ['id' => 2, 'name' => 'Ibuprofen', 'dosage' => '400mg'],
            ['id' => 3, 'name' => 'Amoxicillin', 'dosage' => '500mg'],
            ['id' => 4, 'name' => 'Omeprazole', 'dosage' => '20mg'],
        ];

        $filtered = collect($medications)->filter(function ($med) use ($query) {
            return stripos($med['name'], $query) !== false;
        })->values();

        return response()->json($filtered);
    }
}
