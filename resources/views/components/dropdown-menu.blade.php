@props([
    'active' => false,
    'icon' => '',
])

<div class="relative" x-data="{ open: @json($active) }">
    <button type="button"
        class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-left text-gray-600 transition-colors duration-150 bg-transparent border border-transparent rounded-lg "
        x-on:click="open = !open">
        <span>{!! $icon !!}</span>
        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
            :class="{ 'rotate-180': open }">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 1 1-1.414-1.414L8.586 11H2a1 1 0 0 1 0-2h6.586l-1.293-1.293z"
                clip-rule="evenodd" />
        </svg>
    </button>
    <div x-show="open" x-on:click.away="open = false"
        class="absolute right-0 z-10 mt-2 bg-white shadow-lg rounded-md w-48 ring-1 ring-black ring-opacity-5">
        {{ $slot }}
    </div>
</div>
