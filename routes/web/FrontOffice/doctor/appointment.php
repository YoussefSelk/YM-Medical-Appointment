<?php

//Patient's routes

use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'doctor'])->group(function () {
    //Doctor Appointments Routes
    Route::get('/doctor/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');
    Route::get('doctor/appointment/edit/{id}', [DoctorController::class, 'editAppointmentView'])->name('doctor.CRUD.appointment.edit');
    Route::put('doctor/appointment/edit/{id}', [DoctorController::class, 'updateAppointment'])->name('doctor.appointment.update');
    Route::get('/doctor/appointments/calendar', [DoctorController::class, 'getAppointments'])->name('doctor.appointments.calendar');
    Route::get('/doctor/appointments/{id}', [DoctorController::class, 'getAppointmentDetails'])->name('doctor.appointments.details');

    //Doctor Patients Routes
});
