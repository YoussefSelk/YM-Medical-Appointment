<x-sidebar.overlay />

<aside class="fixed inset-y-0 z-20 flex flex-col space-y-6 border-r border-slate-200/70 bg-white/95 py-5 shadow-[0_30px_45px_-40px_rgba(15,23,42,0.7)] backdrop-blur dark:border-slate-700 dark:bg-dark-eval-1"
    :class="{
        'translate-x-0 w-64': isSidebarOpen || isSidebarHovered,
        '-translate-x-full w-64 md:w-16 md:translate-x-0': !isSidebarOpen && !isSidebarHovered,
    }"
    style="transition-property: width, transform; transition-duration: 150ms;" x-on:mouseenter="handleSidebarHover(true)"
    x-on:mouseleave="handleSidebarHover(false)">
    <x-sidebar.header />

    <x-sidebar.content />

    <x-sidebar.footer />
</aside>
