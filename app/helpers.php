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
        $content = nl2br(e((string) ($data['content'] ?? '')));
        $contactLink = filter_var($data['contactLink'] ?? '', FILTER_VALIDATE_URL)
            ? $data['contactLink']
            : config('app.url');
        $contactText = trim(strip_tags((string) ($data['contactText'] ?? 'Contact us')));
        $phoneNumber = preg_replace('/[^0-9+\\-\\s\\(\\)]/', '', (string) ($data['phoneNumber'] ?? ''));

        Mail::to($data['to'])
            ->send(new Support([
                'content' => $content,
                'contactLink' => $contactLink,
                'contactText' => $contactText,
                'phoneNumber' => $phoneNumber,
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
