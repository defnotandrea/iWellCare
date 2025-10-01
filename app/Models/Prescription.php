<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'consultation_id',
        'prescription_date',
        'prescription_number',
        'diagnosis',
        'notes',
        'status',
        'valid_until',
        'total_amount',
        'payment_status',
    ];

    protected $casts = [
        'prescription_date' => 'date',
        'valid_until' => 'date',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the patient that owns the prescription.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Get the doctor that prescribed the medication.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    /**
     * Get the consultation associated with this prescription.
     */
    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }

    /**
     * Get the prescription items for this prescription.
     */
    public function prescriptionItems(): HasMany
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    /**
     * Get the medications for this prescription.
     */
    public function medications(): HasMany
    {
        return $this->hasMany(PrescriptionMedication::class);
    }

    /**
     * Scope a query to only include active prescriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include prescriptions by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get the prescription status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'active' => 'badge bg-success',
            'completed' => 'badge bg-info',
            'cancelled' => 'badge bg-danger',
            'expired' => 'badge bg-warning',
            default => 'badge bg-secondary',
        };
    }

    /**
     * Get the payment status badge class.
     */
    public function getPaymentStatusBadgeClassAttribute(): string
    {
        return match ($this->payment_status) {
            'paid' => 'badge bg-success',
            'pending' => 'badge bg-warning',
            'partial' => 'badge bg-info',
            'cancelled' => 'badge bg-danger',
            default => 'badge bg-secondary',
        };
    }

    /**
     * Check if prescription is expired.
     */
    public function isExpired(): bool
    {
        return $this->valid_until && $this->valid_until->isPast();
    }

    /**
     * Check if prescription is valid.
     */
    public function isValid(): bool
    {
        return $this->status === 'active' && ! $this->isExpired();
    }

    /**
     * Get formatted total amount.
     */
    public function getFormattedTotalAmountAttribute(): string
    {
        return '$'.number_format($this->total_amount, 2);
    }

    /**
     * Get prescription items count.
     */
    public function getItemsCountAttribute(): int
    {
        return $this->prescriptionItems()->count();
    }
}
