<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Notifications\AppointmentBookingNotification;
use App\Notifications\AppointmentConfirmationNotification;
use App\Notifications\AppointmentReminderNotification;
use App\Notifications\AppointmentStatusUpdateNotification;
use App\Notifications\OtpVerificationNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Use database transactions for cleanup
DB::beginTransaction();

try {
    // Test email
    $testEmail = 'andreajamille0402@gmail.com';
    $testPassword = Hash::make('testpass123');

    // Create or find test doctor user with all fields set to satisfy NOT NULL constraints
    $doctorUser = User::where('email', 'testdoctor@iwellcare.com')->first();
    if (! $doctorUser) {
        $doctorUser = User::create([
            'username' => 'testdoctor',
            'email' => 'testdoctor@iwellcare.com',
            'password' => $testPassword,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'middle_name' => '',
            'date_of_birth' => null,
            'gender' => '',
            'phone_number' => '',
            'street_address' => '',
            'city' => '',
            'state_province' => '',
            'postal_code' => '',
            'country' => '',
            'profile_photo' => null,
            'role' => 'doctor',
            'is_active' => true,
        ]);
    }

    // Create doctor record
    $doctor = Doctor::where('user_id', $doctorUser->id)->first();
    if (! $doctor) {
        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'specialization' => 'General Medicine',
            'license_number' => 'LIC123',
            'years_of_experience' => 5,
            'status' => 'active',
            'consultation_fee' => 50.00,
        ]);
    }

    // Create or find test patient user with test email and all fields set to satisfy NOT NULL constraints
    $patientUser = User::where('email', $testEmail)->first();
    if (! $patientUser) {
        $patientUser = User::create([
            'username' => 'testpatient',
            'email' => $testEmail,
            'password' => $testPassword,
            'first_name' => 'Andrea',
            'last_name' => 'Jamille',
            'middle_name' => '',
            'date_of_birth' => null,
            'gender' => '',
            'phone_number' => '',
            'street_address' => '',
            'city' => '',
            'state_province' => '',
            'postal_code' => '',
            'country' => '',
            'profile_photo' => null,
            'role' => 'patient',
            'is_active' => true,
        ]);
    }

    // Create patient record with all fields set to satisfy NOT NULL constraints
    $patient = Patient::where('user_id', $patientUser->id)->first();
    if (! $patient) {
        $patient = Patient::create([
            'user_id' => $patientUser->id,
            'first_name' => 'Andrea',
            'last_name' => 'Jamille',
            'contact' => '',
            'email' => $testEmail,
            'address' => '',
            'date_of_birth' => null,
            'gender' => '',
            'blood_type' => 'O+',
            'emergency_contact' => 'Emergency Contact',
            'emergency_contact_phone' => '1111111111',
            'medical_history' => 'No known allergies',
            'allergies' => 'None',
            'current_medications' => 'None',
            'insurance_provider' => 'None',
            'insurance_number' => 'N/A',
            'is_active' => true,
        ]);
    }

    // Create test appointment with all fields set to satisfy NOT NULL constraints
    $appointment = Appointment::where('patient_id', $patient->id)->where('status', 'pending')->first();
    if (! $appointment) {
        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctorUser->id,
            'appointment_date' => Carbon::tomorrow()->format('Y-m-d'),
            'appointment_time' => '10:00:00',
            'type' => 'consultation',
            'status' => 'pending',
            'notes' => 'Test appointment for email notification testing',
            'symptoms' => '',
            'priority' => 'medium',
            'duration' => 30,
            'room_number' => '',
            'created_by' => null,
            'updated_by' => null,
        ]);
    }

    // Load relations
    $appointment->load('patient', 'doctor');

    echo "Test data created/loaded successfully.\n";
    echo "Sending notifications to: {$testEmail}\n\n";

    // 1. OTP Verification Notification
    echo "1. Sending OTP Verification Notification...\n";
    $otpNotification = new OtpVerificationNotification('123456', 'email_verification');
    $patientUser->notify($otpNotification);
    echo "OTP email sent.\n\n";

    // 2. Appointment Booking Notification
    echo "2. Sending Appointment Booking Notification...\n";
    $bookingNotification = new AppointmentBookingNotification($appointment);
    $patientUser->notify($bookingNotification);
    echo "Booking confirmation email sent.\n\n";

    // 3. Appointment Confirmation Notification
    echo "3. Sending Appointment Confirmation Notification...\n";
    $confirmationNotification = new AppointmentConfirmationNotification($appointment);
    $patientUser->notify($confirmationNotification);
    echo "Confirmation email sent.\n\n";

    // 4. Appointment Reminder Notification
    echo "4. Sending Appointment Reminder Notification...\n";
    $reminderNotification = new AppointmentReminderNotification($appointment);
    $patientUser->notify($reminderNotification);
    echo "Reminder email sent.\n\n";

    // 5. Appointment Status Update Notification (to confirmed)
    echo "5. Sending Appointment Status Update Notification (to confirmed)...\n";
    $statusUpdateNotification = new AppointmentStatusUpdateNotification($appointment, 'pending', 'confirmed');
    $patientUser->notify($statusUpdateNotification);
    echo "Status update (confirmed) email sent.\n\n";

    // Additional status updates for completeness
    echo "6. Sending Appointment Status Update Notification (to completed)...\n";
    $completedNotification = new AppointmentStatusUpdateNotification($appointment, 'confirmed', 'completed');
    $patientUser->notify($completedNotification);
    echo "Status update (completed) email sent.\n\n";

    echo "All email notifications sent successfully to {$testEmail}.\n";
    echo "Note: CustomMailNotification is an abstract base class and not directly testable.\n";
    echo "You can check your inbox/spam folder for the emails.\n";
    echo "Test data will be rolled back.\n";

} catch (Exception $e) {
    echo 'Error: '.$e->getMessage()."\n";
} finally {
    DB::rollBack(); // Clean up test data
}
