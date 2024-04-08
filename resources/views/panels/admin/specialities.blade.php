<head>
    <link rel="stylesheet" href="{{ asset('css/admin_doctor.css') }}">

</head>
<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Specialities Page') }}
            </h2>
        </div>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>
    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="card content_All_doctors">
            <div class="doctor_count_container">
                <p class="doctor_count">All Specialities (
                <p class="doctor_count_number">{{ count($specialities) }}</p>)</p>
            </div>
            <div class="AddDoc_container">
                <p class="AddDoc">Add New Speciality</p>
                <button x-on:click="$dispatch('open-modal', 'add_speciality')" name="add_speciality" class="">Add
                    Speciality</button>
                {{-- <button id="AddDoc" onclick="showModal()"> + Add New</button> --}}
            </div>
        </div>
    </div>
    <div class="p-6 mt-7 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <h2 class="text-xl font-semibold leading-tight dark:bg-dark-eval-1">
            {{ __('Specialities List') }}
        </h2>
        <div class="mt-5">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 dark:bg-dark-eval-1"
                id="DataTable">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50  dark:text-gray-400 dark:bg-dark-eval-1">
                    <tr class=" bg-gray-50 dark:bg-dark-eval-1">
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> #
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Speciality Name </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-dark-eval-1">
                    @foreach ($specialities as $speciality)
                        <tr class=" hover:bg-gray-100 dark:bg-dark-eval-1">
                            <td class="px-3 py-1">{{ $loop->iteration }}</td>
                            <td class="px-3 py-1">{{ $speciality->name }}</td>
                            <td class="px-3 py-1 flex justify-center items-center"><a
                                    href="{{ route('admin.specialities.edit.view', $speciality->id) }}"
                                    class="px-3 py-1 text-blue-600"><i class="fa-regular fa-pen-to-square"></i></a>
                                <form action="{{ route('admin.specialities.delete', $speciality->id) }}" method="POST"
                                    id="deleteForm{{ $speciality->id }}" class="h-1.5">
                                    @csrf
                                    @method('DELETE')
                                    <a href="#" onclick="confirmDelete('{{ $speciality->id }}')"
                                        class="px-3 py-1 h-0 text-red-600"><i class="fa-solid fa-trash"></i></a>
                                </form>
                                <a href="{{ route('admin.speciality.details', $speciality->id) }}"
                                    class="px-3 py-1 text-blue-600"><i class="fa-regular fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
            </table>
        </div>
</x-admin-layout>
@include('includes.table')
@include('modals.add_speciality')
<script>
    function confirmDelete(specialityId) {
        swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this speciality!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`deleteForm${specialityId}`).submit();
            }
        });
    }
</script>
