@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin_doctor.css') }}">
@endpush

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

    <div class="rounded-md bg-white p-6 dark:bg-dark-eval-1">
        <div class="content_All_doctors">
            <div class="doctor_count_container">
                <p class="doctor_count">All Specialities (</p>
                <p class="doctor_count_number">{{ count($specialities) }}</p>
                <p>)</p>
            </div>
            <div class="AddDoc_container">
                <p class="AddDoc">Add New Speciality</p>
                <button x-on:click="$dispatch('open-modal', 'add_speciality')" name="add_speciality">Add Speciality</button>
            </div>
        </div>
    </div>

    <div class="mt-7 rounded-md bg-white p-6 dark:bg-dark-eval-1">
        <h2 class="text-xl font-semibold leading-tight">{{ __('Specialities List') }}</h2>
        <div class="mt-5 overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500 dark:bg-dark-eval-1 dark:text-gray-400" id="DataTable">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-dark-eval-1 dark:text-gray-400">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">#</th>
                        <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Speciality Name</th>
                        <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white dark:bg-dark-eval-1">
                    @foreach ($specialities as $speciality)
                        <tr class="hover:bg-gray-100 dark:bg-dark-eval-1">
                            <td class="px-3 py-1">{{ $loop->iteration }}</td>
                            <td class="px-3 py-1">{{ $speciality->name }}</td>
                            <td class="flex items-center justify-center px-3 py-1">
                                <a href="{{ route('admin.specialities.edit.view', $speciality->id) }}" class="px-3 py-1 text-blue-600"><i
                                        class="fa-regular fa-pen-to-square"></i></a>
                                <form action="{{ route('admin.specialities.delete', $speciality->id) }}" method="POST"
                                    id="deleteForm{{ $speciality->id }}" class="h-1.5">
                                    @csrf
                                    @method('DELETE')
                                    <a href="#" onclick="confirmDelete('{{ $speciality->id }}')" class="h-0 px-3 py-1 text-red-600"><i
                                            class="fa-solid fa-trash"></i></a>
                                </form>
                                <a href="{{ route('admin.speciality.details', $speciality->id) }}" class="px-3 py-1 text-blue-600"><i
                                        class="fa-regular fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('includes.table')
    @include('modals.add_speciality')

    @push('scripts')
        <script>
            function confirmDelete(specialityId) {
                Swal.fire({
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
    @endpush
</x-admin-layout>
