<head>

</head>

<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Patients') }}
        </h2>
    </x-slot>


    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>

    <div
     class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
    <form action="{{ route('doctor.patient.book.appointment.submit',  [$patient->id]) }}" method="POST">
         @csrf
        <div class="mb-4">
            <label for="doctor_id" class="block text-gray-700 text-sm font-bold mb-2">Choose a doctor:</label>
            <select id="doctor_id" name="doctor_id"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->user->name }}</option>
                @endforeach
            </select>
        </div>

         <div class="mb-4">
            <label for="reason" class="block text-gray-700 text-sm font-bold mb-2">Cause pour le
                rendez-vous:</label>
            <textarea name="reason" id="reason" cols="30" rows="5"
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





</x-doctor-layout>
{{--
<script>
    $(document).ready(function() {
        $('#appointment_date').change(function() {
            var selectedDate = $(this).val();
            if (selectedDate) {
                $.ajax({
                    url: "{{ route('doctor.schedules.index') }}",
                    type: "GET",
                    data: {
                        date: selectedDate
                    },
                    success: function(response) {
                        // Fetch appointments for the selected date
                        $.ajax({
                            url: "{{ route('doctor.appointment.index', $doctor->id) }}",
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
</script> --}}


<script>
    function fetchAppointments(doctorId, date) {
        $.ajax({
            url: "{{ route('doctor.appointment.index') }}",
            type: "GET",
            data: {
                doctor_id: doctorId,
                date: date
            },
            success: function(appointments) {
                // Process appointments here
                console.log("Appointments:", appointments);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    $(document).ready(function() {
        $('#appointment_date').change(function() {
            var selectedDate = $(this).val();
            var selectedDoctorId = $('#doctor_id').val();
            if (selectedDate && selectedDoctorId) {
                $.ajax({
                    url: "{{ route('doctor.schedules.index') }}",
                    type: "GET",
                    data: {
                        doctor_id: selectedDoctorId,
                        date: selectedDate
                    },
                    success: function(response) {
                        fetchAppointments(selectedDoctorId, selectedDate); // Fetch appointments for the selected doctor and date
                        $('#appointment_time').empty();
                        if (response.schedules.length === 0) {
                            $('#appointment_time').append(
                                '<option value="">No schedules available for this date</option>'
                            );
                        } else {
                            response.schedules.forEach(function(schedule) {
                                $('#appointment_time').append(
                                    '<option value="' + schedule.id + '">' + schedule.start + '</option>'
                                );
                            });
                        }
                        $('#appointment_time').prop('disabled', false);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
