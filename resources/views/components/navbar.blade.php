<nav aria-label="secondary" x-data="{ open: false }"
    class="sticky top-0 z-10 flex items-center justify-between px-4 py-4 sm:px-6 transition-transform duration-500 bg-white dark:bg-dark-eval-1"
    :class="{
        '-translate-y-full': scrollingDown,
        'translate-y-0': scrollingUp,
    }">

    <div class="flex items-center gap-3">
        <x-button type="button" class="md:hidden" icon-only variant="secondary" sr-text="Toggle dark mode"
            x-on:click="toggleTheme">
            <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true" class="w-6 h-6" />

            <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true" class="w-6 h-6" />
        </x-button>
    </div>

    <div class="flex items-center gap-3">

        <!-- Notification Dropdown -->
        <div class="relative" id="notificationDropdown">
            <button
                class="flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white rounded-md  dark:text-gray-400 dark:bg-dark-eval-1 dark:hover:text-gray-200"
                type="button" id="notificationDropdownMenuButton" aria-expanded="false">

                <span class="ml-2"><svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 14 20">
                        <path
                            d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z" />
                    </svg></span>
            </button>
            <ul class="absolute right-0 mt-2 w-56 origin-top-right bg-white dark:bg-dark-eval-1 divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 hidden"
                role="menu" aria-orientation="vertical" aria-labelledby="notificationDropdownMenuButton"
                tabindex="-1">
                <!-- Notifications will be appended here -->
            </ul>
        </div>



        <x-button type="button" class="hidden md:inline-flex" icon-only variant="secondary" sr-text="Toggle dark mode"
            x-on:click="toggleTheme">
            <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true" class="w-6 h-6" />

            <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true" class="w-6 h-6" />
        </x-button>


        @php
            $user = Auth::user()->img;
        @endphp
        @if ($user)
            <img src="{{ asset('storage/profile_pictures/' . $user) }}" alt="Profile Picture"
                class="w-12 h-12 rounded-full">
        @else
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="test"
                class="w-12 rounded-full">
        @endif


        <x-dropdown align="right" width="48">

            <x-slot name="trigger">
                <button
                    class="flex items-center p-2 text-sm font-medium text-gray-500 rounded-md transition duration-150 ease-in-out hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <div>{{ Auth::user()->name }}</div>

                    <div class="ml-1">
                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <!-- Profile -->
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>

<!-- Mobile bottom bar -->
<div class="fixed z-50 inset-x-0 bottom-0 flex items-center justify-between px-4 py-4 sm:px-6 transition-transform duration-500 bg-white md:hidden dark:bg-dark-eval-1"
    :class="{
        'translate-y-full': scrollingDown,
        'translate-y-0': scrollingUp,
    }">

    <a href="{{ route(authUser()->getDashboardRouteAttribute()) }}">
        <x-application-logo aria-hidden="true" class="w-10 h-10" />

        <span class="sr-only">Dashboard</span>
    </a>

    <x-button type="button" icon-only variant="secondary" sr-text="Open main menu"
        x-on:click="isSidebarOpen = !isSidebarOpen">
        <x-heroicon-o-menu x-show="!isSidebarOpen" aria-hidden="true" class="w-6 h-6" />

        <x-heroicon-o-x x-show="isSidebarOpen" aria-hidden="true" class="w-6 h-6" />
    </x-button>
</div>

<script src="{{ asset('js/notification/notification.js') }}"></script>
