<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Speciality;
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

    // views Functions
    public function index()
    {
        $appointments = Auth::user()->patient->Appointments;
        return view('panels.patient.index')->with(compact('appointments'));
    }

    public function doctors()
    {
        $specialities = Speciality::all();
        $doctors = Doctor::all();
        return view('panels.patient.doctors')->with(compact('doctors'))->with(compact('specialities'));
    }
    public function appointment(Request $request, $id)
    {
        $doctor = Doctor::find($id);
        $schedule = $doctor->schedules;
        return view('panels.patient.appointment')->with(compact('schedule'))->with(compact('doctor'));
    }

    //Operation Functions

    public function allDoctors()
    {
        $doctors = Doctor::with(['user.address', 'speciality'])->get();
        return response()->json($doctors);
    }

    public function filterDoctors(Request $request)
    {
        // Validate and sanitize inputs
        $specialityId = $request->input('speciality_id', null);
        $city = $request->input('city', null);

        // Prepare the query
        $doctorsQuery = Doctor::with('user.address', 'speciality');

        // Apply filters
        if ($specialityId) {
            $doctorsQuery->whereHas('speciality', function ($query) use ($specialityId) {
                $query->where('id', $specialityId);
            });
        }

        if ($city) {
            // Sanitize the city input to remove potentially harmful characters
            $sanitizedCity = filter_var($city, FILTER_SANITIZE_STRING);

            // Apply the city filter using parameterized query to prevent SQL injection
            $doctorsQuery->whereHas('user.address', function ($query) use ($sanitizedCity) {
                $query->where('ville', 'like', "%{$sanitizedCity}%");
            });
        }

        // Execute the query
        $doctors = $doctorsQuery->get();

        // Return the result
        return response()->json($doctors);
    }






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

    public function getAppointments(Request $request, $id)
    {
        // Retrieve the date from the request
        $date = $request->input('date');

        // Retrieve appointments for the specified doctor and date
        $appointments = Appointment::where('doctor_id', $id)
            ->whereDate('appointment_date', $date)
            ->get();

        // Return appointments as JSON response
        return response()->json($appointments);
    }



    // CRUD Functions

    public function bookAppointment(Request $request, $D_ID, $P_ID)
    {
        $reason_for_appointment = $request->input('reason_for_appointment');
        $appointment_date = $request->input('appointment_date');
        $schedule_id = $request->input('appointment_time');

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
            'schedule_id' => $schedule_id, // Storing the selected schedule ID
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
