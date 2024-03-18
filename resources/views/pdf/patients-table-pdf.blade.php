<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .heading {
            margin-bottom: 30px
        }
    </style>
</head>

<body>

    <div class="heading">
        <div class="logo">
            <h1 class="text-3xl text-slate-950">YM | Medical Appointments</h1>
        </div>

    </div>

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="DataTable">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Doctor name
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Gender
                </th>
                <th scope="col" class="px-6 py-3">
                    Phone
                </th>
                <th scope="col" class="px-6 py-3">
                    Address
                </th>
                <th scope="col" class="px-6 py-3">
                    CIN
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $patient->id }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $patient->user->name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $patient->user->email }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $patient->user->gender }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $patient->user->phone }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $patient->user->address->rue }} , {{ $patient->user->address->ville }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $patient->cin }}
                    </td>

                </tr>
            @endforeach


        </tbody>
    </table>
</body>

</html>
