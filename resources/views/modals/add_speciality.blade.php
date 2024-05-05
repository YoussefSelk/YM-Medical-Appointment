<head>
    <link rel="stylesheet" href="{{ asset('css/add_doctor_modal.css') }}">
    <script src="{{ asset('js/add_doctor_modal.js') }}"></script>
</head>
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Display errors and keep the modal open
            var modal = document.getElementById('create_speciality_modal');
            if (modal) {
                modal.style.display = "flex";
            }
        });
    </script>
@endif
@php
    $hasErrors = $errors->any();
    $temp = false;
    if ($hasErrors) {
        $temp = true;
    }
@endphp
<x-modal name="add_speciality" :show="$temp" id="create_speciality_modal">
    <!-- Modal content goes here -->
    <div class="p-6 bg-white shadow-md rounded-md">
        <h2 class="text-xl font-semibold mb-4">Add Speciality</h2>

        <form action="{{ route('admin.specialities.add') }}" method="POST">
            @csrf
            <div class="mb-4">
                <x-form.label for="speciality" :value="__('Speciality')" />
                <x-form.input id="speciality"
                    class="block w-full mt-1 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md shadow-sm"
                    type="text" name="speciality" :value="old('speciality')" required autofocus />
                <div class="text-red-500">
                    @error('speciality')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Add Speciality') }}
                </x-button>
            </div>
        </form>
    </div>



</x-modal>
