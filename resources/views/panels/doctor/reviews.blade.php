<x-doctor-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight dark:text-white">{{ __('My reviews') }}</h2>
    </x-slot>

    @php
        $overallRating = $ratings->count() ? (float) $ratings->avg('rating') : 0;
    @endphp

    <div class="mt-7 overflow-hidden rounded-md bg-white p-6 shadow-md dark:bg-dark-eval-1">
        @if ($ratings->count() == 0)
            <p><strong>No Rating yet.</strong></p>
        @else
            <p class="mb-2 text-lg font-bold">Overall rating: {{ number_format($overallRating, 1) }}</p>
            <div class="flex items-center gap-1">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= floor($overallRating))
                        <i class="fa-solid fa-star text-yellow-500"></i>
                    @elseif ($i == ceil($overallRating) && fmod($overallRating, 1) > 0)
                        <i class="fa-solid fa-star-half-stroke text-yellow-500"></i>
                    @else
                        <i class="fa-solid fa-star text-gray-300"></i>
                    @endif
                @endfor
            </div>
        @endif
    </div>

    @if ($ratings->count())
        <div class="mt-7 overflow-hidden rounded-md bg-white p-6 shadow-md dark:bg-dark-eval-1">
            <div class="overflow-x-auto">
                <table id="DataTable" class="w-full">
                    <thead>
                        <tr>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">#</th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">Name</th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">Rating</th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ratings as $item)
                            <tr class="transition-all duration-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="border-b border-gray-200 bg-white px-5 py-2 text-sm dark:border-gray-700 dark:bg-gray-800">{{ $item->id }}</td>
                                <td class="border-b border-gray-200 bg-white px-5 py-2 text-sm dark:border-gray-700 dark:bg-gray-800">{{ $item->patient->user->name }}</td>
                                <td class="border-b border-gray-200 bg-white px-5 py-2 text-sm dark:border-gray-700 dark:bg-gray-800">{{ $item->rating }}</td>
                                <td class="border-b border-gray-200 bg-white px-5 py-2 text-sm dark:border-gray-700 dark:bg-gray-800">{{ $item->comment }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @include('includes.table')
    @else
        <div class="mt-7 overflow-hidden rounded-md bg-white p-6 shadow-md dark:bg-dark-eval-1">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">No review found</h1>
        </div>
    @endif
</x-doctor-layout>
