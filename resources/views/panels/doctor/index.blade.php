<head>
    <title>Doctor's Dashboard</title>

</head>

<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doctor Dashboard') }}
        </h2>
    </x-slot>

    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Doctor\'s Dashboard') }}
            </h2>
        </div>
    </x-slot>


    <div class="p-6 mt-7  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <p><strong>Total Appointments:{{ count($appointments) }} </strong> </p>
    </div>


    <div class="p-6 mt-7  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <p>Schedule:{{ count($schedule) }}  </p>
    </div>
</x-doctor-layout>
