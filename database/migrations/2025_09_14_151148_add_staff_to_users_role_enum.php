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
        // Add 'staff' to the role enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'doctor', 'patient', 'staff') NOT NULL DEFAULT 'patient'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'staff' from the role enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'doctor', 'patient') NOT NULL DEFAULT 'patient'");
    }
};
