@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin_patient.css') }}">
@endpush

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Patients Page') }}
            </h2>
        </div>
    </x-slot>

    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>

    <div class="rounded-md bg-white p-6 dark:bg-dark-eval-1">
        <div class="content_All_patients">
            <div class="patient_count_container">
                <p class="patient_count">All Patient (</p>
                <p class="patient_count_number">{{ count($patients) }}</p>
                <p>)</p>
            </div>
            <div class="AddPatient_container">
                <p class="AddPatient">Add New Patient</p>
                <button x-on:click="$dispatch('open-modal', 'add_patient')" name="AddPatient">Add Patient</button>
            </div>
        </div>
    </div>

    <div class="mt-6 rounded-md bg-white p-6 dark:bg-dark-eval-1">
        <div class="relative overflow-x-auto sm:rounded-lg">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400" id="DataTable">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Profile Picture</th>
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">Patient name</th>
                        <th scope="col" class="px-6 py-3">Total Appointments</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Gender</th>
                        <th scope="col" class="px-6 py-3">Phone</th>
                        <th scope="col" class="px-6 py-3">Address</th>
                        <th scope="col" class="px-6 py-3">CIN</th>
                        <th scope="col" class="px-6 py-3">Registred At</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                        <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                            <th scope="row">
                                @if ($patient->user->img)
                                    <img src="{{ asset('storage/profile_pictures/' . $patient->user->img) }}"
                                        alt="Profile Picture" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ $patient->user->name }}" alt="Profile Picture"
                                        class="h-10 w-10 rounded-full object-cover">
                                @endif
                            </th>
                            <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $patient->id }}
                            </th>
                            <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $patient->user->name }}
                            </th>
                            <td class="px-6 py-4">{{ $patient->appointments_count }}</td>
                            <td class="px-6 py-4">{{ $patient->user->email }}</td>
                            <td class="px-6 py-4">{{ $patient->user->gender }}</td>
                            <td class="px-6 py-4">{{ $patient->user->phone }}</td>
                            <td class="px-6 py-4">{{ $patient->user->address->rue }} , {{ $patient->user->address->ville }}</td>
                            <td class="px-6 py-4">{{ $patient->cin }}</td>
                            <td class="px-6 py-4">{{ $patient->user->created_at }}</td>
                            <td class="flex flex-row items-center justify-around px-6 py-4 text-right">
                                <span class="mr-2">
                                    <a href="{{ route('admin.patient.edit.view', $patient->id) }}"
                                        class="font-medium text-blue-600 dark:text-blue-500"><i class="fa-regular fa-pen-to-square"></i></a>
                                </span>

                                <span class="mr-2">
                                    <form id="deleteForm_{{ $patient->id }}" action="{{ route('admin.patient.delete', $patient->id) }}"
                                        method="POST" class="text-red-600 dark:text-red-500">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('{{ $patient->id }}')"><i
                                                class="fa-solid fa-trash h-0"></i></button>
                                    </form>
                                </span>
                                <span>
                                    <a href="{{ route('admin.table.patient.details', $patient->id) }}"><i
                                            class="fa-regular fa-eye"></i></a>
                                </span>
                                <span>
                                    <a href="{{ route('admin.patient.notify', $patient->id) }}"><i class="fa-regular fa-bell"></i></a>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('modals.add_patient')
    @include('includes.table')

    @push('scripts')
        <script>
            function confirmDelete(patientId) {
                Swal.fire({
                    title: 'Are you sure you want to delete this Patient Account?',
                    text: 'All related Data Will Be Deleted With This Item',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        document.getElementById('deleteForm_' + patientId).submit();
                    }
                });
            }
        </script>
    @endpush
</x-admin-layout>
