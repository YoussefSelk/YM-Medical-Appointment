<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Admin\'s Dashboard') }}
            </h2>

        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        {!! __('Welcome <strong>:name</strong> To Admin Panel', ['name' => auth()->user()->name]) !!}
    </div>
    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        {!! __('<strong>Counts</strong> :') !!}

        <div class="card mini_dashboard">
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


            <div class="sub-card mini_dash ">
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

            <div class="sub-card mini_dash">
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
