<head>
    <title>Admin's Dashboard</title>
</head>
<x-admin-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Admin\'s Dashboard') }}
            </h2>

        </div>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>
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
                    <div class="uppercase tracking-wide text-sm text-blue-500 font-semibold">Welcome to the Admin Panel
                    </div>
                    <div>
                        <p class="mt-2 text-gray-500">{!! __('Welcome <strong>:name</strong>', ['name' => auth()->user()->name]) !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6 bg-white dark:bg-dark-eval-1 rounded-md md:w-1/2">
            <strong class="text-lg text-gray-800 dark:text-gray-200">Counts:</strong>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div class="bg-white dark:bg-gray-800 rounded-md shadow-md p-4 flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ count($doctors) }}</p>
                        <p class="text-gray-500 dark:text-gray-400">Doctors</p>
                    </div>
                    <i class="fa-solid fa-user-doctor text-3xl text-blue-500 dark:text-blue-300"></i>
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
                        <p class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ count($appointments) }}
                        </p>
                        <p class="text-gray-500 dark:text-gray-400">Bookings</p>
                    </div>
                    <i class="fas fa-calendar-check text-3xl text-purple-500 dark:text-purple-300"></i>
                </div>
            </div>
        </div>

    </div>

    <div
        class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex flex-col md:flex-row justify-center md:justify-between">

        <div class="p-6 mt-7 md:mt-0 mr-6 overflow-hidden bg-white rounded-md dark:bg-dark-eval-1 w-full md:w-1/2">
            {!! __('<strong>Doctor Registered By Date</strong> :') !!}
            <div class="chart-container" style="position: relative; height: auto; width: 100%;">
                {!! $Doctor_Chart_Created_At->container() !!}
            </div>
            {!! $Doctor_Chart_Created_At->script() !!}
        </div>
        <div class="p-6 mt-7 md:mt-0 mr-6 overflow-hidden bg-white rounded-md dark:bg-dark-eval-1 w-full md:w-1/2">
            {!! __('<strong>Number Of Doctors by Gender</strong> :') !!}
            <div class="chart-container" style="position: relative; height: auto; width: 100%;">
                {!! $gender_chart->container() !!}
            </div>
            {!! $gender_chart->script() !!}
        </div>

    </div>



    <div
        class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex flex-col md:flex-row justify-center md:justify-between">
        <div class="p-6 mt-7 md:mt-0 mr-6 overflow-hidden bg-white rounded-md dark:bg-dark-eval-1 w-full md:w-1/2">
            {!! __('<strong>Patients Registered By Date</strong> :') !!}
            <div class="chart-container" style="position: relative; height: auto; width: 100%;">
                {!! $Patient_Chart_Created_At->container() !!}
            </div>
            {!! $Patient_Chart_Created_At->script() !!}
        </div>
        <div class="p-6 mt-7 md:mt-0 mr-6 overflow-hidden bg-white rounded-md dark:bg-dark-eval-1 w-full md:w-1/2">
            {!! __('<strong>Number Of Patients by Gender</strong> :') !!}
            <div class="chart-container" style="position: relative; height: auto; width: 100%;">
                {!! $patient_gender_chart->container() !!}
            </div>
            {!! $patient_gender_chart->script() !!}
        </div>
    </div>
    <div
        class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex flex-col md:flex-row justify-center md:justify-between">
        <div class="p-6 mt-7 md:mt-0 mr-6 overflow-hidden bg-white rounded-md dark:bg-dark-eval-1 w-full md:w-1/2">
            {!! __('<strong>Appointments Registered By Date</strong> :') !!}
            <div class="chart-container" style="position: relative; height: auto; width: 100%;">
                {!! $Appointments_Chart_Created_At->container() !!}
            </div>
            {!! $Appointments_Chart_Created_At->script() !!}
        </div>
        <div class="p-6 mt-7 md:mt-0 mr-6 overflow-hidden bg-white rounded-md dark:bg-dark-eval-1 w-full md:w-1/2">
            {!! __('<strong>Number Of Appointments by Status</strong> :') !!}
            <div class="chart-container" style="position: relative; height: auto; width: 100%;">
                {!! $Appointments_Chart_Status->container() !!}

            </div>
            {!! $Appointments_Chart_Status->script() !!}

        </div>
    </div>
</x-admin-layout>
