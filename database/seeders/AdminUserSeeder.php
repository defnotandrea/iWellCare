<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        $adminExists = User::where('username', 'admin')->orWhere('email', 'admin@iwellcare.com')->exists();

        if (! $adminExists) {
            User::create([
                'first_name' => 'Admin',
                'last_name' => 'User',
                'username' => 'admin',
                'email' => 'admin@iwellcare.com',
                'email_verified_at' => now(),
                'password' => Hash::make('awcmladmin_2014'),
                'phone_number' => '000-000-0000',
                'street_address' => 'Admin Address',
                'city' => 'Admin City',
                'state_province' => 'Admin State',
                'postal_code' => '00000',
                'role' => 'doctor',
                'is_active' => true,
            ]);

            $this->command->info('✅ Admin user created successfully!');
            $this->command->info('Username: admin');
            $this->command->info('Password: awcmladmin_2014');
            $this->command->info('Email: admin@iwellcare.com');
        } else {
            $this->command->info('ℹ️ Admin user already exists.');
        }
    }
}
