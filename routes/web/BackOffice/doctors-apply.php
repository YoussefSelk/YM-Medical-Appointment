<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/doctors/apply', [AdminController::class, 'apply_view'])
        ->name('admin.apply');

    Route::post('/admin/approve-application/{id}', [AdminController::class, 'approveApplication'])
        ->name('admin.approve.application');

    Route::post('/admin/reject-application/{id}', [AdminController::class, 'rejectApplication'])
        ->name('admin.reject.application');

    Route::delete('/admin/delete-application/{id}', [AdminController::class, 'delete_application'])
        ->name('admin.delete_application');
});
