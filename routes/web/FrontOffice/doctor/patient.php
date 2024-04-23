<?php

//Patient's routes

use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'doctor'])->group(function () {



    //Doctor Patients Routes
    Route::get('/doctor/mypatients', [DoctorController::class, 'mypatients'])->name('doctor.mypatients');
    Route::get('/doctor/patient/{id}', [DoctorController::class, 'patientView'])->name('doctor.CRUD.patient.view');
    Route::get('/doctor/patient/book/appointment/{id}', [DoctorController::class, 'bookAppointmentView'])->name('doctor.CRUD.patient.book');
    Route::post('/doctor/patient/book/appointment/{id}/submit', [DoctorController::class, 'book'])->name('doctor.patient.book.appointment.submit');


});
