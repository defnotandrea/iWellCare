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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            $table->string('prescription_number', 255)->unique();
            $table->date('prescription_date');
            $table->text('diagnosis')->nullable();
            $table->text('notes')->nullable();
            $table->text('instructions')->nullable();
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->date('valid_until')->nullable();
            $table->boolean('is_printed')->default(false);
            $table->timestamp('printed_at')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['patient_id', 'status']);
            $table->index(['doctor_id', 'prescription_date']);
            $table->index('prescription_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
