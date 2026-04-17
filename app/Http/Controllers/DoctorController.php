<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Rating;
use App\Models\Schedule;
use App\Models\Speciality;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    private function currentDoctor(): Doctor
    {
        $doctor = Auth::user()?->doctor;

        abort_if(!$doctor, 403, 'Unauthorized action.');

        return $doctor;
    }

    private function findDoctorScheduleOrFail(int $id, Doctor $doctor): Schedule
    {
        return Schedule::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();
    }

    private function findDoctorAppointmentOrFail(int $id, Doctor $doctor): Appointment
    {
        return Appointment::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();
    }

    private function ensurePatientBelongsToDoctor(Patient $patient, Doctor $doctor): void
    {
        $isLinked = Appointment::where('doctor_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->exists();

        abort_if(!$isLinked, 403, 'Unauthorized action.');
    }

    public function index()
    {
        $doctor = $this->currentDoctor();

        $appointments = $doctor->appointments;
        $schedule = $doctor->schedules;

        $patientIds = $appointments->pluck('patient_id')->unique();
        $patients = Patient::whereIn('id', $patientIds)->get();

        $upcommingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', '>', Carbon::today())
            ->get();

        $recentVisits = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', '<', Carbon::today())
            ->where('status', 'Approved')
            ->get();

        $ratings = Rating::where('doctor_id', $doctor->id)->get();

        return view('panels.doctor.index')
            ->with('appointments', $appointments)
            ->with('schedule', $schedule)
            ->with('patients', $patients)
            ->with('upcommingAppointments', $upcommingAppointments)
            ->with('recentVisits', $recentVisits)
            ->with('ratings', $ratings);
    }

    public function appointments()
    {
        $doctor = $this->currentDoctor();

        $appointments = $doctor->appointments;

        return view('panels.doctor.appointments')->with(compact('appointments'));
    }

    public function schedule()
    {
        $doctor = $this->currentDoctor();
        $schedule = $doctor->schedules;

        return view('panels.doctor.schedule')->with(compact('schedule'))->with('doctor', $doctor);
    }

    public function editSchedule($id)
    {
        $doctor = $this->currentDoctor();
        $schedule = $this->findDoctorScheduleOrFail((int) $id, $doctor);

        return view('panels.doctor.CRUD.edit_schedule')->with(compact('schedule'));
    }

    public function editAppointmentView($id)
    {
        $doctor = $this->currentDoctor();
        $appointment = $this->findDoctorAppointmentOrFail((int) $id, $doctor);

        return view('panels.doctor.CRUD.edit_appointment')->with(compact('appointment'));
    }

    public function mypatients()
    {
        $doctor = $this->currentDoctor();

        $patientIds = $doctor->appointments->pluck('patient_id')->unique();

        $patients = Patient::whereIn('id', $patientIds)->get();
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->whereIn('patient_id', $patientIds)
            ->get();

        return view('panels.doctor.mypatients', with(compact('patients', 'appointments')));
    }

    public function patientView($id)
    {
        $doctor = $this->currentDoctor();
        $patient = Patient::findOrFail((int) $id);

        $this->ensurePatientBelongsToDoctor($patient, $doctor);

        $appointments = Appointment::where('patient_id', $patient->id)
            ->where('doctor_id', $doctor->id)
            ->get();

        return view('panels.doctor.CRUD.patient_view')->with(compact('patient'))->with(compact('appointments'));
    }

    public function bookAppointmentView($id)
    {
        $doctor = $this->currentDoctor();
        $patient = Patient::findOrFail((int) $id);

        $this->ensurePatientBelongsToDoctor($patient, $doctor);

        $doctors = Doctor::where('id', $doctor->id)->get();
        $specialities = Speciality::all();
        $schedules = Schedule::where('doctor_id', $doctor->id)
            ->where('status', 'false')
            ->get();

        return view('panels.doctor.CRUD.patient_book')
            ->with(compact('patient'))
            ->with(compact('specialities'))
            ->with(compact('schedules'))
            ->with(compact('doctors'));
    }

    public function appointmentDetails($id)
    {
        $doctor = $this->currentDoctor();
        $appointment = $this->findDoctorAppointmentOrFail((int) $id, $doctor);
        $patient = Patient::findOrFail($appointment->patient_id);

        return view('panels.doctor.CRUD.appointment_details')->with(compact('appointment'))->with(compact('patient'));
    }

    public function reviews()
    {
        $doctor = $this->currentDoctor();
        $ratings = Rating::where('doctor_id', $doctor->id)->get();

        return view('panels.doctor.reviews')->with(compact('ratings'));
    }

    public function deleteSchedule($id)
    {
        $doctor = $this->currentDoctor();
        $schedule = $this->findDoctorScheduleOrFail((int) $id, $doctor);

        Appointment::where('schedule_id', $schedule->id)
            ->where('doctor_id', $doctor->id)
            ->delete();

        $schedule->delete();

        return redirect()->back()->with('success', 'Schedule deleted successfully.');
    }

    public function updateSchedule(Request $request, $id)
    {
        $doctor = $this->currentDoctor();
        $schedule = $this->findDoctorScheduleOrFail((int) $id, $doctor);

        $validator = Validator::make(
            $request->all(),
            [
                'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
            ],
            [
                'day.required' => 'Please select a day.',
                'day.in' => 'Invalid day selected.',
                'start_time.required' => 'Please enter a start time.',
                'end_time.required' => 'Please enter an end time.',
                'end_time.after' => 'End time must be after start time.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $schedule->day = ucfirst(strtolower($request->input('day')));
        $schedule->start = $request->input('start_time');
        $schedule->end = $request->input('end_time');
        $schedule->save();

        return redirect()->route('doctor.schedule')->with('success', 'Schedule updated successfully.');
    }

    public function getAppointmentDetails($id)
    {
        $doctor = $this->currentDoctor();
        $appointment = $this->findDoctorAppointmentOrFail((int) $id, $doctor);

        $data = [
            'id' => $appointment->id,
            'title' => $appointment->patient->user->name,
            'start' => $appointment->appointment_date,
            'extendedProps' => [
                'patientName' => $appointment->patient->user->name,
                'appointmentDate' => $appointment->appointment_date,
                'reason' => $appointment->reason,
                'doctorName' => $appointment->doctor->user->name,
            ],
        ];

        return response()->json($data);
    }

    public function updateAppointment(Request $request, $id)
    {
        $doctor = $this->currentDoctor();
        $appointment = $this->findDoctorAppointmentOrFail((int) $id, $doctor);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Pending,Approved,Cancelled,Expired',
            'doctor_comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $appointment->status = ucfirst(strtolower($request->input('status')));
        $appointment->doctor_comment = $request->input('doctor_comment');
        $appointment->save();

        return redirect()->route('doctor.appointments')->with('success', 'Appointment updated successfully.');
    }

    public function getSchedules()
    {
        $doctor = $this->currentDoctor();

        $schedules = Schedule::where('doctor_id', $doctor->id)->get();

        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        $events = [];

        foreach ($schedules as $schedule) {
            $startTime = Carbon::parse($schedule->start);
            $endTime = Carbon::parse($schedule->end);
            $currentDate = clone $startDate;

            while ($currentDate->lte($endDate)) {
                if ($currentDate->englishDayOfWeek == $schedule->day) {
                    $events[] = [
                        'id' => $schedule->id,
                        'title' => 'Available',
                        'start' => $currentDate->copy()->setTime($startTime->hour, $startTime->minute)->toDateTimeString(),
                        'end' => $currentDate->copy()->setTime($endTime->hour, $endTime->minute)->toDateTimeString(),
                    ];
                }

                $currentDate->addDay();
            }
        }

        return response()->json($events);
    }

    public function add_schedule(Request $request, $id)
    {
        $doctor = $this->currentDoctor();

        abort_if((int) $id !== (int) $doctor->id, 403, 'Unauthorized action.');

        try {
            $validatedData = $request->validate([
                'start_times' => 'nullable|array',
                'start_times.*' => 'nullable|array',
                'start_times.*.*' => 'nullable|date_format:H:i',
            ]);

            if (empty($validatedData['start_times'])) {
                return redirect()->back()->with('error', 'Please select at least one time slot.');
            }

            foreach ($validatedData['start_times'] as $day => $startTimes) {
                if (!$startTimes) {
                    continue;
                }

                foreach ($startTimes as $startTime) {
                    $existingSchedule = Schedule::where('doctor_id', $doctor->id)
                        ->where('day', ucfirst($day))
                        ->where('start', $startTime)
                        ->exists();

                    if ($existingSchedule) {
                        return redirect()->back()->with('error', 'Schedule already exists.');
                    }

                    $schedule = new Schedule();
                    $schedule->start = $startTime;
                    $schedule->end = date('H:i', strtotime('+30 minutes', strtotime($startTime)));
                    $schedule->day = ucfirst($day);
                    $schedule->doctor_id = $doctor->id;
                    $schedule->status = 'false';
                    $schedule->save();
                }
            }

            return redirect()->back()->with('success', 'Schedule saved successfully.');
        } catch (\Throwable $e) {
            Log::error('Doctor schedule creation failed', [
                'doctor_id' => $doctor->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Unable to save schedule right now.');
        }
    }

    public function book(Request $request, $P_ID)
    {
        $doctor = $this->currentDoctor();
        $patient = Patient::findOrFail((int) $P_ID);

        $this->ensurePatientBelongsToDoctor($patient, $doctor);

        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:255',
            'appointment_datee' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|integer|exists:schedules,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('doctor.CRUD.patient.book', ['id' => $P_ID])
                ->withErrors($validator)
                ->withInput();
        }

        $schedule = Schedule::where('id', $request->input('appointment_time'))
            ->where('doctor_id', $doctor->id)
            ->first();

        if (!$schedule || $schedule->status !== 'false') {
            return redirect()->route('doctor.CRUD.patient.book', ['id' => $P_ID])
                ->with('error', 'Selected time slot is not available.');
        }

        $appointmentDate = Carbon::parse($request->input('appointment_datee'));

        if ($appointmentDate->format('l') !== $schedule->day) {
            return redirect()->route('doctor.CRUD.patient.book', ['id' => $P_ID])
                ->with('error', 'Selected date does not match the chosen schedule day.');
        }

        DB::transaction(function () use ($request, $doctor, $patient, $schedule) {
            Appointment::create([
                'reason' => $request->input('reason'),
                'appointment_date' => $request->input('appointment_datee'),
                'schedule_id' => $schedule->id,
                'doctor_id' => $doctor->id,
                'doctor_comment' => 'none',
                'patient_id' => $patient->id,
                'status' => 'Pending',
            ]);

            $schedule->update(['status' => 'true']);
        });

        return redirect()->route('doctor.mypatients')->with('success', 'Appointment booked successfully.');
    }

    public function getAvailableHours(Request $request)
    {
        $doctor = $this->currentDoctor();

        $validated = $request->validate([
            'date' => 'required|date',
        ]);

        $dayOfWeek = Carbon::parse($validated['date'])->format('l');

        $availableHours = Schedule::where('day', $dayOfWeek)
            ->where('doctor_id', $doctor->id)
            ->where('status', 'false')
            ->select('id', 'start')
            ->get();

        return response()->json($availableHours);
    }

    public function getAppointments(Request $request)
    {
        $doctor = $this->currentDoctor();

        $validated = $request->validate([
            'date' => 'required|date',
        ]);

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $validated['date'])
            ->get();

        return response()->json($appointments);
    }

    public function getAppointmentsForCalendar(Request $request)
    {
        $doctor = $this->currentDoctor();
        $appointments = Appointment::where('doctor_id', $doctor->id)->get();

        return response()->json($appointments);
    }
}
