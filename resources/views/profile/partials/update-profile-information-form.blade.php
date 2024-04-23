<section>
    <header>
        <h2 class="text-lg font-medium">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>
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
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="space-y-2">
            <x-form.label for="name" :value="__('Name')" />

            <x-form.input id="name" name="name" type="text" class="block w-full" :value="old('name', $user->name)" required
                autofocus autocomplete="name" />

            <x-form.error :messages="$errors->get('name')" />
        </div>
        <div class="space-y-2">
            <x-form.label for="gender" :value="__('Gender')" />
            <x-form.select id="gender" name="gender" class="block w-full" required autofocus>
                <option value="" disabled>Select your gender</option>
                <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Female</option>
            </x-form.select>

        </div>
        <div class="space-y-2">
            <x-form.label for="phone" :value="__('Phone')" />
            <x-form.input id="phone" name="phone" type="text" class="block w-full" :value="old('phone', $user->phone)" required
                autofocus autocomplete="phone" />
            <x-form.error :messages="$errors->get('phone')" />
        </div>
        <div class="space-y-2">
            <x-form.label for="ville" :value="__('Ville')" />
            <x-form.select id="ville" name="ville" required class="block w-full">
                <option value="" disabled>Select your city</option>
                @foreach ($moroccanCities as $city)
                    <option value="{{ $city }}"
                        {{ old('ville', $user->address->ville ?? '') == $city ? 'selected' : '' }}>
                        {{ $city }}
                    </option>
                @endforeach
            </x-form.select>


            <x-form.error :messages="$errors->get('address')" />
        </div>
        @if (Auth::user()->user_type == 'patient')
            <div class="space-y-2">
                <x-form.label for="cin" :value="__('Cin')" />

                <x-form.input id="cin" name="cin" type="text" class="block w-full" :value="old('cin', $user->patient->cin)"
                    required autofocus autocomplete="cin" />

                <x-form.error :messages="$errors->get('cin')" />
            </div>
            <div class="space-y-2">
                <x-form.label for="birth_date" :value="__('Birth Date')" />
                <x-form.input id="birth_date" name="birth_date" type="date" class="block w-full" :value="old('birth_date', $user->patient->birth_date)"
                    required autofocus />
                <x-form.error :messages="$errors->get('birth_date')" />
            </div>
        @endif
        <div class="space-y-2">
            <x-form.label for="email" :value="__('Email')" />

            <x-form.input id="email" name="email" type="email" class="block w-full" :value="old('email', $user->email)" required
                autocomplete="email" />

            <x-form.error :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-300">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500  dark:text-gray-400 dark:hover:text-gray-200 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-button>
                <span class="mr-2"><i class="fa-regular fa-floppy-disk"
                        style="color: #ffffff;"></i></span>{{ __('Save') }}
            </x-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>

</section>
