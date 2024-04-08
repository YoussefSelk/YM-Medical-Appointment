<head>
    <title>Doctor's Dashboard</title>

</head>

<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Schedule') }}
        </h2>
    </x-slot>

     <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>
{{--
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
                <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action
            </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($schedule as $item)

                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($item->day) }}</td>
                       <td class="px-6 py-4 whitespace-nowrap">{{ $item->start }}</td>
                       <td class="px-6 py-4 whitespace-nowrap">{{ $item->end }}</td>
                       <td class="px-6 py-4 whitespace-nowrap">

                        <a href="{{route('doctor.CRUD.schedule.edit', [$item->id])}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" >Edit Schedule</a>
                    </td>
                       <td class="px-6 py-4 whitespace-nowrap">

                           <form method="POST" action="{{ route('doctor.schedule.delete', [$item->id]) }}" onsubmit="return confirm('Are you sure you want to delete this schedule?')">
                               @csrf
                               @method('DELETE')
                               <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete Schedule</button>
                           </form>
                        </td>

                   </tr>

            @endforeach

        </tbody>
    </table>
</div>--}}


<div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
    <div class="overflow-x-auto">
        <table id="schedulesTable" class="w-full">
            <thead>
                <tr>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                        #</th>

                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                        Day</th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                        Start </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                        End</th>

                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                        Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedule as $item)
                    <tr class="transition-all duration-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td
                            class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                            {{ $item->id }}</td>

                        <td
                            class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                            {{ ucfirst($item->day) }}</td>
                        <td
                            class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                            {{ $item->start }}</td>
                        <td class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                            {{ $item->end }}
                        </td>

                        <td
                            class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                            <a href="{{route('doctor.CRUD.schedule.edit', [$item->id])}}" class="text-blue-600 hover:text-blue-900" >Edit Schedule</a>
                            <form method="POST" action="{{ route('doctor.schedule.delete', [$item->id]) }}" onsubmit="return confirm('Are you sure you want to delete this schedule?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete Schedule</button>
                            </form>
                        </td>

                        <td  class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</x-doctor-layout>
@include('includes.table')
