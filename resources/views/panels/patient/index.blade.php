<head>
    <title>YM | Home</title>
</head>

<x-patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Patient Dashboard') }}
        </h2>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>

    <!-- Start of Tawk.to Script -->

    <div
        class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-left animate__animated animate__fadeIn">
        <div class="md:flex justify-center items-center md:w-1/2">
            <div class="p-8 flex items-center">
                <div class="mr-12">
                    @php
                        $user = Auth::user()->img;
                        $patient = Auth::user()->patient;
                    @endphp
                    <img src="{{ $user ? asset('storage/profile_pictures/' . $user) : 'https://ui-avatars.com/api/?name=' . Auth::user()->name }}"
                        alt="Profile Picture"
                        class="w-24 h-24 md:w-36 md:h-36 lg:w-48 lg:h-48 rounded-2xl shadow-md animate__animated animate__fadeInLeft">
                </div>
                <div>
                    <div class="uppercase tracking-wide text-sm text-blue-500 font-semibold">Welcome to YM | Home
                    </div>
                    <div>
                        <p class="mt-2 text-gray-500">{!! __('Welcome <strong>:name</strong>', ['name' => auth()->user()->name]) !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row justify-around">


        <div
            class="w-full md:w-1/2 p-6 mt-7 mr-4 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 animate__animated animate__fadeInRight">
            <div class="flex flex-col justify-center ">
                <h2 class="mb-7 font-semibold text-xl text-gray-800 leading-tight dark:text-white">
                    <span class="mr-2"><i class="fa-regular fa-calendar-check" style="color: #74C0FC;"></i></span> My
                    Appointments
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="appoinments-cards">
                    @foreach ($patient->appointments as $index => $appointment)
                        <div
                            class="bg-white dark:bg-dark-eval-1 rounded-lg shadow-md p-4 appoinments-cards @if ($index >= 6) hidden @endif animate__animated animate__fadeInUp">
                            <h3 class="text-lg font-semibold mb-2">
                                <span class="mr-2">
                                    <i class="fa-solid fa-@php echo "$index" @endphp" style="color: #74C0FC;"></i>
                                </span>
                                {{ $appointment->reason }}
                            </h3>

                            <p class="text-gray-600 mb-2  dark:text-white">Date: {{ $appointment->appointment_date }}</p>
                            <p class="text-gray-600 mb-2  dark:text-white">Doctor: {{ $appointment->doctor->user->name }}</p>
                            <p class="text-gray-600 mb-2  dark:text-white">Status: {{ $appointment->status }}</p>
                            <p class="text-gray-600  dark:text-white">Comment: {{ $appointment->doctor_comment }}</p>
                        </div>
                    @endforeach
                </div>
                @if ($patient->appointments->count() > 6)
                    <button id="show-more-btn-2"
                        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md animate__animated animate__fadeInUp">Show
                        More</button>
                @endif
            </div>
        </div>
        <div
            class="w-full md:w-1/2 p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 animate__animated animate__fadeInRight">
            <div class="flex flex-col justify-center">
                <h2 class="mb-7 font-semibold text-xl text-gray-800 leading-tight dark:text-white   ">
                    <span class="mr-2"><i class="fa-solid fa-suitcase-medical" style="color: #74C0FC;"></i></span> My
                    Medical History
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="medical-history-cards">
                    @foreach ($patient->appointments as $index => $appointment)
                        <div
                            class="bg-white rounded-lg shadow-md dark:bg-dark-eval-1 dark:text-white p-4 medical-history-card  @if ($index >= 9) hidden @endif animate__animated animate__fadeInUp">
                            <span class="mb-4">
                                <i class="fa-solid fa-@php echo "$index" @endphp" style="color: #74C0FC;"></i>
                            </span>
                            <p class="text-gray-600 mb-2 dark:text-white">Doctor: {{ $appointment->doctor->user->name }}</p>
                            <p class="text-gray-600 mb-2 dark:text-white">Status: {{ $appointment->status }}</p>
                        </div>
                    @endforeach
                </div>
                @if ($patient->appointments->count() > 9)
                    <button id="show-more-btn"
                        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md animate__animated animate__fadeInUp">Show
                        More</button>
                @endif
            </div>
        </div>

    </div>
    <!-- Additional Features Section -->
    <div class="p-6 mt-7 bg-white rounded-md shadow-md dark:bg-dark-eval-1 animate__animated animate__fadeIn">
        <h2 class="mb-4 font-semibold text-xl text-gray-800 leading-tight">
            <span class="mr-2"><i class="fa-brands fa-pagelines" style="color: #74C0FC;"></i></span> Additional
            Features
        </h2>
        <div class="flex flex-col md:flex-row justify-between">
            <!-- Feature 1: Appointment Reminder -->
            <div
                class="w-full md:w-1/3 dark:bg-dark-eval-1 p-4 bg-gray-100 rounded-md shadow-md mb-4 md:mb-0 animate__animated animate__fadeInLeft">
                <div class="text-center">
                    <i class="fas fa-clock text-3xl text-blue-500 mb-2"></i>
                    <p class="text-gray-700 font-semibold mb-2 dark:text-white">Appointment Reminder</p>
                    <p class="text-gray-600 dark:text-white">Never miss an Appointment with our Appointment Reminder feature. Take Your
                        Appointment and receive notifications when it's time .</p>
                </div>
            </div>
            <!-- Feature 3: Emergency Contact -->
            <div
                class="w-full dark:bg-dark-eval-1 md:w-1/3 p-4 bg-gray-100 rounded-md shadow-md mb-4 md:mb-0 animate__animated animate__fadeInRight">
                <div class="text-center">
                    <i class="fas fa-phone-alt text-3xl text-blue-500 mb-2"></i>
                    <p class="text-gray-700 font-semibold mb-2 dark:text-white">Emergency Contact</p>
                    <p class="text-gray-600 dark:text-white">Have peace of mind knowing that emergency assistance is just a call away.
                        Save important emergency contacts for quick access during critical situations.</p>
                </div>
            </div>
            <!-- Feature 4: Discover Doctors -->
            <div class="w-full dark:bg-dark-eval-1 md:w-1/3 p-4 bg-gray-100 rounded-md shadow-md animate__animated animate__fadeInLeft">
                <div class="text-center">
                    <i class="fas fa-user-md text-3xl text-blue-500 mb-2"></i>
                    <p class="text-gray-700 font-semibold mb-2 dark:text-white">Discover Doctors</p>
                    <p class="text-gray-600 dark:text-white">Explore our list of doctors, select your preferred physician, and book
                        appointments based on their specialization and rating.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Guidance Section -->
    <div class="p-6 mt-7 dark:bg-dark-eval-1 bg-white rounded-md shadow-md dark:bg-dark-eval-1 animate__animated animate__fadeIn">
        <h2 class="mb-4 font-semibold text-xl text-gray-800 leading-tight dark:text-white"> <span class="mr-2"> <i
                    class="fa-solid fa-question" style="color: #74C0FC;"></i></span>How to Take an Appointment?</h2>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <!-- Step 1: Schedule Appointment -->
            <div class="bg-gray-100 dark:bg-dark-eval-1 rounded-lg p-4 flex items-center animate__animated animate__fadeInLeft">
                <i class="fas fa-calendar-alt text-blue-500 mr-4"></i>
                <div>
                    <p class="text-gray-700 font-semibold mb-2 dark:text-white">Click on "Schedule Appointment"</p>
                    <p class="text-gray-600 dark:text-white">Under the "My Appointments" section and choose your preferred doctor from
                        the list.</p>
                </div>
            </div>
            <!-- Step 2: Select Doctor -->
            <div class="bg-gray-100 dark:bg-dark-eval-1 rounded-lg p-4 flex items-center animate__animated animate__fadeInUp">
                <i class="fas fa-users-medical text-blue-500 mr-4"></i>
                <div>
                    <p class="text-gray-700 font-semibold mb-2 dark:text-white">Alternatively, select a doctor</p>
                    <p class="text-gray-600 dark:text-white">From the sidebar "Doctor List" and proceed to fill in the required
                        information.</p>
                </div>
            </div>
            <!-- Step 3: Fill Information -->
            <div class="bg-gray-100 dark:bg-dark-eval-1 rounded-lg p-4 flex items-center animate__animated animate__fadeInRight">
                <i class="fas fa-pencil-alt text-blue-500 mr-4"></i>
                <div>
                    <p class="text-gray-700 font-semibold mb-2 dark:text-white">Fill in the required information</p>
                    <p class="text-gray-600 dark:text-white">Including reason, doctor, and appointment date/time.</p>
                </div>
            </div>
            <!-- Step 4: Submit Form -->
            <div class="bg-gray-100 dark:bg-dark-eval-1 rounded-lg p-4 flex items-center animate__animated animate__fadeInLeft">
                <i class="fas fa-check-circle text-blue-500 mr-4"></i>
                <div>
                    <p class="text-gray-700 font-semibold mb-2 dark:text-white">Submit the form</p>
                    <p class="text-gray-600 dark:text-white">Once all information is filled in.</p>
                </div>
            </div>
            <!-- Step 5: View Appointment -->
            <div class="bg-gray-100 dark:bg-dark-eval-1 rounded-lg p-4 flex items-center animate__animated animate__fadeInUp">
                <i class="fas fa-list-alt text-blue-500 mr-4"></i>
                <div>
                    <p class="text-gray-700 font-semibold mb-2 dark:text-white">View your appointment</p>
                    <p class="text-gray-600 dark:text-white">Once submitted, it will appear under "My Appointments".</p>
                </div>
            </div>
        </div>
    </div>



</x-patient-layout>

<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/661ec6421ec1082f04e32280/1hrk3cthb';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const medicalHistoryCards = document.querySelectorAll('.medical-history-card');
        const showMoreBtn = document.getElementById('show-more-btn');

        showMoreBtn.addEventListener('click', function() {
            medicalHistoryCards.forEach(function(card, index) {
                if (index >= 9) {
                    card.classList.toggle('hidden');
                    card.classList.toggle('animate__fadeInUp');
                }
            });
            showMoreBtn.textContent = showMoreBtn.textContent === 'Show More' ? 'Show Less' :
                'Show More';
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const AppointmentCards = document.querySelectorAll('.appoinments-cards');
        const showMoreBtn2 = document.getElementById('show-more-btn-2');

        showMoreBtn2.addEventListener('click', function() {
            AppointmentCards.forEach(function(card, index) {
                if (index >= 6) {
                    card.classList.toggle('hidden');
                    card.classList.toggle('animate__fadeInUp');
                }
            });
            showMoreBtn2.textContent = showMoreBtn2.textContent === 'Show More' ? 'Show Less' :
                'Show More';
        });
    });
</script>
