<head>

</head>
<x-patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patient Dashboard') }}
        </h2>
    </x-slot>

    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-left "
        style="background-image: url({{ asset('img/old_project/b4.jpg') }});">
        <div class=" rounded-lg p-6 welcome-card">
            <div class="name-container">
                <p class="text-xl font-semibold">Welcome!</p>
                <p class="text-lg">{{ Auth::user()->name }}</p>
            </div>
            <div class="text-card-container mt-4">
                <p class="text-base">
                    Vous n'avez aucune idée des médecins ? pas de problème, passons à la section
                    <a href="{{ route('patiens.doctors') }}" class="text-blue-500">"Tous les médecins"</a><br>
                    Suivez l'historique de vos rendez-vous passés et futurs. <br>
                    Renseignez-vous également sur l'heure d'arrivée prévue de votre médecin ou médecin-conseil.
                </p>
            </div>
        </div>
    </div>
    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-around ">
        <div class="p-6 mt-7 overflow-hidden bg-white rounded-md  dark:bg-dark-eval-1 flex justify-center flex-col ">
            <h2 class="mb-7 font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Appointments') }}
            </h2>


            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Reason
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Doctor Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Doctor Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Appointment Hour
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Appointment Date
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $appointment->id }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $appointment->reason }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $appointment->doctor->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $appointment->doctor->user->email }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    {{ $appointment->schedule->start }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    {{ $appointment->appointment_date }}
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>

        </div>
        <div class="p-6 mt-7 overflow-hidden bg-white rounded-md  dark:bg-dark-eval-1 flex justify-center flex-col">
            <h2 class="mb-7 font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Medical History') }}
            </h2>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Doctor Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Doctor Email
                            </th>
                        </tr>
                    </thead>
                    @if (!$appointments->isEmpty())
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td class="px-6 py-4">
                                        {{ $appointment->doctor->user->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $appointment->doctor->user->email }}
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    @else
                        <img src="" alt="">
                    @endif

                </table>
            </div>
        </div>
    </div>
</x-patient-layout>
