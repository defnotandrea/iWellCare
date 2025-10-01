<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property int $id
 * @property int $appointment_id
 * @property int $patient_id
 * @property int $doctor_id
 * @property string $consultation_date
 * @property string $consultation_time
 * @property string $status
 * @property string $chief_complaint
 * @property string $present_illness
 * @property string $past_medical_history
 * @property string $family_history
 * @property string $social_history
 * @property array $clinical_measurements
 * @property array $physical_examination
 * @property array $diagnosis
 * @property string $treatment_plan
 * @property string $prescription_notes
 * @property string $follow_up_date
 * @property string $follow_up_notes
 * @property string $consultation_notes
 * @property string $medications
 * @property string $allergies
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'consultation_date',
        'consultation_time',
        'status',
        'chief_complaint',
        'present_illness',
        'past_medical_history',
        'family_history',
        'social_history',
        'clinical_measurements',
        'physical_examination',
        'diagnosis',
        'treatment_plan',
        'prescription_notes',
        'follow_up_date',
        'follow_up_notes',
        'consultation_notes',
        'medications',
        'allergies',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'consultation_date' => 'date',
        'consultation_time' => 'datetime',
        'clinical_measurements' => 'array',
        'physical_examination' => 'array',
        'diagnosis' => 'array',
        'treatment_plan' => 'array',
        'follow_up_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the appointment for this consultation.
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the patient for this consultation.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor for this consultation.
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Get the prescriptions for this consultation.
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    /**
     * Get the billing record for this consultation.
     */
    public function billing()
    {
        return $this->hasOne(Billing::class);
    }

    /**
     * Get the medical records for this consultation.
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    /**
     * Get the user who created this consultation.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this consultation.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the consultation status display name.
     */
    public function getStatusDisplayNameAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Get the consultation date and time combined.
     */
    public function getConsultationDateTimeAttribute()
    {
        return ($this->consultation_date ? Carbon::parse($this->consultation_date)->format('Y-m-d') : '') . ' ' . ($this->consultation_time ? Carbon::parse($this->consultation_time)->format('H:i:s') : '');
    }

    /**
     * Check if consultation is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if consultation is in progress.
     */
    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if consultation is scheduled.
     */
    public function isScheduled()
    {
        return $this->status === 'scheduled';
    }

    /**
     * Check if consultation is cancelled.
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Get the clinical measurements as a formatted string.
     */
    public function getClinicalMeasurementsFormattedAttribute()
    {
        if (! $this->clinical_measurements) {
            return 'Not recorded';
        }

        $formatted = [];
        foreach ($this->clinical_measurements as $key => $value) {
            $formatted[] = ucfirst(str_replace('_', ' ', $key)).': '.$value;
        }

        return implode(', ', $formatted);
    }

    /**
     * Get the diagnosis as a formatted string.
     */
    public function getDiagnosisFormattedAttribute()
    {
        if (!$this->diagnosis) {
            return 'Not diagnosed';
        }

        $diagnosis = is_array($this->diagnosis) ? $this->diagnosis : [$this->diagnosis];
        return implode(', ', $diagnosis);
    }

    /**
     * Scope a query to only include consultations with specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include consultations for a specific date.
     */
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('consultation_date', $date);
    }

    /**
     * Scope a query to only include consultations for a specific doctor.
     */
    public function scopeForDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    /**
     * Scope a query to only include consultations for a specific patient.
     */
    public function scopeForPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    /**
     * Scope a query to only include completed consultations.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include in-progress consultations.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope a query to only include today's consultations.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('consultation_date', today());
    }

    /**
     * Scope a query to only include consultations that need follow-up.
     */
    public function scopeNeedsFollowUp($query)
    {
        return $query->whereNotNull('follow_up_date')
            ->where('follow_up_date', '>=', now()->toDateString());
    }
}
