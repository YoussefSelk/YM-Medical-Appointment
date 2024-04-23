<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Carbon\Carbon;

class UpdateAppointmentStatus extends Command
{
    protected $signature = 'appointments:update-status';
    protected $description = 'Update status of appointments if date has passed';

    public function handle()
    {
        // Get pending appointments whose date has passed but are not for today
        $appointments = Appointment::where('status', 'Pending')
            ->whereDate('appointment_date', '<=', Carbon::now())
            ->whereDate('appointment_date', '!=', Carbon::today()) // Exclude appointments for today
            ->get();

        // Update status to 'expired'
        foreach ($appointments as $appointment) {
            $appointment->update(['status' => 'expired']);
            sendSupportEmail([
                'to' => $appointment->patient->user->email,
                'subject' => 'Appointment Expired',
                'content' => 'Your appointment has been Expired. Please find the details below:',
                'contactLink' => 'https://example.com/contact',
                'contactText' => 'Contact us',
                'phoneNumber' => '+1234567890',
            ]);
        }

        $this->info('Appointment statuses updated successfully.');
    }
}
