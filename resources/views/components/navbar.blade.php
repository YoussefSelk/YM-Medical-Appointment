<nav aria-label="secondary" x-data="{ open: false }"
    class="sticky top-0 z-30 border-b border-slate-200/70 bg-white/88 backdrop-blur dark:border-slate-700 dark:bg-dark-eval-1/90"
    :class="{
        '-translate-y-full': scrollingDown,
        'translate-y-0': scrollingUp,
    }"
    style="transition: transform 0.35s ease;">

    <div class="mx-auto flex w-full max-w-[1600px] items-center justify-between px-4 py-4 sm:px-6">
        <div class="flex items-center gap-3">
            <x-button type="button" class="md:hidden" icon-only variant="secondary" sr-text="Toggle dark mode"
                x-on:click="toggleTheme">
                <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true" class="h-5 w-5" />
                <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true" class="h-5 w-5" />
            </x-button>
        </div>

        <div class="flex items-center gap-2 sm:gap-3">
            <div class="relative" id="notificationDropdown">
                <button
                    class="flex items-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 transition hover:border-blue-300 hover:text-blue-600 dark:border-slate-700 dark:bg-dark-eval-1 dark:text-gray-300"
                    type="button" id="notificationDropdownMenuButton" aria-expanded="false">
                    <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 14 20">
                        <path
                            d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z" />
                    </svg>
                </button>
                <ul class="absolute right-0 mt-2 hidden w-72 origin-top-right divide-y divide-gray-100 rounded-xl border border-slate-200 bg-white shadow-xl ring-1 ring-black/5 dark:border-slate-700 dark:bg-dark-eval-1"
                    role="menu" aria-orientation="vertical" aria-labelledby="notificationDropdownMenuButton" tabindex="-1">
                </ul>
            </div>

            <x-button type="button" class="hidden md:inline-flex" icon-only variant="secondary" sr-text="Toggle dark mode"
                x-on:click="toggleTheme">
                <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true" class="h-5 w-5" />
                <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true" class="h-5 w-5" />
            </x-button>

            @php
                $user = Auth::user()->img;
            @endphp
            @if ($user)
                <img src="{{ asset('storage/profile_pictures/' . $user) }}" alt="Profile Picture"
                    class="h-10 w-10 rounded-full border-2 border-white object-cover shadow-sm">
            @else
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="Profile Picture"
                    class="h-10 w-10 rounded-full border-2 border-white object-cover shadow-sm">
            @endif

            <x-dropdown align="right" width="56">
                <x-slot name="trigger">
                    <button
                        class="flex max-w-[140px] items-center rounded-xl border border-transparent p-2 text-sm font-medium text-slate-600 transition hover:border-slate-200 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-300 dark:hover:bg-dark-eval-2 sm:max-w-none">
                        <div class="truncate">{{ Auth::user()->name }}</div>

                        <div class="ml-1">
                            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>

<div class="fixed inset-x-0 bottom-0 z-40 flex items-center justify-between border-t border-slate-200 bg-white px-4 py-3 shadow-lg md:hidden dark:border-slate-700 dark:bg-dark-eval-1"
    :class="{
        'translate-y-full': scrollingDown,
        'translate-y-0': scrollingUp,
    }"
    style="padding-bottom: calc(0.75rem + env(safe-area-inset-bottom)); transition: transform 0.35s ease;">

    <a href="{{ route(authUser()->getDashboardRouteAttribute()) }}" class="inline-flex items-center">
        <x-application-logo aria-hidden="true" class="h-10 w-10" />
        <span class="sr-only">Dashboard</span>
    </a>

    <x-button type="button" icon-only variant="secondary" sr-text="Open main menu"
        x-on:click="isSidebarOpen = !isSidebarOpen">
        <x-heroicon-o-menu x-show="!isSidebarOpen" aria-hidden="true" class="h-6 w-6" />
        <x-heroicon-o-x x-show="isSidebarOpen" aria-hidden="true" class="h-6 w-6" />
    </x-button>
</div>

<script src="{{ asset('js/notification/notification.js') }}"></script>
