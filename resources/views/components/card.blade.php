<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm border border-slate-100']) }}>
    <div class="p-6">
        {{ $slot }}
    </div>
</div>
