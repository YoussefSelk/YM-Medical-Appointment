<head>
    <title>YM | My Appointments List</title>
</head>
<x-patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Appointments List') }}
        </h2>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>
    <div
        class="p-6 mt-7 overflow-hidden bg-white dark:bg-dark-eval-1 rounded-md shadow-md flex justify-center items-center">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 ">
            <div class="p-6 bg-white dark:bg-dark-eval-2 rounded-md ">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Appointments</h3>
                <p class="text-blue-500 text-3xl dark:text-blue-400">{{ count(Auth::user()->patient->Appointments) }}</p>
            </div>
            <div class="p-6 bg-white dark:bg-dark-eval-2 rounded-md ">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pending Appointments</h3>
                <p class="text-blue-500 text-3xl dark:text-blue-400">
                    {{ count(Auth::user()->patient->appointments()->where('status', 'Pending')->get()) }}</p>
            </div>
            <div class="p-6 bg-white dark:bg-dark-eval-2 rounded-md ">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Completed or Expired Appointments
                </h3>
                <p class="text-blue-500 text-3xl dark:text-blue-400">
                    {{ count(Auth::user()->patient->appointments()->where('status', 'expired')->get()) }}</p>
            </div>
        </div>
    </div>


    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="overflow-x-auto">
            <table id="DataTable" class="w-full">
                <thead>
                    <tr>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Numero de rendez-vous</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Reason</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Appointment Date</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Doctor Name</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Starting Hour</th>
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
                                {{ $item->reason }}</td>
                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                {{ $item->appointment_date }}</td>
                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                {{ $item->doctor->user->name }}</td>
                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                {{ $item->schedule->start }}</td>
                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                @if ($item->status == 'Pending')
                                    <span
                                        class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $item->status }}</span>
                                @elseif ($item->status == 'expired')
                                    <span
                                        class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $item->status }}</span>
                                @elseif ($item->status == 'Cancelled')
                                    <span
                                        class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                <a href="{{ route('patiens.appointment.detail', $item->id) }}"
                                    class="text-blue-600 hover:text-blue-900">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-patient-layout>
@include('includes.table')
