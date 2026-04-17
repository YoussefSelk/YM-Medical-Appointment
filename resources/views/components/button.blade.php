@props([
    'variant' => 'primary',
    'iconOnly' => false,
    'srText' => '',
    'href' => false,
    'size' => 'base',
    'disabled' => false,
    'pill' => false,
    'squared' => false,
])

@php

    $baseClasses =
        'inline-flex items-center justify-center gap-2 font-semibold select-none transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed';

    switch ($variant) {
        case 'primary':
            $variantClasses = 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500 shadow-sm';
            break;
        case 'secondary':
            $variantClasses =
                'bg-white text-slate-600 hover:bg-slate-100 focus:ring-slate-300 border border-slate-200 dark:border-slate-700 dark:text-gray-300 dark:bg-dark-eval-1 dark:hover:bg-dark-eval-2';
            break;
        case 'success':
            $variantClasses = 'bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-500 shadow-sm';
            break;
        case 'danger':
            $variantClasses = 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 shadow-sm';
            break;
        case 'warning':
            $variantClasses = 'bg-amber-500 text-white hover:bg-amber-600 focus:ring-amber-500 shadow-sm';
            break;
        case 'info':
            $variantClasses = 'bg-cyan-600 text-white hover:bg-cyan-700 focus:ring-cyan-500 shadow-sm';
            break;
        case 'black':
            $variantClasses =
                'bg-slate-900 text-gray-100 hover:bg-slate-800 focus:ring-slate-500 dark:bg-dark-eval-2 dark:hover:bg-dark-eval-3';
            break;
        default:
            $variantClasses = 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500 shadow-sm';
    }

    switch ($size) {
        case 'sm':
            $sizeClasses = $iconOnly ? 'p-2' : 'px-3 py-2 text-sm';
            break;
        case 'base':
            $sizeClasses = $iconOnly ? 'p-2.5' : 'px-4 py-2.5 text-sm';
            break;
        case 'lg':
        default:
            $sizeClasses = $iconOnly ? 'p-3.5' : 'px-5 py-3 text-base';
            break;
    }

    $classes = $baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses;

    if (!$squared && !$pill) {
        $classes .= ' rounded-xl';
    } elseif ($pill) {
        $classes .= ' rounded-full';
    }

@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
        @if ($iconOnly)
            <span class="sr-only">{{ $srText ?? '' }}</span>
        @endif
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>
        {{ $slot }}
        @if ($iconOnly)
            <span class="sr-only">{{ $srText ?? '' }}</span>
        @endif
    </button>
@endif
