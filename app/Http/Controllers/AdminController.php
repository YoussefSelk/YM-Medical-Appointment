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
    public function index()
    {
        $shedules = Schedule::all();
        $doctors = Doctor::all();
        $Patients = Patient::all();
        $appointments = Appointment::all();
        return view('panels.admin.index')->with('shedules', $shedules)->with('doctors', $doctors)->with('patients', $Patients)->with('appointments', $appointments);
    }
    public function doctor()
    {
        $specialities = Speciality::all();
        $doctors = Doctor::all();
        return view('panels.admin.doctor')->with('doctors', $doctors)->with('specialities', $specialities);
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
        return view('panels.admin.CRUD.edit')->with('doctor', $doctor)->with('specialities', $specialities);
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

    public function add_doctor(Request $request)
    {
        $name = $request->input('nom');
        $birthdate = $request->input('birthdate');
        $ville = $request->input('city');
        $rue = $request->input('rue');
        $email = $request->input('email');
        $password = $request->input('password');
        $phone = $request->input('phone');
        $gender = $request->input('gender');
        $degree = $request->input('degree');
        $speciality = $request->input('speciality');

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
    public function export_doctors_pdf()
    {
        $doctors = Doctor::all();
        $pdf = Pdf::loadView('pdf.doctors-table-pdf', ['doctors' => $doctors]);
        //return $pdf->download('doctors.pdf');
        return $pdf->stream();
    }
}
