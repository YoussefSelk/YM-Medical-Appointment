<?php

//Patient's routes

use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'doctor'])->group(function () {
    //Doctor Schedule Routes
   

    //Doctor Patients Routes
});
