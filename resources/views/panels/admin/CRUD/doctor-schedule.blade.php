<style>
    input[type="checkbox"]:disabled+label {
        color: red;
    }
</style>

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight ">
                {{ __('Edit Doctor Schedules Page') }}
            </h2>

        </div>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>
    <div class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">


        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.schedules') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Doctors Schedules
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Edit
                            Doctor Schedules</span>
                    </div>
                </li>
            </ol>
        </nav>

    </div>
    <div class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="DataTable">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-gray-50">
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start
                        Time</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($schedule as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($item->day) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->start }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->end }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form id="deleteForm_{{ $item->id }}"
                                action="{{ route('admin.doctor.schedule.delete', $item->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" class="text-red-600 hover:text-red-900"
                                onclick="confirmDelete({{ $item->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div
        class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-center items-center flex-col">
        <div
            class=" p-6 mt-7 bg-white shadow-lg overflow-hidden sm:rounded-lg dark:bg-dark-eval-1 dark:text-gray-400 mr-4">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    Doctor Information
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-white">
                    Details and informations about Doctor.
                </p>
            </div>
            <div class="border-t border-gray-200 dark:bg-dark-eval-1 dark:text-gray-400">
                <dl>
                    @php
                        $info = [
                            'Full name' => $doctor->user->name,
                            'Speciality' => $doctor->speciality->name,
                            'Email address' => $doctor->user->email,
                        ];
                    @endphp
                    @foreach ($info as $key => $value)
                        <div
                            class="{{ $loop->even ? 'bg-white' : 'bg-gray-50' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-dark-eval-1 dark:text-white">
                            <dt class="text-sm font-medium text-gray-500 dark:text-white">
                                {{ $key }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-400">
                                {{ $value }}
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>

        <div
            class="p-3 mt-7 bg-white overflow-hidden sm:rounded-lg dark:bg-dark-eval-1 dark:text-gray-400 flex flex-row justify-center ">

            <form action="{{ route('admin.doctor.schedule.submit', $doctor->id) }}" method="POST"
                class="flex flex-col space-y-4  bg-white shadow-md rounded-lg p-6">
                @csrf
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Day</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Start Time</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                        @endphp
                        @foreach ($days as $day)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($day) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap flex flex-wrap">
                                    @for ($i = 8; $i <= 19; $i++)
                                        <div class="flex items-center space-x-2 mb-2">
                                            <input id="{{ $day }}_{{ $i }}" type="checkbox"
                                                name="start_times[{{ $day }}][]"
                                                value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00" class="hidden">
                                            <label for="{{ $day }}_{{ $i }}"
                                                class="text-sm text-gray-900 px-4 py-2 border border-gray-300 rounded-md cursor-pointer">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                                                - {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:30</label>
                                        </div>
                                    @endfor
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Save
                    Slots</button>
            </form>

        </div>

    </div>


</x-admin-layout>
@include('includes.table')
<script>
    document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
        checkbox.addEventListener('change', (event) => {
            event.target.nextElementSibling.classList.toggle('bg-blue-500', checkbox.checked);
            event.target.nextElementSibling.classList.toggle('text-white', checkbox.checked);
        });
    });
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: '{{ route('admin.doctor.schedules', $doctor->id) }}',
            type: 'GET',
            data: {
                doctor_id: '{{ $doctor->id }}'
            },
            success: function(response) {
                var schedules = response.schedules;
                for (var i = 0; i < schedules.length; i++) {
                    var day = schedules[i].day.charAt(0).toLowerCase() + schedules[i].day.slice(1);
                    var time = parseInt(schedules[i].start.split(':')[0]);
                    $('input[id="' + day + '_' + time + '"]').prop('disabled', true);
                }
            }
        });
    });
</script>
<script>
    function confirmDelete(scheduleId) {
        Swal.fire({
            title: 'Are you sure you want to delete this schedule?',
            text: 'All related data will be deleted with this item',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                // If confirmed, submit the specific form for the schedule
                document.getElementById('deleteForm_' + scheduleId).submit();
            }
        });
    }
</script>
