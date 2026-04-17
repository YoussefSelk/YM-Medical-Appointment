@if (session()->has('error'))
    <div class="flash-toast flash-toast--error" x-data="{ show: true }" x-init="setTimeout(() => show = false, 3500)" x-show="show">
        <svg xmlns="http://www.w3.org/2000/svg" class="flash-toast__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-sm font-semibold">{{ session('error') }}</p>
    </div>
@endif
