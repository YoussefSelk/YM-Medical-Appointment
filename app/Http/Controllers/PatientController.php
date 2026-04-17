<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Rating;
use App\Models\Schedule;
use App\Models\Speciality;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    private function currentPatient(): Patient
    {
        $patient = Auth::user()?->patient;

        abort_if(!$patient, 403, 'Unauthorized action.');

        return $patient;
    }

    private function ensureOwnPatientId(int $patientId): Patient
    {
        $patient = $this->currentPatient();

        abort_if($patient->id !== $patientId, 403, 'Unauthorized action.');

        return $patient;
    }

    private function findOwnedAppointmentOrFail(int $appointmentId, Patient $patient): Appointment
    {
        return Appointment::where('id', $appointmentId)
            ->where('patient_id', $patient->id)
            ->firstOrFail();
    }

    public function index()
    {
        $patient = $this->currentPatient();
        $appointments = $patient->appointments;

        return view('panels.patient.index')->with(compact('appointments'));
    }

    public function doctors()
    {
        $specialities = Speciality::all();
        $doctors = Doctor::orderByDesc('avg_rating')->get();

        return view('panels.patient.doctors')->with(compact('doctors', 'specialities'));
    }

    public function appointment(Request $request, $id)
    {
        $doctor = Doctor::with('schedules')->findOrFail((int) $id);
        $schedule = $doctor->schedules;

        return view('panels.patient.appointment')->with(compact('schedule', 'doctor'));
    }

    public function patient_appointments($id)
    {
        $patient = $this->ensureOwnPatientId((int) $id);
        $appointments = Appointment::where('patient_id', $patient->id)->get();

        return view('panels.patient.my_appointments')->with(compact('appointments'));
    }

    public function appointment_detail($id)
    {
        $patient = $this->currentPatient();
        $appointment = $this->findOwnedAppointmentOrFail((int) $id, $patient);

        return view('panels.patient.CRUD.my_appointment-view')->with(compact('appointment'));
    }

    public function getTips()
    {
        $apiKey = config('services.newsapi.key');

        if (empty($apiKey)) {
            return back()->withError('Health tips are temporarily unavailable.');
        }

        $response = Http::timeout(10)->get('https://newsapi.org/v2/top-headlines', [
            'apiKey' => $apiKey,
            'country' => 'us',
            'category' => 'health',
            'pageSize' => 50,
        ]);

        if (!$response->successful()) {
            return back()->withError('Failed to fetch health tips. Please try again later.');
        }

        $healthTips = collect($response->json('articles', []))->map(function ($article) {
            $imageUrl = $article['urlToImage'] ?? null;
            $articleUrl = $article['url'] ?? null;

            if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                $article['urlToImage'] = 'https://via.placeholder.com/150';
            } else {
                $article['urlToImage'] = $imageUrl;
            }

            if (!filter_var($articleUrl, FILTER_VALIDATE_URL)) {
                $article['url'] = '#';
            }

            return $article;
        });

        return view('panels.patient.health_tips', compact('healthTips'));
    }

    public function cancel_appointment($id)
    {
        $patient = $this->currentPatient();
        $appointment = $this->findOwnedAppointmentOrFail((int) $id, $patient);

        $appointment->update(['status' => 'Cancelled']);

        return redirect()->back()->with('success', 'Appointment canceled.');
    }

    public function allDoctors()
    {
        $doctors = Doctor::with(['user.address', 'speciality'])
            ->orderByDesc('avg_rating')
            ->get();

        return response()->json($doctors);
    }

    public function filterDoctors(Request $request)
    {
        $specialityId = $request->input('speciality_id');
        $city = $request->input('city');
        $name = $request->input('name');

        $doctorsQuery = Doctor::with('user.address', 'speciality');

        if ($specialityId) {
            $doctorsQuery->whereHas('speciality', function ($query) use ($specialityId) {
                $query->where('id', $specialityId);
            });
        }

        if ($city) {
            $sanitizedCity = trim(strip_tags((string) $city));

            $doctorsQuery->whereHas('user.address', function ($query) use ($sanitizedCity) {
                $query->where('ville', 'like', "%{$sanitizedCity}%");
            });
        }

        if ($name) {
            $sanitizedName = trim(strip_tags((string) $name));

            $doctorsQuery->whereHas('user', function ($query) use ($sanitizedName) {
                $query->where('name', 'like', "%{$sanitizedName}%");
            });
        }

        $doctors = $doctorsQuery->get();

        return response()->json($doctors);
    }

    public function getAvailableHours(Request $request, $id)
    {
        $request->validate([
            'date' => ['required', 'date'],
        ]);

        $doctor = Doctor::findOrFail((int) $id);
        $dayOfWeek = Carbon::parse($request->input('date'))->format('l');

        $availableHours = Schedule::where('day', $dayOfWeek)
            ->where('doctor_id', $doctor->id)
            ->where('status', 'false')
            ->select('id', 'start')
            ->get();

        return response()->json($availableHours);
    }

    public function getAppointments(Request $request, $id)
    {
        $request->validate([
            'date' => ['required', 'date'],
        ]);

        $doctor = Doctor::findOrFail((int) $id);

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $request->input('date'))
            ->get();

        return response()->json($appointments);
    }

    public function downloadPDF_Appointment($id)
    {
        $patient = $this->currentPatient();
        $appointment = $this->findOwnedAppointmentOrFail((int) $id, $patient);

        $pdf = Pdf::loadView('pdf.appointment-details', compact('appointment'));

        return $pdf->download('appointment_details.pdf');
    }

    public function rateDoctor(Request $request, $doctorId, $patientId)
    {
        $patient = $this->ensureOwnPatientId((int) $patientId);
        $doctor = Doctor::findOrFail((int) $doctorId);

        $validatedData = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:255',
        ]);

        $hasAppointmentWithDoctor = Appointment::where('doctor_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->where('status', 'Approved')
            ->exists();

        if (!$hasAppointmentWithDoctor) {
            return redirect()->back()->with('error', 'You can rate only doctors you had approved appointments with.');
        }

        Rating::updateOrCreate(
            [
                'doctor_id' => $doctor->id,
                'patient_id' => $patient->id,
            ],
            [
                'rating' => $validatedData['rating'],
                'comment' => $validatedData['comment'] ?? null,
            ]
        );

        $doctor->avg_rating = (float) Rating::where('doctor_id', $doctor->id)->avg('rating');
        $doctor->save();

        return redirect()->back()->with('success', 'Rating submitted successfully');
    }

    public function bookAppointment(Request $request, $D_ID, $P_ID)
    {
        $patient = $this->ensureOwnPatientId((int) $P_ID);
        $doctor = Doctor::findOrFail((int) $D_ID);

        $validator = Validator::make($request->all(), [
            'reason_for_appointment' => 'required|string|max:255',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|integer|exists:schedules,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $schedule = Schedule::where('id', $request->input('appointment_time'))
            ->where('doctor_id', $doctor->id)
            ->first();

        if (!$schedule || $schedule->status !== 'false') {
            return redirect()->back()->with('error', 'Selected time slot is unavailable.');
        }

        $appointmentDate = Carbon::parse($request->input('appointment_date'));

        if ($appointmentDate->format('l') !== $schedule->day) {
            return redirect()->back()->with('error', 'Selected date does not match the chosen schedule day.');
        }

        $appointment = DB::transaction(function () use ($request, $doctor, $patient, $schedule) {
            $createdAppointment = Appointment::create([
                'reason' => $request->input('reason_for_appointment'),
                'appointment_date' => $request->input('appointment_date'),
                'schedule_id' => $schedule->id,
                'doctor_id' => $doctor->id,
                'doctor_comment' => 'none',
                'patient_id' => $patient->id,
                'status' => 'Pending',
            ]);

            $schedule->update(['status' => 'true']);

            return $createdAppointment;
        });

        sendSupportEmail([
            'to' => $appointment->patient->user->email,
            'subject' => 'Appointment Confirmation',
            'content' => 'Your appointment has been successfully booked. Please find the details below:',
            'contactLink' => route('patiens.my.appointments', $patient->id),
            'contactText' => 'My Appointments',
            'phoneNumber' => '+1234567890',
        ]);

        return redirect()->back()->with('success', 'Appointment booked successfully');
    }
}
