<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-premium-primary']) }}>
    {{ $slot }}
</button>
