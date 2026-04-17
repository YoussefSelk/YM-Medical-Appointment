@once
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js" defer></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js" defer></script>

    <style>
        .dataTables_wrapper .dataTables_filter input {
            margin-left: .5rem;
            min-width: 170px;
        }

        .dataTables_wrapper .dataTables_length select {
            width: 70px;
        }

        table.dataTable thead th {
            background: #f8fafc;
            color: #475569;
            font-size: .75rem;
            letter-spacing: .05em;
        }

        table.dataTable tbody tr:hover {
            background: #f1f5ff;
        }

        .dark table.dataTable thead th {
            background: #1f2937;
            color: #cbd5e1;
        }

        .dark table.dataTable tbody tr:hover {
            background: #111827;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var startDataTable = function() {
                if (!window.jQuery || !$.fn.DataTable) {
                    window.setTimeout(startDataTable, 120);
                    return;
                }

                if (!document.getElementById('DataTable')) {
                    return;
                }

                if ($.fn.DataTable.isDataTable('#DataTable')) {
                    return;
                }

                $('#DataTable').DataTable({
                    responsive: true,
                    stateSave: true,
                    pageLength: 10,
                    autoWidth: false,
                    dom: 'Bfrtip',
                    buttons: ['csv', 'excel', 'pdf', 'print'],
                    language: {
                        search: 'Search:',
                        lengthMenu: 'Show _MENU_',
                    },
                });
            };

            startDataTable();
        });
    </script>
@endonce

