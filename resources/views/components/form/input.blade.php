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
        ' py-2.5 border-slate-300 rounded-xl bg-white/95 text-slate-700 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-200',
]) !!}>
