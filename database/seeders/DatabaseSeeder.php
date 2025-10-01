<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        $this->call(AdminUserSeeder::class);

        // Create default doctor
        $this->call(DefaultDoctorSeeder::class);

        // Create default users
        $this->createDefaultUsers();

        // Create sample data
        $this->createSampleData();
    }

    /**
     * Create default users.
     */
    private function createDefaultUsers(): void
    {
        // Note: Admin account is created by DefaultDoctorSeeder
        // No need to create additional doctor accounts here

        // Create staff user
        $staff = User::create([
            'first_name' => 'Sarah',
            'last_name' => 'Johnson',
            'email' => 'staff@iwellcare.com',
            'username' => 'staff',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'phone_number' => '+1234567891',
            'street_address' => '456 Healthcare Ave',
            'city' => 'Medical District',
            'is_active' => true,
        ]);

        // Create additional sample users (no additional doctors needed)

        User::create([
            'first_name' => 'Robert',
            'last_name' => 'Wilson',
            'email' => 'robert.wilson@iwellcare.com',
            'username' => 'robert.wilson',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'phone_number' => '+1234567894',
            'street_address' => '654 Staff Street',
            'city' => 'Healthcare District',
            'is_active' => true,
        ]);
    }

    /**
     * Create sample data.
     */
    private function createSampleData(): void
    {
        // Sample data creation removed - patient functionality deleted
    }
}
