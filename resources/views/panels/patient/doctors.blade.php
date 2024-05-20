<head>
    <title>YM | Doctors List</title>
</head>
<x-patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            <span class="mr-2"><i class="fa-solid fa-list" style="color: #74C0FC;"></i></span> {{ __('Doctors List') }}
        </h2>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>
    <div class="p-6 mt-7 overflow-hidden bg-white dark:bg-dark-eval-1 rounded-md shadow-md flex justify-center flex-col">
        <h2 class="mb-9 font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            <span class="mr-2"><i class="fa-solid fa-user-doctor" style="color: #74C0FC;"></i> </span>
            {{ __('Doctors') }}
        </h2>
        <div class="mb-4">
            <label for="select-speciality" class="block text-gray-700 text-sm font-bold mb-2 dark:text-white">Choose a
                Speciality:<span class="ml-2"><i class="fa-solid fa-briefcase" style="color: #74C0FC;"></i></span>
            </label>
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
                City: <span class="ml-2"><i class="fa-solid fa-city" style="color: #74C0FC;"></i></label>
            <input id="input-city" placeholder="Enter a city" type="text"
                class="block w-full bg-white dark:bg-dark-eval-2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:text-gray-300 dark:border-gray-600">
        </div>
        <div class="mb-4">
            <label for="input-name" class="block text-gray-700 text-sm font-bold mb-2 dark:text-white">Enter Doctor's
                Name: <span class="ml-2"><i class="fa-solid fa-signature" style="color: #74C0FC;"></i></label>
            <input id="input-name" type="text" placeholder="Enter doctor's name"
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
                    <div class="p-4 flex flex-row">
                        <div class="mr-3">
                            @if ($doctor->user->img)
                                <img src="{{ asset('storage/profile_pictures/' . $doctor->user->img) }}"
                                    alt="Profile Picture" class="w-32 h-32 rounded-2xl">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ $doctor->user->name }}" alt="test"
                                    class="w-32 h-32 rounded-2xl">
                            @endif
                        </div>
                        <div class="mt-4 ml-4">
                            <h3 class="text-lg font-medium leading-tight text-gray-900 dark:text-white">
                                {{ $doctor->user->name }}</h3>
                            <p class="text-gray-700 dark:text-gray-400">{{ $doctor->speciality->name }}</p>
                            <div class="flex items-center mt-4">
                                <span class="mr-2"><i class="fa-solid fa-star" style="color: #29a2ff;"></i></span>
                                <span>{{ $doctor->avg_rating }}</span>
                                <span class="ml-2">Review ({{ $doctor->ratings->count() }})</span>
                            </div>
                        </div>

                    </div>

                    <div class="p-4 flex items-center justify-end">
                        <a href="{{ route('patiens.doctor.book.appointment', ['id' => $doctor->id]) }}"
                            class="text-blue-500 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200"><i
                                class="fa-regular fa-calendar-check"></i> Prendre
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
        const inputName = document.getElementById('input-name');
        const cancelFilterBtn = document.getElementById('cancel-filter-btn');
        const cancelFilterContainer = document.getElementById('cancel-filter-container');

        selectSpeciality.addEventListener('change', filterDoctors);
        inputCity.addEventListener('input', filterDoctors);
        inputName.addEventListener('input', filterDoctors);
        cancelFilterBtn.addEventListener('click', cancelFilter);

        function filterDoctors() {
            const specialityId = selectSpeciality.value;
            const city = inputCity.value.trim();
            const name = inputName.value.trim(); // Get the entered doctor's name
            const url = "{{ route('filter.doctors') }}";
            const params = new URLSearchParams({
                speciality_id: specialityId
            });

            if (city) {
                params.append('city', city);
            }
            if (name) { // Add name parameter if it's not empty
                params.append('name', name);
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
                    cancelFilterContainer.style.display = specialityId || city || name ? 'block' : 'none';
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
                    let doctorId = doctor.id;
                    let userName = doctor.user && doctor.user.name ? doctor.user.name : 'Unknown';
                    let specialityName = doctor.speciality && doctor.speciality.name ? doctor.speciality
                        .name : 'Unknown';
                    let address = doctor.user && doctor.user.address && doctor.user.address.ville &&
                        doctor.user.address.rue ?
                        `${doctor.user.address.ville}, ${doctor.user.address.rue}` : 'Unknown';
                    const doctorElement = `
                <div id="doctor-${doctor.id}" class="bg-white dark:bg-dark-eval-2 shadow-md rounded-lg overflow-hidden flex flex-col transform transition duration-300 hover:scale-105">
                    <div class="p-4 flex flex-row">
                        <div class="mr-3">
                            ${doctor.user.img ?
                                `<img src="{{ asset('storage/profile_pictures/${doctor.user.img}') }}" alt="Profile Picture" class="w-32 h-32 rounded-2xl">` :
                                `<img src="https://ui-avatars.com/api/?name=${doctor.user.name}" alt="test" class="w-32 h-32 rounded-2xl">`}
                        </div>
                        <div class="mt-4 ml-4">
                            <h3 class="text-lg font-medium leading-tight text-gray-900 dark:text-white">
                                ${userName}
                            </h3>
                            <p class="text-gray-700 dark:text-gray-400">${specialityName}</p>
                            <div class="flex items-center mt-4">
                                <span class="mr-2"><i class="fa-solid fa-star" style="color: #29a2ff;"></i></span>
                                <span>${doctor.avg_rating}</span>
                                <span class="ml-2">Review (${doctor.ratings ? doctor.ratings.length : 0})</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 flex items-center justify-end">
                        <a href="/patient/doctor/${doctorId}/book/appointment" class="text-blue-500 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">
                            <i class="fa-regular fa-calendar-check"></i> Prendre Rendez-vous
                        </a>
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
            inputName.value = ''; // Reset the name input
            filterDoctors(); // Fetch all doctors again
        }
    });
</script>
