<?php


use App\Models\User;
use App\Mail\Support;
use Illuminate\Support\Facades\Mail;

//Function to Get User as A Model


if (!function_exists('authUser')) {
    function authUser(): ?User
    {
        return auth()->user();
    }
}

// Function to Send Email
// sendSupportEmail([
//     'to' => 'recipient@example.com',
//     'content' => 'This is the content of the email.',
//     'contactLink' => 'https://example.com/contact',
//     'contactText' => 'Contact us',
//     'phoneNumber' => '+1234567890',
// ]);


if (!function_exists('sendSupportEmail')) {
    function sendSupportEmail($data)
    {
        Mail::to($data['to'])
            ->send(new Support([
                'content' => $data['content'],
                'contactLink' => $data['contactLink'],
                'contactText' => $data['contactText'],
                'phoneNumber' => $data['phoneNumber'],
            ]));
    }
}
// Function to Get User IP

if (!function_exists('getUserIP')) {
    function getUserIP()
    {
        return request()->ip();
    }
}
