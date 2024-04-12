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

    <div class="p-6   bg-white  rounded-md shadow-md overflow-hidden flex flex-row justify-around">
        <div class="md:flex justify-center items-center">
            <div class="p-8">
                <div class="uppercase tracking-wide text-sm text-blue-500 font-semibold">Welcome to the Admin Panel</div>
                <div>
                    <p class="mt-2 text-gray-500">{!! __('Welcome <strong>:name</strong>', ['name' => auth()->user()->name]) !!}</p>
                </div>
            </div>
        </div>


        <div class="p-6  bg-white rounded-md dark:bg-dark-eval-1">
            {!! __('<strong>Counts</strong> :') !!}

            <div class="card mini_dashboard mr-2">
                <div class="sub-card mini_dash">
                    <div class="card_content">
                        <div class="card_title">
                            <p class="card_title_number">
                                {{ count($doctors) }}
                            </p>
                            <p class="card_title_name">
                                Doctors
                            </p>
                        </div>
                        <div class="card_icon">
                        </div>
                    </div>
                </div>


                <div class="sub-card mini_dash  mr-2">
                    <div class="card_content">
                        <div class="card_title">
                            <p class="card_title_number">
                                {{ count($patients) }}
                            </p>
                            <p class="card_title_name">
                                Patients
                            </p>
                        </div>
                        <div class="card_icon">

                        </div>
                    </div>
                </div>

                <div class="sub-card mini_dash mr-2">
                    <div class="card_content">
                        <div class="card_title">
                            <p class="card_title_number">
                                {{ count($appointments) }}
                            </p>
                            <p class="card_title_name">
                                Bookings
                            </p>
                        </div>
                        <div class="card_icon">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        class="p-6 mt-7  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-center flex-row">

        <div class="p-6 mt-7 mr-6   overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            {!! __('<strong>Doctor Number By Geneder </strong> :') !!}
            @include('includes.charts.doctor-chart')
        </div>
        <div class="p-6 mt-7  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            {!! __('<strong>Doctor Registred By Date </strong> :') !!}
            @include('includes.charts.doctor-chart-register')
        </div>
    </div>


    <div class="p-6 mt-7  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">

    </div>
    <div class="p-6 mt-7  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">

    </div>
</x-admin-layout>
