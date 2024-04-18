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

        <div class="p-6 bg-white rounded-md dark:bg-dark-eval-1 md:w-1/2">
            {!! __('<strong>Counts</strong> :') !!}

            <div class="card mini_dashboard flex flex-wrap justify-center md:justify-around flex-col md:flex-row">
                <div class="sub-card mini_dash mb-4 md:mb-0 md:mr-4">
                    <div class="card_content">
                        <div class="card_title">
                            <p class="card_title_number">{{ count($doctors) }}</p>
                            <p class="card_title_name">Doctors</p>
                        </div>
                        <div class="card_icon"></div>
                    </div>
                </div>

                <div class="sub-card mini_dash mb-4 md:mb-0 md:mr-4">
                    <div class="card_content">
                        <div class="card_title">
                            <p class="card_title_number">{{ count($patients) }}</p>
                            <p class="card_title_name">Patients</p>
                        </div>
                        <div class="card_icon"></div>
                    </div>
                </div>

                <div class="sub-card mini_dash">
                    <div class="card_content">
                        <div class="card_title">
                            <p class="card_title_number">{{ count($appointments) }}</p>
                            <p class="card_title_name">Bookings</p>
                        </div>
                        <div class="card_icon"></div>
                    </div>
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
            {!! __('<strong>######</strong> :') !!}
            <div class="chart-container" style="position: relative; height: auto; width: 100%;">

            </div>

        </div>
    </div>
</x-admin-layout>
