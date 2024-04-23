<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Edit Doctor Page') }}
        </h2>
    </x-slot>
    <x-success-flash />
    <x-error-flash />
    @php
        // Hardcoded list of Moroccan cities
        $moroccanCities = [
            'Agadir',
            'Al Hoceima',
            'Asilah',
            'Azrou',
            'Beni Mellal',
            'Bouznika',
            'Casablanca',
            'Chefchaouen',
            'Dakhla',
            'El Jadida',
            'Errachidia',
            'Essaouira',
            'Fès',
            'Guelmim',
            'Ifrane',
            'Kénitra',
            'Khouribga',
            'Laâyoune',
            'Larache',
            'Marrakech',
            'Meknès',
            'Mohammedia',
            'Nador',
            'Ouarzazate',
            'Oujda',
            'Rabat',
            'Safi',
            'Salé',
            'Tangier',
            'Taroudant',
            'Taza',
            'Tétouan',
            'Tiznit',
        ];
    @endphp
    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.doctor') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Doctor
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Edit
                            Doctor</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-center">
        <div class="w-full max-w-lg">
            <form action="{{ route('admin.doctor.edit', $doctor->id) }}" method="POST"
                class="bg-white rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                @method('PUT')
                <h2 class="text-4xl font-semibold leading-tight mb-10">{{ __('Edit Doctor') }}</h2>

                <!-- Nom -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nom">Nom Complet: <span
                            class="text-red-500">*</span>
                    </label>
                    <input
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="nom_input" type="text" name="nom" value="{{ old('nom', $doctor->user->name) }}"
                        placeholder="Enter Your Full Name">
                    <div class="text-red-500 mt-2">
                        @error('nom')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Birthday -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="birthday">Birthday: <span
                            class="text-red-500">*</span>
                    </label>
                    <input
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="birthday_input" type="date" name="birthdate"
                        value="{{ old('birthdate', $doctor->birth_date) }}" placeholder="Enter Your Birthday">
                    <div class="text-red-500 mt-2">
                        @error('birthdate')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- City -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="city">City: <span
                            class="text-red-500">*</span></label>
                    <x-form.select id="city" name="city" required class="block w-full">
                        <option value="" disabled selected>Select your city</option>
                        @foreach ($moroccanCities as $city)
                            <option value="{{ $city }}" @if (old('ville', $doctor->user->address->ville) == $city) selected @endif>
                                {{ $city }}</option>
                        @endforeach
                    </x-form.select>

                    <div class="error_input text-red-500">
                        @error('city')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                <!-- Street -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="rue">Street: <span
                            class="text-red-500">*</span>
                    </label>
                    <input
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="rue_input" type="text" name="rue"
                        value="{{ old('rue', $doctor->user->address->rue) }}" placeholder="Enter Your Street">
                    <div class="text-red-500 mt-2">
                        @error('rue')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email: <span
                            class="text-red-500">*</span>
                    </label>
                    <input
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="email_input" type="email" name="email" value="{{ old('email', $doctor->user->email) }}"
                        placeholder="test@example.com">
                    <div class="text-red-500 mt-2">
                        @error('email')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password:</label>
                    <input
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="password_input" type="password" name="password"
                        placeholder="Leave blank to keep current password">
                    <div class="text-red-500 mt-2">
                        @error('password')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                <!-- Phone -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Phone: <span
                            class="text-red-500">*</span>
                    </label>
                    <input
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="phone_input" type="number" name="phone"
                        value="{{ old('phone', $doctor->user->phone) }}" placeholder="(06 / 05) 00 00 00 00">
                    <div class="text-red-500 mt-2">
                        @error('phone')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Gender -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="gender">Gender: <span
                            class="text-red-500">*</span>
                    </label>
                    <select
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="gender_input" name="gender">
                        <option value="">Choose The Doctor Gender</option>
                        <option selected value="{{ old('gender', $doctor->user->gender) }}">
                            {{ old('gender', $doctor->user->gender) }}</option>
                        <option value="{{ $doctor->user->gender == 'male' ? 'female' : 'male' }}">
                            {{ $doctor->user->gender == 'male' ? 'Female' : 'Male' }}</option>
                    </select>
                    <div class="text-red-500 mt-2">
                        @error('gender')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Degree -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="degree">Degree: <span
                            class="text-red-500">*</span>
                    </label>
                    <select name="degree" id="degree_input">
                        <option value="">Chose The Doctor Degree</option>
                        <option selected value="{{ old('degree', $doctor->degree) }}">
                            {{ old('degree', $doctor->degree) }}</option>

                        <option value="MD">Doctor of Medicine (MD)</option>
                        <option value="DO">Doctor of Osteopathic Medicine (DO)</option>
                        <option value="MBBS">Bachelor of Medicine, Bachelor of Surgery (MBBS)</option>
                        <option value="BDS">Bachelor of Dental Surgery (BDS)</option>
                        <option value="DMD">Doctor of Dental Medicine (DMD)</option>
                        <option value="DDS">Doctor of Dental Surgery (DDS)</option>
                        <option value="DPM">Doctor of Podiatric Medicine (DPM)</option>
                        <option value="PharmD">Doctor of Pharmacy (PharmD)</option>
                        <option value="DPT">Doctor of Physical Therapy (DPT)</option>
                        <option value="DVM">Doctor of Veterinary Medicine (DVM)</option>
                        <option value="MD-PhD">Doctor of Medicine, Doctor of Philosophy (MD-PhD)</option>
                        <option value="MS">Master of Surgery (MS)</option>
                        <option value="MCh">Master of Chirurgery (MCh)</option>
                        <option value="MDS">Master of Dental Surgery (MDS)</option>
                        <option value="DC">Doctor of Chiropractic (DC)</option>
                        <option value="DSc">Doctor of Science (DSc)</option>
                        <option value="EdD">Doctor of Education (EdD)</option>
                        <option value="PsyD">Doctor of Psychology (PsyD)</option>
                        <option value="JD">Doctor of Jurisprudence (JD)</option>
                        <option value="DrPH">Doctor of Public Health (DrPH)</option>
                    </select>
                    <div class="text-red-500 mt-2">
                        @error('degree')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Speciality -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="speciality">Speciality: <span
                            class="text-red-500">*</span>
                    </label>
                    <select
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="speciality_input" name="speciality">
                        <option value="">Choose The Doctor Speciality</option>
                        @foreach ($specialities as $speciality)
                            <option value="{{ $speciality->id }}"
                                {{ old('speciality', $doctor->speciality->id) == $speciality->id ? 'selected' : '' }}>
                                {{ $speciality->name }}</option>
                        @endforeach
                    </select>
                    <div class="text-red-500 mt-2">
                        @error('speciality')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between mt-8">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">Edit Doctor</button>
                    <button
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
