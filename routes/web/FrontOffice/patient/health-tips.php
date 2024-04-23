<?php

//Patient's routes

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'patient'])->group(function () {
    //Health tips Routes
    Route::get('/patient/health-tips', [PatientController::class, 'getTips'])->name('patiens.health.tips.view');
});
