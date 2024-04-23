<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    //Profile's routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/img', [ProfileController::class, 'img'])->name('profile.img');
    Route::delete('/profile/img/delete', [ProfileController::class, 'deleteProfilePicture'])->name('profile.img.delete');
});
