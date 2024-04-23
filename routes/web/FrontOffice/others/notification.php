<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    //Notifications Routes
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('user.notifications');
    Route::put('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('user.notification.readed');
});
