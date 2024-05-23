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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Appointment Details') }}
        </h2>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>
    <div class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('patiens.my.appointments', Auth::user()->patient->id) }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                         My Appointments
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Appointment
                            Details</span>
                    </div>
                </li>
            </ol>
        </nav>

    </div>
    <div class="py-6 px-4 sm:p-6 lg:p-8 bg-white dark:bg-dark-eval-1 shadow sm:rounded-md">
        <div class="mb-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                Appointment Details
            </h3>
        </div>
        <div class="bg-white dark:bg-dark-eval-2 shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Patient Name
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300">
                            {{ $appointment->patient->user->name }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Patient Email
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300">
                            {{ $appointment->patient->user->email }}
                        </dd>
                    </div>
                    <!-- ... other details -->
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Doctor Name
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300">
                            {{ $appointment->doctor->user->name }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Doctor Email
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300">
                            {{ $appointment->doctor->user->email }}
                        </dd>
                    </div>
                    <!-- ... other details -->
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Appointment Status
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300">

                            @if ($appointment->status == 'Pending')
                                <span
                                    class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $appointment->status }}</span>
                            @elseif ($appointment->status == 'Expired')
                                <span
                                    class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $appointment->status }}</span>
                            @elseif ($appointment->status == 'Cancelled')
                                <span
                                    class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $appointment->status }}</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
            @if ($appointment->status == 'Pending')
                <form action="{{ route('patiens.appointment.detail.cancel', $appointment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <x-button type="submit" variant="danger" class=" ">Cancel The Appointmrnt</x-button>
                    </div>

                </form>
            @elseif ($appointment->status == 'Approved')
                <div
                    class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-center flex-col">
                    <h2 class="mb-2 font-semibold text-xl text-gray-800 leading-tight">
                        <span class="mr-2"><i class="fa-solid fa-star" style="color: #74C0FC;"></i></span>
                        {{ __('Doctor Rating') }}
                    </h2>
                    @php
                        $patient_id = Auth::user()->patient->id;
                        $doctor = $appointment->doctor;
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


                        <button type="submit"
                            class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Submit
                            Rating</button>
                        <p id="messageResponse" class="mt-2 text-sm"></p>
                    </form>
                </div>
            @endif
        </div>
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
