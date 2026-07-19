<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-premium-danger']) }}>
    {{ $slot }}
</button>
