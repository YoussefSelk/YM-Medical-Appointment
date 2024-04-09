<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css">
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.7.0/js/buttons.flash.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

    <style>
        select.dt-input {
            width: 60px;
        }

        button.dt-button {
            margin-bottom: 10px;
            background-color: #3B82F6 !important;
            border: none !important;
            color: white !important;
            border-radius: 7px !important;
        }

        button.dt-button:hover {
            background-color: #2574f5 !important;
            border: none !important;
            color: white !important;
            border-radius: 7px !important;
        }
    </style>
</head>

<script>
    $(document).ready(function() {
        var table = $('#DataTable').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
