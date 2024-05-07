<head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>


<x-doctor-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Appointment details') }}
        </h2>
    </x-slot>

    <div class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('doctor.appointments') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        My Appointments
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">
                            Appointment details</span>
                    </div>
                </li>
            </ol>
        </nav>

    </div>

    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Appointment Details') }}
        </h2>
        <p class="mt-2 text-gray-700 dark:text-gray-400">Status:
            @if ($appointment->status == 'Pending')
                <span
                    class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium px-2.5 py-0.5 rounded">{{ $appointment->status }}</span>
            @elseif ($appointment->status == 'Expired')
                <span
                    class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium px-2.5 py-0.5 rounded">{{ $appointment->status }}</span>
            @elseif ($appointment->status == 'Cancelled')
                <span
                    class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium px-2.5 py-0.5 rounded">{{ $appointment->status }}</span>
            @else
                <span
                    class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ $appointment->status }}</span>
            @endif
        </p>
    </div>


    <div class=" mt-7 overflow-hidden bg-white p-6 rounded-md shadow-md dark:bg-dark-eval-1">

        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Patient Details : ') }}
        </h2>

        <div class="p-4 flex flex-col md:flex-row justify-between">
            <div
                class="md:mr-3 md:mb-0 mb-4 md:w-auto w-full md:flex-none flex items-center justify-center md:flex-row">
                <span class="mr-4">
                    @if ($appointment->patient->user->img)
                        <img src="{{ asset('storage/profile_pictures/' . $appointment->patient->user->img) }}"
                            alt="Profile Picture" class="w-32 h-32 md:rounded-2xl sm:rounded-2xl ">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ $appointment->patient->user->name }}"
                            alt="test" class="w-32 h-32 rounded-2xl  md:rounded-2xl sm:rounded-2xl">
                    @endif
                </span>

                <div class="md:mt-0 mt-4 md:ml-4 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-medium leading-tight text-gray-900 dark:text-white">
                            {{ $appointment->patient->user->name }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="ml-1 mt-2 md:mt-4 md:text-center md:flex md:flex-col md:items-center">
                <div class="flex flex-col md:items-start items-center ">
                    <div class="flex flex-col items-start " style="width: 400px">
                        <span
                            class="text-sm font-medium tracking-wide text-gray-600 dark:text-gray-400 uppercase space-x-2 inline-block md:mr-9 mr-9">
                            @if ($appointment->patient->user->gender == 'male')
                                <span><i class="fa-solid fa-mars" style="color: #74C0FC;"></i> Gender :
                                    {{ $appointment->patient->user->gender }} </span>
                            @else
                                <span><i class="fa-solid fa-venus" style="color: #74C0FC;"></i> Gender :
                                    {{ $appointment->patient->user->gender }} </span>
                            @endif
                        </span>
                        <span
                            class="text-sm font-medium tracking-wide text-gray-600 dark:text-gray-400 uppercase space-x-2 inline-block">
                            <span><i class="fa-solid fa-phone" style="color: #74C0FC;"></i> Phone :
                                {{ $appointment->patient->user->phone }}</span>
                        </span>
                        <span class="text-sm font-medium tracking-wide text-gray-600 dark:text-gray-400 uppercase">
                            <i class="fa-solid fa-at" style="color: #74C0FC;"></i> Mail : <a
                                href="mailto:{{ $appointment->patient->user->email }}">{{ $appointment->patient->user->email }}</a></span>
                        <span
                            class="text-sm font-medium tracking-wide text-gray-600 dark:text-gray-400 uppercase ">
                            <i class="fa-solid fa-location-dot" style="color: #74C0FC;"></i> Address :
                            <span class=" break-words ">{{ $appointment->patient->user->address->ville }}
                                ,
                                {{ $appointment->patient->user->address->rue }}</span>
                        </span>

                        <span class="text-sm font-medium tracking-wide text-gray-600 dark:text-gray-400 uppercase">
                            <i class="fa-solid fa-cake-candles" style="color: #74C0FC;"></i> Birthdate :
                            {{ $appointment->patient->birth_date }}</span>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </div>



</x-doctor-layout>
