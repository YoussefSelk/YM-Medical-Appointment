<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function admin()
    {
        return view('panels.admin.index');
    }
    public function patient()
    {
        return view('panels.patient.index');
    }
    public function doctor()
    {
        return view('panels.doctor.index');
    }
}
