<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing users with usernames based on their email
        DB::table('users')->get()->each(function ($user) {
            if (empty($user->username)) {
                $username = strtolower(explode('@', $user->email)[0]);
                $counter = 1;
                $originalUsername = $username;

                // Ensure username is unique
                while (DB::table('users')->where('username', $username)->where('id', '!=', $user->id)->exists()) {
                    $username = $originalUsername.$counter;
                    $counter++;
                }

                DB::table('users')->where('id', $user->id)->update(['username' => $username]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this migration
    }
};
