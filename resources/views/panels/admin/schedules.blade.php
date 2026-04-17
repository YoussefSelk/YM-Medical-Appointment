<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">{{ __('Schedules Page') }}</h2>
        </div>
    </x-slot>

    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>

    <div class="mt-7 overflow-hidden rounded-md bg-white p-6 shadow-md dark:bg-dark-eval-1">
        <h2 class="text-xl font-semibold leading-tight">{{ __('Doctors List') }}</h2>
        <div class="mt-10 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="DataTable">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr class="dark:bg-dark-eval-1">
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Doctor Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Speciality</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Schedule</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($doctors as $doctor)
                        <tr class="dark:bg-dark-eval-1">
                            <td class="whitespace-nowrap px-6 py-4">{{ $doctor->user->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $doctor->speciality->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $doctor->user->email }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <a href="{{ route('admin.doctor.schedule', $doctor->id) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fa-regular fa-calendar-days"></i>
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
