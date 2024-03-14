<head>
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
    
</body>
