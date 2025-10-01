<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestWebVerification extends Command
{
    protected $signature = 'test:web-verification {username} {code}';

    protected $description = 'Test the web verification process';

    public function handle()
    {
        $username = $this->argument('username');
        $code = $this->argument('code');

        $this->info("Testing web verification for user: {$username}");
        $this->info("Using code: {$code}");

        // Find the user
        $user = User::where('username', $username)->first();

        if (! $user) {
            $this->error("User with username '{$username}' not found!");

            return 1;
        }

        $this->info("Found user: {$user->first_name} {$user->last_name}");
        $this->info("Email: {$user->email}");

        // Test the web verification endpoint
        $this->info('Testing web verification endpoint...');

        try {
            $response = Http::post('http://127.0.0.1:8000/verify-otp', [
                'email' => $user->email,
                'code' => $code,
                '_token' => csrf_token(),
            ]);

            $this->info('Response status: '.$response->status());
            $this->info('Response body: '.$response->body());

            if ($response->successful()) {
                $this->info('✅ Web verification successful!');

                // Check if user was verified
                $user->refresh();
                $this->info('Email verified: '.($user->email_verified_at ? 'Yes' : 'No'));

            } else {
                $this->error('❌ Web verification failed!');
                $this->error('Status: '.$response->status());
                $this->error('Response: '.$response->body());
            }

        } catch (\Exception $e) {
            $this->error('❌ Exception: '.$e->getMessage());
        }

        return 0;
    }
}
