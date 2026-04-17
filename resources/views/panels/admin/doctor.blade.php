@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin_doctor.css') }}">
@endpush

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

    <div class="rounded-md bg-white p-6 dark:bg-dark-eval-1">
        <div class="content_All_doctors">
            <div class="doctor_count_container">
                <p class="doctor_count">All Doctors (</p>
                <p class="doctor_count_number">{{ count($doctors) }}</p>
                <p>)</p>
            </div>
            <div class="AddDoc_container">
                <p class="AddDoc">Add New Doctor</p>
                <button x-on:click="$dispatch('open-modal', 'example-modal')" name="AddDoc">Add Doctor</button>
            </div>
        </div>
    </div>

    <div class="mt-6 rounded-md bg-white p-6 dark:bg-dark-eval-1">
        <div class="relative overflow-x-auto sm:rounded-lg">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400" id="DataTable">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Profile Image</th>
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">Doctor name</th>
                        <th scope="col" class="px-6 py-3">Total Appointments</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Gender</th>
                        <th scope="col" class="px-6 py-3">Phone</th>
                        <th scope="col" class="px-6 py-3">Address</th>
                        <th scope="col" class="px-6 py-3">Degree</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Speciality</th>
                        <th scope="col" class="px-6 py-3">Registred At</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $doctor)
                        <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                            <th scope="row">
                                @if ($doctor->user->img)
                                    <img src="{{ asset('storage/profile_pictures/' . $doctor->user->img) }}"
                                        alt="Profile Picture" class="h-12 w-12 rounded-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ $doctor->user->name }}" alt="Profile Picture"
                                        class="h-10 w-10 rounded-full object-cover">
                                @endif
                            </th>
                            <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $doctor->id }}
                            </th>
                            <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $doctor->user->name }}
                            </th>
                            <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $doctor->appointments_count }}
                            </th>
                            <td class="px-6 py-4">{{ $doctor->user->email }}</td>
                            <td class="px-6 py-4">{{ $doctor->user->gender }}</td>
                            <td class="px-6 py-4">{{ $doctor->user->phone }}</td>
                            <td class="px-6 py-4">{{ $doctor->user->address->rue }} , {{ $doctor->user->address->ville }}</td>
                            <td class="px-6 py-4">{{ $doctor->degree }}</td>
                            <td class="px-6 py-4">{{ $doctor->status }}</td>
                            <td class="px-6 py-4">{{ $doctor->speciality->name }}</td>
                            <td class="px-6 py-4">{{ $doctor->user->created_at }}</td>
                            <td class="flex flex-row items-center justify-around px-6 py-4 text-right">
                                <a href="{{ route('admin.doctor.edit.view', $doctor->id) }}"
                                    class="mr-2 font-medium text-blue-600 dark:text-blue-500"><i class="fa-regular fa-pen-to-square"></i></a>

                                <form id="deleteForm_{{ $doctor->id }}" action="{{ route('admin.doctor.delete', $doctor->id) }}"
                                    method="POST" class="mr-2 font-medium text-red-600 dark:text-red-500">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger h-0"
                                        onclick="confirmDelete('{{ $doctor->id }}')"><i class="fa-solid fa-trash"></i></button>
                                </form>

                                <a href="{{ route('admin.table.doctor.details', $doctor->id) }}"
                                    class="mr-2 font-medium text-blue-600 dark:text-blue-500"><i class="fa-regular fa-eye"></i></a>
                                <a href="{{ route('admin.doctor.notify', $doctor->id) }}"><i class="fa-regular fa-bell"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('modals.add_doctor')
    @include('includes.table')

    @push('scripts')
        <script>
            function confirmDelete(doctorId) {
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
                        document.getElementById('deleteForm_' + doctorId).submit();
                    }
                });
            }
        </script>
    @endpush
</x-admin-layout>
