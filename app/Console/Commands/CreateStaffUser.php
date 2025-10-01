<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateStaffUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-staff {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a staff user for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->error("User with email {$email} already exists!");

            return 1;
        }

        // Create staff user
        $user = User::create([
            'first_name' => 'Staff',
            'last_name' => 'User',
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'staff',
            'phone' => '1234567890',
            'is_active' => true,
        ]);

        $this->info('Staff user created successfully!');
        $this->info("Email: {$email}");
        $this->info("Password: {$password}");
        $this->info('Role: staff');

        return 0;
    }
}
