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
        Schema::table('patients', function (Blueprint $table) {
            // Add atomic full_name field
            $table->string('full_name', 255)->after('user_id');

            // Ensure address is comprehensive (already text, but make sure it's large enough)
            $table->text('address')->change();
        });

        // Populate full_name from existing first_name and last_name
        \DB::statement("UPDATE patients SET full_name = CONCAT(COALESCE(first_name, ''), ' ', COALESCE(last_name, '')) WHERE full_name IS NULL OR full_name = ''");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('full_name');
            // Address field remains as text
        });
    }
};
