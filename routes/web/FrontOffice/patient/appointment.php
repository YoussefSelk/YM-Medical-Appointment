<?php

//Patient's routes

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'patient'])->group(function () {
    //Book Appointment Routes
    Route::get('/patient/doctor/{id}/book/appointment', [PatientController::class, 'appointment'])->name('patiens.doctor.book.appointment');
    Route::get('/patient/doctor/{id}/book/appointment/getHours', [PatientController::class, 'getAvailableHours'])->name('patiens.doctor.book.appointment.getHours');
    Route::post('/patient/doctor/{D_ID}/book/appointment/{P_ID}/submit', [PatientController::class, 'bookAppointment'])->name('patiens.doctor.book.appointment.submit');
    Route::get('/patient/doctor/{id}/appointments', [PatientController::class, 'getAppointments'])->name('fetch.appointments');
    Route::get('/patient/filter/doctors', [PatientController::class, 'filterDoctors'])->name('filter.doctors');
    Route::get('/patient/all/doctors', [PatientController::class, 'allDoctors'])->name('patiens.all.doctors');
    Route::get('/patient/my/appointments/{id}', [PatientController::class, 'patient_appointments'])->name('patiens.my.appointments');
    Route::get('/patient/appointment/detail/{id}', [PatientController::class, 'appointment_detail'])->name('patiens.appointment.detail');
    Route::put('/patient/appointment/detail/{id}/cancel', [PatientController::class, 'cancel_appointment'])->name('patiens.appointment.detail.cancel');
});
