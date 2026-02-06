<button {{ $attributes->merge(['class' => 'inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2 text-white hover:opacity-90']) }}>
    {{ $slot }}
</button>
