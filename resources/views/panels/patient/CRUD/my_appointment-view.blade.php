<x-patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Appointment Details') }}
        </h2>
    </x-slot>
   <div class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('patiens.my.appointments', Auth::user()->patient->id) }}"
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
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Appointment
                            Details</span>
                    </div>
                </li>
            </ol>
        </nav>

    </div>
    <div class="py-6 px-4 sm:p-6 lg:p-8 bg-white dark:bg-dark-eval-1 shadow sm:rounded-md">
        <div class="mb-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                Appointment Details
            </h3>
        </div>
        <div class="bg-white dark:bg-dark-eval-2 shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Patient Name
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300">
                            {{ $appointment->patient->user->name }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Patient Email
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300">
                            {{ $appointment->patient->user->email }}
                        </dd>
                    </div>
                    <!-- ... other details -->
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Doctor Name
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300">
                            {{ $appointment->doctor->user->name }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Doctor Email
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300">
                            {{ $appointment->doctor->user->email }}
                        </dd>
                    </div>
                    <!-- ... other details -->
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Appointment Status
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300">

                            @if ($appointment->status == 'Pending')
                                <span
                                    class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $appointment->status }}</span>
                            @elseif ($appointment->status == 'expired')
                                <span
                                    class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $appointment->status }}</span>
                            @elseif ($appointment->status == 'Cancelled')
                                <span
                                    class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $appointment->status }}</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
            @if ($appointment->status == 'Pending')
                <form action="{{ route('patiens.appointment.detail.cancel', $appointment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <x-button type="submit" variant="danger" class=" ">Cancel The Appointmrnt</x-button>
                    </div>

                </form>
            @endif

        </div>
    </div>
</x-patient-layout>
