<?php


use App\Models\User;

if (!function_exists('authUser')) {
    function authUser(): ?User
    {
        return auth()->user();
    }
}
