<?php

//Patient's routes

use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'doctor'])->group(function () {

    //Doctor Home Routes
    Route::get('/doctor', [DoctorController::class, 'index'])->name('doctor_dashboard');

    //Doctor Patients Routes
});
