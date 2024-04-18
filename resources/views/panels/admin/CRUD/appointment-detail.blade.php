<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Appointment Details Page') }}
            </h2>
        </div>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>
    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.appointments') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Appointments
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Appointments
                            Details</span>
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
            @elseif ($appointment->status == 'expired')
                <span
                    class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium px-2.5 py-0.5 rounded">{{ $appointment->status }}</span>
            @elseif ($appointment->status == 'Cancelled')
                <span
                    class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium px-2.5 py-0.5 rounded">{{ $appointment->status }}</span>
            @elseif ($appointment->status == 'Approved')
                <span
                    class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ $appointment->status }}</span>
            @endif
        </p>
    </div>

    <div class=" mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="p-6 bg-white dark:bg-dark-eval-2 overflow-hidden sm:rounded-lg">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Doctor Details') }}
            </h2>
            <div class="p-4 flex flex-col md:flex-row justify-between">
                <div
                    class="md:mr-3 md:mb-0 mb-4 md:w-auto w-full md:flex-none flex items-center justify-center md:flex-row">
                    <span class="mr-4">
                        @if ($appointment->doctor->user->img)
                            <img src="{{ asset('storage/profile_pictures/' . $appointment->doctor->user->img) }}"
                                alt="Profile Picture" class="w-32 h-32 md:rounded-2xl sm:rounded-2xl ">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ $appointment->doctor->user->name }}"
                                alt="test" class="w-32 h-32 rounded-2xl  md:rounded-2xl sm:rounded-2xl">
                        @endif
                    </span>

                    <div class="md:mt-0 mt-4 md:ml-4 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-medium leading-tight text-gray-900 dark:text-white">
                                {{ $appointment->doctor->user->name }}
                            </h3>
                            <p class="text-gray-700 dark:text-gray-400">{{ $appointment->doctor->speciality->name }}
                            </p>
                            <div class="flex items-center mt-2 md:mt-4">
                                <span class="mr-2"><i class="fa-solid fa-star" style="color: #29a2ff;"></i></span>
                                <span>{{ $appointment->doctor->avg_rating }}</span>
                                <span class="ml-2">Review ({{ $appointment->doctor->ratings->count() }})</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ml-1 mt-2 md:mt-4 md:text-center md:flex md:flex-col md:items-center">
                    <div class="flex flex-col md:items-start items-center ">
                        <div class="flex flex-col items-start ">
                            <span
                                class="text-sm font-medium tracking-wide text-gray-600 dark:text-gray-400 uppercase space-x-2 inline-block md:mr-9 mr-9">
                                @if ($appointment->doctor->user->gender == 'male')
                                    <span><i class="fa-solid fa-mars" style="color: #74C0FC;"></i> Gender :
                                        {{ $appointment->doctor->user->gender }} </span>
                                @else
                                    <span><i class="fa-solid fa-venus" style="color: #74C0FC;"></i> Gender :
                                        {{ $appointment->doctor->user->gender }} </span>
                                @endif
                            </span>
                            <span
                                class="text-sm font-medium tracking-wide text-gray-600 dark:text-gray-400 uppercase space-x-2 inline-block">
                                <span><i class="fa-solid fa-phone" style="color: #74C0FC;"></i> Phone :
                                    {{ $appointment->doctor->user->phone }}</span>
                            </span>
                            <span class="text-sm font-medium tracking-wide text-gray-600 dark:text-gray-400 uppercase">
                                <i class="fa-solid fa-at" style="color: #74C0FC;"></i> Mail : <a
                                    href="mailto:{{ $appointment->doctor->user->email }}">{{ $appointment->doctor->user->email }}</a></span>
                            <span
                                class="text-sm font-medium tracking-wide text-gray-600 dark:text-gray-400 uppercase"><i
                                    class="fa-solid fa-location-dot" style="color: #74C0FC;"></i> Address :
                                <span class=" break-words max-w-64">{{ $appointment->doctor->user->address->ville }} ,
                                    {{ $appointment->doctor->user->address->rue }}</span></span>
                            <span class="text-sm font-medium tracking-wide text-gray-600 dark:text-gray-400 uppercase">
                                <i class="fa-solid fa-cake-candles" style="color: #74C0FC;"></i> Birthdate :
                                {{ $appointment->doctor->birth_date }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Patient Details') }}
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
        @if ($appointment->status == 'Pending')
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 flex flex-row justify-end">
                <form action="{{ route('admin.appointment.detail.cancel', $appointment->id) }}" method="POST"
                    class="mt-4">
                    @csrf
                    @method('PUT')

                    <x-button type="submit" variant="danger" class="mr-4">Cancel The Appointment</x-button>

                </form>
                <form action="{{ route('admin.appointment.detail.approve', $appointment->id) }}" method="POST"
                    class="mt-4">
                    @csrf
                    @method('PUT')

                    <x-button type="submit" variant="success">Approve The Appointment</x-button>

                </form>
            </div>
        @endif

    </div>

</x-admin-layout>
