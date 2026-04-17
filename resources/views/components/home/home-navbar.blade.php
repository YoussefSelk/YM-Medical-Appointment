<nav class="app-home-nav animate__animated animate__fadeInDown">
    <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-slate-800">
            <x-application-logo aria-hidden="true" class="h-10 w-10" />
            <span class="font-display text-lg font-semibold tracking-tight sm:text-xl">YM Medical Appointments</span>
        </a>

        <button id="home-nav-toggle" type="button"
            class="inline-flex items-center justify-center rounded-xl border border-slate-200 p-2 text-slate-600 md:hidden"
            aria-controls="home-nav-menu" aria-expanded="false">
            <span class="sr-only">Open menu</span>
            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>

        <div id="home-nav-menu" class="hidden w-full md:block md:w-auto">
            <ul class="mt-4 flex flex-col gap-2 md:mt-0 md:flex-row md:items-center md:gap-3">
                @if (Route::has('login'))
                    @auth
                        <li>
                            <a href="{{ route(auth()->user()->getDashboardRouteAttribute()) }}"
                                class="inline-flex rounded-xl px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:text-blue-700">Panel</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}"
                                class="inline-flex rounded-xl px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:text-blue-700">Log
                                in</a>
                        </li>
                        @if (Route::has('register'))
                            <li>
                                <a href="{{ route('register') }}"
                                    class="inline-flex rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">Register</a>
                            </li>
                        @endif
                    @endauth
                @endif
            </ul>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggleButton = document.getElementById('home-nav-toggle');
        var menu = document.getElementById('home-nav-menu');

        if (!toggleButton || !menu) {
            return;
        }

        toggleButton.addEventListener('click', function() {
            menu.classList.toggle('hidden');
            var expanded = toggleButton.getAttribute('aria-expanded') === 'true';
            toggleButton.setAttribute('aria-expanded', (!expanded).toString());
        });
    });
</script>
