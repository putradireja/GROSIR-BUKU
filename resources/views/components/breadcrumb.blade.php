@props(['title' => ''])
<nav class="mb-0.5 hidden text-xs text-slate-400 sm:flex items-center gap-1.5">
    <a href="{{ route('dashboard') }}" class="transition hover:text-purple-600">Dashboard</a>
    @if($title && $title !== 'Dashboard')
        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-purple-600">{{ $title }}</span>
    @endif
</nav>