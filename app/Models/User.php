<?php

namespace App\Models;

use App\Services\EmailService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    // Use default primary key configuration; do not override $id as a public property
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'middle_name',
        'date_of_birth',
        'gender',
        'phone_number',
        'street_address',
        'city',
        'state_province',
        'postal_code',
        'country',
        'role',
        'is_active',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Send the email verification notification using our custom OTP system.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        try {
            // Send OTP email using EmailService
            EmailService::sendOtpEmail($this, 'email_verification');

            Log::info('Email verification OTP sent', [
                'user_id' => $this->id,
                'email' => $this->email,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send email verification OTP', [
                'user_id' => $this->id,
                'email' => $this->email,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Get the user's full name
     */
    public function getFullNameAttribute()
    {
        $name = $this->first_name;
        if ($this->middle_name) {
            $name .= ' '.$this->middle_name;
        }
        $name .= ' '.$this->last_name;

        return $name;
    }

    /**
     * Get the user's full address
     */
    public function getFullAddressAttribute()
    {
        $address = $this->street_address;
        if ($this->city) {
            $address .= ', '.$this->city;
        }
        if ($this->state_province) {
            $address .= ', '.$this->state_province;
        }
        if ($this->postal_code) {
            $address .= ' '.$this->postal_code;
        }
        if ($this->country) {
            $address .= ', '.$this->country;
        }

        return $address;
    }

    /**
     * Check if user is a staff member
     */
    public function isStaff()
    {
        return $this->role === 'staff';
    }

    /**
     * Check if user is a patient
     */
    public function isPatient()
    {
        return $this->role === 'patient';
    }

    /**
     * Get the doctor record for this user
     */
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    /**
     * Get the patient record for this user
     */
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    /**
     * Get appointments for this user (as patient)
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    /**
     * Get consultations for this user (as patient)
     */
    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'patient_id');
    }

    /**
     * Get prescriptions for this user (as patient)
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'patient_id');
    }

    /**
     * Get medical records for this user (as patient)
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'patient_id');
    }

    /**
     * Get doctor availability settings set by this user (as staff)
     */
    public function doctorAvailabilitySettings()
    {
        return $this->hasMany(DoctorAvailabilitySetting::class, 'set_by');
    }

    /**
     * Get availability settings for this user (as doctor)
     */
    public function availabilitySettings()
    {
        return $this->hasMany(DoctorAvailabilitySetting::class, 'doctor_id');
    }

    /**
     * Get appointments created by this user
     */
    public function createdAppointments()
    {
        return $this->hasMany(Appointment::class, 'created_by');
    }

    /**
     * Get consultations created by this user
     */
    public function createdConsultations()
    {
        return $this->hasMany(Consultation::class, 'created_by');
    }
}
