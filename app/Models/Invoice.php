<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'appointment_id',
        'invoice_no',
        'date_issued',
        'invoice_type',
        'article',
        'unit_cost',
        'quantity',
        'amount',
        'consultation_fee',
        'medication_fee',
        'other_fees',
        'total_sales',
        'less_sc',
        'net_of_sc',
        'withholding',
        'grand_total',
        'status',
        'payment_date',
        'is_archived',
    ];

    protected $casts = [
        'date_issued' => 'date',
        'payment_date' => 'date',
        'unit_cost' => 'decimal:2',
        'quantity' => 'integer',
        'amount' => 'decimal:2',
        'consultation_fee' => 'decimal:2',
        'medication_fee' => 'decimal:2',
        'other_fees' => 'decimal:2',
        'total_sales' => 'decimal:2',
        'less_sc' => 'decimal:2',
        'net_of_sc' => 'decimal:2',
        'withholding' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'is_archived' => 'boolean',
    ];

    /**
     * Get the patient that owns the invoice.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the appointment associated with this invoice.
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Calculate the line total for this invoice item
     */
    public function calculateLineTotal()
    {
        return $this->unit_cost * $this->quantity;
    }

    /**
     * Calculate the total medical fees
     */
    public function calculateMedicalFees()
    {
        return $this->consultation_fee + $this->medication_fee + $this->other_fees;
    }

    /**
     * Calculate the grand total including all fees
     */
    public function calculateGrandTotal()
    {
        $productTotal = $this->amount;
        $medicalFees = $this->calculateMedicalFees();

        return $productTotal + $medicalFees;
    }
}
