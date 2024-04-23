<?php
// Admin Doctor Routes

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'admin'])->group(function () {

    //Admin Specialities Routes
    Route::get('/admin/specialities', [AdminController::class, 'specialities'])
        ->name('admin.specialities');

    Route::post('/admin/specialities/add', [AdminController::class, 'add_speciality'])
        ->name('admin.specialities.add');

    Route::get('/admin/specialities/edit/{id}', [AdminController::class, 'edit_speciality_view'])
        ->middleware('CheckSpecialityExistence')
        ->name('admin.specialities.edit.view');

    Route::put('/admin/specialities/edit/{id}', [AdminController::class, 'edit_speciality'])
        ->middleware('CheckSpecialityExistence')
        ->name('admin.specialities.edit');

    Route::delete('/admin/specialities/delete/{id}', [AdminController::class, 'delete_speciality'])
        ->middleware('CheckSpecialityExistence')
        ->name('admin.specialities.delete');

    Route::get('/admin/specialitie/details/{id}', [AdminController::class, 'speciality_details'])
        ->middleware('CheckSpecialityExistence')
        ->name('admin.speciality.details');
});
