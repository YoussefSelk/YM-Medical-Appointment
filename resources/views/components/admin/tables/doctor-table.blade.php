{{-- <head>
    <!-- Include Tailwind CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

</head>
<body class="bg-white dark:bg-gray-900"> <!-- Apply dark mode to the body -->
    <div class="container mx-auto px-4 py-8 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <table id="doctorsTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">BirthDate</th>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Specialty</th>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    <!-- Add more columns if needed -->
                </tr>
            </thead>
            <tbody>
                <!-- DataTable will populate data here -->
            </tbody>
        </table>
    </div>

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Include DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('admin.table.doctors') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#doctorsTable').DataTable({
                        data: data,
                        columns: [{
                                data: 'id'
                            },
                            {
                                data: 'user.name'
                            },
                            {
                                data: 'user.email'
                            },
                            {
                                data: 'birth_date'
                            },
                            {
                                data: 'speciality.name'
                            },
                            {
                                data: 'status'
                            },
                        ],
                        // Add DataTable options for customization
                        "paging": true, // Example: Enable paging
                        "ordering": true, // Example: Enable ordering
                        "info": true, // Example: Show information
                        "createdRow": function(row, data, dataIndex) {
                            $(row).addClass('no-background-color'); // Add class to rows without background color
                        }
                        // Add more options as needed
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>

</body> --}}
{{--
<head>
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>
    <link href="/dist/css/semantic-ui/tabulator_semantic-ui.min.css" rel="stylesheet">

    <style>
        .tabulator-row {
            background-color: transparent !important;
            /* Make rows transparent */
        }

        .tabulator-row .tabulator-cell {
            background-color: transparent !important;
            /* Make cells transparent */
        }

        #userTable {
            background-color: transparent !important;
            /* Make table background transparent */
        }
    </style>
</head>
<table class="table-auto" id="userTable" ></table>
<script>
    var table = new Tabulator("#userTable", {
        ajaxURL: "{{ route('admin.table.doctors') }}", // Replace with your route for fetching data
        layout: "fitColumns",
        columns: [{
                title: "id",
                field: "id"
            },
            {
                title: "Email",
                field: "user.email"
            },
            {
                title: "Phone",
                field: "user.phone"
            },
            {
                title: "BirthDate",
                field: "birth_date"
            },
            {
                title: "Speciality",
                field: "speciality.name"
            },
            // Add more columns as needed
        ],
    });
</script> --}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors Table</title>
    <link href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Include Tailwind CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        .dataTables_wrapper .dataTables_filter input {
            background-color: #f3f4f6;
            /* Change the background color */
            border-color: #e5e7eb;
            /* Change the border color */
            border-radius: 0.375rem;
            /* Add border-radius */
            padding: 0.5rem;
            /* Add padding */
            font-size: 0.875rem;
            /* Change font size */
            color: #4b5563;
            /* Change text color */
        }

        .dataTables_filter input {
            margin-left: 10px;
        }

        .dataTables_info {
            margin-top: 1rem;
        }

        /* Custom styling for DataTables length menu and search input */
        .dataTables_length select {
            width: 60px;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            display: inline-block;
            /* Use inline-block */
            vertical-align: middle;
            /* Align items vertically */
            width: 45%;
            margin-bottom: 2rem;
            /* Set initial width */
        }


        /* Media query for smaller screens */
        @media screen and (max-width: 768px) {

            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                width: 100%;
                /* Full width on smaller screens */
                margin-left: 0;
                /* Remove left margin */
                margin-top: 1rem;

                /* Add top margin */
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <div id="tableContainer" class="p-4">
        <table id="userTable" class="table-auto w-full bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Speciality</th>
                    <th>Birthdate</th>
                    <th>Actions</th>
                    <!-- Add more table headers as needed -->
                </tr>
            </thead>
            <tbody>
                <!-- Table rows will be dynamically added here -->
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Include DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <!-- Include your JavaScript code here -->
    <script>
        axios.get('{{ route('admin.table.doctors') }}')
            .then(response => {
                // Handle successful response
                populateTable(response.data);
                // Initialize DataTable with search and sorting
                $('#userTable').DataTable({
                    searching: true, // Enable search field
                    ordering: true, // Enable sorting on columns
                    paging: true // Enable pagination
                });
            })
            .catch(error => {
                // Handle error
                console.error('Error fetching data:', error);
            });

        function populateTable(data) {
            const tableBody = document.querySelector('#userTable tbody');
            data.forEach(doctor => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="border px-4 py-2">${doctor.user.name}</td>
                    <td class="border px-4 py-2">${doctor.user.email}</td>
                    <td class="border px-4 py-2">${doctor.user.phone}</td>
                    <td class="border px-4 py-2">${doctor.speciality.name}</td>
                    <td class="border px-4 py-2">${doctor.birth_date}</td>
                    <td class="border px-4 py-2"><a href="" class="text-blue-600">Edit </a><a href="" class="text-red-500"> Delete</a> </td>
                `;
                tableBody.appendChild(row);
            });
        }
    </script>

</body>
