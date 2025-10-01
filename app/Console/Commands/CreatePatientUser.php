<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreatePatientUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-patient {email} {password} {--username=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a patient user for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = (string) $this->argument('email');
        $password = (string) $this->argument('password');
        $username = (string) ($this->option('username') ?: explode('@', $email)[0]);

        if (User::where('email', $email)->exists()) {
            $this->error("User with email {$email} already exists!");

            return 1;
        }

        $user = User::create([
            'first_name' => 'Patient',
            'last_name' => 'User',
            'email' => $email,
            'username' => $username,
            'password' => Hash::make($password),
            'role' => 'patient',
            'phone_number' => '1234567890',
            'is_active' => true,
        ]);

        $this->info('Patient user created successfully!');
        $this->info("Email: {$email}");
        $this->info("Username: {$username}");
        $this->info("Password: {$password}");
        $this->info('Role: patient');

        return 0;
    }
}


