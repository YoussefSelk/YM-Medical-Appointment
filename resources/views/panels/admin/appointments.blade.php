<x-admin-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Appointments Page') }}
            </h2>
        </div>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>
    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <h2>
            <strong>All Appointments </strong>(<span class="text-blue-600">{{ count($appointments) }}</span>)
        </h2>
    </div>
    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Appointments List') }}
        </h2>
        <div class="mt-4">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600" id="DataTable">
                <thead class="bg-gray-50 dark:bg-gray-800">
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
                        <th>
                            Appointment Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-700">
                    @foreach ($appointments as $appointment)
                        <tr class="dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                                {{ ucfirst($appointment->id) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                                {{ $appointment->patient->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                                {{ $appointment->doctor->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                                {{ $appointment->appointment_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                                {{ $appointment->schedule->start }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                                {{ $appointment->reason }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                                {{ $appointment->schedule->day }}</td>
                            <td>
                                @if ($appointment->status == 'Pending')
                                    <span
                                        class="bg-yellow-100 text-yellow-800 dark:bg-yellow-500 dark:text-yellow-100 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $appointment->status }}</span>
                                @elseif ($appointment->status == 'expired')
                                    <span
                                        class="bg-red-100 text-red-800 dark:bg-red-500 dark:text-red-100 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $appointment->status }}</span>
                                @elseif ($appointment->status == 'Cancelled')
                                    <span
                                        class="bg-red-100 text-red-800 dark:bg-red-500 dark:text-red-100 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $appointment->status }}</span>
                                @elseif ($appointment->status == 'Approved')
                                    <span
                                        class="bg-green-100 text-green-800 dark:bg-green-500 dark:text-green-100 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $appointment->status }}</span>
                                @endif
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200 flex justify-center items-center">
                                <a href="{{ route('admin.appointment.view', $appointment->id) }}"
                                    class="text-blue-600 hover:text-blue-900">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-admin-layout>
@include('includes.table')
