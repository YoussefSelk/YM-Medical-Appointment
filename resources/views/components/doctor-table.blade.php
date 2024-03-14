<head>
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<table id="doctorsTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>BirthDate</th>
            <th>Specialty</th>
            <th>Status</th>
            <th>Actions</th>
            <!-- Add more columns if needed -->
        </tr>
    </thead>
    <tbody>
        <!-- DataTable will populate data here -->
    </tbody>
</table>

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
                        }, // Access user's name via the 'user' relationship
                        {
                            data: 'user.email'
                        }, // Access user's email via the 'user' relationship
                        {
                            data: 'birth_date'
                        }, // Assuming 'birthdate' is a property of the 'Doctor' model
                        {
                            data: 'speciality.name'
                        }, // Assuming 'specialty' is a property of the 'Doctor' model
                        {
                            data: 'status'
                        },
                        // Add more columns if needed
                    ]
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
</script>
