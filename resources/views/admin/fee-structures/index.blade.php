@extends('layouts.app')

@section('page_title', 'Fee Structures')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Fee Structures</h1>
        <p class="text-sm text-slate-500 mt-1">
            Manage fee components per class, term and academic year.
        </p>
    </div>

    <a href="{{ route('admin.fee-structures.create') }}"
       class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 text-white hover:opacity-90 shadow-sm">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                  d="M12 4v16m8-8H4"/>
        </svg>
        Add Fee
    </a>
</div>

{{-- Container --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    {{-- Toolbar --}}
    <div class="p-4 sm:p-5 border-b border-slate-100">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">

            <div class="md:col-span-4">
                <label class="text-xs font-medium text-slate-600">Search</label>
                <input name="q" value="{{ request('q') }}"
                       placeholder="Fee name"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-primary/20" />
            </div>

            <div class="md:col-span-3">
                <label class="text-xs font-medium text-slate-600">Status</label>
                <select name="is_active"
                        class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm
                               focus:outline-none focus:ring-2 focus:ring-primary/20">
                    <option value="">All</option>
                    <option value="1" @selected(request('is_active') === '1')>Active</option>
                    <option value="0" @selected(request('is_active') === '0')>Inactive</option>
                </select>
            </div>

            <div class="md:col-span-5 flex justify-end gap-2 pt-1">
                <button class="rounded-xl bg-primary px-4 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
                    Filter
                </button>

                <a href="{{ route('admin.fee-structures.index') }}"
                   class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50 text-slate-600 text-xs">
                <tr>
                    <th class="px-6 py-3 text-left font-medium">Fee</th>
                    <th class="px-6 py-3 text-left font-medium">Year</th>
                    <th class="px-6 py-3 text-left font-medium">Term</th>
                    <th class="px-6 py-3 text-left font-medium">Class</th>
                    <th class="px-6 py-3 text-left font-medium">Amount</th>
                    <th class="px-6 py-3 text-left font-medium">Status</th>
                    <th class="px-6 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($fees as $fee)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">
                                {{ $fee->name }}
                            </div>
                            <div class="text-xs text-slate-500">
                                ID: {{ $fee->id }}
                            </div>
                        </td>

                        <td class="px-6 py-4 text-slate-700">
                            {{ $fee->academicYear?->name }}
                        </td>

                        <td class="px-6 py-4 text-slate-700">
                            {{ $fee->term?->name }}
                        </td>

                        <td class="px-6 py-4 text-slate-700">
                            {{ $fee->schoolClass?->name }}
                        </td>

                        <td class="px-6 py-4 text-slate-900 font-medium">
                            {{ number_format($fee->amount, 2) }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs border rounded-full
                                {{ $fee->is_active
                                    ? 'bg-green-50 text-green-700 border-green-200'
                                    : 'bg-slate-50 text-slate-700 border-slate-200' }}">
                                {{ $fee->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div x-data="{ open:false, x:0, y:0,
                                place(){ const r=this.$refs.btn.getBoundingClientRect();
                                    this.x=r.right; this.y=r.bottom; } }"
                                 x-init="window.addEventListener('scroll', ()=> open && place(), true);
                                         window.addEventListener('resize', ()=> open && place());">

                                <button type="button"
                                        x-ref="btn"
                                        @click="open=!open; if(open) $nextTick(()=>place())"
                                        class="inline-flex items-center justify-center rounded-lg px-2 py-1 text-slate-500 hover:bg-slate-100">
                                    ⋯
                                </button>

                                <template x-teleport="body">
                                    <div x-show="open"
                                         x-transition.opacity
                                         @click.outside="open=false"
                                         x-cloak
                                         class="fixed z-[9999]"
                                         :style="`left:${x}px; top:${y}px; transform: translateX(-100%);`">

                                        <div class="w-48 rounded-xl border border-slate-200 bg-white shadow-lg overflow-hidden">

                                            <a href="{{ route('admin.fee-structures.edit', $fee) }}"
                                               class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                                                Edit
                                            </a>

                                            <div class="h-px bg-slate-100"></div>

                                            <form method="POST"
                                                  action="{{ route('admin.fee-structures.toggle', $fee) }}">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="w-full text-left px-4 py-2.5 text-sm hover:bg-slate-50 text-slate-700">
                                                    {{ $fee->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                </template>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7"
                            class="px-6 py-12 text-center text-slate-500">
                            No fee structures found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-4 sm:p-5 border-t border-slate-100 bg-white">
        {{ $fees->links() }}
    </div>
</div>

@endsection
