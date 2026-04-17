<div class="flex flex-shrink-0 items-center justify-between px-3">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="inline-flex items-center gap-3 rounded-xl px-2 py-1.5 transition hover:bg-slate-100/80">
        <x-application-logo aria-hidden="true" class="w-10 h-auto" />
        <div x-show="isSidebarOpen || isSidebarHovered" class="min-w-0">
            <p class="truncate text-sm font-semibold text-slate-800">YM Medical</p>
            <p class="truncate text-xs text-slate-500">Admin Workspace</p>
        </div>
    </a>

    <!-- Toggle button -->

</div>
