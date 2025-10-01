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
        Schema::table('invoices', function (Blueprint $table) {
            // Add medical service fields (only if they don't exist)
            if (! Schema::hasColumn('invoices', 'appointment_id')) {
                $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null')->after('patient_id');
            }
            if (! Schema::hasColumn('invoices', 'invoice_type')) {
                $table->enum('invoice_type', ['product', 'medical_service', 'mixed'])->default('product')->after('appointment_id');
            }

            // Add medical service fees
            if (! Schema::hasColumn('invoices', 'consultation_fee')) {
                $table->decimal('consultation_fee', 10, 2)->default(0.00)->after('grand_total');
            }
            if (! Schema::hasColumn('invoices', 'medication_fee')) {
                $table->decimal('medication_fee', 10, 2)->default(0.00)->after('consultation_fee');
            }
            if (! Schema::hasColumn('invoices', 'other_fees')) {
                $table->decimal('other_fees', 10, 2)->default(0.00)->after('medication_fee');
            }

            // Add status and payment tracking (only if they don't exist)
            if (! Schema::hasColumn('invoices', 'status')) {
                $table->enum('status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending')->after('grand_total');
            }
            if (! Schema::hasColumn('invoices', 'payment_date')) {
                $table->date('payment_date')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['appointment_id']);
            $table->dropColumn([
                'appointment_id', 'invoice_type', 'consultation_fee',
                'medication_fee', 'other_fees', 'status', 'payment_date',
            ]);
        });
    }
};
