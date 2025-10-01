<?php

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all users with patient role who don't have a patient record
        $patientUsers = User::where('role', 'patient')
            ->whereNotExists(function ($query) {
                $query->select(\DB::raw(1))
                    ->from('patients')
                    ->whereRaw('patients.user_id = users.id');
            })
            ->get();

        foreach ($patientUsers as $user) {
            // Create patient record for each user
            Patient::create([
                'user_id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'contact' => $user->phone,
                'email' => $user->email,
                'address' => $user->address,
                'date_of_birth' => '1990-01-01', // Default date
                'gender' => 'other', // Default gender
                'blood_type' => 'O+', // Default blood type
                'emergency_contact' => 'Emergency Contact',
                'emergency_contact_phone' => $user->phone,
                'medical_history' => 'No significant medical history',
                'allergies' => 'None known',
                'current_medications' => 'None',
                'insurance_provider' => 'Health Insurance Co.',
                'insurance_number' => 'INS'.rand(100000000, 999999999),
                'is_active' => true,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration doesn't need to be reversed
        // Patient records should remain even if migration is rolled back
    }
};
