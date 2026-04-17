<x-doctor-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
            {{ __('My Schedule') }}
        </h2>
    </x-slot>

    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>

    @php
        $groupedSchedule = [];
        foreach ($schedule as $item) {
            $groupedSchedule[$item->day][] = $item;
        }
    @endphp

    <div class="mb-2 overflow-hidden rounded-md bg-white p-6 shadow-md dark:bg-dark-eval-1">
        @if (count($groupedSchedule) > 0)
            <div class="mt-2 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($groupedSchedule as $day => $items)
                    <div class="rounded-md border border-gray-200 p-4 dark:border-gray-700">
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-300">{{ ucfirst($day) }}</p>
                        <div class="mt-2 grid grid-cols-1 gap-4">
                            @foreach ($items as $item)
                                <div class="rounded-md bg-gray-100 p-4 shadow-md dark:bg-gray-800">
                                    <div class="text-xs uppercase text-gray-700 dark:text-gray-400">
                                        <span class="mr-2"><i class="fa-regular fa-clock" style="color: #74C0FC;"></i></span>
                                        {{ $item->start }} -- {{ $item->end }}
                                    </div>
                                    <form id="deleteForm_{{ $item->id }}" action="{{ route('doctor.schedule.delete', $item->id) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button" class="mt-3 text-red-600 hover:text-red-900"
                                        onclick="confirmDelete({{ $item->id }})">Delete</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="mt-6 text-center">
                <p class="text-lg font-semibold text-gray-800 dark:text-white">No schedules available</p>
            </div>
        @endif
    </div>

    <div class="mt-7 flex justify-center overflow-x-auto rounded-md bg-white p-6 text-dark-eval-1 shadow-md dark:bg-dark-eval-1">
        <div id="calendar" class="w-full lg:w-3/4 xl:w-2/3"></div>
    </div>

    <div class="mt-7 flex flex-col justify-center gap-4 overflow-hidden bg-white p-3 sm:rounded-lg dark:bg-dark-eval-1 dark:text-gray-400 md:flex-row">
        <div class="mt-7 overflow-hidden rounded-md bg-white p-6 shadow-md dark:bg-dark-eval-1">
            <p>Add Schedule</p>
        </div>

        <form action="{{ route('doctor.schedule.add', ['id' => $doctor->id]) }}" method="POST"
            class="flex flex-col space-y-4 rounded-lg bg-white p-6 shadow-md">
            @csrf
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Day</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Start Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @php
                        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                    @endphp
                    @foreach ($days as $day)
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4">{{ ucfirst($day) }}</td>
                            <td class="flex flex-wrap whitespace-nowrap px-6 py-4">
                                @for ($i = 8; $i <= 19; $i++)
                                    <div class="mb-2 flex items-center space-x-2">
                                        <input id="{{ $day }}_{{ $i }}" type="checkbox" name="start_times[{{ $day }}][]"
                                            value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00" class="hidden">
                                        <label for="{{ $day }}_{{ $i }}"
                                            class="cursor-pointer rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-900">
                                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00 - {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:30
                                        </label>
                                    </div>
                                @endfor
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit"
                class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Save Slots
            </button>
        </form>
    </div>

    @push('scripts')
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
    @endpush
</x-doctor-layout>
