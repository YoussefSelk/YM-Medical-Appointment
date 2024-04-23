<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Patients') }}
        </h2>
    </x-slot>


    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>

    <div class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('doctor.mypatients') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                         My Patients
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Book
                           an Appointment</span>
                    </div>
                </li>
            </ol>
        </nav>

    </div>


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
            <label for="appointment_datee" class="block text-gray-700 text-sm font-bold mb-2">Choose a date:</label>
            <input type="date" id="appointment_datee" name="appointment_datee"
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


<script>
    $(document).ready(function() {
        $('#appointment_datee').change(function() {
            var selectedDate = $(this).val();
            var doctorID = $('#doctor_id').val();
            if (selectedDate) {
                $.ajax({
                    url: "{{ route('doctor.schedules.getAvailableHours') }}",
                    type: "GET",
                    data: {
                        date: selectedDate ,
                        doctor_id: doctorID
                    },
                    success: function(response) {
                        // Fetch appointments for the selected date
                        $.ajax({
                            url: "{{ route('doctor.appointment.index') }}",
                            type: "GET",
                            data: {
                                date: selectedDate ,
                                doctor_id: doctorID
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

