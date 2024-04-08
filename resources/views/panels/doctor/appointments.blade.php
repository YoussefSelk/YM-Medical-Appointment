<head>
    <title>My appointments</title>
</head>


<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My appointments') }}
        </h2>
    </x-slot>
    {{-- <div class=" p-6 mt-7  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1" >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table id="appointmentsTable" class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason for visit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->appointment_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->reason }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->patient->user->name }}</td>
                                    <td class=" @if($appointment->status === 'Pending')
                                    text-yellow-500
                                @elseif($appointment->status === 'Expired')
                                    text-red-500
                                @elseif($appointment->status === 'Cancelled')
                                    text-gray-500
                                @else
                                    text-green-500
                                @endif">{{$appointment->status}}</td>
                                <td> <a href="{{route('doctor.CRUD.appointment.edit', [$appointment->id])}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit appointment</a> </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}


    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="overflow-x-auto">
            <table id="appointmentsTable" class="w-full">
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
                                 <a href="{{route('doctor.CRUD.appointment.edit', [$item->id])}}" class="text-blue-600 hover:text-blue-900">Edit appointment</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


</x-doctor-layout>
@include('includes.table')
