<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;

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

    //
    public function index()
    {
        $appointments = Auth::user()->patient->Appointments;
        return view('panels.patient.index')->with(compact('appointments'));
    }

    public function doctors()
    {

        $doctors = Doctor::all();
        return view('panels.patient.doctors')->with(compact('doctors'));
    }
    public function appointment(Request $request, $id)
    {
        $doctor = Doctor::find($id);
        $schedule = $doctor->schedules;
        return view('panels.patient.appointment')->with(compact('schedule'));
    }
}
