<head>
    <title>My appointments</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
</head>


<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My appointments') }}
        </h2>
    </x-slot>


    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>

    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="overflow-x-auto">
            <table id="DataTable" class="w-full">
                <thead>
                    <tr>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            #</th>

                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Date</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Patient </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Reason</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Status</th>

                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $item)
                        <tr class="transition-all duration-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                {{ $item->id }}</td>

                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                {{ $item->appointment_date }}</td>
                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                {{ $item->patient->user->name }}</td>
                            <td class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                {{ $item->reason }}
                            </td>

                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                @if ($item->status == 'Pending')
                                    <span
                                        class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $item->status }}</span>
                                @elseif ($item->status == 'Expired')
                                    <span
                                        class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $item->status }}</span>
                                @elseif ($item->status == 'Cancelled')
                                    <span
                                        class="bg-gray-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $item->status }}</span>
                                @else
                                    <span
                                        class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $item->status }}</span>
                                @endif
                            </td>

                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                 <a href="{{route('doctor.CRUD.appointment.edit', [$item->id])}}" class="font-medium text-blue-600 dark:text-blue-500 mr-2"><i
                                    class="fa-regular fa-pen-to-square"></i>
                                 </a>

                                    <a href="{{ route('doctor.CRUD.appointment.details', [$item->id]) }}"  class="font-medium text-blue-600 dark:text-blue-500 "><i
                                        class="fa-regular fa-eye"></i>
                                    </a>
                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="overflow-x-auto p-6 bg-white text-dark-eval-1 shadow-md flex justify-center dark:bg-dark-eval-1">
        <div id="calendar" class="w-full lg:w-3/4 xl:w-2/3"></div>
    </div>



    @include('includes.table')
</x-doctor-layout>

<script src="{{ asset('js/fullcalendar/doctor_calendar.js') }}"></script>
