<?php
// Admin Doctor Routes

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'admin'])->group(function () {
    //Admin Appointments Routes
    Route::get('/admin/appointments', [AdminController::class, 'appointments'])
        ->name('admin.appointments');

    Route::get('/admin/appointment/view/{id}', [AdminController::class, 'appointment_detail'])

        ->name('admin.appointment.view');

    Route::put('/admin/appointment/detail/{id}/cancel', [AdminController::class, 'cancel_appointment'])

        ->name('admin.appointment.detail.cancel');

    Route::put('/admin/appointment/detail/{id}/approve', [AdminController::class, 'approve_appointment'])

        ->name('admin.appointment.detail.approve');
});
