<head>
    <link rel="stylesheet" href="{{ asset('css/admin_patient.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Admin's Patients Page</title>

</head>
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
    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="card content_All_patients">
            <div class="patient_count_container">
                <p class="patient_count">All Patient (
                <p class="patient_count_number">{{ count($patients) }}</p>)</p>
            </div>
            <div class="AddPatient_container">
                <p class="AddPatient">Add New Patient</p>
                <button x-on:click="$dispatch('open-modal', 'add_patient')" name="AddPatient" class="">Add
                    Patient</button>
                {{-- <button id="AddDoc" onclick="showModal()"> + Add New</button> --}}
            </div>
        </div>
    </div>
    <div class="p-6 mt-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">

        <div class="relative overflow-x-auto sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="DataTable">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Patient name
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
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $patient->id }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
                            <td class="px-6 py-4 text-right flex flex-row">
                                <a href="{{ route('admin.patient.edit.view', $patient->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 mr-2">Edit</a>

                                <!-- In your Blade view file -->
                                <form id="deleteForm_{{ $patient->id }}"
                                    action="{{ route('admin.patient.delete', $patient->id) }}" method="POST"
                                    class="font-medium text-red-600 dark:text-red-500">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger"
                                        onclick="confirmDelete('{{ $patient->id }}')">Delete</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>

    </div>
    @include('modals.add_patient')
    @include('includes.table')
</x-admin-layout>

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
                // If confirmed, submit the specific form for the patient
                document.getElementById('deleteForm_' + patientId).submit();
            }
        });
    }
</script>
