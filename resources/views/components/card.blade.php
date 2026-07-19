@props(['title' => null, 'subtitle' => null, 'padding' => 'p-6'])
<div {{ $attributes->merge(['class' => "card-premium $padding"]) }}>
    @if($title || isset($actions))
        <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
            <div>
                @if($title)
                    <h3 class="text-base font-bold text-slate-800">{{ $title }}</h3>
                @endif
                @if($subtitle)
                    <p class="mt-0.5 text-xs text-slate-400">{{ $subtitle }}</p>
                @endif
            </div>
            @isset($actions)
                <div class="flex items-center gap-2">{{ $actions }}</div>
            @endisset
        </div>
    @endif

    {{ $slot }}
</div>