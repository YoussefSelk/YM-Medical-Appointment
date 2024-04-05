<?php
// UpdateAppointmentStatus.php

namespace App\Jobs;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateAppointmentStatus implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public function handle()
    {
        Log::info('CheckAppointmentsStatus command started.');
        // Get appointments with 'pending' status and past date
        $appointments = Appointment::where('status', 'Pending')
            ->whereDate('date', '<', Carbon::today())
            ->get();

        // Update status to 'cancelled' for each appointment
        foreach ($appointments as $appointment) {
            $appointment->status = 'cancelled';
            $appointment->save();
        }
        Log::info('CheckAppointmentsStatus command completed successfully.');
    }
}
