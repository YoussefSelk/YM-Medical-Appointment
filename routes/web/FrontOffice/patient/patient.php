<?php

//Patient's routes

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'patient'])->group(function () {
    //Home Routes
    Route::get('/patient', [PatientController::class, 'index'])->name('patient_dashboard');
    //Health tips Route
    Route::get('/patient/emergency-contacts', [PatientController::class, 'showEmergencyContactsForm'])->name('patients.emergency.contacts.view');
    Route::get('/patient/emergency-contacts/search', [PatientController::class, 'showEmergencyContacts'])->name('patients.emergency.contacts.process');
});
