<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'license_number',
        'years_of_experience',
        'qualifications',
        'bio',
        'status',
        'consultation_fee',
        'available_days',
        'available_hours',
        'contact_number',
        'emergency_contact',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
    ];

    protected $casts = [
        'available_days' => 'array',
        'available_hours' => 'array',
        'consultation_fee' => 'decimal:2',
        'years_of_experience' => 'integer',
    ];

    /**
     * Get the user that owns the doctor profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the appointments for this doctor.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the consultations for this doctor.
     */
    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }

    /**
     * Get the prescriptions for this doctor.
     */
    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }

    /**
     * Get the medical records for this doctor.
     */
    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    /**
     * Get the availability settings for this doctor.
     */
    public function availabilitySettings(): HasMany
    {
        return $this->hasMany(DoctorAvailabilitySetting::class, 'doctor_id', 'user_id');
    }

    /**
     * Scope a query to only include active doctors.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include doctors by specialization.
     */
    public function scopeBySpecialization($query, $specialization)
    {
        return $query->where('specialization', $specialization);
    }

    /**
     * Get the doctor's full name.
     */
    public function getFullNameAttribute(): string
    {
        return $this->user->full_name ?? 'Unknown Doctor';
    }

    /**
     * Get the doctor's email.
     */
    public function getEmailAttribute(): string
    {
        return $this->user->email ?? '';
    }

    /**
     * Check if doctor is available on a specific day.
     */
    public function isAvailableOnDay(string $day): bool
    {
        return in_array(strtolower($day), array_map('strtolower', $this->available_days ?? []));
    }

    /**
     * Check if doctor is available at a specific time.
     */
    public function isAvailableAtTime(string $time): bool
    {
        if (empty($this->available_hours)) {
            return true; // If no specific hours set, assume always available
        }

        $time = strtotime($time);
        foreach ($this->available_hours as $hours) {
            $start = strtotime($hours['start']);
            $end = strtotime($hours['end']);

            if ($time >= $start && $time <= $end) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get doctor's availability status.
     */
    public function getAvailabilityStatusAttribute(): string
    {
        if ($this->status !== 'active') {
            return 'unavailable';
        }

        $today = strtolower(now()->format('l'));
        if (! $this->isAvailableOnDay($today)) {
            return 'not_working_today';
        }

        $currentTime = now()->format('H:i');
        if (! $this->isAvailableAtTime($currentTime)) {
            return 'outside_hours';
        }

        return 'available';
    }

    /**
     * Get formatted consultation fee.
     */
    public function getFormattedConsultationFeeAttribute(): string
    {
        return '$'.number_format($this->consultation_fee, 2);
    }

    /**
     * Get doctor's complete address.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ]);

        return implode(', ', $parts);
    }

    /**
     * Get doctor's experience in years.
     */
    public function getExperienceTextAttribute(): string
    {
        $years = $this->years_of_experience;

        if ($years === 1) {
            return '1 year of experience';
        }

        return $years.' years of experience';
    }

    /**
     * Get available days as formatted string.
     */
    public function getAvailableDaysTextAttribute(): string
    {
        if (empty($this->available_days)) {
            return 'Not specified';
        }

        return implode(', ', $this->available_days);
    }

    /**
     * Get available hours as formatted string.
     */
    public function getAvailableHoursTextAttribute(): string
    {
        if (empty($this->available_hours)) {
            return 'Not specified';
        }

        $formatted = [];
        foreach ($this->available_hours as $hours) {
            $formatted[] = $hours['start'].' - '.$hours['end'];
        }

        return implode(', ', $formatted);
    }
}
