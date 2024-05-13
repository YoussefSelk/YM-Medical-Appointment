<?php

//Patient's routes

use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'doctor'])->group(function () {



    //Doctor Reviews Routes
    Route::get('/doctor/myreviews', [DoctorController::class, 'reviews'])->name('doctor.myreviews');


});
