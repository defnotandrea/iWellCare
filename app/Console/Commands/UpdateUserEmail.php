<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-email {username} {new_email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user email address';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->argument('username');
        $newEmail = $this->argument('new_email');

        $this->info("Updating email for user: {$username}");
        $this->info("New email: {$newEmail}");

        // Find the user
        $user = User::where('username', $username)->first();

        if (! $user) {
            $this->error("User with username '{$username}' not found!");

            return 1;
        }

        $this->info("Found user: {$user->first_name} {$user->last_name}");
        $this->info("Current email: {$user->email}");

        // Check if new email is already taken
        $existingUser = User::where('email', $newEmail)->first();
        if ($existingUser && $existingUser->id !== $user->id) {
            $this->error("Email '{$newEmail}' is already taken by another user!");

            return 1;
        }

        // Update the email
        $user->update(['email' => $newEmail]);

        $this->info('✅ Email updated successfully!');
        $this->info("Old email: {$user->getOriginal('email')}");
        $this->info("New email: {$newEmail}");

        return 0;
    }
}
