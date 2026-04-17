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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    @if (request()->routeIs('admin_dashboard'))
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    @endif

    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('img/app-logo.png') }}">

    <style>
        .admin-theme {
            background-image: radial-gradient(circle at 10% 10%, rgba(37, 99, 235, 0.2), transparent 35%),
                radial-gradient(circle at 95% 0%, rgba(14, 165, 233, 0.12), transparent 30%);
        }

        .admin-theme h1,
        .admin-theme h2,
        .admin-theme h3,
        .admin-theme h4 {
            font-family: "Sora", sans-serif;
        }
    </style>
</head>

<body class="admin-theme antialiased">
    <div x-data="mainState" :class="{ dark: isDarkMode }" x-on:resize.window="handleWindowResize" x-cloak>
        <div class="app-shell min-h-screen text-gray-900 dark:bg-dark-eval-0 dark:text-gray-200">
            <x-sidebar.sidebar />

            <div class="app-frame flex min-h-screen flex-col"
                :class="{
                    'lg:ml-64': isSidebarOpen,
                    'md:ml-16': !isSidebarOpen
                }">
                <x-navbar />

                <div class="app-content">
                    <header>
                        <div class="app-header">
                            {{ $header }}
                        </div>
                    </header>

                    <main class="app-main pb-6">
                        {{ $slot }}
                    </main>

                    <x-footer />
                </div>
            </div>
        </div>
    </div>
    @stack('scripts')
</body>

</html>

