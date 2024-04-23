<?php
// Admin Doctor Routes

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'admin'])->group(function () {
    //Admin Schedules Routes
    Route::get('/admin/doctors/schedules', [AdminController::class, 'schedules'])
        ->name('admin.schedules');

    Route::get('/admin/doctor/schedule/{id}', [AdminController::class, 'schedule'])
        ->middleware('CheckDoctor')
        ->name('admin.doctor.schedule');

    Route::post('/admin/doctor/schedule/{id}/submit', [AdminController::class, 'add_schedule'])
        ->middleware('CheckDoctor')
        ->name('admin.doctor.schedule.submit');

    Route::get('/admin/doctor-schedules', [AdminController::class, 'getDoctorSchedules'])
        ->middleware('CheckDoctor')
        ->name('admin.doctor.schedules');

    Route::get('/admin/doctor-schedules/{id}/edit', [AdminController::class, 'editSchedule'])
        ->middleware('CheckDoctor')
        ->name('admin.doctor.schedule.edit');

    Route::put('/admin/doctor-schedules/{id}', [AdminController::class, 'updateSchedule'])
        ->middleware('CheckDoctor')
        ->name('admin.doctor.schedule.update');

    Route::delete('/admin/doctor-schedules/{id}/delete', [AdminController::class, 'deleteSchedule'])
        ->middleware('CheckDoctor')
        ->name('admin.doctor.schedule.delete');
});
