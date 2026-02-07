@extends('layouts.app')

@section('page_title', 'Academic Years')

@section('content')
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Academic Years</h1>
        <p class="text-sm text-slate-500 mt-1">Manage academic year periods and activation</p>
    </div>

    <a href="{{ route('admin.academic-years.create') }}"
       class="inline-flex items-center rounded-xl bg-primary px-4 py-2.5 text-white hover:opacity-90 shadow-sm">
        + Add Year
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-4 sm:p-5 border-b border-slate-100">
        <form method="GET" action="{{ route('admin.academic-years.index') }}"
              class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">

            <div class="md:col-span-6">
                <label class="text-xs font-medium text-slate-600">Search</label>
                <input name="q" value="{{ request('q') }}" placeholder="Year name"
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

            <div class="md:col-span-3 flex gap-2 justify-end pt-1">
                <button class="rounded-xl bg-primary px-4 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
                    Filter
                </button>
                <a href="{{ route('admin.academic-years.index') }}"
                   class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50 text-slate-600 text-xs">
                <tr>
                    <th class="px-6 py-3 text-left font-medium">Year</th>
                    <th class="px-6 py-3 text-left font-medium">Start</th>
                    <th class="px-6 py-3 text-left font-medium">End</th>
                    <th class="px-6 py-3 text-left font-medium">Status</th>
                    <th class="px-6 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($years as $year)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $year->name }}</div>
                            <div class="text-xs text-slate-500">ID: {{ $year->id }}</div>
                        </td>

                        <td class="px-6 py-4 text-slate-700">{{ \Carbon\Carbon::parse($year->start_date)->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-slate-700">{{ \Carbon\Carbon::parse($year->end_date)->format('d M Y') }}</td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs border rounded-full
                                {{ $year->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-slate-50 text-slate-700 border-slate-200' }}">
                                {{ $year->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="inline-block"
                                 x-data="{ open:false, x:0, y:0, place(){ const r=this.$refs.btn.getBoundingClientRect(); this.x=r.right; this.y=r.bottom; } }"
                                 x-init="window.addEventListener('scroll', ()=> open && place(), true); window.addEventListener('resize', ()=> open && place());">
                                <button type="button" x-ref="btn"
                                        @click="open=!open; if(open) $nextTick(()=>place())"
                                        class="inline-flex items-center justify-center rounded-lg px-2 py-1 text-slate-500 hover:bg-slate-100"
                                        aria-label="Actions">⋯</button>

                                <template x-teleport="body">
                                    <div x-show="open" x-transition.opacity @click.outside="open=false" x-cloak
                                         class="fixed z-[9999]"
                                         :style="`left:${x}px; top:${y}px; transform: translateX(-100%);`">
                                        <div class="w-48 rounded-xl border border-slate-200 bg-white shadow-lg overflow-hidden">
                                            <a href="{{ route('admin.academic-years.edit', $year) }}"
                                               class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                                                Edit
                                            </a>

                                            <div class="h-px bg-slate-100"></div>

                                            <form method="POST" action="{{ route('admin.academic-years.activate', $year) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="_redirect" value="{{ url()->full() }}">
                                                <button type="submit"
                                                        class="w-full text-left px-4 py-2.5 text-sm hover:bg-slate-50
                                                        {{ $year->is_active ? 'text-slate-400 cursor-not-allowed' : 'text-slate-700' }}"
                                                        {{ $year->is_active ? 'disabled' : '' }}>
                                                    Set Active
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
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">No academic years found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 sm:p-5 border-t border-slate-100 bg-white">
        {{ $years->links() }}
    </div>
</div>
@endsection
