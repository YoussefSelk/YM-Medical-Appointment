<x-patient-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-800 dark:text-slate-100">
                    {{ __('Patient Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">Overview of your appointments, history, and health guidance.</p>
            </div>
        </div>
    </x-slot>

    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>

    @php
        $user = Auth::user()->img;
        $patient = Auth::user()->patient;
    @endphp

    <section class="rounded-2xl bg-white p-6 dark:bg-dark-eval-1">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <img src="{{ $user ? asset('storage/profile_pictures/' . $user) : 'https://ui-avatars.com/api/?name=' . Auth::user()->name }}"
                alt="Profile Picture" class="h-24 w-24 rounded-2xl object-cover shadow sm:h-28 sm:w-28">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-blue-700 dark:text-blue-300">Welcome back</p>
                <h3 class="mt-1 text-xl font-semibold text-slate-800 dark:text-slate-100">{{ auth()->user()->name }}</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Manage upcoming visits, review your history, and keep your care journey organized.</p>
            </div>
        </div>
    </section>

    <section class="grid gap-5 xl:grid-cols-2">
        <div class="rounded-2xl bg-white p-6 dark:bg-dark-eval-1">
            <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">
                <i class="fa-regular fa-calendar-check mr-2 text-blue-500"></i>My Appointments
            </h3>
            <div class="grid gap-3 sm:grid-cols-2" id="appointments-cards">
                @forelse ($patient->appointments as $index => $appointment)
                    <div class="rounded-xl border border-slate-100 p-4 dark:border-slate-700 appointment-card @if ($index >= 6) hidden @endif">
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $appointment->reason }}</p>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">{{ $appointment->appointment_date }}</p>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">Doctor: {{ $appointment->doctor->user->name }}</p>
                        <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-blue-600">{{ $appointment->status }}</p>
                    </div>
                @empty
                    <p class="rounded-xl border border-dashed border-slate-200 p-4 text-sm text-slate-500 dark:border-slate-700 sm:col-span-2">
                        No appointments found.
                    </p>
                @endforelse
            </div>
            @if ($patient->appointments->count() > 6)
                <button id="show-more-appointments" class="mt-4 inline-flex rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Show More</button>
            @endif
        </div>

        <div class="rounded-2xl bg-white p-6 dark:bg-dark-eval-1">
            <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">
                <i class="fa-solid fa-notes-medical mr-2 text-blue-500"></i>Medical History
            </h3>
            <div class="grid gap-3 sm:grid-cols-2" id="medical-history-cards">
                @forelse ($patient->appointments as $index => $appointment)
                    <div class="rounded-xl border border-slate-100 p-4 dark:border-slate-700 medical-history-card @if ($index >= 8) hidden @endif">
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $appointment->doctor->user->name }}</p>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">{{ $appointment->appointment_date }}</p>
                        <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-blue-600">{{ $appointment->status }}</p>
                    </div>
                @empty
                    <p class="rounded-xl border border-dashed border-slate-200 p-4 text-sm text-slate-500 dark:border-slate-700 sm:col-span-2">
                        No medical history found.
                    </p>
                @endforelse
            </div>
            @if ($patient->appointments->count() > 8)
                <button id="show-more-history" class="mt-4 inline-flex rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Show More</button>
            @endif
        </div>
    </section>

    <section class="rounded-2xl bg-white p-6 dark:bg-dark-eval-1">
        <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">Additional Features</h3>
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-xl bg-slate-50 p-4 text-center dark:bg-dark-eval-2">
                <i class="fas fa-clock mb-2 text-2xl text-blue-500"></i>
                <p class="font-semibold text-slate-700 dark:text-slate-200">Appointment Reminder</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Get timely updates so you never miss a scheduled consultation.</p>
            </div>
            <div class="rounded-xl bg-slate-50 p-4 text-center dark:bg-dark-eval-2">
                <i class="fas fa-phone-alt mb-2 text-2xl text-blue-500"></i>
                <p class="font-semibold text-slate-700 dark:text-slate-200">Emergency Contact</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Keep emergency contact information accessible during urgent situations.</p>
            </div>
            <div class="rounded-xl bg-slate-50 p-4 text-center dark:bg-dark-eval-2">
                <i class="fas fa-user-md mb-2 text-2xl text-blue-500"></i>
                <p class="font-semibold text-slate-700 dark:text-slate-200">Discover Doctors</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Browse doctors by specialty, availability, and feedback.</p>
            </div>
        </div>
    </section>

    <section class="rounded-2xl bg-white p-6 dark:bg-dark-eval-1">
        <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">How to Book an Appointment</h3>
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-xl bg-slate-50 p-4 dark:bg-dark-eval-2">
                <p class="font-semibold text-slate-700 dark:text-slate-200">1. Open Doctor List</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Choose the doctor and time that fit your needs.</p>
            </div>
            <div class="rounded-xl bg-slate-50 p-4 dark:bg-dark-eval-2">
                <p class="font-semibold text-slate-700 dark:text-slate-200">2. Fill Appointment Details</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Provide reason and preferred schedule information.</p>
            </div>
            <div class="rounded-xl bg-slate-50 p-4 dark:bg-dark-eval-2">
                <p class="font-semibold text-slate-700 dark:text-slate-200">3. Submit and Track</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Follow the appointment status from your dashboard.</p>
            </div>
        </div>
    </section>

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
        var historyCards = document.querySelectorAll('.medical-history-card');
        var showMoreHistoryBtn = document.getElementById('show-more-history');

        if (showMoreHistoryBtn) {
            showMoreHistoryBtn.addEventListener('click', function() {
                historyCards.forEach(function(card, index) {
                    if (index >= 8) {
                        card.classList.toggle('hidden');
                    }
                });

                showMoreHistoryBtn.textContent = showMoreHistoryBtn.textContent === 'Show More' ? 'Show Less' : 'Show More';
            });
        }

        var appointmentCards = document.querySelectorAll('.appointment-card');
        var showMoreAppointmentsBtn = document.getElementById('show-more-appointments');

        if (showMoreAppointmentsBtn) {
            showMoreAppointmentsBtn.addEventListener('click', function() {
                appointmentCards.forEach(function(card, index) {
                    if (index >= 6) {
                        card.classList.toggle('hidden');
                    }
                });

                showMoreAppointmentsBtn.textContent = showMoreAppointmentsBtn.textContent === 'Show More' ? 'Show Less' : 'Show More';
            });
        }
    });
</script>
