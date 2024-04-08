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
                    <a href="{{ route('admin.doctor') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Doctor
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Doctor
                            Details</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    <div class="p-6 mt-2 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <h2 class="text-xl mb-4 font-semibold leading-tight ">
            {{ __('Doctor Details ') }}
        </h2>
        <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-md">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Name</p>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-300">
                    {{ $doctor->user->name }}</p>
            </div>
            <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-md">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Email</p>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-300">
                    {{ $doctor->user->email }}</p>
            </div>
            <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-md">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Phone</p>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-300">
                    +212 {{ $doctor->user->phone }}</p>
            </div>
            <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-md">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Gender</p>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-300">
                    {{ $doctor->user->gender }}</p>
            </div>
            <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-md">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Birthdate</p>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-300">
                    {{ $doctor->birth_date }}</p>
            </div>
            <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-md">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Speciality</p>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-300">
                    {{ $doctor->speciality->name }}</p>
            </div>
        </div>
        <hr class="my-5">
        <h2 class="text-xl mb-4 font-semibold leading-tight ">
            {{ __('Patient Appointments Details ') }}
        </h2>
        <div class="">
            <table id="DataTable" class="">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Appointment Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Starting Hour</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($doctor->appointments as $item)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4">{{ $item->id }}</td>
                            <td class="px-6 py-4">{{ $item->reason }}</td>
                            <td class="px-6 py-4">{{ $item->appointment_date }}</td>
                            <td class="px-6 py-4">{{ $item->patient->user->name }}</td>
                            <td class="px-6 py-4">{{ $item->schedule->start }}</td>
                            <td class="px-6 py-4">
                                @if ($item->status == 'Pending')
                                    <span
                                        class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $item->status }}</span>
                                @elseif ($item->status == 'expired')
                                    <span
                                        class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $item->status }}</span>
                                @elseif ($item->status == 'Cancelled')
                                    <span
                                        class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $item->status }}</span>
                                @elseif ($item->status == 'Approved')
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200 flex justify-center items-center">
                                <a href="{{ route('admin.appointment.view', $item->id) }}"
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
