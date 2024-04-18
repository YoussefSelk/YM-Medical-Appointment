<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Edit Patient Page') }}
            </h2>
        </div>
    </x-slot>
    <x-success-flash />
    <x-error-flash />
    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md">

        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.patient') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Doctor
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Edit Patient</span>
                    </div>
                </li>
            </ol>
        </nav>

    </div>

    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md flex justify-center ">
        <div class="p-6 bg-white rounded-md">

            <div class="p-6">

                <form action="{{ route('admin.patient.edit', $patient->id) }}" method="POST" class="form"
                    id="form">
                    @csrf
                    @method('PUT')
                    <div class="text-2xl font-bold mb-8">
                        <h1>Edit Patient</h1>
                    </div>

                    <div class="">
                        <div class="mb-4 flex flex-col">
                            <label for="nom" class="block text-gray-700 text-sm font-bold mb-2">Nom
                                Complet: <span class="text-red-500">*</span></label>
                            <input type="text" name="nom" value="{{ old('nom', $patient->user->name) }}"
                                id="nom_input" placeholder="Enter Your Full Name"
                                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <div class="mt-1">
                                @error('nom')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 flex flex-col">
                            <label for="birthday" class="block text-gray-700 text-sm font-bold mb-2">Birthday: <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="birthdate" value="{{ old('birthdate', $patient->birth_date) }}"
                                id="birthday_input" placeholder="Enter Your Birthday"
                                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <div class="mt-1">
                                @error('birthdate')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 flex flex-col">
                            <label for="city" class="block text-gray-700 text-sm font-bold mb-2">City: <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="city"
                                value="{{ old('city', $patient->user->address->ville) }}" placeholder="Enter Your City"
                                id="city_input"
                                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <div class="mt-1">
                                @error('city')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 flex flex-col">
                            <label for="rue" class="block text-gray-700 text-sm font-bold mb-2">Street: <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="rue" value="{{ old('rue', $patient->user->address->rue) }}"
                                id="rue_input" placeholder="Enter Your Street"
                                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <div class="mt-1">
                                @error('rue')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 flex flex-col">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email: <span
                                    class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $patient->user->email) }}"
                                id="email_input" placeholder="test@example.com"
                                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <div class="mt-1">
                                @error('email')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="mb-4 flex flex-col">
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
                        <div class="mb-4 flex flex-col">
                            <label for="cin" class="block text-gray-700 text-sm font-bold mb-2">Cin : <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="cin" value="{{ old('cin', $patient->cin) }}"
                                id="cin_input" placeholder="Enter Patient Cin"
                                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <div class="mt-1">
                                @error('cin')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 flex flex-col">
                            <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone: <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="phone" value="{{ old('phone', $patient->user->phone) }}"
                                id="phone_input" placeholder="(06 / 05) 00 00 00 00"
                                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <div class="mt-1">
                                @error('phone')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 flex flex-col">
                            <label for="gender" class="block text-gray-700 text-sm font-bold mb-2">Gender: <span
                                    class="text-red-500">*</span></label>
                            <select name="gender" id="gender_input"
                                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="" disabled>Select The Patient Gender</option>
                                <option value="male"
                                    {{ old('gender', $patient->user->gender) === 'male' ? 'selected' : '' }}>
                                    Male
                                </option>
                                <option value="female"
                                    {{ old('gender', $patient->user->gender) === 'female' ? 'selected' : '' }}>
                                    Female
                                </option>
                            </select>
                            <div class="mt-1">
                                @error('gender')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-center">
                        <button type="submit"
                            class="rounded-lg px-6 py-2 bg-blue-500 text-white font-semibold hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                            Edit Patient
                        </button>
                        <input type="reset"
                            class="px-6 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
