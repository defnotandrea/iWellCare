<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'dosage',
        'quantity',
        'expiration_date',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'quantity' => 'integer',
    ];

    /**
     * Get the prescription medications for this medication.
     */
    public function prescriptionMedications(): HasMany
    {
        return $this->hasMany(PrescriptionMedication::class);
    }
}
