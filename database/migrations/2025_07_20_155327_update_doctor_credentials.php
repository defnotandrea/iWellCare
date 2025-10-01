<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the doctor's credentials
        DB::table('users')
            ->where('email', 'dr.bigornia@iwellcare.com')
            ->update([
                'username' => 'admin',
                'password' => Hash::make('awcmladmin_2014'),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original credentials
        DB::table('users')
            ->where('email', 'dr.bigornia@iwellcare.com')
            ->update([
                'username' => 'dr.bigornia',
                'password' => Hash::make('password'),
            ]);
    }
};
