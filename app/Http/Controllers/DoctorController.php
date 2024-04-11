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
class DoctorController extends Controller
{
    //Views's Functions
    public function index()
    {
        $appointments=Auth::user()->doctor->Appointments;
        $schedule = Auth::user()->doctor->schedules;

        return view('panels.doctor.index')->with('appointments',$appointments)->with('schedule',$schedule);
    }

    public function appointments(){

        $appointments = Auth::user()->doctor->Appointments;
        return view('panels.doctor.appointments')->with(compact('appointments'));
    }

    public function schedule(){

        $schedule = Auth::user()->doctor->schedules;
        return view('panels.doctor.schedule')->with(compact('schedule'));

    }

    public function editSchedule($id){

        $schedule = Schedule::find($id);

        if (!$schedule) {
            abort(404);
        }

        return view('panels.doctor.CRUD.edit_schedule')->with(compact('schedule'));
    }

    public function editAppointmentView($id){

        $appointment = Appointment::find($id);

        if (!$appointment) {
            abort(404);
        }

        return view('panels.doctor.CRUD.edit_appointment')->with(compact('appointment'));

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
        'end_time.date_format' => 'Invalid end time format. Please use HH:MM format.',
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


//     public function updateSchedule(Request $request, $id)
// {
//     try {
//         // Validate the request data
//         $validatedData = $request->validate([
//             'start_times' => 'nullable|array', // Validate 'start_times' as array
//             'start_times.*' => 'nullable|array', // Each item inside 'start_times' should be an array
//             'start_times.*.*' => 'nullable|date_format:H:i', // Validate as time format (HH:MM)
//         ]);

//         // Check if 'start_times' is empty
//         if (empty($validatedData['start_times'])) {
//             return redirect()->back()->with('error', 'Please select at least one time slot.');
//         }

//         // Iterate through the submitted data and update the database
//         foreach ($validatedData['start_times'] as $day => $startTimes) {
//             if ($startTimes) { // Check if there are start times for this day
//                 foreach ($startTimes as $startTime) {
//                     // Find the existing schedule record to update
//                     $existingSchedule = Schedule::where('doctor_id', $id)
//                         ->where('day', ucfirst($day))
//                         ->where('start', $startTime)
//                         ->first();

//                     // If the existing record exists, update the schedule
//                     if ($existingSchedule) {
//                         // Update the start and end times of the existing schedule
//                         $existingSchedule->start = $startTime;
//                         $existingSchedule->end = date('H:i', strtotime('+30 minutes', strtotime($startTime)));
//                         $existingSchedule->save();
//                     } else {
//                         return redirect()->back()->with('error', 'Schedule not found');
//                     }
//                 }
//             }
//         }

//         // Redirect back or do whatever you want after updating
//         return redirect()->back()->with('success', 'Schedule updated successfully');
//     } catch (\Exception $e) {
//         // Log or display the error message
//         dd($e->getMessage());
//     }
// }


    public function updateAppointment(Request $request, $id){

        $appointment = Appointment::find($id);
        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found.');
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Pending,Confirmed,Cancelled,Expired',
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


}
