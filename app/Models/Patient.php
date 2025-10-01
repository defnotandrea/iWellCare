<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_id',
        'first_name',
        'last_name',
        'full_name',
        'contact',
        'email',
        'address',
        'date_of_birth',
        'gender',
        'blood_type',
        'emergency_contact',
        'emergency_contact_phone',
        'medical_history',
        'allergies',
        'current_medications',
        'insurance_provider',
        'insurance_number',
        'registration_date',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'registration_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            if (empty($patient->patient_id)) {
                $patient->patient_id = static::generatePatientId();
            }
        });
    }

    /**
     * Generate a unique patient ID.
     */
    public static function generatePatientId()
    {
        do {
            $patientId = 'PAT'.str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (static::where('patient_id', $patientId)->exists());

        return $patientId;
    }

    /**
     * Get the user associated with this patient.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the appointments for this patient.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the consultations for this patient.
     */
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    /**
     * Get the prescriptions for this patient.
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    /**
     * Get the medical records for this patient.
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    /**
     * Get the invoices for this patient.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the patient's age.
     */
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? now()->diffInYears($this->date_of_birth) : null;
    }

    /**
     * Get the patient's full name.
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name.' '.$this->last_name);
    }

    /**
     * Scope a query to only include active patients.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to search patients by name or contact.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('full_name', 'like', "%{$search}%")
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('contact', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }
}
