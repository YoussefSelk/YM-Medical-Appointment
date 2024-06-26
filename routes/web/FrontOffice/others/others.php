<?php

use App\Http\Controllers\Auth\DoctorRegisteredUserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/Apply', [HomeController::class, 'apply'])->name('home.apply');

Route::post('/apply/submit', [HomeController::class, 'apply_mail'])
    ->name('home.apply.submit');

Route::get('/doctor/register/{token}', [DoctorRegisteredUserController::class, 'create'])
    ->name('register.doctor');
Route::post('/doctor/register/store', [DoctorRegisteredUserController::class, 'store'])
    ->name('register.doctor.store');

Route::get('/dashboard', function () {
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');
// useless routes
// Just to demo sidebar dropdown links active states.
Route::get('/buttons/text', function () {
    return view('buttons-showcase.text');
})->middleware(['auth'])->name('buttons.text');

Route::get('/buttons/icon', function () {
    return view('buttons-showcase.icon');
})->middleware(['auth'])->name('buttons.icon');

Route::get('/buttons/text-icon', function () {
    return view('buttons-showcase.text-icon');
})->middleware(['auth'])->name('buttons.text-icon');
