<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;

class CheckAppointmentsCommand extends Command
{
    protected $signature = 'check:appointments';

    protected $description = 'Check current appointment statuses';

    public function handle()
    {
        $this->info('Current Appointments:');
        $this->info('==================');

        $appointments = Appointment::with(['patient', 'doctor'])->get();

        if ($appointments->isEmpty()) {
            $this->warn('No appointments found.');

            return;
        }

        foreach ($appointments as $appointment) {
            $patientName = $appointment->patient ?
                ($appointment->patient->first_name.' '.$appointment->patient->last_name) : 'N/A';
            $doctorName = $appointment->doctor ?
                ('Dr. '.$appointment->doctor->first_name.' '.$appointment->doctor->last_name) : 'N/A';

            $this->line(sprintf(
                'ID: %d | Status: %s | Patient: %s | Doctor: %s',
                $appointment->id,
                strtoupper($appointment->status),
                $patientName,
                $doctorName
            ));
        }

        $this->info('');
        $this->info('Summary:');
        $this->info('Pending: '.$appointments->where('status', 'pending')->count());
        $this->info('Confirmed: '.$appointments->where('status', 'confirmed')->count());
        $this->info('Completed: '.$appointments->where('status', 'completed')->count());
        $this->info('Total: '.$appointments->count());
    }
}
