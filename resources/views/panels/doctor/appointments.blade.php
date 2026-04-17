<x-doctor-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
            {{ __('My appointments') }}
        </h2>
    </x-slot>

    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>

    <div class="mt-7 overflow-hidden rounded-md bg-white p-6 dark:bg-dark-eval-1">
        <div class="overflow-x-auto">
            <table id="DataTable" class="w-full">
                <thead>
                    <tr>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">#</th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">Date</th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">Patient</th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">Reason</th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">Status</th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $item)
                        <tr class="transition-all duration-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="border-b border-gray-200 bg-white px-5 py-2 text-sm dark:border-gray-700 dark:bg-gray-800">{{ $item->id }}</td>
                            <td class="border-b border-gray-200 bg-white px-5 py-2 text-sm dark:border-gray-700 dark:bg-gray-800">{{ $item->appointment_date }}</td>
                            <td class="border-b border-gray-200 bg-white px-5 py-2 text-sm dark:border-gray-700 dark:bg-gray-800">{{ $item->patient->user->name }}</td>
                            <td class="border-b border-gray-200 bg-white px-5 py-2 text-sm dark:border-gray-700 dark:bg-gray-800">{{ $item->reason }}</td>

                            <td class="border-b border-gray-200 bg-white px-5 py-2 text-sm dark:border-gray-700 dark:bg-gray-800">
                                @if ($item->status == 'Pending')
                                    <span class="me-2 rounded bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">{{ $item->status }}</span>
                                @elseif ($item->status == 'Expired')
                                    <span class="me-2 rounded bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">{{ $item->status }}</span>
                                @elseif ($item->status == 'Cancelled')
                                    <span class="me-2 rounded bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">{{ $item->status }}</span>
                                @else
                                    <span class="me-2 rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">{{ $item->status }}</span>
                                @endif
                            </td>

                            <td class="border-b border-gray-200 bg-white px-5 py-2 text-sm dark:border-gray-700 dark:bg-gray-800">
                                <a href="{{ route('doctor.CRUD.appointment.edit', [$item->id]) }}" class="mr-2 font-medium text-blue-600 dark:text-blue-500"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a href="{{ route('doctor.CRUD.appointment.details', [$item->id]) }}" class="font-medium text-blue-600 dark:text-blue-500"><i class="fa-regular fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-7 flex justify-center overflow-x-auto rounded-md bg-white p-6 text-dark-eval-1 shadow-md dark:bg-dark-eval-1">
        <div id="calendar" class="w-full lg:w-3/4 xl:w-2/3"></div>
    </div>

    @include('includes.table')

    @push('scripts')
        <script src="{{ asset('js/fullcalendar/doctor_calendar.js') }}"></script>
    @endpush
</x-doctor-layout>
