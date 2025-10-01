<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CheckUserVerification extends Command
{
    protected $signature = 'check:user-verification {username}';

    protected $description = 'Check user verification status';

    public function handle()
    {
        $username = $this->argument('username');

        $this->info("Checking verification status for user: {$username}");

        $user = User::where('username', $username)->first();

        if (! $user) {
            $this->error("User with username '{$username}' not found!");

            return 1;
        }

        $this->info("Found user: {$user->first_name} {$user->last_name}");
        $this->info("Email: {$user->email}");
        $this->info('Email verified: '.($user->email_verified_at ? 'Yes' : 'No'));

        if ($user->email_verified_at) {
            $this->info("Verified at: {$user->email_verified_at}");
        }

        return 0;
    }
}
