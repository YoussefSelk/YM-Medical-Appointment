<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Schedule Page') }}
        </h2>
    </x-slot>

    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>

    <div class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <form action="{{ route('doctor.schedule.update', ['id' => $schedule->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="day" class="block text-sm font-medium text-gray-700">Day</label>
                    <select name="day" id="day" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        <option value="Monday" {{ old('day', $schedule->day) == 'Monday' ? 'selected' : '' }}>Monday</option>
                        <option value="Tuesday" {{ old('day', $schedule->day) == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                        <option value="Wednesday" {{ old('day', $schedule->day) == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                        <option value="Thursday" {{ old('day', $schedule->day) == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                        <option value="Friday" {{ old('day', $schedule->day) == 'Friday' ? 'selected' : '' }}>Friday</option>
                        <option value="Saturday" {{ old('day', $schedule->day) == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                        <option value="Sunday" {{ old('day', $schedule->day) == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                    </select>
                    @error('day')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $schedule->start) }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('start_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $schedule->end) }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('end_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Schedule
                </button>
            </div>
        </form>
    </div>
</x-doctor-layout>
