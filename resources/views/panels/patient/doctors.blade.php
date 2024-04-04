<x-patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Doctors List') }}
        </h2>
    </x-slot>

    <div class="p-6 mt-7 overflow-hidden bg-white dark:bg-dark-eval-1 rounded-md shadow-md flex justify-center flex-col">
        <h2 class="mb-2 font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Doctors') }}
        </h2>
        <div class="mb-4">
            <label for="select-speciality" class="block text-gray-700 text-sm font-bold mb-2 dark:text-white">Choose a
                Speciality:</label>
            <select id="select-speciality" name="speciality"
                class="block w-full bg-white dark:bg-dark-eval-2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:text-gray-300 dark:border-gray-600">
                <option value="">Select Speciality</option>
                @foreach ($specialities as $speciality)
                    <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="input-city" class="block text-gray-700 text-sm font-bold mb-2 dark:text-white">Enter a
                City:</label>
            <input id="input-city" type="text"
                class="block w-full bg-white dark:bg-dark-eval-2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:text-gray-300 dark:border-gray-600">
        </div>
        <div class="mb-4" id="cancel-filter-container" style="display: none;">
            <button id="cancel-filter-btn"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center dark:bg-dark-eval-3 dark:text-gray-200 dark:hover:bg-dark-eval-4 dark:hover:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
                <span>Cancel Filter</span>
            </button>
        </div>
        <div id="no-results-message" class="hidden">
            <p class="text-red-500 text-lg font-semibold dark:text-red-400">No doctors found matching the criteria.</p>
        </div>
        <div id="doctors-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Doctors list will be displayed here -->
            @foreach ($doctors as $doctor)
                <div id="doctor-{{ $doctor->id }}"
                    class="bg-white dark:bg-dark-eval-2 shadow-md rounded-lg overflow-hidden flex flex-col transform transition duration-300 hover:scale-105">
                    <div class="p-4">
                        <div class="flex flex-row items-center mb-3">
                            <x-icons.doctor />
                            <h5 class="text-xl font-medium leading-tight mb-2 dark:text-white">Dr,
                                {{ $doctor->user->name }}</h5>
                        </div>
                        <hr class="my-2">
                        <p class="text-gray-700 mb-4 dark:text-gray-300">Médecin {{ $doctor->speciality->name }}</p>
                        <p class="text-gray-700 text-sm dark:text-gray-400"><strong>Address :
                            </strong>{{ $doctor->user->address->ville }},
                            {{ $doctor->user->address->rue }}</p>
                        <hr class="my-2">
                        <ul class="list-disc space-y-2 pl-4 dark:text-gray-400">
                            <li>{{ $doctor->degree }}</li>
                        </ul>
                    </div>
                    <div class="p-4 flex items-center justify-end">
                        <a href="{{ route('patiens.doctor.book.appointment', ['id' => $doctor->id]) }}"
                            class="text-blue-500 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">Prendre
                            Rendez-vous</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-patient-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectSpeciality = document.getElementById('select-speciality');
        const inputCity = document.getElementById('input-city');
        const cancelFilterBtn = document.getElementById('cancel-filter-btn');
        const cancelFilterContainer = document.getElementById('cancel-filter-container');

        selectSpeciality.addEventListener('change', filterDoctors);
        inputCity.addEventListener('input', filterDoctors);
        cancelFilterBtn.addEventListener('click', cancelFilter);

        function filterDoctors() {
            const specialityId = selectSpeciality.value;
            const city = inputCity.value.trim();
            const url = "{{ route('filter.doctors') }}";
            const params = new URLSearchParams({
                speciality_id: specialityId
            });

            if (city) {
                params.append('city', city);
            }

            fetch(`${url}?${params}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    updateDoctorsList(data);
                    cancelFilterContainer.style.display = specialityId || city ? 'block' : 'none';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function updateDoctorsList(doctors) {
            const doctorsList = document.getElementById('doctors-list');
            const noResultsMessage = document.getElementById('no-results-message');
            doctorsList.innerHTML = '';

            if (doctors.length === 0) {
                noResultsMessage.classList.remove('hidden');
            } else {
                noResultsMessage.classList.add('hidden');
                doctors.forEach(doctor => {
                    let userName = doctor.user && doctor.user.name ? doctor.user.name : 'Unknown';
                    let specialityName = doctor.speciality && doctor.speciality.name ? doctor.speciality
                        .name : 'Unknown';
                    let address = doctor.user && doctor.user.address && doctor.user.address.ville &&
                        doctor.user.address.rue ?
                        `${doctor.user.address.ville}, ${doctor.user.address.rue}` : 'Unknown';

                    const doctorElement = `
                        <div id="doctor-${doctor.id}" class="bg-white dark:bg-dark-eval-2 shadow-md rounded-lg overflow-hidden flex flex-col transform transition duration-300 hover:scale-105">
                            <div class="p-4">
                                <div class="flex flex-row items-center mb-3">
                                    <x-icons.doctor />
                                    <h5 class="text-xl font-medium leading-tight mb-2 dark:text-white">Dr, ${userName}</h5>
                                </div>
                                <hr class="my-2">
                                <p class="text-gray-700 mb-4 dark:text-gray-300">Médecin ${specialityName}</p>
                                <p class="text-gray-700 text-sm dark:text-gray-400"><strong>Address : </strong>${address}</p>
                                <hr class="my-2">
                                <ul class="list-disc space-y-2 pl-4 dark:text-gray-400">
                                    <li>${doctor.degree}</li>
                                </ul>
                            </div>
                            <div class="p-4 flex items-center justify-end">
                                <a href="/patient/doctor/${doctor.id}/book/appointment" class="text-blue-500 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">Prendre Rendez-vous</a>
                            </div>
                        </div>
                    `;
                    doctorsList.insertAdjacentHTML('beforeend', doctorElement);
                });
            }
        }

        function cancelFilter() {
            selectSpeciality.value = ''; // Reset the select element
            inputCity.value = ''; // Reset the city input
            filterDoctors(); // Fetch all doctors again
        }
    });
</script>
