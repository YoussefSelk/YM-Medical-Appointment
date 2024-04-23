<head>

    <title>Doctor's Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>

<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('') }}
        </h2>
    </x-slot>

    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>

    <div class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <h2 class="mb-2 font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('My Schedule') }}
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
                                        action="{{ route('doctor.schedule.delete', $item->id) }}"
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
        class="overflow-x-auto rounded-md mt-7  p-6 bg-white text-dark-eval-1 shadow-md flex justify-center dark:bg-dark-eval-1">
        <div id="calendar" class="w-full lg:w-3/4 xl:w-2/3"></div>
    </div>


    <div
            class="p-3 mt-7 bg-white overflow-hidden sm:rounded-lg dark:bg-dark-eval-1 dark:text-gray-400 flex flex-row justify-center ">
            <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
                <p>Add Schedule</p>
            </div>

            <form action="{{ route('doctor.schedule.add', ['id' => $doctor->id]) }}" method="POST"
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



</x-doctor-layout>
@include('includes.table')
<script src="{{ asset('js/fullcalendar/doctor_schedules.js') }}"></script>

<script>
    function confirmDelete(itemId) {
        Swal.fire({
            title: 'Are you sure you want to delete this Schedule ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the specific form for the patient
                document.getElementById('deleteForm_' + itemId).submit();
            }
        });
    }
</script>

<script>
    document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
        checkbox.addEventListener('change', (event) => {
            event.target.nextElementSibling.classList.toggle('bg-blue-500', checkbox.checked);
            event.target.nextElementSibling.classList.toggle('text-white', checkbox.checked);
        });
    });
</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{--
<script>
    $(document).ready(function() {
        $.ajax({
            url: '{{ route('doctor.schedule', $doctor->id) }}',
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
</script> --}}
