<footer class="px-4 pb-5 pt-3 sm:px-6">
    <div class="rounded-xl border border-slate-200/70 bg-white/80 px-4 py-3 text-xs text-slate-500 shadow-sm dark:border-slate-700 dark:bg-dark-eval-1 dark:text-slate-300">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <p>{{ config('app.name', 'YM Medical') }}</p>
            @if (request()->is('admin*'))
                <p>Operational dashboard for doctors, patients, and appointments.</p>
            @elseif (request()->is('doctor*'))
                <p>Doctor workspace for schedule, appointments, and patient follow-up.</p>
            @elseif (request()->is('patient*'))
                <p>Patient workspace for booking and managing medical appointments.</p>
            @else
                <p>Secure medical appointment management platform.</p>
            @endif
        </div>
    </div>
</footer>
