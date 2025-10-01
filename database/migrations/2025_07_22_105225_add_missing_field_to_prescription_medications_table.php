<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('prescription_medications', 'medication_id')) {
            Schema::table('prescription_medications', function (Blueprint $table) {
                $table->foreignId('medication_id')->nullable()->constrained('medications')->onDelete('set null')->after('prescription_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescription_medications', function (Blueprint $table) {
            $table->dropForeign(['medication_id']);
            $table->dropColumn('medication_id');
        });
    }
};
