<main class="flex flex-1 flex-col items-center px-4 py-6 sm:justify-center sm:py-10">
    <div>
        <a href="/" class="inline-flex rounded-2xl bg-white/85 p-2 shadow-sm">
            <x-application-logo class="h-20 w-20" />
        </a>
    </div>

    <div class="app-auth-card my-6 w-full overflow-hidden px-6 py-6 sm:max-w-md sm:px-8">
        {{ $slot }}
    </div>
</main>
