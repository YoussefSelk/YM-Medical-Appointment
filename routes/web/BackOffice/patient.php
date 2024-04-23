<?php
// Admin Doctor Routes

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Patient Routes
    Route::get('/admin/patient', [AdminController::class, 'patient'])
        ->name('admin.patient');

    Route::post('/admin/patient/add', [AdminController::class, 'add_patient'])
        ->name('admin.patient.add');

    Route::get('/admin/patient/edit/{id}', [AdminController::class, 'edit_patient_view'])
        ->middleware('CheckPatientExistence')
        ->name('admin.patient.edit.view');

    Route::put('/admin/patient/edit/{id}', [AdminController::class, 'edit_patient'])
        ->middleware('CheckPatientExistence')
        ->name('admin.patient.edit');

    Route::delete('/admin/patient/delete/{id}', [AdminController::class, 'delete_patient'])
        ->middleware('CheckPatientExistence')
        ->name('admin.patient.delete');

    Route::get('/admin/patient/pdf', [AdminController::class, 'export_patients_pdf'])
        ->name('admin.table.patients.pdf');

    Route::get('/admin/patient/view/details/{id}', [AdminController::class, 'patient_details'])
        ->middleware('CheckPatientExistence')
        ->name('admin.table.patient.details');

    Route::get('/admin/patient/notify/{id}', [AdminController::class, 'patient_notify_view'])
        ->middleware('CheckPatientExistence')
        ->name('admin.patient.notify');

    Route::post('/admin/patient/notify/{id}/submit', [AdminController::class, 'patient_notify'])
        ->middleware('CheckPatientExistence')
        ->name('admin.patient.notify.submit');
});
