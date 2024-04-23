<?php

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

//BackOffice's routes

include 'web/BackOffice/admin.php';

include 'web/BackOffice/doctor.php';

include 'web/BackOffice/patient.php';

include 'web/BackOffice/appointment.php';

include 'web/BackOffice/schedules.php';

include 'web/BackOffice/speciality.php';


//FrontOffice's routes (Patient)

include 'web/FrontOffice/patient/patient.php';

include 'web/FrontOffice/patient/appointment.php';

include  'web/FrontOffice/patient/health-tips.php';

include  'web/FrontOffice/patient/doctor.php';

//FrontOffice's routes (Doctor)

include 'web/FrontOffice/doctor/doctor.php';

include 'web/FrontOffice/doctor/appointment.php';

include 'web/FrontOffice/doctor/schedule.php';

include 'web/FrontOffice/doctor/patient.php';

//Profile Routes
include 'web/FrontOffice/others/profile.php';

//Notification Routes
include 'web/FrontOffice/others/notification.php';

include 'web/FrontOffice/others/others.php';


require __DIR__ . '/auth.php';
