<head>
    <title>Doctor's Dashboard</title>

</head>

<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Schedule') }}
        </h2>
    </x-slot>


<div class="p-6 mb-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="DataTable">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr class="bg-gray-50">
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start
                    Time</th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($schedule as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($item->day) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->start }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->end }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-doctor-layout>
