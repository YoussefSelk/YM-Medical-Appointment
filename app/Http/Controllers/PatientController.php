<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class PatientController extends Controller
{
    //XSS Attacks Functions

    private function isXssAttackDetected(array $originalInputs, array $sanitizedInputs): bool
    {
        foreach ($originalInputs as $index => $originalInput) {
            if ($originalInput !== $sanitizedInputs[$index]) {
                return true;
            }
        }
        return false;
    }

    //
    public function index()
    {
        $appointments = Auth::user()->patient->Appointments;
        return view('panels.patient.index')->with(compact('appointments'));
    }

    public function doctors()
    {

        $doctors = Doctor::all();
        return view('panels.patient.doctors')->with(compact('doctors'));
    }
    public function appointment(Request $request, $id)
    {
        $doctor = Doctor::find($id);
        $schedule = $doctor->schedules;
        return view('panels.patient.appointment')->with(compact('schedule'))->with(compact('doctor'));
    }

    //Operation Functions

    public function getAvailableHours(Request $request, $id)
    {
        // Retrieve the date from the request
        $date = $request->input('date');

        // Convert the date to day of the week (e.g., Monday, Tuesday)
        $dayOfWeek = Carbon::parse($date)->format('l');

        // Retrieve available hours for the selected date and day of the week
        $availableHours = Schedule::where('day', $dayOfWeek)
            ->where('doctor_id', $id)
            ->where('status', 'false')
            ->select('id', 'start') // Selecting both ID and start time
            ->get();

        // Return the available hours as JSON response
        return response()->json($availableHours);
    }


    // CRUD Functions

    public function bookAppointment(Request $request, $D_ID, $P_ID)
    {
        $reason_for_appointment = $request->input('reason_for_appointment');
        $appointment_date = $request->input('appointment_date');
        $appointment_time = $request->input('appointment_time');

        // Validating form inputs
        $validator = Validator::make($request->all(), [
            'reason_for_appointment' => 'required|string|max:255',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|exists:schedules,id', // Ensure the selected schedule ID exists in the database
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Creating the appointment
        $appointment = Appointment::create([
            'reason' => $reason_for_appointment,
            'appointment_date' => $appointment_date,
            'schedule_id' => $appointment_time, // Storing the selected schedule ID
            'doctor_id' => $D_ID,
            'doctor_comment' => 'none',
            'patient_id' => $P_ID,
            'status' => 'Pending',
        ]);

        if ($appointment) {
            return redirect()->back()->with('success', 'Appointment booked successfully');
        } else {
            return redirect()->back()->with('error', 'Appointment booking failed');
        }
    }
}
