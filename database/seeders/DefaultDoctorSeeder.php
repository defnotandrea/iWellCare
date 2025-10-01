<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultDoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if Dr. Bigornia already exists
        $existingDoctor = User::where('username', 'dr.bigornia')->first();

        if ($existingDoctor) {
            $this->command->info('Default doctor already exists. Skipping...');

            return;
        }

        // Create the user account for Dr. Bigornia
        $user = User::create([
            'first_name' => 'Augustus Caesar Butch B.',
            'last_name' => 'Bigornia',
            'email' => 'dr.bigornia@iwellcare.com',
            'username' => 'dr.bigornia',
            'password' => Hash::make('awcmladmin_2014'),
            'role' => 'doctor',
            'phone_number' => '+63 912 345 6789',
            'street_address' => '123 Medical Center Drive',
            'city' => 'Manila',
            'state_province' => 'Metro Manila',
            'postal_code' => '1000',
            'country' => 'Philippines',
            'is_active' => true,
        ]);

        // Create the doctor profile
        Doctor::create([
            'user_id' => $user->id,
            'specialization' => 'Internal Medicine',
            'license_number' => 'MD-2024-001',
            'years_of_experience' => 15,
            'qualifications' => 'Doctor of Medicine (MD)
Board Certified in Internal Medicine
Specialized in Internal Medicine and Preventive Medicine',
            'bio' => 'Dr. Augustus Caesar Butch B. Bigornia is a highly experienced internal medicine specialist with over 15 years of experience in internal medicine and preventive medicine. He specializes in comprehensive health assessments, chronic disease management, and preventive healthcare.',
            'status' => 'active',
            'consultation_fee' => 300.00, // ₱300.00 PHP
            'available_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            'available_hours' => [
                ['start' => '08:00', 'end' => '12:00'],
                ['start' => '13:00', 'end' => '17:00'],
            ],
            'contact_number' => '+63 912 345 6789',
            'emergency_contact' => '+63 923 456 7890',
            'address' => '123 Medical Center Drive',
            'city' => 'Manila',
            'state' => 'Metro Manila',
            'postal_code' => '1000',
            'country' => 'Philippines',
        ]);

        $this->command->info('Default doctor account created successfully!');
        $this->command->info('Username: dr.bigornia');
        $this->command->info('Password: awcmladmin_2014');
    }
}
