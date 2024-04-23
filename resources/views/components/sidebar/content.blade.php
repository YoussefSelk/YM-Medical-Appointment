<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">

    @if (auth()->user()->user_type === 'admin')
        <x-sidebar.link title="Dashboard" href="{{ route(auth()->user()->getDashboardRouteAttribute()) }}"
            :isActive="request()->routeIs(auth()->user()->getDashboardRouteAttribute())">
            <x-slot name="icon">
                <i class="fa-solid fa-house"></i>
            </x-slot>
        </x-sidebar.link>
    @elseif (auth()->user()->user_type === 'patient')
        <x-sidebar.link title="Home" href="{{ route(auth()->user()->getDashboardRouteAttribute()) }}" :isActive="request()->routeIs(auth()->user()->getDashboardRouteAttribute())">
            <x-slot name="icon">
                <i class="fa-solid fa-house"></i>
            </x-slot>
        </x-sidebar.link>
    @elseif (auth()->user()->user_type === 'doctor')
        <x-sidebar.link title="Dashboard" href="{{ route(auth()->user()->getDashboardRouteAttribute()) }}"
            :isActive="request()->routeIs(auth()->user()->getDashboardRouteAttribute())">
            <x-slot name="icon">
                <i class="fa-solid fa-house"></i>
            </x-slot>
        </x-sidebar.link>
    @endif


    {{-- <x-sidebar.dropdown title="Buttons" :active="Str::startsWith(request()->route()->uri(), 'buttons')">
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

        <x-sidebar.sublink title="Text button" href="{{ route('buttons.text') }}" :active="request()->routeIs('buttons.text')" />
        <x-sidebar.sublink title="Icon button" href="{{ route('buttons.icon') }}" :active="request()->routeIs('buttons.icon')" />
        <x-sidebar.sublink title="Text with icon" href="{{ route('buttons.text-icon') }}" :active="request()->routeIs('buttons.text-icon')" />
    </x-sidebar.dropdown> --}}

    <div x-transition x-show="isSidebarOpen || isSidebarHovered" class="text-sm text-gray-500">
        Links
    </div>
    @if (auth()->user()->user_type === 'admin')
        <x-sidebar.link title="Doctors" href="{{ route('admin.doctor') }}" :isActive="request()->routeIs('admin.doctor')">
            <x-slot name="icon">
                <i class="fa-solid fa-user-doctor"></i>
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link title="Patients" href="{{ route('admin.patient') }}" :isActive="request()->routeIs('admin.patient')">
            <x-slot name="icon">
                <i class="fa-solid fa-bed-pulse"></i>
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link title="Apointments" href="{{ route('admin.appointments') }}" :isActive="request()->routeIs('admin.appointments')">
            <x-slot name="icon">
                <i class="fa-regular fa-calendar-check"></i>
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link title="Schedules" href="{{ route('admin.schedules') }}" :isActive="request()->routeIs('admin.schedules')">
            <x-slot name="icon">
                <i class="fa-solid fa-calendar-days"></i>
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link title="Specialities" href="{{ route('admin.specialities') }}" :isActive="request()->routeIs('admin.specialities')">
            <x-slot name="icon">
                <i class="fa-solid fa-briefcase"></i>
            </x-slot>
        </x-sidebar.link>
    @endif
    @if (auth()->user()->user_type === 'patient')
        <x-sidebar.link title="Doctor List" href="{{ route('patiens.doctors') }}" :isActive="request()->routeIs('patiens.doctors')">
            <x-slot name="icon">
                <i class="fa-solid fa-user-doctor"></i>
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link title="My Appointments" href="{{ route('patiens.my.appointments', authUser()->patient->id) }}"
            :isActive="request()->routeIs('patiens.my.appointments')">
            <x-slot name="icon">
                <i class="fa-regular fa-calendar-check"></i>
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link title="Health Tips " href="{{ route('patiens.health.tips.view', authUser()->patient->id) }}"
            :isActive="request()->routeIs('patiens.health.tips.view')">
            <x-slot name="icon">
                <i class="fa-solid fa-staff-snake"></i>
            </x-slot>
        </x-sidebar.link>
    @endif

    @if (auth()->user()->user_type === 'doctor')



        <x-sidebar.link title="Appointments" href="{{ route('doctor.appointments') }}" :isActive="request()->routeIs('doctor.appointments')">
            <x-slot name="icon">
                <i class="fa-regular fa-calendar-check"></i>
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link title="Schedules" href="{{ route('doctor.schedule') }}" :isActive="request()->routeIs('doctor.schedule')">
            <x-slot name="icon">
                <i class="fa-solid fa-calendar-days"></i>
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link title="My patients" href="{{ route('doctor.mypatients') }}" :isActive="request()->routeIs('doctor.mypatients')">
            <x-slot name="icon">
                <i class="fa-solid fa-bed-pulse"></i>
            </x-slot>
        </x-sidebar.link>
    @endif
</x-perfect-scrollbar>
