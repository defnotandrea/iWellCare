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
        Schema::table('inventory', function (Blueprint $table) {
            $table->string('location', 255)->nullable()->after('supplier');
            $table->string('batch_number', 255)->nullable()->after('location');
            $table->text('notes')->nullable()->after('batch_number');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->after('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['location', 'batch_number', 'notes', 'created_by']);
        });
    }
};
