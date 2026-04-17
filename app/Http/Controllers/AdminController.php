<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Rating;
use App\Models\Schedule;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Charts\DoctorCharts;
use App\Charts\PatientCharts;
use App\Charts\AppoinmentsCharts;
use App\Models\Application;
use App\Models\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
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

    //Views  Functions

    public function apply_view()
    {
        $applications = Application::query()
            ->latest()
            ->get();

        return view('panels.admin.doctors-apply')->with(compact('applications'));
    }

    public function doctor_notify_view($id)
    {
        $doctor = Doctor::find($id);
        return view('panels.admin.CRUD.doctor-notify')->with(compact("doctor"));
    }
    public function patient_notify_view($id)
    {

        $patient = Patient::find($id);
        return view('panels.admin.CRUD.patient-notify')->with(compact("patient"));
    }

    public function doctor_details($id)
    {
        $doctor = Doctor::with(['user.address', 'speciality', 'Appointments'])
            ->find($id);
        return view('panels.admin.CRUD.doctor-view')->with(compact("doctor"));
    }
    public function speciality_details($id)
    {

        $speciality = Speciality::find($id);
        return view('panels.admin.CRUD.specialities-view')->with(compact("speciality"));
    }
    public function edit_speciality_view($id)
    {
        $speciality = Speciality::find($id);
        return view('panels.admin.CRUD.specialities-edit')->with(compact("speciality"));
    }
    public function specialities()
    {
        $specialities = Speciality::query()
            ->orderBy('name')
            ->get();
        return view('panels.admin.specialities')->with(compact("specialities"));
    }
    public function patient_details($id)
    {
        $patient = Patient::with(['user.address', 'Appointments'])
            ->find($id);
        return view('panels.admin.CRUD.patient-details')->with(compact("patient"));
    }
    public function appointment_detail($id)
    {
        $appointment = Appointment::with(['doctor.user', 'patient.user', 'schedule'])
            ->find($id);
        return view('panels.admin.CRUD.appointment-detail')->with(compact("appointment"));
    }
    public function appointments()
    {

        $appointments = Appointment::with(['doctor.user', 'patient.user', 'schedule'])
            ->latest('appointment_date')
            ->get();
        return view('panels.admin.appointments')->with(compact("appointments"));
    }
    public function schedules() //schedules function return the schedules page of the admin panel
    {
        $doctors = Doctor::with(['user', 'speciality'])
            ->orderByDesc('id')
            ->get();
        return view('panels.admin.schedules')->with(compact("doctors"));
    }
    public function schedule($id)
    {
        $doctor = Doctor::with(['user', 'schedules'])
            ->find($id);
        if (!$doctor) {
            abort(404);
        }
        $schedule = $doctor->schedules;
        return view('panels.admin.CRUD.doctor-schedule')->with(compact("doctor"))->with(compact("schedule"));
    }
    public function index(Request $request) //index function return the home page for admin panel
    {
        $selectedRange = (int) $request->query('range', 30);
        $allowedRanges = [7, 30, 90];

        if (!in_array($selectedRange, $allowedRanges, true)) {
            $selectedRange = 30;
        }

        $dashboardData = Cache::remember(
            "admin.dashboard.{$selectedRange}",
            now()->addSeconds(45),
            function () use ($selectedRange) {
                $rangeStart = now()->copy()->subDays($selectedRange)->startOfDay();
                $previousRangeStart = now()->copy()->subDays($selectedRange * 2)->startOfDay();
                $previousRangeEnd = now()->copy()->subDays($selectedRange)->startOfDay();

                $totalDoctors = Doctor::count();
                $totalPatients = Patient::count();
                $totalAppointments = Appointment::count();
                $totalSchedules = Schedule::count();

                $appointmentsCurrentRange = Appointment::where('created_at', '>=', $rangeStart)->count();
                $appointmentsPreviousRange = Appointment::whereBetween('created_at', [$previousRangeStart, $previousRangeEnd])->count();
                $appointmentsGrowth = null;

                if ($appointmentsPreviousRange > 0) {
                    $appointmentsGrowth = round((($appointmentsCurrentRange - $appointmentsPreviousRange) / $appointmentsPreviousRange) * 100, 1);
                } elseif ($appointmentsCurrentRange > 0) {
                    $appointmentsGrowth = 100;
                }

                $appointmentsStatusCounts = Appointment::query()
                    ->selectRaw('status, COUNT(*) as total')
                    ->groupBy('status')
                    ->orderBy('status')
                    ->pluck('total', 'status')
                    ->toArray();

                $normalizedStatusCounts = collect($appointmentsStatusCounts)
                    ->mapWithKeys(function ($count, $status) {
                        return [strtolower((string) $status) => (int) $count];
                    })
                    ->toArray();

                $approvedAppointments = (int) ($normalizedStatusCounts['approved'] ?? 0);
                $pendingAppointments = (int) ($normalizedStatusCounts['pending'] ?? 0);
                $cancelledAppointments = (int) (($normalizedStatusCounts['cancelled'] ?? 0) + ($normalizedStatusCounts['canceled'] ?? 0));
                $otherAppointments = max(0, $totalAppointments - ($approvedAppointments + $pendingAppointments + $cancelledAppointments));

                $todayAppointments = Appointment::whereDate('appointment_date', now()->toDateString())->count();
                $upcomingWeekAppointments = Appointment::whereBetween('appointment_date', [
                    now()->toDateString(),
                    now()->copy()->addDays(7)->toDateString(),
                ])->count();

                $newDoctorsInRange = Doctor::where('created_at', '>=', $rangeStart)->count();
                $newPatientsInRange = Patient::where('created_at', '>=', $rangeStart)->count();

                $pendingApplications = Application::where('status', 'pending')->count();
                $approvedApplications = Application::where('status', 'approved')->count();
                $rejectedApplications = Application::where('status', 'rejected')->count();

                $activeDoctors = Doctor::where('status', 'active')->count();
                $averageRating = round((float) (Rating::avg('rating') ?? 0), 1);

                $openScheduleSlots = Schedule::where(function ($query) {
                    $query->where('status', 'false')
                        ->orWhere('status', false)
                        ->orWhere('status', '0')
                        ->orWhere('status', 0);
                })->count();

                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();

                $weeklyAppointmentsMap = Appointment::whereBetween('appointment_date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
                    ->selectRaw('appointment_date, COUNT(*) as total')
                    ->groupBy('appointment_date')
                    ->pluck('total', 'appointment_date');

                $weeklyAppointments = collect(range(0, 6))->map(function ($offset) use ($startOfWeek, $weeklyAppointmentsMap) {
                    $date = $startOfWeek->copy()->addDays($offset);

                    return [
                        'label' => $date->format('D'),
                        'date' => $date->toDateString(),
                        'count' => (int) ($weeklyAppointmentsMap[$date->toDateString()] ?? 0),
                    ];
                });

                $doctorCreatedByDate = Doctor::query()
                    ->selectRaw('DATE(created_at) as date_key, COUNT(*) as total')
                    ->groupBy('date_key')
                    ->orderBy('date_key')
                    ->pluck('total', 'date_key')
                    ->toArray();

                $patientCreatedByDate = Patient::query()
                    ->selectRaw('DATE(created_at) as date_key, COUNT(*) as total')
                    ->groupBy('date_key')
                    ->orderBy('date_key')
                    ->pluck('total', 'date_key')
                    ->toArray();

                $appointmentCreatedByDate = Appointment::query()
                    ->selectRaw('DATE(created_at) as date_key, COUNT(*) as total')
                    ->groupBy('date_key')
                    ->orderBy('date_key')
                    ->pluck('total', 'date_key')
                    ->toArray();

                $maleDoctorCount = User::where('gender', 'male')->where('user_type', 'doctor')->count();
                $femaleDoctorCount = User::where('gender', 'female')->where('user_type', 'doctor')->count();
                $malePatientCount = User::where('gender', 'male')->where('user_type', 'patient')->count();
                $femalePatientCount = User::where('gender', 'female')->where('user_type', 'patient')->count();

                return [
                    'totalDoctors' => $totalDoctors,
                    'totalPatients' => $totalPatients,
                    'totalAppointments' => $totalAppointments,
                    'totalSchedules' => $totalSchedules,
                    'appointmentsCurrentRange' => $appointmentsCurrentRange,
                    'appointmentsGrowth' => $appointmentsGrowth,
                    'approvedAppointments' => $approvedAppointments,
                    'pendingAppointments' => $pendingAppointments,
                    'cancelledAppointments' => $cancelledAppointments,
                    'otherAppointments' => $otherAppointments,
                    'todayAppointments' => $todayAppointments,
                    'upcomingWeekAppointments' => $upcomingWeekAppointments,
                    'newDoctorsInRange' => $newDoctorsInRange,
                    'newPatientsInRange' => $newPatientsInRange,
                    'pendingApplications' => $pendingApplications,
                    'approvedApplications' => $approvedApplications,
                    'rejectedApplications' => $rejectedApplications,
                    'activeDoctors' => $activeDoctors,
                    'averageRating' => $averageRating,
                    'openScheduleSlots' => $openScheduleSlots,
                    'weeklyAppointments' => $weeklyAppointments,
                    'doctorCreatedByDate' => $doctorCreatedByDate,
                    'patientCreatedByDate' => $patientCreatedByDate,
                    'appointmentCreatedByDate' => $appointmentCreatedByDate,
                    'appointmentStatusCounts' => $appointmentsStatusCounts,
                    'maleDoctorCount' => $maleDoctorCount,
                    'femaleDoctorCount' => $femaleDoctorCount,
                    'malePatientCount' => $malePatientCount,
                    'femalePatientCount' => $femalePatientCount,
                ];
            }
        );

        $unreadAdminNotifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        $recentAppointments = Appointment::with(['doctor.user', 'patient.user', 'schedule'])
            ->latest('appointment_date')
            ->latest('created_at')
            ->take(8)
            ->get();

        $topRatedDoctors = Doctor::with(['user', 'speciality'])
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->orderByDesc('ratings_count')
            ->take(5)
            ->get();

        $specialityLoad = Speciality::withCount('doctors')
            ->orderByDesc('doctors_count')
            ->take(5)
            ->get();

        $maxSpecialityDoctors = max(1, (int) $specialityLoad->max('doctors_count'));

        $Doctor_Chart_Created_At = new DoctorCharts;
        $Doctor_Chart_Created_At->labels(array_keys($dashboardData['doctorCreatedByDate']));
        $Doctor_Chart_Created_At->dataset('Number Of Doctors', 'bar', array_values($dashboardData['doctorCreatedByDate']))
            ->backgroundColor('#3B82F6');

        $gender_chart = new DoctorCharts;
        $gender_chart->labels(['Male', 'Female']);
        $gender_chart->dataset('Number Of Doctors by Gender', 'doughnut', [
            $dashboardData['maleDoctorCount'],
            $dashboardData['femaleDoctorCount'],
        ])->backgroundColor(['#3B82F6', '#FF00CC']);

        $Patient_Chart_Created_At = new PatientCharts;
        $Patient_Chart_Created_At->labels(array_keys($dashboardData['patientCreatedByDate']));
        $Patient_Chart_Created_At->dataset('Number Of Patient', 'bar', array_values($dashboardData['patientCreatedByDate']))
            ->backgroundColor('#3B82F6');

        $patient_gender_chart = new PatientCharts;
        $patient_gender_chart->labels(['Male', 'Female']);
        $patient_gender_chart->dataset('Number Of Patients by Gender', 'doughnut', [
            $dashboardData['malePatientCount'],
            $dashboardData['femalePatientCount'],
        ])->backgroundColor(['#3B82F6', '#FF00CC']);

        $Appointments_Chart_Created_At = new AppoinmentsCharts;
        $Appointments_Chart_Created_At->labels(array_keys($dashboardData['appointmentCreatedByDate']));
        $Appointments_Chart_Created_At->dataset('Number Of Patient', 'bar', array_values($dashboardData['appointmentCreatedByDate']))
            ->backgroundColor('#3B82F6');

        $Appointments_Chart_Status = new AppoinmentsCharts;
        $Appointments_Chart_Status->labels(array_keys($dashboardData['appointmentStatusCounts']));
        $Appointments_Chart_Status->dataset('Number Of Appointments by Status', 'doughnut', array_values($dashboardData['appointmentStatusCounts']))
            ->backgroundColor(['#3B82F6', '#34D399', '#F87171', '#A78BFA', '#FBBF24']);

        return view('panels.admin.index', [
            'Appointments_Chart_Status' => $Appointments_Chart_Status,
            'Appointments_Chart_Created_At' => $Appointments_Chart_Created_At,
            'patient_gender_chart' => $patient_gender_chart,
            'Patient_Chart_Created_At' => $Patient_Chart_Created_At,
            'gender_chart' => $gender_chart,
            'Doctor_Chart_Created_At' => $Doctor_Chart_Created_At,
            'shedulesCount' => $dashboardData['totalSchedules'],
            'doctorsCount' => $dashboardData['totalDoctors'],
            'patientsCount' => $dashboardData['totalPatients'],
            'appointmentsCount' => $dashboardData['totalAppointments'],
            'selectedRange' => $selectedRange,
            'allowedRanges' => $allowedRanges,
            'appointmentsCurrentRange' => $dashboardData['appointmentsCurrentRange'],
            'appointmentsGrowth' => $dashboardData['appointmentsGrowth'],
            'approvedAppointments' => $dashboardData['approvedAppointments'],
            'pendingAppointments' => $dashboardData['pendingAppointments'],
            'cancelledAppointments' => $dashboardData['cancelledAppointments'],
            'otherAppointments' => $dashboardData['otherAppointments'],
            'todayAppointments' => $dashboardData['todayAppointments'],
            'upcomingWeekAppointments' => $dashboardData['upcomingWeekAppointments'],
            'newDoctorsInRange' => $dashboardData['newDoctorsInRange'],
            'newPatientsInRange' => $dashboardData['newPatientsInRange'],
            'pendingApplications' => $dashboardData['pendingApplications'],
            'approvedApplications' => $dashboardData['approvedApplications'],
            'rejectedApplications' => $dashboardData['rejectedApplications'],
            'activeDoctors' => $dashboardData['activeDoctors'],
            'averageRating' => $dashboardData['averageRating'],
            'unreadAdminNotifications' => $unreadAdminNotifications,
            'openScheduleSlots' => $dashboardData['openScheduleSlots'],
            'recentAppointments' => $recentAppointments,
            'topRatedDoctors' => $topRatedDoctors,
            'specialityLoad' => $specialityLoad,
            'maxSpecialityDoctors' => $maxSpecialityDoctors,
            'weeklyAppointments' => $dashboardData['weeklyAppointments'],
        ]);
    }

    public function doctor() //doctor function return the doctor page for admin panel
    {
        $specialities = Speciality::query()
            ->orderBy('name')
            ->get();

        $doctors = Doctor::with(['user.address', 'speciality'])
            ->withCount('Appointments')
            ->orderByDesc('id')
            ->get();

        return view('panels.admin.doctor')->with('doctors', $doctors)->with('specialities', $specialities);
    }

    public function patient()
    {
        $patients = Patient::with(['user.address'])
            ->withCount('Appointments')
            ->orderByDesc('id')
            ->get();

        return view('panels.admin.patient')->with(compact("patients"));
    }

    public function edit_doctor_view($id)
    {
        $specialities = Speciality::query()
            ->orderBy('name')
            ->get();
        $doctor = Doctor::with(['user.address', 'speciality'])
            ->where("id", $id)
            ->first();

        return view('panels.admin.CRUD.doctor-edit')->with('doctor', $doctor)->with('specialities', $specialities);
    }
    public function edit_patient_view($id)
    {
        $patient = Patient::with(['user.address'])
            ->where("id", $id)
            ->first();

        return view('panels.admin.CRUD.patient-edit')->with('patient', $patient);
    }

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
    // Operations Functions




    public function cancel_appointment($id)
    {
        $appointment = Appointment::find($id);
        if ($appointment) {
            $appointment->update(['status' => 'Cancelled']);
            $appointment->save();
            sendSupportEmail([
                'to' => $appointment->patient->user->email,
                'subject' => 'Appointment Canceled',
                'content' => 'Your appointment [#' . $appointment->id . '] has been Canceled. Please find the details below:',
                'contactLink' => route('patiens.my.appointments', $appointment->patient->id),
                'contactText' => 'My Appointments',
                'phoneNumber' => '+1234567890',
            ]);
            return redirect()->back()->with('success', 'Appointment Canceled !!');
        } else {
            return redirect()->back()->with('error', 'Appointment Not Found !!');
        }
    }
    public function approve_appointment($id)
    {
        $appointment = Appointment::find($id);
        if ($appointment) {
            $appointment->update(['status' => 'Approved']);
            $appointment->save();
            sendSupportEmail([
                'to' => $appointment->patient->user->email,
                'subject' => 'Appointment Approved',
                'content' => 'Your appointment [#' . $appointment->id . '] has been Approved. Please find the details below:',
                'contactLink' => route('patiens.my.appointments', $appointment->patient->id),
                'contactText' => 'My Appointments',
                'phoneNumber' => '+1234567890',
            ]);
            return redirect()->back()->with('success', 'Appointment Approved !!');
        } else {
            return redirect()->back()->with('error', 'Appointment Not Found !!');
        }
    }
    public function getDoctorSchedules(Request $request)
    {
        // Validate the request...
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        // Get the doctor's schedules...
        $doctor = Doctor::find($request->doctor_id);
        $schedules = $doctor->schedules;

        // Format the schedules...
        $formattedSchedules = $schedules->map(function ($schedule) {
            return [
                'day' => $schedule->day,
                'start' => substr($schedule->start, 0, 5), // Remove the seconds from the time
            ];
        });

        // Return the schedules as a JSON response...
        return response()->json([
            'schedules' => $formattedSchedules,
        ]);
    }
    public function getDoctors()
    {
        $doctors = Doctor::with('user', 'speciality')->get();
        return response()->json($doctors);
    }
    public function approveApplication(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $application->status = 'approved';

        // Generate a unique registration token
        $application->registration_token = Str::random(60);

        // Set token expiry time (e.g., 24 hours)
        $application->token_expiry = now()->addHours(24);

        $application->save();

        $link = url('/doctor/register/' . $application->registration_token);
        // Send support email with the registration link containing the token
        sendSupportEmail([
            'to' => $application->email,
            'content' => 'Your application for the doctor position has been approved. [#' . $application->id . ']. Click the link below to register as a doctor. Thank you for showing interest.',
            'contactLink' => $link,
            'contactText' => 'Register as a doctor',
            'phoneNumber' => '+1234567890',
        ]);


        return response()->json(['message' => 'Application approved successfully']);
    }


    public function rejectApplication(Request $request, $id)
    {
        $application = Application::find($id);
        $application->status = 'rejected';
        $application->save();

        // Send support email
        sendSupportEmail([
            'to' => $application->email,
            'content' => 'We regret to inform you that your application for the doctor position has been rejected. [#' . $application->id . ']. Thank you for showing interest.',
            'contactLink' => 'https://example.com/contact',
            'contactText' => 'Contact us',
            'phoneNumber' => '+1234567890',
        ]);

        return response()->json(['message' => 'Application rejected successfully']);
    }

    public function delete_application($id)
    {
        $application = Application::findOrFail($id);
        $application->delete();

        return response()->json(['message' => 'Application deleted successfully']);
    }

    // CRUD Functions

    public function doctor_notify(Request $request, $id)
    {
        $OriginalTitle = $request->input('title');
        $title = $request->input('title');

        $OriginalMessage = $request->input('message');
        $message = $request->input('message');

        if (!empty($title) && !empty($message)) {
            if ($this->isXssAttackDetected([$OriginalTitle, $OriginalMessage], [$title, $message])) {
                return redirect()->back()->with('error', 'XSS or SQL Injection attack detected. Please provide valid input.');
            }
        }
        // Validate input data
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Find the patient
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return redirect()->back()->with('error', 'Patient Not Found !!');
        }

        // Create the notification
        $notification = Notification::create([
            'user_id' => $doctor->user->id,
            'title' => $request->input('title'),
            'message' => $request->input('message'), // Sanitize the message content
        ]);

        // Handle success
        return redirect()->back()->with('success', 'Notification Sent !!');
    }
    public function patient_notify(Request $request, $id)
    {
        $OriginalTitle = $request->input('title');
        $title = $request->input('title');

        $OriginalMessage = $request->input('message');
        $message = $request->input('message');

        if (!empty($title) && !empty($message)) {
            if ($this->isXssAttackDetected([$OriginalTitle, $OriginalMessage], [$title, $message])) {
                return redirect()->back()->with('error', 'XSS or SQL Injection attack detected. Please provide valid input.');
            }
        }
        // Validate input data
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Find the patient
        $patient = Patient::find($id);
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient Not Found !!');
        }

        // Create the notification
        $notification = Notification::create([
            'user_id' => $patient->user->id,
            'title' => $request->input('title'),
            'message' => $request->input('message'), // Sanitize the message content
        ]);

        // Handle success
        return redirect()->back()->with('success', 'Notification Sent !!');
    }

    public function uploadProfilePicture(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
        ]);

        // Retrieve the authenticated user
        $user = authUser()->user;

        // Store the uploaded image
        $imagePath = $request->file('img')->store('profile_pictures', 'public');

        // Update the user's profile picture path in the database
        $user->img = $imagePath;
        $user->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Profile picture uploaded successfully.');
    }

    public function edit_speciality(Request $request, $id)
    {
        $speciality = Speciality::find($id);
        if (!$speciality) {
            return redirect()->back()->with('error', 'Speciality Not Found !!');
        }
        $OriginalName = $request->input('speciality');

        $name = htmlspecialchars($request->input('speciality'));
        if (!empty($name)) {
            if ($this->isXssAttackDetected([$OriginalName], [$name])) {
                return redirect()->back()->with('error', 'XSS or SQL Injection attack detected. Please provide valid input.');
            }
        }
        $rules = [
            'speciality' => 'required|unique:specialities,name',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $speciality->update(['name' => $name]);
            $speciality->save();
        }

        return redirect()->back()->with('success', 'Speciality Edited Successfully');
    }
    public function add_speciality(Request $request)
    {
        $OriginalName = $request->input('speciality');

        $name = htmlspecialchars($request->input('speciality'));

        if (!empty($name)) {
            if ($this->isXssAttackDetected([$OriginalName], [$name])) {
                return redirect()->back()->with('error', 'XSS or SQL Injection attack detected. Please provide valid input.');
            }
        }

        $rules = [
            'speciality' => 'required|unique:specialities,name',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            Speciality::create(['name' => $name]);
        }

        return redirect()->back()->with('success', 'Speciality Added Successfully');
    }
    public function delete_speciality($id)
    {
        $speciality = Speciality::find($id);
        if ($speciality) {
            if (count($speciality->doctors) > 0) {
                return redirect()->back()->with('error', 'Speciality is Used By Some Doctors !!');
            }
            $speciality->delete();
            return redirect()->back()->with('success', 'Speciality Deleted Successfully');
        } else {
            return redirect()->back()->with('error', 'Speciality Not Found');
        }
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
            Log::error('Admin schedule creation failed', [
                'doctor_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Unable to save schedule right now.');
        }
    }



    public function edit_doctor(Request $request, $id)
    {

        $originalName = $request->input('nom');
        $originalVille = $request->input('city');
        $originalRue = $request->input('rue');
        $originalEmail = $request->input('email');
        $originalDegree = $request->input('degree');
        $originalSpeciality = $request->input('speciality');

        $name = htmlspecialchars($request->input('nom'));
        $birthdate = $request->input('birthdate');
        $ville = htmlspecialchars($request->input('city'));
        $rue = htmlspecialchars($request->input('rue'));
        $email = htmlspecialchars($request->input('email'));
        $phone = htmlspecialchars($request->input('phone'));
        $gender = $request->input('gender');
        $degree = htmlspecialchars($request->input('degree'));
        $speciality = htmlspecialchars($request->input('speciality'));
        $password = $request->input('password');

        if (!empty($name) && !empty($birthdate) && !empty($ville) && !empty($rue) && !empty($email) && !empty($phone) && !empty($gender) && !empty($degree) && !empty($speciality)) {
            if ($this->isXssAttackDetected([$originalName, $originalVille, $originalRue, $originalEmail, $originalDegree, $originalSpeciality], [$name, $ville, $rue, $email, $degree, $speciality])) {
                return redirect()->back()->with('error', 'XSS or SQL Injection attack detected. Please provide valid input.');
            }
        }


        $rules = [
            'nom' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'city' => 'required|string|max:255',
            'rue' => 'required|string|max:255',
            'email' => 'required|email|',
            'phone' => [
                'required',
                'string',
                'regex:/^(06|05)\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2}$/',
            ],
            'gender' => 'required',
            'degree' => 'required|string|max:255',
            'speciality' => 'required|string|max:255',
        ];
        if (!empty($password)) {
            // Validate password if it's not empty
            $rules['password'] = 'required|string|min:8';
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $doctor = Doctor::find($id);
            // Update the address
            $address = Address::find($doctor->user->address->id);
            if ($address) {
                $address->update([
                    'ville' => $ville,
                    'rue' => $rue,
                ]);

                // Update the user
                $user = User::find($doctor->user->id);
                if ($user) {
                    $user->update([
                        'name' => $name,
                        'email' => $email,
                        'gender' => $gender,
                        'phone' => $phone,
                    ]);
                    if (!empty($password)) {
                        $user->update([
                            'password' => Hash::make($password),
                        ]);
                    }
                    if ($doctor) {
                        $doctor->update([
                            'birth_date' => $birthdate,
                            'degree' => $degree,
                            'specialty_id' => $speciality,
                        ]);

                        return redirect()->route('admin.doctor')->with('success', 'Doctor updated successfully.');
                    } else {
                        return redirect()->back()->with('error', 'Doctor not found.');
                    }
                } else {
                    return redirect()->back()->with('error', 'User not found.');
                }
            } else {
                return redirect()->back()->with('error', 'Address not found.');
            }
        }
    }
    public function edit_patient(Request $request, $id)
    {
        // Sanitize Inputs
        $originalName = $request->input('nom');
        $originalBirthdate = $request->input('birthdate');
        $originalVille = $request->input('city');
        $originalRue = $request->input('rue');
        $originalEmail = $request->input('email');
        $originalPhone = $request->input('phone');
        $originalGender = $request->input('gender');
        $originalCin = $request->input('cin');

        $name = htmlspecialchars($originalName);
        $birthdate = htmlspecialchars($originalBirthdate);
        $ville = htmlspecialchars($originalVille);
        $rue = htmlspecialchars($originalRue);
        $email = htmlspecialchars($originalEmail);
        $phone = htmlspecialchars($originalPhone);
        $gender = htmlspecialchars($originalGender);
        $cin = htmlspecialchars($originalCin);
        $password = $request->input('password');

        if ($this->isXssAttackDetected([$originalName, $originalVille, $originalRue, $originalEmail, $originalCin], [$name, $ville, $rue, $email, $cin])) {
            return redirect()->back()->with('error', 'XSS or SQL Injection attack detected. Please provide valid input.');
        }
        $rules = [
            'nom' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'city' => 'required|string|max:255',
            'rue' => 'required|string|max:255',
            'email' => 'required|email|',
            'phone' => [
                'required',
                'string',
                'regex:/^(06|05)\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2}$/',
            ],
            'gender' => 'required',
            'cin' => 'required|string|max:255',
        ];
        if (!empty($password)) {
            // Validate password if it's not empty
            $rules['password'] = 'required|string|min:8';
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $patient = Patient::find($id);
            // Update the address
            $address = Address::find($patient->user->address->id);
            if ($address) {
                $address->update([
                    'ville' => $ville,
                    'rue' => $rue,
                ]);

                // Update the user
                $user = User::find($patient->user->id);
                if ($user) {
                    $user->update([
                        'name' => $name,
                        'email' => $email,
                        'gender' => $gender,
                        'phone' => $phone,
                    ]);
                    if (!empty($password)) {
                        $user->update([
                            'password' => Hash::make($password),
                        ]);
                    }
                    if ($patient) {
                        $patient->update([
                            'birth_date' => $birthdate,
                            'cin' => $cin,
                        ]);

                        return redirect()->route('admin.patient')->with('success', 'Patient updated successfully.');
                    } else {
                        return redirect()->back()->with('error', 'Patient not found.');
                    }
                } else {
                    return redirect()->back()->with('error', 'User not found.');
                }
            } else {
                return redirect()->back()->with('error', 'Address not found.');
            }
        }
    }
    public function delete_doctor($id)
    {
        $doctor = Doctor::find($id);
        if ($doctor) {
            $user = $doctor->user;
            $address = $user->address;
            $schedules = Schedule::where('doctor_id', $doctor->id)->get();

            if ($schedules->isNotEmpty()) { // Check if there are schedules to delete
                $schedules->each->delete(); // Delete each schedule
            }

            $doctor->delete();
            if ($user) {
                $user->delete();

                if ($address) {
                    $address->delete();
                }
            }
            return redirect()->route('admin.doctor')->with('success', 'Doctor deleted successfully.');
        }
    }

    public function delete_patient($id)
    {
        $patient = Patient::find($id);
        if ($patient) {

            $user = User::find($patient->user->id);
            $address = Address::find($patient->user->address->id);
            $patient->delete();
            if ($user) {
                $user->delete();

                if ($address) {
                    $address->delete();
                }
            }
            return redirect()->route('admin.patient')->with('success', 'Doctor deleted successfully.');
        } else {
            return redirect()->route('admin.patient')->with('error', 'Patient not found.');
        }
    }
    public function add_doctor(Request $request)
    {
        $originalName = $request->input('nom');
        $originalVille = $request->input('city');
        $originalRue = $request->input('rue');
        $originalEmail = $request->input('email');
        $originalDegree = $request->input('degree');
        $originalSpeciality = $request->input('speciality');


        $name = htmlspecialchars($request->input('nom'));
        $birthdate = $request->input('birthdate');
        $ville = htmlspecialchars($request->input('city'));
        $rue = htmlspecialchars($request->input('rue'));
        $email = htmlspecialchars($request->input('email'));
        $password = htmlspecialchars($request->input('password'));
        $phone = htmlspecialchars($request->input('phone'));
        $gender = $request->input('gender');
        $degree = htmlspecialchars($request->input('degree'));
        $speciality = htmlspecialchars($request->input('speciality'));

        if (!empty($name) && !empty($birthdate) && !empty($ville) && !empty($rue) && !empty($email) && !empty($phone) && !empty($gender) && !empty($degree) && !empty($speciality)) {
            if (
                $this->isXssAttackDetected(
                    [$originalName, $originalVille, $originalRue, $originalEmail, $originalDegree, $originalSpeciality],
                    [$name, $ville, $rue, $email, $degree, $speciality]
                )
            ) {
                return redirect()->back()->with('error', 'XSS or SQL Injection attack detected. Please provide valid input.');
            }
        }

        $rules = [
            'nom' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'city' => 'required|string|max:255',
            'rue' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => [
                'required',
                'string',
                'regex:/^(06|05)\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2}$/',
            ],
            'gender' => 'required',
            'degree' => 'required|string|max:255',
            'speciality' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            // Create the Address
            $address = Address::create([
                'ville' => $ville,
                'rue' => $rue,
            ]);
            if ($address) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'user_type' => 'doctor',
                    'gender' => $gender,
                    'phone' => $phone,
                    'address_id' => $address->id,
                ]);

                if ($user) {
                    $doctor = Doctor::create([
                        'user_id' => $user->id,
                        'birth_date' => $birthdate,
                        'degree' => $degree,
                        'specialty_id' => $speciality,
                        'status' => 'active',
                    ]);
                    if ($doctor) {
                        return redirect()->back()->with('success', 'Doctor created successfully.');
                    } else {
                        $user->delete();
                        $address->delete();
                        return redirect()->back()->with('error', 'Error creating the doctor record. Please try again.');
                    }
                } else {
                    $address->delete();
                    return redirect()->back()->with('error', 'Error creating the user. Please try again.');
                }
            } else {
                return redirect()->back()->with('error', 'Error creating the address. Please try again.');
            }
        }
    }


    public function add_patient(Request $request)
    {
        // Sanitize Inputs
        $originalName = $request->input('nom');
        $originalBirthdate = $request->input('birthdate');
        $originalVille = $request->input('city');
        $originalRue = $request->input('rue');
        $originalEmail = $request->input('email');
        $originalPassword = $request->input('password');
        $originalPhone = $request->input('phone');
        $originalGender = $request->input('gender');
        $originalCin = $request->input('cin');

        $name = htmlspecialchars($originalName);
        $birthdate = htmlspecialchars($originalBirthdate);
        $ville = htmlspecialchars($originalVille);
        $rue = htmlspecialchars($originalRue);
        $email = htmlspecialchars($originalEmail);
        $password = htmlspecialchars($originalPassword);
        $phone = htmlspecialchars($originalPhone);
        $gender = htmlspecialchars($originalGender);
        $cin = htmlspecialchars($originalCin);

        // Check for XSS Attacks
        if (!empty($name) && !empty($ville) && !empty($rue) && !empty($email) && !empty($cin) && !empty($password) && !empty($phone) && !empty($gender)) {
            if ($this->isXssAttackDetected([$originalName, $originalVille, $originalRue, $originalEmail, $originalCin], [$name, $ville, $rue, $email, $cin])) {
                return redirect()->back()->with('error', 'XSS or SQL Injection attack detected. Please provide valid input.');
            }
        }
        // Validation Rules
        $rules = [
            'nom' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'city' => 'required|string|max:255',
            'rue' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => [
                'required',
                'string',
                'regex:/^(06|05)\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2}$/',
            ],
            'gender' => 'required',
            'cin' => 'required|string|max:255',
        ];

        // Validate Inputs
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            // Create the Address
            $address = Address::create([
                'ville' => $ville,
                'rue' => $rue,
            ]);
            if ($address) {
                // Create the User
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'user_type' => 'patient',
                    'gender' => $gender,
                    'phone' => $phone,
                    'address_id' => $address->id,
                ]);

                if ($user) {
                    // Create the Patient
                    $patient = Patient::create([
                        'user_id' => $user->id,
                        'birth_date' => $birthdate,
                        'cin' => $cin,
                    ]);
                    if ($patient) {
                        return redirect()->back()->with('success', 'Patient created successfully.');
                    } else {
                        // Rollback operations if creating patient fails
                        $user->delete();
                        $address->delete();
                        return redirect()->back()->with('error', 'Error creating the Patient record. Please try again.');
                    }
                } else {
                    // Rollback operations if creating user fails
                    $address->delete();
                    return redirect()->back()->with('error', 'Error creating the user. Please try again.');
                }
            } else {
                return redirect()->back()->with('error', 'Error creating the address. Please try again.');
            }
        }
    }


    // PDF Functions

    // public function export_doctors_pdf()
    // {
    //     $doctors = Doctor::all();
    //     $pdf = Pdf::loadView('pdf.doctors-table-pdf', ['doctors' => $doctors]);
    //     return $pdf->download('doctors.pdf');
    //     //return $pdf->stream();
    // }
    public function export_doctors_pdf()
    {
        $doctors = Doctor::all();
        $pdf = PDF::loadView('pdf.doctors-table-pdf', ['doctors' => $doctors]);

        // Set headers for streaming
        return response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="doctors.pdf"',
        ]);
    }
    public function export_patients_pdf()
    {
        $patients = Patient::all();
        $pdf = PDF::loadView('pdf.patients-table-pdf', ['patients' => $patients]);

        // Set headers for streaming
        return response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="patients.pdf"',
        ]);
    }
}
