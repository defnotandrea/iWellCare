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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            $table->string('record_number', 255)->unique();
            $table->date('record_date');
            $table->string('chief_complaint', 255)->nullable();
            $table->text('present_illness')->nullable();
            $table->text('past_medical_history')->nullable();
            $table->text('family_history')->nullable();
            $table->text('social_history')->nullable();
            $table->text('review_of_systems')->nullable();
            $table->text('physical_examination')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('treatment_plan')->nullable();
            $table->text('medications_prescribed')->nullable();
            $table->text('lab_results')->nullable();
            $table->text('imaging_results')->nullable();
            $table->text('clinical_measurements')->nullable(); // JSON field for BP, temp, pulse, etc.
            $table->text('allergies')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'archived', 'deleted'])->default('active');
            $table->enum('record_type', ['consultation', 'follow_up', 'emergency', 'routine'])->default('consultation');
            $table->boolean('is_confidential')->default(false);
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['patient_id', 'status']);
            $table->index(['doctor_id', 'record_date']);
            $table->index(['record_date', 'record_type']);
            $table->index('record_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
