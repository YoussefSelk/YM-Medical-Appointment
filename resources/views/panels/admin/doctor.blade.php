<head>
    <link rel="stylesheet" href="{{ asset('css/admin_doctor.css') }}">
</head>
<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Doctors Page') }}
            </h2>

        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="card content_All_doctors">
            <div class="doctor_count_container">
                <p class="doctor_count">All Doctors (
                <p class="doctor_count_number">{{ count($doctors) }}</p>)</p>
            </div>
            <div class="AddDoc_container">
                <p class="AddDoc">Add New Doctor</p>
                <button id="AddDoc" > + Add New</button>
            </div>
        </div>
    </div>
    
</x-admin-layout>