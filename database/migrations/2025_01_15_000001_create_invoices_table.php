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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('invoice_no', 255)->unique();
            $table->date('date_issued');

            // Article details (integrated)
            $table->string('article', 255);
            $table->decimal('unit_cost', 10, 2);
            $table->integer('quantity', false, true);
            $table->decimal('amount', 10, 2);

            // Financial totals
            $table->decimal('total_sales', 10, 2);
            $table->decimal('less_sc', 10, 2)->default(0.00); // less sales commission
            $table->decimal('net_of_sc', 10, 2)->default(0.00); // net of sales commission
            $table->decimal('withholding', 10, 2)->default(0.00);
            $table->decimal('grand_total', 10, 2);

            $table->timestamps();

            // Indexes for better performance
            $table->index(['patient_id', 'date_issued']);
            $table->index('invoice_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
