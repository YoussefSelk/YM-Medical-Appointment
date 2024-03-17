<head>
    <link rel="stylesheet" href="{{ asset('css/admin_doctor.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>
<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Doctors Page') }}
            </h2>

        </div>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>
    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="card content_All_doctors">
            <div class="doctor_count_container">
                <p class="doctor_count">All Doctors (
                <p class="doctor_count_number">{{ count($doctors) }}</p>)</p>
            </div>
            <div class="AddDoc_container">
                <p class="AddDoc">Add New Doctor</p>
                <button x-on:click="$dispatch('open-modal', 'example-modal')" name="AddDoc" class="">Add Doctor</button>
                {{-- <button id="AddDoc" onclick="showModal()"> + Add New</button> --}}
            </div>
        </div>
    </div>


    <div class="p-6 mt-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <x-download-botton route="{{ route('admin.table.doctors.pdf') }}" />
        {{-- <a href="{{route('admin.table.doctors.pdf')}}" class=" top-4 right-4 font-medium text-blue-600 dark:text-blue-500 mr-2">Export PDF</a> --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
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
                            Degree
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Speciality
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $doctor)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $doctor->id }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $doctor->user->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $doctor->user->email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $doctor->user->gender }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $doctor->user->phone }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $doctor->user->address->rue }} , {{ $doctor->user->address->ville }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $doctor->degree }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $doctor->status }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $doctor->speciality->name }}
                            </td>
                            <td class="px-6 py-4 text-right flex flex-row">
                                <a href="{{ route('admin.doctor.edit.view', $doctor->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 mr-2">Edit</a>

                                <!-- In your Blade view file -->
                                <form id="deleteForm" action="{{ route('admin.doctor.delete', $doctor->id) }}"
                                    method="POST" class="font-medium text-red-600 dark:text-red-500 ">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger"
                                        onclick="confirmDelete()">Delete</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>

    </div>
    @include('modals.add_doctor')
    @include('includes.table')
</x-admin-layout>

<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Are you sure you want to delete this Doctor Account?',
            text: 'All related Data Will Be Deleted With This Item',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                // If confirmed, submit the form
                document.getElementById('deleteForm').submit();
            }
        });
    }
</script>
