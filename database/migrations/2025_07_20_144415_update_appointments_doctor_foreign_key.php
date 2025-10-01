<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if foreign key exists and drop it
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'appointments' 
            AND COLUMN_NAME = 'doctor_id' 
            AND CONSTRAINT_NAME != 'PRIMARY'
        ");

        if (! empty($foreignKeys)) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->dropForeign(['doctor_id']);
            });
        }

        // Check if index exists and drop it
        $indexes = DB::select("
            SELECT INDEX_NAME 
            FROM information_schema.STATISTICS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'appointments' 
            AND INDEX_NAME = 'appointments_doctor_id_appointment_date_index'
        ");

        if (! empty($indexes)) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->dropIndex(['doctor_id', 'appointment_date']);
            });
        }

        // Add the new foreign key constraint and index
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null');
            $table->index(['doctor_id', 'appointment_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['doctor_id']);

            // Drop the index
            $table->dropIndex(['doctor_id', 'appointment_date']);

            // Restore the original foreign key constraint to users table
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('set null');

            // Recreate the index
            $table->index(['doctor_id', 'appointment_date']);
        });
    }
};
