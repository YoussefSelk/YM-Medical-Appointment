<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'YM Medical') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('img/app-logo.png') }}">
</head>

<body>
    <div x-data="mainState" :class="{ dark: isDarkMode }" x-cloak>
        <div class="app-auth flex min-h-screen flex-col text-gray-900 dark:bg-dark-eval-0 dark:text-gray-200 animate__animated animate__fadeIn">
            {{ $slot }}

            <x-footer />
        </div>

        <div class="fixed right-4 top-4 sm:right-6 sm:top-6">
            <x-button type="button" icon-only variant="secondary" sr-text="Toggle dark mode" x-on:click="toggleTheme"
                class="shadow-sm">
                <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true" class="h-5 w-5" />
                <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true" class="h-5 w-5" />
            </x-button>
        </div>
    </div>
    @stack('scripts')
</body>

</html>

