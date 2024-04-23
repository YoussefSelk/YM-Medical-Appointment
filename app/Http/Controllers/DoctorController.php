<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DoctorController extends Controller
{
    //Views's Functions

    public function index()
    {
        $appointments = Auth::user()->doctor->Appointments;
        $schedule = Auth::user()->doctor->schedules;

        return view('panels.doctor.index')->with('appointments', $appointments)->with('schedule', $schedule);
    }

    public function appointments()
    {

        $appointments = Auth::user()->doctor->Appointments;
        return view('panels.doctor.appointments')->with(compact('appointments'));
    }

    public function schedule()
    {
        $doctor = Auth::user()->doctor;
        $schedule = Auth::user()->doctor->schedules;
        return view('panels.doctor.schedule')->with(compact('schedule'))->with('doctor', $doctor);
    }

    public function editSchedule($id)
    {

        $schedule = Schedule::find($id);

        if (!$schedule) {
            abort(404);
        }

        return view('panels.doctor.CRUD.edit_schedule')->with(compact('schedule'));
    }

    public function editAppointmentView($id)
    {

        $appointment = Appointment::find($id);

        if (!$appointment) {
            abort(404);
        }

        return view('panels.doctor.CRUD.edit_appointment')->with(compact('appointment'));
    }

    public function mypatients(){

        $patientIds = Auth::user()->doctor->Appointments->pluck('patient_id')->unique();

        $patients = Patient::whereIn('id', $patientIds)->get();
        $appointments = Appointment::whereIn('patient_id', $patientIds)->get();

        return view('panels.doctor.mypatients', with(compact('patients', 'appointments')));

    }

    public function patientView($id){

        $patient = Patient::find($id);
        $appointments = Appointment::where('patient_id', $id)->get();
        return view('panels.doctor.CRUD.patient_view')->with(compact('patient'))->with(compact('appointments'));
    }


    public function bookAppointmentView($id){
        $doctors = Doctor::all();
        $patient = Patient::find($id);
        $specialities = Speciality::all();
        $schedules = Schedule::all();
        return view('panels.doctor.CRUD.patient_book')->with(compact('patient'))->with(compact('specialities'))->with(compact('schedules'))
        ->with(compact('doctors'));
    }



    //Operations's Functions

    public function deleteSchedule($id)
    {
        // Find the schedule by its ID
        $schedule = Schedule::find($id);

        // If the schedule doesn't exist, redirect back with an error message
        if (!$schedule) {
            return redirect()->back()->with('error', 'Schedule not found.');
        }

        $appointments = Appointment::where('schedule_id', $id)->get();
        if ($appointments) {
            foreach ($appointments as $appointment) {
                $appointment->delete();
            }
        }

        // Delete the schedule
        $schedule->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Schedule deleted successfully.');
    }

    public function updateSchedule(Request $request, $id)
    {
        $schedule = Schedule::find($id);
        if (!$schedule) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
        'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
    ], [
        'day.required' => 'Please select a day.',
        'day.in' => 'Invalid day selected.',
        'start_time.required' => 'Please enter a start time.',

        'end_time.required' => 'Please enter an end time.',
        'end_time.date_format' => 'Invalid end time format. ',
        'end_time.after' => 'End time must be after start time.',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $schedule->day = ucfirst(strtolower($request->input('day')));
        $schedule->start = $request->input('start_time');
        $schedule->end = $request->input('end_time');
        $schedule->save();
        return redirect()->route('doctor.schedule')->with('success', 'Schedule updated successfully.');
    }




    public function getAppointmentDetails($id)
    {
        $appointment = Appointment::findOrFail($id);

        $data = [
            'id' => $appointment->id,
            'title' => $appointment->patient->user->name,
            'start' => $appointment->appointment_date,
            'extendedProps' => [
                'patientName' => $appointment->patient->user->name,
                'appointmentDate' => $appointment->appointment_date,
                'reason' => $appointment->reason,
                'doctorName' => $appointment->doctor->user->name,
            ]
        ];

        return response()->json($data);
    }




    public function updateAppointment(Request $request, $id)
    {

        $appointment = Appointment::find($id);
        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found.');
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Pending,Completed,Cancelled,Expired',
            'doctor_comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $appointment->status = ucfirst(strtolower($request->input('status')));
        $appointment->doctor_comment = $request->input('doctor_comment');
        $appointment->save();

        return redirect()->route('doctor.appointments')->with('success', 'Appointment updated successfully.');
    }

    public function getSchedules()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        // Retrieve all schedules for the doctor with the given ID
        $schedules = Schedule::where('doctor_id', $doctor->id)->get();

        // Get the start and end of the current week
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        // Transform the schedule data into the format expected by FullCalendar
        $events = [];
        foreach ($schedules as $schedule) {
            // Parse the start and end times for the current schedule
            $startTime = Carbon::parse($schedule->start);
            $endTime = Carbon::parse($schedule->end);

            // Get the current date (Monday) and iterate through each day of the week
            $currentDate = clone $startDate;

            while ($currentDate->lte($endDate)) {
                // Check if the current date matches the schedule day
                if ($currentDate->englishDayOfWeek == $schedule->day) {
                    // Assign the schedule to the current day of the week
                    $events[] = [
                        'id' => $schedule->id,
                        'title' => 'Available', // Customize as needed
                        'start' => $currentDate->copy()->setTime($startTime->hour, $startTime->minute)->toDateTimeString(),
                        'end' => $currentDate->copy()->setTime($endTime->hour, $endTime->minute)->toDateTimeString(),
                    ];
                }

                // Move to the next day
                $currentDate->addDay();
            }
        }

        // Return the events as a JSON response
        return response()->json($events);
    }

    public function add_schedule(Request $request, $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'start_times' => 'nullable|array', // Validate 'start_times' as array
                'start_times.*' => 'nullable|array', // Each item inside 'start_times' should be an array
                'start_times.*.*' => 'nullable|date_format:H:i', // Validate as time format (HH:MM)
            ]);

            // Check if 'start_times' is empty
            if (empty($validatedData['start_times'])) {
                return redirect()->back()->with('error', 'Please select at least one time slot.');
            }

            // Iterate through the submitted data and store in the database
            foreach ($validatedData['start_times'] as $day => $startTimes) {
                if ($startTimes) { // Check if there are start times for this day
                    foreach ($startTimes as $startTime) {
                        // Check if there's an existing record with the same doctor_id, day, and start time
                        $existingSchedule = Schedule::where('doctor_id', $id)
                            ->where('day', ucfirst($day))
                            ->where('start', $startTime)
                            ->exists();

                        // If there's no existing record, then insert the new schedule
                        if (!$existingSchedule) {
                            // Create a new Schedule instance
                            $schedule = new Schedule();
                            $schedule->start = $startTime;

                            // Set the end time to 30 minutes later than the start time
                            $schedule->end = date('H:i', strtotime('+30 minutes', strtotime($startTime)));

                            $schedule->day = ucfirst($day); // Capitalize the day name
                            $schedule->doctor_id = $id;
                            $schedule->status = 'false';
                            $schedule->save();
                        } else {
                            return redirect()->back()->with('error', 'Schedule already Exist');
                        }
                    }
                }
            }

            // Redirect back or do whatever you want after saving
            return redirect()->back()->with('success', 'Schedule saved successfully');
        } catch (\Exception $e) {
            // Log or display the error message
            dd($e->getMessage());
        }
    }



    public function book(Request $request, $P_ID)
    {
        $reason_for_appointment = $request->input('reason');
        $appointment_date = $request->input('appointment_datee');
        $schedule_id = $request->input('appointment_time');
        $doctor_id = $request->input('doctor_id');

        // Validating form inputs
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:255',
            'appointment_datee' => 'required|date',
            'appointment_time' => 'required|exists:schedules,id', // Ensure the selected schedule ID exists in the database
        ]);

        if ($validator->fails()) {
            return redirect()->route('doctor.CRUD.patient.book',['id' => $P_ID])->with('error', 'Appointment booking failed');
        }

        // Creating the appointment
        $appointment = Appointment::create([
            'reason' => $reason_for_appointment,
            'appointment_date' => $appointment_date,
            'schedule_id' => $schedule_id, // Storing the selected schedule ID
            'doctor_id' => $doctor_id,
            'doctor_comment' => 'none',
            'patient_id' => $P_ID,
            'status' => 'Pending',
        ]);

        // If appointment is successfully created
        if ($appointment) {
            // Update the schedule to mark the booked time slot as unavailable
            $schedule = Schedule::find($schedule_id);
            if ($schedule) {
                $schedule->update(['status' => 'true']);
            }
            return redirect()->route('doctor.mypatients')->with('success', 'Appointment booked successfully');
        } else {
            return redirect()->route('doctor.CRUD.patient.book')->with('error', 'Appointment booking failed');
        }
    }



    public function getAvailableHours(Request $request )
    {
        // Retrieve the date from the request
        $date = $request->input('date');
        $doctor_id = $request->input('doctor_id');
        // Convert the date to day of the week (e.g., Monday, Tuesday)
        $dayOfWeek = Carbon::parse($date)->format('l');

        // Retrieve available hours for the selected date and day of the week
        $availableHours = Schedule::where('day', $dayOfWeek)
            ->where('doctor_id', $doctor_id)
            ->where('status', 'false')
            ->select('id', 'start') // Selecting both ID and start time
            ->get();

        // Return the available hours as JSON response
        return response()->json($availableHours);

    }

    public function getAppointments(Request $request)
    {
        // Retrieve the date from the request
        $date = $request->input('date');
        $doctor_id = $request->input('doctor_id');
        // Retrieve appointments for the specified doctor and date
        $appointments = Appointment::where('doctor_id', $doctor_id)
            ->whereDate('appointment_date', $date)
            ->get();

        // Return appointments as JSON response
        return response()->json($appointments);

    }




}
