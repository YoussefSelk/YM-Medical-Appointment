<x-doctor-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold leading-tight text-slate-800 dark:text-slate-100">
                    {{ __('Doctor Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">Track appointments, patient activity, and ratings in one view.</p>
            </div>
        </div>
    </x-slot>

    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>

    @php
        $profileImage = Auth::user()->img;
    @endphp

    <section class="grid gap-5 lg:grid-cols-[1.2fr_1fr]">
        <div class="rounded-2xl bg-white p-6 dark:bg-dark-eval-1">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <div class="shrink-0">
                    @if ($profileImage)
                        <img src="{{ asset('storage/profile_pictures/' . $profileImage) }}" alt="Profile Picture"
                            class="h-24 w-24 rounded-2xl object-cover shadow sm:h-28 sm:w-28">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="Profile Picture"
                            class="h-24 w-24 rounded-2xl shadow sm:h-28 sm:w-28">
                    @endif
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-blue-700 dark:text-blue-300">Doctor Workspace</p>
                    <h3 class="mt-1 text-xl font-semibold text-slate-800 dark:text-slate-100">Dr. {{ auth()->user()->name }}</h3>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Manage daily schedules, follow-up consultations, and patient care from this dashboard.</p>
                </div>
            </div>
        </div>

        <div class="grid gap-3 sm:grid-cols-2">
            <div class="rounded-xl bg-white p-4 dark:bg-dark-eval-1">
                <p class="text-xs uppercase tracking-wide text-slate-500">Schedules</p>
                <p class="mt-2 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ count($schedule) }}</p>
            </div>
            <div class="rounded-xl bg-white p-4 dark:bg-dark-eval-1">
                <p class="text-xs uppercase tracking-wide text-slate-500">Patients</p>
                <p class="mt-2 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ count($patients) }}</p>
            </div>
            <div class="rounded-xl bg-white p-4 dark:bg-dark-eval-1">
                <p class="text-xs uppercase tracking-wide text-slate-500">Bookings</p>
                <p class="mt-2 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ count($appointments) }}</p>
            </div>
            <div class="rounded-xl bg-white p-4 dark:bg-dark-eval-1">
                <p class="text-xs uppercase tracking-wide text-slate-500">Average Rating</p>
                <p class="mt-2 text-2xl font-semibold text-slate-800 dark:text-slate-100">
                    {{ $ratings->isNotEmpty() ? number_format((float) $ratings->avg('rating'), 1) : 'N/A' }}
                </p>
            </div>
        </div>
    </section>

    <section class="grid gap-5 xl:grid-cols-2">
        <div class="rounded-2xl bg-white p-6 dark:bg-dark-eval-1">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Upcoming Appointments</h3>
                <a href="{{ route('doctor.appointments') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">View all</a>
            </div>

            <div class="space-y-3">
                @forelse ($upcommingAppointments as $appointment)
                    <div class="rounded-xl border border-slate-100 p-4 dark:border-slate-700">
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $appointment->patient->user->name }}</p>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">{{ $appointment->appointment_date }}</p>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $appointment->reason }}</p>
                    </div>
                @empty
                    <p class="rounded-xl border border-dashed border-slate-200 p-4 text-sm text-slate-500 dark:border-slate-700">
                        No upcoming appointments.
                    </p>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 dark:bg-dark-eval-1">
            <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">Recent Patient Visits</h3>
            <div class="space-y-3">
                @forelse ($recentVisits as $visit)
                    <div class="rounded-xl border border-slate-100 p-4 dark:border-slate-700">
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $visit->patient->user->name }}</p>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">{{ $visit->appointment_date }}</p>
                    </div>
                @empty
                    <p class="rounded-xl border border-dashed border-slate-200 p-4 text-sm text-slate-500 dark:border-slate-700">
                        No recent visits.
                    </p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="rounded-2xl bg-white p-6 dark:bg-dark-eval-1">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Latest Reviews</h3>
            <a href="{{ route('doctor.myreviews') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">View more</a>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            @forelse ($ratings->take(4) as $review)
                <div class="rounded-xl border border-slate-100 p-4 dark:border-slate-700">
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $review->patient->user->name }}</p>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $review->comment }}</p>
                    <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-amber-600">Rating: {{ $review->rating }}/5</p>
                </div>
            @empty
                <p class="rounded-xl border border-dashed border-slate-200 p-4 text-sm text-slate-500 dark:border-slate-700 md:col-span-2">
                    No reviews yet.
                </p>
            @endforelse
        </div>
    </section>

</x-doctor-layout>
