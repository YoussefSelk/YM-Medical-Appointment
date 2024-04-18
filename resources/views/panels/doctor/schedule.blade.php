<head>

    <title>Doctor's Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>

<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Schedule') }}
        </h2>
    </x-slot>

    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>


    {{--
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

                        <a href="{{route('doctor.CRUD.schedule.edit', [$item->id])}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" >Edit Schedule</a>
                    </td>
                       <td class="px-6 py-4 whitespace-nowrap">

                           <form method="POST" action="{{ route('doctor.schedule.delete', [$item->id]) }}" onsubmit="return confirm('Are you sure you want to delete this schedule?')">
                               @csrf
                               @method('DELETE')
                               <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete Schedule</button>
                           </form>
                        </td>

                   </tr>

            @endforeach

        </tbody>
    </table>
</div> --}}

    <div
        class="overflow-x-auto rounded-md mt-7  p-6 bg-white text-dark-eval-1 shadow-md flex justify-center dark:bg-dark-eval-1">
        <div id="calendar" class="w-full lg:w-3/4 xl:w-2/3"></div>
    </div>

    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="overflow-x-auto">
            <table id="DataTable" class="w-full">
                <thead>
                    <tr>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            #</th>

                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Day</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Start </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            End</th>

                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedule as $item)
                        <tr class="transition-all duration-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                {{ $item->id }}</td>

                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                {{ ucfirst($item->day) }}</td>
                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                {{ $item->start }}</td>
                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                {{ $item->end }}
                            </td>

                            <td
                            class="px-5 py-2 text-right flex justify-around border-b border-gray-200 dark:border-gray-700 items-center flex-row">
                                <a href="{{ route('doctor.CRUD.schedule.edit', [$item->id]) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 mr-2"><i
                                        class="fa-regular fa-pen-to-square"></i></a>

                                <form id= "deleteForm_{{ $item->id }}" method="POST" action="{{ route('doctor.schedule.delete', [$item->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"  onclick="confirmDelete('{{ $item->id }}')" class="font-medium text-red-600 dark:text-red-500 h-0">
                                    <i
                                    class="fa-solid fa-trash"></i>
                                        </button>
                                </form>
                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
