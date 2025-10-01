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
        Schema::dropIfExists('billings');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            $table->decimal('amount', 10, 2);
            $table->decimal('consultation_fee', 10, 2)->default(0.00);
            $table->decimal('medication_fee', 10, 2)->default(0.00);
            $table->decimal('other_fees', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2);
            $table->string('status', 255)->default('unpaid');
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });
    }
};
