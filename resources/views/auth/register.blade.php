<x-guest-layout>
    <x-auth-card>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <x-success-flash></x-success-flash>
        <x-error-flash></x-error-flash>
        <form method="POST" action="{{ route('register') }}">
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

                    <x-form.select id="gender" class="block w-full" name="gender" required>
                        <option value="male">{{ __('Male') }}</option>
                        <option value="female">{{ __('Female') }}</option>
                        <option value="other">{{ __('Other') }}</option>
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

                <!-- Cin -->
                <div class="space-y-2">
                    <x-form.label for="cin" :value="__('CIN')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-identification aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input withicon id="cin" class="block w-full" type="number" name="cin"
                            :value="old('cin')" required placeholder="{{ __('CIN') }}" />
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

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-location-marker aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input withicon id="ville" class="block w-full" type="text" name="ville"
                            :value="old('ville')" required placeholder="{{ __('Ville') }}" />
                    </x-form.input-with-icon-wrapper>
                </div>

                <div>
                    <x-button class="justify-center w-full gap-2">
                        <x-heroicon-o-user-add class="w-6 h-6" aria-hidden="true" />

                        <span>{{ __('Register') }}</span>
                    </x-button>
                </div>

                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Already registered?') }}
                    <a href="{{ route('login') }}" class="text-blue-500 hover:underline">
                        {{ __('Login') }}
                    </a>
                </p>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
