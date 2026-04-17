<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    //Notifications Routes
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])
        ->middleware('throttle:60,1')
        ->name('user.notifications');
    Route::put('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])
        ->middleware('throttle:60,1')
        ->name('user.notification.readed');
});
