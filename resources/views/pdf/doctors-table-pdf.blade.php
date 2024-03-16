<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://unpkg.com/flowbite@1.4.4/dist/flowbite.js"></script>
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

    <table>
        <caption>Doctors List</caption>
        <thead>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Doctor name
                </th>
                <th>
                    Email
                </th>
                <th>
                    Gender
                </th>
                <th>
                    Phone
                </th>
                <th>
                    Address
                </th>
                <th>
                    Speciality
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($doctors as $doctor)
                <tr>
                    <th scope="row">
                        {{ $doctor->id }}
                    </th>
                    <th scope="row">
                        {{ $doctor->user->name }}
                    </th>
                    <td>
                        {{ $doctor->user->email }}
                    </td>
                    <td>
                        {{ $doctor->user->gender }}
                    </td>
                    <td>
                        {{ $doctor->user->phone }}
                    </td>
                    <td>
                        {{ $doctor->user->address->rue }} , {{ $doctor->user->address->ville }}
                    </td>

                    <td>
                        {{ $doctor->speciality->name }}
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
</body>

</html>
