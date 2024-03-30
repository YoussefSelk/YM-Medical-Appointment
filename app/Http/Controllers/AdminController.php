<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

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
    public function appointments()
    {
        
        $appointments = Appointment::all();
        return view('panels.admin.appointments')->with(compact("appointments"));
    }
    public function schedules() //schedules function return the schedules page of the admin panel
    {
        $doctors = Doctor::all();
        return view('panels.admin.schedules')->with(compact("doctors"));
    }
    public function schedule($id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            abort(404);
        }
        $schedule = $doctor->schedules;
        return view('panels.admin.CRUD.doctor-schedule')->with(compact("doctor"))->with(compact("schedule"));
    }
    public function index() //index function return the home page for admin panel
    {
        $shedules = Schedule::all();
        $doctors = Doctor::all();
        $Patients = Patient::all();
        $appointments = Appointment::all();
        return view('panels.admin.index')->with('shedules', $shedules)->with('doctors', $doctors)->with('patients', $Patients)->with('appointments', $appointments);
    }

    public function doctor() //doctor function return the doctor page for admin panel
    {
        $specialities = Speciality::all();
        $doctors = Doctor::all();
        return view('panels.admin.doctor')->with('doctors', $doctors)->with('specialities', $specialities);
    }

    public function patient()
    {
        $patients = Patient::all();
        return view('panels.admin.patient')->with(compact("patients"));
    }

    public function edit_doctor_view($id)
    {
        $specialities = Speciality::all();
        $doctor = Doctor::where("id", $id)->first();
        return view('panels.admin.CRUD.doctor-edit')->with('doctor', $doctor)->with('specialities', $specialities);
    }
    public function edit_patient_view($id)
    {
        $patient = Patient::where("id", $id)->first();
        return view('panels.admin.CRUD.patient-edit')->with('patient', $patient);
    }

    // Operations Functions

    public function getDoctors()
    {
        $doctors = Doctor::with('user', 'speciality')->get();
        return response()->json($doctors);
    }

    // CRUD Functions
    public function add_schedule(Request $request, $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'start_times' => 'nullable|array', // Validate 'start_times' as array
                'start_times.*' => 'nullable|array', // Each item inside 'start_times' should be an array
                'start_times.*.*' => 'nullable|date_format:H:i', // Validate as time format (HH:MM)
            ]);

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

        if (!empty($name) && !empty($birthdate) && !empty($ville) && !empty($rue) && !empty($email) && !empty($phone) && !empty($gender) && !empty($degree) && !empty($speciality)) {
            if ($this->isXssAttackDetected([$originalName, $originalVille, $originalRue, $originalEmail, $originalDegree, $originalSpeciality], [$name, $ville, $rue, $email, $degree, $speciality])) {
                return redirect()->back()->with('error', 'XSS attack detected. Please provide valid input.');
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

        if ($this->isXssAttackDetected([$originalName, $originalVille, $originalRue, $originalEmail, $originalCin], [$name, $ville, $rue, $email, $cin])) {
            return redirect()->back()->with('error', 'XSS attack detected. Please provide valid input.');
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

        if ($this->isXssAttackDetected(
            [$originalName, $originalVille, $originalRue, $originalEmail, $originalDegree, $originalSpeciality],
            [$name, $ville, $rue, $email, $degree, $speciality]
        )) {
            return redirect()->back()->with('error', 'XSS attack detected. Please provide valid input.');
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
        if ($this->isXssAttackDetected([$originalName, $originalVille, $originalRue, $originalEmail, $originalCin], [$name, $ville, $rue, $email, $cin])) {
            return redirect()->back()->with('error', 'XSS attack detected. Please provide valid input.');
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
