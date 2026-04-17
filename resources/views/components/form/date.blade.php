@props([
    'disabled' => false,
    'withicon' => false,
])

@php
    $withiconClasses = $withicon ? 'pl-11 pr-4' : 'px-4';
@endphp

<div class="relative">
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' =>
            $withiconClasses .
            ' block w-full py-2.5 border-slate-300 rounded-xl bg-white/95 text-slate-700 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500',
    ]) !!}>
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
        <svg class="h-5 w-5 text-slate-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-13 9h16a1 1 0 001-1V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a1 1 0 001 1z"></path>
        </svg>
    </div>
</div>
