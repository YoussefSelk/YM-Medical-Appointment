<?php
// Admin Doctor Routes

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'admin'])->group(function () {
    //Doctors Routes
    Route::get('/admin/doctor', [AdminController::class, 'doctor'])->name('admin.doctor');
    Route::post('/admin/doctor/add', [AdminController::class, 'add_doctor'])->name('admin.doctor.add');
    Route::get('/admin/doctors', [AdminController::class, 'getDoctors'])->name('admin.table.doctors');
    Route::get('/admin/doctor/edit/{id}', [AdminController::class, 'edit_doctor_view'])->name('admin.doctor.edit.view');
    Route::put('/admin/doctor/edit/{id}', [AdminController::class, 'edit_doctor'])->name('admin.doctor.edit');
    Route::delete('/admin/doctor/delete/{id}', [AdminController::class, 'delete_doctor'])->name('admin.doctor.delete');
    Route::get('/admin/doctors/pdf', [AdminController::class, 'export_doctors_pdf'])->name('admin.table.doctors.pdf');
    Route::get('/admin/doctor/view/details/{id}', [AdminController::class, 'doctor_details'])->name('admin.table.doctor.details');
    Route::get('/admin/doctor/notify/{id}', [AdminController::class, 'doctor_notify_view'])->name('admin.doctor.notify');
    Route::post('/admin/doctor/notify/{id}/submit', [AdminController::class, 'doctor_notify'])->name('admin.doctor.notify.submit');
});
