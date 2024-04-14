@props([
    'disabled' => false,
    'withicon' => false,
])

@php
    $withiconClasses = $withicon ? 'pl-11 pr-4' : 'px-4';
@endphp

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        $withiconClasses .
        ' py-2 border-gray-400 rounded-md dark:border-gray-600 dark:bg-dark-eval-1
            dark:text-gray-300',
]) !!}>
