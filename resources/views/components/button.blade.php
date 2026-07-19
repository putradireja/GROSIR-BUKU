@props(['variant' => 'primary', 'as' => 'button', 'href' => null, 'type' => 'submit'])
@php
    $variants = [
        'primary'   => 'btn-premium-primary',
        'secondary' => 'btn-premium-secondary',
        'danger'    => 'btn-premium-danger',
        'success'   => 'btn-premium-success',
        'ghost'     => 'btn-premium-ghost',
    ];
    $cls = $variants[$variant] ?? $variants['primary'];
@endphp
@if($as === 'a')
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $cls]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $cls]) }}>{{ $slot }}</button>
@endif