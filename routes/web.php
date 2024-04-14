<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
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
        Route::get('/admin/doctor/view/details/{id}', [AdminController::class, 'doctor_details'])->name('admin.table.doctor.details');
        Route::get('/admin/doctor/notify/{id}', [AdminController::class, 'doctor_notify_view'])->name('admin.doctor.notify');
        Route::post('/admin/doctor/notify/{id}/submit', [AdminController::class, 'doctor_notify'])->name('admin.doctor.notify.submit');
        // Admin Patient Routes
        Route::get('/admin/patient', [AdminController::class, 'patient'])->name('admin.patient');
        Route::post('/admin/patient/add', [AdminController::class, 'add_patient'])->name('admin.patient.add');
        Route::get('/admin/patient/edit/{id}', [AdminController::class, 'edit_patient_view'])->name('admin.patient.edit.view');
        Route::put('/admin/patient/edit/{id}', [AdminController::class, 'edit_patient'])->name('admin.patient.edit');
        Route::delete('/admin/patient/delete/{id}', [AdminController::class, 'delete_patient'])->name('admin.patient.delete');
        Route::get('/admin/patient/pdf', [AdminController::class, 'export_patients_pdf'])->name('admin.table.patients.pdf');
        Route::get('/admin/patient/view/details/{id}', [AdminController::class, 'patient_details'])->name('admin.table.patient.details');
        Route::get('/admin/patient/notify/{id}', [AdminController::class, 'patient_notify_view'])->name('admin.patient.notify');
        Route::post('/admin/patient/notify/{id}/submit', [AdminController::class, 'patient_notify'])->name('admin.patient.notify.submit');



        //Admin Schedules Routes
        Route::get('/admin/doctors/schedules', [AdminController::class, 'schedules'])->name('admin.schedules');
        Route::get('/admin/doctor/schedule/{id}', [AdminController::class, 'schedule'])->name('admin.doctor.schedule');
        Route::post('/admin/doctor/schedule/{id}/submit', [AdminController::class, 'add_schedule'])->name('admin.doctor.schedule.submit');
        Route::get('/admin/doctor-schedules',  [AdminController::class, 'getDoctorSchedules'])->name('admin.doctor.schedules');
        Route::get('/admin/doctor-schedules/{id}/edit', [AdminController::class, 'editSchedule'])->name('admin.doctor.schedule.edit');
        Route::put('/admin/doctor-schedules/{id}', [AdminController::class, 'updateSchedule'])->name('admin.doctor.schedule.update');
        Route::delete('/admin/doctor-schedules/{id}/delete', [AdminController::class, 'deleteSchedule'])->name('admin.doctor.schedule.delete');

        //Admin Appointments Routes
        Route::get('/admin/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
        Route::get('/admin/appointment/view/{id}', [AdminController::class, 'appointment_detail'])->name('admin.appointment.view');
        Route::put('/admin/appointment/detail/{id}/cancel', [AdminController::class, 'cancel_appointment'])->name('admin.appointment.detail.cancel');
        Route::put('/admin/appointment/detail/{id}/approve', [AdminController::class, 'approve_appointment'])->name('admin.appointment.detail.approve');

        //Admin Specialities Routes
        Route::get('/admin/specialities', [AdminController::class, 'specialities'])->name('admin.specialities');
        Route::post('/admin/specialities/add', [AdminController::class, 'add_speciality'])->name('admin.specialities.add');
        Route::get('/admin/specialities/edit/{id}', [AdminController::class, 'edit_speciality_view'])->name('admin.specialities.edit.view');
        Route::put('/admin/specialities/edit/{id}', [AdminController::class, 'edit_speciality'])->name('admin.specialities.edit');
        Route::delete('/admin/specialities/delete/{id}', [AdminController::class, 'delete_speciality'])->name('admin.specialities.delete');
        Route::get('/admin/specialitie/details/{id}', [AdminController::class, 'speciality_details'])->name('admin.speciality.details');
    });

    //Doctor's routes
    Route::middleware('doctor')->group(function () {

        //Doctor Home Routes
        Route::get('/doctor', [DoctorController::class, 'index'])->name('doctor_dashboard');

        //Doctor Appointments Routes
        Route::get('/doctor/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');
        Route::get('doctor/appointment/edit/{id}', [DoctorController::class, 'editAppointmentView'])->name('doctor.CRUD.appointment.edit');
        Route::put('doctor/appointment/edit/{id}', [DoctorController::class, 'updateAppointment'])->name('doctor.appointment.update');
        Route::get('/doctor/appointments/calendar', [DoctorController::class, 'getAppointments'])->name('doctor.appointments.calendar');
        Route::get('/doctor/appointments/{id}', [DoctorController::class, 'getAppointmentDetails'])->name('doctor.appointments.details');

        //Doctor Schedule Routes
        Route::get('doctor/schedule', [DoctorController::class, 'schedule'])->name('doctor.schedule');
        Route::get('doctor/schedule/edit/{id}', [DoctorController::class, 'editSchedule'])->name('doctor.CRUD.schedule.edit');
        Route::put('doctor/schedule/{id}', [DoctorController::class, 'updateSchedule'])->name('doctor.schedule.update');
        Route::delete('/doctor/schedule/{id}', [DoctorController::class, 'deleteSchedule'])->name('doctor.schedule.delete');


        Route::get('/doctor/schedules/index', [DoctorController::class, 'getSchedules'])->name('doctor.schedules.index');

        //Doctor Patients Routes
    });



    //Patient's routes
    Route::middleware('patient')->group(function () {
        //Home Routes
        Route::get('/patient', [PatientController::class, 'index'])->name('patient_dashboard');

        //Doctor Routes
        Route::get('/patient/doctors', [PatientController::class, 'doctors'])->name('patiens.doctors');

        //Book Appointment Routes
        Route::get('/patient/doctor/{id}/book/appointment', [PatientController::class, 'appointment'])->name('patiens.doctor.book.appointment');
        Route::get('/patient/doctor/{id}/book/appointment/getHours', [PatientController::class, 'getAvailableHours'])->name('patiens.doctor.book.appointment.getHours');
        Route::post('/patient/doctor/{D_ID}/book/appointment/{P_ID}/submit', [PatientController::class, 'bookAppointment'])->name('patiens.doctor.book.appointment.submit');
        Route::get('/patient/doctor/{id}/appointments', [PatientController::class, 'getAppointments'])->name('fetch.appointments');
        Route::get('/patient/filter/doctors', [PatientController::class, 'filterDoctors'])->name('filter.doctors');
        Route::get('/patient/all/doctors', [PatientController::class, 'allDoctors'])->name('patiens.all.doctors');
        Route::get('/patient/my/appointments/{id}', [PatientController::class, 'patient_appointments'])->name('patiens.my.appointments');
        Route::get('/patient/appointment/detail/{id}', [PatientController::class, 'appointment_detail'])->name('patiens.appointment.detail');
        Route::put('/patient/appointment/detail/{id}/cancel', [PatientController::class, 'cancel_appointment'])->name('patiens.appointment.detail.cancel');
    });

    //Profile's routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/img', [ProfileController::class, 'img'])->name('profile.img');

    //Notifications Routes
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('user.notifications');
    Route::put('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('user.notification.readed');
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
