<x-admin-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight ">
                {{ __('Appointments Page') }}
            </h2>

        </div>
    </x-slot>

    <div class="p-6 mt-7  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Appointments List') }}
        </h2>
        <div class="flex flex-wrap justify-center mt-10">
            @foreach ($appointments as $appointment)
                <x-cards.normal-card title="{{ $appointment->patient->user->name }}"
                    description="{{ $appointment->doctor->user->name }}"
                    link-url="{{ route('admin.appointments.edit', $appointment->id) }}" link-text="Edit" />
            @endforeach
        </div>
    </div>
</x-admin-layout>
