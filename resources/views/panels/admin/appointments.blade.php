<x-admin-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight ">
                {{ __('Appointments Page') }}
            </h2>

        </div>
    </x-slot>

    <div class="p-6 mt-7  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Appointments List') }}
        </h2>
        <div class="mt-4">
            <table class="min-w-full divide-y divide-gray-200" id="DataTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Patient Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Doctor Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Appointment Date
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Appointment Start Hour
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Appointment Reason
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Appointment Day
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($appointments as $appointment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($appointment->id) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->patient->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->doctor->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->appointment_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->schedule->start }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->reason }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->schedule->day }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">

                                <button type="button" class="text-red-600 hover:text-red-900"
                                    onclick="confirmDelete({{ $appointment->id }})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-admin-layout>
@include('includes.table')
