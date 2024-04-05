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
})->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    //Admin's routes
    Route::middleware('admin')->group(function () {

        // Admin Dashboard
        Route::get('/admin', [AdminController::class, 'index'])->name('admin_dashboard');

        // Admin Doctor Routes
        Route::get('/admin/doctor', [AdminController::class, 'doctor'])->name('admin.doctor');
        Route::post('/admin/doctor/add', [AdminController::class, 'add_doctor'])->name('admin.doctor.add');
        Route::get('/admin/doctors', [AdminController::class, 'getDoctors'])->name('admin.table.doctors');
        Route::get('/admin/doctor/edit/{id}', [AdminController::class, 'edit_doctor_view'])->name('admin.doctor.edit.view');
        Route::put('/admin/doctor/edit/{id}', [AdminController::class, 'edit_doctor'])->name('admin.doctor.edit');
        Route::delete('/admin/doctor/delete/{id}', [AdminController::class, 'delete_doctor'])->name('admin.doctor.delete');
        Route::get('/admin/doctors/pdf', [AdminController::class, 'export_doctors_pdf'])->name('admin.table.doctors.pdf');

        // Admin Patient Routes
        Route::get('/admin/patient', [AdminController::class, 'patient'])->name('admin.patient');
        Route::post('/admin/patient/add', [AdminController::class, 'add_patient'])->name('admin.patient.add');
        Route::get('/admin/patient/edit/{id}', [AdminController::class, 'edit_patient_view'])->name('admin.patient.edit.view');
        Route::put('/admin/patient/edit/{id}', [AdminController::class, 'edit_patient'])->name('admin.patient.edit');
        Route::delete('/admin/patient/delete/{id}', [AdminController::class, 'delete_patient'])->name('admin.patient.delete');
        Route::get('/admin/patient/pdf', [AdminController::class, 'export_patients_pdf'])->name('admin.table.patients.pdf');

        //Admin Schedules Routes
        Route::get('/admin/doctors/schedules', [AdminController::class, 'schedules'])->name('admin.schedules');
        Route::get('/admin/doctor/schedule/{id}', [AdminController::class, 'schedule'])->name('admin.doctor.schedule');
        Route::post('/admin/doctor/schedule/{id}/submit', [AdminController::class, 'add_schedule'])->name('admin.doctor.schedule.submit');


        //Admin Appointments Routes
        Route::get('/admin/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
    });

    //Doctor's routes
    Route::middleware('doctor')->group(function () {
        Route::get('/doctor', [DoctorController::class, 'index'])->name('doctor_dashboard');

        Route::get('/doctor/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');
        Route::get('doctor/schedule', [DoctorController::class, 'schedule'])->name('doctor.schedule');
    });



    //Patient's routes
    Route::middleware('patient')->group(function () {
        Route::get('/patient', [PatientController::class, 'index'])->name('patient_dashboard');
        Route::get('/patient/doctors', [PatientController::class, 'doctors'])->name('patiens.doctors');
        Route::get('/patient/doctor/{id}/book/appointment', [PatientController::class, 'appointment'])->name('patiens.doctor.book.appointment');
        Route::get('/patient/doctor/{id}/book/appointment/getHours', [PatientController::class, 'getAvailableHours'])->name('patiens.doctor.book.appointment.getHours');
        Route::post('/patient/doctor/{D_ID}/book/appointment/{P_ID}/submit', [PatientController::class, 'bookAppointment'])->name('patiens.doctor.book.appointment.submit');
        Route::get('/patient/doctor/{id}/appointments', [PatientController::class, 'getAppointments'])->name('fetch.appointments');
    });

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
