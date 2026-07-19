@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-xl bg-emerald-50 px-4 py-2.5 text-sm font-medium text-emerald-600']) }}>
        {{ $status }}
    </div>
@endif