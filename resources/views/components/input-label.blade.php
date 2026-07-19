@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-bold uppercase tracking-wide text-slate-500']) }}>
    {{ $value ?? $slot }}
</label>