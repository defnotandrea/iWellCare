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
        Schema::create('doctor_availability_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_available')->default(true);
            $table->string('unavailable_message', 255)->nullable();
            $table->timestamp('unavailable_until')->nullable();
            $table->string('status', 255)->default('available'); // available, unavailable, on_leave, emergency
            $table->text('notes')->nullable();
            $table->foreignId('set_by')->constrained('users')->onDelete('cascade'); // staff who set this
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_availability_settings');
    }
};
