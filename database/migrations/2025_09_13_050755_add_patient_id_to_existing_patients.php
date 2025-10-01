<?php

use App\Models\Patient;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all patients that don't have a patient_id
        $patientsWithoutId = Patient::whereNull('patient_id')->orWhere('patient_id', '')->get();

        foreach ($patientsWithoutId as $patient) {
            $patient->patient_id = Patient::generatePatientId();
            $patient->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration doesn't need to be reversed
        // Patient IDs should remain even if migration is rolled back
    }
};
