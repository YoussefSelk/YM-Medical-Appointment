<?php

// app/Console/Commands/CreateTomorrowAppointmentsNotification.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use App\Mail\Support;

class CreateTomorrowAppointmentsNotification extends Command
{
    protected $signature = 'notifications:create-tomorrow-appointments';

    protected $description = 'Create notifications for appointments scheduled for tomorrow';

    public function handle()
    {
        // Get appointments scheduled for tomorrow
        $tomorrow = now()->addDay();
        $appointments = Appointment::whereDate('appointment_date', $tomorrow)->get();

        foreach ($appointments as $appointment) {
            // Check if notification already exists for this appointment ID
            $existingNotification = Notification::where('title', 'like', 'Appointment Reminder id ' . $appointment->id . '%')->exists();

            // If notification already exists, skip creating a new one
            if ($existingNotification) {
                continue;
            }

            // Create notification for the appointment
            $notification = new Notification();
            $notification->user_id = $appointment->patient->user->id;
            $notification->title = 'Appointment Reminder id ' . $appointment->id;
            $notification->message = 'You have an appointment scheduled for tomorrow. Please check your Appointments.';
            $notification->save();

            // Send SMS reminder
            // $this->sendSMSReminder($appointment->patient->user->phone, $notification->message);

            // Send Email reminder
            $this->sendEmailReminder($appointment->patient->user->email, $notification->message, $appointment);
        }

        $this->info('Notifications created successfully for appointments scheduled for tomorrow.');
    }

    // Send email reminder method
    // Send email reminder method
    protected function sendEmailReminder($email, $message, $appointment)
    {
        $data = [
            'content' => $message,
            'contactLink' => '#', // Your contact link
            'contactText' => 'Contact Us',
            'phoneNumber' => '123-456-7890', // Your phone number
        ];

        Mail::to($email)->send(new Support($data));
    }

}
