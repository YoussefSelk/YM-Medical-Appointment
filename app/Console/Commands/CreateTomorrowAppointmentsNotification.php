<?php

// app/Console/Commands/CreateTomorrowAppointmentsNotification.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Support\Facades\Http;

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
            // $this->sendSMSReminder($appointment->patient->user->phone, $notification->message);
        }

        $this->info('Notifications created successfully for appointments scheduled for tomorrow.');
    }
    // Method to send SMS reminder using Twilio
    // private function sendSMSReminder($phoneNumber, $message)
    // {
    //     $accountSid = 'AC402467f45b5d33645deceffaa242bdea';
    //     $authToken = '3bcdff66e55eb3573788f70a2e2539d2';
    //     $twilioNumber = '+12513062666';

    //     $response = Http::withBasicAuth($accountSid, $authToken)
    //         ->post("https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Messages.json", [
    //             'From' => $twilioNumber,
    //             'To' => $phoneNumber,
    //             'Body' => $message,
    //         ]);

    //     if ($response->successful()) {
    //         // SMS sent successfully
    //         return true;
    //     } else {
    //         // Handle error
    //         $errorMessage = $response->json()['message'] ?? 'Unknown error occurred';

    //         return false;
    //     }
    // }
}
