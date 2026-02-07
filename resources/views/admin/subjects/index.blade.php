@extends('layouts.app')

@section('page_title', 'Subjects')

@section('content')
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Subjects</h1>
        <p class="text-sm text-slate-500 mt-1">Manage curriculum subjects</p>
    </div>

    <a href="{{ route('admin.subjects.create') }}"
       class="inline-flex items-center rounded-xl bg-primary px-4 py-2.5 text-white hover:opacity-90 shadow-sm">
        + Add Subject
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    {{-- Toolbar --}}
    <div class="p-4 sm:p-5 border-b border-slate-100">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            <div class="md:col-span-6">
                <label class="text-xs font-medium text-slate-600">Search</label>
                <input name="q" value="{{ request('q') }}"
                       placeholder="Name or code"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-primary/20">
            </div>

            <div class="md:col-span-3">
                <label class="text-xs font-medium text-slate-600">Status</label>
                <select name="is_active"
                        class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm">
                    <option value="">All</option>
                    <option value="1" @selected(request('is_active') === '1')>Active</option>
                    <option value="0" @selected(request('is_active') === '0')>Inactive</option>
                </select>
            </div>

            <div class="md:col-span-3 flex justify-end gap-2">
                <button class="rounded-xl bg-primary px-4 py-2.5 text-sm text-white">Filter</button>
                <a href="{{ route('admin.subjects.index') }}"
                   class="rounded-xl border px-4 py-2.5 text-sm">Reset</a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50 text-slate-600 text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Subject</th>
                    <th class="px-6 py-3 text-left">Code</th>
                    <th class="px-6 py-3 text-left">Type</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($subjects as $subject)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium">{{ $subject->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $subject->code }}</td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $subject->is_core ? 'Core' : 'Optional' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 text-xs rounded-full border
                                {{ $subject->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-slate-50 text-slate-600 border-slate-200' }}">
                                {{ $subject->is_active ? 'Active' : 'Inactive' }}
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
                                            <a href="{{ route('admin.subjects.edit', $subject) }}"
                                               class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                                                Edit
                                            </a>

                                            <div class="h-px bg-slate-100"></div>

                                            <form method="POST" action="{{ route('admin.subjects.activate', $subject) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="_redirect" value="{{ url()->full() }}">
                                                <button type="submit"
                                                        class="w-full text-left px-4 py-2.5 text-sm hover:bg-slate-50
                                                        {{ $subject->is_active ? 'text-slate-400 cursor-not-allowed' : 'text-slate-700' }}"
                                                        {{ $subject->is_active ? 'disabled' : '' }}>
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
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            No Subjects found.
                        </td>
                    </tr>
                @endforelse
                
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t">
        {{ $subjects->links() }}
    </div>
</div>
@endsection
