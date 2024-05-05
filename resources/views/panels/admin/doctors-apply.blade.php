<head>
    <title>Admin's Doctors Applies Page</title>
</head>
<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Doctors Apply Page') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <table class="min-w-full divide-y divide-gray-200" id="DataTable">
            <thead class="bg-gray-50">
                <tr class="dark:bg-gray-800 dark:text-white dark:border-gray-700">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Details</th>
                    <th>CV</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($applications as $application)
                    <tr>
                        <td>{{ $application->id }}</td>
                        <td>{{ $application->name }}</td>
                        <td>{{ $application->email }}</td>
                        <td>{{ $application->details }}</td>
                        <td>
                            <a href="{{ asset('storage/cv/' . $application->cv) }}" target="_blank"><i
                                    class="fa-solid fa-file" style="color: #74C0FC;"></i></a>
                        </td>
                        <td>{{ $application->status }}</td>
                        <td>
                            <form action="">
                                <a href="#" class="approve-btn" data-id="{{ $application->id }}"><i
                                        class="fa-solid fa-thumbs-up" style="color: green;"></i></a>

                                <a href="#" class="reject-btn" data-id="{{ $application->id }}"><i
                                        class="fa-solid fa-thumbs-down" style="color: red;"></i></a>

                                <a href="#" class="delete-btn" data-id="{{ $application->id }}"><i
                                        class="fa-solid fa-trash" style="color: red;"></i></a>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>
@include('includes.table')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const approveButtons = document.querySelectorAll('.approve-btn');
        const rejectButtons = document.querySelectorAll('.reject-btn');
        const deleteButtons = document.querySelectorAll('.delete-btn');

        approveButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const applicationId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Do you want to approve this application?',
                    showCancelButton: true,
                    confirmButtonText: `Approve`,
                    cancelButtonText: `Cancel`,
                    icon: 'question',
                    html: '<form id="approve-form">' +
                        '<input type="hidden" name="application_id" value="' +
                        applicationId + '">' +
                        '<label for="comment">Comment:</label>' +
                        '<input type="text" id="comment" name="comment">' +
                        '</form>',
                    preConfirm: () => {
                        const comment = document.getElementById('comment').value;
                        return fetch(
                                `/admin/approve-application/${applicationId}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        comment: comment
                                    })
                                })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                    `Request failed: ${error}`
                                )
                            })
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Approved!',
                            'The application has been approved.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }
                });
            });
        });

        rejectButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const applicationId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Do you want to reject this application?',
                    showCancelButton: true,
                    confirmButtonText: `Reject`,
                    cancelButtonText: `Cancel`,
                    icon: 'question',
                    html: '<form id="reject-form">' +
                        '<input type="hidden" name="application_id" value="' +
                        applicationId + '">' +
                        '<label for="comment">Comment:</label>' +
                        '<input type="text" id="comment" name="comment">' +
                        '</form>',
                    preConfirm: () => {
                        const comment = document.getElementById('comment').value;
                        return fetch(`/admin/reject-application/${applicationId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    comment: comment
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                    `Request failed: ${error}`
                                )
                            })
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Rejected!',
                            'The application has been rejected.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }
                });
            });
        });

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const applicationId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Do you want to delete this application?',
                    showCancelButton: true,
                    confirmButtonText: `Delete`,
                    cancelButtonText: `Cancel`,
                    icon: 'question',
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/delete-application/${applicationId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .then(data => {
                                Swal.fire(
                                    'Deleted!',
                                    'The application has been deleted.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            })
                            .catch(error => {
                                Swal.fire(
                                    'Error!',
                                    `Failed to delete application: ${error}`,
                                    'error'
                                );
                            })
                    }
                });
            });
        });

    });
</script>
