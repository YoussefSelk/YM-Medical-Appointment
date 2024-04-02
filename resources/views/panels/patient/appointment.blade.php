<x-patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doctors List') }}
        </h2>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>
    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-center flex-col">
        <h2 class="mb-2 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doctor Information') }}
        </h2>
        <div class="p-6 mt-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="DataTable">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="bg-gray-50">
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start
                            Time</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End
                            Time
                        </th>
                    </tr>
                </thead>
                <tbody class=" bg-white divide-y divide-gray-200">
                    @foreach ($schedule as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($item->day) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->start }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->end }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div
        class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-center flex-col">

        <form action="{{ route('patiens.doctor.book.appointment.submit', [$doctor->id, Auth::user()->patient->id]) }}"
            method="POST">
            @csrf
            <div class="mb-4">
                <label for="reason_for_appointment" class="block text-gray-700 text-sm font-bold mb-2">Cause pour le
                    rendez-vous:</label>
                <textarea name="reason_for_appointment" id="reason_for_appointment" cols="30" rows="5"
                    placeholder="Donner la cause pour le rendez-vous"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>
            <div class="mb-4">
                <label for="appointment_date" class="block text-gray-700 text-sm font-bold mb-2">Choose a date:</label>
                <input type="date" id="appointment_date" name="appointment_date"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    min="{{ date('Y-m-d') }}">
            </div>
            <div class="mb-4">
                <label for="appointment_time" class="block text-gray-700 text-sm font-bold mb-2">Choose a time:</label>
                <select id="appointment_time" name="appointment_time"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    disabled>
                    <option value="">Select a date first</option>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Book</button>
            </div>
        </form>



    </div>
</x-patient-layout>
@include('includes.table')
<script>
    $(document).ready(function() {
        $('#appointment_date').change(function() {
            var selectedDate = $(this).val();
            if (selectedDate) {
                $.ajax({
                    url: "{{ route('patiens.doctor.book.appointment.getHours', $doctor->id) }}",
                    type: "GET",
                    data: {
                        date: selectedDate
                    },
                    success: function(response) {
                        // Fetch appointments for the selected date
                        $.ajax({
                            url: "{{ route('fetch.appointments', $doctor->id) }}",
                            type: "GET",
                            data: {
                                date: selectedDate
                            },
                            success: function(appointments) {
                                $('#appointment_time').empty();
                                if (response.length === 0) {
                                    $('#appointment_time').append(
                                        '<option value="">No schedules available for this date</option>'
                                    );
                                } else {
                                    var availableSchedules = response.filter(
                                        function(schedule) {
                                            return !appointments.some(
                                                function(appointment) {
                                                    return schedule
                                                        .id ==
                                                        appointment
                                                        .schedule_id &&
                                                        appointment
                                                        .status ==
                                                        'Pending';
                                                });
                                        });

                                    if (availableSchedules.length === 0) {
                                        $('#appointment_time').append(
                                            '<option value="">No available schedules for this date</option>'
                                        );
                                    } else {
                                        availableSchedules.forEach(function(
                                            schedule) {
                                            $('#appointment_time')
                                                .append(
                                                    '<option value="' +
                                                    schedule.id + '">' +
                                                    schedule.start +
                                                    '</option>');
                                        });
                                    }
                                }
                                $('#appointment_time').prop('disabled', false);
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                            }
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
