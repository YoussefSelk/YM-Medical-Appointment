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
                return true; // XSS attack detected
            }
        }
        return false; // No XSS attack detected
    }



    //index function return the home page for admin panel
    public function index()
    {
        $shedules = Schedule::all();
        $doctors = Doctor::all();
        $Patients = Patient::all();
        $appointments = Appointment::all();
        return view('panels.admin.index')->with('shedules', $shedules)->with('doctors', $doctors)->with('patients', $Patients)->with('appointments', $appointments);
    }
    //doctor function return the doctor page for admin panel
    public function doctor()
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
    public function getDoctors()
    {
        $doctors = Doctor::with('user', 'speciality')->get();
        return response()->json($doctors);
    }
    public function doctor_chart()
    {
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
    public function edit_doctor(Request $request, $id)
    {
        $name = $request->input('nom');
        $birthdate = $request->input('birthdate');
        $ville = $request->input('city');
        $rue = $request->input('rue');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $gender = $request->input('gender');
        $degree = $request->input('degree');
        $speciality = $request->input('speciality');

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
        $name = $request->input('nom');
        $birthdate = $request->input('birthdate');
        $ville = $request->input('city');
        $rue = $request->input('rue');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $gender = $request->input('gender');
        $cin = $request->input('cin');

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

            $user = User::find($doctor->user->id);
            $address = Address::find($doctor->user->address->id);
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
        if ($this->isXssAttackDetected([$originalName, $originalVille, $originalRue, $originalEmail, $originalDegree, $originalSpeciality], [$name, $ville, $rue, $email, $degree, $speciality])) {
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
