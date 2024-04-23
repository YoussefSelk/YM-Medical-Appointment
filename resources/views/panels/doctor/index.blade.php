<head>
    <title>Doctor's Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
                            <p class="card_title_number">{{ count($schedule) }}</p>
                            <p class="card_title_name">Schedules</p>
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



</x-doctor-layout>
