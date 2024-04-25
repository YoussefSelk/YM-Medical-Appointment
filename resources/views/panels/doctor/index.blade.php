<head>
    <title>Doctor's Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css?v=1628755089081">
</head>

<x-doctor-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Doctor\'s Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div
    class="p-6 bg-white rounded-md shadow-md overflow-hidden flex flex-col md:flex-row justify-around dark:bg-dark-eval-1">
    <div class="md:flex justify-center items-center md:w-1/2">
        <div class="p-8 flex items-center">
            <div class="mr-12">
                @php
                    $user = Auth::user()->img;
                @endphp
                @if ($user)
                    <img src="{{ asset('storage/profile_pictures/' . $user) }}" alt="Profile Picture"
                        class="w-24 h-24 md:w-36 md:h-36 lg:w-48 lg:h-48 rounded-3xl">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="test"
                        class="w-24 h-24 md:w-36 md:h-36 lg:w-48 lg:h-48 rounded-3xl">
                @endif
            </div>
            <div>
                <div class="uppercase tracking-wide text-sm text-blue-500 font-semibold">Welcome to the Doctor Panel
                </div>
                <div>
                    <p class="mt-2 text-gray-500">{!! __('Dr. <strong>:name</strong>', ['name' => auth()->user()->name]) !!}</p>
                </div>
            </div>
        </div>
    </div>


    <div class="p-6 bg-white dark:bg-dark-eval-1 rounded-md md:w-1/2">
        <strong class="text-lg text-gray-800 dark:text-gray-200">Counts:</strong>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div class="bg-white dark:bg-gray-800 rounded-md shadow-md p-4 flex items-center justify-between">
                <div>
                    <p class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ count($schedule) }}</p>
                    <p class="text-gray-500 dark:text-gray-400">Schedules</p>
                </div>
                <i class="fas fa-calendar text-3xl text-blue-500 dark:text-blue-300"></i>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-md shadow-md p-4 flex items-center justify-between">
                <div>
                    <p class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ count($patients) }}</p>
                    <p class="text-gray-500 dark:text-gray-400">My patients</p>
                </div>
                <i class="fas fa-solid fa-bed-pulse text-3xl text-blue-500 dark:text-blue-300"></i>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-md shadow-md p-4 flex items-center justify-between">
                <div>
                    <p class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ count($appointments) }}</p>
                    <p class="text-gray-500 dark:text-gray-400">Bookings</p>
                </div>
                <i class="fas fa-calendar-check text-3xl text-purple-500 dark:text-purple-300"></i>
            </div>
        </div>
    </div>


</div>





</x-doctor-layout>
