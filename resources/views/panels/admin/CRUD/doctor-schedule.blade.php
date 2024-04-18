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
        <h2 class="mb-2 font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Doctor Schedules') }}
        </h2>
        @php
            $groupedSchedule = [];
            foreach ($schedule as $item) {
                $groupedSchedule[$item->day][] = $item;
            }
        @endphp

        @if (count($groupedSchedule) > 0)
            <div class="p-6 mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($groupedSchedule as $day => $items)
                    <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-md">
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-300">{{ ucfirst($day) }}</p>
                        <div class="grid grid-cols-1 gap-4 mt-2">
                            @foreach ($items as $item)
                                <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-md shadow-md  ">
                                    <div class="text-xs text-gray-700 uppercase dark:text-gray-400"> <span
                                            class="mr-2"><i class="fa-regular fa-clock"
                                                style="color: #74C0FC;"></i></span>{{ $item->start }} --
                                        {{ $item->end }}</div>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form id="deleteForm_{{ $item->id }}"
                                            action="{{ route('admin.doctor.schedule.delete', $item->id) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type="button" class="text-red-600 hover:text-red-900"
                                            onclick="confirmDelete({{ $item->id }})">Delete</button>
                                    </td>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-6 mt-6 text-center">
                <p class="text-lg font-semibold text-gray-800 dark:text-white">No schedules available</p>
                <!-- Add any additional design or message here to indicate no schedules -->
            </div>
        @endif
    </div>

    <div
        class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-center flex-col">
        <h2 class="mb-2 font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Doctor Informations') }}
        </h2>
        <div class="p-4 flex flex-col md:flex-row justify-between">
            <div
                class="md:mr-3 md:mb-0 mb-4 md:w-auto w-full md:flex-none flex items-center justify-center md:flex-row">
                <span class="mr-4">
                    @if ($doctor->user->img)
                        <img src="{{ asset('storage/profile_pictures/' . $doctor->user->img) }}" alt="Profile Picture"
                            class="w-32 h-32 md:rounded-2xl sm:rounded-2xl ">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ $doctor->user->name }}" alt="test"
                            class="w-32 h-32 rounded-2xl  md:rounded-2xl sm:rounded-2xl">
                    @endif
                </span>

                <div class="md:mt-0 mt-4 md:ml-4 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-medium leading-tight text-gray-900 dark:text-white">
                            {{ $doctor->user->name }}
                        </h3>
                        <p class="text-gray-700 dark:text-gray-400">{{ $doctor->speciality->name }}</p>
                        <div class="flex items-center mt-2 md:mt-4">
                            <span class="mr-2"><i class="fa-solid fa-star" style="color: #29a2ff;"></i></span>
                            <span>{{ $doctor->avg_rating }}</span>
                            <span class="ml-2">Review ({{ $doctor->ratings->count() }})</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ml-1 mt-2 md:mt-4 md:text-center md:flex md:flex-col md:items-center">
                <div class="flex flex-col md:items-start items-center ">
                    <div class="flex flex-col items-start ">
                        <span
                            class="text-sm font-medium tracking-wide text-gray-600 dark:text-gray-400 uppercase space-x-2 inline-block md:mr-9 mr-9">
                            @if ($doctor->user->gender == 'male')
                                <span><i class="fa-solid fa-mars" style="color: #74C0FC;"></i> Gender :
                                    {{ $doctor->user->gender }} </span>
                            @else
                                <span><i class="fa-solid fa-venus" style="color: #74C0FC;"></i> Gender :
                                    {{ $doctor->user->gender }} </span>
                            @endif
                        </span>
                        <span
                            class="text-sm font-medium tracking-wide text-gray-600 dark:text-gray-400 uppercase space-x-2 inline-block">
                            <span><i class="fa-solid fa-phone" style="color: #74C0FC;"></i> Phone :
                                {{ $doctor->user->phone }}</span>
                        </span>
                        <span class="text-sm font-medium tracking-wide text-gray-600 dark:text-gray-400 uppercase">
                            <i class="fa-solid fa-at" style="color: #74C0FC;"></i> Mail : <a
                                href="mailto:{{ $doctor->user->email }}">{{ $doctor->user->email }}</a></span>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="mb-2 mt-4 font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Doctor Schedule  Management') }}
        </h2>
        <div class="p-3 mt-7 bg-white overflow-hidden sm:rounded-lg dark:bg-dark-eval-1 flex flex-row justify-center">

            <form action="{{ route('admin.doctor.schedule.submit', $doctor->id) }}" method="POST"
                class="flex flex-col space-y-4 bg-white rounded-lg p-6 dark:bg-dark-eval-2">
                @csrf
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-50 dark:bg-dark-eval-2">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Day</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Start
                                Time</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-dark-eval-2">
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
                                                value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00"
                                                class="hidden dark:bg-transparent dark:border-gray-600">
                                            <label for="{{ $day }}_{{ $i }}"
                                                class="text-sm px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md cursor-pointer dark:bg-gray-700 dark:text-white">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                                                - {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:30</label>
                                        </div>
                                    @endfor
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-600">Save
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
