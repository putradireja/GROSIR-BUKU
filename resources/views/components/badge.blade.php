@props(['color' => 'purple'])
@php
    $colors = [
        'purple' => 'bg-purple-100 text-purple-700',
        'pink'   => 'bg-pink-100 text-pink-700',
        'green'  => 'bg-emerald-100 text-emerald-700',
        'red'    => 'bg-red-100 text-red-700',
        'amber'  => 'bg-amber-100 text-amber-700',
        'slate'  => 'bg-slate-100 text-slate-600',
        'fuchsia'=> 'bg-fuchsia-100 text-fuchsia-700',
    ];
    $cls = $colors[$color] ?? $colors['purple'];
@endphp
<span {{ $attributes->merge(['class' => "badge-premium $cls"]) }}>
    {{ $slot }}
</span>