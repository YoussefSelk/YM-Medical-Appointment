<x-doctor-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Appointment Page') }}
        </h2>
    </x-slot>

     <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>

    <div class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <form action="{{ route('doctor.appointment.update', ['id' => $appointment->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        <option value="Expired" {{ old('status', $appointment->status) == 'Expired' ? 'selected' : '' }}>Expired</option>
                        <option value="Cancelled" {{ old('status', $appointment->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="Pending" {{ old('status', $appointment->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ old('status', $appointment->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                    </select>
                    @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="doctor_comment" class="block text-sm font-medium text-gray-700">Doctor comment </label>
                    <input type="text" placeholder="{{ $appointment->doctor_comment ? '' : 'Enter doctor comment' }}" name="doctor_comment" id="doctor_comment" value="{{ old('doctor_comment', $appointment->doctor_comment) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('doctor_comment')
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
