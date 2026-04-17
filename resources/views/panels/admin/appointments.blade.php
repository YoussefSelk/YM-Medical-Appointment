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

    <div class="mt-7 overflow-hidden rounded-md bg-white p-6 dark:bg-dark-eval-1">
        <h2><strong>All Appointments </strong>(<span class="text-blue-600">{{ count($appointments) }}</span>)</h2>
    </div>

    <div class="mt-7 overflow-hidden rounded-md bg-white p-6 dark:bg-dark-eval-1">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">{{ __('Appointments List') }}</h2>

        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600" id="DataTable">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">#</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Patient Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Doctor Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Appointment Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Appointment Start Hour</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Appointment Reason</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Appointment Day</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Appointment Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white dark:bg-gray-700">
                    @foreach ($appointments as $appointment)
                        <tr class="dark:border-gray-700 dark:bg-gray-800">
                            <td class="whitespace-nowrap px-6 py-4 text-gray-900 dark:text-gray-200">{{ ucfirst($appointment->id) }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-900 dark:text-gray-200">{{ $appointment->patient->user->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-900 dark:text-gray-200">{{ $appointment->doctor->user->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-900 dark:text-gray-200">{{ $appointment->appointment_date }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-900 dark:text-gray-200">{{ $appointment->schedule->start }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-900 dark:text-gray-200">{{ $appointment->reason }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-900 dark:text-gray-200">{{ $appointment->schedule->day }}</td>
                            <td>
                                @if ($appointment->status == 'Pending')
                                    <span class="me-2 rounded bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-500 dark:text-yellow-100">{{ $appointment->status }}</span>
                                @elseif ($appointment->status == 'Expired' || $appointment->status == 'Cancelled')
                                    <span class="me-2 rounded bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-500 dark:text-red-100">{{ $appointment->status }}</span>
                                @elseif ($appointment->status == 'Approved')
                                    <span class="me-2 rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-500 dark:text-green-100">{{ $appointment->status }}</span>
                                @endif
                            </td>
                            <td class="flex items-center justify-center whitespace-nowrap px-6 py-4 text-gray-900 dark:text-gray-200">
                                <a href="{{ route('admin.appointment.view', $appointment->id) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('includes.table')
</x-admin-layout>
