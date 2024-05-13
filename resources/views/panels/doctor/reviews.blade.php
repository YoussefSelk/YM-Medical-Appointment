<head>
    <title>Doctor's Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css?v=1628755089081">
</head>

<x-doctor-layout>



    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My reviews') }}
        </h2>
    </x-slot>


    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        @if ($ratings->count() == 0)

        <p> <strong>No Rating yet .</p>

        @else

            <p class="text-lg font-bold mb-4">Overall rating: {{ $ratings->avg('rating') }}</p>
            <div class="flex items-center" id="ratingStars">
                <!-- Stars will be dynamically generated here -->
            </div>

        @endif

    </div>

    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="overflow-x-auto">
            <table id="DataTable" class="w-full">
                <thead>
                    <tr>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            #</th>

                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Name</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Rating </th>


                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Comment </th>



                    </tr>
                </thead>
                <tbody>

                    @if ($ratings)
                    @foreach ($ratings as $item)
                        <tr class="transition-all duration-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                {{ $item->id }}</td>

                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                {{ $item->patient->user->name  }}</td>

                            <td
                                class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                {{ $item->rating  }}</td>

                            <td class="py-2 px-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                {{ $item->comment}}
                            </td>





                        </tr>

                        @endforeach
                </tbody>
            </table>



        </div>
    </div>

    @else
    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">No review Found</h1>
    </div>
    @endif








@include('includes.table')

</x-doctor-layout>

<script>
    const overallRating = {{ $ratings->avg('rating') }};
    const starContainer = document.getElementById('ratingStars');

    for (let i = 1; i <= 5; i++) {
        const star = document.createElement('i');
        star.className = 'fa-solid fa-star';
        if (i <= Math.floor(overallRating)) {
            star.classList.add('text-yellow-500');
        } else if (i === Math.ceil(overallRating)) {
            // If decimal part is 0.5, display half-filled star
            star.classList.add('text-yellow-500', 'fa-star-half-alt');
        } else {
            star.classList.add('text-gray-400');
        }
        starContainer.appendChild(star);
    }
</script>
