<?php

// app/Http/Middleware/CheckAppointment.php

namespace App\Http\Middleware\Checkers;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class CheckAppointment
{
    public function handle(Request $request, Closure $next)
    {
        // Get the authenticated patient
        $authenticatedPatient = authUser()->patient;

        // Get the appointment
        $appointment = Appointment::find($request->id);

        // Check if the appointment exists
        if (!$appointment) {
            abort(404);
        }

        // Check if the appointment belongs to the authenticated patient
        if ($appointment->patient_id != $authenticatedPatient->id) {
            abort(404);
        }

        return $next($request);
    }
}
