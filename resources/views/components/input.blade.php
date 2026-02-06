@props(['label' => null])

<label class="block">
    @if($label)
        <span class="text-sm font-medium text-slate-700">{{ $label }}</span>
    @endif
    <input {{ $attributes->merge(['class' => 'mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/30']) }}>
</label>
