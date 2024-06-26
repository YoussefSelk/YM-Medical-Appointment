<?php

//Patient's routes

use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'doctor'])->group(function () {
    //Doctor Schedule Routes
    Route::get('doctor/schedule', [DoctorController::class, 'schedule'])->name('doctor.schedule');
    Route::get('doctor/schedule/edit/{id}', [DoctorController::class, 'editSchedule'])->name('doctor.CRUD.schedule.edit');
    Route::put('doctor/schedule/{id}', [DoctorController::class, 'updateSchedule'])->name('doctor.schedule.update');
    Route::delete('/doctor/schedule/{id}', [DoctorController::class, 'deleteSchedule'])->name('doctor.schedule.delete');
    Route::post('/doctor/{id}/schedule/add', [DoctorController::class, 'add_schedule'])->name('doctor.schedule.add');

    Route::get('/doctor/schedules/index', [DoctorController::class, 'getSchedules'])->name('doctor.schedules.index');
    Route::get('/doctor/schedules/availableHours',[DoctorController::class, 'getAvailableHours'])->name('doctor.schedules.getAvailableHours');

    //Doctor Patients Routes
});
