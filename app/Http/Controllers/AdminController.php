<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $shedules = Schedule::all();
        $doctors = Doctor::all();
        $Patients = Patient::all();
        $appointments = Appointment::all();
        return view('panels.admin.index')->with('shedules',$shedules)->with('doctors',$doctors)->with('patients',$Patients)->with('appointments',$appointments);
    }
    public function doctor(){
        $doctors = Doctor::all();
        return view('panels.admin.doctor')->with('doctors',$doctors);
    }
}
