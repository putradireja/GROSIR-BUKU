@props(['placeholder' => 'Cari sesuatu...'])
<div {{ $attributes->merge(['class' => 'relative']) }}>
    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
    </svg>
    <input
        type="text"
        placeholder="{{ $placeholder }}"
        class="w-64 rounded-xl border border-purple-100 bg-white/70 py-2 pl-9 pr-3 text-sm text-slate-600 shadow-sm transition focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100"
    >
</div>