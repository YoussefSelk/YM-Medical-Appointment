<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Schedules Page') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Doctors List') }}
        </h2>
        <div class="mt-10">
            <table class="min-w-full divide-y divide-gray-200" id="DataTable">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr class="dark:bg-dark-eval-1">
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Doctor Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Speciality
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Schedule
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($doctors as $doctor)
                        <tr class="dark:bg-dark-eval-1">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $doctor->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $doctor->speciality->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $doctor->user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.doctor.schedule', $doctor->id) }}"
                                    class="text-blue-600 hover:text-blue-900"> <i
                                        class="fa-regular fa-calendar-days"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
@include('includes.table')
