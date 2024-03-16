<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {


    //Admin's routes
    Route::get('/admin', [AdminController::class, 'index'])->name('admin_dashboard');
    Route::get('/admin/doctor', [AdminController::class, 'doctor'])->name('admin.doctor');
    Route::post('/admin/doctor/add', [AdminController::class, 'add_doctor'])->name('admin.doctor.add');
    Route::get('/admin/doctors', [AdminController::class, 'getDoctors'])->name('admin.table.doctors');
    Route::get('/admin/doctor/edit/{id}', [AdminController::class, 'edit_doctor_view'])->name('admin.doctor.edit.view');
    Route::put('/admin/doctor/edit/{id}', [AdminController::class, 'edit_doctor'])->name('admin.doctor.edit');
    Route::delete('/admin/doctor/edit/{id}', [AdminController::class, 'delete_doctor'])->name('admin.doctor.delete');
    Route::get('/admin/doctors/pdf', [AdminController::class, 'export_doctors_pdf'])->name('admin.table.doctors.pdf');

    //Doctor's routes
    Route::get('/doctor', [DoctorController::class, 'index'])->name('doctor_dashboard');

    //Patient's routes
    Route::get('/patient', [PatientController::class, 'index'])->name('patient_dashboard');

    //Profile's routes

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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

require __DIR__ . '/auth.php';
