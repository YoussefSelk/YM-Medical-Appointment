<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    //Views's Functions
    public function index()
    {
        $appointments=Auth::user()->doctor->Appointments;
        $schedule = Auth::user()->doctor->schedules;

        return view('panels.doctor.index')->with('appointments',$appointments)->with('schedule',$schedule);
    }

    public function appointments(){

        $appointments = Auth::user()->doctor->Appointments;
        return view('panels.doctor.appointments')->with(compact('appointments'));
    }

    public function schedule(){

        $schedule = Auth::user()->doctor->schedules;
        return view('panels.doctor.schedule')->with(compact('schedule'));

    }


    //Operations's Functions


}
