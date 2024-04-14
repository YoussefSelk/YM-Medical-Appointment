<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Patient Notify Page') }}
            </h2>
        </div>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>
    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.patient') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Patiens
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Patient
                            Notify</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    <div class="p-6 mt-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <h3 class="text-lg font-semibold mb-4">Send Notification to Patient</h3>
        <form method="POST" action="{{ route('admin.patient.notify.submit', $patient->id) }}">
            @csrf

            <div class="space-y-2">
                <x-form.label for="title" :value="__('Title')" />

                <x-form.input id="title" name="title" type="text" class="block w-full" :value="old('title', 'System Notification')"
                    required autofocus autocomplete="title" />

                <x-form.error :messages="$errors->get('title')" />
            </div>

            <div class="space-y-2">
                <x-form.label for="message" :value="__('Message')" />
                <textarea name="message" id="message" rows="4"
                    class="mt-1 p-2 block w-full rounded-md border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    required></textarea>
                <x-form.error :messages="$errors->get('title')" />
            </div>
            <div class="flex justify-end mt-3">
                <x-button>
                    {{ __('Send') }}
                </x-button>
            </div>
        </form>
    </div>
</x-admin-layout>
