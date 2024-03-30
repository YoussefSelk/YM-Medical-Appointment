<x-patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doctors List') }}
        </h2>
    </x-slot>

    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-center flex-col">
        <h2 class="mb-2 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doctors') }}
        </h2>
        @foreach ($doctors as $doctor)
            <div class="bg-white shadow-md rounded-lg overflow-hidden flex flex-col">
                <div class="p-4">
                    <div class="flex flex-row items-center mb-3">
                        <x-icons.doctor />
                        <h5 class="text-xl font-medium leading-tight mb-2">Dr, {{ $doctor->user->name }}</h5>
                    </div>

                    <p class="text-gray-700 mb-4">Médecin {{ $doctor->speciality->name }}</p>
                    <p class="text-gray-700 text-sm"><strong>Address : </strong>{{ $doctor->user->address->ville }} ,
                        {{ $doctor->user->address->rue }}</p>
                    <ul class="list-disc space-y-2 pl-4">
                        <li>{{ $doctor->degree }}</li>
                    </ul>
                </div>
                <div class="p-4 flex items-center justify-end">
                    <a href="{{ route('patiens.doctor.book.appointment', $doctor->id) }}"
                        class="text-blue-500 hover:text-blue-800">Prendre Rendez-vous</a>
                </div>
            </div>
        @endforeach
    </div>
</x-patient-layout>
