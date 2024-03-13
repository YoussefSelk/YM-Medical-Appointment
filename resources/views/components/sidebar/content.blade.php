<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">

    <x-sidebar.link title="Dashboard" href="{{ route(auth()->user()->getDashboardRouteAttribute()) }}" :isActive="request()->routeIs('dashboard')">
        <x-sidebar.link title="Doctors" href="#" />
    </x-sidebar.link>

    <x-sidebar.dropdown title="Buttons" :active="Str::startsWith(request()->route()->uri(), 'buttons')">
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

        <x-sidebar.sublink title="Text button" href="{{ route('buttons.text') }}" :active="request()->routeIs('buttons.text')" />
        <x-sidebar.sublink title="Icon button" href="{{ route('buttons.icon') }}" :active="request()->routeIs('buttons.icon')" />
        <x-sidebar.sublink title="Text with icon" href="{{ route('buttons.text-icon') }}" :active="request()->routeIs('buttons.text-icon')" />
    </x-sidebar.dropdown>

    <div x-transition x-show="isSidebarOpen || isSidebarHovered" class="text-sm text-gray-500">
        Links
    </div>
    @if(auth()->user()->user_type === 'admin')
    <x-sidebar.link title="Doctors" href="{{route('admin.doctor')}}" />
    <x-sidebar.link title="Patients" href="#" />
    <x-sidebar.link title="Apointments" href="#" />
    <x-sidebar.link title="Schedules" href="#" />
    @endif
</x-perfect-scrollbar>