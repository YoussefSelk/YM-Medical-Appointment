<style>
    .rating {
        display: inline-block;
    }

    .rating input {
        display: none;
    }

    .rating label {
        float: right;
        cursor: pointer;
        color: #ccc;
        transition: color 0.3s;
    }

    .rating label:before {
        content: '\2605';
        font-size: 30px;
    }

    .rating input:checked~label,
    .rating label:hover,
    .rating label:hover~label {
        color: #0077ff;
        transition: color 0.3s;
    }
</style>
<x-patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doctors List') }}
        </h2>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>
    <div class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('patiens.doctors', Auth::user()->patient->id) }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Doctors List
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
                            Appointment</span>
                    </div>
                </li>
            </ol>
        </nav>

    </div>
    <div
        class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-center flex-col">
        <h2 class="mb-2 font-semibold text-xl text-gray-800 leading-tight">
            <span class="mr-2"><i class="fa-solid fa-circle-info"
                    style="color: #74C0FC;"></i></span>{{ __('Doctor Information') }}
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





        <h2 class="mb-2 mt-4 font-semibold text-xl text-gray-800 leading-tight">
            <span class="mr-2"><i class="fa-solid fa-calendar-days" style="color: #74C0FC;"></i></span>
            {{ __('Doctor Schedule') }}
        </h2>
        @php
            $groupedSchedule = [];
            foreach ($schedule as $item) {
                $groupedSchedule[$item->day][] = $item;
            }
        @endphp

        <div class="p-6 mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($groupedSchedule as $day => $items)
                <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-md">
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-300">{{ ucfirst($day) }}</p>
                    <div class="grid grid-cols-1 gap-4 mt-2">
                        @foreach ($items as $item)
                            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-md shadow-md flex justify-center">
                                <div class="text-xs text-gray-700 uppercase dark:text-gray-400"> <span class="mr-2"><i
                                            class="fa-regular fa-clock"
                                            style="color: #74C0FC;"></i></span>{{ $item->start }} --
                                    {{ $item->end }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>



    </div>

    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-center flex-col"
        id="appointment_form_container">
        <h2 class="mb-2 font-semibold text-xl text-gray-800 leading-tight">
            <span class="mr-2"><i class="fa-regular fa-calendar-check" style="color: #74C0FC;"></i></span>
            {{ __('Appointment Form') }}
        </h2>
        @if ($schedule->isNotEmpty())
            <form
                action="{{ route('patiens.doctor.book.appointment.submit', [$doctor->id, Auth::user()->patient->id]) }}"
                method="POST">
                @csrf
                <div class="mb-4">
                    <label for="reason_for_appointment" class="block text-gray-700 text-sm font-bold mb-2">Cause pour le
                        rendez-vous: <span class="ml-2"><i class="fa-solid fa-virus"
                                style="color: #74C0FC;"></i></span></label>
                    <textarea name="reason_for_appointment" id="reason_for_appointment" cols="30" rows="5"
                        placeholder="Donner la cause pour le rendez-vous"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="mb-4">
                    <label for="appointment_date" class="block text-gray-700 text-sm font-bold mb-2">Choose a
                        date: <span class="ml-2"><i class="fa-solid fa-calendar-week"
                                style="color: #74C0FC;"></i></span></label>
                    <input type="date" id="appointment_date" name="appointment_date"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        min="{{ date('Y-m-d') }}">
                </div>
                <div class="mb-4">
                    <label for="appointment_time" class="block text-gray-700 text-sm font-bold mb-2">Choose a
                        time: <span class="ml-2"><i class="fa-regular fa-hourglass-half"
                                style="color: #74C0FC;"></i></span></label>
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
        @else
            <p class="text-red-500"> <span class="mr-2"><i class="fa-solid fa-bug"
                        style="color: #ff0000;"></i></span>Sorry, No schedules available for This Doctor !!!</p>
        @endif

    </div>
    <div
        class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-center flex-col">
        <h2 class="mb-2 font-semibold text-xl text-gray-800 leading-tight">
            <span class="mr-2"><i class="fa-solid fa-star" style="color: #74C0FC;"></i></span>
            {{ __('Doctor Rating') }}
        </h2>
        @php
            $patient_id = Auth::user()->patient->id;
        @endphp
        <form id="ratingForm"
            action="{{ route('patient.doctor.rate', ['D_id' => $doctor->id, 'P_id' => $patient_id]) }}"
            method="POST">
            @csrf
            <div class="flex items-center space-x-2">
                <div class="rating">
                    <input value="5" name="rating" id="star5" type="radio">
                    <label for="star5"></label>
                    <input value="4" name="rating" id="star4" type="radio">
                    <label for="star4"></label>
                    <input value="3" name="rating" id="star3" type="radio">
                    <label for="star3"></label>
                    <input value="2" name="rating" id="star2" type="radio">
                    <label for="star2"></label>
                    <input value="1" name="rating" id="star1" type="radio">
                    <label for="star1"></label>
                </div>
            </div>

            <textarea name="comment" id="message" class="mt-4 w-full px-3 py-2 border rounded-md focus:outline-none"
                placeholder="Enter your message" cols="30" rows="5"></textarea>


            <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Submit
                Rating</button>
            <p id="messageResponse" class="mt-2 text-sm"></p>
        </form>
    </div>
</x-patient-layout>
@include('includes.table')
<script>
    $(document).ready(function() {
        const stars = $('input[name="rating"]');
        const labels = $('label');
        const messageArea = $('#messageResponse');
        const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Retrieve CSRF token value

        stars.on('click', function() {
            removeActive($(this).index());
        });

        function removeActive(index) {
            labels.each(function(i) {
                if (i <= index) {
                    $(this).removeClass('text-gray-400').addClass('text-blue-600');
                } else {
                    $(this).removeClass('text-blue-600').addClass('text-gray-400');
                }
            });
        }

        $('#ratingForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            const selectedRating = $('input[name="rating"]:checked').val();
            const comment = $('#message').val();

            // Send the selectedRating and message to the server via AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in the request headers
                },
                data: {
                    rating: selectedRating,
                    comment: comment
                },
                success: function(response) {
                    console.log('Rating submitted successfully');
                    // Update message area with success message
                    messageArea.text('Rating submitted successfully').removeClass(
                        'text-red-500').addClass('text-green-500');

                    // Clear the form fields
                    $('#ratingForm')[0].reset();

                    // Hide success message after 3 seconds
                    setTimeout(function() {
                        messageArea.text('');
                    }, 3000);
                },
                error: function(error) {
                    console.error('Error submitting rating:', error);
                    // Update message area with error message
                    messageArea.text('Error submitting rating').removeClass(
                        'text-green-500').addClass('text-red-500');
                }
            });
        });
    });
</script>

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
