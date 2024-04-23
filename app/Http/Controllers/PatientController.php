<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Speciality;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Facades\Location;
use Geocoder\Provider\OpenStreetMap\OpenStreetMap;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;
use Geocoder\Provider\Nominatim\Nominatim;

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
        $doctors = Doctor::orderByDesc('avg_rating')->get();
        return view('panels.patient.doctors')->with(compact('doctors'))->with(compact('specialities'));
    }
    public function appointment(Request $request, $id)
    {
        $doctor = Doctor::find($id);
        $schedule = $doctor->schedules;
        return view('panels.patient.appointment')->with(compact('schedule'))->with(compact('doctor'));
    }
    public function patient_appointments($id)
    {
        $appointments = Appointment::where('patient_id', $id)->get();
        return view('panels.patient.my_appointments')->with(compact('appointments'));
    }

    public function appointment_detail($id)
    {
        $appointment = Appointment::find($id);
        return view('panels.patient.CRUD.my_appointment-view')->with(compact('appointment'));
    }

    //Operation Functions

    public function getTips()
    {
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'apiKey' => '9d4f0f76580e49e7b654623b3837ddd3',
            'country' => 'us', // Fetch global health tips
            'category' => 'health',
            'pageSize' => 50,
        ]);

        if ($response->successful()) {
            $healthTips = $response->json();
            $healthTips = collect($healthTips['articles'])->map(function ($article) {
                if (!isset ($article['urlToImage']) || empty ($article['urlToImage'])) {
                    $article['urlToImage'] = 'https://via.placeholder.com/150'; // Default image
                }
                return $article;
            });

            return view('panels.patient.health_tips', compact('healthTips'));
        } else {
            return back()->withError('Failed to fetch health tips. Please try again later.');
        }
    }








    public function cancel_appointment($id)
    {
        $appointment = Appointment::find($id);
        if ($appointment) {
            $appointment->update(['status' => 'Cancelled']);
            $appointment->save();
            return redirect()->back()->with('success', 'Appointment Canceled !!');
        } else {
            return redirect()->back()->with('error', 'Appointment Not Found !!');
        }
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
        // Validate and sanitize inputs
        $specialityId = $request->input('speciality_id', null);
        $city = $request->input('city', null);
        $name = $request->input('name', null); // Get the name parameter

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

        if ($name) { // Apply name filter if it's not empty
            $doctorsQuery->whereHas('user', function ($query) use ($name) {
                $query->where('name', 'like', "%{$name}%");
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
    public function rateDoctor(Request $request, $doctorId, $patientId)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:255',
        ]);


        // Find the doctor and patient
        $doctor = Doctor::findOrFail($doctorId);
        $patient = Patient::findOrFail($patientId);

        // Create a new rating
        $rating = new Rating();
        $rating->doctor_id = $doctor->id;
        $rating->patient_id = $patient->id;
        $rating->rating = $validatedData['rating'];
        $rating->comment = $validatedData['comment'] ?? null; // If message is not provided, set it to null
        $rating->save();

        // Update the average rating for the doctor
        $ratings = Rating::where('doctor_id', $doctor->id)->pluck('rating');
        $avgRating = $ratings->isEmpty() ? 0 : $ratings->avg();
        $doctor->avg_rating = $avgRating;
        $doctor->save();
        // Redirect back with success message
        return redirect()->back()->with('success', 'Rating submitted successfully');
    }
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
