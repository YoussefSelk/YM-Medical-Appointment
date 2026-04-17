@props([
    'isActive' => false,
    'title' => '',
    'collapsible' => false,
])

@php
    $isActiveClasses = $isActive
        ? 'text-white bg-gradient-to-r from-blue-600 to-cyan-500 shadow-lg shadow-blue-500/20 hover:from-blue-600 hover:to-cyan-500'
        : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-300 dark:hover:text-white dark:hover:bg-dark-eval-2';

    $classes =
        'flex-shrink-0 flex items-center gap-2 p-2.5 transition-all rounded-xl overflow-hidden border border-transparent ' . $isActiveClasses;

    if ($collapsible) {
        $classes .= ' w-full';
    }
@endphp

@if ($collapsible)
    <button type="button" {{ $attributes->merge(['class' => $classes]) }}>
        <span
            class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-white/20 text-base {{ $isActive ? 'text-white' : 'text-slate-500' }}">
            @if ($icon ?? false)
                {{ $icon }}
            @else
                <x-icons.empty-circle class="h-5 w-5" aria-hidden="true" />
            @endif
        </span>

        <span class="text-base font-medium whitespace-nowrap" x-show="isSidebarOpen || isSidebarHovered">
            {{ $title }}
        </span>

        <span x-show="isSidebarOpen || isSidebarHovered" aria-hidden="true" class="relative block ml-auto w-6 h-6">
            <span :class="open ? '-rotate-45' : 'rotate-45'"
                class="absolute right-[9px] bg-gray-400 mt-[-5px] h-2 w-[2px] top-1/2 transition-all duration-200"></span>

            <span :class="open ? 'rotate-45' : '-rotate-45'"
                class="absolute left-[9px] bg-gray-400 mt-[-5px] h-2 w-[2px] top-1/2 transition-all duration-200"></span>
        </span>
    </button>
@else
    <a {{ $attributes->merge(['class' => $classes]) }}>
        <span
            class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-white/20 text-base {{ $isActive ? 'text-white' : 'text-slate-500' }}">
            @if ($icon ?? false)
                {{ $icon }}
            @else
                <x-icons.empty-circle class="h-5 w-5" aria-hidden="true" />
            @endif
        </span>

        <span class="text-base font-medium" x-show="isSidebarOpen || isSidebarHovered">
            {{ $title }}
        </span>
    </a>
@endif
