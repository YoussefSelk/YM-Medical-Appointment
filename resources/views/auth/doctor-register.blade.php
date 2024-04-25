<x-guest-layout>
    <x-auth-card>
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
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register.doctor.store') }}">
            @csrf

            <div class="grid gap-6">
                <!-- Name -->
                <div class="space-y-2">
                    <x-form.label for="name" :value="__('Name')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-user aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input withicon id="name" class="block w-full" type="text" name="name"
                            :value="old('name')" required autofocus placeholder="{{ __('Name') }}" />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Email Address -->
                <div class="space-y-2">
                    <x-form.label for="email" :value="__('Email')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-mail aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input withicon id="email" class="block w-full" type="email" name="email"
                            :value="old('email')" required placeholder="{{ __('Email') }}" />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <x-form.label for="password" :value="__('Password')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-lock-closed aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input withicon id="password" class="block w-full" type="password" name="password"
                            required autocomplete="new-password" placeholder="{{ __('Password') }}" />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <x-form.label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-lock-closed aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input withicon id="password_confirmation" class="block w-full" type="password"
                            name="password_confirmation" required placeholder="{{ __('Confirm Password') }}" />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Gender -->
                <div class="space-y-2">
                    <x-form.label for="gender" :value="__('Gender')" />
                    <x-form.select id="gender" class="block w-full" name="gender" required>
                        <option value="male">{{ __('Male') }}</option>
                        <option value="female">{{ __('Female') }}</option>
                    </x-form.select>
                </div>

                <!-- Phone -->
                <div class="space-y-2">
                    <x-form.label for="phone" :value="__('Phone')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-phone aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input withicon id="phone" class="block w-full" type="number" name="phone"
                            :value="old('phone')" required placeholder="{{ __('Phone') }}" />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Degree -->
                <div class="space-y-2">
                    <x-form.label for="degree" :value="__('Degree')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-academic-cap aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input withicon id="degree" class="block w-full" type="text" name="degree"
                            :value="old('degree')" required placeholder="{{ __('Degree') }}" />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Speciality -->
                <div class="space-y-2">
                    <x-form.label for="speciality" :value="__('Speciality')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-collection aria-hidden="true" class="w-5 h-5" />
                        </x-slot>


                        <x-form.select :withicon="true" id="speciality" class="block w-full" type="text"
                            name="speciality" required placeholder="{{ __('Speciality') }}">
                            @foreach ($specialities as $speciality)
                                <option value="{{ $speciality->id }}"
                                    {{ old('speciality') == $speciality->id ? 'selected' : '' }}>
                                    {{ $speciality->name }}
                                </option>
                            @endforeach
                        </x-form.select>


                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Birth Date -->
                <div class="space-y-2">
                    <x-form.label for="birth_date" :value="__('Birth Date')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-calendar aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input withicon id="birth_date" class="block w-full" type="date" name="birth_date"
                            :value="old('birth_date')" required placeholder="{{ __('Birth Date') }}" />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Rue -->
                <div class="space-y-2">
                    <x-form.label for="rue" :value="__('Rue')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-home aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input withicon id="rue" class="block w-full" type="text" name="rue"
                            :value="old('rue')" required placeholder="{{ __('Rue') }}" />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Ville -->
                <div class="space-y-2">
                    <x-form.label for="ville" :value="__('Ville')" />
                    <x-form.select :withicon="true" id="ville" name="ville" required class="block w-full">
                        <option value="" disabled selected>Select your city</option>
                        @foreach ($moroccanCities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                        @endforeach
                    </x-form.select>

                    <div class="error_input text-red-500">
                        @error('city')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Token -->
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <x-button class="justify-center w-full gap-2">
                        <x-heroicon-o-user-add class="w-6 h-6" aria-hidden="true" />

                        <span>{{ __('Register') }}</span>
                    </x-button>
                </div>
                <div>
                    <a href="{{ route('home') }}"
                        class="inline-block text-sm px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg">
                        {{ __('Back to Landing Page') }}
                    </a>
                </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
