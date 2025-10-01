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
        // Keep 'doctor' in the role enum for the main doctor user
        // No changes needed as 'doctor' role should remain available
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'doctor', 'patient', 'staff') NOT NULL DEFAULT 'patient'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add 'doctor' back to the role enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'doctor', 'patient', 'staff') NOT NULL DEFAULT 'patient'");
    }
};
