<head>
    <title>Doctor's appointments</title>
</head>


<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doctor appointments') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason for visit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->appointment_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->reason }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->patient->user->name }}</td>
                                    <!-- Add more columns as needed -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-doctor-layout>
