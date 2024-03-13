<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $doctors = Doctor::all();
        return view('panels.admin.doctor')->with('doctors', $doctors);
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
            'phone' => 'required|string|max:10',
            'gender' => ['required', Rule::in(['male', 'female'])],
            'degree' => 'required|string|max:255',
            'speciality' => 'required|string|max:255',
        ];

        


    }
}
