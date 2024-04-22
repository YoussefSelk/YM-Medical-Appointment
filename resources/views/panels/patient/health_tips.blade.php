<head>
    <title>YM | Health Tips</title>
</head>
<x-patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            <span class="mr-2"><i class="fa-solid fa-list" style="color: #74C0FC;"></i></span> {{ __('Doctors List') }}
        </h2>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>

    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <h2>
            <strong>Health Tips</strong>
        </h2>
    </div>
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-8">Health Tips</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @if(isset($healthTips) && count($healthTips) > 0)
                @foreach($healthTips as $healthTip)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ $healthTip['urlToImage'] }}" alt="{{ $healthTip['title'] }}" class="w-full h-40 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-4">{{ $healthTip['title'] }}</h3>
                            <p class="text-gray-700">{{ $healthTip['description'] }}</p>
                            <a href="{{ $healthTip['url'] }}" class="text-blue-500 mt-4 inline-block" target="_blank">Read more</a>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No health tips available at the moment.</p>
            @endif
        </div>
    </div>
</x-patient-layout>
