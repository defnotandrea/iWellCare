<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'type',
        'status',
        'notes',
        'symptoms',
        'priority',
        'duration',
        'room_number',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'appointment_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the patient for this appointment.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor for this appointment.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    /**
     * Get the consultation for this appointment.
     */
    public function consultation()
    {
        return $this->hasOne(Consultation::class);
    }

    /**
     * Get the billing record for this appointment.
     */
    public function billing()
    {
        return $this->hasOne(Billing::class);
    }

    /**
     * Get the billing records for this appointment.
     */
    public function billings()
    {
        return $this->hasMany(Billing::class);
    }

    /**
     * Get the user who created this appointment.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this appointment.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the appointment status display name.
     */
    public function getStatusDisplayNameAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Get the appointment type display name.
     */
    public function getTypeDisplayNameAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->type));
    }

    /**
     * Get the appointment date and time combined.
     */
    public function getAppointmentDateTimeAttribute()
    {
        return $this->appointment_date->format('Y-m-d').' '.$this->appointment_time->format('H:i:s');
    }

    /**
     * Check if appointment is today.
     */
    public function isToday()
    {
        $appointmentDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $this->appointment_date->format('Y-m-d') . ' ' . $this->appointment_time->format('H:i:s'));
        return $appointmentDateTime->isToday();
    }

    /**
     * Check if appointment is in the past.
     */
    public function isPast()
    {
        $appointmentDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $this->appointment_date->format('Y-m-d') . ' ' . $this->appointment_time->format('H:i:s'));
        return $appointmentDateTime->isPast();
    }

    /**
     * Check if appointment is confirmed.
     */
    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if appointment is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if appointment is cancelled.
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Scope a query to only include appointments with specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include appointments for a specific date.
     */
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('appointment_date', $date);
    }

    /**
     * Scope a query to only include appointments for a specific doctor.
     */
    public function scopeForDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    /**
     * Scope a query to only include appointments for a specific patient.
     */
    public function scopeForPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    /**
     * Scope a query to only include upcoming appointments.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
            ->where('status', '!=', 'cancelled');
    }

    /**
     * Scope a query to only include today's appointments.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today());
    }

    /**
     * Scope a query to only include pending appointments.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include confirmed appointments.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include completed appointments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
