<x-admin-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Schedules Page') }}
            </h2>

        </div>
    </x-slot>

    <div class="p-6 mt-7  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Doctors List') }}
        </h2>
        <div class="flex flex-wrap justify-center mt-10">
            @foreach ($doctors as $doctor)
                <x-cards.normal-card title="{{ $doctor->user->name }}"
                    description="{!! $doctor->speciality->name !!} , {!! $doctor->user->email !!}"
                    link-url="{{ route('admin.doctor.schedule', $doctor->id) }}" link-text="Schedule" />
            @endforeach
        </div>
    </div>
</x-admin-layout>
