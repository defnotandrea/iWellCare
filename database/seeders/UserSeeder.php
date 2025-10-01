<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default doctor (admin functions)
        User::create([
            'first_name' => 'Dr. John',
            'last_name' => 'Smith',
            'username' => 'doctor',
            'email' => 'doctor@iwellcare.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'doctor',
            'phone_number' => '+1234567890',
            'street_address' => '123 Medical Center Dr',
            'city' => 'Healthcare City',
            'is_active' => true,
        ]);

        // Create a default staff member
        User::create([
            'first_name' => 'Sarah',
            'last_name' => 'Johnson',
            'username' => 'staff',
            'email' => 'staff@iwellcare.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'phone_number' => '+1234567891',
            'street_address' => '456 Healthcare Ave',
            'city' => 'Medical District',
            'is_active' => true,
        ]);

        // Create additional sample users
        User::create([
            'first_name' => 'Dr. Emily',
            'last_name' => 'Davis',
            'username' => 'emily',
            'email' => 'emily.davis@iwellcare.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'doctor',
            'phone_number' => '+1234567893',
            'street_address' => '321 Doctor Lane',
            'city' => 'Medical Center',
            'is_active' => true,
        ]);

        User::create([
            'first_name' => 'Robert',
            'last_name' => 'Wilson',
            'username' => 'robert',
            'email' => 'robert.wilson@iwellcare.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'phone_number' => '+1234567894',
            'street_address' => '654 Staff Street',
            'city' => 'Healthcare District',
            'is_active' => true,
        ]);

        // Create a sample patient
        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'username' => 'patient',
            'email' => 'patient@iwellcare.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'patient',
            'phone_number' => '+1234567895',
            'street_address' => '789 Patient Ave',
            'city' => 'Patient City',
            'is_active' => true,
        ]);

    }
}
