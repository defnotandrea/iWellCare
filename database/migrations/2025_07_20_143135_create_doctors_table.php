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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('specialization', 255)->nullable();
            $table->string('license_number', 255)->unique()->nullable();
            $table->integer('years_of_experience', false, true)->default(0);
            $table->text('qualifications')->nullable();
            $table->text('bio')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->decimal('consultation_fee', 10, 2)->default(0.00);
            $table->json('available_days')->nullable();
            $table->json('available_hours')->nullable();
            $table->string('contact_number', 255)->nullable();
            $table->string('emergency_contact', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('postal_code', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('specialization');
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
