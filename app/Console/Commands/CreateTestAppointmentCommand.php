<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Console\Command;

class CreateTestAppointmentCommand extends Command
{
    protected $signature = 'create:test-appointment';

    protected $description = 'Create a test pending appointment for notification testing';

    public function handle()
    {
        $this->info('Creating a test pending appointment...');

        // Find an existing patient and doctor
        $patient = Patient::first();
        $doctor = User::where('role', 'doctor')->first();

        if (! $patient) {
            $this->error('No patients found in the system!');

            return 1;
        }

        if (! $doctor) {
            $this->error('No doctors found in the system!');

            return 1;
        }

        $this->info('Using patient: '.$patient->first_name.' '.$patient->last_name);
        $this->info('Using doctor: '.$doctor->first_name.' '.$doctor->last_name);

        // Create a test appointment for tomorrow
        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => now()->addDays(1)->format('Y-m-d'),
            'appointment_time' => '14:00:00',
            'reason' => 'Test appointment for notification testing',
            'status' => 'pending',
            'type' => 'consultation',
        ]);

        $this->info('✅ Test appointment created successfully!');
        $this->info('Appointment ID: '.$appointment->id);
        $this->info('Status: '.$appointment->status);
        $this->info('Date: '.$appointment->appointment_date);
        $this->info('Time: '.$appointment->appointment_time);
        $this->info('');
        $this->info('Now you can:');
        $this->info('1. Go to staff appointments page');
        $this->info('2. Click "Approve" on this appointment');
        $this->info('3. Both notifications will be sent automatically');

        return 0;
    }
}
