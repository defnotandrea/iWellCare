<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAvailability extends Model
{
    use HasFactory;

    protected $table = 'doctor_availability';

    protected $fillable = [
        'doctor_id',
        'availability_date',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'availability_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Get the doctor that owns the availability.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}