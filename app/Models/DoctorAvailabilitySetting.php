<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAvailabilitySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'is_available',
        'unavailable_message',
        'unavailable_until',
        'status',
        'notes',
        'set_by',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'unavailable_until' => 'datetime',
    ];

    /**
     * Get the doctor that owns the availability setting.
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Get the staff member who set this availability.
     */
    public function setBy()
    {
        return $this->belongsTo(User::class, 'set_by');
    }

    /**
     * Check if the doctor is currently available.
     */
    public function isCurrentlyAvailable()
    {
        if (! $this->is_available) {
            return false;
        }

        if ($this->unavailable_until && now()->lt($this->unavailable_until)) {
            return false;
        }

        return true;
    }

    /**
     * Get the current availability status.
     */
    public function getCurrentStatus()
    {
        if ($this->isCurrentlyAvailable()) {
            return [
                'is_available' => true,
                'message' => 'Doctor is available',
                'status' => 'available',
            ];
        }

        return [
            'is_available' => false,
            'message' => $this->unavailable_message ?? 'Doctor is currently unavailable',
            'status' => $this->status,
            'until' => $this->unavailable_until,
        ];
    }
}
