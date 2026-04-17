<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-2xl font-semibold leading-tight">
                    {{ __("Admin's Dashboard") }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Monitor activity, review queues, and take action fast.
                </p>
            </div>

            <form method="GET" action="{{ route('admin_dashboard') }}" class="flex items-center gap-2">
                <label for="range" class="text-sm font-medium text-gray-600 dark:text-gray-300">Range</label>
                <select id="range" name="range"
                    class="rounded-md border-gray-300 py-2 pl-3 pr-10 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-dark-eval-0">
                    @foreach ($allowedRanges as $rangeOption)
                        <option value="{{ $rangeOption }}" @selected($selectedRange === $rangeOption)>
                            Last {{ $rangeOption }} days
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                    Apply
                </button>
            </form>
        </div>
    </x-slot>

    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>

    @php
        $profileImage = Auth::user()->img;
        $growthLabel = is_null($appointmentsGrowth) ? 'No previous range data' : ($appointmentsGrowth >= 0 ? '+' : '') . $appointmentsGrowth . '% vs previous period';
        $growthTone = is_null($appointmentsGrowth)
            ? 'text-slate-500 bg-slate-100'
            : ($appointmentsGrowth >= 0
                ? 'text-emerald-700 bg-emerald-100'
                : 'text-red-700 bg-red-100');
        $statusTotal = max(1, $appointmentsCount);
        $maxWeeklyCount = max(1, $weeklyAppointments->max('count'));
    @endphp

    <style>
        .admin-gradient {
            background: radial-gradient(circle at top right, rgba(59, 130, 246, .20), transparent 40%), linear-gradient(140deg, #ffffff, #f8fafc);
        }

        .admin-kpi {
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .admin-kpi:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(15, 23, 42, .08);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            padding: .2rem .7rem;
            font-size: .75rem;
            font-weight: 600;
        }
    </style>

    <section class="admin-gradient overflow-hidden rounded-2xl border border-slate-200 p-6 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
        <div class="grid gap-6 lg:grid-cols-[1.2fr_1fr] lg:items-center">
            <div class="flex items-center gap-4 sm:gap-6">
                @if ($profileImage)
                    <img src="{{ asset('storage/profile_pictures/' . $profileImage) }}" alt="Profile Picture"
                        class="h-20 w-20 rounded-2xl object-cover shadow sm:h-24 sm:w-24">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="Avatar"
                        class="h-20 w-20 rounded-2xl shadow sm:h-24 sm:w-24">
                @endif
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-blue-700 dark:text-blue-300">Control Center</p>
                    <h3 class="text-xl font-semibold text-slate-800 dark:text-slate-100">
                        Welcome back, {{ auth()->user()->name }}
                    </h3>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">
                        {{ $appointmentsCurrentRange }} bookings created in the last {{ $selectedRange }} days.
                    </p>
                    <span class="mt-3 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $growthTone }}">
                        {{ $growthLabel }}
                    </span>
                </div>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <div class="rounded-xl bg-white/90 p-4 shadow-sm dark:bg-dark-eval-0">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Today</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $todayAppointments }}</p>
                    <p class="text-xs text-slate-500">appointments scheduled</p>
                </div>
                <div class="rounded-xl bg-white/90 p-4 shadow-sm dark:bg-dark-eval-0">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Next 7 days</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $upcomingWeekAppointments }}</p>
                    <p class="text-xs text-slate-500">upcoming appointments</p>
                </div>
                <div class="rounded-xl bg-white/90 p-4 shadow-sm dark:bg-dark-eval-0">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Open Slots</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $openScheduleSlots }}</p>
                    <p class="text-xs text-slate-500">available schedules</p>
                </div>
                <div class="rounded-xl bg-white/90 p-4 shadow-sm dark:bg-dark-eval-0">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Unread Alerts</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $unreadAdminNotifications }}</p>
                    <p class="text-xs text-slate-500">admin notifications</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <a href="{{ route('admin.doctor') }}"
            class="admin-kpi rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-600 dark:text-slate-300">Manage Doctors</p>
                <i class="fa-solid fa-user-doctor text-blue-600"></i>
            </div>
            <p class="mt-3 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $doctorsCount }}</p>
            <p class="text-xs text-slate-500">Active: {{ $activeDoctors }} | New: {{ $newDoctorsInRange }}</p>
        </a>

        <a href="{{ route('admin.patient') }}"
            class="admin-kpi rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-600 dark:text-slate-300">Manage Patients</p>
                <i class="fa-solid fa-bed-pulse text-emerald-600"></i>
            </div>
            <p class="mt-3 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $patientsCount }}</p>
            <p class="text-xs text-slate-500">New in range: {{ $newPatientsInRange }}</p>
        </a>

        <a href="{{ route('admin.appointments') }}"
            class="admin-kpi rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-600 dark:text-slate-300">Appointments</p>
                <i class="fa-regular fa-calendar-check text-amber-600"></i>
            </div>
            <p class="mt-3 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $appointmentsCount }}</p>
            <p class="text-xs text-slate-500">Pending: {{ $pendingAppointments }} | Approved: {{ $approvedAppointments }}</p>
        </a>

        <a href="{{ route('admin.apply') }}"
            class="admin-kpi rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-600 dark:text-slate-300">Doctor Applications</p>
                <i class="fa-solid fa-file-signature text-rose-600"></i>
            </div>
            <p class="mt-3 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $pendingApplications }}</p>
            <p class="text-xs text-slate-500">Approved: {{ $approvedApplications }} | Rejected: {{ $rejectedApplications }}</p>
        </a>
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-[1.2fr_1fr]">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Quick Actions</h3>
                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">{{ $selectedRange }}-day context</span>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <a href="{{ route('admin.doctor') }}"
                    class="rounded-lg border border-slate-200 p-3 text-sm font-medium text-slate-700 transition hover:border-blue-500 hover:text-blue-600 dark:border-slate-700 dark:text-slate-200">
                    <i class="fa-solid fa-user-plus mr-2"></i> Add or edit doctors
                </a>
                <a href="{{ route('admin.patient') }}"
                    class="rounded-lg border border-slate-200 p-3 text-sm font-medium text-slate-700 transition hover:border-blue-500 hover:text-blue-600 dark:border-slate-700 dark:text-slate-200">
                    <i class="fa-solid fa-hospital-user mr-2"></i> Manage patients
                </a>
                <a href="{{ route('admin.appointments') }}"
                    class="rounded-lg border border-slate-200 p-3 text-sm font-medium text-slate-700 transition hover:border-blue-500 hover:text-blue-600 dark:border-slate-700 dark:text-slate-200">
                    <i class="fa-solid fa-clock-rotate-left mr-2"></i> Review appointments
                </a>
                <a href="{{ route('admin.schedules') }}"
                    class="rounded-lg border border-slate-200 p-3 text-sm font-medium text-slate-700 transition hover:border-blue-500 hover:text-blue-600 dark:border-slate-700 dark:text-slate-200">
                    <i class="fa-solid fa-calendar-days mr-2"></i> Manage schedules
                </a>
                <a href="{{ route('admin.specialities') }}"
                    class="rounded-lg border border-slate-200 p-3 text-sm font-medium text-slate-700 transition hover:border-blue-500 hover:text-blue-600 dark:border-slate-700 dark:text-slate-200">
                    <i class="fa-solid fa-stethoscope mr-2"></i> Update specialities
                </a>
                <a href="{{ route('admin.apply') }}"
                    class="rounded-lg border border-slate-200 p-3 text-sm font-medium text-slate-700 transition hover:border-blue-500 hover:text-blue-600 dark:border-slate-700 dark:text-slate-200">
                    <i class="fa-solid fa-envelope-open-text mr-2"></i> Process applications
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Weekly Activity</h3>
            <p class="mt-1 text-xs text-slate-500">Appointments scheduled this week</p>
            <div class="mt-5 space-y-3">
                @foreach ($weeklyAppointments as $day)
                    @php
                        $barWidth = max(8, round(($day['count'] / $maxWeeklyCount) * 100));
                    @endphp
                    <div class="grid grid-cols-[48px_1fr_36px] items-center gap-3">
                        <span class="text-xs font-semibold text-slate-500">{{ $day['label'] }}</span>
                        <div class="h-2 rounded-full bg-slate-100 dark:bg-slate-700">
                            <div class="h-2 rounded-full bg-blue-600" style="width: {{ $barWidth }}%"></div>
                        </div>
                        <span class="text-right text-xs font-semibold text-slate-600 dark:text-slate-200">{{ $day['count'] }}</span>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 rounded-lg bg-slate-50 p-3 text-xs text-slate-600 dark:bg-dark-eval-0 dark:text-slate-300">
                Average doctor rating: <span class="font-semibold">{{ number_format($averageRating, 1) }}/5</span>
            </div>
        </div>
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-[1.5fr_1fr]">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Recent Appointments</h3>
                <a href="{{ route('admin.appointments') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-700">View all</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                    <thead>
                        <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <th class="py-3 pr-4">Date</th>
                            <th class="py-3 pr-4">Patient</th>
                            <th class="py-3 pr-4">Doctor</th>
                            <th class="py-3 pr-4">Status</th>
                            <th class="py-3 pr-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm dark:divide-slate-800">
                        @forelse ($recentAppointments as $appointment)
                            @php
                                $normalizedStatus = strtolower($appointment->status ?? '');
                                $statusClasses = 'bg-slate-100 text-slate-700';
                                if ($normalizedStatus === 'approved') {
                                    $statusClasses = 'bg-emerald-100 text-emerald-700';
                                } elseif ($normalizedStatus === 'cancelled' || $normalizedStatus === 'canceled') {
                                    $statusClasses = 'bg-rose-100 text-rose-700';
                                } elseif ($normalizedStatus === 'pending') {
                                    $statusClasses = 'bg-amber-100 text-amber-700';
                                }
                            @endphp
                            <tr>
                                <td class="py-3 pr-4 text-slate-600 dark:text-slate-300">
                                    {{ \Illuminate\Support\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                </td>
                                <td class="py-3 pr-4 text-slate-800 dark:text-slate-100">
                                    {{ optional(optional($appointment->patient)->user)->name ?? 'Unknown patient' }}
                                </td>
                                <td class="py-3 pr-4 text-slate-800 dark:text-slate-100">
                                    {{ optional(optional($appointment->doctor)->user)->name ?? 'Unknown doctor' }}
                                </td>
                                <td class="py-3 pr-4">
                                    <span class="status-pill {{ $statusClasses }}">{{ ucfirst($appointment->status ?? 'unknown') }}</span>
                                </td>
                                <td class="py-3 pr-0">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.appointment.view', $appointment->id) }}"
                                            class="rounded-md border border-slate-200 px-2.5 py-1 text-xs font-medium text-slate-700 transition hover:border-blue-500 hover:text-blue-600 dark:border-slate-700 dark:text-slate-200">
                                            Details
                                        </a>

                                        @if ($normalizedStatus === 'pending')
                                            <form method="POST" action="{{ route('admin.appointment.detail.approve', $appointment->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="rounded-md bg-emerald-600 px-2.5 py-1 text-xs font-semibold text-white transition hover:bg-emerald-700">
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.appointment.detail.cancel', $appointment->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="rounded-md bg-rose-600 px-2.5 py-1 text-xs font-semibold text-white transition hover:bg-rose-700">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-sm text-slate-500">
                                    No appointment data available yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Appointment Mix</h3>
                <div class="mt-4 space-y-3 text-sm">
                    <div>
                        <div class="mb-1 flex items-center justify-between">
                            <span class="font-medium text-slate-600 dark:text-slate-300">Approved</span>
                            <span class="text-slate-700 dark:text-slate-100">{{ $approvedAppointments }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100 dark:bg-slate-700">
                            <div class="h-2 rounded-full bg-emerald-600"
                                style="width: {{ round(($approvedAppointments / $statusTotal) * 100) }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-1 flex items-center justify-between">
                            <span class="font-medium text-slate-600 dark:text-slate-300">Pending</span>
                            <span class="text-slate-700 dark:text-slate-100">{{ $pendingAppointments }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100 dark:bg-slate-700">
                            <div class="h-2 rounded-full bg-amber-500"
                                style="width: {{ round(($pendingAppointments / $statusTotal) * 100) }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-1 flex items-center justify-between">
                            <span class="font-medium text-slate-600 dark:text-slate-300">Cancelled</span>
                            <span class="text-slate-700 dark:text-slate-100">{{ $cancelledAppointments }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100 dark:bg-slate-700">
                            <div class="h-2 rounded-full bg-rose-500"
                                style="width: {{ round(($cancelledAppointments / $statusTotal) * 100) }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-1 flex items-center justify-between">
                            <span class="font-medium text-slate-600 dark:text-slate-300">Other</span>
                            <span class="text-slate-700 dark:text-slate-100">{{ $otherAppointments }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100 dark:bg-slate-700">
                            <div class="h-2 rounded-full bg-slate-500"
                                style="width: {{ round(($otherAppointments / $statusTotal) * 100) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Top Specialities</h3>
                <div class="mt-4 space-y-3">
                    @forelse ($specialityLoad as $speciality)
                        @php
                            $specialityWidth = max(10, round(($speciality->doctors_count / $maxSpecialityDoctors) * 100));
                        @endphp
                        <div>
                            <div class="mb-1 flex items-center justify-between text-sm">
                                <span class="font-medium text-slate-700 dark:text-slate-200">{{ $speciality->name }}</span>
                                <span class="text-slate-500">{{ $speciality->doctors_count }} doctors</span>
                            </div>
                            <div class="h-2 rounded-full bg-slate-100 dark:bg-slate-700">
                                <div class="h-2 rounded-full bg-blue-600" style="width: {{ $specialityWidth }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No speciality data available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Top Rated Doctors</h3>
            <div class="mt-4 space-y-3">
                @forelse ($topRatedDoctors as $doctor)
                    <div class="flex items-center justify-between rounded-lg border border-slate-100 px-3 py-2 dark:border-slate-700">
                        <div>
                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">
                                {{ optional($doctor->user)->name ?? 'Unknown doctor' }}
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ optional($doctor->speciality)->name ?? 'No speciality' }} • {{ $doctor->ratings_count }} review(s)
                            </p>
                        </div>
                        <div class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                            {{ number_format((float) ($doctor->ratings_avg_rating ?? 0), 1) }}/5
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No rating data yet.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Application Pipeline</h3>
            <div class="mt-4 grid gap-3 sm:grid-cols-3">
                <div class="rounded-lg bg-amber-50 p-3 text-center">
                    <p class="text-xs font-semibold uppercase text-amber-700">Pending</p>
                    <p class="mt-1 text-2xl font-semibold text-amber-800">{{ $pendingApplications }}</p>
                </div>
                <div class="rounded-lg bg-emerald-50 p-3 text-center">
                    <p class="text-xs font-semibold uppercase text-emerald-700">Approved</p>
                    <p class="mt-1 text-2xl font-semibold text-emerald-800">{{ $approvedApplications }}</p>
                </div>
                <div class="rounded-lg bg-rose-50 p-3 text-center">
                    <p class="text-xs font-semibold uppercase text-rose-700">Rejected</p>
                    <p class="mt-1 text-2xl font-semibold text-rose-800">{{ $rejectedApplications }}</p>
                </div>
            </div>
            <a href="{{ route('admin.apply') }}"
                class="mt-4 inline-flex items-center rounded-md border border-blue-600 px-3 py-2 text-sm font-medium text-blue-600 transition hover:bg-blue-600 hover:text-white">
                Review applications
            </a>
        </div>
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
            <h3 class="mb-3 text-lg font-semibold text-slate-800 dark:text-slate-100">Doctors Registered by Date</h3>
            <div class="chart-container relative h-auto w-full">
                {!! $Doctor_Chart_Created_At->container() !!}
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
            <h3 class="mb-3 text-lg font-semibold text-slate-800 dark:text-slate-100">Doctors by Gender</h3>
            <div class="chart-container relative h-auto w-full">
                {!! $gender_chart->container() !!}
            </div>
        </div>
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
            <h3 class="mb-3 text-lg font-semibold text-slate-800 dark:text-slate-100">Patients Registered by Date</h3>
            <div class="chart-container relative h-auto w-full">
                {!! $Patient_Chart_Created_At->container() !!}
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
            <h3 class="mb-3 text-lg font-semibold text-slate-800 dark:text-slate-100">Patients by Gender</h3>
            <div class="chart-container relative h-auto w-full">
                {!! $patient_gender_chart->container() !!}
            </div>
        </div>
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
            <h3 class="mb-3 text-lg font-semibold text-slate-800 dark:text-slate-100">Appointments Registered by Date</h3>
            <div class="chart-container relative h-auto w-full">
                {!! $Appointments_Chart_Created_At->container() !!}
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1">
            <h3 class="mb-3 text-lg font-semibold text-slate-800 dark:text-slate-100">Appointments by Status</h3>
            <div class="chart-container relative h-auto w-full">
                {!! $Appointments_Chart_Status->container() !!}
            </div>
        </div>
    </section>

    {!! $Doctor_Chart_Created_At->script() !!}
    {!! $gender_chart->script() !!}
    {!! $Patient_Chart_Created_At->script() !!}
    {!! $patient_gender_chart->script() !!}
    {!! $Appointments_Chart_Created_At->script() !!}
    {!! $Appointments_Chart_Status->script() !!}
</x-admin-layout>
