<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight ">
                {{ __('Edit Doctor Schedules Page') }}
            </h2>

        </div>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>
    <div class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">


        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.schedules') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Doctors Schedules
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Edit
                            Doctor Schedules</span>
                    </div>
                </li>
            </ol>
        </nav>

    </div>
    <div class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="DataTable">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-gray-50">
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start
                        Time</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($schedule as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($item->day) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->start }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->end }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-center">
        <div
            class="p-1 mt-7 bg-white max-w-2xl shadow overflow-hidden sm:rounded-lg dark:bg-dark-eval-1 dark:text-gray-400 mr-4">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    Doctor Information
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-white">
                    Details and informations about Doctor.
                </p>
            </div>
            <div class="border-t  border-gray-200 dark:bg-dark-eval-1 dark:text-gray-400">
                <dl>
                    <div
                        class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-dark-eval-1 dark:text-white">
                        <dt class="text-sm font-medium text-gray-500 dark:text-white ">
                            Full name
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-400">
                            {{ $doctor->user->name }}
                        </dd>
                    </div>
                    <div
                        class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-dark-eval-1 dark:text-white">
                        <dt class="text-sm font-medium text-gray-500 dark:text-white">
                            Speciality
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-400">
                            {{ $doctor->speciality->name }}
                        </dd>
                    </div>
                    <div
                        class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-dark-eval-1 dark:text-white">
                        <dt class="text-sm font-medium text-gray-500 dark:text-white">
                            Email address
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-400">
                            {{ $doctor->user->email }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
        <div
            class="p-3 mt-7 bg-white max-w-5xl shadow overflow-hidden sm:rounded-lg dark:bg-dark-eval-1 dark:text-gray-400 flex flex-row justify-center ">

            <form action="{{ route('admin.doctor.schedule.submit', $doctor->id) }}" method="POST"
                class="flex flex-col">
                @csrf
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50">
                        <tr class="h-8 bg-transparent">
                            <th class="w-20">Day</th>
                            <th class="w-20">Start Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                        @endphp
                        @foreach ($days as $day)
                            <tr class="bg-gray-50">
                                <td>{{ ucfirst($day) }}</td>
                                <td class="flex flex-row ">
                                    <input type="checkbox" name="start_times[{{ $day }}][]" value="08:00">
                                    08:00 - 08:30 <br>
                                    <input type="checkbox" name="start_times[{{ $day }}][]" value="09:00">
                                    09:00 - 09:30 <br>
                                    <input type="checkbox" name="start_times[{{ $day }}][]" value="10:00">
                                    10:00 - 10:30 <br>
                                    <input type="checkbox" name="start_times[{{ $day }}][]" value="11:00">
                                    11:00 - 11:30 <br>
                                    <input type="checkbox" name="start_times[{{ $day }}][]" value="12:00">
                                    12:00 - 12:30 <br>
                                    <input type="checkbox" name="start_times[{{ $day }}][]" value="13:00">
                                    13:00 - 13:30 <br>
                                    <input type="checkbox" name="start_times[{{ $day }}][]" value="14:00">
                                    14:00 - 14:30 <br>
                                    <input type="checkbox" name="start_times[{{ $day }}][]" value="15:00">
                                    15:00 - 15:30 <br>
                                    <input type="checkbox" name="start_times[{{ $day }}][]" value="16:00">
                                    16:00 - 16:30 <br>
                                    <input type="checkbox" name="start_times[{{ $day }}][]" value="17:00">
                                    17:00 - 17:30 <br>
                                    <input type="checkbox" name="start_times[{{ $day }}][]" value="18:00">
                                    18:00 - 18:30 <br>
                                    <input type="checkbox" name="start_times[{{ $day }}][]" value="19:00">
                                    19:00 - 19:30 <br>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save
                    Slots</button>
            </form>
        </div>

    </div>


</x-admin-layout>
@include('includes.table')
